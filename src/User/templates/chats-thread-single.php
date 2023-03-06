
<div class="robin-chat-msg-overlay-list-bubble__chat-messages-list">
  <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-grouped-profile-picture">
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-group-selection">
      <input type="checkbox" name="robin-chat-select-messages[]" />
    </div>
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-featured-image">
      <button class="robin-chat-msg-overlay-button robin-chat-action-button" value="view-single-message-page">
        <img src="<?php echo ROBIN_CHAT_DIST_URL. 'images/people/'. $get_thread['image']; ?>" alt="" />
      </button>
    </div>
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-names">
      <div class="robin-chat-full-name"><p><?php echo $get_thread['name']; ?></p></div>
      <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-content">
          <?php echo \RobinChat\Core\User\Thread::get_instance()->get_thread_type($get_thread, $get_thread['message_type']); ?>
      </div>
    </div>
  </div>
  <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-notifications">
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-notifications__time">
      <p><?php echo $get_thread['time']; ?></p>
    </div>
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-list-notifications__status">
      <?php echo \RobinChat\Core\User\Thread::get_instance()->message_status($get_thread, $get_thread['message_status']); ?>
    </div>
  </div>
</div>