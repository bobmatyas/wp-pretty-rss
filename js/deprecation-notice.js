(function ($) {
    $(function () {
        $(document).on('click', '#prettyrss-deprecation-notice .notice-dismiss', function () {
            $.post(prettyRssDeprecation.ajaxUrl, {
                action: 'prettyrss_dismiss_deprecation_notice',
                nonce: prettyRssDeprecation.nonce
            });
        });
    });
})(jQuery);
