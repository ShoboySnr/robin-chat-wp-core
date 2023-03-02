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