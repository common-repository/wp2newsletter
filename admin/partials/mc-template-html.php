<?php
$feed_html = '';
if(!empty($pids)){
foreach($pids as $post_id){
		global $post;
		$post = get_post($post_id);
		setup_postdata($post);
		$excerpt = $this->wpnlc_rss_limit_words(get_the_excerpt(),$feed_excerpt_length);
		$postimages = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		if ( $postimages ) {
			$postimage = $postimages[0];
		}
		else{
			$postimage = plugins_url('wp2newsletter') . '/public/images/no-image.png';
		}
	//*********** Replace the metakeys found within the post****/
		preg_match_all('/\{wp2edm-(.*?)\}/s', $template_dynamic, $matches);
		$post_metakeys = array();
		$post_metavalues = array();
		foreach($matches[0] as $code){
			$post_metakeys[] = $code;
			}
		foreach($matches[1] as $metakey){
			$meta_value = get_post_meta(get_the_ID(),$metakey,true);
			$post_metavalues[] = $meta_value;
			}
		$template_dynamic = str_replace($post_metakeys,$post_metavalues,$template_dynamic);
	//*********** Replace the metakeys found within the post****/

	//*********** Replace the special metakeys****/
		preg_match_all('/\{wp2edmspcl-(.*?)\}/s', $template_dynamic, $matches);
		$special_keys = array();
		$special_key_values = array();
		foreach($matches[0] as $code){
			$special_keys[] = $code;
			}
		foreach($matches[1] as $metakey){
			list($main_plugin, $key) = explode('-', $metakey, 2);
			$special_key_values[] = $this->wpnlc_get_special_metavalue($main_plugin,get_the_ID(),$key);
			}
		$template_dynamic = str_replace($special_keys,$special_key_values,$template_dynamic);
	//*********** Replace the special metakeys****/
	
		if($template_type == 'normal'){
			$code = array('{POST_ID}','{POST_IMAGE}','{POST_TITLE}','{POST_AUTHOR}','{POST_DATE}','{CONTENT_FULL}','{CONTENT_EXCERPT}','{POST_LINK}');
			
			$date = get_post_time( $feed_date_format, true );

			
			$replace = array(get_the_ID(),$postimage,get_the_title(),get_the_author(),$date,($feed_text_limit == 'full')?get_the_content():'',($feed_text_limit == 'excerpt')?$excerpt:'',get_the_permalink()
			);?>
<?php echo str_replace($code,$replace,$template_dynamic);
		}else{
		/*
		what to do if rss driven??
		*/
		}
	wp_reset_postdata();
	}
	}

?>