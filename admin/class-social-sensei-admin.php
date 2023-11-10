<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @see       http://example.com
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Your Name <email@example.com>
 */
class Social_Sensei_Admin {
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
     * Option prefix in db.
     *
     * @var string
     */
    private $option_name;

    /**
     * Current env.
     *
     * @var string
     */
    private $environment;

    /**
     * Plugin settings
     */
    private $settings;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param Social_Sensei $social_sensei the name of this plugin
     * @param string        $version       the version of this plugin
     */
    public function __construct($social_sensei, $version) {
        $this->social_sensei = $social_sensei->get_social_sensei();
        $this->version       = $version;

        $this->settings    = $social_sensei->get_settings();
        $this->option_name = $social_sensei->get_option_name();
    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->social_sensei, plugin_dir_url(__FILE__) . 'css/social-sensei-admin.css', [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->social_sensei, plugin_dir_url(__FILE__) . 'js/social-sensei-admin.js', ['jquery'], $this->version, false);
    }

    /**
     * Add an options page under the Settings submenu.
     */
    public function add_options_page() {
        add_options_page(
            'Social Sensei',
            'Social Sensei',
            'manage_options',
            $this->social_sensei,
            [$this, 'display_options_page']
        );
    }

    /**
     * Outputs admin page.
     */
    public function display_options_page() {
        include_once 'partials/social-sensei-admin-display.php';
    }

    /**
     * Settings form fields.
     *
     * @var array
     */
    private $form_fields = [
        [
            'label' => 'Application ID',
            'slug'  => 'app_id',
            'type'  => 'text',
        ],
        [
            'label' => 'API Key',
            'slug'  => 'api_key',
            'type'  => 'password',
        ],
    ];

    /**
     * Add an options page under the Settings submenu.
     */
    public function register_setting() {
        add_settings_section(
            $this->option_name . 'settings',  // Section name
            'Open AI API Settings',           // Section title
            [$this, 'settings_render'],       // Render callback
            $this->social_sensei                // Option page slug
        );

        // register settings input fields by looping over '$this->form_fields'
        foreach ($this->form_fields as $field) {
            $render_function = isset($field['render']) ? $field['render'] : 'text_field_render';
            $input_type      = isset($field['type']) ? $field['type'] : 'text';

            // create field
            add_settings_field(
                $this->option_name . $field['slug'],  // ID
                $field['label'],                      // Title
                [$this, $render_function],            // Callback function that renders field
                $this->social_sensei,                   // Page slug ('social-sensei')
                $this->option_name . 'settings',      // Section name this should live in
                [
                    'label_for' => $this->option_name . $field['slug'], // Extra args
                    'type'      => $input_type,
                    'slug'      => $field['slug'],
                ]
            );

            // register field
            register_setting(
                $this->social_sensei,                   // Settings group name
                $this->option_name . $field['slug'],  // Option name in db ('wl_social_sensei_{slug}')
                [
                    'type'              => 'string',
                    'sanitize_callback' => [$this, 'text_field_sanitize'],
                ]
            );
        }
    }

    /**
     * Render the text for the general section.
     */
    public function settings_render() {
        print '<p>Instructions on finding your api keys.</p>';
    }

    /**
     * Sanitize text form field.
     *
     * @param string $input
     *
     * @return string
     */
    public function text_field_sanitize($input) {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    /**
     * Render text form fields.
     *
     * @param array $field
     *
     * @return void
     */
    public function text_field_render($field) { ?>
<input type="<?= $field['type']; ?>"
    name="<?= $field['label_for']; ?>"
    id="<?= $field['label_for']; ?>"
    class="regular-text"
    value="<?= $this->get_data($field['slug']); ?>" />
<?php }

    /**
     * Render 'Index Prefix' text form field w/ description.
     *
     * @param array $field
     *
     * @return void
     */
    public function text_field_index_prefix_render($field) { ?>
<input type="<?= $field['type']; ?>"
    name="<?= $field['label_for']; ?>"
    id="<?= $field['label_for']; ?>"
    class="regular-text"
    value="<?= $this->get_data($field['slug']); ?>" />
<br>
<p class="description">
    This prefix will be prepended to your indices.
    <?php $prefix = $this->get_data($field['slug']); ?>
    <?php if (!strpos($prefix, $this->environment)): ?>
    <br>
    <em style="color:red;">Prefix should contain
        '<strong>_<?= $this->environment; ?>_</strong>'.</em>
    <?php endif; ?>
</p>
<?php }

    /**
     * Render the admin bar options
     */
    public function render_admin_bar_menu() {
        global $wp_admin_bar;
        $id = 'social-sensei_social_summary';

        $wp_admin_bar->add_menu([
            'id'    => $id,
            'title' => 'Generate Social',
            'href'  => '#', 
        ]);

        $choices = array(
            'Twitter' => '#twitter',
            'Facebook' => '#facebook',
            'LinkedIn' => '#linkedin',
            'Pinterest' => '#pinterest',
        );

        foreach ($choices as $choice_title => $choice_href) {
            $wp_admin_bar->add_menu(array(
                'parent' => $id,
                'id'     => sanitize_key($choice_title),
                'title'  => $choice_title,
                'href'   => $choice_href,
            ));
        }
    }

    /**
     * Test API key to make sure it's valid.
     *
     * @return bool
     */
    public function is_api_key_valid() {
        // TODO: test API key
        return true;
    }

    /**
     * Get Options data.
     *
     * @param string $suffix
     *
     * @return array
     */
    private function get_data($suffix) {
        return $this->settings->get_data($suffix);
    }

    /**
     * Check whether index is for current environment.
     *
     * @param string $index_name
     *
     * @return bool
     */
    private function is_index_for_current_environment($index_name) {
        return strpos(strtolower($index_name), '_' . $this->environment . '_');
    }

    /**
     * Get Environment.
     *
     * @return string
     */
    private function get_environment() {
        return $this->environment;
    }

    /**
     * register wp ajax endpoint for social summary
     * 
     * wp_ajax_wl_generate_summary
     */
    public function register_ajax_endpoint() {
        $data     = json_decode(file_get_contents('php://input'), true);
        $content = preg_replace('/\s+/u', ' ', $data['data']);

        $dom = new DOMDocument;

        libxml_use_internal_errors(true); // Suppress warnings for invalid HTML
        $dom->loadHTML($content);
        libxml_clear_errors();
        $textContent = $dom->textContent;

        // send to open ai
        $apiKey = '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';
        $openai = new OpenAIApiClient($apiKey);

        $messages = [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => 'Summarize the content of the page for sharing on social media. Don\'t use more than 100 words.'],
            ['role' => 'assistant', 'content' => $textContent],
        ];

        $response = $openai->generateChatCompletion($messages, 0.8);

        wp_send_json_success($response);

    }
}
?>