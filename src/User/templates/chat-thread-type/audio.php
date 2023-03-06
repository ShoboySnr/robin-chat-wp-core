<?php

if(!empty($thread['type'])) {
    echo '<div class="robin-chat-image-message">';
    echo ROBIN_CHAT_ICON_THREAD_AUDIO;
    echo '<p>'. apply_filters('robin_chat_message_thread_message_type_audio', __('Voice Message', 'robin-app')). '</p>';
    echo '<p>'. apply_filters('robin_chat_message_thread_message_type_audio_duration', __('0:18', 'robin-app')). '</p>';
    echo '</div>';
}