<?php
$image_url = ROBIN_CHAT_ASSETS_URL. 'images/no-chats.png';

?>
<div class="robin-chat-msg-overlay-list-bubble-empty-message">
  <img src="<?php echo $image_url; ?>" alt="robin-chat-empty-message" class="robin-chat-msg-overlay-list-bubble-empty-message__image" />
  <div class="robin-chat-msg-overlay-list-bubble-empty-message__text-container">
    <p>
        <?php echo __('No chats yet. Click on the icon to begin a new chat.'); ?>
    </p>
    
    <?php echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('compose-new', ROBIN_CHAT_ICON_COMPOSE_NEW, 'robin-chat-compose-new'); ?>
  </div>
</div>
