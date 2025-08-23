/**
 * QSM - Logic v1.0.2
 */

var QSMLogic;
(function ($) {
	const { __ } = wp.i18n;
	QSMLogic = {
		question: Backbone.Model.extend({
			defaults: {
				id: null,
				quizID: 1,
				type: '0',
				name: 'Your new question!',
				answerInfo: '',
				comments: '1',
				hint: '',
				category: '',
				required: 1,
				answers: [],
				page: 0
			}
		}),
		questions: null,
		pages: null,
		questionCollection: null,
		VERSION : '1.0.2',
		DEFAULTS : {},
		question_option_string : "",
		question_pages : "",
		questions_array : {},
		pages_array : {},
		category_array : {},
		category_option_string : "",
		categories_tree : {},
		no_rules : '<img src="'+qsmLogicObject.lyr_image+'" /><p>No ‘<span>OR conditions</span>’ implemented yet</p>',
		loadQuestions: function() {
			QSMLogic.choose_display();
			$.ajax({
				url: wpApiSettings.root + 'quiz-survey-master/v1/quizzes/' + qsmLogicObject.quizID + '/categories',
				headers: { 'X-WP-Nonce': qsmLogicObject.nonce },
			}).done(function( categories ) {
				QSMLogic.categories_tree = categories.tree;
				QSMLogic.category_option_string = '<optgroup label="Category">'+QSMLogic.loadCategoryString(categories.tree, '')+'</optgroup>';
			}).fail(QSMAdmin.displayjQueryError);

			QSMLogic.questions.fetch({
				headers: { 'X-WP-Nonce': qsmLogicObject.nonce },
				data: { quizID: qsmLogicObject.quizID },
				success: QSMLogic.loadSuccess,
				error: QSMAdmin.displayError
			});
		},
		loadCategoryString: function (tree, string, space = '') {
			if ( typeof tree !== "undefined" && tree !== null ) {
				tree.forEach( function ( obj, i, tree ) {
					QSMLogic.category_array['c'+obj.term_id] = obj.name;
					string += '<option value="c' + obj.term_id + '" data-parent="' + obj.parent + '">' + space + obj.name + '</option>';
					if ( typeof obj.children !== "undefined" && obj.children !== null ) {
						string = QSMLogic.loadCategoryString( obj.children, string, space + '&nbsp;&nbsp;&nbsp;&nbsp;');
					}
				} );
			}
			return string;
		},
		loadSuccess: function() {
			QSMAdmin.clearAlerts();
			QSMLogic.questions.each(function( question ) {
				var new_question_title = question.get('question_title');
				if( typeof new_question_title === "undefined" || new_question_title === null || new_question_title === "" ){
					var question_title =  question.get('name');
				}else{
					var question_title =  new_question_title;
				}
				QSMLogic.question_option_string += '<option value="' + question.get('id') + '">' + question_title + '</option>';
				QSMLogic.questions_array[question.get('id')] = question_title;
			});
			_.each(qsmLogicObject.quiz_qpages_id, function(page) {
				if (page && page.id) {
					QSMLogic.question_pages += '<option value="' + page.id + '">' + page.pagekey + '</option>';
					QSMLogic.pages_array[page.id] = page.pagekey;
				} else {
					console.warn("Page object is missing an 'id' property:", page);
				}
			});
				QSMLogic.load();
		},
		// Prepares add rules popup
		add_rule : function() {
			$( '#modal-wizard-logic-content' ).html(
				'<div class="logic-rule-single" data-status="updated" data-id="">' +
				'<div class="logic-rule-single-body">' +
					'<div class="logic-rule-single-if">' +
					'<div class="logic-rule-single-if-row" data-logic-level="0" style="padding-left: 50px;">'+
						'<select class="if-question">' +
						'<option value="0">Select a question</option>' +
						QSMLogic.question_option_string +
						'</select>' +
						'<select class="if-condition">' +
						'<option>is equal to</option>' +
						'<option>is not equal to</option>' +
						'<option>is greater than</option>' +
						'<option>is less than</option>' +
						'<option>is empty</option>' +
						'<option>is not empty</option>' +
						'</select>' +
						'<select class="if-answer">' +
						'<option value="0">'+__( 'Select an answer','qsm-logic' )+'</option>' +
						'</select>' +
						'<span class="custom-add-ele add-new-if dashicons dashicons-insert "></span>' +
					'</div>' +
					'</div>' +
					'<div class="new-group-row">' +
					QSMLogic.no_rules
					 +'<span class="button add-new-group-button">'+__( 'Add New Group', 'qsm-logic' )+'</span>' +
					'</div>' +
					'<div class="logic-rule-single-then">' +
						'<div class="logic-rule-single-then-row">'+__( 'Then ' ,'qsm-logic')+
							'<select class="then-condition">' +
							'<option value="Show">' + __("Show", "qsm-logic") + '</option>' +
							'<option value="Hide">' + __("Hide", "qsm-logic") + '</option>' +
							'<option value="endquiz">' + __("End quiz", "qsm-logic") + '</option>' +
							'<option value="goto">' + __("Goto Pages", "qsm-logic") + '</option>' +
							'</select>' +
							'<select class="then-question">' +
							'<option value="0">'+__( 'Select a question', 'qsm-logic' )+'</option>' +
							QSMLogic.question_option_string +
							QSMLogic.category_option_string +
							'</select>' +
							'<select class="then-page" style="display: none;">' +
							'<option value="0">'+__( 'Select a Page', 'qsm-logic' )+'</option>' +
							QSMLogic.question_pages +
							'</select>' +
						'</div>' +
						'<div class="logic-rule-single-then-row add-new-then-btn">' +
							'<span class="button add-new-then">'+__( 'Add additional action', 'qsm-logic' )+'</span>' +
						'</div>' +
					'</div>' +
				'</div>' +
				'</div>'
			);
			// Handle then-condition change
			$(document).on('change', '.then-condition', function() {
				QSMLogic.handleThenConditionChange($(this));
			});
			MicroModal.show('modal-wizard-logic');
		},
		// Handles the visibility of question/page based on then-condition
		handleThenConditionChange: function($element) {
			var $row = $element.closest('.logic-rule-single-then-row');
			$row.find('.then-page').hide();
			$row.find('.qsm-tooltips-icon').remove();
			
			if ($element.val() === 'goto') {
				$row.find('.then-question').hide();
				$row.find('.then-page').show();
				$row.addClass('logic-rule-tooltip');
				
				$row.append(
					'<span class="dashicons dashicons-editor-help qsm-tooltips-icon">' +
					  '<span class="qsm-tooltips qsm-logic-goto-warning-msg">' + 
						__('Implementing backward navigation logic is not currently supported.', 'qsm-logic') + 
					  '</span>' +
					'</span>'
				);
			} else {
				$row.find('.then-question').show();
				$row.find('.then-page').hide();
				$row.removeClass('logic-rule-tooltip');
			}
		},		
		// Deletes single rule
		deleteRule : function( $deleteElement ) {
			let status = true;
			id = $deleteElement.parent().parent().data("id");
			if(id){
				var data = {
					action: 'qsm_delete_logic',
					id : id,
				};

				jQuery.post( qsmLogicObject.ajaxurl, data, function( response ) {
					response = JSON.parse( response );
					status = response.status;
				});
			}

			if(status){
				if($('.logic-rules .logic-rule-single').length == 1){
					QSMLogic.choose_display('new');
				}
				$deleteElement.parent().parent().remove();
				QSMAdmin.displayAlert( __( 'Success! Your rules have been deleted!', 'qsm-logic'), 'info' );
			} else {
				QSMAdmin.displayAlert( __( 'Error! Unable to delete rule, Try again later!', 'qsm-logic' ), 'error' );
			}
		},
		// Adds new condition in logic popup
		addCondition : function( $ifElement ) {
			let dc_logic_level = $ifElement.find('.logic-rule-single-if-row').data('logic-level');
			$ifElement.append(
				'<div class="logic-rule-single-if-row" data-logic-level="'+dc_logic_level+'">'+
				'<span class="dashicons dashicons-remove delete-if-row"></span>' +
					'<select class="if-question">' +
						'<option value="0">'+__( 'Select a question', 'qsm-logic')+'</option>' +
						QSMLogic.question_option_string +
					'</select>' +
					'<select class="if-condition">' +
						'<option>is equal to</option>' +
						'<option>is not equal to</option>' +
						'<option>is greater than</option>' +
						'<option>is less than</option>' +
						'<option>is empty</option>' +
						'<option>is not empty</option>' +
					'</select>' +
					'<select class="if-answer">' +
						'<option value="0">'+__( 'Select an answer', 'qsm-logic' )+'</option>' +
					'</select>' +
					'<span class="custom-add-ele add-new-if dashicons dashicons-insert "></span>' +
				'</div>'
			);
		},
		// Deletes an existing condition on click of trash icon
		deleteCondition : function( $deleteElement ) {
			$firstParent = $deleteElement.parents('.logic-rule-single-if');
			$grand_parent = $firstParent.parents('.logic-rule-single-body');
			$thisElementParent = $deleteElement.parents('.logic-rule-single-if-row');
			$prevElement = $thisElementParent.prev();
			$nextElement = $thisElementParent.next();
			$deleteElement.parent().remove();
			if ($nextElement.length == 0) {
				$prevElement.find(".custom-add-ele").text("");
				$prevElement.find(".custom-add-ele").addClass("dashicons dashicons-insert add-new-if");
			}
			if($firstParent.find(".logic-rule-single-if-row").length == 0) {
				$firstParent.remove();
			}
			if($grand_parent.find(".logic-rule-single-if").length == 1 && $thisElementParent.data("logic-level") > 0) {
				$grand_parent.find(".new-group-row").find(".add-new-group-button").before(QSMLogic.no_rules);
				$grand_parent.find(".new-group-row").css({"border": "1.5px dashed #CBD5E1", "padding": "15px 0"});
			}
		},
		addTrigger : function( $thenElement ) {
			$thenElement.append(
				'<div class="logic-rule-single-then-row">And ' +
					'<select class="then-condition">' +
						'<option value="Show">' + __("Show", "qsm-logic") + '</option>' +
						'<option value="Hide">' + __("Hide", "qsm-logic") + '</option>' +
						'<option value="endquiz">' + __("End quiz", "qsm-logic") + '</option>' +
						'<option value="goto">' + __("Goto Pages", "qsm-logic") + '</option>' +
					'</select>' +
					'<select class="then-question">' +
						'<option value="0">'+__( 'Select a question', 'qsm-logic' )+'</option>' +
						QSMLogic.question_option_string +
						QSMLogic.category_option_string +
						'</select>' +
						'<select class="then-page" style="display: none;">' +
						'<option value="0">'+__( 'Select a Page', 'qsm-logic' )+'</option>' +
						QSMLogic.question_pages +
						'</select>' +
					'<span class="delete-then-row dashicons dashicons-trash"></span>' +
				'</div>' +
				'<div class="logic-rule-single-then-row add-new-then-btn">' +
					'<span class="button add-new-then">'+__( 'Add additional action', 'qsm-logic' )+'</span>' +
				'</div>'
			);
			// Handle then-condition change
			$(document).on('change', '.then-condition', function() {
				QSMLogic.handleThenConditionChange($(this));
			});
		},
		deleteTrigger : function( $deleteElement ) {
			$deleteElement.parent().remove();
		},
		// Updates answers select field when question is changed
		changeQuestion : function( questionID, $questionElement ) {
			ifAnswer = $questionElement.siblings( '.if-answer' );
			QSMLogic.questions.each(function( question ) {
				if ( question.get('id') === questionID ) {
					switch ( question.get('type') ) {
						case "0":
						case "1":
						case "2":
						case "4":
						case "10":
							$( '<select class="if-answer"></select>').insertAfter(ifAnswer);
							ifAnswer.remove();
							$.each( question.get('answers'), function( j, answer ) {
								$questionElement.siblings( '.if-answer' ).append( '<option>' + encodeEntities( answer[0] ) + '</option>' );
							});
							break;
						case "7":
							$( '<input type="number" class="if-answer" />').insertAfter(ifAnswer);
							ifAnswer.remove();
							break;
						case "3":
						case "5":
						default:
							$( '<input type="text" class="if-answer" />').insertAfter(ifAnswer);
							ifAnswer.remove();
					}
				}
			});
			$questionElement.removeAttr("style");
		},
		// Loads page depending on several conditions
		load : function(LogicObject = false) {
			proceed = true;
			if(!LogicObject){
				LogicObject = qsmLogicObject;
				if(LogicObject.load_modal && LogicObject.logicRules !== ''){
					QSMAdmin.displayAlert( __( 'Upgrade Message', 'qsm-logic' ), 'error' );
					$notice = $('<strong>'+__('Upgrade Message','qsm-logic')+'</strong><br/><br/>'+
					+__( 'From version', 'qsm-logic' )+' <code>2.0.0</code> '+__( 'we are upgrading to better database structure.', 'qsm-logic' )+
					__('All your logic rules will be migrated to new tables. ','qsm-logic')+
					__( 'Hence we recommend to take a ', 'qsm-logic' )+'<strong>'+__( 'database backup', 'qsm-logic' )+'</strong><br/><br/>'+
					'<a class="save-rules button-primary">'+__( 'Upgrade', 'qsm-logic' )+'</a>'
					);
					$('.notice-error:last-child').html($notice);
					$('.notice-error:last-child').addClass('is-dismissible');
					QSMLogic.choose_display('upgrade');
					proceed = false;
				} else if(!LogicObject.logicRules || LogicObject.logicRules.length == 0){
					QSMLogic.choose_display('new');
				} else {
					QSMLogic.choose_display('table');
				}
			}

			if(!proceed){
				return;
			}
			QSMAdmin.displayAlert( __( 'Preparing logic rules...', 'qsm-logic' ), 'info' );
			var $logic_rule = '';

			$.each( LogicObject.logicRules, function( i, val ) {
				if(LogicObject.ids !== undefined){
					$current_id = LogicObject.ids[i];
				} else {
					$current_id = '';
				}
				alternate = '';
				if(i%2 > 0){
					alternate = 'alternate';
				}
				$logic_rule = $( '<tr class="logic-rule-single ' + alternate + '" data-status="default" data-id="'+$current_id+'">' +
						'<td><input type="checkbox" class="check_logic" value="'+$current_id+'" /></td>'+
						'<td class="logic-rule-single-if">' +
						'</td>' +
						'<td class="logic-rule-single-then">' +
						'</td>' +
					'</tr>' );
					let data_logic_level = 0;
				$.each( val.if, function( j, ifVal ) {
					if(data_logic_level < ifVal.logic_level) {
						$logic_rule.find( '.logic-rule-single-if' ).append( '<b>OR</b><br/>');
					} else {
						if ( 0 !== j ) {
							$logic_rule.find( '.logic-rule-single-if' ).append( 'AND<br/>');
						}
					}
					$logic_rule.find( '.logic-rule-single-if' ).append(
						QSMLogic.questions_array[ifVal.question]+
						' '+
						'<strong><i>'+ifVal.condition+'</i></strong>'+
						' '+
						encodeEntities( ifVal.answer )+
						'<br/>'
					);
					data_logic_level = ifVal.logic_level;
				});

				$.each( val.then, function( j, thenVal ) {	
					if ( 0 !== j ) {
						$logic_rule.find( '.logic-rule-single-then' ).append( 'AND<br/>');
					}
					var then_condition = thenVal.condition;
					var then_value = '';
					if ( typeof QSMLogic.questions_array[thenVal.question] !== "undefined" ) {
						then_condition += ' Question';
						then_value = QSMLogic.questions_array[thenVal.question];
					} else {
						then_condition += ' Page';
						then_value = QSMLogic.pages_array [thenVal.question];
					}
					if ( typeof QSMLogic.category_array[thenVal.question] !== "undefined" ) {
						then_condition += ' Category';
						then_value = QSMLogic.category_array[thenVal.question];
					}
					$logic_rule.find( '.logic-rule-single-then' ).append(
						'<strong><i>' + then_condition + '</i></strong>' + ' ' + then_value + '<br/>'
					);
				});

				$logic_rule.find( '.logic-rule-single-if' ).append(
					'<span class="action-label edit-rule">'+__( 'Edit', 'qsm-logic')+' | </span> ' +
					'<span class="action-label delete-rule">'+__( 'Delete', 'qsm-logic' )+'</span>'
				)

				if(! $.isEmptyObject(edit_element)){
					$logic_rule.insertAfter(edit_element)
					edit_element.remove();
					edit_element = {};
				} else {
					$( '.logic-rules' ).append( $logic_rule );
				}
			});
			if($logic_rule.length > 0){
				QSMLogic.choose_display('table');
			}
			QSMAdmin.clearAlerts();
		},
		edit_rule : function(logicId) {
			var data = {
				action: 'qsm_edit_logic',
				id : logicId,
			};

			jQuery.post( qsmLogicObject.ajaxurl, data, function( response ) {
				response = JSON.parse(response);
				if(response.status == true){
					QSMLogic.load_edit_rule(response);
					$("#modal-wizard-logic .qsm-popup__content .logic-rule-single-if:first .logic-rule-single-if-row:first").css('padding-left', '50px');
				} else {
					QSMAdmin.displayAlert( __( 'Error loading data. Please try again','qsm-logic' ), 'error' );
				}

			});
		},
		load_edit_rule: function(LObject){
			LogicObject = LObject;
			var $logic_rule = '';
			$.each( LogicObject.logicRules, function( i, val ) {
				if(LogicObject.ids !== undefined){
					$current_id = LogicObject.ids[i];
				} else {
					$current_id = '';
				}
				$logic_rule = $( '<div class="logic-rule-single ' + i + '" data-status="default" data-id="'+$current_id+'">' +
					'<div class="logic-rule-single-body">' +
						'<div class="logic-rule-single-then">' +
						'</div>' +
					'</div>' +
					'</div>' );
					let current_group = 0;
					let full_structure = "";
					let loop_count = 0;
					let data_logic_level = 0;
				$.each( val.if, function( j, ifVal ) {
					loop_count++;
					current_group_removel = structure_before = "";
					if((ifVal.logic_level != 'undefined') & (ifVal.logic_level > current_group)) {
						structure_before = '</div><div class="logic-rule-single-if">';
						current_group_removel = '<div class="new-group-parent">'+
						'<span class="or-before-after">'+__( 'OR', 'qsm-logic')+'</span></div>';
						data_logic_level = ifVal.logic_level;
					} else {
						data_logic_level = current_group;
					}

					if( loop_count == 1) {
						structure_before = '<div class="logic-rule-single-if">';
					}
					var remove_icon = '<span class="dashicons dashicons-remove delete-if-row"></span>';
					if(j == 0){
						remove_icon = "";
					}
					full_structure += structure_before + current_group_removel +
					'<div class="logic-rule-single-if-row ' + j + '" data-logic-level="'+ data_logic_level +'">'+
						remove_icon+
						'<select class="if-question">' +
							'<option value="0">Select a question</option>' +
							QSMLogic.question_option_string +
						'</select>' +
						'<select class="if-condition">' +
							'<option>is equal to</option>' +
							'<option>is not equal to</option>' +
							'<option>is greater than</option>' +
							'<option>is less than</option>' +
							'<option>is empty</option>' +
							'<option>is not empty</option>' +
						'</select>' +
						'<input type="text" class="if-answer" disabled/>'+
						'<span class="custom-add-ele add-new-if dashicons dashicons-insert "></span>' +
					'</div>';
					current_group = ifVal.logic_level;
				});
				$logic_rule.find( '.logic-rule-single-body' ).find('.logic-rule-single-then').before(full_structure);
				let after_data_logic_level = 0;
				let loop = 0;
				var edit_no_rules = "";
				$.each( val.if, function( j, ifVal ) {
					if( after_data_logic_level < ifVal.logic_level) {
						loop = 0;
					}
					// if ( 0 !== loop ) {
					// 	$logic_rule.find( '.logic-rule-single-if .logic-rule-single-if-row.' + j ).prepend( '<span class="dashicons dashicons-remove delete-if-row"></span>' );
					// }
					loop++;
					$logic_rule.find( '.logic-rule-single-if .logic-rule-single-if-row.' + j + ' .if-question' ).val( ifVal.question );
					$logic_rule.find( '.logic-rule-single-if .logic-rule-single-if-row.' + j + ' .if-condition' ).val( ifVal.condition );
					$logic_rule.find( '.logic-rule-single-if .logic-rule-single-if-row.' + j + ' .if-answer' ).val( encodeEntities( ifVal.answer ) );
					after_data_logic_level =  ifVal.logic_level;
				});

				$grand_parent = $logic_rule.find( '.logic-rule-single-body' );
				if($grand_parent.find(".logic-rule-single-if").length == 1 && ( after_data_logic_level == 0 || typeof after_data_logic_level === 'undefined') ) {
					edit_no_rules = QSMLogic.no_rules;
				}

				$grand_parent.find(".logic-rule-single-if").find(".logic-rule-single-if-row:not(:last-child)").find(".custom-add-ele").removeClass("add-new-if dashicons dashicons-insert");
				$grand_parent.find(".logic-rule-single-if").find(".logic-rule-single-if-row:not(:last-child)").find(".custom-add-ele").text("and");
				$grand_parent.find(".logic-rule-single-if").find(".logic-rule-single-if-row:last-child").find(".custom-add-ele").addClass("add-new-if dashicons dashicons-insert");

				$logic_rule.find( '.logic-rule-single-body' ).find('.logic-rule-single-then').before('<div class="new-group-row">' +
				edit_no_rules+'<span class="button add-new-group-button">'+__( 'Add New Group', 'qsm-logic' )+'</span>' +
				'</div>');

				$.each( val.then, function( j, thenVal ) {

				$logic_rule.find( '.logic-rule-single-then' ).append(
					'<div class="logic-rule-single-then-row ' + j + '"></div>');
					if ( 0 !== j ) {
						$logic_rule.find( '.logic-rule-single-then-row:last-child' ).append( __('And ','qsm-logic'));
					} else {
						$logic_rule.find( '.logic-rule-single-then-row:last-child' ).append( __('Then','qsm-logic'));
					}
				$logic_rule.find( '.logic-rule-single-then-row:last-child' ).append(
					'<select class="then-condition">' +
						'<option value="Show">' + __("Show", "qsm-logic") + '</option>' +
						'<option value="Hide">' + __("Hide", "qsm-logic") + '</option>' +
						'<option value="endquiz">' + __("End quiz", "qsm-logic") + '</option>' +
						'<option value="goto">' + __("Goto Pages", "qsm-logic") + '</option>' +
					'</select>' +
					'<select class="then-question">' +
						'<option value="0">Select a question</option>' +
						QSMLogic.question_option_string +
						QSMLogic.category_option_string +
					'</select>' +
					'<select class="then-page" style="display: none;">' +
						'<option value="0">Select a Page</option>' +
						QSMLogic.question_pages +
					'</select>' +
					'</div>'
				);

				// Handle then-condition change
				$(document).on('change', '.then-condition', function() {
					QSMLogic.handleThenConditionChange($(this));
				});
				if ( 0 !== j ) {
					$logic_rule.find( '.logic-rule-single-then .logic-rule-single-then-row.' + j ).append( '<span class="dashicons dashicons-trash delete-then-row"></span>' );
				}
				$logic_rule.find( '.logic-rule-single-then .logic-rule-single-then-row.' + j + ' .then-question' ).val( thenVal.question );
				$logic_rule.find( '.logic-rule-single-then .logic-rule-single-then-row.' + j + ' .then-page' ).val( thenVal.question );
				$logic_rule.find( '.logic-rule-single-then .logic-rule-single-then-row.' + j + ' .then-condition' ).val( thenVal.condition );
				});
				$logic_rule.find( '.logic-rule-single-then' ).append(
				'<div class="logic-rule-single-then-row add-new-then-btn">' +
					'<span class="button add-new-then">'+__( 'Add additional action', 'qsm-logic' )+'</span>' +
				'</div>'
				);
				if ( val.then.length === 1 && val.then[0]['condition'] === 'endquiz') {
					$logic_rule.find('.logic-rule-single-then-row').not(':last-child').addClass('end-quiz').find('.then-question').addClass('qsm-logic-disabled');
					$logic_rule.find('.add-new-then').addClass('qsm-logic-disabled');
					$logic_rule.find('.logic-rule-single-then-row').not(':last-child').find('.then-page').hide();
				} 
				$.each($logic_rule.find('.logic-rule-single-then-row'), function (i, row) {
					var $row = $(row);
					var condition = $row.find('.then-condition').val();					
					$row.find('.qsm-tooltips-icon').remove();
					$row.removeClass('logic-rule-tooltip');
				
					if (condition === 'show' || condition === 'hide') {
						$($row).find('.then-page').hide();
						$($row).find('.then-question').show();
					} 
					 if (condition === 'goto') {
						$row.find('.then-page').show();
						$row.find('.then-question').hide();
						$row.addClass('logic-rule-tooltip');
						$row.append(
							'<span class="dashicons dashicons-editor-help qsm-tooltips-icon">' +
							  '<span class="qsm-tooltips qsm-logic-goto-warning-msg">' + 
								__('Implementing backward navigation logic is not currently supported.', 'qsm-logic') + 
							  '</span>' +
							'</span>'
						);
					}
				});
				$( '#modal-wizard-logic-content' ).html( $logic_rule );
				MicroModal.show('modal-wizard-logic');
			});
			$('#modal-wizard-logic .if-question').each(function(){
				if_answer_val = $(this).siblings('.if-answer').val();
				$(this).trigger('change');
				$(this).next('.if-condition').trigger('change');
				answer_field = $(this).siblings('.if-answer');
				select = false;
				answer_field.children().each(function(){
					if($(this).text() == if_answer_val){
						$(this).attr('selected', 'selected')
						select = true;
					}
				});
				if(!select){
					answer_field.val( decodeEntities( if_answer_val ) );
				}
			})
			QSMAdmin.clearAlerts();
		},
		save : function() {
			QSMAdmin.displayAlert( __( 'Upgrading database...', 'qsm-logic' ), 'info' );
			var logic_parameters = [];
				parameter = {
					id : '',
					status : '',
				}
				logic_parameters.push( parameter );

			var data = {
				action: 'qsm_save_logic',
				logic_rules: qsmLogicObject.logicRules,
				quiz_id : qsmLogicObject.quizID,
				parameter : logic_parameters,
			};

			jQuery.post( qsmLogicObject.ajaxurl, data, function( response ) {
				QSMLogic.saved( JSON.parse( response ) );
			});

		},
		saved : function( response ) {
			if ( response.status ) {
				QSMAdmin.displayAlert( __( 'Success! Your rules have been saved!', 'qsm-logic' ), 'info' );
				location.reload();
			} else {

				QSMAdmin.displayAlert( __( 'Error! There was an error encountered when saving your rules. Please try again.', 'qsm-logic' ), 'error' );
			}
		},
		saveNew : function($newLogic) {
			validated = QSMLogic.validate();
			if(! validated){
				return;
			}
			QSMAdmin.displayAlert( __( 'Saving logic rules...', 'qsm-logic' ), 'info' );
			$( '.logic-rule-message' ).empty();
			var logic_rule_array = [];
			var logic_parameters = [];
			var logic_rule_single = {};
				logic_rule_single = {
				if : [],
				then : []
				};
				parameter = {
					id : $newLogic.data('id'),
					status : $newLogic.data('status'),
				}
				$newLogic.find( '.logic-rule-single-if-row' ).each( function() {
					// if(! $(this).is(':last-child')){
						answer_val = $(this).children( '.if-answer' ).val();
						if('is empty' ===  $(this).children( '.if-condition' ).val() || 'is not empty' ===  $(this).children( '.if-condition' ).val() ){
							answer_val = '';
						}
						logic_rule_single.if.push({
							question : $(this).children( '.if-question' ).val(),
							condition : $(this).children( '.if-condition' ).val(),
							answer : answer_val,
							logic_level : $(this).data('logic-level'),
						});
					// }
				});
				$newLogic.find( '.logic-rule-single-then-row' ).each( function() {
					if(! $(this).is(':last-child') && $(this).not('.end-quiz')){
						if($(this).children( '.then-condition' ).val() === 'goto'){
							logic_rule_single.then.push({
								question : $(this).children( '.then-page' ).val(),
								condition : $(this).children( '.then-condition' ).val(),
							});
						} else {
							logic_rule_single.then.push({
								question : $(this).children( '.then-question' ).val(),
								condition : $(this).children( '.then-condition' ).val(),
							});
						}
					} else if(! $(this).is(':last-child') && $(this).hasClass('end-quiz')){
						logic_rule_single.then.push({
							question : null,
							condition : $(this).children( '.then-condition' ).val(),
						});
					}
				});
				logic_rule_array.push( logic_rule_single );
				logic_parameters.push( parameter );

			var data = {
				action: 'qsm_save_logic',
				logic_rules: logic_rule_array,
				quiz_id : qsmLogicObject.quizID,
				parameter : logic_parameters,
			};
			jQuery.post( qsmLogicObject.ajaxurl, data, function( response ) {
				QSMLogic.savedNew( JSON.parse( response ) );
			});
		},
		savedNew : function( response ) {
			if(response.logicRulesObject === undefined){
				location.reload();
			} else {
				QSMLogic.load(response.logicRulesObject);
				if ( response.status ) {
					QSMAdmin.displayAlert( __( 'Success! Your rules have been saved!', 'qsm-logic' ), 'info' );
				} else {
					QSMAdmin.displayAlert( __( 'Error! There was an error encountered when saving your rules. Please try again.', 'qsm-logic' ), 'error' );
				}
			}

			MicroModal.close('modal-wizard-logic');

		},
		validate : function(){
			valid = true;
			$('#modal-wizard-logic select.if-question').each(function(){
				if($(this).val() == 0){
					$(this).css("border-color", "red").focus();
					valid = false;
					return false;
				}
			});
			$('#modal-wizard-logic select.then-question:visible').each(function(){
				let condition = $(this).parent().find('.then-condition').val().trim();
				if($(this).val() == 0 && condition != 'endquiz'){
					$(this).css("border-color", "red").focus();
					valid = false;
					return false;
				} 
			});
			$('#modal-wizard-logic select.then-page:visible').each(function(){
				let condition = $(this).parent().find('.then-condition').val().trim();
				if($(this).val() == 0 && condition != 'endquiz'){
					$(this).css("border-color", "red").focus();
					valid = false;
					return false;
				} 
			});
			return valid;
		},
		delete_selected : function(){
			ids_array = [];
			$('.check_logic:checked').each(function(){
				ids_array.push($(this).val());
			});
			total_ids = ids_array.length
			if(total_ids > 0){
				if(confirm(total_ids+__( ' logic rules will be deleted from database. Are you sure?', 'qsm-logic'))){
					QSMLogic.deleteBulk(ids_array);
				}

			}
			$('#check_all').removeAttr('checked');
		},
		deleteBulk : function(ids){
			status = true;
				var data = {
					action: 'qsm_delete_logic_bulk',
					ids : ids,
				};

				jQuery.post( qsmLogicObject.ajaxurl, data, function( response ) {
					response = JSON.parse( response );
					status = response.status;
				});

			if(status){
				$('.check_logic:checked').each(function(){
					$(this).parent().parent().remove();
				});
				if($('.logic-rules .logic-rule-single').length == 0){
					QSMLogic.choose_display('new');
				}
				QSMAdmin.displayAlert( __( 'Success! Your rules have been deleted!', 'qsm-logic' ), 'info' );
			} else {
				QSMAdmin.displayAlert( __( 'Error! Unable to delete rule, Try again later!', 'qsm-logic' ), 'error' );
			}
		},
		choose_display: function(display_var){
			switch (display_var) {
				case 'upgrade':
					$('.upgrade-logic-rules').fadeIn();
					$('.logic-container').hide();
					$('.no-logic-container').hide();
					break;
				case 'new':
					$('.no-logic-container').fadeIn();
					$('.upgrade-logic-rules').hide();
					$('.logic-container').hide();
					break;
				case 'table':
					$('.logic-container').fadeIn();
					$('.upgrade-logic-rules').hide();
					$('.no-logic-container').hide();
					break;
				default:
					$('.upgrade-logic-rules').hide();
					$('.logic-container').hide();
					$('.no-logic-container').hide();
					break;
			}
		},
		add_new_group: function ( thisobj ) {
			var group_parent = thisobj.parent(".new-group-row");
			group_parent.find('img').remove();
			group_parent.find('p').remove();
			group_parent.css({"border": "none", "padding": "0"});
			let dc_logic_level = group_parent.prev().children(".logic-rule-single-if-row").data('logic-level');
			group_body = '<div class="logic-rule-single-if">' +
					'<div class="new-group-parent">'+
					'<span class="or-before-after">'+__( 'OR', 'qsm-logic')+'</span>'+
					'</div>'+
					'<div class="logic-rule-single-if-row" data-logic-level="'+(dc_logic_level+1)+'">'+
					'<span class="dashicons dashicons-remove delete-if-row"></span>' +
						'<select class="if-question">' +
						'<option value="0">Select a question</option>' +
						QSMLogic.question_option_string +
						'</select>' +
						'<select class="if-condition">' +
						'<option>is equal to</option>' +
						'<option>is not equal to</option>' +
						'<option>is greater than</option>' +
						'<option>is less than</option>' +
						'<option>is empty</option>' +
						'<option>is not empty</option>' +
						'</select>' +
						'<select class="if-answer">' +
						'<option value="0">'+__( 'Select an answer','qsm-logic' )+'</option>' +
						'</select>' +
						'<span class="custom-add-ele add-new-if dashicons dashicons-insert "></span>' +
					'</div>' +
					'</div>';
			thisobj.parent(".new-group-row").before(group_body);

			// thisobj.insertBefore("<div>mydiv</div>")

		}
	};
	$(function() {
		QSMLogic.questionCollection = Backbone.Collection.extend({
			url: wpApiSettings.root + 'quiz-survey-master/v1/questions',
			model: QSMLogic.question
		});
		QSMLogic.questions = new QSMLogic.questionCollection();
		// logic-container
		if (document.querySelector('.logic-container')) {
			QSMLogic.loadQuestions();
		}
		$( '.add-rule' ).on( 'click', function() {
			QSMLogic.add_rule();
		});
		$( '.mlw_quiz_options' ).on( 'click', '.save-rules', function() {
			QSMLogic.save();
		});
		$( '.save-new-rule' ).on( 'click', function() {
			QSMLogic.saveNew($('#modal-wizard-logic').find('.logic-rule-single'));
		});
		$('#modal-wizard-logic').on('change', '.then-condition', function() {
			if ( $(this).val() == 'endquiz' ) {
				$(this).parent().addClass('end-quiz');
				$('#modal-wizard-logic').find('.logic-rule-single-then-row').not('.end-quiz').not('.add-new-then-btn').remove();
				$('#modal-wizard-logic').find('.add-new-then').addClass('qsm-logic-disabled');
				$(this).parent().find('.delete-then-row').remove();
				$(this).parent().find('.then-question').addClass('qsm-logic-disabled');
				let eleEndQuiz = $('#modal-wizard-logic').find('.logic-rule-single-then-row.end-quiz');
				let countEndQuiz = $('#modal-wizard-logic').find('.logic-rule-single-then-row.end-quiz').length;
				countEndQuiz--;
				eleEndQuiz.not(':eq('+ countEndQuiz +')').remove();
				qsmRemoveTextNodes($(this).parent());
			} else {
				$(this).parent().removeClass('end-quiz');
				$(this).parent().find('.then-question').removeClass('qsm-logic-disabled');
				$('#modal-wizard-logic').find('.add-new-then').removeClass('qsm-logic-disabled');
			}
		});
		$( '#modal-wizard-logic' ).on( 'click', '.add-new-if', function() {
			var $ifElement = $( this ).parent().parent();
			$(this).text("and");
			$(this).removeClass("dashicons dashicons-insert add-new-if");

			QSMLogic.addCondition( $ifElement );
			$(this).parents('.logic-rule-single').data("status", "updated");
		});
		$( '#modal-wizard-logic' ).on( 'click', '.add-new-then', function() {
			var $thenElement = $( this ).parent().parent();
			$( this ).parent().remove();
			QSMLogic.addTrigger( $thenElement );
			$(this).parents('.logic-rule-single').data("status", "updated");
		});
		$( '#modal-wizard-logic' ).on( 'click', '.delete-if-row', function() {
			var $deleteElement = $( this );
			QSMLogic.deleteCondition( $deleteElement );
			$(this).parents('.logic-rule-single').data("status", "updated");
		});
		$( '#modal-wizard-logic' ).on( 'click', '.delete-then-row', function() {
			var $deleteElement = $( this );
			QSMLogic.deleteTrigger( $deleteElement );
			$(this).parents('.logic-rule-single').data("status", "updated");
		});
		$( '#modal-wizard-logic' ).on( 'change', '.if-question', function() {
			QSMLogic.changeQuestion( $( this ).val(), $( this ) );
			$(this).parents('.logic-rule-single').data("status", "updated");
		});
		$( '#modal-wizard-logic' ).on( 'change', '.if-condition', function() {
			if('is empty' ===  $( this ).val() || 'is not empty' ===  $( this ).val()){
				$(this).next().hide();
			}else{
				$(this).next().show();
			}
		});
		$( '#modal-wizard-logic' ).on( 'change', '.then-question', function() {
			$(this).removeAttr("style");
		});
		$( '.logic-rules' ).on( 'click', '.edit-rule', function() {
			edit_element = $(this).parents('.logic-rule-single');
			QSMLogic.edit_rule(edit_element.data('id'));
		});
		$( '.logic-rules' ).on( 'click', '.delete-rule', function() {
			if(confirm( __( 'Are you sure?', 'qsm-logic' ))){
				var $deleteElement = $( this );
				QSMLogic.deleteRule( $deleteElement );
			}
		});
		$('.logic-table').on('mouseover', '.logic-rule-single', function(){
			$(this).find('.action-label').show();
		});
		$('.logic-table').on('mouseout', '.logic-rule-single', function(){
			$(this).find('.action-label').hide();
		});
		$( '.logic-table' ).on( 'click', '#check_all', function() {
			if(this.checked === true){
				$('.check_logic:visible').each(function(){
					this.checked = true;
				})
			} else {
				$('.check_logic:visible').each(function(){
					$(this).removeAttr('checked');
				})
			}
		});
		$( '.delete-all-rules' ).on( 'click', function() {
			QSMLogic.delete_selected();
		});
		$( '.mlw_quiz_options' ).on( 'keyup', '.search-logic', function() {
			search_term = $.trim( $(this).val());
			if(search_term == ''){
				$('.logic-rules .logic-rule-single').each(function(){
					$(this).show()
				});
			} else {
				search_term = new RegExp(search_term, 'i');
				$('.logic-rules .logic-rule-single').each(function(){
					search_string = $(this).text();
					search_string = search_string.replace('Edit |  Delete', ' ');
					result = search_string.search(search_term);
					if(result > -1){
						$(this).show();
					} else {
						$(this).hide();
					}
				});

			}
		});
		$( '#modal-wizard-logic' ).on( 'click', '.add-new-group-button', function() {
			QSMLogic.add_new_group($(this));
		});
		$( '#modal-wizard-logic' ).on( 'click', '.new-group-parent span:not(:first)', function() {
			$(this).parents('.logic-rule-single-if').remove();
		});
	});
	edit_element = {};
	function decodeEntities (str ) {
		if(str && typeof str === 'string') {
			str = str.replace("\\'", "'");
			str = str.replace('\\"', '"');
		}
		return str;
	};
	function encodeEntities (str ) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	};
	function qsmRemoveTextNodes(element) {
		element.contents().each(function() {
			if (this.nodeType === Node.TEXT_NODE && $(this).text().trim() == 'And') {
				$(this).replaceWith('Then');
			} else {
				qsmRemoveTextNodes($(this));
			}
		});
	}
}(jQuery));