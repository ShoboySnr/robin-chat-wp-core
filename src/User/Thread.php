<?php

namespace RobinChat\Core\User;

class Thread {
    
    public function threads_placeholder()
    {
        ob_start();
        Search::get_instance()->search_box();
        $this->thread_tabs();
        $this->thread_contents();
        return ob_get_clean();
    }
    
    
    public function thread_tabs() {
        $tabs_lists = [
            'all-messages' => __('All', 'robin-chat'),
            'direct-messages' => __('Direct Messages', 'robin-chat'),
            'group-messages' => __('Groups', 'robin-chat'),
        ];
        
        $tabs_lists = apply_filters('robin_chat_message_thread_tab_lists', $tabs_lists);
        
        ob_start();
        ?>
        <div class="robin-chat-msg-overlay-list-bubble__top-static-area">
            <div class="robin-chat-msg-overlay-list-bubble__top-static-area-tabs-size">
                <div aria-multiselectable="false" class="robin-chat-msg-overlay-list-bubble__top-static-area-tablist" role="tablist">
                    <?php
                        foreach ($tabs_lists as $key => $list) {
                            $selected = '';
                            if ($key === array_key_first($tabs_lists)) $selected = 'robin-chat-tab-selected';
                          
                    ?>
                    <button class="robin-chat-msg-overlay-bubble-header__button robin-chat-tab <?php echo $selected; ?>" role="tab" value="<?php echo $key; ?>">
                        <?php echo $list ?>
                    </button>
                     <?php } ?>
                </div>
            </div>
        </div>
        <?php
        
        echo ob_get_clean();
    }
    
    public function thread_contents()
    {
        $tabs_contents = [
            'all-messages' => __('All', 'robin-chat'),
            'direct-messages' => __('Direct Messages', 'robin-chat'),
            'group-messages' => __('Groups', 'robin-chat'),
        ];
    
        $tabs_contents = apply_filters('robin_chat_message_thread_tab_content', $tabs_contents);
        
        ob_start();
        ?>
        <section class="robin-chat-scrollable robin-chat-msg-overlay-list-bubble__content robin-chat-msg-overlay-list-bubble__content--scrollable">
          <div></div>
          
          <div class="robin-chat-msg-overlay-list-bubble__default-conversation-container">
            <span class="visually-hidden">
              Attention screen reader users, messaging items continuously update. Please use the tab and shift + tab keys instead of your up and down arrow keys to navigate between messaging items.
            </span>
            <div class="robin-chat-msg-overlay-list-bubble__conversations-list">
            
            </div>
          </div>
        </section>
        
        <?php
        
        echo ob_get_clean();
    }
    
    
    public function new_chat_options()
    {
      $chat_options = [
          [
              'icon'    => ROBIN_CHAT_ICON_NEW_CHAT_GROUP,
              'text'    => apply_filters('robin_chat_new_group_chats_name', __('New Group Chat', 'robin-app')),
              'value'   => 'new-group-chat'
          ],
          [
              'icon'    => ROBIN_CHAT_ICON_NEW_CHAT_LIST,
              'text'    => apply_filters('robin_chat_new_group_chats_list', __('New Chat List', 'robin-app')),
              'value'   => 'new-chat-list'
          ],
      ];
      
      
      //maybe modify options
      $chat_options = apply_filters('robin_chat_new_chat_options', $chat_options);
      
      $template = '';
      
      if(empty($chat_options)) return $template;
      
      ob_start();
      
      if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'partials/new-chat-options.php')) {
        include ROBIN_CHAT_USER_TEMPLATES_DIR. 'partials/new-chat-options.php';
      }
      
      $template .= ob_get_clean();
    
      $template = str_replace('loading="lazy"', '', $template);
  
      return \RobinChat\Core\minify_html($template);
    }
    
    public function get_contact_lists($contacts = [], $show_checkbox = false)
    {
        if(empty($contacts)) return '';
        
        ob_start();
        
        if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'contacts-list.php')) {
            include ROBIN_CHAT_USER_TEMPLATES_DIR. 'contacts-list.php';
        }
        
        return  ob_get_clean();
    }
    
    
    public function get_thread_type($thread, $type = '')
    {
      if(empty($type)) return '';
      
      switch ($type) {
          case 'image':
            if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
            {
              include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
            }
          break;
          case 'video':
              if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
              {
                  include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
              }
          break;
          case 'audio':
              if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
              {
                  include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
              }
          break;
          case 'gif':
              if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
              {
                  include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
              }
          break;
          case 'typing':
              if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
              {
                  include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
              }
          break;
          case 'link':
              if(file_exists(ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php'))
              {
                  include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/'. $type. '.php';
              }
          break;
          default:
              include ROBIN_CHAT_USER_TEMPLATES_DIR. 'chat-thread-type/text.php';
      }
      
    }
    
    
    public function message_status($thread, $status = [])
    {
      $message_status_html = '';
      if(empty($status)) return $message_status_html;
      
      if(!empty($status['unread'])) {
          $message_status_html .= sprintf('<p class="robin-chat-message-unread">%s</p>', intval($status['unread']));
      }
      
    if(!empty($status['receipts'])) {
        $message_status_html .= sprintf('<p class="robin-chat-message-receipt">%s</p>', $status['receipts']);
    }
    
    if(!empty($status['muted'])) {
        $message_status_html .= sprintf('<p class="robin-chat-message-muted">%s</p>', ROBIN_CHAT_ICON_THREAD_MUTE);
    }
      
      return $message_status_html;
      
    }
    
    
    /**
     * Singleton.
     *
     * @return Thread
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