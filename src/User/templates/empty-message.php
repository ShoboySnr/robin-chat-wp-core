<?php
$image_url = ROBIN_CHAT_ASSETS_URL. 'images/no-chats.png';

?>
<div class="robin-chat-msg-overlay-list-bubble-empty-message">
  <img src="<?php echo $image_url; ?>" alt="robin-chat-empty-message" class="robin-chat-msg-overlay-list-bubble-empty-message__image" />
  <div class="robin-chat-msg-overlay-list-bubble-empty-message__text-container">
    <p>
        <?php echo __('No chats yet. Click on the icon to begin a new chat.'); ?>
    </p>
    
    <?php
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none"><path stroke="#039C61" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 2H4.2c-1.12 0-1.68 0-2.108.218a2 2 0 0 0-.874.874C1 3.52 1 4.08 1 5.2v9.6c0 1.12 0 1.68.218 2.108a2 2 0 0 0 .874.874C2.52 18 3.08 18 4.2 18h9.6c1.12 0 1.68 0 2.108-.218a2 2 0 0 0 .874-.874C17 16.48 17 15.92 17 14.8v-4.3m-4.5-7 2.828 2.828m-7.565 1.91 6.648-6.649a2 2 0 1 1 2.828 2.828l-6.862 6.862c-.761.762-1.142 1.143-1.576 1.446-.385.268-.8.491-1.237.663-.492.194-1.02.3-2.076.514L5 14l.047-.332c.168-1.176.252-1.763.443-2.312a6 6 0 0 1 .69-1.377c.323-.482.743-.902 1.583-1.742Z"/></svg>';
    echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('compose-new', $icon, 'robin-chat-compose-new'); ?>
  </div>
</div>
