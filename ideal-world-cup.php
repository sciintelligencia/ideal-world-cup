<?php
/**
 * Plugin Name: Ideal World Cup
 * Plugin URI: https://www.scintelligencia.com/
 * Description: Its a game in which you can insert images and select images to show on frontend. It will show images in pairs.
 * Version: 1.0
 * Author: SCI Intelligencia
 * Author URI: https://www.scintelligencia.com/
 * Author Email: sciintelligencia@gmail.com
 * Requires at least: WP 4.8
 * Tested up to: WP 5.6
 * Text Domain: ideal-world-cup
 * Domain Path: /lang
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if(!class_exists('IdealWorldCup')) {
    class IdealWorldCup {
	    /**
	     * StarterPlugin constructor.
	     * @since 1.0
	     * @version 1.0
	     */
	    public function __construct() {
		    $this->run();
	    }

	    /**
	     * Runs Plugins
	     * @since 1.0
	     * @version 1.0
	     */
	    public function run() {
		    $this->constants();
		    $this->includes();
		    $this->add_actions();
		    $this->register_hooks();
	    }

	    /**
	     * @param $name Name of constant
	     * @param $value Value of constant
	     *
	     * @since 1.0
	     * @version 1.0
	     */
	    public function define( $name, $value ) {
		    if ( ! defined( $name ) ) {
			    define( $name, $value );
		    }
	    }

	    /**
	     * Defines Constants
	     * @since 1.0
	     * @version 1.0
	     */
	    public function constants() {
		    $this->define( 'VERSION', '1.0' );
		    $this->define( 'PREFIX', 'iwc_' );
		    $this->define( 'TEXT_DOMAIN', 'ideal-world-cup' );
		    $this->define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		    $this->define( 'PLUGIN_URI', plugin_dir_url( __FILE__ ) );
	    }

	    /**
	     * Require File
	     * @since 1.0
	     * @version 1.0
	     */
	    public function file( $required_file ) {
		    if ( file_exists( $required_file ) ) {
			    require_once $required_file;
		    } else {
			    echo 'File Not Found';
		    }
	    }

	    /**
	     * Include files
	     * @since 1.0
	     * @version 1.0
	     */
	    public function includes() {
		    $this->file( PLUGIN_DIR . 'includes/ideal-functions.php' );
	    }

	    /**
	     * Enqueue Styles and Scripts
	     * @since 1.0
	     * @version 1.0
	     */
	    public function enqueue_scripts() {
		    wp_enqueue_media();
		    wp_enqueue_style( TEXT_DOMAIN . '-css', PLUGIN_URI . 'assets/css/style.css', [], VERSION, 'all' );
		    wp_enqueue_script( TEXT_DOMAIN . '-custom-js', PLUGIN_URI . 'assets/js/custom.js', [ 'jquery' ], VERSION, true );
		    wp_localize_script( TEXT_DOMAIN . '-custom-js', 'custom_ajax',
			    [
			    	'ajaxurl' => admin_url( "admin-ajax.php" ),
				    'apikey' => TEXT_DOMAIN . "|" . get_option( 'siteurl' ),
				    'apiurl' => "https://www.scintelligencia.com/wp-json/api-manager/api-key"
			    ] );
	    }

	    /**
	     * Adds Admin Page in Dashboard
	     * @since 1.0
	     * @version 1.0
	     */
	    public function add_menu() {
		    add_menu_page(
			    __( 'Ideal World Cup', TEXT_DOMAIN ),
			    'Ideal World Cup',
			    'manage_options',
			    TEXT_DOMAIN . '-home',
			    [ $this, 'home' ],
			    plugin_dir_url( __FILE__ ) . "assets/images/logo.png"
		    );

		    add_submenu_page(
			    TEXT_DOMAIN . "-home",
			    __( 'Ideal World Cup', TEXT_DOMAIN ),
			    'Ideal World Cup',
			    "manage_options",
			    TEXT_DOMAIN . "-home",
			    [ $this, "home" ],
			    "1"
		    );

		    add_submenu_page(
			    TEXT_DOMAIN . "-home",
			    __( 'Select Images', TEXT_DOMAIN ),
			    'Select Images',
			    "manage_options",
			    TEXT_DOMAIN . "-select-to-show",
			    [ $this, "select_to_show" ],
			    "1"
		    );

		    add_submenu_page(
			    TEXT_DOMAIN . "-home",
			    __( 'Show All Quiz', TEXT_DOMAIN ),
			    'Show All Quiz',
			    'manage_options',
			    TEXT_DOMAIN . '-display-all-quiz',
			    [ $this, 'show_all_quiz' ]
		    );
	    }

	    public function show_all_quiz()
	    {
	    	require_once PLUGIN_DIR . "templates/show-all.php";
	    }

        public function select_to_show()
        {

        	require_once PLUGIN_DIR . "templates/select-to-show.php";
        }

        /**
         * Home page of Plugin
         * @since 1.0
         * @version 1.0
         */
        public function home()
        {
            require_once PLUGIN_DIR. 'templates/home.php';
        }

        /**
         * Add Actions
         * @since 1.0
         * @version 1.0
         */
        public function add_actions()
        {
            add_action('init', [$this, 'enqueue_scripts']);
            add_action('admin_menu', [$this, 'add_menu']);
            add_action('init', [$this, "shortcodes"]);
            add_action( "wp_ajax_custom_ajax", [$this, "custom_ajax"] );
            add_action( "wp_ajax_nopriv_custom_ajax", [$this, "custom_ajax"] );
        }

        public function custom_ajax()
        {
        	$type = "error";
        	$message = "error";

        	if (isset($_POST['method']))
	        {
	        	$method = $_POST['method'];
	        	if ($method == "get_more")
		        {
		        	$data = $_POST['ids'];
		        	$data = explode(",", $data);
			        $ids = [];
		        	foreach ( $data as $id ):
				        $tournament = ideal_get_tournament_by_id( $id );
				        ideal_get_winner_by_name_and_title( $tournament['name'], $tournament['title'] );
		        	    array_push( $ids, $tournament );
			        endforeach;
                    ideal_insert_tournament($ids);
			        $message = json_encode($ids);

		        	$type = "success";
		        } else {
			        $type = "0";
			        $message = "0";
		        }
	        }

        	$response['type']   =   $type;
        	$response['message']    =   $message;
        	die(json_encode($response));
        }

        public function shortcodes()
        {
        	add_shortcode( "display_pairs", [$this, "display_couples"] );
        }

        public function display_couples( $args = [] )
        {
        	extract( $args );
        	ob_start();
			require_once PLUGIN_DIR . 'templates/display-couples.php';
			return ob_get_clean();
        }

        /**
         * Register Activation, Deactivation and Uninstall Hooks
         * @since 1.0
         * @version 1.0
         */
        public function register_hooks()
        {
            register_activation_hook( __FILE__, [$this, 'activate'] );
            register_deactivation_hook( __FILE__, [$this, 'deactivate'] );
            register_uninstall_hook(__FILE__, 'pluginprefix_function_to_run');
        }

        /**
         * Runs on Plugin's activation
         * @since 1.0
         * @version 1.0
         */
        public function activate()
        {
			global $wpdb;
			$table = $wpdb->prefix . "ideal_winners";
	        $charset_collate = $wpdb->get_charset_collate();
	        $sql = "CREATE TABLE $table (
						id mediumint (9) NOT NULL AUTO_INCREMENT,
						name VARCHAR (255) NOT NULL,
						title VARCHAR (255) NOT NULL,
						votes VARCHAR (255) NOT NULL,
						PRIMARY KEY (id)
					) $charset_collate";
			require_once ABSPATH . "wp-admin/includes/upgrade.php";
			dbDelta($sql);
        }

        /**
         * Runs on Plugin's Deactivation
         * @since 1.0
         * @version 1.0
         */
        public function deactivate()
        {

        }
    }
}

new IdealWorldCup();
