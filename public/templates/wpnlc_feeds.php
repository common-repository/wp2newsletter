<?php
/**
 * Customs RSS template 
 * 
 *
 */
/**
 * Get posts based on user settings.
 */

if(class_exists(Wpnewsletter_Campaign)){
	$Wpnewsletter_Campaign = new Wpnewsletter_Campaign();
	$plugin_admin = new Wpnewsletter_Campaign_Admin( $Wpnewsletter_Campaign->get_wpnewsletter_campaign(), $Wpnewsletter_Campaign->get_version() );
	$feed_html  = $plugin_admin->wpncl_generate_campaigns($post->ID);
	$feed_description = $plugin_admin->wpnlc_rss_limit_words(get_post_meta($post->ID,'wpnlc_feed_description',true),50);

setup_postdata($post);
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$postimages = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );

// Check for images
if ( $postimages ) {

	// Get featured image
	$postimage = $postimages[0];

}

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
//*
// * Fires between the <xml> and <rss> tags in a feed.
// * @since 4.0.0
// * @param string $context Type of feed. Possible values include 
// * 'rss2', 'rss2-comments', 'rdf', 'atom', and 'atom-comments'.
// 
 
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php
//	*
//	 * Fires at the end of the RSS root to add namespaces.
//	 * @since 2.0.0
//	 
	do_action( 'rss2_ns' );
	?>
>

<channel>
	<title><?php the_title(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php echo get_post_meta($post->ID,'wpnlc_feed_description',true)?></description>
	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<?php
	$duration = 'hourly';
//	*
//	 * Filter how often to update the RSS feed.
//	 * @since 2.1.0
//	 * @param string $duration The update period.
//	 * Default 'hourly'. 
//	 * Accepts 'hourly', 'daily', 'weekly', 'monthly', 'yearly'.
//	 
	?>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', $duration ); ?></sy:updatePeriod>
	<?php
	$frequency = '1';
//	*
//	 * Filter the RSS update frequency.
//	 * @since 2.1.0
//	 * @param string $frequency An integer passed as a string 
//	 * representing the frequency of RSS updates within the update period. 
//	 * Default '1'.
//	 
	?>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', $frequency ); ?></sy:updateFrequency>
	<?php
//	*
//	 * Fires at the end of the RSS2 Feed Header.
//	 * @since 2.0.0
//	 
	do_action( 'rss2_head');
?>
<?php echo $feed_html?>
</channel>
</rss>	

<?php
}



