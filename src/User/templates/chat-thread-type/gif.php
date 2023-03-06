<?php

if(!empty($thread['type'])) {
    echo '<div class="robin-chat-image-message">';
    echo ROBIN_CHAT_ICON_THREAD_GIF;
    echo '<p>'. apply_filters('robin_chat_message_thread_message_type_gif', __('GIF Attachment', 'robin-app')). '</p>';
    echo '</div>';
}