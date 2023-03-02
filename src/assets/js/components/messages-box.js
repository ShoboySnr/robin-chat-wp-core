import $ from 'jquery';

$(document).on('ready', (event) => {
    // when the chat box is maximized
    $('button.robin-chat-msg-overlay-bubble-header__button').on('click', robin_chat_trigger_action_buttons);

    load_messages_on_page_load();

    // close all dropdowns
    $('body').on('click', close_all_dropdowns_content);

    function robin_chat_trigger_action_buttons(event)
    {
        let value = $(this).val();

        if(value === 'toggle-chat-box') toggle_floating_chat(event);

        if(value === 'chat-settings-dropdown') toggle_dropdown_content(event);

        if(value === 'all-messages') fetch_all_messages(event);
        if(value === 'direct-messages') fetch_direct_messages(event);
        if(value === 'group-messages') fetch_group_messages(event);
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