jQuery(document).ready(function () {
    jQuery('.qsm-navigator-color-field').wpColorPicker();
    jQuery('.qsm-navigator-color-field').each(function () {
        if (jQuery(this).attr('data-label')) {
            jQuery(this).parents('.wp-picker-container').find('.wp-color-result-text').html( jQuery(this).attr('data-label') );
        }
    });
    jQuery(document).on('change', 'input[name="qsm_quiz_navigator_shortcode"]', function (){
        if ( jQuery(this).is(':checked') ) {
            jQuery('.qsm-navigator-shortcode-main').css('visibility', 'visible');
            if ( jQuery('.qsm-navigator-shortcode-main').data('first') ) {
                jQuery('#qsm-quiz-navigator-layout').val('grid');
            }
        } else {
            jQuery('.qsm-navigator-shortcode-main').css('visibility', 'hidden');
        }
    });

    jQuery(document).on('change', 'input[name="qsm_quiz_navigator_enable"]', function (){
        if ( jQuery(this).is(':checked') ) {
            jQuery('#tabs-quiz-navigator').removeClass('qsm-navigator-disabled');
        } else {
            jQuery('#tabs-quiz-navigator').addClass('qsm-navigator-disabled');
        }
    });

    jQuery(document).on('click', '.qsm-navigator-shortcode-main .qsm-navigator-shortcode-info', function () {
        var shortcodeContainer = jQuery(this).parent('.qsm-navigator-shortcode-main');
        var shortcode = shortcodeContainer.find('.qsm-navigator-shortcode').html();

        shortcodeContainer.find('.qsm-navigator-copy-msg').hide();
        shortcodeContainer.find('.qsm-navigator-copy-success').fadeIn();

        qsmNavigatorcopyToClipboard(shortcode);

        // Reverse the display condition after 5 seconds
        setTimeout(function () {
            shortcodeContainer.find('.qsm-navigator-copy-success').hide();
            shortcodeContainer.find('.qsm-navigator-copy-msg').fadeIn();
        }, 3000);
    });


    function qsmNavigatorcopyToClipboard(text) {
        var textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }

});
