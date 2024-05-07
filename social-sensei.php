<?php

/**
 *
 * @see              https://hahn.agency
 * @since            1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Social Sensei
 * Plugin URI:        https://hahn.agency
 * Description:       Use AI to create social media posts from your content.
 * Version:           1.2.3
 * Author:            Hahn Agency
 * Author URI:        https://hahn.agency
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       social-sensei
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
    exit;
}

define('SOCIAL_SENSEI_VERSION', '1.2.3');

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
