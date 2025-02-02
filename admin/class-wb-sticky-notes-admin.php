<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/plugins/wb-sticky-notes
 * @since      1.0.0
 *
 * @package    Wb_Sticky_Notes
 * @subpackage Wb_Sticky_Notes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wb_Sticky_Notes
 * @subpackage Wb_Sticky_Notes/admin
 * @author     Web Builder 143 
 */
class Wb_Sticky_Notes_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wb-sticky-notes-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		$settings=Wb_Sticky_Notes::get_settings();
		$wb_stn_data=array(
			'nonces' => array(
	            'main'=>wp_create_nonce($this->plugin_name),
	        ),
	        'ajax_url' => admin_url('admin-ajax.php'),
	        'wb_stn_plugin_url' => WB_STN_PLUGIN_URL,
	        'labels'=>array(
	        	'areyousure'=>__('Are you sure you want to delete this?', 'wb-sticky-notes'),
	        	'no_data_to_display' => __("No data to display", "wb-sticky-notes"),
		    )
		);		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wb-sticky-notes-admin.js', array( 'jquery','jquery-ui-draggable','jquery-ui-resizable'), $this->version, false );
		wp_localize_script($this->plugin_name,'wb_stn_data',$wb_stn_data);
	}

	/**
	 * Plugin action links
	 *
	 * @since    1.0.0
	 */
	public function plugin_action_links($links)
	{
		$links[]='<a href="'.admin_url('tools.php?page=wb-sticky-notes').'">'.__('Settings', 'wb-sticky-notes').'</a>';
		return $links;
	}

	/**
	 * Admin menu
	 *
	 * @since    1.0.0
	 */
	public function admin_menu()
	{
		add_management_page(
			__('Sticky Notes', 'wb-sticky-notes'),
			__('Sticky Notes', 'wb-sticky-notes'),
			'edit_posts',
			'wb-sticky-notes',
			array($this,'settings_page')
		);
	}

	/**
	 * Drop down menu in admin bar
	 *
	 * @since    1.0.0
	 */
	public function admin_bar_menu()
	{
		global $wp_admin_bar;
		$the_settings=Wb_Sticky_Notes::get_settings();
		$menu_id='wb_stn_admin_bar_menu';
		$wp_admin_bar->add_menu(array(
			'id'=>$menu_id,
			'title'=>'<span class="ab-icon"></span>'.__('Sticky notes', 'wb-sticky-notes'),
		   )
		);
		if($the_settings['enable']==1)
		{
			$wp_admin_bar->add_menu(array(
				'parent' => $menu_id, 
				'title' => __('New', 'wb-sticky-notes'), 
				'id' =>$menu_id.'_new',
				'meta' =>array('class'=>'wb_stn_new'),
				)
			);
			$wp_admin_bar->add_menu(array(
				'parent' => $menu_id, 
				'title' => __('Show/Hide', 'wb-sticky-notes'), 
				'id' =>$menu_id.'_toggle',
				'meta' =>array('class'=>'wb_stn_toggle'),
				)
			);
		}

		/**
		 * 	Archives menu
		 * 	@since 1.1.1
		 */
		$wp_admin_bar->add_menu(array(
			'parent' => $menu_id, 
			'title' => __('Archives', 'wb-sticky-notes'), 
			'id' =>$menu_id.'_archives', 
			'href' =>admin_url('tools.php?page=wb-sticky-notes&wb_stn_tab=archives'),
			)
		);

		if(current_user_can('manage_options'))
		{
			$wp_admin_bar->add_menu(array(
				'parent' => $menu_id, 
				'title' => __('Settings', 'wb-sticky-notes'), 
				'id' =>$menu_id.'_settings', 
				'href' =>admin_url('tools.php?page=wb-sticky-notes'),
				)
			);
		}

		$wp_admin_bar->add_menu(array(
			'parent' => $menu_id, 
			'title' => __('Rate us', 'wb-sticky-notes').' ⭐️⭐️⭐️⭐️⭐️', 
			'id' =>$menu_id.'_rate_us', 
			'href' => 'https://wordpress.org/support/plugin/wb-sticky-notes/reviews/?rate=5#new-post',
			)
		);
	}

	/**
	 * Settings page
	 *
	 * @since    1.0.0
	 */
	public function settings_page()
	{
		$allowed_tabs = array('settings', 'archives');
		$tab = isset($_GET['wb_stn_tab']) ? sanitize_text_field($_GET['wb_stn_tab']) : 'settings';
		$tab = !in_array($tab, $allowed_tabs) ? 'settings' : $tab;

		// Show archive page for non admins
		if ('settings' === $tab && !current_user_can('manage_options')) 
		{
		    $tab = 'archives';
		}

		// Get options:
    	$the_settings=Wb_Sticky_Notes::get_settings();
    	if(isset($_POST['wb_stn_update_settings']))
    	{
    		// Check nonce
	        check_admin_referer(WB_STN_SETTINGS);
	        foreach($the_settings as $key => $value) 
	        {
	            if(isset($_POST['wb_stn'][$key])) 
	            {
	                $the_settings[$key]=$this->sanitize_settings($_POST['wb_stn'][$key],$key);

	                if ( 'role_name'=== $key && ! in_array( 'administrator', $the_settings[$key] ) ){
	                	$the_settings[$key][] = 'administrator'; // Always enabled for admin
	                }
	            }else{

	            	if ( 'role_name'=== $key ) {
	            		$the_settings[ $key ] = array( 'administrator' );
	            	}
	            }
	        }
	        Wb_Sticky_Notes::update_settings($the_settings);
	        wp_redirect(admin_url('tools.php?page=wb-sticky-notes&wb-suss=1'));
	        exit();
    	}
		require_once plugin_dir_path( __FILE__ ).'partials/wb-sticky-notes-admin-display.php';
	}

	/**
	 * Sanitize settings values
	 *
	 * @since    1.0.0
	 * @param    $value settings value
	 * @param    $key settings key in POST array
	 */
	private function sanitize_settings($value,$key)
	{
		$out=0;
		switch ($key)
		{
			case 'enable':
			case 'floating_button':
			case 'theme':
			case 'font_family':
			case 'font_size':
			case 'z_index':
			case 'width':
			case 'height':
			case 'postop':
			case 'posleft':
				$out=(int) $value;
				break;
			case 'role_name': 
				$out = array_map('sanitize_text_field', $value);
				break;
			default:
				$out=(int) $value;
				break;
		}
		return $out;
	}
}
