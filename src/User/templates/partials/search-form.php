<div class="robin-chat-msg-overlay-list-bubble-search">
    <div class="robin-chat-msg-overlay-list-bubble-search__input-container">
        <label class="robin-chat-ally-text" for="robin-chat-msg-overlay-list-bubble-search__search-typeahead-input"><?php echo __('Search anyone, group or message', 'robin-chat'); ?></label>
        <span class="robin-chat-msg-overlay-list-search__search-icon">
                <?php echo ROBIN_CHAT_ICON_SEARCH_ICON; ?>
              </span>
        <input type="text" id="robin-chat-msg-overlay-list-bubble-search__search-typeahead-input" class="robin-chat-msg-overlay-list-search__search-typeahead-input" placeholder="<?php echo __('Search anyone, group or message', 'robin-chat'); ?>" autocomplete="off" />
    </div>
    <div class="robin-chat-msg-overlay-list-bubble-search__filter-chat robin-chat-msg-toggle-dropdown-contents">
        <?php
            
            echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('chat-settings-dropdown', ROBIN_CHAT_ICON_FILTER_ICON, 'robin-chat-msg-overlay-bubble-header__button robin-chat-dropdown robin-chat-filter-chat');
            
            $chat_message_settings = [
                [
                    'name'      => __('Unread Chat', 'robin-chat'),
                    'icon'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"><path stroke="#83899C" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="m7.5 10.185 1.539 1.482L12.5 8.333M17.503 10a7.5 7.5 0 0 1-7.5 7.5H2.504s1.3-3.12.78-4.166A7.5 7.5 0 1 1 17.503 10Z"/></svg>',
                    'value'     => 'unread-chat'
                ],
                [
                    'name'      => __('Archived Chat', 'robin-chat'),
                    'icon'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"><path stroke="#83899C" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M15.834 8.334V14c0 .934 0 1.4-.182 1.757-.16.313-.415.568-.728.728-.357.182-.824.182-1.757.182H6.834c-.934 0-1.4 0-1.757-.182a1.667 1.667 0 0 1-.729-.728c-.181-.357-.181-.823-.181-1.757V8.334M7.5 11.667h5M4.667 3.333h10.666c.467 0 .7 0 .879.091.157.08.284.208.364.365.09.178.09.411.09.878V7c0 .467 0 .7-.09.878a.833.833 0 0 1-.364.365c-.178.09-.412.09-.878.09H4.667c-.467 0-.7 0-.878-.09a.833.833 0 0 1-.365-.365c-.09-.178-.09-.411-.09-.878V4.667c0-.467 0-.7.09-.878a.833.833 0 0 1 .365-.365c.178-.09.411-.09.878-.09Z"/></svg>',
                    'value'     => 'archived-chat'
                ]
            ];
            
            $chat_message_settings = apply_filters('robin_chat_filter_chat_message_options', $chat_message_settings);
            
            echo \RobinChat\Core\User\MessageModal::get_instance()->message_modal_dropdown($chat_message_settings);
        
        ?>
    </div>
</div>