import $ from 'jquery';

$(document).on('ready', (event) => {
    // when the chat box is maximized
    $(document).on('click', 'button.robin-chat-msg-overlay-bubble-header__button, button.robin-chat-action-button', robin_chat_trigger_action_buttons);
    $(document).on('change', '.robin-chat-msg-overlay-list-bubble__contacts-list-selection input[type="checkbox"]', robin_chat_trigger_contacts_selection);

    load_messages_on_page_load();

    // close all dropdowns
    $('body').on('click', close_all_dropdowns_content);

    function robin_chat_trigger_contacts_selection(event)
    {
        let _this = $(this);

        let all_checked = $('.robin-chat-msg-overlay-list-bubble__contacts-list-selection input[type="checkbox"]:checked');

        if(all_checked.length > 0) {
            $('.robin-chat-msg-overlay-list-bubble__selected-group-members').addClass('is-selected');
        } else {
            $('.robin-chat-msg-overlay-list-bubble__selected-group-members').removeClass('is-selected');
        }

        let all_user_images = all_checked.parents('li').clone();
        all_user_images.find('.robin-chat-msg-overlay-list-bubble__contacts-list-selection').remove();
        all_user_images.find('.robin-chat-msg-overlay-list-bubble__selected-group-members-remove').html('<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none"><path stroke="#071439" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1.5 1.5 9 9m0-9-9 9"/></svg>');

        $('.robin-chat-msg-overlay-list-bubble__selected-group-members').html('');

        $.each(all_user_images, function(key, value) {
            let firstname_value = $(value).find('.name').data('first-name');
            $(value).find('.name').text(firstname_value);
            $('.robin-chat-msg-overlay-list-bubble__selected-group-members').append(value);
        })

    }

    function robin_chat_trigger_action_buttons(event)
    {
        let value = $(this).val();

        if(value === 'toggle-chat-box') toggle_floating_chat(event);

        if(value === 'chat-settings-dropdown') toggle_dropdown_content(event);

        if(value === 'all-messages') fetch_all_messages(event);
        if(value === 'direct-messages') fetch_direct_messages(event);
        if(value === 'group-messages') fetch_group_messages(event);

        //select messages
        if(value === 'select-messages') check_selected_messages(event);

        // select all checked/unchecked messages
        if(value === 'select-all-messages') select_all_messages(event);

        //delete all checked messages
        if(value === 'delete-selected-messages') delete_checked_messages(event);

        //compose new chat
        if(value === 'compose-new') compose_new_chat(event);

        // new group chat
        if(value === 'new-group-chat') new_group_chat(event);


    }

    function toggle_floating_chat(event)
    {
        let _this = event.target;

        let parent_overlay_list = $(_this).parents('.robin-chat-msg-overlay-list-bubble');

        let robin_chat_dropdown = $('.robin-chat-dropdown');

        parent_overlay_list.toggleClass('robin-chat-msg-overlay-list-bubble--is-minimized');

        robin_chat_dropdown.parents('.robin-chat-msg-toggle-dropdown-contents').find('.robin-chat-msg-overlay-bubble-header__controls-dropdown-content').toggleClass('robin-chat-controls-dropdown-content-placement-top').toggleClass('robin-chat-controls-dropdown-content-placement-bottom');
    }


    function toggle_dropdown_content(event)
    {
        event.preventDefault();
        event.stopPropagation();

        let _this = event.target;

        let parent_dotted_class = $(_this).parents('.robin-chat-msg-toggle-dropdown-contents');

        let dropdown_content = parent_dotted_class.find('.robin-chat-msg-overlay-bubble-header__controls-dropdown-content');

        dropdown_content.toggleClass('robin-chat-dropdown-content--is-open');
    }

    function check_selected_messages(event)
    {
        event.preventDefault();
        if($('.robin-chat-msg-overlay-list-bubble__chat-messages-list').length <= 0) return;

        if($('.robin-chat-msg-overlay-list-bubble__chat-messages-group-selection')) {
            $('.robin-chat-msg-overlay-list-bubble__chat-messages-group-selection').toggleClass('robin-chat-msg-overlay-list-bubble__chat-messages-group-selection__is-open');
        }

        if($('.robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection')) {
            $('.robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection').toggleClass('robin-chat-msg-overlay-list-bubble__chat-messages-grouped-selection__is-open');
        }

        if($('.robin-chat-msg-overlay-list-bubble__top-static-area')) {
            $('.robin-chat-msg-overlay-list-bubble__top-static-area').toggleClass('robin-chat-msg-overlay-list-bubble__top-static-area__is_close');
        }
    }

    function select_all_messages(event)
    {
        event.preventDefault();

        let _this = $(event.target);

        if(_this.hasClass('is-all-selected')) {
            $('.robin-chat-msg-overlay-list-bubble__chat-messages-group-selection').find('input[type="checkbox"]').prop('checked', false);
            _this.removeClass('is-all-selected');
            _this.text('Select All');
            console.log(_this);
        } else {
            $('.robin-chat-msg-overlay-list-bubble__chat-messages-group-selection').find('input[type="checkbox"]').prop('checked', true);
            _this.addClass('is-all-selected');
            _this.text('Unselect All');
        }
    }

    function delete_checked_messages(event)
    {
        event.preventDefault();

        if(!confirm('Are you sure you want to delete the selected messages?')) return;

        let all_checked = $('.robin-chat-msg-overlay-list-bubble__chat-messages-group-selection').find('input[type="checkbox"]:checked');

        //delete all checked
        all_checked.parents('.robin-chat-msg-overlay-list-bubble__chat-messages-list').remove();

        //check if there are no conversation left
        if($('.robin-chat-msg-overlay-list-bubble__chat-messages-list').length <= 0) {
            let data = {

            };

            let conversation_list = $('.robin-chat-msg-overlay-list-bubble__conversations-list');

            let request = make_api_request_call('deleteThreads', data);

            request.done(function (response, textStatus, jqXHR) {
                conversation_list.html(response.threads);
                if($('.robin-chat-msg-overlay-list-bubble__top-static-area')) {
                    $('.robin-chat-msg-overlay-list-bubble__top-static-area').toggleClass('robin-chat-msg-overlay-list-bubble__top-static-area__is_close');
                }
            });


            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error('The following error occurred: ' + JSON.stringify(jqXHR) +  textStatus, errorThrown);
            });
        }

    }

    function compose_new_chat(event) {
        if($('.robin-chat-msg-overlay-list-bubble').hasClass('robin-chat-msg-overlay-list-bubble--is-minimized')) toggle_floating_chat(event);

        $('.robin-chat-msg-overlay-list-bubble__new-chats-action-links').removeClass('robin-chat-msg-overlay-list-bubble__new-chats-action-links__is_close');

        event.preventDefault();

        let conversation_list = $('.robin-chat-msg-overlay-list-bubble__conversations-list');

        let data = {

        };

        let request = make_api_request_call('newChat', data);

        request.done(function (response, textStatus, jqXHR) {
            $('.robin-chat-msg-overlay-list-bubble-search').addClass('robin-chat-msg-overlay-list-bubble-search__is_close');
            $('.robin-chat-msg-overlay-list-bubble__top-static-area').addClass('robin-chat-msg-overlay-list-bubble__top-static-area__is_close');
            conversation_list.html(response.threads);
        });


        request.fail(function(jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + JSON.stringify(jqXHR) +  textStatus, errorThrown);
        });

    }

    function new_group_chat(event)
    {
        event.preventDefault();

        let conversation_list = $('.robin-chat-msg-overlay-list-bubble__conversations-list');

        let data = {

        };

        $('.robin-chat-msg-overlay-list-bubble__contacts-list').remove();

        let request = make_api_request_call('newGroupChat', data);

        request.done(function (response, textStatus, jqXHR) {
            $('.robin-chat-msg-overlay-list-bubble-search').addClass('robin-chat-msg-overlay-list-bubble-search__is_close');
            $('.robin-chat-msg-overlay-list-bubble__top-static-area').addClass('robin-chat-msg-overlay-list-bubble__top-static-area__is_close');
            $('.robin-chat-msg-overlay-list-bubble__new-chats-action-links').addClass('robin-chat-msg-overlay-list-bubble__new-chats-action-links__is_close');
            conversation_list.html(response.threads);
        });


        request.fail(function(jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + JSON.stringify(jqXHR) +  textStatus, errorThrown);
        });

    }

    function close_all_dropdowns_content()
    {
        if($('.robin-chat-dropdown-contents').hasClass('robin-chat-dropdown-content--is-open')) {
            $('.robin-chat-dropdown-contents').removeClass('robin-chat-dropdown-content--is-open');
        }
    }

    function load_messages_on_page_load() {
        let conversation_list = $('.robin-chat-msg-overlay-list-bubble__conversations-list');

        let data = {

        };

        let request = make_api_request_call('threads', data);

        request.done(function (response, textStatus, jqXHR) {
            conversation_list.html(response.threads);
        });


        request.fail(function(jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + JSON.stringify(jqXHR) +  textStatus, errorThrown);
        });
    }

    function fetch_all_messages(event)
    {
        event.preventDefault();

        let _this = event.target;

        let data = {

        };

        let conversation_list = $('.robin-chat-msg-overlay-list-bubble__conversations-list');

        const url = robin_chat_js_globals.robin_chat_rest_api_url + 'threads';

        let request = make_api_request_call('threads', data);

        $('.robin-chat-tab-selected').removeClass('robin-chat-tab-selected');

        request.done(function (response, textStatus, jqXHR) {
            conversation_list.html(response.threads);
        });


        request.fail(function(jqXHR, textStatus, errorThrown) {
            console.error('The following error occurred: ' + JSON.stringify(jqXHR) +  textStatus, errorThrown);
        });

        request.always(function () {
            // active select the tab
            $(_this).addClass('robin-chat-tab-selected');
        });

    }

    function fetch_direct_messages(event)
    {
        event.preventDefault();

        let _this = event.target;

        $('.robin-chat-tab-selected').removeClass('robin-chat-tab-selected');

        $(_this).addClass('robin-chat-tab-selected');
    }

    function fetch_group_messages(event)
    {
        event.preventDefault();

        let _this = event.target;

        $('.robin-chat-tab-selected').removeClass('robin-chat-tab-selected');

        $(_this).addClass('robin-chat-tab-selected');
    }


    function make_api_request_call(route, data)
    {
        const url = robin_chat_js_globals.robin_chat_rest_api_url + route;
        let request = $.ajax({
            url,
            type: 'GET',
            beforeSend:  function ( xhr ) {
                xhr.setRequestHeader( 'X-WP-Nonce', robin_chat_js_globals.wp_rest_nonce );
            },
            data,
        });

        return request;
    }
    function fetch_messages(event)
    {
        event.preventDefault();

        let data = {

        };

        console.log(robin_chat_js_globals.robin_chat_rest_api_url);
        return;

        let request = $.ajax({
            url: robin_chat_js_globals.robin_chat_rest_api_url,
            type: 'GET',
            data,
        }, );
    }
});