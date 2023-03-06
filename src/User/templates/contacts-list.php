<ul class="robin-chat-msg-overlay-list-bubble__contacts-list">
    <?php
        foreach ($contacts as $contact ) {
    ?>
    <li>
        <label for="robin-chat-select-messages-<?php echo $contact['uid']; ?>" class="robin-chat-action-button" value="single-chat-conversation">
          <span class="image">
           <img src="<?php echo ROBIN_CHAT_DIST_URL. 'images/people/'. $contact['image']; ?>" alt="" />
            <button class="robin-chat-msg-overlay-list-bubble__selected-group-members-remove"></button>
          </span>
          <span class="name" data-first-name="<?php echo $contact['first_name']; ?>">
            <?php echo $contact['name']; ?>
          </span>
        </label>
        <?php
            if(!empty($show_checkbox)) {
        ?>
        <div class="robin-chat-msg-overlay-list-bubble__contacts-list-selection">
          <input id="robin-chat-select-messages-<?php echo $contact['uid']; ?>" type="checkbox" name="robin-chat-select-messages[]" />
        </div>
        <?php } ?>
    </li>
    <?php
        }
    ?>
</ul>