<?php

if(!empty($get_threads)) {
?>
    <div class="robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection">
      <button class="robin-chat-action-button robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection__select-all" value="select-all-messages">
          <?php echo __('Select All', 'robin-chat'); ?>
      </button>
      <div class="robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection__action-links">
        <button class="robin-chat-action-button robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection__action-links-archive" value="archive-selected-messages">
          <?php echo sprintf('%s <span>%s</span>',  __('Archive', 'robin-chat'), ROBIN_CHAT_ICON_THREAD_ARCHIVE); ?>
        </button>
        <button class="robin-chat-action-button robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection__action-links-delete" value="delete-selected-messages">
            <?php echo sprintf('%s <span>%s</span>',  __('Delete', 'robin-chat'), ROBIN_CHAT_ICON_THREAD_DELETE); ?>
        </button>
      </div>
    </div>
<div class="robin-chat-msg-overlay-list-bubble__chat-messages">
    <?php foreach($get_threads as $key => $get_thread ) {
        include 'chats-thread-single.php';
    }
    ?>
</div>
<?php } ?>
