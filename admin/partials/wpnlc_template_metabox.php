<?php
$template_type = get_post_meta($post->ID,'wpnlc_template_type',true);
$email_mkt_srvs = get_post_meta($post->ID,'wpnlc_email_mkt_srvs',true);
$template_code_normal = get_post_meta($post->ID,'wpnlc_template_code',true);
$template_code_rss = get_post_meta($post->ID,'wpnlc_template_code_rss',true);
?>

<table width="100%" border="0" cellspacing="5" cellpadding="5">
 <?php
 /*
  <tr class="template_type">
    <td width="30%"><?php _e('Template Type','wpnewsletter-campaigns')?></td>
    <td width="70%"><label for="wpnlc_template_type"></label>
      <select name="wpnlc_template_type" id="wpnlc_template_type">
        <option value="normal" <?php echo ($template_type == 'normal')?'selected':''?>>
        <?php _e('Normal Template','wpnewsletter-campaign')?>
        </option>
        <option value="rss" <?php echo ($template_type == 'rss')?'selected':''?>>
        <?php _e('RSS Driven Template','wpnewsletter-campaign')?>
        </option>
      </select></td>
  </tr>
  */
  ?>
  
  <tr class="email_mkt_srvs">
    <td width="30%"><?php _e('Email Marketing Services','wpnewsletter-campaigns')?></td>
    <td width="70%"><label for="wpnlc_email_mkt_srvs"></label>
      <select name="wpnlc_email_mkt_srvs" id="wpnlc_email_mkt_srvs">
        <?php $options = array('mailchimp'=>'MailChimp',
								'getresponse'=>'GetResponse ( Comming Soon )',
								'campaignmonitor'=>'Campaign Monitor ( Comming Soon )'
								);
			foreach($options as $key=>$value){?>
        <option value="<?php echo $key; ?>" <?php echo ($email_mkt_srvs == $key)?'selected':''?>>
        <?php _e($value,'wpnewsletter-campaign'); ?>
        </option>
        <?php }
		?>
      </select></td>
  </tr>
  <tr class="html_n_preview">
    <td width="100%" colspan="2"><ul>
        <li class="tabs_control active">
        <a tab="wpnlc_template_html_normal">
          <?php _e('Normal Template Code','wpnewsletter-campaign') ?>
          </a>
        </li>
        <li class="tabs_control">
        <a tab="wpnlc_template_html_rss">
          <?php _e('RSS Driven Template Code','wpnewsletter-campaign') ?>
          </a>
        </li>
        <li class="tabs_control">
        <a tab="wpnlc_template_preview">
          <?php _e('Preview ( Normal )','wpnewsletter-campaign') ?>
          </a>
       </li>
      </ul></td>
  </tr>
  <tr class="html_n_preview_tabs">
    <td width="100%" colspan="2">
    <div class="wpnlc_template_tabs" id="wpnlc_template_html_normal">
        <textarea name="wpnlc_template_code_normal" id="wpnlc_template_code_normal"><?php echo $template_code_normal; ?></textarea>
      </div>
      <div class="wpnlc_template_tabs" id="wpnlc_template_html_rss">
        <textarea name="wpnlc_template_code_rss" id="wpnlc_template_code_rss"><?php echo $template_code_rss; ?></textarea>
      </div>
      <div class="wpnlc_template_tabs" id="wpnlc_template_preview">
        <iframe id="template_preview"></iframe>
      </div></td>
      
  </tr>
</table>
