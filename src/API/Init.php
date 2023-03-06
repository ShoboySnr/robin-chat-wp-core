<?php

namespace RobinChat\Core\API;

class Init {
    
    private $contacts = [
        [
            'name'      => 'Adan Lauzon',
            'first_name'      => 'Adan',
            'uid'       => 1,
            'image'     => 'contact1.png'
        ],
        [
            'name'      => 'Acumen Digital',
            'first_name'      => 'Acumen',
            'uid'       => 2,
            'image'     => 'contact2.png'
        ],
        [
            'name'      => 'Alfonso Stanton',
            'first_name'      => 'Alfonso',
            'uid'       => 3,
            'image'     => 'contact3.png'
        ],
        [
            'name'      => 'Alfredo Vetrovs',
            'first_name'      => 'Alfredo',
            'uid'       => 4,
            'image'     => 'contact4.png'
        ],
        [
            'name'      => 'Bill Gaston',
            'first_name'      => 'Bill',
            'uid'       => 5,
            'image'     => 'contact5.png'
        ],
        [
            'name'      => 'Brooklyn Warren',
            'first_name'      => 'Brooklyn',
            'uid'       => 6,
            'image'     => 'contact6.png'
        ],
        [
            'name'      => 'Calvin Steward',
            'first_name'      => 'Calvin',
            'uid'       => 7,
            'image'     => 'contact7.png'
        ],
        [
            'name'      => 'Chris Nhat',
            'first_name'      => 'Chris',
            'uid'       => 8,
            'image'     => 'contact8.png'
        ],
    ];
    
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
    
        register_rest_route( 'robin-chat/v2', '/deleteThreads', array(
            'methods' => 'GET',
            'callback' => array( $this, 'delete_threads' ),
            'permission_callback' => array( $this, 'is_user_authorized' )
        ) );
    
        register_rest_route( 'robin-chat/v2', '/newChat', array(
            'methods' => 'GET',
            'callback' => array( $this, 'new_chat' ),
            'permission_callback' => array( $this, 'is_user_authorized' )
        ) );
    
        register_rest_route( 'robin-chat/v2', '/newGroupChat', array(
            'methods' => 'GET',
            'callback' => array( $this, 'new_group_chat' ),
            'permission_callback' => array( $this, 'is_user_authorized' )
        ) );
    }
    
    
    public function api_classes_init()
    {
        Conversations::get_instance();
    }
    
    
    public function new_chat($user_id = false)
    {
        $current_user_id = ( $user_id ) ? $user_id : get_current_user_id();
        $server_time     = \RobinChat\Core\get_microtime();
        
        $users = [];
    
        // Implement Robin REST API here
        
        $contacts = $this->contacts;
        
        // maybe modify contact through filter
        $contacts = apply_filters('robin_chat_contact_lists', $contacts);
    
        $threads  = '';
        
        $path = apply_filters('robin_chat_views_path', ROBIN_CHAT_USER_TEMPLATES_DIR);
    
        $template = '';
    
        ob_start();
    
        $template = 'new-chat.php';
    
        $template = apply_filters( 'robin_chat_new_chat_template', $path . $template, $template );
    
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
            'contacts'   => $contacts,
            'serverTime' => $server_time
        ];
    }
    
    
    public function new_group_chat($user_id = false)
    {
        $current_user_id = ( $user_id ) ? $user_id : get_current_user_id();
        $server_time     = \RobinChat\Core\get_microtime();
        
        $users = [];
        
        // Implement Robin REST API here
    
        $contacts = $this->contacts;
        
        // maybe modify contact through filter
        $contacts = apply_filters('robin_chat_contact_lists', $contacts);
        
        $threads  = '';
        
        $path = apply_filters('robin_chat_views_path', ROBIN_CHAT_USER_TEMPLATES_DIR);
        
        $template = '';
        
        ob_start();
        
        $show_checkbox = true;
        
        $template = 'new-group-chat.php';
        
        $template = apply_filters( 'robin_chat_new_chat_template', $path . $template, $template );
        
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
            'contacts'   => $contacts,
            'serverTime' => $server_time
        ];
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
                'image'                 => 'people1.png',
                'message_type'          => 'image',
                'message'               => 'image1.jpeg',
                'name'                  => 'Close Friends',
                'time'                  => '10:20',
                'message_status'        => ['unread' => 2, 'muted' => true],
            ],
            [
                'thread_id'     => 2,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people2.png',
                'message_type'    => 'text',
                'message'     => 'The possibilities for innovation...',
                'name'      => 'Group Name',
                'time'      => '10:20',
                'message_status'    => ['read' => true, 'muted' => true],
                
            ],
            [
                'thread_id'     => 3,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people3.png',
                'message_type'        => 'typing',
                'name'      => 'Precious James',
                'time'      => '10:20',
                'message_status'    => ['receipts' => 'sent'],
            ],
            [
                'thread_id'     => 4,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people4.png',
                'message_type'    => 'video',
                'message' => 'video4.jpeg',
                'name'      => 'Group Name',
                'time'      => '10:20',
                'message_status'    => ['receipts' => 'read'],
            ],
            [
                'thread_id'     => 5,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people5.png',
                'message_type'    => 'audio',
                'message' => 'audio5.mp3',
                'name'      => 'Precious James',
                'time'      => '10:20',
                'message_status'        => ['unread' => 2],
            ],
            [
                'thread_id'     => 6,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people6.png',
                'message_type'    => 'gif',
                'message' => 'gif6.gif',
                'name'      => 'Precious James',
                'time'      => '10:20',
                'message_status'    => ['receipts' => 'sent', 'muted' => true],
            ],
            [
                'thread_id'     => 7,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people7.png',
                'message_type'    => 'link',
                'message' => 'https://www.google.c...',
                'name'      => 'Precious James',
                'time'      => '10:20',
                'message_status'    => ['receipts' => 'read', 'muted' => true],
            ],
            [
                'thread_id'     => 8,
                'type'          => 'text',
                'subject'          => '',
                'message_id'          => 2,
                'date_sent'          => '2/03/2021',
                'image'         => 'people8.png',
                'message_type'    => 'audio',
                'message' => 'audio8.mp3',
                'name'      => 'Group Name',
                'time'      => '10:20',
                'message_status'    => ['unread' => 2],
            ]
        ];
    
        $threads  = '';
        $messages = [];
        $user_ids = [ $current_user_id ];
        $added_users = [];
    
        $path = apply_filters('robin_chat_views_path', ROBIN_CHAT_USER_TEMPLATES_DIR);
    
        $template = '';
    
        ob_start();
        
        if(!empty( $get_threads)) {
            
            $template = 'chats-thread.php';
    
            $template = apply_filters( 'robin_chat_messages_thread_template', $path . $template, $template );
            
        } else {
            $template = 'empty-message.php';
    
            $template = apply_filters( 'robin_chat_empty_message_template', $path . $template, $template );
        }
    
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
    
    
    public function delete_threads( $thread_ids = [], $fetch_messages = true, $fetch_users = true, $personal_data = true, $cache = true, $user_id = false  )
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
        
        $threads  = '';
        $messages = [];
        $user_ids = [ $current_user_id ];
        $added_users = [];
    
        $path = apply_filters('robin_chat_views_path', ROBIN_CHAT_USER_TEMPLATES_DIR);
    
        $template = '';
    
        ob_start();
        
        $template = 'empty-message.php';
    
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