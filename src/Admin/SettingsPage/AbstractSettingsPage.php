<?php

namespace RobinChat\Core\Admin\SettingsPage;

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

abstract class AbstractSettingsPage
{
    protected $option_name;
    
    public function init_menu()
    {
        add_action('admin_menu', array($this, 'register_core_menu'));
    }
    
    
    public function register_core_menu()
    {
        add_menu_page(
            __('Robin WordPress Plugin', 'robin-chat'),
            __('Robin', 'robin-chat'),
            \RobinChat\Core\get_capability(),
            ROBIN_CHAT_SETTINGS_DASHBOARD_SLUG,
            '',
            $this->getMenuIcon(),
            40
        );
        
        add_filter('admin_body_class', array($this, 'add_admin_body_class'));
    }
    
    private function getMenuIcon()
    {
        return 'data:image/svg+xml;base64,' . base64_encode('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><g style="mix-blend-mode:luminosity"><path fill="#F05A28" d="M10.516 8.82C6.46 8.34 3.686 5.867 2.318 4.126.952 2.389 1.82 1.063 1.758.87c.14.422 2.107 5.99 8.802 7.932.032.008.06.016.092.027-.043 0-.09-.005-.136-.01Z"/><path fill="#F6921E" d="m10.017 8.399-.071-.041C4.669 5.448 4.05.384 4.01 0c.017.173-.813 1.798-.013 3.405.8 1.606 2.579 3.783 5.905 4.955.038.014.076.025.115.039Z"/><path fill="#EE4036" d="M1.134 15.688c2.837-3.77 5.231-.404 9.282-2.196 2.82-1.25 1.768-2.595 4.379-3.666.498-.203 1.205-.175 1.205-.175s-.084-.108-.446-.338c-.362-.228-.604-.247-.604-.247s-.079-.22-.539-.525c-.46-.304-1.289-.324-1.98.014-.465.228-1.066.5-1.898.41C6.096 8.477 2.184 5.556 0 3.011c.003.458 8.185 10.806 1.134 12.676Z"/></g></svg>');
    }
    
    /**
     * Adds admin body class to all admin pages created by the plugin.
     *
     * @param string $classes Space-separated list of CSS classes.
     *
     * @return string Filtered body classes.
     * @since 0.1.0
     *
     */
    public function add_admin_body_class($classes)
    {
        $current_screen = get_current_screen();
        
        if (empty ($current_screen)) return;
        
        if (false !== strpos($current_screen->id, 'robin-chat')) {
            
            // Leave space on both sides so other plugins do not conflict.
            $classes .= ' robin-chat-admin ';
        }
        
        return $classes;
    }
    
    
    public function register_core_settings()
    {
      if ( ! empty( $this->rc_is_account_connected() ) ) $this->stylish_header();
    }
    
    
    public function stylish_header()
    {
        $logo_url = ROBIN_CHAT_ASSETS_URL . 'images/logo-robin-chat.png';
        
        ?>
        <div class="rc-admin-banner">
            <div class="rc-admin-banner__logo">
                <img src="<?= $logo_url ?>" alt="">
            </div>
            <?php $this->settings_page_menu(); ?>
            <?php $this->premium_header(); ?>
            <?php $this->account_header(); ?>
        </div>
        <?php
    }
    
    public function settings_page_menu()
    {
      $menu_args = apply_filters('robin_chat_settings_page_menu', [
        [
            'tab_title'   => __('Dashboard', 'robin-chat'),
            'tab_link'   => ROBIN_CHAT_SETTINGS_DASHBOARD_PAGE,
            'tab_slug'   => ROBIN_CHAT_SETTINGS_DASHBOARD_SLUG
        ],
        [
            'tab_title'   => __('Users', 'robin-chat'),
            'tab_link'   => ROBIN_CHAT_SETTINGS_USERS_PAGE,
            'tab_slug'   => ROBIN_CHAT_SETTINGS_USERS_SLUG
        ],
        [
            'tab_title'   => __('Settings', 'robin-chat'),
            'tab_link'   => ROBIN_CHAT_SETTINGS_SETTINGS_PAGE,
            'tab_slug'   => ROBIN_CHAT_SETTINGS_SETTINGS_SLUG
        ],
      ]);
      
      echo '<div class="rc-settings-page-menu">';
      echo '<ul>';
      
      foreach ($menu_args as $arg) {
        $is_active = !empty($_GET['page']) && $_GET['page'] == $arg['tab_slug'] ? 'active' : '';
        echo '<li class="'.$is_active.'">';
        echo sprintf('<a href="%s" title="%s">%s</a>', $arg['tab_link'], $arg['tab_title'], $arg['tab_title']);
        echo '</li>';
      }
      
      echo '</ul>';
      echo '</div>';
    }
    
    public function premium_header()
    {
        if( ! defined('ROBIN_CHAT_DETACH_LIBSODIUM' )  ) {
        ?>
        <div class="robin-chat-account-premium-header">
          <a href="#" title="<?php echo __('Go Premium', 'robin-chat'); ?>">
          <?php echo __('Go Premium', 'robin-chat'); ?>
          </a>
        </div>
        <?php
      }
    }
    
    
    public function account_header()
    {
      $account_link = 'https://robinapp.co';
      ?>
        <div class="robin-chat-user-account">
          <a href="<?php echo esc_url($account_link); ?>" title="<?php echo __('My Account', 'robin-chat'); ?>" target="_blank">
            <?php echo __('My Account', 'robin-app'); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" fill="none"><path fill="#0F172A" fill-rule="evenodd" d="M2.25 3.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 10.75 15h-8.5A2.25 2.25 0 0 1 0 12.75v-8.5A2.25 2.25 0 0 1 2.25 2h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd"/><path fill="#0F172A" fill-rule="evenodd" d="M4.194 10.753a.75.75 0 0 0 1.06.053L14.5 2.44v2.81a.75.75 0 0 0 1.5 0V.75a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553L4.247 9.694a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd"/></svg>
          </a>
        </div>
      <?php
    }
    
    public static function rc_is_account_connected()
    {
        return  get_option(ROBIN_CHAT_ACCOUNT_IS_CONNECTED, false);
    }
}