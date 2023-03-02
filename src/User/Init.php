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
                        <?php
                            echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('chat-settings-dropdown', ROBIN_CHAT_ICON_DOTTED, 'robin-chat-msg-overlay-bubble-header__button robin-chat-dropdown');
                            
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
                          <?php
                              echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('compose-new', ROBIN_CHAT_ICON_COMPOSE_NEW, 'robin-chat-compose-new');
                          ?>
                      </div>
                    </div>
                  </div>
                  <div class="robin-chat-msg-overlay-bubble-header__minimized">
                      <?php
                          echo \RobinChat\Core\User\Init::get_instance()->button_icon_html('toggle-chat-box', ROBIN_CHAT_ICON_ARROW_DOWN, 'robin-chat-msg-overlay-bubble-header__button robin-chat-toggle-message-box');
                      ?>
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
    
    public function button_icon_html($value, $icon, $classes = [])
    {
      
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