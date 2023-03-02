<?php

namespace RobinChat\Core\User;

class MessageModal {
    
    public function __construct()
    {
    
    }
    
    public function message_modal_dropdown($options = [])
    {
        if(empty($options)) return '';
        
        ob_start();
        ?>
          <div class="robin-chat-msg-overlay-bubble-header__controls-dropdown-container">
                    <div tabindex="-1" aria-hidden="true" class="robin-chat-msg-overlay-bubble-header__controls-dropdown-content robin-chat-controls-dropdown-content-placement-top robin-chat-controls-dropdown-content-justification-right robin-chat-dropdown-contents">
                        <div class="robin-chat-msg-overlay-bubble-header__controls-dropdown-content-inner">
                            <ul>
                                <?php
                                    foreach ( $options as $option ) {
                                ?>
                                <li><button class="robin-chat-msg-overlay-bubble-header__button robin-chat-select-messages" value="<?php echo $option['value']; ?>">
                                    <span class="full-width">
                                      <span><?php echo $option['name']; ?></span>
                                        <?php
                                            if(!empty($option['icon'])) {
                                        ?>
                                      <span>
                                        <?php echo $option['icon']; ?>
                                      </span>
                                      <?php } ?>
                                    </span>
                                    </button>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Singleton.
     *
     * @return MessageModal
     */
    public static function get_instance()
    {
        static $instance = null;
        
        if (is_null($instance)) {
            $instance = new self();
        }
        
        return $instance;
    }
}