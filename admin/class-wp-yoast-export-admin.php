<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sabinico.com
 * @since      1.0.0
 *
 * @package    Wp_Yoast_Export
 * @subpackage Wp_Yoast_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Yoast_Export
 * @subpackage Wp_Yoast_Export/admin
 * @author     Sabinico <sabinico@gmail.com>
 */
class Wp_Yoast_Export_Admin {

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
		 * defined in Wp_Yoast_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Yoast_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-yoast-export-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Yoast_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Yoast_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-yoast-export-admin.js', array( 'jquery' ), $this->version, false );

	}

		/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */
	    add_options_page( 'WP Yoast Export Config', 'WP Yoast Export', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {

	    include_once( 'partials/wp-yoast-export-admin-display.php' );
			if(isset($_REQUEST['export'])){
				$export = (isset($_REQUEST['specific'])) ? $this->export_metadata_yoast($_REQUEST['specific']) : $this->export_metadata_yoast();
				include_once( 'partials/wp-yoast-export-admin-table.php' );
			}
	}

	/**
	 * Validator the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function validate($input) {
    // All checkboxes inputs
    $valid = array();

    //Cleanup
    $valid['count_key'] = (isset($input['count_key']) && !empty($input['count_key'])) ? 1 : 0;
    $valid['remove_html'] = (isset($input['remove_html']) && !empty($input['remove_html'])) ? 1: 0;
    $valid['include_img_key'] = (isset($input['include_img_key']) && !empty($input['include_img_key'])) ? 1 : 0;

    return $valid;
 }

 public function options_update() {
    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 }


	/**
	 * Export the request data.
	 *
	 * @since    1.0.0
	 */

	public function export_metadata_yoast($specific = null) {

			global $wpdb;
			$options = get_option($this->plugin_name);

			//posts
			$posts = array();
			if($specific != null){
				$sql = "SELECT ID, post_title, post_content, post_author, post_date, guid FROM $wpdb->posts WHERE ID = '".$specific."'";
			}else{
				$sql = "SELECT ID, post_title, post_content, post_author, post_date, guid FROM $wpdb->posts WHERE post_status = 'publish'";
			}

			$results = $wpdb->get_results($sql);
			foreach($results as $post){
				$yoast_kw_query = $wpdb->get_results("SELECT metadata.meta_value FROM $wpdb->postmeta metadata WHERE metadata.post_id = $post->ID AND metadata.meta_key = '_yoast_wpseo_focuskw'");
				$yoast_kw = (count($yoast_kw_query) > 0) ? $yoast_kw_query[0]->meta_value : 'undefined';
				if($options['count_key']){
					$post->yoast_kw_count = substr_count(strtolower(strip_tags($post->post_content)),strtolower($yoast_kw));
				}
				$post->yoast_kw = $yoast_kw;

				$score_content_query = $wpdb->get_results("SELECT metadata.meta_value FROM $wpdb->postmeta metadata WHERE metadata.post_id = $post->ID AND metadata.meta_key = '_yoast_wpseo_content_score'");
				$score_content = (count($score_content_query) > 0) ? $score_content_query[0]->meta_value : 0;
				$post->score_content = $score_content;

				$score_legi_query = $wpdb->get_results("SELECT metadata.meta_value FROM $wpdb->postmeta metadata WHERE metadata.post_id = $post->ID AND metadata.meta_key = '_yoast_wpseo_linkdex'");
				$score_legi = (count($score_legi_query) > 0) ? $score_legi_query[0]->meta_value : 0;
				$post->score_legi = $score_legi;

				$post->words_count = ($options['remove_html']) ? str_word_count(strip_tags($post->post_content)) : str_word_count($post->post_content);
				$content_without_bb = preg_replace('#\[[^\]]+\]#', '', $post->post_content);
				$post->content_without_bb = $content_without_bb;
				if($specific != null){
					file_put_contents('chafer_bbcode_test.txt', $content_without_bb);
				}
				$post->words_count_2 = ($options['remove_html']) ? str_word_count(strip_tags($content_without_bb)) : str_word_count($content_without_bb);

				$posts[] = $post;
			}

			//print '<pre>'.print_r($posts, true).'</pre>';
			return $posts;
	}

}
