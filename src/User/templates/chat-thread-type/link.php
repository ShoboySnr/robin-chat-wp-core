<?php

if(!empty($thread['type'])) {
    echo '<div class="robin-chat-image-message">';
    echo ROBIN_CHAT_ICON_THREAD_LINK;
    echo '<p>'. sprintf('Link: %s', apply_filters('robin_chat_message_thread_message_type_link', $thread['message'])). '</p>';
    echo '</div>';
}