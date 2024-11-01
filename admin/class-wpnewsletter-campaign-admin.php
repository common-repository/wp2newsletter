<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://webavenue.com.au/wpnewslettercampaign
 * @since      1.0.0
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/admin
 * @author     Your Name <email@example.com>
 */
class Wpnewsletter_Campaign_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wpnewsletter_campaign    The ID of this plugin.
	 */
	private $wpnewsletter_campaign;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	*Array of meta fields used in Newwslettr Campaign Post type
	*
	*
	*/
	private $wpnlc_post_meta	= array(
						'wpnlc_feed_title',
						'wpnlc_feed_description',
						'wpnlc_feed_datasource',
						'wpnlc_feed_category',
						'wpnlc_feed_type',
						'wpnlc_feed_event_venue',
						'wpnlc_feed_start_date',
						'wpnlc_feed_end_date',
						'wpnlc_hero_post',
						'wpnlc_feed_orderby',
						'wpnlc_feed_order',
						'wpnlc_feed_excludes',
						'wpnlc_feed_number',
						'wpnlc_feed_text_limit',
						'wpnlc_feed_excerpt_length',
						'wpnlc_feed_date_format',
						'wpnlc_feed_dateformat_custom',
						'wpnlc_feed_includes',
		);
	/**
	*Array of meta fields used in Newwslettr Template Post type
	*
	*
	*/
	private $wpmlc_template_meta = array(
											//'wpnlc_template_type',
											'wpnlc_email_mkt_srvs',
											'wpnlc_template_code_normal',	
											'wpnlc_template_code_rss'	
										);
		


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wpnewsletter_campaign       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wpnewsletter_campaign, $version ) {

		$this->wpnewsletter_campaign = $wpnewsletter_campaign;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpnewsletter_Campaign_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpnewsletter_Campaign_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->wpnewsletter_campaign, plugin_dir_url( __FILE__ ) . 'css/wpnewsletter-campaign-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'codemirror-css', plugin_dir_url( __FILE__ ) . 'codemirror/lib/codemirror.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'codemirror-seti-css', plugin_dir_url( __FILE__ ) . 'codemirror/theme/seti.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'chosen-css', plugin_dir_url( __FILE__ ) . 'css/chosen.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpnewsletter_Campaign_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpnewsletter_Campaign_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_script( $this->wpnewsletter_campaign, plugin_dir_url( __FILE__ ) . 'js/wpnewsletter-campaign-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'codemirror-js', plugin_dir_url( __FILE__ ) . 'codemirror/lib/codemirror.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'codemirror-htmlmixed-js', plugin_dir_url( __FILE__ ) . 'codemirror/mode/htmlmixed/htmlmixed.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'codemirror-xml-js', plugin_dir_url( __FILE__ ) . 'codemirror/mode/xml/xml.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'codemirror-css-js', plugin_dir_url( __FILE__ ) . 'codemirror/mode/css/css.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'codemirror-javascript-js', plugin_dir_url( __FILE__ ) . 'codemirror/mode/javascript/javascript.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'chosen-js', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.min.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	*Register our custom post type of newsletter campaign
	*
	* @since	1.0.0
	*
	*/
	public function register_wpnewsletter_campaign_posttypes(){

/*
Register Newsletter Campaign post type
*/
		$labels = array(
		'name'               => _x( 'Data Sources', 'post type general name', 'wpnewsletter-campaigns' ),
		'singular_name'      => _x( 'Data Source', 'post type singular name', 'wpnewsletter-campaigns' ),
		'menu_name'          => _x( 'Wp2Newsletter', 'admin menu', 'wpnewsletter-campaigns' ),
		'name_admin_bar'     => _x( 'Wp2Newsletter', 'add new on admin bar', 'wpnewsletter-campaigns' ),
		'add_new'            => _x( 'New Data Source', 'newsletter_camapaign', 'wpnewsletter-campaigns' ),
		'add_new_item'       => __( 'Add New Data Source', 'wpnewsletter-campaigns' ),
		'new_item'           => __( 'New Data Source', 'wpnewsletter-campaigns' ),
		'edit_item'          => __( 'Edit Data Source', 'wpnewsletter-campaigns' ),
		'view_item'          => __( 'View Data Source', 'wpnewsletter-campaigns' ),
		'all_items'          => __( 'Data Sources', 'wpnewsletter-campaigns' ),
		'search_items'       => __( 'Search Data Sources', 'wpnewsletter-campaigns' ),
		'parent_item_colon'  => __( 'Parent Data Sources:', 'wpnewsletter-campaigns' ),
		'not_found'          => __( 'No Data Source Found.', 'wpnewsletter-campaigns' ),
		'not_found_in_trash' => __( 'No Data Source found in Trash.', 'wpnewsletter-campaigns' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'wpnewsletter-campaigns' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'wpnewsletter_camapaign' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_icon'			=>'dashicons-email',
		'menu_position'      => null,
		'supports'           => array( 'title')
	);

	register_post_type( 'wpnlc', $args );

/*
Register Template Post type
*/
		$labels = array(
		'name'               => _x( 'Templates', 'post type general name', 'wpnewsletter-campaigns' ),
		'singular_name'      => _x( 'Template', 'post type singular name', 'wpnewsletter-campaigns' ),
		'menu_name'          => _x( 'EDM Templates', 'admin menu', 'wpnewsletter-campaigns' ),
		'name_admin_bar'     => _x( 'Template', 'add new on admin bar', 'wpnewsletter-campaigns' ),
		'add_new'            => _x( 'Add New', 'newsletter_camapaign', 'wpnewsletter-campaigns' ),
		'add_new_item'       => __( 'Add New', 'wpnewsletter-campaigns' ),
		'new_item'           => __( 'New Template', 'wpnewsletter-campaigns' ),
		'edit_item'          => __( 'Edit Template', 'wpnewsletter-campaigns' ),
		'view_item'          => __( 'View Template', 'wpnewsletter-campaigns' ),
		'all_items'          => __( 'Templates', 'wpnewsletter-campaigns' ),
		'search_items'       => __( 'Search Template', 'wpnewsletter-campaigns' ),
		'parent_item_colon'  => __( 'Parent Template:', 'wpnewsletter-campaigns' ),
		'not_found'          => __( 'No Templates found.', 'wpnewsletter-campaigns' ),
		'not_found_in_trash' => __( 'No Template found in Trash.', 'wpnewsletter-campaigns' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'wpnewsletter-campaigns' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'wpnewsletter_template' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_icon'			 =>'dashicons-screenoptions',
		'menu_position'      => null,
		'supports'           => array( 'title','thumbnail')
	);

	register_post_type( 'wpnlc_template', $args );
	
	
/*	
Register Newsltter Template Category
*/	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Categories' ),
		'all_items'         => __( 'All Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item'         => __( 'Edit Category' ),
		'update_item'       => __( 'Update Category' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category Name' ),
		'menu_name'         => __( 'Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'wpnlc_template_cat' ),
	);

	register_taxonomy( 'wpnlc_template_cat', array( 'wpnlc_template' ), $args );
		}
	/**
	*Function to create a setting page for generating the newsletter campaigns to be pushed to mailchimp
	*/
	public function wpnewsletter_campaign_settings(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-newsletter-campaigns-settings.php';
		$plugin_settings = new WpNewsletter_Campaign_Settings();
		}
	
	/**
	*Function to save the Newsletter Campaigns settings (Mailchimp Api Key)
	*/
	public function wpnlc_save_settings(){
	$apikey = $_POST['apikey'];
	$valid_datasources = $_POST['valid_datasources'];
	$update = update_option('wpnlc_mailchimp_api_key',$apikey);
	$update = update_option('wpnlc_valid_datasources',$valid_datasources);
	if($update){
		echo 'true';
		}else{
			echo 'false';
			}
	die;
	}
	
	/*
	*Function to remove view link, edit link in newsletter template post types
	*/	
	public function wpnlc_remove_row_actions($actions){
		 if( get_post_type() == 'wpnlc_template' ){
				unset( $actions['view'] );
				unset($actions['inline hide-if-no-js'] );
		 	}
			return $actions;
		}
	/*
	Function to add a new Coloumn 'Post Type' in the newsletter datasource listing admin page
	*/	
	public function wpnlc_datasource_coloumn_head($defaults){
		$defaults['wpnlc_post_type']  = 'Post Type';
		return $defaults;
		}
	/*
	Function to output the value for the custom coloumn 'Post Type' for datasources
	*/
	public function wpnlc_datsource_coloumn_content($column_name,$post_id){
		if ($column_name == 'wpnlc_post_type') {
				$type = get_post_meta($post_id,'wpnlc_feed_datasource',true);
				$obj = get_post_type_object( $type );
				if($obj){
					echo ($obj->labels->menu_name)?$obj->labels->menu_name:'';
					}else{
						echo '';
						}
				
			}
		
		}
	/*
	Function to add a new coloumn 'Preview Image' to show the Featured Image of the template for EDM Templates in Templates List Table
	*/	
	public function wpnlc_template_coloumn_head($defaults){
		$defaults['wpnlc_template_thumb']  = 'Preview Image';
		return $defaults;
		}
	/*
	Function to return the featured image of the EDM Template in Templates Listing Table in admin area
	*/
	public function wpnlc_template_coloumn_content($column_name,$post_id){
		if ($column_name == 'wpnlc_template_thumb') {
			echo get_the_post_thumbnail($post_id,array(120,180));
			}
		
		}
	
	
/*
Function to add new Filter in the Post list table of Datasources
*/	
public function wpnlc_admin_posts_filter_restrict_manage_posts(){
	$type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    if ('wpnlc' == $type){
		$valid_datasources = get_option('wpnlc_valid_datasources');
		if(!$valid_datasources){
		return;
		}
		$values =array();
		foreach($valid_datasources as $post_type){
			$obj = get_post_type_object( $post_type );
			$values[$obj->labels->singular_name] = $post_type;
			}
		
        ?>
        <select name="admin_filter_data_source">
        <option value=""><?php _e('Filter By Post Types', 'wpnewsletter-campaign'); ?></option>
        <?php
            $current_v = isset($_GET['admin_filter_data_source'])? $_GET['admin_filter_data_source']:'';
            foreach ($values as $label => $value) {
                printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v? ' selected="selected"':'',
                        $label
                    );
                }
        ?>
        </select>
        <?php
    }
	}
/*
Function hooked to filter post list in admin area for data sources based on post type selected in Post type filter dropdown in post list table of datasources
*/
public function  wpnlc_custom_post_type_filter($query) {
	 global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'wpnlc' == $type && is_admin() && $pagenow=='edit.php' && isset($_GET['admin_filter_data_source']) && $_GET['admin_filter_data_source'] != '') {
        $query->query_vars['meta_key'] = 'wpnlc_feed_datasource';
        $query->query_vars['meta_value'] = $_GET['admin_filter_data_source'];
    }
}
	/**
	*Function to add the metabox for newsletter configuration in our custom post type
	*
	*@since 1.0.0
	*/
	public function wpnewsletter_campaign_metabox($post){
		add_meta_box('wpnewsletter-campaign', __('Setup Newsletter Data Source'),  array($this,'wpnewsletter_capmpaign_metabox_markup'), "wpnlc", "normal", "low");
		}
	/**
	*Function to show the metabox template
	*/
	public function wpnewsletter_capmpaign_metabox_markup($post){
		$admin = $this;
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
		ob_start();
		include dirname( __FILE__ ).'/partials/wpnlc_metabox.php';
		echo ob_get_clean();
		}
	/*
	*Function to save our custom field data to database
	*/
	public function wpnlc_save_metabox($post){
		if(empty($_POST)) return;
		global $post;
		//var_dump($_POST);die;
		foreach($this->wpnlc_post_meta as $field_name)
    			{	
					if(isset ($_POST[$field_name]))
					{
					update_post_meta($post->ID, $field_name, $_POST[$field_name]);
					}else{
						update_post_meta($post->ID, $field_name, '');
						}
    			}
		}
	/*
	*Function to add the metabox section to add the template editor area in newsletter template post types
	*/	
	public function wpnewsletter_template_metabox(){
		add_meta_box('wpnewsletter-template', __('Newsletter Template Editor'),  array($this,'wpnewsletter_template_metabox_markup'), "wpnlc_template", "normal", "low");
		}

	/*
	*Function to add the code editor metabox to newsletter template post types
	*/
	public function wpnewsletter_template_metabox_markup($post){
		ob_start();
		include dirname( __FILE__ ).'/partials/wpnlc_template_metabox.php';
		echo ob_get_clean();
		}
	/*
	*Function to save the template code during newsletter template post save/edit 
	*/
	public function wpnlc_template_save_metabox($post){
		if(empty($_POST)) return;
		global $post;
		foreach($this->wpmlc_template_meta as $field_name)
    			{	
					if(isset ($_POST[$field_name]))
					{
						update_post_meta($post->ID, $field_name, $_POST[$field_name]);
					}else{
						update_post_meta($post->ID, $field_name, '');
						}
    			}
		}
	/**
	*Funciton to get the Categories of datasource selected while creating Feed Datasource
	*/
	public function wpnlc_get_datasource_categories(){
		$post_type = $_POST['post_type'];
		$post_cats = array('post'=>'category','product'=>'product_cat','tribe_events'=>'tribe_events_cat');
		$taxonomy = $post_cats[$post_type];
		$args = array(
			'name'               => 'wpnlc_feed_category',
			'id'                 => 'wpnlc_feed_category',
			'show_option_none' => __( 'Select category' ),
			'show_count'       => 1,
			'orderby'          => 'name',
			'hide_empty'	   =>false,
			'taxonomy'		   =>$taxonomy,
			'echo'				=>0,
		);
		$cat_html = wp_dropdown_categories( $args );
  $taxonomies = get_object_taxonomies( $post_type,'object' );
  $html = '<select name="wpnlc_feed_category[]" id="wpnlc_feed_category" multiple="multiple">';
  foreach ($taxonomies as $tax){
    $terms = get_terms($tax->name);
    if(! empty( $terms ) && ! is_wp_error( $terms )){
     $html .= '<optgroup label="'.strtoupper($tax->label).'">';
     foreach($terms as $term){
      $html .= '<option value="'.$tax->name.':'.$term->term_id.'">'.$term->name.'</option>'; 
     }
     $html .= '</optgroup>';
    }
    
  }		
		echo json_encode($html);
		die();
		}
	/**
	*Funciton to get the feed type dropdown based on datasource selected while creating Feed Datasource
	*/
	public function wpnlc_get_feed_types(){
		$post_type = $_POST['post_type'];
		$feed_types = array();
		switch ($post_type){
			case 'post':
				$feed_types = array(
								'latest'=>'Latest',
  								'sticky'=>'Sticky or Featured'
								);
				break;
			case 'product':
				$feed_types = array(
										'latest'=>'Latest',
  										'featured'=>'Sticky or Featured',
										'topseller'=>'Top Seller',
										'topfreebies'=>'Top Freebies',
										'topearners'=>'Top Earners',
										'promotions'=>'Promotions (Specials)',
								);
				break;
			case 'tribe_events':
				$feed_types = array(
								'latest'=>'Latest',
								'upcomming'=>'Upcomming',
								'location'=>'Location (Near By)',
								'thismonth'=>'Events this month',
								'thisweek'=>'Events this week',
								);
				break;
			case 'shop_coupon':
				$feed_types = array(
								'latest'=>'Latest',
  								'popular'=>'Most Popular (Only the ones without user restriction or public ones)',
								'discount'=>'Most Discount'
								);
				break;
			default:
			$feed_types = array('latest'=>'Latest');
			}
	
		ob_start();?>
<select name="wpnlc_feed_type" id="wpnlc_feed_type">
	<option value=""><?php _e('None','wpnewsletter-campaign');?></option>
<?php foreach($feed_types as $key=>$value){
	$obj = get_post_type_object( $post_type );
?>
	<option value="<?php echo $key?>"><?php echo $value.' ( '.$obj->labels->singular_name.' )';?></option>
	<?php }?>
</select>
		<?php
        echo json_encode(ob_get_clean());
		die();
		}
	/**
	*Function to generate the newsletter campaigns from newsletter admin section 
	*
	*/	
	public function wpncl_generate_campaigns($feed_id=''){
		//$feed_html_already = $_POST['feed_html'];
		$preview =  (isset($_POST['wpncl_preview']))?true:false;
		$wpnlc_mctid = isset($_POST['wpnlc_mctid'])?$_POST['wpnlc_mctid']:'';
		$template_type = isset($_POST['template_type'])?$_POST['template_type']:'rss';
		$apikey = get_option('wpnlc_mailchimp_api_key',false);
		
		$template = isset($_POST['template'])? $_POST['template'] : 'rss';
		
		if($template){
			//$template_type = get_post_meta($template,'wpnlc_template_type',true);
			$template_name = isset($_POST['template_name'])? $_POST['template_name'] : '';
		}
		
		$feed_id = isset($_POST['feed_id'])? $_POST['feed_id'] : $feed_id;
		
		$post = get_post($feed_id,'OBJECT');
		$hero_post = get_post(get_post_meta($post->ID,'wpnlc_hero_post',true),'OBJECT');
		$feed_data_source = get_post_meta($post->ID,'wpnlc_feed_datasource',true);
		$feed_category = get_post_meta($post->ID,'wpnlc_feed_category',true);
		$feed_type = get_post_meta($post->ID,'wpnlc_feed_type',true);
				
		$feed_start_date = get_post_meta($post->ID,'wpnlc_feed_start_date',true);
		$feed_end_date = get_post_meta($post->ID,'wpnlc_feed_end_date',true);
		$feed_event_venue = get_post_meta($post->ID,'wpnlc_feed_event_venue',true);
		
		$feed_include = get_post_meta($post->ID,'wpnlc_feed_includes',true);
		$feed_orderby = get_post_meta($post->ID,'wpnlc_feed_orderby',true);
		$feed_order = get_post_meta($post->ID,'wpnlc_feed_order',true);
		$feed_exclude = get_post_meta($post->ID,'wpnlc_feed_excludes',true);
		$feed_number = get_post_meta($post->ID,'wpnlc_feed_number',true);
		$feed_text_limit = get_post_meta($post->ID,'wpnlc_feed_text_limit',true);
		$feed_excerpt_length = get_post_meta($post->ID,'wpnlc_feed_excerpt_length',true);
		$feed_date_format = (get_post_meta($post->ID,'wpnlc_feed_date_format',true) == 'custom')?get_post_meta($post->ID,'wpnlc_feed_dateformat_custom',true):get_post_meta($post->ID,'wpnlc_feed_date_format',true);
		$pids = array();
		switch($feed_data_source){
	case 'page':
				$args = array(	'post_type'=>'page',
						'posts_per_page'=>$feed_number,
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'orderby'=>$feed_orderby,
						'order'=>$feed_order,
						'post_status'=>'publish',
						);
		$pids = $this->wpnlc_query_pages($args);
		break;		
	
	
	case 'product':
				$args = array(	'post_type'=>array( 'product', 'product_variation' ),
						'category'=>$feed_category,
						'posts_per_page'=>$feed_number,
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'orderby'=>$feed_orderby,
						'order'=>$feed_order,
						'post_status'=>'publish',
						);
		$pids = $this->wpnlc_query_products($args);
		break;
		
	case 'tribe_events':
		$args = array(	'post_type'=>'tribe_events',
						'category'=>$feed_category,
						'posts_per_page'=>$feed_number,
						'feed_type'=>$feed_type,
						'feed_start_date'=>$feed_start_date,
						'feed_end_date'=>$feed_end_date,
						'feed_event_venue'=>$feed_event_venue,
						'exclude'=>$feed_exclude,
						'orderby'=>$feed_orderby,
						'order'=>$feed_order,
						'post_status'=>'publish',
						);
												
		$pids = $this->wpnlc_query_events($args);
		break;
	case 'shop_coupon':
		$args = array(
						'post_type'=>'shop_coupon',
						'feed_type'=>$feed_type,
						'posts_per_page'=>$feed_number,
						'post_status'=>'publish',
						);
		$pids = $this->wpnlc_query_coupons($args);
		break;
	case 'include_ids':
		$args = array(	'include_ids' =>$feed_include,'post_status'=>'publish',
						);
		$pids = $this->wpnlc_query_list_ids($args);
	break;
	default:
	$args = array(	'post_type'=>$feed_data_source,
						'category'=>$feed_category,
						'posts_per_page'=>$feed_number,
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'orderby'=>$feed_orderby,
						'order'=>$feed_order,
						'post_status'=>'publish',
						);
		$pids = $this->wpnlc_query_posts($args);
		break;
	}
			$template_obj = get_post($template);
			if($template_type == 'rss'){
				$code_type = 'wpnlc_template_code_rss';
				}elseif($template_type == 'normal'){
					$code_type = 'wpnlc_template_code_normal';
					}
					
			$template_code_full = get_post_meta($template_obj->ID,$code_type,true);
			if($hero_post){
						$hero_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $hero_post->ID), 'full' );
						if ( $hero_thumb ) {
							$hero_thumb = $hero_thumb[0];
						}
						else{
							$hero_thumb = plugins_url('wp2newsletter') . '/public/images/no-image.png';
						}
						$hero_code =  array('{HERO_TITLE}','{HERO_DESCRIPTION}','{HERO_IMAGE}','{HERO_LINK}');
						$hero_replace = array($hero_post->post_title,$this->wpnlc_rss_limit_words(get_post_meta($post->ID,'wpnlc_feed_description',true),50),$hero_thumb,get_permalink($hero_post->ID));
					
			$template_code_full = str_replace($hero_code,$hero_replace,$template_code_full);
			}
		if($template_type == 'normal'){
		$template_arr = explode('{POST_BLOCK}',$template_code_full);
		$template_before = $template_arr[0];
		$template_arr = explode('{/POST_BLOCK}',$template_arr[1]);
		$template_dynamic = $template_arr[0];
		$template_after = $template_arr[1];
		ob_start();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/mc-template-html.php';
		$template_dynamic_formatted = ob_get_clean();
		$feed_html = "{$template_before}{$template_dynamic_formatted}{$template_after}";
		}elseif($template_type=='rss'){
			if(!empty($pids)){
		
				$template_arr = explode('*|RSSITEMS:|*',$template_code_full);
				$template_before = $template_arr[0];
				$template_arr = explode('*|END:RSSITEMS|*',$template_arr[1]);
				$template_dynamic = $template_arr[0];
				$template_after = $template_arr[1];
				$template_dynamic_formatted = '';
				ob_start();
					require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/wpnlc_rss-template.php';
				$template_dynamic_formatted.=ob_get_clean();
				$feed_html = "{$template_before}{$template_dynamic_formatted}{$template_after}";
				$rss_codes =  array('*|RSSFEED:URL|*','*|RSSFEED:TITLE|*','*|RSSFEED:DESCRIPTION|*','*|RSSFEED:DATE|*');
				$rss_replace = array(get_the_permalink($post->ID), $post->post_title ,get_post_meta($post->ID,'wpnlc_feed_description',true),mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false));
				$feed_html = str_replace($rss_codes,$rss_replace,$feed_html);
				//$feed_html = $template_after;
				
				
				}
			}
			
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			if($preview){
					echo json_encode($feed_html);
					}else{
						if($template_type == 'normal'){
							$html = $feed_html;
							}elseif($template_type == 'rss'){
							$html = $template_code_full;
							}
						$MC = new MailChimp($apikey);
						if($wpnlc_mctid !=''){
							$result = $MC->patch('templates/'.$wpnlc_mctid,array('name'=>$template_name,'html'=>$html));
							}else{
							$result = $MC->post('templates/',array('name'=>$template_name,'html'=>$html));
							}
						if($result){
							if($result['id']){
								$output['result']='success';
								$output['message'] = 'Template Created Sucessfully !';
							}else{
								$output['result'] = 'failed';
								$output['message']= $MC->getLastError();	
							}
						}else{
								$output['result'] = 'failed';
								$output['message']= ($wpnlc_mctid !='')?'Error Updating Template':'Error Creating Template';	
							}
					echo json_encode($output);
						}
				die;
		
		die;
		}
		else{
			return $feed_html;
			}


	
}
/*
Function to return the number of posts found the the selected criteria while creating/editing the Datasource
*/
	public function wpnlc_found_post_count(){
		$feed_data_source = isset($_POST['post_type']) ? $_POST['post_type']:'post';
		$feed_category = isset($_POST['categories']) ? $_POST['categories']:'';
		$feed_type =  isset($_POST['categories']) ? $_POST['feed_type']:'';
		$feed_exclude = (!empty($_POST['excludes']))?implode(',',$_POST['excludes']):'';
		$count =  isset($_POST['categories']) ? $_POST['count']:-1;
		switch($feed_data_source){
	case 'page':
				$args = array(	'post_type'=>'page',
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'posts_per_page'=>$count,
						'post_status'=>'publish',
						'orderby'=>'',
						'order'=>''
						);
		$pids = $this->wpnlc_query_pages($args);
		break;		
	case 'product':
				$args = array(	'post_type'=>array( 'product', 'product_variation' ),
						'category'=>$feed_category,
						//'taxonomy'=>$taxonomy,
						'posts_per_page'=>$count,
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'post_status'=>'publish',
						'orderby'=>'',
						'order'=>''
						);
		$pids = $this->wpnlc_query_products($args);
		break;
		
	case 'tribe_events':
		$feed_start_date = $_POST['feed_start_date'];
		$feed_end_date = $_POST['feed_end_date'];
		$feed_event_venue= $_POST['feed_event_venue'];
		$args = array(	'post_type'=>'tribe_events',
						'category'=>$feed_category,
						//'taxonomy'=>$taxonomy,
						'posts_per_page'=>$count,
						'feed_type'=>$feed_type,
						'feed_start_date'=>$feed_start_date,
						'feed_end_date'=>$feed_end_date,
						'feed_event_venue'=>$feed_event_venue,
						'exclude'=>$feed_exclude,
						'post_status'=>'publish',
						'orderby'=>'',
						'order'=>''
						);
												
		$pids = $this->wpnlc_query_events($args);
		break;
	case 'shop_coupon':
		$args = array(
						'post_type'=>'shop_coupon',
						'feed_type'=>$feed_type,
						'posts_per_page'=>$count,
						'post_status'=>'publish',
						'orderby'=>'',
						'order'=>''
						);
		$pids = $this->wpnlc_query_coupons($args);
		break;
	case 'include_ids':
		$args = array(	'include_ids' =>$feed_include
						);
		$pids = $this->wpnlc_query_list_ids($args);
	break;
	default:
		$args = array(	'post_type'=>$feed_data_source,
						'category'=>$feed_category,
						//'taxonomy'=>$taxonomy,
						'posts_per_page'=>$count,
						'feed_type'=>$feed_type,
						'exclude'=>$feed_exclude,
						'post_status'=>'publish',
						'orderby'=>'',
						'order'=>''
						);
		$pids = $this->wpnlc_query_posts($args);
		break;
		

	}
echo json_encode(count($pids));die;
		}
/**
*Function to get the Mailchimp template id for selected template while generating or updating the template
*/		
public function wpnlc_get_mc_template_id(){
	$template = get_post($_POST['template']);
	$mc_temp_id = get_post_meta($template->ID,'wpnlc_template_id',true);
	
	if($mc_temp_id){
	$apikey = get_option('wpnlc_mailchimp_api_key',false);
	$MC = new MailChimp($apikey);
	$template = $MC->get('templates/'.$mc_temp_id,array('type'=>'user'));
	if($template['id']){
		echo $mc_temp_id;
		}else{
		echo false;	
			}		
		}
	die;
	}

/**
*Function to lookup title for auto suggest input field, hero post, includes and excludes input fields in datasource setup and creation page.
*
*/
public function search_post_ajax(){
	
	global $wpdb;
    $search = like_escape($_POST['search_title']);
	$post_type = ($_POST['post_type'])?$_POST['post_type']:'post';
    $query = 'SELECT ID,post_title FROM ' . $wpdb->posts . '
        WHERE post_title LIKE \'' . $search . '%\'
        AND post_status = \'publish\'';
		if($post_type != 'include_ids'){
			$query .='AND post_type =\''.$post_type.'\'';
			}
        $query.='ORDER BY post_title ASC';
    $result=array();
	foreach ($wpdb->get_results($query) as $row) {
        $result[]=array('pid'=>$row->ID,'title'=>$row->post_title);
    }
	echo json_encode($result);
    die();
	}
/*
Function to return the templates based on type supplied (either normal or rss)
*/	


/*
public function get_templates_by_type(){
	$type = $_POST['template_type'];
		$args =array(
				'post_type'=>'wpnlc_template',
				'posts_per_page'=>'-1',
				'meta_query' => array( 
									array(
										'key' => 'wpnlc_template_type',
         								'value' => $type,
										)
								)
			);
			$the_query = new WP_Query( $args );
			ob_start();?>
			<?php 
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
				$the_query->the_post();?>
					   <li class="select_template_thumb" tid="<?php echo get_the_ID()?>">
					  <div class="template_thumb_img"> <?php echo get_the_post_thumbnail(get_the_ID(),array(100,150)) ?></div>
                       <br /><span><?php the_title()?></span>
                       </li>
			<?php 
				} 
			}
			?>
			<?php	
			$output = ob_get_clean();
 
		echo json_encode($output);
		die;
	}

*/
	


/*
Function to limit the words for given string
*/	
	public function wpnlc_rss_limit_words($text,$limit){
		  if (str_word_count($text, 0) > $limit) {
			  $words = str_word_count($text, 2);
			  $pos = array_keys($words);
			  $text = substr($text, 0, $pos[$limit]) . '...';
		  }
		  return $text;

	}

/*
Function to get the metavalue for the special keys given in templates that are not availiable in the specific post rather to be pulled based on the key provied
*/	public function wpnlc_get_special_metavalue($main_plugin,$post_id,$metakey){
		switch($main_plugin){
			case 'tribe':
			if ( ! class_exists( 'Tribe__Events__Main' ) ) {
				return 'Tribe Events Plugin not installed';
				}
				list($type, $key) = explode('-', $metakey, 2);
				switch ($type){
					case 'venue':
					$venue = get_post_meta($post_id,'_EventVenueID',true);
					if($venue){
						return get_post_meta($venue->ID,$key,true);
						}
					break;
					default:
					return 'The key'.$metakey.' is not yet supported';
					}
			break;
			case 'woo':
			if(!class_exists('WooCommerce')){
				return 'Woocommerce not installed';
				}
			list($type, $key) = explode('-', $metakey, 2);
	switch($type){
					case 'product':
						switch($key){
							case 'price':
								$pf = new WC_Product_Factory();
								$product = $pf->get_product($post_id);
								if($product->sale_price !=$product->regular_price && $product->sale_price !=0){
									return '<span class="price special"> $'.$product->regular_price.'</span> Now <span class="price">$'.$product->sale_price.'</span>';
									}else{
										return '<span class="price">From $'.$product->price.'</span>';
										}
							default:
							$metavalue = get_post_meta($post_id,$key,true);
							return $metavalue;
							}
					default:
					return '';
					}
				
			default:
			return 'Key'.$metakey.' is not yet supported';
			}
		}	
	
/*
Function to return the ids of posts found for given query arguments
*/	
	public function wpnlc_query_posts($atts){
		$args = array(
						'post_type'=>(isset($atts['post_type']))?$atts['post_type']:'post',
						'orderby'=>(isset($atts['orderby']))?$atts['orderby']:'',
						'order'=>(isset($atts['order']))?$atts['order']:'ASC',
						'post_status'=>(isset($atts['post_status']))?$atts['post_status']:'publish',
			 	);
		$feed_exclude = isset($atts['exclude'])?$atts['exclude']:'';
		if($feed_exclude != ''){
			$feed_exclude_ids = explode(',',$feed_exclude);
		}else{
			$feed_exclude_ids = array();
			}
		 if(!empty($atts['category'])){
			 $args['tax_query'] = array('relation' => 'OR',);
			 foreach($atts['category'] as $cat){
				$taxs = explode(':', $cat);
				$args['tax_query'][] = array(
									 'taxonomy' => $taxs[0],
									 'field'    => 'term_id',
									 'terms'    => $taxs[1],
										);	 
			}
 		}
		if($atts['posts_per_page'] !=''){
			$args['posts_per_page']=$atts['posts_per_page'];
		}
		if($atts['feed_type'] == 'sticky'){
			$arr1 = get_option('sticky_posts');
			$arr2 = $feed_exclude_ids;
			$pids = array_diff($arr1,$arr2);
			$args['post__in'] = $pids;//get_option('sticky_posts');
			}else{
				$args['post__not_in'] = $feed_exclude_ids;
				}
		$the_query = new WP_Query( $args );
		$post_ids = array();
		if ( $the_query->have_posts() ){
			while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$post_ids[get_the_ID()]=get_the_ID();
		}
			wp_reset_postdata();
			
		}
		return $post_ids;
	}
/*
Function to return the ids of Pages found for given query arguments
*/	
	public function wpnlc_query_pages($atts){
		$args = array(
					'post_type'=>(isset($atts['post_type']))?$atts['post_type']:'post',
					'orderby'=>(isset($atts['orderby']))?$atts['orderby']:'',
					'order'=>(isset($atts['order']))?$atts['order']:'ASC',
					'post_status'=>(isset($atts['post_status']))?$atts['post_status']:'publish',
			);
		$feed_exclude = isset($atts['exclude'])?$atts['exclude']:'';
		if($feed_exclude != ''){
			$feed_exclude_ids = explode(',',$feed_exclude);
			$args['post__not_in'] = $feed_exclude_ids;
		}
		if($atts['posts_per_page'] !=''){
			$args['posts_per_page']=$atts['posts_per_page'];
		}
		$the_query = new WP_Query( $args );
		$post_ids = array();
		if ( $the_query->have_posts() ){
			while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$post_ids[get_the_ID()]=get_the_ID();
		}
			wp_reset_postdata();
			
		}
		return $post_ids;
	}
/*
Function to return the ids of woocommerce products found for given query arguments
*/	
	public function wpnlc_query_products($atts){
		$exclude = explode(',',$atts['exclude']);
		$cats =$atts['category'];
		$type = $atts['feed_type'];
		$count = $atts['posts_per_page'];
		

 // The Query
 $featured_product_ids = array();
 
 $args = array(
  'post_type'      => 'product',
  'posts_per_page' => $count,
  'post_status'=>$atts['post_status'],
  'fields' => 'id=>parent',
  'orderby' => $atts['orderby'],
  'order' => $atts['order'],
 );
 if('sticky' != $type){
  $args['post__not_in'] = $exclude;
 }
 if(!empty($cats)){
	 $args['tax_query'] = array('relation' => 'OR',);
	 foreach($cats as $cat){
		$taxs = explode(':', $cat);
		$args['tax_query'][] = array(
							 'taxonomy' => $taxs[0],
							 'field'    => 'term_id',
							 'terms'    => $taxs[1],
								);	 
	}
 }
 if('topseller' == $type){
  $args['meta_key'] = 'total_sales';
  $args['orderby'] = 'meta_value_num';
  
 } else if('featured' == $type){
  $args['meta_query'] = array(
        array(
         'key'   => '_visibility',
         'value'  => array('catalog', 'visible'),
         'compare'  => 'IN'
        ),
        array(
         'key'  => '_featured',
         'value' => 'yes'
        )
       );
 } else if('promotions' == $type){
  $args['meta_query'] = array(
        'relation' => 'OR',
        array( // Simple products type
         'key'           => '_sale_price',
         'value'         => 0,
         'compare'       => '>',
         'type'          => 'numeric'
        ),
        array( // Variable products type
         'key'           => '_min_variation_sale_price',
         'value'         => 0,
         'compare'       => '>',
         'type'          => 'numeric'
        )
       );
 } else if('sticky' == $type){
  $sticky = get_option('sticky_posts');
  $sticky = array_diff($sticky, $exclude);
  $args['post__in'] = $sticky;
  
 }
 $the_query = new WP_Query( $args );
 // The Loop
 if ( $the_query->have_posts() ) {
  while ( $the_query->have_posts() ) {
   $the_query->the_post();
   $featured_product_ids[] = get_the_ID();
  }
 } 
 /* Restore original Post Data */
 wp_reset_postdata();
if('topfreebies'== $type){
$freebies = $this->wpnlc_get_order_report_data( array(
					'data' => array(
						'_product_id' => array(
							'type'            => 'order_item_meta',
							'order_item_type' => 'line_item',
							'function'        => '',
							'name'            => 'product_id'
						),
						'_qty' => array(
							'type'            => 'order_item_meta',
							'order_item_type' => 'line_item',
							'function'        => 'SUM',
							'name'            => 'order_item_qty'
						)
					),
					'where_meta'   => array(
						array(
							'type'       => 'order_item_meta',
							'meta_key'   => '_line_subtotal',
							'meta_value' => '0',
							'operator'   => '='
						)
					),
					'order_by'     => 'order_item_qty DESC',
					'group_by'     => 'product_id',
					'limit'        => ($count >0)?$count:10,
					'query_type'   => 'get_results',
					'filter_range' => true,
					'order_types'  => wc_get_order_types( 'order-count' ),
					'nocache' => true
				) );
if($freebies){
	foreach($freebies as $free){
		$featured_product_ids[] = $free->ID;
		}
	}
}
				
 //set_transient( 'wc_featured_products', $featured_product_ids );
 return $featured_product_ids;
 }
/*
Function to return the ids of events found for given query arguments
*/	
	public function wpnlc_query_events($atts){
		$args = array(
						'post_type'=>$atts['post_type'],
						'orderby' => $atts['orderby'],
						'order' => $atts['order'],
						'post_status'=>$atts['post_status'],
		);
		$feed_exclude = $atts['exclude'];
		if($feed_exclude != ''){
			$feed_exclude_ids = explode(',',$feed_exclude);
			$args['post__not_in'] = $feed_exclude_ids;
		}
		 if(!empty($atts['category'])){
			 $args['tax_query'] = array('relation' => 'OR',);
			 foreach($atts['category'] as $cat){
				$taxs = explode(':', $cat);
				$args['tax_query'][] = array(
									 'taxonomy' => $taxs[0],
									 'field'    => 'term_id',
									 'terms'    => $taxs[1],
										);	 
			}
		 }
 		if($atts['posts_per_page'] !=''){
			$args['posts_per_page']=$atts['posts_per_page'];
		}
		if($atts['feed_type'] == 'upcomming'){
			$args['start_date'] = $atts['start_date'];
			}
		if($atts['feed_type'] == 'thismonth'){
			$args['start_date'] = strtotime('first day of this month');
			$args['start_date'] = strtotime('last day of this month');
			}
		if($atts['feed_type'] == 'thisweek'){
			$args['start_date'] = strtotime('monday this week');
			$args['start_date'] = strtotime('sunday this week');
			}
		if($atts['feed_type'] == 'locationss'){
			$args['meta_query'] = array(
										array(
										 'key' => '_EventVenueID',
										 'value' => $atts['feed_event_venue'],
									   )
									);
			}
		$event_feeds = tribe_get_events($args);
		$post_ids = array();
		if($event_feeds){
			foreach($event_feeds as $feed){
				$post_ids[get_the_ID()]=$feed->ID;
				}
			}
		wp_reset_postdata();
		return $post_ids;
		}
	public function wpnlc_query_list_ids($atts){
		$includes = $atts['include_ids'];
		$posts = get_posts(array('include'=>$includes));
		}
/*
Function to return the ids of counpons found for given query arguments
*/	
	public function wpnlc_query_coupons($atts){
		$post_ids = array();
		$args = array(
						'post_type'=>'shop_coupon',
						'feed_type'=>$feed_type,
						'posts_per_page'=>$feed_number,
						'post_status'=>$atts['post_status'],
						);
						
		$args = array(
						'post_type'=>$atts['post_type'],
		);
		$feed_exclude = $atts['exclude'];
		if($feed_exclude != ''){
			$feed_exclude_ids = explode(',',$feed_exclude);
		}
		if($atts['posts_per_page'] !=''){
			$args['posts_per_page']=$atts['posts_per_page'];
		}
		
		if($atts['feed_type'] == 'popular'){
			$args['meta_query'] = array(
										array(
										 'key' => '',
										 'value' => '',
									   )
									);
			}
		return $post_ids;				
		}
	
	public function wpnlc_get_order_report_data( $args = array() ) {
		$start_date = strtotime( date( 'Y-01-01', current_time('timestamp') ) );
		$end_date = strtotime( 'midnight', current_time( 'timestamp' ) );
		global $wpdb;
		$default_args = array(
			'data'                => array(),
			'where'               => array(),
			'where_meta'          => array(),
			'query_type'          => 'get_row',
			'group_by'            => '',
			'order_by'            => '',
			'limit'               => '',
			'filter_range'        => false,
			'nocache'             => false,
			'debug'               => false,
			'order_types'         => wc_get_order_types( 'reports' ),
			'order_status'        => array( 'completed', 'processing', 'on-hold' ),
			'parent_order_status' => false,
		);
		$args = apply_filters( 'woocommerce_reports_get_order_report_data_args', $args );
		$args = wp_parse_args( $args, $default_args );

		extract( $args );

		if ( empty( $data ) ) {
			return '';
		}

		$order_status = apply_filters( 'woocommerce_reports_order_statuses', $order_status );

		$query  = array();
		$select = array();

		foreach ( $data as $key => $value ) {
			$distinct = '';

			if ( isset( $value['distinct'] ) ) {
				$distinct = 'DISTINCT';
			}

			switch ( $value['type'] ) {
				case 'meta' :
					$get_key = "meta_{$key}.meta_value";
					break;
				case 'parent_meta' :
					$get_key = "parent_meta_{$key}.meta_value";
					break;
				case 'post_data' :
					$get_key = "posts.{$key}";
					break;
				case 'order_item_meta' :
					$get_key = "order_item_meta_{$key}.meta_value";
					break;
				case 'order_item' :
					$get_key = "order_items.{$key}";
					break;
				default :
					continue;
			}

			if ( $value['function'] ) {
				$get = "{$value['function']}({$distinct} {$get_key})";
			} else {
				$get = "{$distinct} {$get_key}";
			}

			$select[] = "{$get} as {$value['name']}";
		}

		$query['select'] = "SELECT " . implode( ',', $select );
		$query['from']   = "FROM {$wpdb->posts} AS posts";

		// Joins
		$joins = array();

		foreach ( ( $data + $where ) as $key => $value ) {
			$join_type = isset( $value['join_type'] ) ? $value['join_type'] : 'INNER';
			$type      = isset( $value['type'] ) ? $value['type'] : false;

			switch ( $type ) {
				case 'meta' :
					$joins["meta_{$key}"] = "{$join_type} JOIN {$wpdb->postmeta} AS meta_{$key} ON ( posts.ID = meta_{$key}.post_id AND meta_{$key}.meta_key = '{$key}' )";
					break;
				case 'parent_meta' :
					$joins["parent_meta_{$key}"] = "{$join_type} JOIN {$wpdb->postmeta} AS parent_meta_{$key} ON (posts.post_parent = parent_meta_{$key}.post_id) AND (parent_meta_{$key}.meta_key = '{$key}')";
					break;
				case 'order_item_meta' :
					$joins["order_items"] = "{$join_type} JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON (posts.ID = order_items.order_id)";

					if ( ! empty( $value['order_item_type'] ) ) {
						$joins["order_items"] .= " AND (order_items.order_item_type = '{$value['order_item_type']}')";
					}

					$joins["order_item_meta_{$key}"]  = "{$join_type} JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta_{$key} ON " .
														"(order_items.order_item_id = order_item_meta_{$key}.order_item_id) " .
														" AND (order_item_meta_{$key}.meta_key = '{$key}')";
					break;
				case 'order_item' :
					$joins["order_items"] = "{$join_type} JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON posts.ID = order_items.order_id";
					break;
			}
		}

		if ( ! empty( $where_meta ) ) {
			foreach ( $where_meta as $value ) {
				if ( ! is_array( $value ) ) {
					continue;
				}
				$join_type = isset( $value['join_type'] ) ? $value['join_type'] : 'INNER';
				$type      = isset( $value['type'] ) ? $value['type'] : false;
				$key       = is_array( $value['meta_key'] ) ? $value['meta_key'][0] . '_array' : $value['meta_key'];

				if ( 'order_item_meta' === $type ) {

					$joins["order_items"] = "{$join_type} JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON posts.ID = order_items.order_id";
					$joins["order_item_meta_{$key}"] = "{$join_type} JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta_{$key} ON order_items.order_item_id = order_item_meta_{$key}.order_item_id";

				} else {
					// If we have a where clause for meta, join the postmeta table
					$joins["meta_{$key}"] = "{$join_type} JOIN {$wpdb->postmeta} AS meta_{$key} ON posts.ID = meta_{$key}.post_id";
				}
			}
		}

		if ( ! empty( $parent_order_status ) ) {
			$joins["parent"] = "LEFT JOIN {$wpdb->posts} AS parent ON posts.post_parent = parent.ID";
		}

		$query['join'] = implode( ' ', $joins );

		$query['where']  = "
			WHERE 	posts.post_type 	IN ( '" . implode( "','", $order_types ) . "' )
			";

		if ( ! empty( $order_status ) ) {
			$query['where'] .= "
				AND 	posts.post_status 	IN ( 'wc-" . implode( "','wc-", $order_status ) . "')
			";
		}

		if ( ! empty( $parent_order_status ) ) {
			if ( ! empty( $order_status ) ) {
				$query['where'] .= " AND ( parent.post_status IN ( 'wc-" . implode( "','wc-", $parent_order_status ) . "') OR parent.ID IS NULL ) ";
			} else {
				$query['where'] .= " AND parent.post_status IN ( 'wc-" . implode( "','wc-", $parent_order_status ) . "') ";
			}
		}

		if ( $filter_range ) {

			$query['where'] .= "
				AND 	posts.post_date >= '" . date('Y-m-d', $start_date ) . "'
				AND 	posts.post_date < '" . date('Y-m-d', $end_date ) . "'
			";
		}


		if ( ! empty( $where_meta ) ) {

			$relation = isset( $where_meta['relation'] ) ? $where_meta['relation'] : 'AND';

			$query['where'] .= " AND (";

			foreach ( $where_meta as $index => $value ) {

				if ( ! is_array( $value ) ) {
					continue;
				}

				$key = is_array( $value['meta_key'] ) ? $value['meta_key'][0] . '_array' : $value['meta_key'];

				if ( strtolower( $value['operator'] ) == 'in' ) {

					if ( is_array( $value['meta_value'] ) ) {
						$value['meta_value'] = implode( "','", $value['meta_value'] );
					}

					if ( ! empty( $value['meta_value'] ) ) {
						$where_value = "IN ('{$value['meta_value']}')";
					}
				} else {
					$where_value = "{$value['operator']} '{$value['meta_value']}'";
				}

				if ( ! empty( $where_value ) ) {
					if ( $index > 0 ) {
						$query['where'] .= ' ' . $relation;
					}

					if ( isset( $value['type'] ) && $value['type'] == 'order_item_meta' ) {

						if ( is_array( $value['meta_key'] ) ) {
							$query['where'] .= " ( order_item_meta_{$key}.meta_key   IN ('" . implode( "','", $value['meta_key'] ) . "')";
						} else {
							$query['where'] .= " ( order_item_meta_{$key}.meta_key   = '{$value['meta_key']}'";
						}

						$query['where'] .= " AND order_item_meta_{$key}.meta_value {$where_value} )";
					} else {

						if ( is_array( $value['meta_key'] ) ) {
							$query['where'] .= " ( meta_{$key}.meta_key   IN ('" . implode( "','", $value['meta_key'] ) . "')";
						} else {
							$query['where'] .= " ( meta_{$key}.meta_key   = '{$value['meta_key']}'";
						}

						$query['where'] .= " AND meta_{$key}.meta_value {$where_value} )";
					}
				}
			}

			$query['where'] .= ")";
		}

		if ( ! empty( $where ) ) {

			foreach ( $where as $value ) {

				if ( strtolower( $value['operator'] ) == 'in' ) {

					if ( is_array( $value['value'] ) ) {
						$value['value'] = implode( "','", $value['value'] );
					}

					if ( ! empty( $value['value'] ) ) {
						$where_value = "IN ('{$value['value']}')";
					}
				} else {
					$where_value = "{$value['operator']} '{$value['value']}'";
				}

				if ( ! empty( $where_value ) )
					$query['where'] .= " AND {$value['key']} {$where_value}";
			}
		}

		if ( $group_by ) {
			$query['group_by'] = "GROUP BY {$group_by}";
		}

		if ( $order_by ) {
			$query['order_by'] = "ORDER BY {$order_by}";
		}

		if ( $limit ) {
			$query['limit'] = "LIMIT {$limit}";
		}

		$query          = apply_filters( 'woocommerce_reports_get_order_report_query', $query );
		$query          = implode( ' ', $query );
		$query_hash     = md5( $query_type . $query );
		$cached_results = get_transient( strtolower( get_class( $this ) ) );

		if ( $debug ) {
			echo '<pre>';
			print_r( $query );
			echo '</pre>';
		}

		if ( $debug || $nocache || false === $cached_results || ! isset( $cached_results[ $query_hash ] ) ) {
			// Enable big selects for reports
			$wpdb->query( 'SET SESSION SQL_BIG_SELECTS=1' );
			$cached_results[ $query_hash ] = apply_filters( 'woocommerce_reports_get_order_report_data', $wpdb->$query_type( $query ), $data );
			set_transient( strtolower( get_class( $this ) ), $cached_results, DAY_IN_SECONDS );
		}

		$result = $cached_results[ $query_hash ];

		return $result;
	}
}
