<?php
/**
 * Settings class to retrieve options from database.
 */
class SocialSenseiSettings {
    /**
     * The options name to be used in this plugin.
     *
     * @var string
     */
    private $option_name;

    /**
     * Load class.
     */
    public function __construct($option_name) {
        $this->option_name = $option_name;
    }

    /**
     * Get value for specific setting.
     *
     * @return string
     */
    public function get_data($suffix) {
        return get_option($this->option_name . $suffix);
    }

    /**
     * Get app id.
     *
     * @return string
     */
    public function get_app_id() {
        return get_option($this->option_name . 'app_id');
    }

    /**
     * Get admin api key.
     *
     * @return string
     */
    public function get_admin_api_key() {
        return get_option($this->option_name . 'api_key');
    }

    /**
     * Get search-only api key.
     *
     * @return string
     */
    public function get_search_api_key() {
        return get_option($this->option_name . 'api_key_search');
    }

    /**
     * Get index prefix.
     *
     * @return string
     */
    public function get_index_prefix() {
        return get_option($this->option_name . 'index_prefix');
    }
}
