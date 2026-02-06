<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://themesartist.com
 * @since      1.0.0
 *
 * @package    Themesartist_Demo_Importer
 * @subpackage Themesartist_Demo_Importer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Themesartist_Demo_Importer
 * @subpackage Themesartist_Demo_Importer/includes
 * @author     Themes Artist <mail.themesartist@gmail.com>
 */
class Themesartist_Demo_Importer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Themesartist_Demo_Importer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'THEMESARTIST_DEMO_IMPORTER_VERSION' ) ) {
			$this->version = THEMESARTIST_DEMO_IMPORTER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'themesartist-demo-importer';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Themesartist_Demo_Importer_Loader. Orchestrates the hooks of the plugin.
	 * - Themesartist_Demo_Importer_i18n. Defines internationalization functionality.
	 * - Themesartist_Demo_Importer_Admin. Defines all hooks for the admin area.
	 * - Themesartist_Demo_Importer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-themesartist-demo-importer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-themesartist-demo-importer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-themesartist-demo-importer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-themesartist-demo-importer-public.php';

		$this->loader = new Themesartist_Demo_Importer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Themesartist_Demo_Importer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Themesartist_Demo_Importer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Themesartist_Demo_Importer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Themesartist_Demo_Importer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Themesartist_Demo_Importer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}




if (!function_exists('themesartist_demo_importer_import_files')) {

    function themesartist_demo_importer_import_files()
    {
	add_filter( 'ocdi/import_files', 'ocdi_import_files' );
        return array(
		        array(
		            'import_file_name'             => esc_html__('Jobclub', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/jobclub/jobclub.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/jobclub/jobclub.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/jobclub/jobclub.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/jobclub/jobclub.png',
		            'import_notice'                => __( 'Make sure you are using free version of Jobclub Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/jobclub/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Super Job', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/superjob/superjob.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/superjob/superjob.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/superjob/superjob.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/superjob/superjob.png',
		            'import_notice'                => __( 'Make sure you are using free version of Super Job Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/superjob/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('BizDirectory', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/bizdirectory/bizdirectory.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/bizdirectory/bizdirectory.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/bizdirectory/bizdirectory.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/bizdirectory/bizdirectory.png',
		            'import_notice'                => __( 'Make sure you are using free version of Super Job Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/bizdirectory/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Artimusic/Musicana', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/artimusic/artimusic.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/artimusic/artimusic.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/artimusic/artimusic.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/artimusic/artimusic.png',
		            'import_notice'                => __( 'Make sure you are using free version of Artimusic Theme or Musicana Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/artimusic/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Joblook', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/joblook/joblook.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/joblook/joblook.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/joblook/joblook.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/joblook/joblook.png',
		            'import_notice'                => __( 'Make sure you are using free version of Joblook Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/joblookfree/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Podcastin', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/podcastin/podcastin.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/podcastin/podcastin.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/podcastin/podcastin.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/podcastin/podcastin.png',
		            'import_notice'                => __( 'Make sure you are using free version of Podcastin Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/podcastin/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Life Coaches', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lifecoaches/lifecoaches.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lifecoaches/lifecoaches.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lifecoaches/lifecoaches.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lifecoaches/lifecoaches.png',
		            'import_notice'                => __( 'Make sure you are using free version of Life Coaches Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/lifecoaches/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Travel Blogz', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/travelblogz/travelblogz.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/travelblogz/travelblogz.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/travelblogz/travelblogz.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/travelblogz/travelblogz.png',
		            'import_notice'                => __( 'Make sure you are using free version of Travel Blogz Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/travelblogzfree/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Recipe Blogz', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/recipeblogz/recipeblogz.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/recipeblogz/recipeblogz.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/recipeblogz/recipeblogz.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/recipeblogz/recipeblogz.png',
		            'import_notice'                => __( 'Make sure you are using free version of Recipe Blogz Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/recipeblogz/',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Lawyering', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lawyering/lawyering.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lawyering/lawyering.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lawyering/lawyering.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/lawyering/lawyering.png',
		            'import_notice'                => __( 'Make sure you are using free version of Lawyering Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/lawyeringfree',
		        ),
		        array(
		            'import_file_name'             => esc_html__('Coachable', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/coachable/coachable.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/coachable/coachable.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/coachable/coachable.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/coachable/coachable.png',
		            'import_notice'                => __( 'Make sure you are using free version of Lawyering Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/coachablefree/',
		        ),
		         array(
		            'import_file_name'             => esc_html__('Charitys', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/charitys/charitys.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/charitys/charitys.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/charitys/charitys.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/charitys/charitys.jpeg',
		            'import_notice'                => __( 'Make sure you are using free version of Charitys Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/charitysfree/',
		        ),
		         array(
		            'import_file_name'             => esc_html__('Localdirectory', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/localdirectory/localdirectory.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/localdirectory/localdirectory.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/localdirectory/localdirectory.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/localdirectory/localdirectory.jpg',
		            'import_notice'                => __( 'Make sure you are using free version of Localdirectory Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/localdirectoryfree/',
		        ),
		         array(
		            'import_file_name'             => esc_html__('Feminine Mentor', 'themesartist-demo-importer'),
		            'import_file_url'            => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/femininementor/femininementor.xml',
		            'import_widget_file_url'     => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/femininementor/femininementor.wie',
		            'import_customizer_file_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/femininementor/femininementor.dat',
		            'import_preview_image_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/demo/femininementor/femininementor.jpg',
		            'import_notice'                => __( 'Make sure you are using free version of Feminine Mentor Theme', 'themesartist-demo-importer' ),
		            'preview_url'                  => 'https://demo.themesartist.com/femininementorfree/',
		        ),
        );
    }
}

if (in_array('one-click-demo-import/one-click-demo-import.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_filter('pt-ocdi/import_files', 'themesartist_demo_importer_import_files');
    add_action( 'pt-ocdi/after_import', 'themesartist_demo_importer_after_import_setup' );
}


function themesartist_demo_importer_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Primary', 'primary-menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );
    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}







function themesartist_demo_import_lists(){
$demo_lists = array(
      'demo1' =>array(
         'title' => __( 'Profixer Free', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => false,
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'handyman'),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
           'template_url' => array(
            'content' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/profixer/content.json',
            'options' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/profixer/options.json',
            'widgets' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/profixer/widgets.json'
        ),
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/profixer-free.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/handyman/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo2' =>array(
         'title' => __( 'Profixer Pro- Handyman1', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/profixer/',
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'handyman'),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/profixer-handyman.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/handyman2/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo3' =>array(
         'title' => __( 'Profixer Pro- Handyman 2', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/profixer/',
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'handyman' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-handyman-.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/handyman3/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo4' =>array(
         'title' => __( 'Profixer Pro- Plumbing 1', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/profixer/',         
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'plumbing' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-plumbing.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/plumbing/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo5' =>array(
         'title' => __( 'Profixer Pro- Plumbing 2', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
          'pro_url' => 'https://themesartist.com/profixer/',        
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'plumbing' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-plumbing-.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/plumbing2/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo6' =>array(
         'title' => __( 'Profixer Pro- Roofing 1', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
          'pro_url' => 'https://themesartist.com/profixer/',        
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'roofing' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-roofing.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/roofing/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo7' =>array(
         'title' => __( 'Profixer Pro- Roofing 2', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
          'pro_url' => 'https://themesartist.com/profixer/',       
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'roofing' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-roofing-.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/roofing2',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo8' =>array(
         'title' => __( 'Profixer Pro- Cleaning', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
          'pro_url' => 'https://themesartist.com/profixer/',       
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'cleaning' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-cleaning.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/cleaning2',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo9' =>array(
         'title' => __( 'Profixer Pro- Gardening', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
          'pro_url' => 'https://themesartist.com/profixer/',       
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'gardening' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-gardening.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/gardening/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),

      'demo10' =>array(
         'title' => __( 'Profixer Pro - HVAC', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/profixer/',        
         'type' => 'homeservices',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'hvac' ),/*Search keyword*/
         'categories' => array( 'profixer' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/profixer-hvac.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/hvac',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo11' =>array(
         'title' => __( 'LMSCourse Free', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => false,
         'type' => 'courses',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'course'),/*Search keyword*/
         'categories' => array( 'lmscourse' ),/*Categories*/
           'template_url' => array(
            'content' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/lmscourse/content.json',
            'options' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/lmscourse/options.json',
            'widgets' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/lmscourse/widgets.json'
        ),
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/lmscourse-free.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/lmscoursefree/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo12' =>array(
         'title' => __( 'LMSCourse Pro', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/lmscourse/',        
         'type' => 'courses',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'course' ),/*Search keyword*/
         'categories' => array( 'lmscourse' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/lmscourse.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/lmscoursepro/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo13' =>array(
         'title' => __( 'Newsmagify Pro', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/newsmagify/',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'newsmagify' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/newsmagify.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/newsmagifypro/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo14' =>array(
         'title' => __( 'Newsmagify Free', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => false,
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine'),/*Search keyword*/
         'categories' => array( 'newsmagify' ),/*Categories*/
           'template_url' => array(
            'content' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/newsmagify/content.json',
            'options' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/newsmagify/options.json',
            'widgets' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/newsmagify/widgets.json'
        ),
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/newsmagify-free.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/newsmagifyfree/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo15' =>array(
         'title' => __( 'Muliblog Free', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => false,
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine'),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
           'template_url' => array(
            'content' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/multiblog/content.json',
            'options' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/multiblog/options.json',
            'widgets' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/multiblog/widgets.json'
        ),
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/multiblog-free.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblogfree',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo16' =>array(
         'title' => __( 'Multiblog Pro - News', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/multiblog',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/multiblog-news.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblognews/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo17' =>array(
         'title' => __( 'Multiblog Pro - Magazine', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/multiblog',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/multiblog-mag1.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblogmagazine1/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo18' =>array(
         'title' => __( 'Multiblog Pro - Magazine', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/multiblog',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/multiblog-mag2.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblogmagazine2/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo19' =>array(
         'title' => __( 'Multiblog Pro - Recipe', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/multiblog',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/multiblog-recipe.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblogrecipe/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo20' =>array(
         'title' => __( 'Multiblog Pro - Coaching', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/multiblog',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'news','blog','magazine' ),/*Search keyword*/
         'categories' => array( 'multiblog' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/multiblog-coaching.jpg',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/multiblogcoaching/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo21' =>array(
         'title' => __( 'MusicVibe Free', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => false,
         'type' => 'music',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'music','artist','producers'),/*Search keyword*/
         'categories' => array( 'musicvibe' ),/*Categories*/
           'template_url' => array(
            'content' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/musicvibe/content.json',
            'options' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/musicvibe/options.json',
            'widgets' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/themes/musicvibe/widgets.json'
        ),
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . 'public/screenshot/musicvibe-free.webp',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/musicvibefree/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
      'demo22' =>array(
         'title' => __( 'MusicVibe Pro', 'themesartist-demo-importer' ),/*Title*/
         'is_pro' => true,
         'pro_url' => 'https://themesartist.com/musicvibe',        
         'type' => 'blog',/*Optional eg elementor, elementor or other page builders or type*/
         'author' => __( 'Themesartist', 'themesartist-demo-importer' ),/*Author Name*/
         'keywords' => array( 'music','artist','producers' ),/*Search keyword*/
         'categories' => array( 'musicvibe' ),/*Categories*/
         'screenshot_url' => trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) ) . '/public/screenshot/musicvibe-pro.webp',/*Full URL Path to demo screenshot image*/
         'demo_url' => 'https://demo.themesartist.com/musicvibepro/',/*Full URL Path to Live Demo*/
         /* Recommended plugin for this demo */
      ),
   );
   return $demo_lists;
}
add_filter('advanced_import_demo_lists','themesartist_demo_import_lists');