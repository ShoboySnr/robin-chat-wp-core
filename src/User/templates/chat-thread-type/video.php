<?php

if(!empty($thread['type'])) {
    echo '<div class="robin-chat-image-message">';
    echo ROBIN_CHAT_ICON_THREAD_VIDEO;
    echo '<p>'. apply_filters('robin_chat_message_thread_message_type_video', __('Video Attachment', 'robin-app')). '</p>';
    echo '</div>';
}