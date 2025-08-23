jQuery(document).ready(function () {
    jQuery(document).on('qsm_next_button_click_after qsm_previous_button_click_after', function (event, quiz_id) {
        let container = jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id);
        let pre_page = container.find('.qsm-pages-number.active');
        container.find('.qsm-pages-number').removeClass('active');

        let questionPages = jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page');
        if (questionPages.length) {
            if (jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page:visible').length) {
                let current_page = jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page:visible').data("qpid");
                container.find('.qsm-pages-number-' + current_page).addClass("active");
            }
            questionPages.each(function () {
                let page_id = jQuery(this).data("qpid");
                let page_number = container.find('.qsm-pages-number-' + page_id);

                if (pre_page.length && (pre_page.data('number') == page_id || pre_page.data('number') > page_id)) {
                    let skip_answer = 0;
                    jQuery(this).find('.qsm-question-wrapper:not(".question-type-13, .question-type-15")').each(function () {
                        if (jQuery(this).find('.qsm_dropdown').length) {
                            if ( null === jQuery(this).find('.qsm_dropdown').val() ) {
                                skip_answer++;
                            }
                        } else if (jQuery(this).find('.mlw_answer_date').length) {
                            if ( "" === jQuery(this).find('.qsm_dropdown').val() ) {
                                skip_answer++;
                            }
                        } else if (jQuery(this).find('.mlw_answer_number, .mlw_answer_open_text, .mlw_answer_open_text, .qmn_fill_blank, .mlw_answer_file_upload ').length) {
                            if ( "" === jQuery(this).find('.mlw_answer_number, .mlw_answer_open_text, .mlw_answer_open_text, .qmn_fill_blank, .mlw_answer_file_upload ').val() ) {
                                skip_answer++;
                            }
                        } else if ( ( !jQuery(this).find('input:not([type="hidden"])').is(':checked') || jQuery(this).find('input[type="radio"][value=""]:checked').length !== 0)
                            && jQuery(this).find('input:not([type="hidden"])').filter(':not(:empty)').length === 0
                        ) {
                            skip_answer++;
                        }
                    });
                    let page_class = 'qsm-navigator-page-status-' + (skip_answer ? 'skipped' : 'completed');
                    console.log(page_class);
                    if ('qsm-navigator-page-status-completed' == page_class) {
                        page_number.removeClass('qsm-navigator-page-status-skipped qsm-navigator-page-status-required').addClass(page_class);
                    }
                    if ( jQuery(this).find('.qmn_error').length ) {
                        page_class += ' qsm-navigator-page-status-required';
                    }
                    page_number.removeClass('qsm-navigator-page-status-skipped qsm-navigator-page-status-completed').addClass(page_class);
                }
            });
            if (jQuery('.qsm-quiz-container-' + quiz_id + ':not(.qsm-quiz-navigator-answers-wrap-shortcode) .quiz_begin').is(':visible')) {
                jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id + ':not(.qsm-quiz-navigator-answers-wrap-shortcode)').hide();
            } else if( jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id ).is(':hidden') ) {
                jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id + ':not(.qsm-quiz-navigator-answers-wrap-shortcode)').fadeIn();
                qsmNavigatorCheckOverflow();
            }
        }

        // Scroll to center if not visible
        let overflowContainer = jQuery('.qsm-quiz-navigator-overflow.qsm-quiz-navigator-answers-wrap-' + quiz_id);
        if (overflowContainer.length && container.find('.qsm-pages-number.active').length) {
            qsmNavigatorScrollIntoViewIfNeeded(quiz_id);
        }
    });

    // Function to scroll the element to the center if not visible
    function qsmNavigatorScrollIntoViewIfNeeded(quiz_id) {
        var containers = jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id + ' .qsm-quiz-navigator-pages');
        containers.each(function () {
            var container = jQuery(this);
            var activePage = container.find('.qsm-pages-number.active');
            var containerLeft = container.scrollLeft();
            var elementLeft = activePage.position().left + containerLeft;
            var scrollPosition = elementLeft - container.width() / 2 + activePage.width() / 2;
            container.scrollLeft(scrollPosition);
        });
    }

    jQuery(document).on('click', '.qsm-quiz-navigator-pages .qsm-pages-number', function () {
        let quiz_id = jQuery(this).data('quiz-id');
        let current_page;

        let activePage = jQuery(this).parent('.qsm-quiz-navigator-answers-wrap').find('.qsm-pages-number.active');
        if (activePage.length) {
            current_page = activePage.data('number');
        } else if (jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page:visible').length) {
            current_page = jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page:visible').data("qpid");
        } else if (!jQuery('.qsm-quiz-container-' + quiz_id + ' .mlw_previous:visible').length) {
            current_page = 0;
        } else if (!jQuery('.qsm-quiz-container-' + quiz_id + ' .mlw_custom_next:visible').length) {
            current_page = jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page').length + 1;
        }

        let next_page = jQuery(this).data('number');
        let page_diff = next_page - current_page;

        if (page_diff > 0) {
            for (let i = 0; i < page_diff; i++) {
                jQuery(".qsm-quiz-container-" + quiz_id + " .mlw_custom_next").trigger('click');
            }
        } else if (page_diff < 0) {
            for (let i = 0; i > page_diff; i--) {
                jQuery(".qsm-quiz-container-" + quiz_id + " .mlw_previous").trigger('click');
            }
        }
    });

    function qsmNavigatorCheckOverflow() {
        jQuery('.qsm-quiz-navigator-answers-wrap-horizontal').each(function () {
            var container = jQuery(this).find('.qsm-quiz-navigator-pages');
            var isOverflowing = container[0].scrollWidth > Math.ceil( container.innerWidth() );
            var left_offset = container.find('.qsm-pages-number').offset().left
            if (isOverflowing || left_offset < 0 ) {
                jQuery(this).addClass('qsm-quiz-navigator-overflow');
            } else {
                jQuery(this).removeClass('qsm-quiz-navigator-overflow');
            }
        });
    }

    // Initial check on document ready
    qsmNavigatorCheckOverflow();

    // Check on window resize (in case of dynamic changes)
    jQuery(window).on('resize', function () {
        qsmNavigatorCheckOverflow();
    });

    // Left arrow click event
    jQuery('.qsm-quiz-navigator-arrow-left').on('click', function () {
        var container = jQuery(this).closest('.qsm-quiz-navigator-answers-wrap').find('.qsm-quiz-navigator-pages');
        container.animate({scrollLeft: container.scrollLeft() - 200}, 'fast');
    });

    // Right arrow click event
    jQuery('.qsm-quiz-navigator-arrow-right').on('click', function () {
        var container = jQuery(this).closest('.qsm-quiz-navigator-answers-wrap').find('.qsm-quiz-navigator-pages');
        container.animate({scrollLeft: container.scrollLeft() + 200}, 'fast');
    });

    jQuery('.qsm-quiz-navigator-answers-wrap-skip').each(function () {
        let quiz_id = jQuery(this).data('quiz-id');
        let quiz_container = jQuery('.qsm-quiz-container-' + quiz_id);

        const classMappings = {
            'mlwRequiredNumber': 'qsm-navigator-required-number',
            'mlwRequiredDate': 'qsm-navigator-required-date',
            'mlwRequiredText': 'qsm-navigator-required-text',
            'mlwRequiredAccept': 'qsm-navigator-required-accept',
            'mlwRequiredRadio': 'qsm-navigator-required-radio',
            'mlwRequiredCaptcha': 'qsm-navigator-required-captcha',
            'mlwRequiredFileUpload': 'qsm-navigator-required-file',
            'qsmRequiredSelect': 'qsm-navigator-required-select',
            'mlwRequiredCheck': 'qsm-navigator-required-checkbox'
        };

        for (const classToFind in classMappings) {
            const targetClass = classMappings[classToFind];
            if (quiz_container.find('.' + classToFind).length) {
                quiz_container.find('.' + classToFind).addClass(targetClass).removeClass(classToFind);
            }
        }
    });

    jQuery(document).on('qsm_quiz_submit_trigger', function (event, quiz_id) {
        let quiz_container = jQuery('.qsm-quiz-container-' + quiz_id);

        const classMappings = {
            'qsm-navigator-required-number': 'mlwRequiredNumber',
            'qsm-navigator-required-date': 'mlwRequiredDate',
            'qsm-navigator-required-text':'mlwRequiredText',
            'qsm-navigator-required-accept': 'mlwRequiredAccept',
            'qsm-navigator-required-radio':'mlwRequiredRadio',
            'qsm-navigator-required-captcha': 'mlwRequiredCaptcha',
            'qsm-navigator-required-file': 'mlwRequiredFileUpload',
            'qsm-navigator-required-select': 'qsmRequiredSelect',
            'qsm-navigator-required-checkbox': 'mlwRequiredCheck'
        };

        for (const classToFind in classMappings) {
            const targetClass = classMappings[classToFind];
            if (quiz_container.find('.' + classToFind).length) {
                quiz_container.find('.' + classToFind).addClass(targetClass).removeClass(classToFind);
            }
        }
    })
    jQuery(document).on('qsm_after_validation', function (event, element, quiz_form_id) {
        let quiz_id = quiz_form_id.replace('quizForm', '');
        let questionPages = jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-question-page');
        let container = jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id);
        if (questionPages.length) {
            questionPages.each(function () {
                let page_id = jQuery(this).data("qpid");
                let page_number = container.find('.qsm-pages-number-' + page_id);
                if ( jQuery(this).find('.qmn_error').length ) {
                    let page_class = 'qsm-navigator-page-status-required';
                    page_number.removeClass('qsm-navigator-page-status-skipped qsm-navigator-page-status-completed').addClass(page_class);
                }
            });
        }
    });
    if (jQuery(window).width() > 500) {
        jQuery('.quiz_theme_default').each(function () {
            let $this = jQuery(this);
            let quiz_id = $this.find('.qmn_quiz_id').val();

            if (qmn_quiz_data[quiz_id] && 1 != qmn_quiz_data[quiz_id].progress_bar) {
                let navigatorWrap = $this.next('.qsm-quiz-navigator-answers-wrap-' + quiz_id + ':not(.qsm-quiz-navigator-answers-wrap-shortcode)');

                if (navigatorWrap.length > 0) {
                    $this.find('.qsm-progress-bar').replaceWith(navigatorWrap);

                    let pre_btn_width = $this.find('.mlw_previous').outerWidth();
                    let next_btn_width = $this.find('.mlw_next').outerWidth();
                    let total_width = parseFloat(next_btn_width) + parseFloat(pre_btn_width) + 35;
                    total_width = Math.ceil(total_width);

                    navigatorWrap.css('width', 'calc(100% - ' + total_width + 'px)');
                }
            }
        });
    }

    jQuery(document).on('qsm_after_quiz_submit', function(e, quiz_form_id) {
        let quiz_id = quiz_form_id.replace("quizForm", "");
        jQuery('.qsm-quiz-navigator-answers-wrap-' + quiz_id).fadeOut();
    })

});