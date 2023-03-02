<?php

namespace RobinChat\Core;

class Core {
    
    public function __construct()
    {
        Base::get_instance();
    }
    
    public static function get_instance() {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
    
    public static function init()
    {
        Core::get_instance();
        
        do_action('robin_chat_loaded');
    }
}