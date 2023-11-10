<?php

/**
 * Provide a admin area view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @see       http://example.com
 * @since      1.0.0
 */
$env = $this->get_environment();
?>

<div class="wrap">
    <h1><?= get_admin_page_title(); ?></h1>
    <?php if (!$this->is_api_key_valid()): ?>
    <div class="notice notice-error inline">
        <p>Could not connect to Open AI. <br>Please check <strong>Application ID</strong> and/or <strong>Admin API
                Key</strong>.</p>
    </div>
    <?php endif; ?>

    <h2 class="nav-tab-wrapper" style="margin: 0 0 1rem">
        <button class="nav-tab nav-tab-active" data-tab-target="api-settings">API Settings</button>
        <!-- <button class="nav-tab" data-tab-target="custom-hooks">Custom Hooks</button> -->
    </h2>

    <div id="social-sensei___notice">
        <p></p>
        <button class="social-sensei__notice-close"></button>
    </div>

    <div data-tab="api-settings" class="tab-content tab-content-active">
        <form action="options.php" method="post">
            <?php settings_fields($this->social_sensei); ?>
            <?php do_settings_sections($this->social_sensei); ?>
            <?php submit_button(); ?>
        </form>
    </div>

    <!-- <div data-tab="custom-hooks" class="tab-content">
        <h2>Custom Hooks</h2>
        <p>Find these hooks in <strong>Title</strong>.
    </p>
    <table class="widefat">
        <thead>
            <tr class="alternate">
                <th class="row-title">Hook</th>
                <th class="row-title">Description</th>
                <th class="row-title">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div> -->
</div>