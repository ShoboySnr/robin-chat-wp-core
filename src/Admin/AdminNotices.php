<?php

namespace RobinChat\Core\Admin;

class AdminNotices {
  
    const admin_notices_success_key = 'robin_chat_admin_success_notices';
    const admin_notices_error_key = 'robin_chat_admin_error_notices';
    
    public function __construct()
    {
        add_action( 'admin_notices', array( $this, 'maybe_display_notice' ) );
    }
    
    public function maybe_display_notice()
    {
      // display success notice
      $notice = get_transient( self::admin_notices_success_key );
      
      if( $notice ) {
          delete_transient( self::admin_notices_success_key );
          $this->display_notice( $notice );
      }
    
      // display error notice
      $notice = get_transient( self::admin_notices_error_key, false );
  
      if( $notice ) {
          delete_transient( self::admin_notices_error_key );
          $this->display_notice( $notice, 'error' );
      }
    }
    
    public function display_notice( $notice, $type = 'success' )
    {
        ?>
        <div class="notice robin-chat-notice notice-<?php echo $type; ?> is-dismissible">
            <p><?php echo sprintf('%s', esc_attr($notice)); ?></p>
        </div>
        <?php
    }
    
    public function create_notice( $notice, $type = 'success' )
    {
      if( ! empty( $notice ) ) $type != 'success' ? set_transient( self::admin_notices_error_key, $notice ) : set_transient( self::admin_notices_success_key, $notice );
    }
    
    /**
     * @return AdminNotices|null
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