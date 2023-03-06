<?php

namespace RobinChat\Core\User;

class Search {
    
    public function __construct()
    {
    
    }
    
    
    public function search_box()
    {
        ob_start();
    
        include ROBIN_CHAT_USER_TEMPLATES_DIR . 'partials/search-form.php';
    
        echo ob_get_clean();
    }
    
    /**
     * Singleton.
     *
     * @return Search
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