<?php

namespace RobinChat\Core\API;

class Conversations {
    
    public function __construct()
    {
        add_action( 'rest_api_init',  array( $this, 'rest_api_init' ) );
    }
    
    public function rest_api_init()
    {
        register_rest_route( 'robin-chat/v2', '/', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_reports' ),
            'permission_callback' => array( $this, 'has_access' )
        ) );
    }
    
    /**
     * Singleton.
     *
     * @return Conversations
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