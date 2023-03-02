<?php

namespace RobinChat\Core\Admin\SettingsPage;

use RobinChat\Core\Admin\AdminNotices;

class RegisterActivation
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'verify_account_api_key_activation'));
    }
    
    /**
     * Render account activation key page
     */
    public function rc_render_activation_key_page()
    {
        $connected = ! empty($this->rc_api_activation_key());
        if( $connected ) {
            $this->update_account_connection_status(true);
        }
        
        $connection_error_message = !empty(get_transient(ROBIN_CHAT_ACCOUNT_CONNECTION_ERROR_MESSAGE)) ? get_transient(ROBIN_CHAT_ACCOUNT_CONNECTION_ERROR_MESSAGE) : '';
        
        include_once __DIR__.'/templates/account-api-activation-key.php';
        
        //delete connection error message
        delete_transient(ROBIN_CHAT_ACCOUNT_CONNECTION_ERROR_MESSAGE);
    }
    
    /**
     * Verify account api key activation
     *
     * @return false|void
     */
    public function verify_account_api_key_activation()
    {
        if ( isset($_POST['account-api-key-submit']) && isset($_POST['robin-chat-account-api-key-nonce']) ) {
            
            //check if the security nonce
            if(!wp_verify_nonce($_POST['robin-chat-account-api-key-nonce'], 'robin-chat-account-api-key')) {
                AdminNotices::get_instance()->create_notice('Security mismatch. Please refresh the page and try again!', 'error');
                return false;
            }
            
            $api_key = sanitize_text_field($_POST['robin-chat-account-api-key']);
            
            $is_success = true;
            // do the API Account Connection here
            
            if($is_success === false) {
                AdminNotices::get_instance()->create_notice('Your Robinapp account  connection failed', 'error');
                $message = __('Your Robinapp account connection failed', 'robin-app');
                set_transient(ROBIN_CHAT_ACCOUNT_CONNECTION_ERROR_MESSAGE, $message);
                return false;
            }
            
            if($is_success) {
                $this->update_api_activation_key($api_key);
                AdminNotices::get_instance()->create_notice('Your Robinapp account  has been connected!');
                return true;
            }
            
        }
    }
    
    /**
     * Get the api activation key status
     *
     * @return false|mixed|void
     */
    public function rc_api_activation_key()
    {
        return  get_option(ROBIN_CHAT_API_ACTIVATION_KEY, '');
    }
    
    /**
     * Update account connection status
     *
     */
    public function update_account_connection_status($status = false)
    {
        update_option(ROBIN_CHAT_ACCOUNT_IS_CONNECTED, $status);
    }
    
    public function update_api_activation_key($api_key)
    {
        update_option(ROBIN_CHAT_API_ACTIVATION_KEY, $api_key);
    }
    
    /**
     * @return Account
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