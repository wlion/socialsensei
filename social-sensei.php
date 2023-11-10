<?php

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @see              http://example.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Social Sensei
 * Plugin URI:        http://example.com/social-sensei-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       social-sensei
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    exit;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SOCIAL_SENSEI_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-social-sensei-activator.php.
 */
function activate_social_sensei() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-social-sensei-activator.php';
    Social_Sensei_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-social-sensei-deactivator.php.
 */
function deactivate_social_sensei() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-social-sensei-deactivator.php';
    Social_Sensei_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_social_sensei');
register_deactivation_hook(__FILE__, 'deactivate_social_sensei');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-social-sensei.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_social_sensei() {
    $plugin = new Social_Sensei();
    $plugin->run();
}
run_social_sensei();
