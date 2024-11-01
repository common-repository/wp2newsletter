<div id="loading_progress" style="display:none"> <img class="loading_image" src="<?php echo plugins_url('wp2newsletter/public/images/loading.gif');?>"> </div>
<div class="wrap">
  <h1>
    <?php _e( "Wp2Newsletter Settings", "wpnewsletter-campaigns" ); ?>
  </h1>
  <div id="message" class="settings-error"> </div>
  <table class="form-table">
    <tr valigh="middle">
      <th> <label for="wpnlc_mailchimp_api_key">
          <?php _e( "Mailchimp API Key", "wpnewsletter-campaigns" ); ?>
        </label>
      </th>
      <td><input type="text" name="wpnlc_mailchimp_api_key" id="wpnlc_mailchimp_api_key" value="<?php echo get_option('wpnlc_mailchimp_api_key','')?>" placeholder="Mailchimp API Key" required="required"/>
        <?php if($status['status']){?>
        <label class="mc_status active">
          <?php _e('Connected','wpnewsletter-campaign')?>
        </label>
        <?php }else{?>
        <label class="mc_status">
          <?php _e('Disconnected','wpnewsletter-campaign')?>
        </label>
        <br />
        <p class="mc_api_error"><?php echo $status['detail']?></p>
        <?php	}?></td>
    </tr>
    <tr valigh="middle">
      <th> <label for="wpnlc_valid_datasources">
          <?php _e( "Data Sources", "wpnewsletter-campaigns" ); ?>
        </label>
      </th>
      <td><?php 
			$valid_datasources = (get_option('wpnlc_valid_datasources'))?get_option('wpnlc_valid_datasources'):array();
			$sources = array(
							'post'=>'Posts',
							'page'=>'Pages',
							//'include_ids'=>'User Selected IDs'
							);
			$args = array(
			   //'public'   => true,
			   'publicly_queryable'=>true,
			   '_builtin' => false,
			);
			
		$post_types = get_post_types($args,'objects');
		
		foreach ($post_types as $ds){
			$sources[$ds->name]=$ds->labels->menu_name;
			}
		if(class_exists( 'WooCommerce' )){
			$sources['shop_coupon'] = 'Woocommerce Coupons';
		}
//Exclude our datasource post type 
if($sources['wpnlc'])unset($sources['wpnlc']);

foreach($sources as $key=>$value){
	?>
        <p>
          <input type="checkbox" name="wpnlc_valid_datasources[]" value="<?php echo $key?>" <?php echo (in_array($key,$valid_datasources))?'checked':'' ?>/>
          <strong><?php echo  $value;?></strong></p>
        <?php }
			?></td>
    </tr>
    <tr valigh="middle">
      <td>&nbsp;</td>
      <td><input name="wpnlc_settings_save" class="button button-primary" id="wpnlc_settings_save" type="submit" value="<?php _e('Save Changes','wpnewsletter-campaigns')?>"/></td>
    </tr>
  </table>
</div>
