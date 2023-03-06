<ul class="robin-chat-msg-overlay-list-bubble__new-chats-action-links">
    <?php
        foreach ($chat_options as $option ) {
    ?>
    <li>
        <button class="robin-chat-action-button robin-chat-msg-overlay-list-bubble__new-chats-action-links-new-group-chat" value="<?php echo $option['value']; ?>">
            <span class="icon">
              <?php echo $option['icon']; ?>
            </span>
            <span class="text">
              <?php echo $option['text']; ?>
            </span>
        </button>
    </li>
    <?php } ?>
</ul>