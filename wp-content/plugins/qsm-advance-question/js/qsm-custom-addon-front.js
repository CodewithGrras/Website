(function ($) {
    jQuery(document).on('click', '.qsm-deselect-answer', function (e) {
		e.preventDefault();
		jQuery(this).parents('.quiz_section').find('input[type="radio"]:hidden').prop('checked', false);
	});
    $( ".qsm-match-sortable" ).sortable({
        cursor:"grabbing",
        opacity:"0.8",
        update: function( event, ui ) {
            qsm_matching_pairs_inline_results_check(this);
            var parent = $(this).parents('.qsm-matching-pairs');
            qsm_change_matching_pair_order(parent);
        }
    });
    $( ".qsm-match-sortable" ).disableSelection();

    jQuery(document).on('qsm_next_button_click_after qsm_previous_button_click_after', function (e, quiz_id) {
        let $container = jQuery('.qsm-quiz-container-' + quiz_id);
        qsm_change_matching_pair_order($container.find('.qsm-matching-pairs'));
    });

    jQuery(document).on('qsm_after_validation', function (e, element, quiz_form_id) {
        if (!show_result_validation) {
            return show_result_validation;
        }
        var quiz_id = +jQuery('#' + quiz_form_id).find('.qmn_quiz_id').val();
        var error_messages = qmn_quiz_data[quiz_id].error_messages;
        jQuery(element).each(function () {
            if ( jQuery(this).attr('class') && jQuery(this).is(':visible') ) {
                if (jQuery(this).attr('class').indexOf('mlwRequiredRadioAllRows') > -1 ) {
                    jQuery( ".qmn-grid-require-all-rows:visible" ).each(function() {
                        check_val = jQuery(this).find('input:checked').val();                        
                        if (check_val == "No Answer Provided" || check_val == '' || check_val == undefined) {
                            qmnDisplayError(error_messages.empty_grid_radio_checkbox_text, jQuery(this), quiz_form_id);
                            show_result_validation = false;
                        }
                    });
                }
            }
        });
	});
    
    $(document).on('qsm_question_quick_result_js_after', function( event, returnObject, correct_answer, answer, answer_array, answer_type, settings, decrypt, question_id ) {
        qsm_advance_question_real_time_check( returnObject, correct_answer, answer, answer_array, answer_type, settings, decrypt, question_id )
    });

    jQuery(document).on('change', '.qsm_radio_grid' , function (e) {
		let $i_this = jQuery(this);
		var quizID = jQuery(this).parents('.qsm-quiz-container').find('.qmn_quiz_id').val();
		var $quizForm = QSM.getQuizForm(quizID);
		let value = jQuery(this).val();
		let $this = jQuery(this).parents('.quiz_section');
		let question_id = $i_this.data('qid');
        let row = $i_this.attr('id').split('_');
        value = `${row[1]}_${value}`;
		jQuery(document).trigger('qsm_after_select_answer', [quizID, question_id, value, $i_this, 'radio']);
		if (qmn_quiz_data[quizID].enable_quick_result_mc == 1) {
			qsm_show_inline_result(quizID, question_id, value, $this, 'radio', $i_this)
		}
	});

    jQuery(document).on('change', '.qsm_checkbox_grid' , function (e) {
		let $i_this = jQuery(this);
		var quizID = jQuery(this).parents('.qsm-quiz-container').find('.qmn_quiz_id').val();
		let parent = jQuery(this).closest('.qmn_check_answers');
        let value = [];
		parent.find('input[type="checkbox"]').map(function() {
            let row = jQuery(this).attr('id').split('_')[1];
            let col = jQuery(this).attr('id').split('_')[2];
            if ( value[row] === undefined ) {
                value[row] = [];
            }
			value[row][col] = jQuery(this).is(':checked') ? 1 : 0;
		}).get();
		let $this = jQuery(this).parents('.quiz_section');
		let question_id = $i_this.data('qid');
		jQuery(document).trigger('qsm_after_select_answer', [quizID, question_id, value, $i_this, 'checkbox']);
		if (qmn_quiz_data[quizID].enable_quick_result_mc == 1) {
			qsm_show_inline_result(quizID, question_id, value, $this, 'radio', $i_this)
		}
	});

    $('.qsm-matching-pairs').each(function(){
        var parent = $(this);
        setTimeout(qsm_change_matching_pair_order(parent), 2000);
    });

    jQuery(document).on('qsm_polar_slider_change_after', function (e, ui,questionID, answer1, answer2, value , isReverse) {
		jQuery('.question-section-id-'+questionID+'  .question-type-polar-s').find( '.polar-title' ).css('font-weight', 'initial');
        jQuery('.question-section-id-' + questionID + ' .question-type-polar-s').find('.polar-title').removeClass('transparent-before');
        jQuery('.question-section-id-'+questionID+'  .question-type-polar-s').find( '.polar-title img' ).css('opacity', "0.4");
		jQuery('.question-section-id-'+questionID+'  .question-type-polar-s').find( '#polar-' + ui.value ).css('font-weight', '900');
        jQuery('.question-section-id-'+questionID+'  .question-type-polar-s').find( '#polar-' + ui.value + ' img').css('opacity', " 1 ");
		jQuery('.question-section-id-'+questionID+'  .question-type-polar-s').find( '#polar-' + ui.value + '::before' ).css('color', 'transparent');
        jQuery('.question-section-id-' + questionID + ' .question-type-polar-s').find('#polar-' + ui.value).addClass('transparent-before');
	});
}(jQuery));

function convertArray(inputArray, rows, cols) {
    const result = [];

    for (let i = 0; i < rows; i++) {
        const row = [];
        for (let j = 0; j < cols; j++) {
          const index = i + j * cols;
          if (index < inputArray.length) {
            row.push(inputArray[index]);
          } else {
            row.push(0);
          }
        }
        result.push(row);
      }
  
    return result;
}
function qsm_advance_answer_correct(input, correct) {
    for (let i = 0; i < input.length; i++) {
      for (let j = 0; j < input[i].length; j++) {
        if (input[i][j] === 1 && correct[i][j] === 0) {
          return false;
        }
  
        if (input[i][j] === 1 && correct[i][j] === 1) {
          // Do nothing, it's a correct match
        }
      }
    }
  
    return true;
}

function qsm_change_matching_pair_order( $parent ){
    var $loop = $parent;
    $loop.find('.qsm_mc_answer_wrap').css('height','');
    let i = 1;
    $loop.find('.qsm-right-option .qsm_mc_answer_wrap').each(function ( index ) {
        let left_element = $loop.find('.qsm-left-option .qsm_mc_answer_wrap').eq(index);
        let dragheight = jQuery(this).outerHeight();
        let height = left_element.outerHeight();
        if (dragheight > height) {
            left_element.css('height', dragheight)
            jQuery(this).css('height', dragheight);
        } else if (dragheight < height) {
            jQuery(this).css('height', height);
        }
        i++;
    });
}

function qsm_matching_pairs_inline_results_check(element) {
    let $i_this = jQuery(element).parents('.qsm-matching-pairs');
    var quizID = jQuery(element).parents('.qsm-quiz-container').find('.qmn_quiz_id').val();
    let $this = jQuery(element).parents('.quiz_section');
    let question_id = jQuery(element).data('qid');
    var sortedValues = jQuery(element).find('input[name="question'+ question_id +'[]"]').map(function() {
        return jQuery(this).val();
    }).get();
    jQuery(document).trigger('qsm_after_select_answer', [quizID, question_id, sortedValues, $i_this, 'matchingPairs']);
    if (qmn_quiz_data[quizID].enable_quick_result_mc == 1) {
        qsm_show_inline_result(quizID, question_id, sortedValues, $this, 'matchingPairs', $i_this)
    }
}

function qsm_advance_question_real_time_check( returnObject, correct_answer, answer, answer_array, answer_type, settings, decrypt, question_id ) {
    if ( answer_array && 2 === parseInt(decrypt[question_id].question_type_new) && 'multiple' === settings['drop-down-type'] && 0 == settings['inline-drop-down'] ) {
        let values = [];
        $(document).find('select[name="question'+ question_id +'[]"]').map(function() {                
            values.push(jQuery(this).val());
        }).get();
        answer_array = answer_array.map(subarr => subarr[0]);
        if ( 1 === parseInt(decrypt.correct_answer_logic) ) {
            correct_answer = JSON.stringify(answer_array) === JSON.stringify(values) ? true : false;
        } else {
            const areEqual = values.every((value, index) => {
                if (value === '') { 
                    return true; // Skip empty values
                }
                return value.trim() === answer_array[index].trim();
            });
            correct_answer = areEqual ? true : false;
        }
        if ( correct_answer ) {
            returnObject.success = 'correct';
        } else {
            returnObject.success = 'incorrect';
        }
    }
    if ( 15 === parseInt(decrypt[question_id].question_type_new) ) {
        let decryptMatchPairs = '';
        if (typeof transientData[question_id] !== 'undefined') {
            let decryptedBytesMatchPairs = CryptoJS.AES.decrypt(transientData[question_id], transientKey[question_id]);
            let decryptedDataMatchPairs = decryptedBytesMatchPairs.toString(CryptoJS.enc.Utf8);
            decryptMatchPairs = JSON.parse(decryptedDataMatchPairs);
        }
        if ( answer ) {
            const areEqual = Array.isArray(answer) && answer.every((value, index) => parseInt(value) === parseInt(decryptMatchPairs[index]));
            correct_answer = areEqual ? true : false;
            if ( correct_answer ) {
                returnObject.success = 'correct';
            } else {
                returnObject.success = 'incorrect';
            }
        }           
    }
    if ( 16 === parseInt(decrypt[question_id].question_type_new) ) {
        let corrects = [];
        if ( answer_array.corrects ) {
            corrects = convertArray( answer_array.corrects, answer_array.rows.length, answer_array.columns.length );
        }
        answer = answer.split('_');
        let ans_row = answer[0];
        let ans_col = answer[1];

        if ( corrects.length > 0 ) {
            if ( corrects[ans_row][ans_col] === 1 ) {
                correct_answer = true;
            }
            if ( correct_answer ) {
                returnObject.success = 'correct';
            } else {
                returnObject.success = 'incorrect';
            }
        } else {
            returnObject.success = 'correct';
        }       
    }
    if ( 17 === parseInt(decrypt[question_id].question_type_new) ) {
        let corrects = [];
        if ( answer_array.corrects ) {
            corrects = convertArray( answer_array.corrects, answer_array.rows.length, answer_array.columns.length );
        }
        if ( corrects.length > 0 ) {
            if ( 1 === parseInt(decrypt.correct_answer_logic) ) {
                correct_answer = JSON.stringify(corrects) === JSON.stringify(answer) ? true : false;
            } else {
                correct_answer = qsm_advance_answer_correct(answer, corrects) ? true : false;
            }
            if ( correct_answer ) {
                returnObject.success = 'correct';
            } else {
                returnObject.success = 'incorrect';
            }
        } else {
            returnObject.success = 'correct';
        }       
    }
    return returnObject;
}