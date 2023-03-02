<?php

namespace RobinChat\Core\User;


use RobinChat\Core\Core;

define('ROBIN_CHAT_USER_TEMPLATES_DIR', __DIR__.'/templates/' );

class Init {
    
    public function __construct()
    {
        add_action('wp_footer', array($this, 'initialize_floating_chat_bubble'));
    }
    
    
    public function initialize_floating_chat_bubble()
    {
        if (defined('WP_DEBUG') && true === WP_DEBUG) {
            // some debug to add later
        } else {
            error_reporting(0);
        }
    
        do_action('robin_chat_before_generation');
    
        $path = apply_filters('robin_chat_views_path', __DIR__ . '/templates/');
    
        $template = 'layout-index.php';
        
        ob_start();
    
        $template = apply_filters( 'robin_chat_current_template', $path . $template, $template );
        
        if($template !== false) {
            include($template);
        }
    
    
        $content = ob_get_clean();
        $content = str_replace('loading="lazy"', '', $content);
        
        $content = \RobinChat\Core\minify_html($content);
        
        do_action('robin_chat_after_generation');
        
        echo $content;
    }
    
    public function container_placeholder()
    {
        $chat_count = 2;
        ob_start();
        ?>
        <div tabindex="-1" class="robin-chat-msg-overlay-list-bubble robin-chat-msg-overlay-list-bubble--is-minimized">
            <div class="robin-chat-msg-overlay-bubble-header">
                <div class="robin-chat-msg-overlay-bubble-header__badge-container"></div>
                <div class="robin-chat-msg-overlay-bubble-header__details">
                  <div class="robin-chat-msg-overlay-bubble-header__button_controls">
                    <button class="robin-chat-msg-overlay-bubble-header__button robin-chat-toggle-message-box" value="toggle-chat-box">
                    <span>
                      <span aria-hidden="true"><?php echo __('Messages', 'robin-chat'); ?></span>
                      <span class="robin-chat-msg-unread-messages"><?php echo $chat_count; ?></span>
                    </span>
                    </button>
                    <div class="robin-chat-msg-overlay-bubble-header__controls">
                      <div class="robin-chat-msg-overlay-bubble-header__controls-dropdown robin-chat-msg-toggle-dropdown-contents">
                        <button class="robin-chat-msg-overlay-bubble-header__button robin-chat-dropdown" value="chat-settings-dropdown">
                          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" fill="none"><path fill="#000" d="M9 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM2 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm14 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/></svg>
                        </button>
                        <?php
                            
                            $chat_message_settings = [
                                [
                                    'name'      => __('Select Messages', 'robin-chat'),
                                    'icon'      => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path fill="#51545C" d="m9.813 5.86-2.86 2.867-1.1-1.1a.667.667 0 1 0-.94.94L6.48 10.14a.667.667 0 0 0 .94 0l3.334-3.333a.666.666 0 0 0-.47-1.14.667.667 0 0 0-.47.193ZM8 1.333a6.667 6.667 0 1 0 0 13.334A6.667 6.667 0 0 0 8 1.334Zm0 12A5.334 5.334 0 1 1 8 2.667a5.334 5.334 0 0 1 0 10.668Z"/></svg>',
                                    'value'     => 'select-messages'
                                ],
                                [
                                    'name'      => __('Chat Settings', 'robin-chat'),
                                    'icon'      => ' <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"><path fill="#51545C" d="M13.267 8.44a.667.667 0 0 1 0-.88l.853-.96a.667.667 0 0 0 .08-.78l-1.333-2.307a.667.667 0 0 0-.714-.32l-1.253.254a.667.667 0 0 1-.767-.44l-.406-1.22a.667.667 0 0 0-.634-.454H6.427a.667.667 0 0 0-.667.454l-.373 1.22a.667.667 0 0 1-.767.44l-1.287-.254a.667.667 0 0 0-.666.32L1.333 5.82a.667.667 0 0 0 .067.78l.847.96a.667.667 0 0 1 0 .88L1.4 9.4a.667.667 0 0 0-.067.78l1.334 2.307a.667.667 0 0 0 .713.32l1.253-.254a.667.667 0 0 1 .767.44l.407 1.22a.667.667 0 0 0 .666.454H9.14a.667.667 0 0 0 .633-.454l.407-1.22a.667.667 0 0 1 .767-.44l1.253.254a.667.667 0 0 0 .713-.32l1.334-2.307a.668.668 0 0 0-.08-.78l-.9-.96Zm-.994.893.534.6-.854 1.48-.786-.16a2 2 0 0 0-2.3 1.334l-.254.746H6.907l-.24-.76a2 2 0 0 0-2.3-1.333l-.787.16-.867-1.473.534-.6a2 2 0 0 0 0-2.667l-.534-.6.854-1.467.786.16a2 2 0 0 0 2.3-1.333l.254-.753h1.706l.254.76a2 2 0 0 0 2.3 1.333l.786-.16.854 1.48-.534.6a2 2 0 0 0 0 2.653Zm-4.513-4a2.667 2.667 0 1 0 0 5.334 2.667 2.667 0 0 0 0-5.334Zm0 4a1.333 1.333 0 1 1 0-2.666 1.333 1.333 0 0 1 0 2.666Z"/></svg>',
                                    'value'     => 'chat-settings'
                                ]
                            ];
                            
                            $chat_message_settings = apply_filters('robin_chat_dotted_chat_message_options', $chat_message_settings);
                            
                            echo MessageModal::get_instance()->message_modal_dropdown($chat_message_settings);
                            
                         ?>
                      </div>
                      <div class="robin-chat-msg-overlay-bubble-header__controls-compose-new">
                        <button class="robin-chat-msg-overlay-bubble-header__button robin-chat-compose-new" value="compose-new">
                          <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="none"><path stroke="#039C61" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 2H4.2c-1.12 0-1.68 0-2.108.218a2 2 0 0 0-.874.874C1 3.52 1 4.08 1 5.2v9.6c0 1.12 0 1.68.218 2.108a2 2 0 0 0 .874.874C2.52 18 3.08 18 4.2 18h9.6c1.12 0 1.68 0 2.108-.218a2 2 0 0 0 .874-.874C17 16.48 17 15.92 17 14.8v-4.3m-4.5-7 2.828 2.828m-7.565 1.91 6.648-6.649a2 2 0 1 1 2.828 2.828l-6.862 6.862c-.761.762-1.142 1.143-1.576 1.446-.385.268-.8.491-1.237.663-.492.194-1.02.3-2.076.514L5 14l.047-.332c.168-1.176.252-1.763.443-2.312a6 6 0 0 1 .69-1.377c.323-.482.743-.902 1.583-1.742Z"/></svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="robin-chat-msg-overlay-bubble-header__minimized">
                    <button class="robin-chat-msg-overlay-bubble-header__button robin-chat-toggle-message-box">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="8" fill="none"><path fill="#000" d="m7.71 7.54 5.65-5.66A1 1 0 1 0 11.95.46l-5 4.95L2 .46a1 1 0 0 0-1.41 0 1 1 0 0 0-.3.71 1 1 0 0 0 .3.71l5.65 5.66a1 1 0 0 0 1.47 0Z"/></svg>
                    </button>
                  </div>
                </div>
            </div>
            <?php echo Thread::get_instance()->threads_placeholder(); ?>
        </div>
        <div class="robin-chat-msg-overlay__emoji-hoverable-outlet"></div>
        <div class="robin-chat-msg-overlay__reactor-list-outlet"></div>
        <?php
        return ob_get_clean();
    }
    
    public function button_icon_html($value, $icon, $classes = []) {
      
      if(empty($value)) return '';
      
      if(!empty($classes)) {
        if(is_array($classes)) $classes = implode(' ', $classes);
      }
      
      ob_start();
      
      include __DIR__.'/templates/partials/button-icon.php';
      
      return ob_get_clean();
    }
    
    /**
     * Singleton.
     *
     * @return Init
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