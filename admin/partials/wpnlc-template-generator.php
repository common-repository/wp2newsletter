<div class="wrap">
  <h1>
    <?php _e( "Generate Newsletter", "wpnewsletter-campaigns" ); ?>
  </h1>
  <div id="setting-error-settings_updated" class="settings-error"> </div>
  <form method="post" name="wpnlc_generate_newsletter_form" id="wpnlc_generate_newsletter_form">
    <div class="wpnlc_tg_left">
      <div id="wpnlc_template_create_n_update_tabs">
        <ul>
          <li class="tabs_control active"> <a tab="">
            <?php _e('Create New Template','wpnewsletter-campaigns');?>
            </a></li>
          <li class="tabs_control"> <a tab="template_update_select">
            <?php _e('Update Template','wpnewsletter-campaigns');?>
            </a></li>
        </ul>
      </div>
      <table class="form-table">
        <tr valigh="middle" class="template_update_select" style="display:none">
          <td width="200"><label for="wpnlc_setting_template_name">
              <?php _e( "Chose Template To Update", "wpnewsletter-campaigns" ); ?>
            </label></td>
          <td><?php
			$apikey = get_option('wpnlc_mailchimp_api_key',false);
			$MC = new MailChimp($apikey);
			$templates = $MC->get('templates',array('type'=>'user'));
			$availiable_templates = array();
			if($templates['templates']){
				 foreach($templates['templates'] as $key=>$template){
					$availiable_templates[$template['id']] = $template['name'];
					}
			}
			?>
            <select name="wpnlc_setting_template_name_update" id="wpnlc_setting_template_name_update">
              <option value="">
              <?php _e('Choose Template','wpnewsletter-campaign')?>
              </option>
              <?php if($availiable_templates){
					foreach($availiable_templates as $key=>$value){?>
              <option value="<?php echo $key?>">
              <?php _e($value,'wpnewsletter-campaign')?>
              </option>
              <?php }
					} ?>
            </select></td>
        </tr>
        <tr valigh="middle" class="wpnlc_setting_template_name">
          <td width="200"><label for="wpnlc_setting_template_name">
              <?php _e( "Template Name", "wpnewsletter-campaigns" ); ?>
            </label></td>
          <td><?php
			$apikey = get_option('wpnlc_mailchimp_api_key',false);
			$MC = new MailChimp($apikey);
			$templates = $MC->get('templates',array('type'=>'user'));
			$availiable_templates = array();
			if($templates['templates']){
				 foreach($templates['templates'] as $key=>$template){
					$availiable_templates[$template['id']] = $template['name'];
					}
			}
			?>
            <input type="text" name="wpnlc_setting_template_name" id="wpnlc_setting_template_name" size="40" placeholder="Template Name"/></td>
        </tr>
        <tr valigh="middle" class="wpnlc_setting_template_type">
          <td width="200"><label for="wpnlc_setting_template_type">
              <?php _e( "Choose Template Type", "wpnewsletter-campaigns" ); ?>
            </label></td>
          <td><select name="wpnlc_setting_template_type" id="wpnlc_setting_template_type">
              <option value="">
              <?php _e('Choose Template Type');?>
              </option>
              <option value="normal">
              <?php _e('Normal Template');?>
              </option>
              <option value="rss">
              <?php _e('RSS Driven Template');?>
              </option>
            </select></td>
        </tr>
        <tr valigh="middle" class="wpnlc_setting_template">
          <td colspan="2"><label for="wpnlc_setting_template">
              <?php _e( "Choose Newsletter Template", "wpnewsletter-campaigns" ); ?>
            </label><?php
			$args =array(
				'post_type'=>'wpnlc_template',
				'posts_per_page'=>'-1',
				);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				?>
				 <ul class="template_selection_list">
				<?php while ( $the_query->have_posts() ) {
					$the_query->the_post();?>
					<li class="select_template_thumb" tid="<?php echo get_the_ID()?>">
						<div class="template_thumb_img"> <?php echo get_the_post_thumbnail(get_the_ID(),array(100,150)) ?></div>
                       	<br /><span><?php the_title()?></span>
                    </li>
				<?php }?>
			</ul>	
			<?php }
			?>
            
           
            
            
            <input id="selected_template" type="hidden" template_id="" /></td>
        </tr>
        <tr> </tr>
        <tr valigh="middle">
          <td><label for="wpnlc_setting_feed">
              <?php _e( "Data Source", "wpnewsletter-campaigns" ); ?>
            </label></td>
          <td><select name="wpnlc_setting_feed" id="wpnlc_setting_feed" required>
              <?php $args = array('post_type'=>'wpnlc',
                                        'posts_per_page'=>-1,
                                        ); 
                        $feeds = get_posts($args);
                        if($feeds){?>
              <option value="">
              <?php _e( "Select Data Source", "wpnewsletter-campaigns" ); ?>
              </option>
              <?php
                            foreach($feeds as $feed){?>
              <option value="<?php echo $feed->ID?>">
              <?php _e($feed->post_title,'wpnewsletter-campaign') ?>
              </option>
              <?php }
                            }else{?>
              <option value="">
              <?php _e('--Data Source Not Found--','wpnewsletter-campaign');?>
              </option>
              <?php } ?>
            </select></td>
        </tr>
        <tr valigh="middle">
          <td>&nbsp;</td>
          <td class="template_create"><span class="template_create">
            <input class="button button-primary" name="wpnlc_generate_newsletter_btn" id="wpnlc_generate_newsletter_btn" type="submit" value="<?php _e('Create New Template','wpnewsletter-campaigns')?>"/>
            </span> <span class="template_update">
            <input class="button button-primary" name="wpnlc_update_newsletter_btn" id="wpnlc_update_newsletter_btn" type="submit" value="<?php _e('Update Template','wpnewsletter-campaigns')?>" template_id=""/>
            </span> <span class="template_preview">
            <input class="button button-primary" name="wpnlc_preview_newsletter_btn" id="wpnlc_preview_newsletter_btn" type="submit" value="<?php _e('Generate Preview','wpnewsletter-campaigns')?>" template_id=""/>
            </span></td>
        </tr>
      </table>
    </div>
    <div id="loading_progress" style="display:none"> <img class="loading_image" src="<?php echo plugins_url('wp2newsletter/public/images/loading.gif');?>"> </div>
    <div class="wpnlc_tg_right">
      <div id="wpnlc_template_html_preview_tabs">
        <ul>
          <li class="tabs_control active"> <a tab="template_preview">
            <?php _e('Template Preview','wpnewsletter-campaigns');?>
            </a></li>
          <li class="tabs_control"> <a tab="template_html_normal">
            <?php _e('Html Code Normal','wpnewsletter-campaigns');?>
            </a></li>
          <li class="tabs_control"> <a tab="template_html_rss">
            <?php _e('Html Code RSS','wpnewsletter-campaigns');?>
            </a></li>
        </ul>
        <div class="tab_content_wrap">
          <div id="template_html_normal" class="wpnlc_tab" style="display:none">
            <textarea name="wpnlc_code_editor_normal" id="wpnlc_code_editor_normal"></textarea>
          </div>
          <div id="template_html_rss" class="wpnlc_tab" style="display:none">
            <textarea name="wpnlc_code_editor_rss" id="wpnlc_code_editor_rss"></textarea>
          </div>
          <div id="template_preview" class="newsletter_preview_container wpnlc_tab"> </div>
        </div>
      </div>
    </div>
  </form>
</div>
