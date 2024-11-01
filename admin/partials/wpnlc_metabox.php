<div id="loading_progress" style="display:none"> <img class="loading_image" src="<?php echo plugins_url('wp2newsletter/public/images/loading.gif');?>"> </div>
<?php
$feed_description = get_post_meta($post->ID,'wpnlc_feed_description',true);
$feed_data_source = get_post_meta($post->ID,'wpnlc_feed_datasource',true);
$feed_category = get_post_meta($post->ID,'wpnlc_feed_category',true);
$feed_type = get_post_meta($post->ID,'wpnlc_feed_type',true);

$feed_event_venue = get_post_meta($post->ID,'wpnlc_feed_event_venue',true);


$feed_start_date = get_post_meta($post->ID,'wpnlc_feed_start_date',true);
$feed_end_date = get_post_meta($post->ID,'wpnlc_feed_end_date',true);

$wpnlc_hero_post = get_post_meta($post->ID,'wpnlc_hero_post',true);
if($wpnlc_hero_post){
	$hero_obj = get_post($wpnlc_hero_post);
	}else{
		$wpnlc_hero_post='';
		}
$feed_include = get_post_meta($post->ID,'wpnlc_feed_includes',true);
$feed_exclude = get_post_meta($post->ID,'wpnlc_feed_excludes',true);
$feed_number = get_post_meta($post->ID,'wpnlc_feed_number',true);
$feed_orderby = get_post_meta($post->ID,'wpnlc_feed_orderby',true);
$feed_order = get_post_meta($post->ID,'wpnlc_feed_order',true);
$feed_text_limit = get_post_meta($post->ID,'wpnlc_feed_text_limit',true);
$feed_excerpt_length = get_post_meta($post->ID,'wpnlc_feed_excerpt_length',true);
$feed_date_format = get_post_meta($post->ID,'wpnlc_feed_date_format',true);
$feed_dateformat_custom = get_post_meta($post->ID,'wpnlc_feed_dateformat_custom',true);
?>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr class="feed_description">
    <td width="30%"><?php _e('Description','wpnewsletter-campaigns')?></td>
    <td width="70%"><label for="feed_description"></label>
      <textarea cols="60" rows="8" name="wpnlc_feed_description" id="wpnlc_feed_description" required="required"><?php echo $feed_description; ?></textarea>
      <br />
      <span class="note"><?php echo _e('Description will be used for feed description','wpnewsletter-campaign')?></span></td>
  </tr>
  <tr class="feed_source">
    <td><?php _e('Data Source','wpnewsletter-campaigns')?></td>
    <td><label for="feed_source"></label>
      <?php
	$valid_datasources = get_option('wpnlc_valid_datasources');
	
	$valid_datasources[]='include_ids';
	
	$sources = array(
					'post'=>'Posts',
					'page'=>'Pages',
					'include_ids'=>'List of IDs'
					);
					
			$args = array(
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
	if($sources['wpnlc'])unset($sources['wpnlc']);
		
?>
      <select name='wpnlc_feed_datasource' id='wpnlc_feed_datasource'>
        <?php 
			if($valid_datasources !=''){?>
        <option value="">
        <?php _e('Select Data Source')?>
        </option>
        <?php
				foreach ($sources as $name=>$label){
				if(in_array($name,$valid_datasources)){ ?>
        <option value="<?php echo esc_attr($name); ?>" <?php echo ($feed_data_source == $name)?'selected':'' ?>><?php echo esc_html($label); ?></option>
        <?php }
				}
			}else{?>
        <option value="">
        <?php _e('Please Select Valid Datasources in Settings First','wpnewsletter-campaigns')?>
        </option>
        <?php } ?>
      </select>
      <span class="note"><?php echo _e('Select content type for your Newsletter','wpnewsletter-campaign')?></span></td>
  </tr>
  <tr class="feed_category" <?php echo ($feed_data_source =='')?'style="display:none"':''?>>
    <td><?php _e('Narrow Data Source','wpnewsletter-campaigns')?></td>
    <td><label for="categories"></label>
      <?php
		  $taxonomies = get_object_taxonomies( $feed_data_source );
  		  $html = '<select name="wpnlc_feed_category[]" id="wpnlc_feed_category" multiple="multiple">';
		  if(empty($taxonomies)){
			  }else{
				 foreach ($taxonomies as $tax){
			$terms = get_terms($tax);
			if(! empty( $terms ) && ! is_wp_error( $terms )){
			 $html .= '<optgroup label="'.$tax.'">';
			 foreach($terms as $term){
			  $selected = '';
			  
			  if(!empty($feed_category)){
				  if(in_array($tax.':'.$term->term_id, $feed_category)){
			 	$selected = 'selected';
			 	 }
			  }
			  $html .= '<option value="'.$tax.':'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>'; 
			 }
			 $html .= '</optgroup>';
			}
			
		  }  
				  }
			$html.='</select>';
		 
		  echo $html;
		
		?>
      <span class="note"><?php echo _e('Enter categories, tags or custom taxonomies','wpnewsletter-campaign')?></span></td>
  </tr>
  <tr class="feed_type">
    <?php
  $feed_types = array();
  switch($feed_data_source){
			case 'post':
				$feed_types = array('' =>'None',
								'latest'=>'Latest',
  								'sticky'=>'Sticky or Featured'
								);
				break;
			case 'product':
				$feed_types = array('' =>'None',
										'latest'=>'Latest',
  										'sticky'=>'Sticky or Featured',
										'topseller'=>'Top Seller',
										'topfreebies'=>'Top Freebies',
										'topearners'=>'Top Earners',
										'promotions'=>'Promotions (Specials)',
								);
				break;
			case 'tribe_events':
				$feed_types = array('' =>'None',
								'latest'=>'Latest',
								'upcomming'=>'Upcomming',
								'location'=>'Location (Near By)',
								'thismonth'=>'Events this month',
								'thisweek'=>'Events this week',
								);
				break;
			case 'shop_coupon':
				$feed_types = array('' =>'None',
								'latest'=>'Latest',
  								'popular'=>'Most Popular (Only the ones without user restriction or public ones)',
								'discount'=>'Most Discount'
								);
				break;
			default:
			$feed_types = array('' =>'None','latest'=>'Latest');
			}
 ?>
    <td><?php _e('Data Type','wpnewsletter-campaigns')?></td>
    <td><label for="feed_type"></label>
      <select name="wpnlc_feed_type" id="wpnlc_feed_type">
        <?php
	  if($feed_types){
		  $obj = get_post_type_object( $feed_data_source );
		  foreach($feed_types as $name=>$label){
		  if(isset($obj->labels)){
			  $label = $label.'( '.$obj->labels->menu_name.' )';
			  }
		  ?>
        <option value="<?php echo $name?>" <?php echo ($feed_type == $name)?'selected':'' ?>><?php echo $label ?></option>
        <?php }
		 }else{?>
        <option value="">
        <?php _e('First Select Datasource','wpnewsletter-campaigns');?>
        </option>
        <?php  }
	  
	  ?>
      </select>
      <p class="post_count"></p></td>
  </tr>
  <tr class="feed_start_date" <?php echo ($feed_type == 'upcomming')?'':'style="display:none"'?>>
    <td><?php _e('Fetch Feeds Start Date','wpnewsletter-campaigns')?></td>
    <td><label for="date"></label>
      <input name="wpnlc_feed_start_date" type="date" class="datepicker" id="wpnlc_feed_start_date" value="<?php echo ($feed_start_date)?$feed_start_date:date('Y-m-d')?>" placeholder="Upcomming Events From" /></td>
  </tr>
  <tr class="feed_end_date" <?php echo ($feed_type == 'upcomming')?'':'style="display:none"'?>>
    <td><?php _e('Fetch Feeds End Date','wpnewsletter-campaigns')?></td>
    <td><label for="date"></label>
      <input name="wpnlc_feed_end_date" type="date" class="datepicker" id="wpnlc_feed_end_date" value="<?php echo ($feed_end_date)?$feed_end_date:date('Y-m-d')?>" placeholder="Upcomming Events Until" /></td>
  </tr>
  <tr class="feed_venue" <?php echo ($feed_type == 'location')?'':'style="display:none"'?>>
    <td><?php _e('Location Near By','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_event_venue"></label>
      <select name="wpnlc_feed_event_venue" id="wpnlc_feed_event_venue">
        <option value="">
        <?php _e('Select Location Nearby You','wpnewsletter-campaign')?>
        </option>
        <?php 
	$venues = get_posts(array('post_type'=>'tribe_venue','posts_per_page'=> -1));
	foreach($venues as $venue){?>
        <option value="<?php echo $venue->ID?>" <?php echo ($venue->ID == $feed_event_venue)?'selected':'' ?>><?php echo $venue->post_title?></option>
        <?php }
	?>
      </select>
      
      <!--<input name="wpnlc_feed_event_venue" type="text" id="wpnlc_feed_event_venue" value="<?php echo $feed_event_venue?>" placeholder="Events Nearby" />--></td>
  </tr>
  <tr class="feed_includes" <?php echo ($feed_data_source == 'include_ids')?'':'style="display:none"'?>>
    <td><?php _e('Include Post Ids','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_includes"></label>
      <select name="wpnlc_feed_includes[]" id="wpnlc_feed_includes" multiple="multiple">
        <?php 
	if(!empty($feed_include)){
		foreach($feed_include as $pid){
		$pobj = get_post($pid);?>
        <option value="<?php echo $pobj->ID?>" selected="selected">
        <?php _e($pobj->post_title,'wpnewsletter-campaign')?>
        </option>
        <?php }
		}
		?>
      </select>
      
      <!--<input type="text" name="wpnlc_feed_includes" id="wpnlc_feed_includes" value="<?php echo $feed_include?>" placeholder="Comma seperated post IDs" />--></td>
  </tr>
  <tr class="wpnlc_hero_post">
    <td><?php _e('Select Hero Post','wpnewsletter-campaigns')?></td>
    <td><label for="feed_hero_post"></label>
      <select name="wpnlc_hero_post" id="wpnlc_hero_post">
        <?php
		if($wpnlc_hero_post !=''){
			?>
        <option value="<?php $hero_obj->ID ?>" selected="selected"><?php echo $hero_obj->post_title?></option>
        <?php }else{?>
        <option disabled="disabled"></option>
        <option value="" disabled="disabled">
        <?php _e('Chose Hero Post', 'wpnewsletter-campaign')?>
        </option>
        <?php }
		?>
      </select></td>
  </tr>
  <tr class="settings_section_divider">
    <td colspan="2"><h1>
        <?php _e('Settings','wpnewsletter-campaign'); ?>
      </h1></td>
  </tr>
  <tr class="feed_excludes">
    <td><?php _e('Exclude','wpnewsletter-campaigns')?></td>
    <td><label for="exclude_post"></label>
      <select name="wpnlc_feed_excludes[]" id="wpnlc_feed_excludes" multiple="multiple">
        <?php 
	if(!empty($feed_exclude)){
		foreach($feed_exclude as $pid){
		$pobj = get_post($pid);?>
        <option value="<?php $pobj->ID?>" selected="selected">
        <?php _e($pobj->post_title,'wpnewsletter-campaign')?>
        </option>
        <?php }
		}
		?>
      </select>
      <span class="note"><?php echo _e('Exclude posts, pages, etc. by title.','wpnewsletter-campaign')?></span> 
      <!--<input type="text" name="wpnlc_feed_excludes" id="wpnlc_feed_excludes" value="<?php echo $feed_exclude?>" placeholder="Comma seperated post IDs" />--></td>
  </tr>
  <tr class="feed_orderby">
    <td><?php _e('Order By','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_orderby"></label>
      <select name="wpnlc_feed_orderby" id="wpnlc_feed_orderby">
        <?php $order_by_arr = array(
							'date'=> __('Date','wpnewsletter-campaign'),
							'ID'=> __('Post ID','wpnewsletter-campaign'),
							'author' =>  __('Author','wpnewsletter-campaign'),
							'title' => __('Post Title','wpnewsletter-campaign'),
							'menu_order' => __('Menu Order / Page Order','wpnewsletter-campaign')
							);?>
        <?php foreach($order_by_arr as $key=>$value){?>
        <option value="<?php echo $key?>" <?php echo ($key == $feed_orderby)?'selected':''?>><?php echo $value?></option>
        <?php }?>
      </select></td>
  </tr>
  <tr class="feed_order">
    <td><?php _e('Sort Order','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_order"></label>
      <select name="wpnlc_feed_order" id="wpnlc_feed_order">
        <option value="asc" <?php echo ($feed_order == 'asc')?'selected':'' ?>>
        <?php _e('Ascending','wpnewsletter-campaign')?>
        </option>
        <option value="desc" <?php echo ($feed_order == 'desc')?'selected':'' ?>>
        <?php _e('Descending','wpnewsletter-campaign')?>
        </option>
      </select></td>
  </tr>
  <tr class="feed_number">
    <td><?php _e('Max No. of Items','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_number"></label>
      <input type="number" name="wpnlc_feed_number" id="wpnlc_feed_number" value="<?php echo $feed_number?>"/></td>
  </tr>
  <tr class="feed_text_limit">
    <td><?php _e('Content Length','wpnewsletter-campaigns')?></td>
    <td><label for="wpnlc_feed_text_limit"></label>
      <select name="wpnlc_feed_text_limit" id="wpnlc_feed_text_limit">
        <option value="excerpt" <?php echo ($feed_text_limit=='excerpt')?'selected':''?>>
        <?php _e('Excerpt','wpnewsletter-campaigns')?>
        </option>
        <option value="full" <?php echo ($feed_text_limit == 'full')?'selected':'' ?>>
        <?php _e('Full Content','wpnewsletter-campaigns')?>
        </option>
      </select></td>
  </tr>
  <tr class="feed_excerpt_length" <?php echo ($feed_text_limit == 'excerpt')?'':'style="display:none"'?>>
    <td><?php _e('Excerpt Length','wpnewsletter-campaigns')?></td>
    <td><label for="excerpt_length"></label>
      <input type="text" name="wpnlc_feed_excerpt_length" id="wpnlc_feed_excerpt_length" value="<?php echo ($feed_excerpt_length)?$feed_excerpt_length:20?>" /></td>
  </tr>
  <tr class="feed_date_format">
    <td><?php _e('Date Format','wpnewsletter-campaigns')?></td>
    <td><p>
        <label>
          <input type="radio" name="wpnlc_feed_date_format" value="F d, Y" <?php echo ($feed_date_format == 'F d, Y')?'checked':'' ?> required="required"/>
          <?php _e('February 26, 2016','wpnewsletter-campaigns')?>
        </label>
        <br />
        <label>
          <input type="radio" name="wpnlc_feed_date_format" value="Y-m-d" <?php echo ($feed_date_format == 'Y-m-d')?'checked':'' ?> required="required"/>
          <?php _e('2016-02-26','wpnewsletter-campaigns')?>
        </label>
        <br />
        <label>
          <input type="radio" name="wpnlc_feed_date_format" value="m/d/Y" <?php echo ($feed_date_format == 'm/d/Y')?'checked':'' ?> required="required"/>
          <?php _e('02/26/2016','wpnewsletter-campaigns')?>
        </label>
        <br />
        <label>
          <input type="radio" name="wpnlc_feed_date_format" value="d/m/Y" <?php echo ($feed_date_format == 'd/m/Y')?'checked':'' ?> required="required"/>
          <?php _e('26/02/2016','wpnewsletter-campaigns')?>
        </label>
        <br />
        <label>
          <input type="radio" name="wpnlc_feed_date_format" value="custom" <?php echo ($feed_date_format == 'custom')?'checked':'' ?> required="required"/>
          <?php _e('Custom Format','wpnewsletter-campaigns')?>
          <input class="feed_custom_dateformat" type="text" name="wpnlc_feed_dateformat_custom" value="<?php echo $feed_dateformat_custom?>" <?php echo ($feed_date_format == 'custom')?'required="required"':'' ?> placeholder="Date Format Eg:F j, Y" <?php echo ($feed_date_format == 'custom')?'':'style="display:none"'?>>
        </label>
        <br />
      </p></td>
  </tr>
</table>
