var QSMPageTimer;
jQuery(document).ready(function () {
    if (typeof qmn_quiz_data == 'undefined' || !qmn_quiz_data) {
        return;
    }
    _.each(qmn_quiz_data, function (quiz) {
        let quiz_id = parseInt(quiz.quiz_id);

        //sets the started time of quiz to localStorage
        if (qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.timer_continues_after_closing == 'yes' && localStorage.getItem("begins_at_quiz" + quiz_id) == null) {
            localStorage.setItem("begins_at_quiz" + quiz_id, new Date().getTime());
        }

        let current_page_status = localStorage.getItem("qsm_quiz_current_page_" + quiz_id);

        if (qmn_quiz_data[quiz_id].advanced_timer.timer_continues_after_closing == 'yes' && current_page_status) {
            _.each(qmn_quiz_data[quiz_id].qpages, function (qpage) {
                if (localStorage.getItem("qsm_quiz_current_page_started_at_" + quiz_id + "page_" + qpage.id) && qpage.pagetimer != 0) {
                    let started_time = localStorage.getItem("qsm_quiz_current_page_started_at_" + quiz_id + "page_" + qpage.id);
                    let timeDiff = Math.round((new Date().getTime() - started_time) / 1000);
                    let pageTime = qpage.pagetimer * 60;
                    let finalRemainingTime = pageTime - timeDiff;
                    if (undefined != pageTime && finalRemainingTime > 0) {
                        qpage.timerRemaning = finalRemainingTime;
                    } else {
                        qpage.timerRemaning = 1;
                    }
                }
            })
        }

        if (localStorage.getItem("begins_at_quiz" + quiz_id) !== undefined && qmn_quiz_data[quiz_id].advanced_timer.timer_continues_after_closing == 'yes') {
            let quizBeginTime = parseInt(localStorage.getItem("begins_at_quiz" + quiz_id));
            let timeDifference = Math.round((new Date().getTime() - quizBeginTime) / 1000);
            let quizTimeInSeconds = qmn_quiz_data[quiz_id].timer_limit * 60;
            if (quizTimeInSeconds > timeDifference) {
                localStorage.setItem("mlw_time_consumed_quiz" + quiz_id, timeDifference);
            } else {
                localStorage.setItem("mlw_time_consumed_quiz" + quiz_id, quizTimeInSeconds - 1);
            }
        }
    });

    QSMPageTimer = {
        /**
         * Init Page Timer
         */
        initPageTimer: function (quizID, $currentpage) {
            jQuery(document).trigger('qsm_init_page_timer_before', [quizID, $currentpage]);
            var $quizForm = QSM.getQuizForm(quizID);
            var pid = $currentpage.data('pid');
            if (undefined != pid) {
                var $qpages = qmn_quiz_data[quizID].qpages;
                var $curr_page_opt = $qpages[pid];
                if (($curr_page_opt.hasOwnProperty('pagetimer') && 0 != $curr_page_opt.pagetimer) || ($curr_page_opt.hasOwnProperty('pagetimer_second') && 0 != $curr_page_opt.pagetimer_second)) {
                    var $timer_box = $currentpage.find('.qsm-pagetimer');
                    var seconds = 0;
                    var timerStarted = localStorage.getItem('mlw_started_q' + quizID + '_page' + pid);
                    var timerStoped = localStorage.getItem('mlw_stoped_q' + quizID + '_page' + pid);
                    var timerRemaning = localStorage.getItem('mlw_time_q' + quizID + '_page' + pid);
                    if (timerStoped != 'undefined' && timerStoped > 0 && 'yes' != timerStarted) {
                        seconds = timerStoped;
                    } else if ('yes' == timerStarted) {
                        if (0 < timerRemaning) {
                            seconds = parseInt(timerRemaning);
                        }
                    } else {
                        seconds = parseFloat($curr_page_opt.pagetimer) * 60;
                        if ($curr_page_opt.hasOwnProperty('pagetimer_second') && "" != $curr_page_opt.pagetimer_second) {
                            seconds = seconds + parseInt($curr_page_opt.pagetimer_second);
                        }
                    }
                    if (qmn_quiz_data[quizID].hasOwnProperty('advanced_timer') && qmn_quiz_data[quizID].advanced_timer.timer_continues_after_closing == "yes" && qmn_quiz_data[quizID].qpages[pid].timerRemaning != undefined) {
                    } else { qmn_quiz_data[quizID].qpages[pid].timerRemaning = seconds; }
                    /* Makes the timer appear. */
                    if (!qmn_quiz_data[quizID].hasOwnProperty('advanced_timer')) {
                        $timer_box.show();
                    }
                    $timer_box.text(QSMPageTimer.secondsToTimer(seconds));
                    /* Sets up timer interval. */
                    qmn_quiz_data[quizID].qpages[pid].timerInterval = setInterval(QSMPageTimer.timer, 1000, quizID, pid, $timer_box);
                }
                $currentpage.find('.page_intro_wrapper video').each(function () {
                    var $this = jQuery(this);
                    var src = $this.find('source').attr('src');
                    $this.attr('src', src)
                    $this.load();
                    $this.get(0).play();
                });
            }
            jQuery(document).trigger('qsm_init_page_timer_after', [quizID, $currentpage]);
        },
        /**
         * Reduces the timer by one second and checks if timer is 0
         * @param int quizID The ID of the quiz.
         */
        timer: function (quizID, pid, $timer_box) {
            var $quizForm = QSM.getQuizForm(quizID);
            var $page = qmn_quiz_data[quizID].qpages[pid];
            qmn_quiz_data[quizID].qpages[pid].timerRemaning -= 1;
            if (0 > qmn_quiz_data[quizID].qpages[pid].timerRemaning) {
                qmn_quiz_data[quizID].qpages[pid].timerRemaning = 0;
            }
            var total_seconds = parseFloat($page.pagetimer) * 60;
            if ($page.hasOwnProperty('pagetimer_second') && "" != $page.pagetimer_second) {
                if ($page.pagetimer == "" || $page.pagetimer == 0) {
                    var total_seconds = 0;
                }
                total_seconds = parseInt(total_seconds) + parseInt($page.pagetimer_second);
            }
            var secondsRemaining = qmn_quiz_data[quizID].qpages[pid].timerRemaning;
            var display = QSMPageTimer.secondsToTimer(secondsRemaining);
            $timer_box.text(display);
            jQuery(document).trigger('qsm_change_timer', [quizID, secondsRemaining, $page.pagetimer, total_seconds]);
            var pageTimeTaken = total_seconds - secondsRemaining;
            jQuery('#pagetime_' + pid).val(pageTimeTaken);
            /* Sets our local storage values for the timer being started and current timer value. */
            localStorage.setItem('mlw_started_q' + quizID + '_page' + pid, "yes");
            localStorage.setItem('mlw_time_q' + quizID + '_page' + pid, secondsRemaining);
            jQuery(document).trigger('display_page_timer_warning', [$page, secondsRemaining, $timer_box]);
            /* If timer is run out, disable fields. */
            if (0 >= secondsRemaining) {
                clearInterval(qmn_quiz_data[quizID].qpages[pid].timerInterval);

                jQuery(".qsm-page:visible input:radio").attr('disabled', true);
                jQuery(".qsm-page:visible input:checkbox").attr('disabled', true);
                jQuery(".qsm-page:visible select").attr('disabled', true);
                jQuery(".qsm-page:visible .mlw_qmn_question_comment").attr('disabled', true);
                jQuery(".qsm-page:visible .mlw_answer_open_text").attr('disabled', true);
                jQuery(".qsm-page:visible .mlw_answer_number").attr('disabled', true);

                QSMPageTimer.endPageTimer(quizID);
                MicroModal.show('modal-page-1');
                return;
            }
        },
        /**
         * Clears timer interval
         * @param int quizID The ID of the quiz
         */
        endPageTimer: function (quizID, clearStorage = false) {
            jQuery.each(qmn_quiz_data[quizID].qpages, function (i, value) {
                if ((value.hasOwnProperty('pagetimer') && 0 != value.pagetimer) || value.hasOwnProperty('pagetimer_second') && 0 != value.pagetimer_second) {
                    if (clearStorage) {
                        localStorage.removeItem('mlw_started_q' + quizID + '_page' + value.id);
                        localStorage.removeItem('mlw_stoped_q' + quizID + '_page' + value.id);
                        localStorage.removeItem('mlw_time_q' + quizID + '_page' + value.id);
                    }
                    var secondsRemaining = qmn_quiz_data[quizID].qpages[value.id].timerRemaning;
                    var timerStarted = localStorage.getItem('mlw_started_q' + quizID + '_page' + value.id);
                    var timerStoped = localStorage.getItem('mlw_stoped_q' + quizID + '_page' + value.id);
                    var timerRemaning = localStorage.getItem('mlw_time_q' + quizID + '_page' + value.id);
                    if (timerStoped != 'undefined' && timerStoped > 0) {
                        secondsRemaining = timerStoped;
                    } else if ('yes' == timerStarted) {
                        if (0 < timerRemaning) {
                            secondsRemaining = parseInt(timerRemaning);
                        }
                    } else {
                        secondsRemaining = parseFloat(qmn_quiz_data[quizID].qpages[value.id].pagetimer) * 60;
                        if (qmn_quiz_data[quizID].qpages[value.id].hasOwnProperty('pagetimer_second') && "" != qmn_quiz_data[quizID].qpages[value.id].pagetimer_second) {
                            secondsRemaining = secondsRemaining + parseInt(qmn_quiz_data[quizID].qpages[value.id].pagetimer_second);
                        }
                    }
                    localStorage.setItem('mlw_stoped_q' + quizID + '_page' + value.id, secondsRemaining);
                    if (typeof qmn_quiz_data[quizID].qpages[value.id].timerInterval != 'undefined') {
                        clearInterval(qmn_quiz_data[quizID].qpages[value.id].timerInterval);
                    }
                }
            });
        },
        /**
         * Converts seconds to 00:00:00 format
         * @param int seconds The number of seconds
         * @return string A string in H:M:S format
         */
        secondsToTimer: function (seconds) {
            var formattedTime = '';
            seconds = parseInt(seconds);
            var hours = Math.floor(seconds / 3600);
            if (0 === hours) {
                formattedTime = '00:';
            } else if (10 > hours) {
                formattedTime = '0' + hours + ':';
            } else {
                formattedTime = hours + ':';
            }
            var minutes = Math.floor((seconds % 3600) / 60);
            if (0 === minutes) {
                formattedTime = formattedTime + '00:';
            } else if (10 > minutes) {
                formattedTime = formattedTime + '0' + minutes + ':';
            } else {
                formattedTime = formattedTime + minutes + ':';
            }
            var remainder = Math.floor((seconds % 60));
            if (0 === remainder) {
                formattedTime = formattedTime + '00';
            } else if (10 > remainder) {
                formattedTime = formattedTime + '0' + remainder;
            } else {
                formattedTime = formattedTime + remainder;
            }
            return formattedTime;
        },
    }

    jQuery(document).on('end_page_timer_init_page_timer', function (event, quiz_id, $currentPage) {
        QSMPageTimer.endPageTimer(quiz_id);
        QSMPageTimer.initPageTimer(quiz_id, $currentPage);
    });

    jQuery(document).on('start_stop_page_timer', function (event, quizID) {
        if (qmn_quiz_data[quizID].hasOwnProperty('advanced_timer') && (qmn_quiz_data[quizID].advanced_timer.hasOwnProperty('show_stop_timer') && qmn_quiz_data[quizID].advanced_timer.hasOwnProperty('show_stop_timer') == 'yes')) {
            QSMPageTimer.endPageTimer(quizID, true);
        }
    });

    jQuery(document).on('qsm_init_page_timer_after', function (event, quiz_id, $currentpage) {
        var pageId = $currentpage.data('pid');
        var $quizForm = QSM.getQuizForm(quiz_id);
        var $custom_timer = 0;
        if ($quizForm.find('.linear-custom-timer').length) {
            $custom_timer = $quizForm.find('.linear-custom-timer');
        } else if ($quizForm.find('.qsm-v-line-timer-top').length) {
            $custom_timer = $quizForm.find('.qsm-v-line-timer-top');
        } else if ($quizForm.find('.box-timer-top').length) {
            $custom_timer = $quizForm.find('.box-timer-top');
        } else if ($quizForm.find('.oval-timer-top').length) {
            $custom_timer = $quizForm.find('.oval-timer-top');
        } else if ($quizForm.find('.half-circle-timer').length) {
            $custom_timer = $quizForm.find('.half-circle-timer');
        } else if ($quizForm.find('.qsm-shade-circle-timer').length) {
            $custom_timer = $quizForm.find('.qsm-shade-circle-timer');
        } else if ($quizForm.find('.circle-custom-timer').length) {
            $custom_timer = $quizForm.find('.circle-custom-timer');
        } else if ($quizForm.find('.custom-mlw_qmn_timer').length) {
            $custom_timer = $quizForm.find('.custom-mlw_qmn_timer');
        }
        if ($custom_timer != 0) {
            $custom_timer.hide();
        }
        if (qmn_quiz_data[quiz_id].advanced_timer.timer_continues_after_closing == 'yes'
            && undefined != pageId) {
            localStorage.setItem("qsm_quiz_current_page_" + quiz_id, pageId);
            if (localStorage.getItem("qsm_quiz_current_page_started_at_" + quiz_id + "page_" + pageId) == null
                && qmn_quiz_data[quiz_id].qpages[pageId].pagetimer != null && qmn_quiz_data[quiz_id].advanced_timer.show_stop_timer == 'no') {
                localStorage.setItem("qsm_quiz_current_page_started_at_" + quiz_id + "page_" + pageId, new Date().getTime());
            }
        }
    });

    jQuery(document).on('qsm_before_form_data_process', function (event, quiz_form_id, unindexed_array) {
        let quiz_id = quiz_form_id.replace("quizForm", "");
        let timer_ms = new Date().getTime();
        let started_time = localStorage.getItem("begins_at_quiz" + quiz_id);
        if (qmn_quiz_data[quiz_id].advanced_timer.timer_continues_after_closing == 'yes' && started_time) {
            let time_taken = Math.round(Math.abs(started_time - timer_ms) / 1000);
            _.each(unindexed_array, function (item) {
                if (item.name == 'timer') {
                    item.value = time_taken;
                }
            })
        }
    })

    //Unset the started time of quiz to localStorage after quiz submission
    jQuery(document).on('qsm_after_quiz_submit', function (event, quiz_form_id) {
        let quiz_id = quiz_form_id.replace("quizForm", "");
        localStorage.removeItem("begins_at_quiz" + quiz_id);
        localStorage.removeItem("qsm_quiz_current_page_" + quiz_id);
        _.each(qmn_quiz_data[quiz_id].qpages, function (qpage) {
            localStorage.removeItem("qsm_quiz_current_page_started_at_" + quiz_id + "page_" + qpage.id);
            localStorage.removeItem('time_taken_' + quiz_id + '_page' + qpage.id);
            localStorage.removeItem('mlw_started_q' + quiz_id + '_page' + qpage.id);
            localStorage.removeItem('mlw_stoped_q' + quiz_id + '_page' + qpage.id);
            localStorage.removeItem('mlw_time_q' + quiz_id + '_page' + qpage.id);
        })
    });

    jQuery('.stoptimer').click(function (e) {
        e.preventDefault();
        MicroModal.show('stop-timer-popup');
        var quiz_id = jQuery("#qmn_quiz_id").val();
        QSM.endTimer(quiz_id);
        clearInterval(qsmTimerInterval[quiz_id]);
        localStorage.setItem('mlw_time_consumed_quiz' + quiz_id, qmn_quiz_data[quiz_id].timerConsumed);
        QSMPageTimer.endPageTimer(quiz_id);
    });

    jQuery(document).on('qsm_before_quiz_submit', function (event, quiz_form_id) {
        let quiz_id = quiz_form_id.replace("quizForm", "");
        if (qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_stop_timer')) {
            QSMPageTimer.endPageTimer(quiz_id);
        }
    });

    //Submit the form on popup click
    jQuery('.stop-timer-submit-the-form').click(function (e) {
        e.preventDefault();
        var quiz_id = jQuery("#qmn_quiz_id").val();
        qsmEndTimeTakenTimer();
        QSM.endTimer(quiz_id);
        clearInterval(qsmTimerInterval[quiz_id]);
        localStorage.removeItem('mlw_time_quiz' + quiz_id);
        localStorage.setItem('mlw_time_consumed_quiz' + quiz_id, 1);
        jQuery('#quizForm' + quiz_id).submit();
        jQuery('#stop-timer-popup').removeClass('is-open');
    });

    jQuery('.stop-timer-continue-the-quiz').click(function (e) {
        e.preventDefault();
        var quizID = jQuery("#qmn_quiz_id").val();
        if (!isNaN(qmn_quiz_data[quizID].timerRemaning)) {
            qmn_quiz_data[quizID].timerInterval = setInterval(QSM.timer, 1000, quizID);
            qsmTimerInterval[quizID] = setInterval(function () { qmnTimeTakenTimer(quizID) }, 1000);
        }
        jQuery('#stop-timer-popup').removeClass('is-open');
        advanceAutoPageTimerContinue(quizID);
    });
    //Check stop timer div
    if (jQuery('.stoptimer-p').length > 0) {
        jQuery('.stoptimer-p').parents('.qsm-quiz-container').addClass('qsm-stop-timer-enabled');
    }

    jQuery('.pagetime-goto-nextslide').click(function (e) {
        e.preventDefault();
        var quiz_id = jQuery(this).data('quiz_id');
        var $apid = jQuery('.qsm-auto-page-row:visible').data('apid');
        var $container = jQuery('#quizForm' + quiz_id).closest('.qmn_quiz_container');
        var maxDataapid = 0;
        jQuery('.qsm-auto-page-row').each(function () {
            var dataapid = jQuery(this).data('apid');
            if (maxDataapid < dataapid) {
                maxDataapid = dataapid;
            }
        });
        if (!$container.find('.qsm-submit-btn').is(':visible')) {
            if (maxDataapid != $apid) {
                qmnNextSlide($apid + 1, 1, '#quizForm' + quiz_id);
                advanceAutoPageTimerContinue(quiz_id);
            }
        } else {
            $container.find(".mlw_custom_next").hide();
        }
    });

    jQuery(document).on('load_timer_faces', function (event, quizID, secondsRemaining, total_seconds, display) {
        var quizData = qmn_quiz_data[quizID];
        var advancedTimer = quizData ? quizData.advanced_timer : null;
        var $quizForm = QSM.getQuizForm(quizID);
        if (advancedTimer && advancedTimer.qsm_timer_count_upwards == 1) {
            secondsRemaining = quizData.timerConsumed - 1;
        }
        if (advancedTimer && advancedTimer.show_stop_timer && advancedTimer.timer_design === 'big_timer') {
            var $secondCircle = jQuery(".second.circle");
            $secondCircle.parent('.mlw_quiz_form').addClass('qsm_big_timer');
            $secondCircle.show();
            $secondCircle.find('strong').html(display);
            var hiddenTimerValue = jQuery(".hiddentimer").html();
            var datashow = (hiddenTimerValue - secondsRemaining) / hiddenTimerValue;
            $secondCircle.circleProgress({
                startAngle: 11,
                value: datashow,
                animation: false,
                fill: { gradient: ["#00bb40", "#00511c"] }
            });
        } else if ($quizForm.find('.linear-custom-timer').length) {
            linearFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        } else if ($quizForm.find('.qsm-v-line-timer-top').length) {
            vLineFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        } else if ($quizForm.find('.box-timer-top').length) {
            boxFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        } else if ($quizForm.find('.oval-timer-top').length) {
            ovalFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        } else if ($quizForm.find('.half-circle-timer').length) {
            halfFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        } else if ($quizForm.find('.qsm-shade-circle-timer').length) {
            shadeFormatTimeLeft(quizID, secondsRemaining, total_seconds);
        }
    });

    jQuery(document).on('display_page_timer_warning', function (event, $page, secondsRemaining, $timer_box) {
        if (!$page.hasOwnProperty('warning_checkbox') && ($page.hasOwnProperty('pagetimer_warning') && 0 != $page.pagetimer_warning)) {
            $page.warning_checkbox = "1";
        }
        if ((($page.hasOwnProperty('pagetimer_warning') && 0 != $page.pagetimer_warning) || ($page.hasOwnProperty('pagetimer_warning_second') && 0 != $page.pagetimer_warning_second)) && ($page.hasOwnProperty('warning_checkbox') && 0 != $page.warning_checkbox)) {
            if ($page.pagetimer_warning == "") {
                $page.pagetimer_warning = 0;
            }
            var page_warning_sec = parseFloat($page.pagetimer_warning) * 60;
            if ($page.hasOwnProperty('pagetimer_warning_second') && "" != $page.pagetimer_warning_second) {
                page_warning_sec = page_warning_sec + parseInt($page.pagetimer_warning_second);
            }
            if (Math.round(page_warning_sec) == secondsRemaining) {
                $timer_box.parents('.qsm-page').find('.qsm-pagetimer-warning').fadeIn();
            }
        }
    });

    jQuery(document).on('display_page_timer_warning5', function (event, $page, secondsRemaining, $timer_box) {
        return $page;
    });

    jQuery(document).on('qsm_next_button_click_after qsm_previous_button_click_after', function (event, quizID) {
        advanceAutoPageTimerContinue(quizID);
    });

    jQuery(document).on('qsm_change_timer', function (event, quiz_id, seconds, $page, total_duration = 0) {

        var $quizForm = QSM.getQuizForm(quiz_id);
        $page_timer = $quizForm.find('.qsm-pagetimer');
        $page_timer.hide();
        if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
            $page_timer.show();
        }
        if ($quizForm.find('.linear-custom-timer').length) {
            $custom_timer = $quizForm.find('.linear-custom-timer');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                linearFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.box-timer-top').length) {
            $custom_timer = $quizForm.find('.box-timer-top');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                boxFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.oval-timer-top').length) {
            $custom_timer = $quizForm.find('.oval-timer-top');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                ovalFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.qsm-v-line-timer-top').length) {
            $custom_timer = $quizForm.find('.qsm-v-line-timer-top');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                vLineFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.half-circle-timer').length) {
            $custom_timer = $quizForm.find('.half-circle-timer');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                halfFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.qsm-shade-circle-timer').length) {
            $custom_timer = $quizForm.find('.qsm-shade-circle-timer');
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                shadeFormatTimeLeft(quiz_id, seconds, total_duration);
            }
        } else if ($quizForm.find('.circle-custom-timer').length) {
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                var display = QSM.secondsToTimer(seconds);
                jQuery(".second.circle").parent('.mlw_quiz_form').addClass('qsm_big_timer');
                jQuery(".second.circle").show();
                jQuery(".second.circle strong").html(display);
                var datashow = (total_duration - seconds) / total_duration;
                jQuery(".second.circle").circleProgress({
                    startAngle: 11,
                    value: datashow,
                    animation: false,
                    fill: { gradient: ["#00bb40", "#00511c"] }
                });
            }
        } else if ($quizForm.find('.custom-mlw_qmn_timer').length) {
            if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('show_both_timers') && qmn_quiz_data[quiz_id].advanced_timer.show_both_timers == "yes") {
                $page_timer.show();
            } else {
                $quizForm.find('.mlw_qmn_timer').removeClass('mlw_qmn_timer');
                $quizForm.find('.custom-mlw_qmn_timer').text(QSM.secondsToTimer(seconds));
                $quizForm.find('.custom-mlw_qmn_timer').show();
            }
        }
    });

});

function shadeFormatTimeLeft(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.qsm-shade-circle-timer');
    $custom_timer.show();
    var formatHours = '';
    var formatMinutes = '';
    var formatSeconds = '';

    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes
    var seconds = Math.floor(time % 60); // Calculate seconds

    // Format hours
    formatHours = hours < 10 ? '0' + hours : hours;

    // Format minutes
    formatMinutes = minutes < 10 ? '0' + minutes : minutes;

    // Format seconds
    formatSeconds = seconds < 10 ? '0' + seconds : seconds;

    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.qsm-shade-timer-text-label').html(formatHours);
        $custom_timer.find('.qsm-shade-timer-label').html(qmn_quiz_data[quiz_id].advanced_timer.hrs.toLowerCase());
    } else if (hours <= 0 && minutes > 0) {
        $custom_timer.find('.qsm-shade-timer-text-label').html(formatMinutes);
        $custom_timer.find('.qsm-shade-timer-label').html(qmn_quiz_data[quiz_id].advanced_timer.min.toLowerCase());
    } else {
        $custom_timer.find('.qsm-shade-timer-text-label').html(formatSeconds);
        $custom_timer.find('.qsm-shade-timer-label').html(qmn_quiz_data[quiz_id].advanced_timer.sec.toLowerCase());
    }

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find('.qsm-shade-timer-text-label, .qsm-shade-timer-label').css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }

    // Calculate stroke dash array for the progress circle
    var strokeDashArray = Math.floor(time * 295 / total_duration) + ' 295';
    $custom_timer.find('.base-timer_path-remaining').css('stroke-dasharray', strokeDashArray);

    // Update timer progress color
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
        $custom_timer.find(".base-timer_path-remaining").css('stroke', qmn_quiz_data[quiz_id].advanced_timer.time_progress_color);
    }
}

function halfFormatTimeLeft(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.half-circle-timer');
    $custom_timer.show();
    var formatHours = '';
    var formatMinutes = '';
    var formatSeconds = '';

    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes
    var seconds = Math.floor(time % 60); // Calculate seconds

    // Format hours
    formatHours = hours < 10 ? '0' + hours : hours;

    // Format minutes
    formatMinutes = minutes < 10 ? '0' + minutes : minutes;

    // Format seconds
    formatSeconds = seconds < 10 ? '0' + seconds : seconds;

    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.half-timer_text_label').html(formatHours);
        $custom_timer.find('.half-timer_label').html(qmn_quiz_data[quiz_id].advanced_timer.hrs.toLowerCase());
    } else if (hours <= 0 && minutes > 0) {
        $custom_timer.find('.half-timer_text_label').html(formatMinutes);
        $custom_timer.find('.half-timer_label').html(qmn_quiz_data[quiz_id].advanced_timer.min.toLowerCase());
    } else {
        $custom_timer.find('.half-timer_text_label').html(formatSeconds);
        $custom_timer.find('.half-timer_label').html(qmn_quiz_data[quiz_id].advanced_timer.sec.toLowerCase());
    }

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find('.half-timer_label, .half-timer_text_label').css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }

    // Calculate stroke dash array for the progress circle
    var strokeDashArray = Math.floor(time * 147.5 / total_duration) + ' 147.5';
    $custom_timer.find('.base-timer_path-remaining').css('stroke-dasharray', strokeDashArray);

    // Update timer progress color
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
        $custom_timer.find(".base-timer_path-remaining").css('stroke', qmn_quiz_data[quiz_id].advanced_timer.time_progress_color);
    }
}

function vLineFormatTimeLeft(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.qsm-v-line-timer-top');
    $custom_timer.show();
    var formattedHour = '';
    var formattedMinute = '';
    var formattedSeconds = '';
    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes

    // Format hours
    formattedHour += hours < 10 ? '0' + hours + ':' : hours + ':';

    // Format minutes
    if (minutes < 10) {
        formattedMinute += '0' + minutes;
    } else {
        formattedMinute += minutes;
    }

    // Calculate remaining seconds
    var seconds = Math.floor(time % 60);

    // Format seconds
    if (seconds < 10) {
        formattedSeconds += ':' + '0' + seconds;
    } else {
        formattedSeconds += ':' + seconds;
    }

    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.qsm-v-line-time-text').html(formattedHour + formattedMinute);
        $custom_timer.find('.qsm-v-line-time-status').html(qmn_quiz_data[quiz_id].advanced_timer.hours);
    } else if (hours <= 0 && minutes > 0) {
        $custom_timer.find('.qsm-v-line-time-text').html(formattedMinute + formattedSeconds);
        $custom_timer.find('.qsm-v-line-time-status').html(qmn_quiz_data[quiz_id].advanced_timer.minutes);
    } else {
        $custom_timer.find('.qsm-v-line-time-text').html(formattedMinute + formattedSeconds);
        $custom_timer.find('.qsm-v-line-time-status').html(qmn_quiz_data[quiz_id].advanced_timer.seconds);
    }

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find(".qsm-v-line-time-text").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
        $custom_timer.find(".qsm-v-line-time-status").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }

    var width = Math.floor(time * 100 / total_duration);
    vLineUpdateProgressBar(width); // Update progress bar

    // Update timer color
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
        $custom_timer.find(".qsm-v-line-timer-percentage-line").css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_progress_color);
    }

    // Update timer background color
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_background_color')) {
        $custom_timer.css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_background_color);
    }
}

function vLineUpdateProgressBar(percentage) {
    const progressBar = document.querySelector('.qsm-v-line-timer-percentage-line');
    progressBar.style.width = percentage + '%';
}

function boxFormatTimeLeft(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.box-timer-top');
    $custom_timer.show();
    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes
    var formattedHour = '';
    var formattedMinute = '';
    var formattedSeconds = '';

    // Format hours
    formattedHour += hours < 10 ? '0' + hours + ':' : hours + ':';

    // Format minutes
    if (minutes < 10) {
        formattedMinute += '0' + minutes;
    } else {
        formattedMinute += minutes;
    }

    // Calculate remaining seconds
    var seconds = Math.floor(time % 60);

    // Format seconds
    if (seconds < 10) {
        formattedSeconds += ':' + '0' + seconds;
    } else {
        formattedSeconds += ':' + seconds;
    }

    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.box-timer-text').html(formattedHour + formattedMinute);
        $custom_timer.find('.box-timer-status').html(qmn_quiz_data[quiz_id].advanced_timer.hrs + '&nbsp;&nbsp;&nbsp;' + qmn_quiz_data[quiz_id].advanced_timer.min);
    } else if (hours <= 0 && minutes >= 0) {
        $custom_timer.find('.box-timer-text').html(formattedMinute + formattedSeconds);
        $custom_timer.find('.box-timer-status').html(qmn_quiz_data[quiz_id].advanced_timer.min + '&nbsp;&nbsp;&nbsp;' + qmn_quiz_data[quiz_id].advanced_timer.sec);
    }

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find(".box-timer-text").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
        $custom_timer.find(".box-timer-status").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }

    var width = Math.floor(time * 100 / total_duration);
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
        $custom_timer.find(".box-timer-percentage-line").css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_progress_color);
    }
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_background_color')) {
        $custom_timer.css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_background_color);
    }

    boxUpdateProgressBar(width); // Update progress bar
}

function boxUpdateProgressBar(percentage) {
    const progressBar = document.querySelector('.box-timer-percentage-line');
    progressBar.style.width = percentage + '%';
}

function ovalFormatTimeLeft(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.oval-timer-top');
    $custom_timer.show();
    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes from the remaining time
    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.oval-timer-label-top').html(qmn_quiz_data[quiz_id].advanced_timer.hrs);
        $custom_timer.find('.oval-timer-label-bottom').html(qmn_quiz_data[quiz_id].advanced_timer.min);
        $custom_timer.find('.second').hide();
    } else {
        $custom_timer.find('.oval-timer-label-top').html(qmn_quiz_data[quiz_id].advanced_timer.min);
        $custom_timer.find('.oval-timer-label-bottom').html(qmn_quiz_data[quiz_id].advanced_timer.sec);
        $custom_timer.find('.hour').hide();
        $custom_timer.find('.second').show();
    }
    var formattedTime = '';
    // Format hours
    if (hours < 10) {
        formattedTime += '0' + hours;
    } else {
        formattedTime += hours;
    }
    $custom_timer.find('.hour').html(formattedTime); // Update hour display

    formattedTime = '';
    // Format minutes
    if (minutes < 10) {
        formattedTime += '0' + minutes;
    } else {
        formattedTime += minutes;
    }
    $custom_timer.find('.minute').html(formattedTime); // Update hour display

    var seconds = Math.floor(time % 60); // Calculate remaining seconds
    formattedTime = '';
    // Format seconds
    if (seconds < 10) {
        formattedTime += '0' + seconds;
    } else {
        formattedTime += seconds;
    }
    $custom_timer.find('.second').html(formattedTime); // Update second display

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find("span").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
        $custom_timer.find(".oval-timer-percentage-line").css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_progress_color);
    }
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_background_color')) {
        $custom_timer.css('background-color', qmn_quiz_data[quiz_id].advanced_timer.time_background_color);
    }

    var width = Math.floor(time * 100 / total_duration);
    ovalUpdateProgressBar(width); // Update progress bar
}

function ovalUpdateProgressBar(percentage) {
    const progressBar = document.querySelector('.oval-timer-percentage-line');
    progressBar.style.width = percentage + '%';
}

function linearFormatTimeLeft(quiz_id, time, total_duration = 0) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $custom_timer = $quizForm.find('.linear-custom-timer');
    $custom_timer.show();
    var formattedHour = '';
    var formattedMinute = '';
    var formattedSeconds = '';
    var hours = Math.floor(time / 3600); // Calculate hours
    var minutes = Math.floor((time % 3600) / 60); // Calculate minutes

    // Format hours
    formattedHour += hours < 10 ? '0' + hours + ':' : hours + ':';

    // Format minutes
    if (minutes < 10) {
        formattedMinute += '0' + minutes;
    } else {
        formattedMinute += minutes;
    }

    // Calculate remaining seconds
    var seconds = Math.floor(time % 60);

    // Format seconds
    if (seconds < 10) {
        formattedSeconds += ':' + '0' + seconds;
    } else {
        formattedSeconds += ':' + seconds;
    }

    if (hours > 0 && qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.check_hour === 1) {
        $custom_timer.find('.linear-timer-text').html(formattedHour + formattedMinute);
        $custom_timer.find('.linear-timer-status').html(qmn_quiz_data[quiz_id].advanced_timer.hours.toUpperCase());
    } else if (hours <= 0 && minutes > 0) {
        $custom_timer.find('.linear-timer-text').html(formattedMinute + formattedSeconds);
        $custom_timer.find('.linear-timer-status').html(qmn_quiz_data[quiz_id].advanced_timer.minutes.toUpperCase());
    } else {
        $custom_timer.find('.linear-timer-text').html(formattedMinute + formattedSeconds);
        $custom_timer.find('.linear-timer-status').html(qmn_quiz_data[quiz_id].advanced_timer.seconds.toUpperCase());
    }

    // Update timer styling
    if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_text_color')) {
        $custom_timer.find(".linear-timer-text, .linear-timer-status").css('color', qmn_quiz_data[quiz_id].advanced_timer.time_text_color);
    }

    linearChangeColor(quiz_id, time, total_duration); // Update timer color
}

function linearChangeColor(quiz_id, time, total_duration) {
    var $quizForm = QSM.getQuizForm(quiz_id);
    $linear_timer = $quizForm.find('.linear-custom-timer');

    const percentage = (time / total_duration) * 100;
    const spans = document.querySelectorAll('.linear-timer-span span');

    spans.forEach((span, index) => {
        span.style.border = "1px solid #9C9C9C";
        span.style.backgroundColor = "#ffffff";
        if (index * 10 < percentage) {
            if (percentage <= 100 && percentage >= 50) {
                if (qmn_quiz_data[quiz_id].advanced_timer.hasOwnProperty('time_progress_color')) {
                    span.style.border = "1px solid " + qmn_quiz_data[quiz_id].advanced_timer.time_progress_color;
                    span.style.backgroundColor = qmn_quiz_data[quiz_id].advanced_timer.time_progress_color;
                }
            } else if (percentage <= 50 && percentage >= 20) {
                span.style.border = "1px solid #FFB800";
                span.style.backgroundColor = "#FFB800";
            } else if (percentage <= 20) {
                span.style.border = "1px solid #FF5555";
                span.style.backgroundColor = "#FF5555";
            }
        }
    });
}

function advanceAutoPageTimerContinue(quizID) {
    var $currentpage = jQuery('.qsm-auto-page-row:visible');
    var $apid = jQuery('.qsm-auto-page-row:visible').data('apid');
    var start_timer = parseInt(qmn_quiz_data[quizID].advanced_timer.start_timer_page);
    var $quizForm = QSM.getQuizForm(quizID);
    if (start_timer <= $apid) {
        jQuery('.qsm-auto-page-row').each(function () {
            var dataapid = jQuery(this).data('apid');
            if (typeof dataapid !== 'undefined' && qmn_quiz_data[quizID] && qmn_quiz_data[quizID].qpages && qmn_quiz_data[quizID].qpages[dataapid] && typeof qmn_quiz_data[quizID].qpages[dataapid].timerInterval !== 'undefined') {
                clearInterval(qmn_quiz_data[quizID].qpages[dataapid].timerInterval);
            }

        });

        if (qmn_quiz_data[quizID].advanced_timer.show_stop_timer == 'yes' && $apid != undefined) {
            jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').show();
        } else {
            jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').hide();
        }

        $quizForm.closest('.qmn_quiz_container').find('.qsm_ninety_warning').hide();

        if (qmn_quiz_data[quizID].hasOwnProperty('advance_per_page_timer') && undefined != $apid && 0 < qmn_quiz_data[quizID].advance_per_page_timer && qmn_quiz_data[quizID].hasOwnProperty('pagination') && 0 < qmn_quiz_data[quizID].pagination.amount) {

            var $timer_box = $currentpage.find('.qsm-pagetimer');
            var seconds = 0;
            var timerTaken = localStorage.getItem('time_taken_' + quizID + '_page' + $apid);
            var per_page_timer_second = parseFloat(qmn_quiz_data[quizID].advance_per_page_timer) * 60;
            if (timerTaken >= qmn_quiz_data[quizID].advance_per_page_timer) {
                seconds = per_page_timer_second - parseInt(timerTaken);
            } else if (timerTaken <= qmn_quiz_data[quizID].advance_per_page_timer && null != timerTaken) {
                seconds = per_page_timer_second - parseInt(timerTaken);
            } else {
                seconds = per_page_timer_second;
                if (timerTaken == null) {
                    localStorage.setItem('time_taken_' + quizID + '_page' + $apid, 0);
                }
            }
            if (qmn_quiz_data[quizID].advanced_timer.timer_continues_after_closing == 'yes' && undefined != $apid) {
                localStorage.setItem("qsm_quiz_current_page_" + quizID, $apid);
                let started_time = localStorage.getItem("qsm_quiz_current_page_started_at_" + quizID + "page_" + $apid);

                if (started_time == null && qmn_quiz_data[quizID].qpages[$apid].pagetimer != null && qmn_quiz_data[quizID].advanced_timer.show_stop_timer == 'no') {
                    localStorage.setItem("qsm_quiz_current_page_started_at_" + quizID + "page_" + $apid, new Date().getTime());
                }
                let timeDiff = Math.round((new Date().getTime() - started_time) / 1000);
                let pageTime = qmn_quiz_data[quizID].qpages[$apid].pagetimer * 60;
                let finalRemainingTime = pageTime - timeDiff;
                if (undefined != pageTime && finalRemainingTime > 0) {
                    localStorage.setItem('time_taken_' + quizID + '_page' + $apid, timeDiff);
                } else {
                    if (started_time != null && timerTaken != null) {
                        localStorage.setItem('time_taken_' + quizID + '_page' + $apid, pageTime);
                    }
                }
            }
            /* Sets up timer interval. */
            qmn_quiz_data[quizID].qpages[$apid].timerInterval = setInterval(advanceAutoPageTimer, 1000, quizID, $apid, $timer_box);
        }
    } else if (start_timer > $apid) {
        var $custom_timer = 0;
        if ($quizForm.find('.linear-custom-timer').length) {
            $custom_timer = $quizForm.find('.linear-custom-timer');
        } else if ($quizForm.find('.qsm-v-line-timer-top').length) {
            $custom_timer = $quizForm.find('.qsm-v-line-timer-top');
        } else if ($quizForm.find('.box-timer-top').length) {
            $custom_timer = $quizForm.find('.box-timer-top');
        } else if ($quizForm.find('.oval-timer-top').length) {
            $custom_timer = $quizForm.find('.oval-timer-top');
        } else if ($quizForm.find('.half-circle-timer').length) {
            $custom_timer = $quizForm.find('.half-circle-timer');
        } else if ($quizForm.find('.qsm-shade-circle-timer').length) {
            $custom_timer = $quizForm.find('.qsm-shade-circle-timer');
        } else if ($quizForm.find('.circle-custom-timer').length) {
            $custom_timer = $quizForm.find('.circle-custom-timer');
        } else if ($quizForm.find('.custom-mlw_qmn_timer').length) {
            $custom_timer = $quizForm.find('.custom-mlw_qmn_timer');
        }

        if ($custom_timer != 0) {
            clearInterval(qmn_quiz_data[quizID].qpages[start_timer].timerInterval);
            if (qmn_quiz_data[quizID].timer_limit_val <= 0 || qmn_quiz_data[quizID].advanced_timer.show_both_timers == "no") {
                $custom_timer.hide();
            }
            if (qmn_quiz_data[quizID].advanced_timer.show_stop_timer == 'yes') {
                if (qmn_quiz_data[quizID].timer_limit_val <= 0 || qmn_quiz_data[quizID].advanced_timer.show_both_timers == "no") {
                    jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').hide();
                }
            }
        }
    }
    var pid = jQuery('.qsm-page:visible').data('pid');

    if (undefined != pid) {
        if (start_timer <= pid) {
            if (qmn_quiz_data[quizID].advanced_timer.show_stop_timer == 'yes') {
                jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').show();
            } else {
                jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').hide();
            }
        } else {
            if (qmn_quiz_data[quizID].advanced_timer.show_stop_timer == 'yes') {
                jQuery('.qsm-quiz-container-' + quizID).find('.stoptimer-p').show();
            }
        }
    }
}

function advanceAutoPageTimerDisplay(seconds, current_page, quiz_id) {
    var $apid = jQuery('.qsm-auto-page-row:visible').data('apid');
    var $currentpage = qmn_quiz_data[quiz_id].qpages[$apid];
    var per_page_timer_second = parseFloat(qmn_quiz_data[quiz_id].advance_per_page_timer) * 60;
    var $quizForm = QSM.getQuizForm(quiz_id);
    var ninety_sec = Math.round(per_page_timer_second) - (Math.round(per_page_timer_second) * 90 / 100);
    if (ninety_sec == seconds) {
        $quizForm.closest('.qmn_quiz_container').find('.qsm_ninety_warning').fadeIn();
    }
    if ($currentpage) {
        jQuery(document).trigger('qsm_change_timer', [quiz_id, seconds, $currentpage.pagetimer, Math.round(per_page_timer_second)]);
    }
    var formattedTime = '';
    seconds = parseInt(seconds);
    var hours = Math.floor(seconds / 3600);
    if (0 === hours) {
        formattedTime = '00:';
    } else if (10 > hours) {
        formattedTime = '0' + hours + ':';
    } else {
        formattedTime = hours + ':';
    }
    var minutes = Math.floor((seconds % 3600) / 60);
    if (0 === minutes) {
        formattedTime = formattedTime + '00:';
    } else if (10 > minutes) {
        formattedTime = formattedTime + '0' + minutes + ':';
    } else {
        formattedTime = formattedTime + minutes + ':';
    }
    var remainder = Math.floor((seconds % 60));
    if (0 === remainder) {
        formattedTime = formattedTime + '00';
    } else if (10 > remainder) {
        formattedTime = formattedTime + '0' + remainder;
    } else {
        formattedTime = formattedTime + remainder;
    }
    return formattedTime;
}

function advanceAutoPageTimer(quizID, $apid, $timer_box) {
    $timer_box.show();
    var timerTaken = localStorage.getItem('time_taken_' + quizID + '_page' + $apid);
    var per_page_timer_second = parseFloat(qmn_quiz_data[quizID].advance_per_page_timer) * 60;
    seconds = Math.round(per_page_timer_second) - parseInt(timerTaken);
    if (0 < seconds) {
        timerTaken++;
        seconds--;
        localStorage.setItem('time_taken_' + quizID + '_page' + $apid, timerTaken);
        $timer_box.text(advanceAutoPageTimerDisplay(parseInt(seconds), $apid, quizID));
    } else {
        $timer_box.text(advanceAutoPageTimerDisplay(0, $apid, quizID));
        clearInterval(qmn_quiz_data[quizID].qpages[$apid].timerInterval);
        MicroModal.show('modal-page-1');
    }
}

//Remove the themes timer
jQuery(document).on('qsm_themes_timer_header_after', function (e, quiz_id, qmn_quiz_data, timerObj) {
    if (qmn_quiz_data[quiz_id].advanced_timer.timer_design == "right_bottom_timer"){
        timerObj.timer_template;
    } 
    else if(qmn_quiz_data[quiz_id].hasOwnProperty('advanced_timer') && qmn_quiz_data[quiz_id].advanced_timer.timer_design != "" ) {
        timerObj.timer_template = "";
    }
});
jQuery(document).on('qmn_timer_consumed_seconds', function (e, quiz_id, qmn_quiz_data, qsm_timer_consumed_obj) {
    if(qmn_quiz_data[quiz_id].advanced_timer.qsm_timer_count_upwards != undefined && qmn_quiz_data[quiz_id].advanced_timer.qsm_timer_count_upwards == 1){
        qsm_timer_consumed_obj.qmn_count_upward_status = true; 
    }
});
jQuery(document).on('qsm_timer_ended', function (event, quiz_id, qmn_quiz_data) {
    if ( qmn_quiz_data[quiz_id].advanced_timer.qsm_continue_after_timer_ends != undefined && qmn_quiz_data[quiz_id].advanced_timer.qsm_continue_after_timer_ends == 1 ) {
        jQuery(".mlw_qmn_quiz input:radio").attr('disabled', false);
        jQuery(".mlw_qmn_quiz input:checkbox").attr('disabled', false);
        jQuery(".mlw_qmn_quiz select").attr('disabled', false);
        jQuery(".mlw_qmn_question_comment").attr('disabled', false);
        jQuery(".mlw_answer_open_text").attr('disabled', false);
        jQuery(".mlw_answer_number").attr('readonly', false);
    }
});