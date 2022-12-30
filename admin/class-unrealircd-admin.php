<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/ValwareIRC
 * @since      1.0.0
 *
 * @package    Unrealircd
 * @subpackage Unrealircd/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Unrealircd
 * @subpackage Unrealircd/admin
 * @author     Valware <v.a.pond@outlook.com>
 */
class Unrealircd_Admin {

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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Unrealircd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Unrealircd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/unrealircd-admin.css', array(), $this->version, 'all' );

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
		 * defined in Unrealircd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Unrealircd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/unrealircd-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function settings_link($links)
	{
		$link = '<a href="admin.php?page=dalek">Main</a>';
		array_push($links, $link);
		return $links;
	}
	public function add_admin_pages()
	{
		add_menu_page('IRC Overview', 'UnrealIRCd Panel', 'manage_options', 'unreal_plugin', [$this, 'irc_overview'], 'dashicons-rest-api', 10);
		add_submenu_page('unreal_plugin', 'Users', 'Users', 'manage_options', 'unreal_users', [$this, 'users_view']);
		add_submenu_page('unreal_plugin', 'Channels', 'Channels', 'manage_options', 'unreal_channels', [$this, 'test']);
		add_submenu_page('unreal_plugin', 'Server Bans', 'Server Bans', 'manage_options', 'unreal_serverbans', [$this, 'test']);
		add_submenu_page('unreal_plugin', 'Spamfilter', 'Spamfilter', 'manage_options', 'unreal_spamfilter', [$this, 'test']);
		
	}
	public function add_widget()
	{
	}
	public function irc_overview()
	{
		require_once plugin_dir_path(__FILE__).'partials/unrealircd-admin-display.php';
	}
	public function users_view()
	{
		require_once plugin_dir_path(__FILE__).'partials/unrealircd-admin-users.php';
	}

	public static function test()
	{
		echo "You what lad";
	}
}
