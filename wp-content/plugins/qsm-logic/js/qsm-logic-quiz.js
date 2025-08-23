/**
 * QSM - Logic v0.1.0
 */
var QSM_End_Quiz = false;
var QSM_Logic_Quiz;
(function ($) {
	QSM_Logic_Quiz = {
		VERSION: '1.0.1',
		DEFAULTS: {},
		checkRule: function (rule) {
			var conditionsTrue = 0;
			var totalIf = 0;
			var grouped = _.mapObject(_.groupBy(rule.if, 'logic_level'), mylist => mylist.map(param => _.omit(param, 'logic_level')));
			$.each(grouped, function (j, single) {
				conditionsTrue = 0;
				totalIf = 0;
				$.each(single, function (i, val) {
					totalIf++;
					var $question = $("input[name=question" + val.question + "]:checked, input[name='question" + val.question + "[]']:checked, select[name=question" + val.question + "], textarea[name=question" + val.question + "],input[name=question" + val.question + "][type='number'], input[name=question" + val.question + "][type='text']");
					// Get checkbox/select multiple selected/checked values
					var multipleCheckedVals = $question.map(function () {
						return this.value;
					}).get();
					// Check if input is select or checkbox
					var is_checkbox = false;
					if ($question.is(':checkbox')) {
						is_checkbox = true;
					}
					if ($question.is('select')) {
						is_checkbox = true;
					}

					if ("No Answer Provided" != $question.val()) {
						switch ( val.condition ) {
							case 'is equal to':
								if ($question.val() === decodeEntities( val.answer ).toString() || $.inArray(decodeEntities( val.answer ).toString(), multipleCheckedVals) !== -1) {
									conditionsTrue++;
								}
								break;
							case 'is not equal to':
								if ( $question.val() !== decodeEntities( val.answer ).toString() && !is_checkbox ) {
									conditionsTrue++;
								}
								if ( is_checkbox ) {
									if ($.inArray( decodeEntities( val.answer ).toString() , multipleCheckedVals) === -1) {
										conditionsTrue++;
									}
								}
								break;
							case 'is greater than':
								if (parseFloat($question.val()) > parseFloat(decodeEntities( val.answer )) && !is_checkbox) {
									conditionsTrue++;
								}
								if ( is_checkbox ) {
									var check_g = false;
									$.each(multipleCheckedVals, function (k, v) {
										if (parseFloat(v) > parseFloat(decodeEntities( val.answer ))) {
											check_g = true;
										}
									});
									if (check_g) {
										conditionsTrue++;
									}
								}
								break;
							case 'is less than':
								if (parseFloat($question.val()) < parseFloat(decodeEntities( val.answer )) && !is_checkbox) {
									conditionsTrue++;
								}
								if (is_checkbox) {
									var check_g = false;
									$.each(multipleCheckedVals, function (k, v) {
										if (parseFloat(v) < parseFloat(decodeEntities( val.answer ))) {
											check_g = true;
										}
									});
									if (check_g) {
										conditionsTrue++;
									}
								}
								break;
							case 'is empty':
								if ('' === $question.val() || null === $question.val() ) {
									conditionsTrue++;
								}
								if ( !is_checkbox && 0 === multipleCheckedVals.length ) {
									conditionsTrue++;
								}
								break;
							case 'is not empty':
								if ('' !== $question.val() ) {
									conditionsTrue++;
								}
								if ( is_checkbox && 0 > multipleCheckedVals.length ) {
									conditionsTrue++;
								}
								break;
							default:
								// default
						}
					}
				});
				if (conditionsTrue === totalIf) {
					return false;
				}
			});

			$.each(rule.then, function (i, val) {
				console.log({i, val});
				if (jQuery(".data-req-el-" + val.question)) {
					$.each(jQuery(".data-req-el-" + val.question), function() {
						var req_class = jQuery(this).attr("data-req-class");
						jQuery(this).addClass(req_class);
					})
				}
			});

			if (conditionsTrue === totalIf) {
				$.each(rule.then, function (i, val) {
					QSM_End_Quiz = false;
					var thenVal = val.question;
					var sectionClass = '.question-section-id-'+thenVal;
					if (String(thenVal).indexOf('c') > -1) {
						sectionClass = '.category-section-id-'+thenVal;
					}
					if ('Show' === val.condition) {
						$(sectionClass).show().removeClass('qsm-logic-hidden');
						removeFromHiddenField(thenVal);
						QSMLogicRecalucateQuestionNumber(thenVal);
					} else if ('endquiz' == val.condition) {
						QSM_End_Quiz = true;
						if ( rule.if[0].question ) {
							let quizId = jQuery(document).find('.question-section-id-'+rule.if[0].question).parents('.qsm-quiz-container').find('.qmn_quiz_id').val();
							jQuery(document).find('.qsm-quiz-container-'+ quizId +' .qsm-submit-btn').trigger('click');
						}
					} else {
						resetBeforeHide(thenVal);
						$(sectionClass).hide().addClass('qsm-logic-hidden');
						qsmRemoveRequired(sectionClass + ' *', sectionClass, thenVal);
						addToHiddenField(thenVal);
						QSMLogicRecalucateQuestionNumber(thenVal);
						$.each(qmn_quiz_data_new, function (j, valj) {
							var particular_quiz_rule = qmn_quiz_data_new[j];
							$.each(particular_quiz_rule, function (i, object_value) {
								$.each(object_value.if, function (i, ovi_val) {
									if (ovi_val.question == thenVal) {
										$.each(object_value.then, function (i, obt_val) {
											var objectThenVal = obt_val.question;
											var objectSectionClass = '.question-section-id-'+objectThenVal;
											if (String( objectThenVal ).indexOf('c') > -1) {
												objectSectionClass = '.category-section-id-'+objectThenVal;
											}
											resetBeforeHide(objectThenVal);
											$(objectSectionClass).hide().addClass('qsm-logic-hidden');
											qsmRemoveRequired(objectSectionClass + ' *', objectSectionClass, objectThenVal);
											addToHiddenField(objectThenVal);
											QSMLogicRecalucateQuestionNumber(thenVal);
										});
									}
								});

							});
						});
					}
				});
			} else {
				$.each(rule.then, function (i, val) {
					QSM_End_Quiz = false;
					var thenVal = val.question;
					var sectionClass = '.question-section-id-'+thenVal;
					if (String(thenVal).indexOf('c') > -1) {
						sectionClass = '.category-section-id-'+thenVal;
					}
					if ('Show' !== val.condition) {
						$(sectionClass).show().removeClass('qsm-logic-hidden');
						removeFromHiddenField(thenVal);
						QSMLogicRecalucateQuestionNumber(thenVal);
					} else if ('endquiz' == val.condition) {
						QSM_End_Quiz = true;
						if ( rule.if[0].question ) {
							let quizId = jQuery(document).find('.question-section-id-'+rule.if[0].question).parents('.qsm-quiz-container').find('.qmn_quiz_id').val();
							jQuery(document).find('.qsm-quiz-container-'+ quizId +' .qsm-submit-btn').trigger('click');
						}
					} else {
						resetBeforeHide(thenVal);
						$(sectionClass).hide().addClass('qsm-logic-hidden');
						qsmRemoveRequired(sectionClass + ' *', sectionClass, thenVal);
						addToHiddenField(thenVal);
						QSMLogicRecalucateQuestionNumber(thenVal);
						$.each(qmn_quiz_data_new, function (j, valj) {
							var particular_quiz_rule = qmn_quiz_data_new[j];
							$.each(particular_quiz_rule, function (i, object_value) {
								$.each(object_value.if, function (i, ovi_val) {
									if (ovi_val.question == thenVal) {
										$.each(object_value.then, function (i, obt_val) {
											var objectThenVal = obt_val.question;
											var objectSectionClass = '.question-section-id-'+objectThenVal;
											if (String( objectThenVal ).indexOf('c') > -1) {
												objectSectionClass = '.category-section-id-'+objectThenVal;
											}
											resetBeforeHide(objectThenVal);
											$(objectSectionClass).hide().addClass('qsm-logic-hidden');
											qsmRemoveRequired(objectSectionClass + ' *', objectSectionClass, objectThenVal);
											addToHiddenField(objectThenVal);
											QSMLogicRecalucateQuestionNumber(thenVal);
										});
									}
								});
							});
						});
					}
				});
			}
		}
	};

	function implement_logic() {
		var mr_field = ' ';
		var quiz_id = qsm_logic_quiz_id.quiz_id;
		$.each(qmn_quiz_data_new, function (j, valj) {
			var pagination = qmn_quiz_data[j].hasOwnProperty('pagination') ? qmn_quiz_data[j].pagination.amount : 0;
			if (pagination > 0) {
				return false;
			}
			var particular_quiz_rule = qmn_quiz_data_new[j];
			var execute_last = {};
			$.each(particular_quiz_rule, function (i, val) {
				QSM_Logic_Quiz.checkRule(particular_quiz_rule[i]);
				$.each(val.if, function (j, vals) {
					$('.question-section-id-' + vals.question).find('input[type=checkbox]').each(function () {
						mr_field += ', #' + $(this).attr('id');
					});
					$(document).on( "change keyup", "input[name=question" + vals.question + "], textarea[name=question" + vals.question + "], select[name=question" + vals.question + "] " + mr_field, function () {
						var current_val = $(this).val();
						if ( particular_quiz_rule[i] !== undefined || particular_quiz_rule[i].if !== undefined ) {
							$.each(particular_quiz_rule[i].if, function (qr, qr_val) {
								if ( decodeEntities( qr_val.answer ) == current_val) {
									execute_last = particular_quiz_rule[i];
								} else {
									QSM_Logic_Quiz.checkRule(particular_quiz_rule[i]);
								}
							});
						}
						QSM_Logic_Quiz.checkRule(execute_last);
					});
				});
			});
		});
	}

	jQuery(document).on('qsm_next_button_click_after', function(event, quiz_id) {
		if (typeof qmn_quiz_data_new === 'undefined' || !quiz_id) return;
		
		const $quizContainer = $(`.qsm-quiz-container-${quiz_id}`);
		const currentPage = $quizContainer.find('.qsm-question-page:visible');
		const currentPid = parseInt(currentPage.attr('data-pid'));

		if ($('.qsm-page-1:visible').length > 0 || !currentPage.length) return;
		
		qsm_logic_process_quiz_rules($quizContainer, currentPid);
	});
	
	function qsm_logic_process_quiz_rules($container, currentPid) {
		let ruleProcessed = false;
		
		$.each(qmn_quiz_data_new, function(quizIndex, rules) {

			if (qmn_quiz_data[quizIndex]?.pagination?.amount > 0) return;
			
			$.each(rules, function(ruleIndex, rule) {
				if (ruleProcessed) return;
				
				if (!qsm_logic_rule_conditions_met(rule, $container)) return;
				
				qsm_logic_process_then_actions(rule, $container, currentPid, () => {
					ruleProcessed = true;
				});
			});
		});
	}
	
	function qsm_logic_rule_conditions_met(rule, $container) {
		let conditionsMet = false;
		const grouped = _.mapObject(_.groupBy(rule.if, 'logic_level'), 
			group => group.map(param => _.omit(param, 'logic_level')));
		
		$.each(grouped, function(j, conditions) {
			let conditionsTrue = 0;
			let totalConditions = conditions.length;
			
			$.each(conditions, function(i, condition) {
				const $question = $container.find(
					`input[name=question${condition.question}]:checked, ` +
					`input[name='question${condition.question}[]']:checked, ` +
					`select[name=question${condition.question}], ` +
					`textarea[name=question${condition.question}], ` +
					`input[name=question${condition.question}][type='number'], ` +
					`input[name=question${condition.question}][type='text']`
				);
				
				if (qsm_logic_check_Condition($question, condition)) {
					conditionsTrue++;
				}
			});
			
			if (conditionsTrue === totalConditions) {
				conditionsMet = true;
				return false; 
			}
		});
		
		return conditionsMet;
	}
	
	function qsm_logic_check_Condition($question, condition) {
		const multipleCheckedVals = $question.map(function() { 
			return this.value; 
		}).get();
		
		const isCheckboxOrSelect = $question.is(':checkbox') || $question.is('select');
		const questionValue = $question.val();
		
		if (questionValue === "No Answer Provided") return false;
		
		const decodedAnswer = decodeEntities(condition.answer).toString();
		
		switch (condition.condition) {
			case 'is equal to':
				return questionValue === decodedAnswer || 
					   multipleCheckedVals.includes(decodedAnswer);
			case 'is not equal to':
				return (!isCheckboxOrSelect && questionValue !== decodedAnswer) ||
					   (isCheckboxOrSelect && !multipleCheckedVals.includes(decodedAnswer));
			case 'is greater than':
				return (!isCheckboxOrSelect && parseFloat(questionValue) > parseFloat(decodedAnswer)) ||
					   (isCheckboxOrSelect && multipleCheckedVals.some(val => 
						   parseFloat(val) > parseFloat(decodedAnswer)));
			case 'is less than':
				return (!isCheckboxOrSelect && parseFloat(questionValue) < parseFloat(decodedAnswer)) ||
					   (isCheckboxOrSelect && multipleCheckedVals.some(val => 
						   parseFloat(val) < parseFloat(decodedAnswer)));
			case 'is empty':
				return questionValue === '' || questionValue === null || 
					   (!isCheckboxOrSelect && multipleCheckedVals.length === 0);
			case 'is not empty':
				return questionValue !== '' || 
					   (isCheckboxOrSelect && multipleCheckedVals.length > 0);
			default:
				return false;
		}
	}
	
	function qsm_logic_process_then_actions(rule, $container, currentPid, onProcessed) {
		$.each(rule.then, function(k, action) {
			if (action.condition !== 'goto') return;
			
			const targetPid = parseInt(action.question);
			if (currentPid === targetPid) return;
			
			const pages = $container.find('.qsm-question-page');
			let currentIndex = -1;
			let targetIndex = -1;
			
			pages.each(function(index) {
				const pid = parseInt($(this).attr('data-pid'));
				if (pid === currentPid) currentIndex = index;
				if (pid === targetPid) targetIndex = index;
			});
			
			if (currentIndex === -1 || targetIndex === -1) return;
			
			if (targetIndex > currentIndex) {
				onProcessed();
				QSM_End_Quiz = false;
				$container.find('.mlw_next').first().trigger('click');
			}
		});
	}

	if (typeof qmn_quiz_data != 'undefined' && qmn_quiz_data) {
		implement_logic();
	}
	// implementing logic on Quiz Retake
	$(document).on('qsm_retake_quiz', function (e, quizID) {
		implement_logic();
	});
}(jQuery));



function qsmRemoveRequired(element, q_section, question_id) {
	jQuery(element).each(function () {
		if (jQuery(this).attr('class')) {
			if (jQuery(this).attr('class').indexOf('mlwEmail') !== -1) {
				jQuery(this).removeClass("mlwEmail");
				jQuery(this).attr("data-req-class", "mlwEmail");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredNumber') !== -1) {
				jQuery(this).removeClass("mlwRequiredNumber");
				jQuery(this).attr("data-req-class", "mlwRequiredNumber");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredText') !== -1) {
				jQuery(this).removeClass("mlwRequiredText");
				jQuery(this).attr("data-req-class", "mlwRequiredText");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredCaptcha') !== -1) {
				jQuery(this).removeClass("mlwRequiredCaptcha");
				jQuery(this).attr("data-req-class", "mlwRequiredCaptcha");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredAccept') !== -1) {
				jQuery(this).removeClass("mlwRequiredAccept");
				jQuery(this).attr("data-req-class", "mlwRequiredAccept");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredRadio') !== -1) {
				jQuery(this).removeClass("mlwRequiredRadio");
				jQuery(this).attr("data-req-class", "mlwRequiredRadio");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredFileUpload') !== -1) {
				jQuery(this).removeClass("mlwRequiredFileUpload");
				jQuery(this).attr("data-req-class", "mlwRequiredFileUpload");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('qsmRequiredSelect') !== -1) {
				jQuery(this).removeClass("qsmRequiredSelect");
				jQuery(this).attr("data-req-class", "qsmRequiredSelect");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('mlwRequiredCheck') !== -1) {
				jQuery(this).removeClass("mlwRequiredCheck");
				jQuery(this).attr("data-req-class", "mlwRequiredCheck");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
			if (jQuery(this).attr('class').indexOf('g-recaptcha-response') !== -1) {
				jQuery(this).removeClass("g-recaptcha-response");
				jQuery(this).attr("data-req-class", "g-recaptcha-response");
				jQuery(this).addClass("data-req-el-" + question_id);
			}
		}
	});
}


function addToHiddenField(question_id) {
	var question_hidden = jQuery('#qsm_hidden_questions').val();
	if (question_hidden != "") {
		question_hidden = JSON.parse(question_hidden);
	} else {
		question_hidden = [];
	}

	// Put question id into hidden field
	if (jQuery.inArray(question_id, question_hidden) === -1) {
		question_hidden.push(question_id);
		jQuery("#qsm_hidden_questions").val(JSON.stringify(question_hidden));
	}
}

function removeFromHiddenField(question_id) {
	var question_hidden = jQuery('#qsm_hidden_questions').val();
	if (question_hidden != undefined && question_hidden != "") {
		question_hidden = JSON.parse(question_hidden);
		question_hidden = jQuery.grep(question_hidden, function (value) {
			return value != question_id;
		});
		jQuery("#qsm_hidden_questions").val(JSON.stringify(question_hidden));
	}
}

function QSMLogicRecalucateQuestionNumber(question_id) {
	var $questionnumber = 1;
	jQuery('.quiz_section').each(function (e) {
		if (jQuery(this).hasClass('quiz_begin') || jQuery(this).hasClass('quiz_end')) {
			//Do nothing.
		} else {
			if (jQuery(this).css('display') !== 'none' && jQuery(this).find('.mlw_qmn_question_number').length > 0) {
				jQuery(this).find('.mlw_qmn_question_number').text('').text($questionnumber + '. ');
				$questionnumber++;
			}
		}
	});
}
// Resets the options of question
function resetBeforeHide(question_id) {
	input = jQuery('.question-section-id-' + question_id).find('input')
	select = jQuery('.question-section-id-' + question_id).find('select');
	if (input.length > 0) {
		input.each(function () {
			switch (jQuery(this).attr('type')) {
				case 'radio':
				case 'checkbox':
					if (jQuery(this).prop('checked')) {
						jQuery(this).prop('checked', false);
						jQuery(document).trigger('qsm_reset_before_hide', jQuery(this));
					}

					break;
				case 'text':
				case 'number':
					jQuery(this).val('');
				default:
					break;
			}
		});
	}

	if (select.length > 0) {
		select.each(function () {
			jQuery(this).val('');
		})
	}

}

function decodeEntities (str ) {
	if(str && typeof str === 'string') {
		str = str.replace("\\'", "'");
		str = str.replace('\\"', '"');
	}
	return str;
};

//hook after click next and previous button
jQuery(document).on('qsm_next_button_click_after qsm_previous_button_click_after', function (event, quiz_id) {
	if (jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-page:visible').find('.qsm-question-wrapper').length && !jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-page:visible').find('.qsm-question-wrapper:visible').length) {
		if ('qsm_next_button_click_after' === event.type && !jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-submit-btn:visible').length ) {
			jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-next:visible').click();
		} else if( 'qsm_previous_button_click_after' === event.type ) {
			jQuery('.qsm-quiz-container-' + quiz_id + ' .qsm-previous').click();
		}
	}
});

jQuery(document).on('qsm_after_validation', function (event, element, quiz_form_id) {
	if ( QSM_End_Quiz ) {
		show_result_validation = true;
	}
});