<?php

/**
 * Fired during plugin activation.
 *
 * @see       http://example.com
 * @since      1.0.0
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 *
 * @author     Your Name <email@example.com>
 */
class Social_Sensei_Activator {
    /**
     * Short Description. (use period).
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
    }

    /**
     * Generate bearer token for communicating with Hahn API
     * 
     * Should send:
     * - website url (use this to do an allowed hosts check)
     * 
     * Should receive:
     * - bearer token
     */
    private function generateAccessToken () {

    }
}
