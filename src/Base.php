<?php

namespace RobinChat\Core;

use RobinChat\Core\Admin\AdminNotices;
use RobinChat\Core\Admin\PluginSettings;

define('ROBIN_CHAT_URL', plugin_dir_url(ROBIN_CHAT_SYSTEM_FILE_PATH));
define('ROBIN_CHAT_ASSETS_DIR', wp_normalize_path(dirname(__FILE__) . '/assets/'));
define('ROBIN_CHAT_CORE_DIR', wp_normalize_path(dirname(__FILE__). '/'));
if (str_contains(__FILE__, 'robin-chat' . DIRECTORY_SEPARATOR . 'src')) {
    // production url path to assets folder.
    define('ROBIN_CHAT_ASSETS_URL', ROBIN_CHAT_URL . 'src/core/src/assets/');
} else {
    // dev url path to assets folder.
    define('ROBIN_CHAT_ASSETS_URL', ROBIN_CHAT_URL . wp_normalize_path('../' . dirname(substr(__FILE__, strpos(__FILE__, 'robin-chat'))) . '/assets/'));
}

if (str_contains(__FILE__, 'robin-chat' . DIRECTORY_SEPARATOR . 'src')) {
    // production url path to assets folder.
    define('ROBIN_CHAT_CORE_URL', ROBIN_CHAT_URL . 'src/core/');
} else {
    // dev url path to assets folder.
    define('ROBIN_CHAT_CORE_URL', ROBIN_CHAT_URL . wp_normalize_path('../' . dirname(substr(__FILE__, strpos(__FILE__, 'robin-chat'))). '/'));
}

define('ROBIN_CHAT_DIST_URL', ROBIN_CHAT_CORE_URL. 'dist/');

define('ROBIN_CHAT_SETTINGS_DASHBOARD_SLUG', 'robin-chat-dashboard');
define('ROBIN_CHAT_SETTINGS_USERS_SLUG', 'robin-chat-users');
define('ROBIN_CHAT_SETTINGS_SETTINGS_SLUG', 'robin-chat-settings');

define('ROBIN_CHAT_SETTINGS_DASHBOARD_PAGE', admin_url('admin.php?page=' . ROBIN_CHAT_SETTINGS_DASHBOARD_SLUG));
define('ROBIN_CHAT_SETTINGS_USERS_PAGE', admin_url('admin.php?page=' . ROBIN_CHAT_SETTINGS_USERS_SLUG));
define('ROBIN_CHAT_SETTINGS_SETTINGS_PAGE', admin_url('admin.php?page=' . ROBIN_CHAT_SETTINGS_SETTINGS_SLUG));

define('ROBIN_CHAT_API_ACTIVATION_KEY', 'robin_chat_api_activation_key');
define('ROBIN_CHAT_ACCOUNT_IS_CONNECTED', 'robin_chat_account_is_connected');
define('ROBIN_CHAT_ACCOUNT_CONNECTION_ERROR_MESSAGE', 'robin_app_account_connection_error_message');
define('ROBIN_CHAT_ACCOUNT_STATUS', 'robin_app_account_status');

class Base {
    
    const robin_chat_api_activation_key = 'robin_chat_api_activation_key';
    
    public function __construct()
    {
//        register_activation_hook(ROBIN_CHAT_SYSTEM_FILE_PATH, ['RobinChat\Core\RegisterActivation\Base', 'run_install']);
        
        API\Init::get_instance();
        
        RegisterScripts::get_instance();
        PluginSettings::get_instance();
        
        $this->admin_hooks();
        
        $this->user_hooks();
    }
    
    public function admin_hooks()
    {
        if ( ! is_admin()) {
            return;
        }
    
        Admin\SettingsPage\RegisterActivation::get_instance();
        Admin\SettingsPage\Dashboard::get_instance();
        Admin\SettingsPage\Users::get_instance();
        Admin\SettingsPage\Settings::get_instance();
        
        AdminNotices::get_instance();
    }
    
    public function user_hooks()
    {
        $is_account_connected = get_option(ROBIN_CHAT_ACCOUNT_IS_CONNECTED, false);
        if(is_admin() || $is_account_connected == false) return;
    
        User\Init::get_instance();
    }
    
    /**
     * Singleton.
     *
     * @return Base
     */
    public static function get_instance()
    {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}