<?php

namespace RobinChat\Core;

class RegisterScripts
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_css'));
        add_action('wp_enqueue_scripts', array($this, 'public_css'));
        add_action('wp_enqueue_scripts', array($this, 'public_js'));
    }
    
    
    public function public_css()
    {
        wp_enqueue_style('robin-chat', ROBIN_CHAT_CORE_URL . 'dist/css/bundle.css', [], ROBIN_CHAT_VERSION_NUMBER);
        wp_enqueue_style('robin-chat-satoshi-font', 'https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,301,701,300,501,401,901,400&display=swap', [], ROBIN_CHAT_VERSION_NUMBER);
    }
    
    /**
     * Enqueue public scripts and styles.
     */
    public function public_js()
    {
        $this->chat_scripts();
        $this->global_js_variables('robin-chat');
    }
    
    
    /**
     * Global JS variables required by Robin Chat
     *
     * @param string $handle
     */
    public function global_js_variables($handle = 'jquery')
    {
        $localize_strings = array(
        'admin_url'                                     => admin_url(),
            'user_nonce'                                => wp_create_nonce('robin-chat-user-nonce'),
            'admin_nonce'                               => wp_create_nonce('robin-chat-admin-nonce'),
            'robin_chat_ajaxurl'                        => admin_url( 'admin-ajax.php' ),
            'robin_chat_rest_api_url'                   => rest_url('/robin-chat/v2/'),
            'wp_rest_nonce'                             => wp_create_nonce( 'wp_rest' )
        );
    
        if ( ! is_admin()) {
            unset($localize_strings['admin_url']);
            unset($localize_strings['admin_nonce']);
        }
    
        wp_localize_script(
            $handle, 'robin_chat_js_globals',
            apply_filters('robin_chat_js_globals', $localize_strings)
        );
    }
    
    
    public function chat_scripts()
    {
        wp_enqueue_script('jquery');
    
        wp_enqueue_script('robin-chat', ROBIN_CHAT_CORE_URL . 'dist/js/bundle.js', ['jquery'], ROBIN_CHAT_VERSION_NUMBER, true);
    }
    
    
    /**
     * Robin Chat only css to fix conflicts
     */
    public function admin_css()
    {
        $screen = get_current_screen();
        
        $base_text = $screen->base;
    
        wp_enqueue_style('robin-chat-menu', ROBIN_CHAT_ASSETS_URL . 'css/admin/robin-chat-menu.css', [], filemtime(ROBIN_CHAT_ASSETS_DIR . 'css/admin/robin-chat-menu.css'));
    
        if (str_contains($base_text, 'robin-chat')) {
            wp_enqueue_style('robin-chat-admin', ROBIN_CHAT_ASSETS_URL . 'css/admin/admin.css', [], filemtime(ROBIN_CHAT_ASSETS_DIR . 'css/admin/admin.css'));
        }
        
    }
    
    /**
     * @return RegisterScripts
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