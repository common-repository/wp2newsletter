<?php
$feed_html = '';
if(!empty($pids)){
	foreach($pids as $post_id){
			global $post;
			$post = get_post($post_id);
			setup_postdata($post);
			$excerpt = ($feed_text_limit == 'excerpt')?$this->wpnlc_rss_limit_words(get_the_excerpt(),$feed_excerpt_length):get_the_content();
			$postimages = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
			if ( $postimages ) {
				$postimage = $postimages[0];
				$mime_type = get_post_mime_type(get_post_thumbnail_id( get_the_ID() ));
			}
			else{
				$postimage = plugins_url('wp2newsletter') . '/public/images/no-image.png';
				$mime_type = 'image/png';
			}
	$date = get_post_time( $feed_date_format, true );
			if($feed_data_source == 'tribe_events'){
				$date = mysql2date( $feed_date_format, get_post_meta(get_the_ID(),'_EventStartDate',true),false);
				if($feed_type == 'upcomming'){
					$date = 'From: '.mysql2date( $feed_date_format, get_post_meta(get_the_ID(),'_EventStartDate',true),false).' To: '.mysql2date( $feed_date_format, get_post_meta(get_the_ID(),'_EventEndDate',true),false);
					}
				}
	?>
    <item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
		<enclosure url="<?php echo esc_url($postimage);?>" type="<?php echo $mime_type?>"/> 
		<comments><?php comments_link_feed(); ?></comments>
		<pubDate><?php echo $date ?></pubDate>
		<dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator>
		<?php the_category_rss('rss2') ?>

		<guid isPermaLink="false"><?php the_guid(); ?></guid>
		<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
	<?php $content = get_the_content_feed('rss2'); ?>
	<?php if ( strlen( $content ) > 0 ) : ?>
		<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
	<?php else : ?>
		<content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
	<?php endif; ?>
		<wfw:commentRss><?php echo esc_url( get_post_comments_feed_link(null, 'rss2') ); ?></wfw:commentRss>
		<slash:comments><?php echo get_comments_number(); ?></slash:comments>
<?php rss_enclosure(); ?>
	<?php
	/**
	 * Fires at the end of each RSS2 feed item.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_item' );
	?>
	</item>
	<?php
	wp_reset_postdata();
	}
}
?>

