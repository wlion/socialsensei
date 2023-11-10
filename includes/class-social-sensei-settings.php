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
     * Get admin api key.
     *
     * @return string
     */
    public function get_api_key() {
        return get_option($this->option_name . 'api_key');
    }

    /**
     * Get Prompt Instruction.
     *
     * @return string
     */
    public function get_prompt_instructions() {
        return get_option($this->option_name . 'prompt_instructions');
    }
}
