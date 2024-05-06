<?php

/**
 * Social Sensei Admin Views
 *
 * @see       http://example.com
 * @since      1.0.0
 */
$env             = $this->get_environment();
$linkedIn_cookie = isset($_COOKIE[Linkedin_Social_Controller::STATE_COOKIE_NAME]) && !empty($_COOKIE[Linkedin_Social_Controller::STATE_COOKIE_NAME]) ? $_COOKIE[Linkedin_Social_Controller::STATE_COOKIE_NAME] : '';
$code            = isset($_GET['code']) && !empty($_GET['code']) ? $_GET['code'] : '';
$state           = isset($_GET['state']) && !empty($_GET['state']) ? $_GET['state'] : '';
$state_error     = '';
$access_token    = '';
$show_social_tab = defined('LINKEDIN_CLIENT_ID') && defined('LINKEDIN_REDIRECT_URI') && !empty(LINKEDIN_CLIENT_ID) && !empty(LINKEDIN_REDIRECT_URI);

if (!empty($code) && !empty($state)) {
    // if state is not equal to the cookie, then we have a CSRF attack
    if ($state !== $linkedIn_cookie) {
        $state_error = 'Something went wrong.  Please refresh the page and try again.';
        setcookie(Linkedin_Social_Controller::STATE_COOKIE_NAME, '', time() - 3600, '/');
        unset($_COOKIE['your_cookie_name']);
    }

    if ($show_social_tab) {
        // send request to get access_token for user
        $li_controller = new Linkedin_Social_Controller(LINKEDIN_CLIENT_ID, LINKEDIN_REDIRECT_URI);
        $response  = $li_controller->getAccessToken($code);
        $access_token = $response['data']['access_token'];
    
        // TODO: save access_token to options table
        // TODO: can we move this logic out of this partial?
    }
}
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
        <button class="nav-tab" data-tab-target="social-media-settings">Social Media Settings</button>
    </h2>

    <div id="api-settings" data-tab="api-settings" class="settings-section">
        <h2>AI Generated Social API Settings</h2>
        <p>Generate an API key in your Open AI account <a target="_blank" href="https://platform.openai.com/api-keys">here</a>.
        <form action="options.php" method="post">
            <?php settings_fields($this->social_sensei); ?>
            <?php do_settings_sections($this->social_sensei); ?>
            <?php submit_button(); ?>
        </form>
    </div>

    <div id="custom-hooks" data-tab="custom-hooks" class="settings-section" style="display: none;">
        <h2>AI Generated Social Prompt Settings</h2>
        <p>Configure the AI Assistant used to generate the social media posts.</p>
        <form action="options.php" method="post">
            <?php settings_fields($this->social_sensei . '_prompt'); ?>
            <?php do_settings_sections($this->social_sensei . '_prompt'); ?>
            <?php submit_button(); ?>
        </form>
    </div>

    <?php if ($show_social_tab): ?>
        <div id="social-media-settings" data-tab="social-media-settings" class="settings-section" style="display: none">
            <h2>Social Media Account Settings</h2>
            <p>Connect Social Sensei with your social media accounts.</p>
            <form action="options.php" method="post">
                <?php settings_fields($this->social_sensei . '_social'); ?>
                <?php do_settings_sections($this->social_sensei . '_social'); ?>
            </form>
            <p><?= $access_token ?></p>
        </div>
    <?php endif; ?>
</div>
