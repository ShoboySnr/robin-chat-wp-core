<?php

namespace RobinChat\Core\Admin\SettingsPage;

// Exit if accessed directly
use RobinChat\Core\RegisterActivation\Account;

if ( ! defined('ABSPATH')) {
    exit;
}

class Settings extends AbstractSettingsPage {
    
    public function __construct()
    {
        add_action('admin_menu', array($this, 'register_settings_page'));
    }
    
    
    public function register_settings_page()
    {
        add_submenu_page(
            ROBIN_CHAT_SETTINGS_DASHBOARD_SLUG,
            __('Settings - Robin', 'mailoptin'),
            __('Settings', 'mailoptin'),
            \RobinChat\Core\get_capability(),
            ROBIN_CHAT_SETTINGS_SETTINGS_SLUG,
            array($this, 'settings_admin_page_callback')
        );
    }
    
    public static function get_instance()
    {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
    
    
    public function settings_admin_page_callback()
    {
        echo '<div class="robin-chat-wrapper">';
    
        $this->register_core_settings();
        settings_errors('wp_csa_notice');
        echo '<div class="wrap">';
        if( ! empty( $this->rc_is_account_connected() ) ) {
            // include the settings template
            include_once 'templates/settings.php';
        } else {
            // this handles api key account activation
            Account::get_instance()->rc_render_activation_key_page();
        }
        echo '</div>';
        echo '</div>';
    }
}