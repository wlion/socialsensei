<?php

/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @see       http://example.com
 * @since      1.0.0
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
 *
 * @author     Your Name <email@example.com>
 */
class Social_Sensei {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     *
     * @var Social_Sensei_Loader maintains and registers all hooks for the plugin
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the string used to uniquely identify this plugin
     */
    protected $social_sensei;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     *
     * @var string the current version of the plugin
     */
    protected $version;

    /**
     * To retrieve plugin settings.
     *
     * @var SocialSenseiSettings
     */
    protected $settings;

    /**
     * The option name to be used in this plugin (ie. prefix in options table).
     *
     * @var string
     */
    protected $option_name = 'wl_social_sensei_';

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
        if (defined('SOCIAL_SENSEI_VERSION')) {
            $this->version = SOCIAL_SENSEI_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->social_sensei = 'social-sensei';

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
     * - Social_Sensei_Loader. Orchestrates the hooks of the plugin.
     * - Social_Sensei_i18n. Defines internationalization functionality.
     * - Social_Sensei_Admin. Defines all hooks for the admin area.
     * - Social_Sensei_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-social-sensei-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-social-sensei-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-social-sensei-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-social-sensei-public.php';

        /**
         * Require vendor classes.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/vendor/class-open-ai.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/social_controllers/class-linkedin-social-controller.php';

        $this->loader = new Social_Sensei_Loader();
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-social-sensei-settings.php';

        $this->loader   = new Social_Sensei_Loader();
        $this->settings = new SocialSenseiSettings($this->get_option_name());
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Social_Sensei_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     */
    private function set_locale() {
        $plugin_i18n = new Social_Sensei_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     */
    private function define_admin_hooks() {
        $plugin_admin = new Social_Sensei_Admin($this, $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_init', $plugin_admin, 'create_social_state_strings');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_options_page');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_setting');
        $this->loader->add_action('admin_init', $plugin_admin, 'prompt_register_setting');
        $this->loader->add_action('admin_init', $plugin_admin, 'social_register_setting');
        $this->loader->add_action('admin_bar_menu', $plugin_admin, 'render_admin_bar_menu', 999);
        $this->loader->add_action('wp_ajax_wl_generate_summary', $plugin_admin, 'register_ajax_endpoint');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     */
    private function define_public_hooks() {
        $plugin_public = new Social_Sensei_Public($this->get_social_sensei(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
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
     *
     * @return string the name of the plugin
     */
    public function get_social_sensei() {
        return $this->social_sensei;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     *
     * @return Social_Sensei_Loader orchestrates the hooks of the plugin
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Get option_name.
     *
     * @return string
     */
    public function get_option_name() {
        return $this->option_name;
    }

    /**
     * Settings class reference.
     *
     * @return SocialSenseiSettings
     */
    public function get_settings() {
        return $this->settings;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     *
     * @return string the version number of the plugin
     */
    public function get_version() {
        return $this->version;
    }
}
