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
        <button class="nav-tab" data-tab-target="custom-hooks">Prompt Settings</button>
    </h2>

    <div data-tab="api-settings" class="tab-content tab-content-active">
        <h2>AI Generated Social API Settings</h2>
        <p>Generate an API key in your Open AI account <a target="_blank" href="https://platform.openai.com/api-keys">here</a>.
        <form action="options.php" method="post">
            <?php settings_fields($this->social_sensei); ?>
            <?php do_settings_sections($this->social_sensei); ?>
            <?php submit_button(); ?>
        </form>
    </div>

    <div data-tab="custom-hooks" class="tab-content">
        <h2>AI Generated Social Prompt Settings</h2>
        <p>Configure the AI Assistant used to generate the social media posts.</p>
        <form action="options.php" method="post">
            <?php settings_fields($this->social_sensei . '_prompt'); ?>
            <?php do_settings_sections($this->social_sensei . '_prompt'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
</div>