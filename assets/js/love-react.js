jQuery(function ($) {
    "use strict";

    if ( typeof LoveReactSettings === 'undefined' ) return;

    $('body').on('click', '.love-react-btn', function () {
        const $btn   = $(this);
        const postID = $btn.data('post');          // ID 

        if ( $btn.hasClass('loved') ) return;

        $.post(
            LoveReactSettings.ajaxUrl,
            {
                action: 'love_react_toggle',
                nonce : LoveReactSettings.nonce,
                postId: postID,                    // AJAX
            },
            function (response) {
                if ( response.success ) {
                    $btn.addClass('loved')
                        .find('.count').text( response.data.count );
                }
            }
        );
    });
});