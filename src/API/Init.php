<?php

namespace RobinChat\Core\API;

class Init {
    
    public function __construct()
    {
        $this->api_classes_init();
    
        add_action( 'rest_api_init',  array( $this, 'rest_api_init' ) );
    
        add_action( 'wp_ajax_robin_chat_new_nonce_token', array( $this, 'rest_nonce' ) );
        
        
    }
    
    public function rest_api_init()
    {
        register_rest_route( 'robin-chat/v2', '/threads', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_threads' ),
            'permission_callback' => array( $this, 'is_user_authorized' )
        ) );
    
        register_rest_route( 'robin-chat/v2', '/threads', array(
            'methods' => 'POST',
            'callback' => array( $this, 'get_threads' ),
            'permission_callback' => array( $this, 'is_user_authorized' )
        ) );
    }
    
    
    public function api_classes_init()
    {
        Conversations::get_instance();
    }
    
    public function get_threads( $thread_ids = [], $fetch_messages = true, $fetch_users = true, $personal_data = true, $cache = true, $user_id = false )
    {
        $excluded = [];
    
        if( is_a($thread_ids, 'WP_REST_Request' ) ){
            $request = $thread_ids;
            $excluded = (array) $request->get_param('exclude');
            $thread_ids = [];
        }
    
        $current_user_id = ( $user_id ) ? $user_id : get_current_user_id();
        $server_time     = \RobinChat\Core\get_microtime();
        
        // Implement Robin REST API here
    
        $users = [];
    
        $get_threads = [
            [
                'thread_id'     => 1,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
            ],
            [
                'thread_id'     => 1,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
            ]
        ];
    
        $threads  = '';
        $messages = [];
        $user_ids = [ $current_user_id ];
        $added_users = [];
    
        $path = apply_filters('robin_chat_views_path', ROBIN_CHAT_USER_TEMPLATES_DIR);
        
        if( ! empty( $get_threads)) {
            foreach ($get_threads as $get_thread ) {
            
            }
        }
    
        $template = 'empty-message.php';
    
        ob_start();
    
        $template = apply_filters( 'robin_chat_empty_message_template', $path . $template, $template );
    
        if($template !== false) {
            include($template);
        }
    
    
        $content = ob_get_clean();
    
        $content = str_replace('loading="lazy"', '', $content);
    
        $content = \RobinChat\Core\minify_html($content);
        
        $threads .= $content;
    
        return [
            'threads'    => $threads,
            'users'      => $users,
            'messages'   => $messages,
            'serverTime' => $server_time
        ];
    }
    
    
    public function rest_nonce()
    {
        wp_send_json([
            'user_id' => get_current_user_id(),
            'nonce'   => wp_create_nonce( 'wp_rest' )
        ]);
    }
    
    public function is_user_authorized( \WP_REST_Request $request )
    {
        if( is_user_logged_in() ) {
            return true;
        }
        
        return apply_filters('robin_chat_rest_is_user_authorized', false, $request );
    }
    
    
    /**
     * Singleton.
     *
     * @return Init
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