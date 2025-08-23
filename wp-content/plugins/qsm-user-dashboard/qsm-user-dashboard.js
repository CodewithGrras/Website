var USER_DASHBOARD;

USER_DASHBOARD = {
  q_counter: Backbone.Model.extend({
    defaults: {
      answers: []
    }
  }),
  changes: function (data, question_id) {

    answers = myModel.get('answers');
    answers.push({
      'q_id': question_id,
      'correct': data.success == 'correct' ? 1 : 0,
      'incorrect': data.success == 'correct' ? 0 : 1,
      'unanswered': 0
    });

    myModel.set({ 'answers': USER_DASHBOARD.filter_question(myModel.get('answers')) });
    
    update_answers = myModel.get('answers');
    let correct = 0;
    let incorrect = 0;
    let unanswered = 0;

    update_answers.forEach(function(obj){
      if(obj.correct == 1) {
        correct++;
      }else if(obj.incorrect == 1){
        incorrect++;
      }else if(obj.unanswered == 1){
        unanswered++;
      }
    });
    
    if( jQuery(".qsm-question-container").length ) {
      jQuery(".qsm-correct-count-text").text(parseInt(correct));
      jQuery(".qsm-incorrect-count-text").text(parseInt(incorrect));
      jQuery(".qsm-unanswer-count-text").text(parseInt(unanswered));
    }

  },
  filter_question: function(arr) {
    var result = {};
    arr.forEach(function(obj) {
      if (obj.q_id) {
        result[obj.q_id] = obj;
      }
    });
    return Object.values(result);
  },
  unanswered: function (q_ids) {
    let qIds = [];
    let unanswered = 0;
    let oldanswers = myModel.get('answers');
    
    // get old question ids
    jQuery.each(oldanswers, function(index, obj) {
      if (obj.q_id) {
        qIds.push(obj.q_id);
      }
    });

    // short new unanswered elements
    let unanswered_array = jQuery.grep(q_ids, function(element) {
      return jQuery.inArray(element, qIds) === -1;
    });

    // set default
    jQuery.each(unanswered_array, function(i, obj){
      oldanswers.push({
        'q_id': obj,
        'correct': 0,
        'incorrect': 0,
        'unanswered': 1
      });
    });
    
    oldanswers.forEach(function(obj){
      if(obj.unanswered == 1) {
        unanswered++;
      }
    });
    myModel.set({ 'answers': oldanswers });

    if( jQuery(".qsm-question-container").length ) {
      jQuery(".qsm-unanswer-count-text").text(parseInt(unanswered));
    }

  }
};
var myModel = new USER_DASHBOARD.q_counter({});

jQuery(document).on('qsm_next_button_click_before', function(event, data){
  let q_ids = [];
  jQuery(".qsm-question-wrapper .mlw_qmn_question:visible").each(function () {
    var questionTypes = [0, 4, 1, 10, 2, 7, 3, 5, 14];
    var divClass = jQuery(this).parents('.qsm-question-wrapper').attr('class');
    for (var i = 0; i < questionTypes.length; i++) {
      var questionTypeClass = "question-type-" + questionTypes[i];
      var regex = new RegExp("\\b" + questionTypeClass + "\\b");
      if (regex.test(divClass)) {
        q_ids.push(jQuery(this).parents('.qsm-question-wrapper').attr('class').match(/question-section-id-(\d+)/)[1]);
        break;
      }
    }
  })
  USER_DASHBOARD.unanswered(q_ids);
});

jQuery(document).on('qsm_after_select_answer', function(event, quizID, question_id, value, $this, answer_type, index = null){
  if (typeof inline_dashboard !== 'undefined' && inline_dashboard !== null && inline_dashboard.inline_dashboard != 0) {
    var data = qsm_question_quick_result_js(question_id, value, answer_type, qmn_quiz_data[quizID].enable_quick_correct_answer_info, quizID);
    USER_DASHBOARD.changes(data, question_id.replace(/\D/g, ""));
  }
});

jQuery(document).on('qsm_auto_next_button_click_after', function(event, data){
  qsm_display_user_dashboard(data);
});

jQuery(document).on('qsm_auto_previous_button_click_after', function(event, data){
  qsm_display_user_dashboard(data);
});

jQuery(document).on('qsm_go_to_page_after', function(event, quizID, pageNo){
  if(pageNo != 1){
    qsm_display_user_dashboard(jQuery('#quizForm' + quizID));
  }
});

function qsm_display_user_dashboard(data) {
  if(jQuery(data).closest('.qmn_quiz_container').find('.quiz_begin').is(':visible')){
    jQuery(".qsm-question-container").hide();
  }else{
    jQuery(".qsm-question-container").show();
  }
}

jQuery(document).ready(function () {
  if(typeof quizType !== 'undefined' && quizType == 'default') {
    jQuery(".qsm-unanswer-count").hide();
    jQuery(".qsm-question-container").show();
  }
  jQuery('.dashboard-options').sortable({
    opacity: 70,
    cursor: 'grabbing',
    handle: 'img'
  });

  jQuery('.dashboard-options').on('click', '.settings-field', function (event) {
    event.preventDefault();
    var parentField = jQuery(this).parents('.dashboard-options-field');
    var target = parentField.find('.dashboard-options-field-settings');
    
    if (parentField.hasClass('active')) {
        jQuery('.dashboard-options-field-settings').not(target).hide();
        target.toggle();
    }
  });

  jQuery(document).on('click', '#shortcode-btn', function (event) {
    event.preventDefault();
  });

  jQuery('.dashboard-options-field').each(function() {
    if (jQuery(this).find('input[type="checkbox"]').is(':checked')) {
        jQuery(this).addClass('active');
    } else {
      jQuery(this).find('input[type="text"]').attr('disabled', true);
    }
  });

  jQuery(document).on('change', '.dashboard-options-switch input[type="checkbox"]', function (){
    if ( jQuery(this).is(':checked') ) {
      jQuery(this).parents('.dashboard-options-field').find('input[type="text"]').attr('disabled', false);
      jQuery(this).parents('.dashboard-options-field').addClass('active');
    } else {
      jQuery(this).parents('.dashboard-options-field').find('input[type="text"]').attr('disabled', true);
      jQuery(this).parents('.dashboard-options-field').removeClass('active');
    }
  });

  jQuery(document).on('click', '.qsm-user-dashboard-shortcode-main .qsm-user-dashboard-shortcode-info', function () {
    var shortcodeContainer = jQuery(this).parent('.qsm-user-dashboard-shortcode-main');
    var shortcode = shortcodeContainer.find('.qsm-user-dashboard-shortcode').html();

    shortcodeContainer.find('.qsm-user-dashboard-copy-msg').hide();
    shortcodeContainer.find('.qsm-user-dashboard-copy-success').fadeIn();

    qsmDashboardcopyToClipboard(shortcode);

    // Reverse the display condition after 5 seconds
    setTimeout(function () {
        shortcodeContainer.find('.qsm-user-dashboard-copy-success').hide();
        shortcodeContainer.find('.qsm-user-dashboard-copy-msg').fadeIn();
    }, 3000);
  });
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
				action: 'qsm_user_dashboard_validate_license',
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
  jQuery( '.qsm-license-form-parent' ).on( 'click', '.qsm_user_dashboard_validate_button', function ( event ) {
    event.preventDefault();
    var license_message = jQuery('.qsm_user_dashboard_validate_message');
    jQuery("#qsm-license_message").show();
    if( jQuery('.qsm_user_dashboard_validate_input').val() != "") {
      license_message.html(qsm_user_dashboard_obj.please_wait);
      var data = {
        action: 'qsm_user_dashboard_validate_license',
        input: jQuery('.qsm_user_dashboard_validate_input').val(),
      };
      jQuery.post( ajaxurl, data, function ( response ) {
        response = jQuery.parseJSON(response);
        license_message.html(response.message);
        if(response.validate == 1 || response.validate == 2) {
          response.validate == 1 ? jQuery("#qsm-license_message").css({'color': '#00a32a'}) : "";
          setTimeout(function() {
            location.reload();
          }, 2000);
        } else {
          license_message.html(qsm_user_dashboard_obj.invalid);
        }
      });
    }else{
      license_message.html(qsm_user_dashboard_obj.license_msg);
      jQuery('.qsm_user_dashboard_validate_input').focus();
    }
  });
  if (jQuery("#quiz_inline_results_count").length > 0) {
    function enableDisableResult() {
      if (jQuery("#quiz_inline_results_count").prop('checked')) {
        jQuery('.inline-result-overlay').removeClass('disabled-td');
      } else {
        jQuery('.inline-result-overlay').addClass('disabled-td');
      }
    }
    enableDisableResult();
    jQuery("#quiz_inline_results_count").on("change", function() {
      enableDisableResult();
    });
  } 
});
function qsmDashboardcopyToClipboard(text) {
  var textarea = document.createElement('textarea');
  textarea.value = text;
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand('copy');
  document.body.removeChild(textarea);
}
jQuery(document).ready(function ($) {
  $('.dashboard-generate-shortcode-button').on('click', function () {
      var inputField = $(this).closest('.dashboard-options-field').find('.qsm-dashboard-shortcode-print');
      inputField.prop('disabled', false).select(); 
      document.execCommand('copy'); 
      inputField.prop('disabled', true); 
  });

  $('.settings-field').on('click', function (e) {
      e.preventDefault();
      var target = $(this).closest('.dashboard-options-field').find('.dashboard-options-field-settings');
      $('.dashboard-options-field-settings').not(target).slideUp(); 
      target.stop(true, true).slideToggle(); 
  });

  $(document).on('click', function (e) {
      if (!$(e.target).closest('.dashboard-options-field').length) {
          $('.dashboard-options-field-settings').slideUp();
      }
  });

  $('.qsm-save-quizzes').on('click', function (e) {
      e.preventDefault();
      var selectedQuizIDs = $('#quizzes option:selected').map(function () { return $(this).val(); }).get();
      $('.qsm-dashboard-shortcode-print').val('[user_dashboard' + (selectedQuizIDs.length ? ' quiz_id="' + selectedQuizIDs.join(', ') + '"' : '') + ']');
  });
});