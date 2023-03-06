<div class="robin-chat-msg-overlay-list-bubble__new-chats">
    <div class="robin-chat-msg-overlay-list-bubble__new-chats-header">
        <?php
            echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('close-new-chat', ROBIN_CHAT_ICON_NEW_CHAT_CLOSE, 'robin-chat-msg-overlay-list-bubble__new-chats-header-close-chat');
        ?>
        <div class="robin-chat-msg-overlay-list-bubble__new-chats-header-name">
          <h2><?php echo apply_filters('robin_chat_new_chats_header_name', __('New Chat', 'robin-app')); ?></h2>
        </div>
    </div>
    <div class="robin-chat-msg-overlay-list-bubble-search__input-container">
      <label class="robin-chat-ally-text" for="robin-chat-msg-overlay-list-bubble-search__search-typeahead-input"><?php echo __('Search anyone', 'robin-chat'); ?></label>
      <span class="robin-chat-msg-overlay-list-search__search-icon">
                  <?php echo ROBIN_CHAT_ICON_SEARCH_ICON; ?>
                </span>
      <input type="text" id="robin-chat-msg-overlay-list-bubble-search__search-typeahead-input" class="robin-chat-msg-overlay-list-search__search-typeahead-input" placeholder="<?php echo __('Search anyone', 'robin-chat'); ?>" autocomplete="off" />
    </div>
    <?php echo \RobinChat\Core\User\Thread::get_instance()->new_chat_options(); ?>
    <?php
        
        echo \RobinChat\Core\User\Thread::get_instance()->get_contact_lists($contacts); ?>
</div>