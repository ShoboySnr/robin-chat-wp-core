<?php

namespace RobinChat\Core\Admin;

class PluginSettings {
    
    public function __construct()
    {
        $basename = plugin_basename(ROBIN_CHAT_SYSTEM_FILE_PATH);
        $prefix = is_network_admin() ? 'network_admin_' : '';
        add_filter("{$prefix}plugin_action_links_$basename", array($this, 'robin_chat_action_links'), 10, 4);
    }
    
    
    public function robin_chat_action_links($actions, $plugin_file, $plugin_data, $context)
    {
        $custom_actions = array(
            'rc_settings' =>  sprintf('<a href="%s">%s</a>', ROBIN_CHAT_SETTINGS_DASHBOARD_PAGE, __('Dashboard', 'robin-chat'))
        );
    
        if (!defined('ROBIN_CHAT_DETACH_LIBSODIUM')) {
            $custom_actions['rc_premium'] = sprintf(
                '<a style="color:#EE4036;font-weight:bold" href="%s" target="_blank">%s</a>', '#',
                __('Go Premium', 'robin-chat')
            );
        }
    
        // add the links to the front of the actions list
        return array_merge($custom_actions, $actions);
    }
    
    /**
     * @return PluginSettings|null
     *
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