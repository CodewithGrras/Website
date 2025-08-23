/**
 * QSM Question Tab
 */
 var QSM_advance_question;
 (function ($) {
	if (jQuery('body').hasClass('admin_page_mlw_quiz_options') && window.location.href.indexOf('tab') == -1 ||window.location.href.indexOf('tab=questions')> 0 ){
	$(function () {
		// opens media library o set featured image for quiz
		$(document).on('click', '#set_featured_image_lhs, #set_featured_image_rhs', function (e) {
			var button = $(this);
			e.preventDefault();
			custom_uploader = wp.media({
				title: 'Set Featured Image',
				library: {
					type: 'image'
				},
				button: {
					text: 'Use this image' // button label text
				},
				multiple: false
			}).on('select', function () { // it also has "open" and "close" events
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				button.prev().val(attachment.url);
				button.nextAll('.qsm_featured_image_preview').attr('src', attachment.url);
			}).open();
		});

		$(document).on('click', '#inline-drop-down', function(){
			let cls = $(this).parents('div').prop('class');
			let q_type = cls.match(/\d+/)[0];
			if( $(this).prop('checked') ) {
				$('#drop-down-type_area').show();
				$('#question_type_' + q_type + '_description').show();
			} else {
				$('#drop-down-type_area').hide();
				$('#question_type_' + q_type + '_description').hide();
			}
		});

		$(document).on('change', '#drop-down-type', function(){
			if( 'multiple' == $(this).val() ) {
				$('.answer-correct-div').hide();
			} else {
				$('.answer-correct-div').show();
			}
		});

		$(document).on('qsm_open_edit_popup', function(event, questionID, CurrentElement){
			let questionData = QSMQuestion.questions.get(questionID);
			let allSetting = questionData.get('settings');
			let answerEditor = $('#change-answer-editor').val();
			if (allSetting && allSetting['advance-polar'] !== undefined && allSetting['advance-polar'] !== '') {
				$('#answers').empty();
                let answers = questionData.get('answers');
				let al = 0;
				_.each(answers, function (answer) {
					answer['index'] = al;
					answer['question_id'] = questionID;
					answer['answerType'] = answerEditor;
					QSMQuestion.addNewAnswer(answer, questionData.get('type'));
					al++;
				});
				$('.questionElements').find('.new-answer-button').show();
			}
			let q_type = CurrentElement.parents('.question.opened').data('question-type');
			if( $('#inline-drop-down').prop('checked') ) {
				$('#drop-down-type_area').show();
				$('#question_type_' + q_type + '_description').show();
			} else {
				$('#drop-down-type_area').hide();
				$('#question_type_' + q_type + '_description').hide();
			}
			if( 'multiple' == $('#drop-down-type').val() ) {
				$('.answer-correct-div').hide();
			} else {
				$('.answer-correct-div').show();
			}
		});

		$(document).on('qsm_new_answer_template', function(event, ansTemp, answer, questionType){
			let ddl_type = $('.questionElements:visible').find('#drop-down-type').val();
			if ( ansTemp.answer === undefined && 2 == questionType ) {
				setTimeout(() => {
					if( 'multiple' == ddl_type && 2 == questionType ) {
						$('.answer-correct-div').hide();
					} else if ( 'multiple' != ddl_type && 2 == questionType ) {
						$('.answer-correct-div').show();
					}
				}, 2);
			}
		});

		$(document).on('qsm_question_type_change_after', function(event, question_val) {
			if ( 2 == question_val && $('#inline-drop-down').prop('checked') ) {
				$('#drop-down-type_area').show();
			} else {
				$('#drop-down-type_area').hide();
			}
			if ( 2 == question_val && $('#question_type_' + question_val + '_description').length > 0 && $('#inline-drop-down').prop('checked')) {
				$('#question_type_' + question_val + '_description').show();
			} else if ( 2 == question_val && $('#question_type_' + question_val + '_description').length > 0 && $('#inline-drop-down').prop('checked') == false){
				$('#question_type_' + question_val + '_description').hide();
			}
		});

		$(document).on('qsm_save_popup_button_after', function(event, questionElements) {
			if (2 == questionElements.find('#question_type').val()) {
				question_description = wp.editor.getContent('question-text').trim();
				blanks = question_description.match(/%DROPDOWN%/g);
				options_length = $('.answer-text-div').length
				if ($('#drop-down-type:visible').val() == 'single') {
					if (blanks == null || blanks.length != 1) {
						$('.modal-8-table').html(qsm_admin_messages.drop_down_single_validation);
						MicroModal.show('modal-8');
						return false;
					}
				} else if ($('#drop-down-type:visible').val() == 'multiple' && (blanks == null || options_length != blanks.length)) {
					$('.modal-8-table').html(qsm_admin_messages.drop_down_multiple_validation);
					MicroModal.show('modal-8');
					return false;
				}
			}
			if (13 == questionElements.find('#question_type').val()) {
				let advance_polar = $('.questionElements #advance-polar').val();
				if( advance_polar != '' && $('#answers').find('.answers-single').length < 3 ){
					$('.modal-8-table').html(qsm_admin_messages.advance_polar_validation);
					MicroModal.show('modal-8');
					return false;
				}
			}
		});

		$(document).on('qsm_save_question_before', function(event, questionID, CurrentElement, model, advanced_option) {
			let inline_drop_down = $(".questionElements input[name='inline-drop-down']").is(":checked") ? 0 : 1;
			let drop_down_type = $(".questionElements select[name='drop-down-type']").val();
			let advance_polar = $(".questionElements #advance-polar").val();

			advanced_option['inline-drop-down'] = inline_drop_down;
			advanced_option['drop-down-type'] = drop_down_type;
			advanced_option['advance-polar'] = advance_polar;

			let answer = model.get('answers');
			if ( 'multiple' == drop_down_type ) {
				$.each(answer, function (index, subarray) {
					subarray[subarray.length - 1] = 1;
				});
			}

			model.set('answers', answer);
			model.set('inline-drop-down', inline_drop_down);
			model.set('drop-down-type', drop_down_type);
			model.set('advance-polar', advance_polar);
		});

		$(document).on('qsm_new_answer_button_before', function(event, isMultiPolar, question_id) {
			let advance_polar = $(".questionElements #advance-polar").val();
			isMultiPolar.isActive = advance_polar != '' ? true : false;
		});

		$(document).on('qsm_all_question_setting_after', function(event, all_setting) {
			$.each(all_setting, function (index, value) {
				if (index == 'drop-down-type') {
					$('#drop-down-type').val(value);
				}
				if (index == 'advance-polar') {
					$('#advance-polar').val(value);
				}
			});
		});

		$(document).on('click', '.delete-question-option', function(){
			let index = parseInt($(this).attr('index'));
			let columns = $(this).parents('.qsm-advance-question-multiple-grid').find('.qsm-advance-question-column-list');
			_.each(columns, function (column, key) {
				let sections = jQuery(column).find('.qsm-grid-points-section');
				_.each(sections, function (section, skey) {
					if( jQuery(section).attr('index') == index ) {
						jQuery(section).remove();
					}
				});
			});
			$(this).parent().remove();
		});
		$(document).on('click', '.new-question-row', function(){
			let index = parseInt($(this).attr('index'));
			let columns = $(this).parents('.qsm-advance-question-multiple-grid').find('.qsm-advance-question-column-list');
			let point_type = $(this).parents('.qsm-advance-question-multiple-grid').find('.new-question-column').attr('point_type');
			let html = '';
			let qsm_template_class = 1;
			let qsm_answer_label_tamplate_html = qsm_template_html = '';
			if ( document.getElementById('tmpl-advance-assessment-add-answer-label-template') ) {
				qsm_answer_label_tamplate_html = wp.template('advance-assessment-add-answer-label-template');
				qsm_template_html = qsm_answer_label_tamplate_html({});
			}
			_.each(columns, function (column, key) {
				html = '';
				if( 'both' === point_type ){
					html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-points-both-section' : '') + '" index="' + index + '">';
					html += '<input type="checkbox" class="answer-correct" value="1">';
					html += '<input type="text" class="answer-points weight-points" placeholder="Points"/>';
					html += qsm_template_html;
					html += '</div>';
				}
				if( 'point' === point_type ){
					html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-points-point-section' : '') + '" index="' + index + '">';
					html += '<input type="text" class="answer-points" placeholder="Points"/>';
					html += qsm_template_html;
					html += '</div>';
				}
				if( 'correct' === point_type ){
					html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-correct-incorrect-section' : '') + '" index="' + index + '">';
					html += '<input type="checkbox" class="answer-correct" value="1">';
					html += qsm_template_html;
					html += '</div>';
				}
				if( 'other' === point_type ){
					html += '<div class="qsm-grid-points-section" index=' + index + '>';
					html += '<input type="checkbox" checked disabled>';
					html += '</div>';
				}
				jQuery(column).append( html );
			});
			html = '<div class="qsm-advance-question-rows-list">';
			html +=	'<a href="javascript:void(0)" class="delete-question-option" index=' + index + '><span class="dashicons dashicons-remove"></span></a>';
			html +=	'<input type="text" class="answer-text answer-text-row" placeholder="Row value"/>';
			html +=	'</div>';
			$( html ).insertBefore( $(this).parent('.new-answer-button') );
			index += 1;
			$(this).attr('index', index);
		});
		$(document).on('click', '.new-question-column', function(){
			let qsm_template_class = 1;
			let qsm_answer_label_tamplate_html = qsm_template_html = '';
			if (document.getElementById('tmpl-advance-assessment-add-answer-label-template')) {
				qsm_answer_label_tamplate_html = wp.template('advance-assessment-add-answer-label-template');
				qsm_template_html = qsm_answer_label_tamplate_html({});
			}
			let rowCount = $(this).parents('.qsm-advance-question-multiple-grid').find('.qsm-advance-question-rows-list').length;
			var html = '<div class="qsm-advance-question-column-list">';
				html +=	'<a href="javascript:void(0)" class="delete-question-option"><span class="dashicons dashicons-remove"></span></a>';
				html +=	'<input type="text" class="answer-text answer-text-column" value="" placeholder="Column value"/>';
				for (let index = 0; index < rowCount; index++) {
					if( 'both' === $(this).attr('point_type') ){
						html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-points-both-section' : '') + '" index="' + index + '">';
						html += '<input type="checkbox" class="answer-correct" value="1">';
						html += '<input type="text" class="answer-points weight-points" placeholder="Points"/>';
						html += qsm_template_html;
						html += '</div>';
					}
					if( 'point' === $(this).attr('point_type') ){
						html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-points-point-section' : '') + '" index="' + index + '">';
						html += '<input type="text" class="answer-points" placeholder="Points"/>';
						html += qsm_template_html;
						html += '</div>';
					}
					if( 'correct' === $(this).attr('point_type') ){
						html += '<div class="qsm-grid-points-section ' + (qsm_template_class == 1 ? 'qsm-grid-correct-incorrect-section' : '') + '" index="' + index + '">';
						html += '<input type="checkbox" class="answer-correct" value="1">';
						html += qsm_template_html;
						html += '</div>';
					}
					if( 'other' === $(this).attr('point_type') ){
						html += '<div class="qsm-grid-points-section" index=' + index + '>';
						html += '<input type="checkbox" checked disabled>';
						html += qsm_template_html;
						html += '</div>';
					}
				}
				html +=	'</div>';
			$( html ).insertBefore( $(this).parent('.new-answer-button') );
		});
		$(document).on('click', '.questionElements #required', function () {
			let questionID = $('.questionElements #question_type').val();
			if( 16 == questionID || 17 == questionID ){
				if( $(".questionElements input[name='required']").prop("checked") == true ){
					$(".questionElements #require-all-rows_area").show();
				} else {
					$(".questionElements #require-all-rows_area").hide();
				}
			} else {
				$(".questionElements #require-all-rows_area").hide();
			}
		});
		$(document).on('change', '.questionElements #advance-polar', function () {
			let advance_polar = $('.questionElements #advance-polar').val();
			let question_val = $('.questionElements #question_type').val();
			var answerType = $('#change-answer-editor').val();
			if( 13 == question_val && $(this).val() != '' ){
				if ( $('#answers').find('.answers-single').length < 3 ) {
					jQuery('#answers').find('.answers-single').remove();
				}
				$('.questionElements').find('.new-answer-button').show();
			} else if( 13 == question_val && $(this).val() == '' ){
				QSMQuestion.prepareEditPolarQuestion(question_val);
			}
		});
	});

		/**
		 * Extend Object Functions / Methods
		 * @param targetF     Target Function / Method
		 * @param originalF   Original Function / Method
		 * @param parent      Parent Object of `originalF`
		 */
		function qsm_advance_question_extends_object_after( targetF, originalF, parent ) {
			if ( typeof parent == 'undefined' ) {
				return;
			}
			for ( var i in parent ) {
				if ( parent[i] === originalF ) {
					parent[i] = function () {
						originalF.apply( this, arguments );
						return targetF.apply( this, arguments )
					}
					break;
				}
			}
		}
		function qsm_advance_question_extends_object_before( targetF, originalF, parent ) {
			if ( typeof parent == 'undefined' ) {
				return;
			}
			for ( var i in parent ) {
				if ( parent[i] === originalF ) {
					parent[i] = function () {
						targetF.apply( this, arguments );
						return originalF.apply( this, arguments );
					}
					break;
				}
			}
		}
		function qsm_advance_question_extends_any_one_object( targetF, originalF, parent ) {
			if ( typeof parent == 'undefined' ) {
				return;
			}
			for ( var i in parent ) {
				if ( parent[i] === originalF ) {
					parent[i] = function () {
						if(!targetF.apply( this, arguments )){
							return originalF.apply( this, arguments );
						}
					}
					break;
				}
			}
		}
		function qsm_advance_question_extends_object_override( targetF, originalF, parent ) {
			if ( typeof parent == 'undefined' ) {
				return;
			}
			for ( var i in parent ) {
				if ( parent[i] === originalF ) {
					parent[i] = function () {
						return targetF.apply( this, arguments );
					}
					break;
				}
			}
		}

		function qsm_hide_show_question_desc(question_type) {
			$('.question-type-description').hide();
			if ($('#question_type_' + question_type + '_description').length > 0) {
				$('#question_type_' + question_type + '_description').show();
			}
		}

		var decodeEntities = (function () {
			//create a new html document (doesn't execute script tags in child elements)
			var doc = document.implementation.createHTMLDocument("");
			var element = doc.createElement('div');

			function getText(str) {
				element.innerHTML = str;
				str = element.textContent;
				element.textContent = '';
				return str;
			}

			function decodeHTMLEntities(str) {
				if (str && typeof str === 'string') {
					var x = getText(str);
					while (str !== x) {
						str = x;
						x = getText(x);
					}
					return x;
				}
			}
			return decodeHTMLEntities;
		})();

		QSM_advance_question = {
			addNewAnswer: function (answer, questionType = false) {
				if (!questionType) {
					questionType = $('#question_type').val();
				}
				questionType = parseInt( questionType );

				var multiple_grid = [16, 17];
				var advance_question_types = [15, 16, 17];
				if( -1 === $.inArray( questionType, advance_question_types ) ) return false;

				if (15 === questionType) {
					$('#new-answer-button').hide();
					var answerTemplate = wp.template('advance-question-matching-pairs');
					if ( typeof answer[3] !== 'undefined' && 'image' == answer['answerType']) {
						$('#answers').append(answerTemplate({
							answer: decodeEntities(answer[0]),
							points: answer[1],
							correct: answer[2],
							caption: answer[3],
							count: answer['index'],
							question_id: answer['question_id'],
							answerType: answer['answerType'],
							quiz_system: qsmQuestionSettings.quiz_system
						}));
					} else {
						$('#answers').append(answerTemplate({
							answer: decodeEntities(answer[0]),
							points: answer[1],
							correct: answer[2],
							count: answer['index'],
							question_id: answer['question_id'],
							answerType: answer['answerType'],
							quiz_system: qsmQuestionSettings.quiz_system
						}));
					}
					if (answer['answerType'] == 'rich' && qsmQuestionSettings.qsm_user_ve === 'true') {
						var settings = {
							mediaButtons: true,
							tinymce: {
								forced_root_block: '',
								toolbar1: 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,strikethrough,hr,forecolor,pastetext,removeformat,codeformat,charmap,undo,redo'
							},
							quicktags: true,
						};
						var textarea_id_lhs = 'answer-' + answer['question_id'] + '-' + answer['index'] + '-lhs';
						var textarea_id_rhs = 'answer-' + answer['question_id'] + '-' + answer['index'] + '-rhs';
						var answer = QSMQuestion.prepareQuestionText(answer[0]);
						answer_array = answer.split(',,');

						wp.editor.remove(textarea_id_lhs);
						wp.editor.initialize(textarea_id_lhs, settings);
						$(textarea_id_lhs).val(answer_array[0]);
						tinyMCE.get(textarea_id_lhs).setContent(answer_array[0]);

						wp.editor.remove(textarea_id_rhs);
						wp.editor.initialize(textarea_id_rhs, settings);
						if(typeof answer_array[1] == 'undefined'){
							answer_array[1]='';
						}
						$(textarea_id_rhs).val(answer_array[1]);
						tinyMCE.get(textarea_id_rhs).setContent(answer_array[1]);
					}
				}else if( -1 !== $.inArray( questionType, multiple_grid ) ){
					qsmQuestionSettings.default_answers = 1;
					var answerTemplate = wp.template('advance-question-multiple-grid');
					$('#answers').append(answerTemplate({
						answer: answer,
						quiz_system: qsmQuestionSettings.quiz_system,
						form_type: qsmQuestionSettings.form_type,
						question_type: questionType,
						answer_label: answer.hasOwnProperty('answer_label') ? answer.answer_label : []
					}));
				}
				return true;
			},
			openEditPopup: function (questionID, CurrentElement) {
				var advance_question_types = [15, 16, 17];
				var multiple_grid = [16, 17];

                var question = QSMQuestion.questions.get(questionID);
				var questionType = parseInt( question.get('type') );
				if( -1 === $.inArray( questionType, advance_question_types ) ) return false;
                if (CurrentElement.parents('.question').next('.questionElements').length > 0) {
                    if (CurrentElement.parents('.question').next('.questionElements').is(":visible")) {
                        CurrentElement.parents('.question').next('.questionElements').slideUp('slow');
                        $('.questions').sortable('enable');
                        $('.page').sortable('enable');
                    } else {
                        CurrentElement.parents('.question').next('.questionElements').slideDown('slow');
                    }
                    return true;
                } else {
                    $('.questions .questionElements').slideDown('slow');
                    $('.questions .questionElements').remove();
                }
                //Copy and remove popup div
                var questionElements = $('#modal-1-content').html();
                $('#modal-1-content').children().remove();
                CurrentElement.parents('.question').after("<div style='display: none;' class='questionElements'>" + questionElements + "</div>");

                //Show question id on question edit screen
                $('#qsm-question-id').text('ID: ' + questionID);
                QSMQuestion.prepareCategories();
                QSMQuestion.processCategories();
                var questionText = QSMQuestion.prepareQuestionText(question.get('name'));
                $('#edit_question_id').val(questionID);
                var answerInfo = question.get('answerInfo');
                var CAI_editor = '';
                var question_editor = ''
                if (qsmQuestionSettings.qsm_user_ve === 'true') {
                    wp.editor.remove('question-text');
                    wp.editor.remove('correct_answer_info');
                    QSMQuestion.prepareEditor();
                    question_editor = tinyMCE.get('question-text');
                    CAI_editor = tinyMCE.get('correct_answer_info');
                }
                if ($('#wp-question-text-wrap').hasClass('html-active')) {
                    jQuery("#question-text").val(questionText);
                } else if (question_editor) {
                    tinyMCE.get('question-text').setContent(questionText);
                } else {
                    jQuery("#question-text").val(questionText);
                }

                if ($('#wp-correct_answer_info-wrap').hasClass('html-active')) {
                    jQuery("#correct_answer_info").val(answerInfo);
                } else if (CAI_editor) {
                    tinyMCE.get('correct_answer_info').setContent(answerInfo);
                } else {
                    jQuery("#correct_answer_info").val(answerInfo);
                }

                $('#answers').empty();
                var answers = question.get('answers');
                var answerEditor = question.get('answerEditor');
                if (answerEditor === null || typeof answerEditor === "undefined") {
                    answerEditor = 'text';
                }
                //Check autofill setting
                var disableAutofill = question.get('autofill');
                if (disableAutofill === null || typeof disableAutofill === "undefined") {
                    disableAutofill = '0';
                }
                //Get text limit value
                var get_limit_text = question.get('limit_text');
                if (get_limit_text === null || typeof get_limit_text === "undefined") {
                    get_limit_text = '0';
                }
                //Get limit multiple response value
                var get_limit_mr = question.get('limit_multiple_response');
                if (get_limit_mr === null || typeof get_limit_mr === "undefined") {
                    get_limit_mr = '0';
                }
                //Get file upload limit
                var get_limit_fu = question.get('file_upload_limit');
                if (get_limit_fu === null || typeof get_limit_fu === "undefined") {
                    get_limit_fu = '0';
                }
                //Get checked question type
                var multicategories = question.get('multicategories');
                $("input[name='tax_input[qsm_category][]']:checkbox").attr("checked", false);
                if (multicategories === null || typeof multicategories === "undefined") {
                    //No Action Require
                } else {
                    $.each(multicategories, function (i, val) {
                        $("input[name='tax_input[qsm_category][]']:checkbox[value='" + val + "']").attr("checked", "true");
                    });
                }
                //Get featured image
                var get_featureImageSrc = question.get('featureImageSrc');
                var get_featureImageID = question.get('featureImageID');
                if (get_featureImageSrc === null || typeof get_featureImageSrc === "undefined") {
                    get_featureImageSrc = get_featureImageID = '';
                }
                //Get checked question type
                var get_file_upload_type = question.get('file_upload_type');
                $("input[name='file_upload_type[]']:checkbox").attr("checked", false);
                if (get_file_upload_type === null || typeof get_file_upload_type === "undefined") {} else {
                    var fut_arr = get_file_upload_type.split(",");
                    $.each(fut_arr, function (i) {
                        $("input[name='file_upload_type[]']:checkbox[value='" + fut_arr[i] + "']").attr("checked", "true");
                    });
                }
				if( -1 !== $.inArray( questionType, multiple_grid ) ){
					QSM_advance_question.addNewAnswer(answers, questionType);
				}else{
					var answer_index = 0;
					_.each(answers, function (answer) {
						answer['index'] = answer_index;
						answer['question_id'] = questionID;
						answer['answerType'] = answerEditor;
						QSMQuestion.addNewAnswer(answer,questionType);
						answer_index++;
					});
				}
                //get new question type
                var get_question_title = question.get('question_title');
                if (get_question_title === null || typeof get_question_title === "undefined") {
                    get_question_title = '';
                }

                //Hide the question settings based on question type
                $('.qsm_hide_for_other').hide();
                if ($('.qsm_show_question_type_' + questionType).length > 0) {
                    $('.qsm_show_question_type_' + questionType).show();
                }

                qsm_hide_show_question_desc(questionType);
                $('#hint').val(question.get('hint'));
                $("#question_type").val(questionType);
                $("#comments").val(question.get('comments'));
                //Changed checked logic based on new structure for required.
                $("input#required[value='" + question.get('required') + "']").prop('checked', true);
				if( 16 == questionType || 17 == questionType ){
					if( $(".questionElements input[name='required']").prop("checked") == true ){
						$(".questionElements #require-all-rows_area").show();
					} else {
						$(".questionElements #require-all-rows_area").hide();
					}
				} else {
					$(".questionElements #require-all-rows_area").hide();
				}
                $("#hide_autofill").val(disableAutofill);
                $("#limit_text").val(get_limit_text);
                $("#limit_multiple_response").val(get_limit_mr);
                $("#file_upload_limit").val(get_limit_fu);
                $("#change-answer-editor").val(answerEditor);
                $(".category-radio").removeAttr('checked');
                $("#edit-question-id").text('').text(questionID);
                $("#question_title").val(get_question_title);
                if (0 !== question.get('category').length) {
                    $(".category-radio").val([question.get('category')]);
                }
                //Append feature image
                if (get_featureImageSrc) {
                    var button = $('.qsm-feature-image-upl');
                    button.html('<img src="' + get_featureImageSrc + '" style="width:150px">');
                    button.next('.qsm-feature-image-rmv').show();
                    button.next().next('.qsm-feature-image-id').val(get_featureImageID);
                    button.next().next().next('.qsm-feature-image-src').val(get_featureImageSrc);
                }
                //Append extra settings
                var all_setting = question.get('settings');
				if ((typeof all_setting === 'undefined') || (all_setting && typeof all_setting.isPublished === 'undefined')) {
					$('#qsm-question-status').prop('checked', true).trigger('change');
				}
                if (all_setting === null || typeof all_setting === "undefined") {} else {
                    $.each(all_setting, function (index, value) {
                        if ($('#' + index + '_area').length > 0) {
                            if ($('#' + index + '_area').find('input[type="checkbox"]').length > 1) {
                                var fut_arr = value.split(",");
                                $.each(fut_arr, function (i) {
                                    $(".questionElements input[name='" + index + "[]']:checkbox[value='" + fut_arr[i] + "']").attr("checked", "true").prop('checked', true);
                                });
                            } else {
                                if (value != null)
                                    $('#' + index).val(value);
                            }
                        }
                        if (index == 'matchAnswer') {
                            $('#match-answer').val(value);
                        }
						if (index == 'isPublished') {
							if ( all_setting.isPublished == 1 ) {
								$('#qsm-question-status').prop('checked', true).trigger('change');
							} else {
								$('#qsm-question-status').prop('checked', false).trigger('change');
							}
						}
						if( index == 'require-all-rows' ) {
							if( value == 0 && question.get('required' ) == 0) {
								$(".questionElements #require-all-rows[value='" + value + "']").prop('checked', true);
							} else {
								if(question.get('required') == 0) {
									$(".questionElements input#require-all-rows[value='" + value + "']").prop('checked', false);
								} else {
									$(".questionElements #require-all-rows_area").hide();
								}
							}
						}
                    });
                }
                CurrentElement.parents('.question').next('.questionElements').slideDown('slow');
                $('#modal-1-content').html(questionElements);
                //MicroModal.show( 'modal-1' );
                $('.questions').sortable('disable');
                $('.page').sortable('disable');

                QSMQuestion.sync_child_parent_category(questionID);

				/**
				 * Hide new answer button for grid question types
				 */
				if ( 16 == questionType || 17 == questionType ) {
					$( '#new-answer-button' ).hide();
				} else {
					$( '#new-answer-button' ).show();
				}
				let link_quizzes_array = question.get('link_quizzes');

				$('.qsm-linked-list-inside').hide().empty();
				$('.qsm-linked-list-div-block').hide();

				if (typeof link_quizzes_array == 'object' && link_quizzes_array != null && Object.keys(link_quizzes_array).length > 0) {

					Object.values(link_quizzes_array).forEach(function(quizName) {
						// Ensure each quizName is a valid non-empty string
						if (quizName && typeof quizName == 'string' && quizName.trim().length > 0) {
							let link = $('<span></span>')
								.attr('class', 'qsm-linked-list-item')
								.attr('title', quizName)
								.text(quizName.length > 25 ? quizName.substring(0, 25) + '...' : quizName);

							$('.qsm-linked-list-div-block').show();
							$('.qsm-linked-list-inside').append(link);
						}
					});

					// Add an "Unlink" link at the end
					let unlink = $('<span></span>')
						.attr('class', 'qsm-unlink-the-question button button-danger')
						.attr('data-question-id', questionID)
						.text(qsm_admin_messages.unlink_question);
						$('.qsm-linked-list-inside').append(unlink);
				}
                jQuery(document).trigger('qsm_open_edit_popup', [questionID, CurrentElement]);
				return true;
            },
			question_type_change: function(previous_question_val, questionID){
				var multiple_grid = [16, 17];
				var ans_length = 0;
				$(".answers-single input").each(function() {
					var val = $(this).val();
					if( "" !== val) {
						ans_length++;
					}
				});
				questionID = parseInt( questionID );

                //Hide the question settings based on question type
                $('.qsm_hide_for_other').hide();
                if ($('.qsm_show_question_type_' + questionID).length > 0) {
                    $('.qsm_show_question_type_' + questionID).show();
                }
				previous_question_val = parseInt( previous_question_val );
				if( 16 == questionID || 17 == questionID ){
					if( $(".questionElements input[name='required']").prop("checked") == true ){
						$(".questionElements #require-all-rows_area").show();
					} else {
						$(".questionElements #require-all-rows_area").hide();
					}
				} else {
					$(".questionElements #require-all-rows_area").hide();
				}
				if( 16 == questionID || 17 == questionID ){
					$('#new-answer-button').hide();
				} else {
					$('#new-answer-button').show();
				}
				if( 15 === previous_question_val || 15 === questionID || ( -1 !== $.inArray( questionID, multiple_grid ) && -1 === $.inArray( previous_question_val, multiple_grid ) ) || ( -1 !== $.inArray( previous_question_val, multiple_grid ) && -1 === $.inArray( questionID, multiple_grid ) ) ){
					if( 0 == ans_length ){
						$('#answers').find('.answers-single').remove();
						$('#new-answer-button').click();
					} else if (confirm('All answer will be reset, Do you want to still continue?')) {
						$('#answers').find('.answers-single').remove();
						$('#new-answer-button').click();
						return true;
					}else{
						$('#question_type').val(previous_question_val);
						return false;
					}
				}else{
					return false;
				}
				jQuery(document).trigger('qsm_question_type_change_after', [questionID]);
			},
			answerFilter: function (answers, $answers, answerType) {
				return answers;
			},
			saveQuestion: function (questionID, CurrentElement) {
				questionType = parseInt( $('#question_type').val() );
				var multiple_grid = [16, 17];
				var advance_question_types = [15, 16, 17];
				if( -1 === $.inArray( questionType, advance_question_types ) ) return false;

				QSMAdmin.displayAlert('Saving question...', 'info');
                var model = QSMQuestion.questions.get(questionID);
                var hint = $('#hint').val();
                var name = wp.editor.getContent('question-text');
                //Save new question title
                var question_title = $('#question_title').val();
                if (name == '' && question_title == '') {
                    return false;
                }
                var advanced_option = {};
                var answerInfo = wp.editor.getContent('correct_answer_info');
                var quizID = parseInt( qsmTextTabObject.quiz_id );
                var type = $("#question_type").val();
                var comments = $("#comments").val();
                advanced_option['required'] = $(".questionElements input[name='required']").is(":checked") ? 0 : 1;
				advanced_option['require-all-rows'] = $(".questionElements input[name='require-all-rows']").is(":checked") ? 0 : 1;
                var category = $(".category-radio:checked").val();
                var autofill = $("#hide_autofill").val();
                var limit_text = $("#limit_text").val();
                var limit_multiple_response = $("#limit_multiple_response").val();
                var file_upload_limit = $("#file_upload_limit").val();
                var type_arr = [];
                $.each($("input[name='file_upload_type[]']:checked"), function () {
                    type_value = $(this).val().replace(/,/g, '');
                    type_arr.push(type_value);
                });
                if ('new_category' == category) {
                    category = $('#new_category').val();
                }
                if (!category) {
                    category = '';
                }
                var multicategories = [];
                $.each($("input[name='tax_input[qsm_category][]']:checked"), function () {
                    multicategories.push($(this).val());
                });
                var featureImageID = $('.qsm-feature-image-id').val();
                var featureImageSrc = $('.qsm-feature-image-src').val();
                var answerType = $('#change-answer-editor').val();
                var matchAnswer = $('#match-answer').val();

				var $answer, answer, caption, answer_l, answer_r, caption_l, caption_r, row_val, ta_id_lhs, ta_id_rhs, points, correct;
                var answers = [];
				if( 15 === questionType ){
					var $answers = jQuery('.answers-single');
					_.each($answers, function (answer) {
						$answer = jQuery(answer);
						answer = caption = answer_l = answer_r = caption_l = caption_r = '';
						if (answerType == 'rich') {
							ta_id_lhs = $answer.find('.answer-textarea-lhs').attr('id');
							ta_id_rhs = $answer.find('.answer-textarea-rhs').attr('id');
							answer_l = wp.editor.getContent(ta_id_lhs);
							answer_r = wp.editor.getContent(ta_id_rhs);
						} else if (answerType == 'image') {
							answer_l = $.QSMSanitize( $answer.find('.answer-text-lhs').val().trim() );
							caption_l = $.QSMSanitize( $answer.find('.answer-caption-lhs').val().trim() );
							answer_r = $.QSMSanitize( $answer.find('.answer-text-rhs').val().trim() );
							caption_r = $.QSMSanitize( $answer.find('.answer-caption-rhs').val().trim() );
							caption = caption_l+',,'+caption_r;
						} else {
							answer_l = $.QSMSanitize( $answer.find('.answer-text-lhs').val().trim() );
							answer_r = $.QSMSanitize( $answer.find('.answer-text-rhs').val().trim() );
						}

						answer = answer_l+',,'+answer_r;
						points = $answer.find('.answer-points').val();
						correct = 1;

						if (answerType == 'image') {
							answers.push([answer, points, correct, caption]);
						} else {
							answers.push([answer, points, correct]);
						}

					});
				} else if( -1 !== $.inArray( questionType, multiple_grid )  ){
					var $rows = jQuery('.qsm-advance-question-rows-list');
					var rows = [];
					_.each($rows, function (row) {
						row_val = $.QSMSanitize( jQuery(row).find('.answer-text-row').val().trim() );
						rows.push(row_val);

					});

					var $answers = jQuery('.qsm-advance-question-column-list');
					var columns = [];
					var points = [];
					var corrects = [];
					let i = 0;
					_.each($answers, function (answer) {
						$answer = jQuery(answer);
						column = $.QSMSanitize( $answer.find('.answer-text-column').val().trim() );
						$ci_ps = $answer.find('.qsm-grid-points-section');
						let j = 0;
						_.each($ci_ps, function (ci_p) {
							$ci_p = jQuery(ci_p);
							point = $ci_p.find('.answer-points').val();
							correct = $ci_p.find('.answer-correct').prop('checked') == true ? 1 : 0;
							points.push(point);
							corrects.push(correct);
						});
						columns.push(column);
					});
					answers = {"columns":columns, "points":points, "corrects":corrects, "rows":rows};
					answers = QSM_advance_question.answerFilter(answers, $answers, answerType);
				}

				/**
				 * Override answers variable for remove empty string ('') elements.
				 */

				let isPublished = $(".questionElements input[name='question_status']").is(":checked") ? 1 : 0;
				model.set('is_published', isPublished);
                $('.questionElements .advanced-content > .qsm-row ').each(function () {
                    if ($(this).find('input[type="text"]').length > 0) {
                        var element_id = $(this).find('input[type="text"]').attr('id');
                        advanced_option[element_id] = $(this).find('input[type="text"]').val();
                    } else if ($(this).find('input[type="number"]').length > 0) {
                        var element_id = $(this).find('input[type="number"]').attr('id');
                        advanced_option[element_id] = $(this).find('input[type="number"]').val();
                    } else if ($(this).find('select').length > 0) {
                        var element_id = $(this).find('select').attr('id');
                        advanced_option[element_id] = $(this).find('select').val();
                    } else if ($(this).find('input[type="checkbox"]').length > 0) {
                        var element_id = $(this).find('input[type="checkbox"]').attr('name');
                        var multi_value = $(this).find('input[type="checkbox"]:checked').map(function () {
                            return this.value;
                        }).get().join(',');
                        element_id = element_id.replace('[]', '');
                        advanced_option[element_id] = multi_value;
                    }
                });
                model.save({
                    quizID: quizID,
                    type: type,
                    name: name,
                    question_title: question_title,
                    answerInfo: answerInfo,
                    comments: comments,
                    hint: hint,
                    category: category,
                    multicategories: multicategories,
                    featureImageID: featureImageID,
                    featureImageSrc: featureImageSrc,
                    answers: answers,
                    answerEditor: answerType,
                    matchAnswer: matchAnswer,
                    other_settings: advanced_option,
                    settings: advanced_option,
                    required: advanced_option['required'],
                    rest_nonce: qsmQuestionSettings.rest_user_nonce
                }, {
                    headers: {
                        'X-WP-Nonce': qsmQuestionSettings.nonce
                    },
                    success: QSMQuestion.saveSuccess,
                    error: QSMAdmin.displayError,
                    type: 'POST'
                });
                jQuery(document).trigger('qsm_save_question', [questionID, CurrentElement]);

				return true;
			},
		}
		/**
		 * Extending Main Plugin Object Methods
		 */
		qsm_advance_question_extends_any_one_object( QSM_advance_question.openEditPopup, QSMQuestion.openEditPopup, QSMQuestion );
		qsm_advance_question_extends_any_one_object( QSM_advance_question.addNewAnswer, QSMQuestion.addNewAnswer, QSMQuestion );
		qsm_advance_question_extends_any_one_object( QSM_advance_question.saveQuestion, QSMQuestion.saveQuestion, QSMQuestion );
		qsm_advance_question_extends_object_after( QSM_advance_question.question_type_change, QSMQuestion.question_type_change, QSMQuestion );
	}

}( jQuery ) );

jQuery(function ($) {
	jQuery('.qsm-toggleButton').on("click", function( event ) {
		event.preventDefault();
		if ( parseInt(jQuery(this).attr('data-toggle')) === 0 ) {
			jQuery(document).find('#qsm-license_entry').show();
			jQuery(document).find('.qsm-license-content .qsm-license-info').hide();
		} else {
			jQuery(document).find('.qsm-license-content .qsm-license-info').show();
			jQuery(document).find('#qsm-license_entry').hide();
		}
	});
	jQuery( '.qsm-license-container' ).on( 'click', '#qsm-validate_btn', function ( event ) {
		event.preventDefault();
		var license_message = jQuery('#qsm-license_entry .qsm-validate-msg');
		license_message.html(qsm_license_validate_obj.hold).fadeIn();
		if( jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val() != "") {
			var data = {
				action: 'qsm_advance_question_type_validate_license',
				input: jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val(),
				update_status: 'yes',
			};
			jQuery.post( ajaxurl, data, function ( response ) {
				console.log(response);
				response = jQuery.parseJSON(response);
				if(response.validate == 1 || response.validate == 2) {
					setTimeout(function() {
						location.reload();
					}, 2000);
				} else {
					license_message.html(qsm_license_validate_obj.invalid).fadeIn();
				}
			});
		} else {
			license_message.html(qsm_license_validate_obj.empty);
			jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').focus();
		}
	});
    jQuery( document ).on( 'click', 'form .qsm_advance_question_validate_button', function ( event ) {
        event.preventDefault();
        var license_message = jQuery('.qsm_advance_question_validate_message');
        jQuery("#qsm-license_message").show();
        if( jQuery('.qsm_advance_question_validate_input').val() != "") {
          license_message.html(qsm_advance_question_obj.please_wait);
          var data = {
            action: 'qsm_advance_question_type_validate_license',
            input: jQuery('.qsm_advance_question_validate_input').val(),
          };
          jQuery.post( ajaxurl, data, function ( response ) {
            response = jQuery.parseJSON(response);
            license_message.html(response.message);
            if(response.validate == 1 || response.validate == 2) {
              response.validate == 1 ? jQuery("#qsm-license_message").css({'color': '#00a32a'}) : "";
              setTimeout(function() {
                location.reload();
              }, 4000);
            } else {
				license_message.html(qsm_advance_question_obj.invalid).fadeIn();
			}
          });
        }else{
          license_message.html(qsm_advance_question_obj.license_msg);
          jQuery('.qsm_advance_question_validate_input').focus();
        }
    });
});