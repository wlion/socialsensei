<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @see       http://example.com
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @author     Your Name <email@example.com>
 */
class Social_Sensei_Public {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the ID of this plugin
     */
    private $social_sensei;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     *
     * @var string the current version of this plugin
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param string $social_sensei the name of the plugin
     * @param string $version       the version of this plugin
     */
    public function __construct($social_sensei, $version) {
        $this->social_sensei = $social_sensei;
        $this->version       = $version;

        // Hook to include custom PHP file in the footer
        add_action('wp_footer', [$this, 'include_custom_php_in_footer']);
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Social_Sensei_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Social_Sensei_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->social_sensei, plugin_dir_url(__FILE__) . 'css/social-sensei-public.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        /*
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Social_Sensei_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Social_Sensei_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->social_sensei, plugin_dir_url(__FILE__) . 'js/social-sensei-public.js', ['jquery'], $this->version, false);
        wp_localize_script(
            $this->social_sensei,
            'socialSenseiAjax',
            ['ajax_url' => admin_url('admin-ajax.php')]
        );
    }

    /**
     * Include custom PHP file in the footer.
     *
     * @since    1.0.0
     */
    public function include_custom_php_in_footer() {
        include_once plugin_dir_path(__FILE__) . 'partials/modal.php';
    }
}
