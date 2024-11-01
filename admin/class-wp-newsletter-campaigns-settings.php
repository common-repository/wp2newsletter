<?php
if(!class_exists('WpNewsletter_Campaign_Settings'))
{
	class WpNewsletter_Campaign_Settings
	{
		/**
		 * Construct the plugin object
		 */
		function __construct()
		{
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
		} // END public function __construct
		
        /**
         * hook into WP's admin_init action hook
		 * @since  1.0.0
		 * @access public
		 * @return void
         */
        public function admin_init()
        {
        } // END public static function activate
        

        
        /**
         * add a menu
		 * @since  1.0.0
		 * @access public
		 * @return void
         */		
        public function add_menu()
        {
           add_submenu_page(
			'edit.php?post_type=wpnlc',
			'WP Newsletter Campaigns Settings', /*page title*/
			'Settings', /*menu title*/
			'manage_options', /*roles and capabiliyt needed*/
			'wpnlc_setting',
			 array(&$this, 'wpnlc_settings')
		);
           
		   add_submenu_page(
			'edit.php?post_type=wpnlc',
			'Generate Newsletter', /*page title*/
			'Generate Newsletter', /*menu title*/
			'manage_options', /*roles and capabiliyt needed*/
			'wpnlc_template_generator',
			 array(&$this, 'wpnlc_template_generator')
		);

      } // END public function add_menu()
    
        /**
         * Menu Callback
		 * @since  1.0.0
		 * @access public
		 * @return void
         */		
        public function wpnlc_settings()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.' , 'wp_mediacenter'));
        	}
	      	$apikey = get_option('wpnlc_mailchimp_api_key','');
			if($apikey){
				$MC = new MailChimp($apikey);
				$response = $MC->get('',array('user'=>$apikey));
				if(isset($response['account_id'])){
				$status['status'] = true;
				}else{
					$status['status'] = false;
					$status['detail']= $response['title'].': '.$response['detail'];
					}
				}else{
					$status['status'] = false;
					$status['detail'] = 'API Key no Found';
					}
			
			include dirname( __FILE__ ).'/partials/wp-newsletter-campaigns-settings.php';

        } // END public function wpnlc_settings()
        /**
         * Menu Callback
		 * @since  1.0.0
		 * @access public
		 * @return void
         */		
        public function wpnlc_template_generator()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.' , 'wp_mediacenter'));
        	}
	      	
			include dirname( __FILE__ ).'/partials/wpnlc-template-generator.php';

        } // END public function wpnlc_settings()
		
	
    } // END class WpNewsletter_Campaign_Settings
} // END if(!class_exists('WpNewsletter_Campaign_Settings'))
