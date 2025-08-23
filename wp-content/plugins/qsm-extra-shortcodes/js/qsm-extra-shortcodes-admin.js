/*qsm_copy_shortcode function() is used to copy the  respective shortcode*/
/*'selector' argument  is the id of the input field */
var QSM_EXTRA_SHORTCODE;

function qsm_copy_shortcode(element, doCopy=0) {
  let name = jQuery(element).data('name');
  let params = jQuery(element).data('params').split(',');
  let shortcode = '[' + name;
  let isEnclosingShortcode = name === 'qsm_calc'; // Add more names if needed
  if ( name == 'qsm_assessment_compare' ) {
    let v1 = jQuery(element).parents('.extra-shortcode-options-field').find('#value1').val();
    let v2 = jQuery(element).parents('.extra-shortcode-options-field').find('#value2').val();
    let l1 = jQuery(element).parents('.extra-shortcode-options-field').find('#label1').val();
    let l2 = jQuery(element).parents('.extra-shortcode-options-field').find('#label2').val();
    let color = jQuery(element).parents('.extra-shortcode-options-field').find('#shortcode_color').val();
    shortcode += ' value1=' + v1 + ' value2=' + v2 + ' label1=' + l1 + ' label2=' + l2 + ' color=' + color;
  }
  params.forEach(param => {
    if ( param.trim() == 'quiz_id' || param.trim() == 'mlw_quiz' ) {
      if(param.trim() == 'quiz_id') {
        shortcode += ' quiz_id=' + jQuery(element).parents('.extra-shortcode-options-field').find('.qsm_quiz_param').val();
      } else if(param.trim() == 'mlw_quiz') {
        shortcode += ' mlw_quiz=' + jQuery(element).parents('.extra-shortcode-options-field').find('.qsm_quiz_param').val();
      }
    }
    if ( param.trim() == 'scoreby' ) {
      shortcode += ' scoreby=' + jQuery(element).parents('.extra-shortcode-options-field').find('.quiz-score-by').val();
    }
    if ( param.trim() == 'score' ) {
      shortcode += ' score=' + jQuery(element).parents('.extra-shortcode-options-field').find('input[type="number"]').val();
    }
    if ( param.trim() == 'amount' ) {
      shortcode += ' amount=' + jQuery(element).parents('.extra-shortcode-options-field').find('input[type="number"]').val();
    }
    if ( param.trim() == 'decimal' ) {
      shortcode += ' decimal=' + jQuery(element).parents('.extra-shortcode-options-field').find('input[type="number"]').val();
    }
    if ( param.trim() == 'limit' ) {
      shortcode += ' limit=' + jQuery(element).parents('.extra-shortcode-options-field').find('input[type="number"]').val();
    }
    if ( param.trim() == 'button_text' ) {
      shortcode += ' button_text="' + jQuery(element).parents('.extra-shortcode-options-field').find('input[type="text"]').val() + '"';
    }
    if ( param.trim() == 'date_range' ) {
      let fromDate = jQuery(element).parents('.extra-shortcode-options-field').find('#start_date').val();
      let toDate = jQuery(element).parents('.extra-shortcode-options-field').find('#end_date').val();
      let formattedStartDate = '';
      let formattedEndDate = '';
      if (fromDate || toDate) {
        let start_date = new Date(fromDate);
        let end_date = new Date(toDate);
        
        if (!isNaN(start_date.getTime())) {
          formattedStartDate = start_date.getFullYear() + '-' + 
                                 String(start_date.getMonth() + 1).padStart(2, '0') + '-' + 
                                 String(start_date.getDate()).padStart(2, '0');
        }
        if (!isNaN(end_date.getTime())) {
          formattedEndDate = end_date.getFullYear() + '-' + 
                               String(end_date.getMonth() + 1).padStart(2, '0') + '-' + 
                               String(end_date.getDate()).padStart(2, '0');
        }
      }
      shortcode += ' date_range="' + formattedStartDate + ',' + formattedEndDate + '"';
    }
    if ( param.trim() == 'type' ) {
      shortcode += ' type=' + jQuery(element).parents('.extra-shortcode-options-field').find('#qsm_chart_type').val();
    }
    if ( param.trim() == 'value' ) {
      let labels = jQuery(element).parents('.extra-shortcode-options-field').find('#qsm_label_value').val();
      let formattedLabels = labels.map(label => '%ANSWER_LABEL_POINTS_' + label + '%');
      let result = formattedLabels.join(',');
      shortcode += ' value=' + result;
    }
    if ( param.trim() == 'label' ) {
      shortcode += ' label=' + jQuery(element).parents('.extra-shortcode-options-field').find('#custom_labels').val();
    }
  });
  shortcode += ']';
    if (isEnclosingShortcode) {
    shortcode = jQuery(element).parents('.extra-shortcode-options-field').find('.extra-shortcode-demo').val() || '';
  }
  jQuery(element).parents('.extra-shortcode-options-field').find('.extra-shortcode-demo').val(shortcode);
	if ( doCopy == 1 ) {
    var $button = jQuery(element).parents('.extra-shortcode-options-field').find('.extra-shortcode-generate-shortcode-button');
    $button.html('<span class="dashicons dashicons-yes"></span>');
    var tooltip = jQuery('<div class="tooltip">'+qsm_license_validate_obj.copytext+'</div>');
    $button.append(tooltip);
      tooltip.css({
          position: 'absolute',
          top: -38 + 'px',
          left: '-5px',
          color: '#3c434a',
          background: '#eeeeee',
          'font-weight': '500',
      });
      tooltip.fadeIn();
    setTimeout(() => {
      $button.html('<img src="'+qsm_license_validate_obj.copy_image_url+'" alt="copy.svg"/>');
    }, 3000);

    var temp = jQuery("<input>");
    jQuery("body").append(temp);
    temp.val(shortcode).select();
    document.execCommand("copy");
    temp.remove();
    var data = {
      action: 'qsm_extra_shortcode_save_shortcode',
      name: name,
      shortcode: shortcode,
    };
    jQuery.post( ajaxurl, data, function ( response ) {
      response = jQuery.parseJSON(response);
      if(response.updated == 1) {
        console.log('Shortcode saved');
      }
    });
  }
}
jQuery(function ($) {
  if( jQuery('.qsm_quiz_param').length ) {
      $('.qsm_quiz_param').multiselect({
          columns: 1,
          placeholder: 'Select quiz',
          search: true,
          selectAll: true,
          dropdownAutoWidth: false,
      });
  }
  if( jQuery('#qsm_label_value').length ) {
      $('#qsm_label_value').multiselect({
          columns: 1,
          placeholder: 'Select',
          search: true,
          selectAll: true,
          dropdownAutoWidth: false,
      });
  }
  if (typeof jQuery.fn.wpColorPicker !== 'undefined') {
    jQuery('.qsm-shortcode-color-field').wpColorPicker();
  }
  jQuery( '.qsm_extra_shortcodes_validate_parent' ).on( 'click', '.qsm_extra_shortcodes_validate_button', function ( event ) {
      event.preventDefault();
      var license_message = jQuery('.qsm_extra_shortcodes_validate_message');
      jQuery("#qsm-license_message").show();
      if( jQuery('.qsm_extra_shortcodes_validate_input').val() != "") {
        license_message.html(qsm_extra_shortcodes_obj.please_wait);
        var data = {
          action: 'qsm_extra_shortcodes_validate_license',
          input: jQuery('.qsm_extra_shortcodes_validate_input').val(),
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
            license_message.html(qsm_extra_shortcodes_obj.invalid);
          }
        });
      }else{
        license_message.html(qsm_extra_shortcodes_obj.license_msg);
        jQuery('.qsm_extra_shortcodes_validate_input').focus();
      }
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
  jQuery( '.qsm-extra-shortcodes-license-container' ).on( 'click', '#qsm-validate_btn', function ( event ) {
    event.preventDefault();
    var license_message = jQuery('#qsm-license_entry .qsm-validate-msg');
    license_message.html(qsm_license_validate_obj.hold);
    if( jQuery('.qsm-extra-shortcodes-license-container #qsm-license_entry input[name="license_key"]').val() != "") {
      var data = {
        action: 'qsm_extra_shortcodes_validate_license',
        input: jQuery('.qsm-extra-shortcodes-license-container #qsm-license_entry input[name="license_key"]').val(),
        update_status: 'yes',
      };
      jQuery.post( ajaxurl, data, function ( response ) {
        response = jQuery.parseJSON(response);
        if(response.validate == 1 || response.validate == 2) {
          setTimeout(function() {
            location.reload();
          }, 2000);
        } else {
          license_message.html(qsm_license_validate_obj.invalid);
        }
      });
    } else {
      license_message.html(qsm_license_validate_obj.empty);
      jQuery('.qsm-extra-shortcodes-license-container #qsm-license_entry input[name="license_key"]').focus();
    }
  });
  jQuery( '.extra-shortcode-options-field' ).on( 'click', '.settings-field', function ( event ) {
    event.preventDefault();
    let settings = jQuery(this).parents('.extra-shortcode-options-field').find('.extra-shortcode-options-field-settings').addClass('active');
    jQuery(document).find('.extra-shortcode-options-field-settings').not('.active').hide();
    jQuery(settings).toggle();
    jQuery(settings).removeClass('active');
  });
  jQuery(document).on('click', function(event) {
    var clickedElement = jQuery(event.target);
    if (!clickedElement.closest('.extra-shortcode-options-field-settings').length &&
        !clickedElement.closest('.settings-field').length) {
        jQuery('.extra-shortcode-options-field-settings').hide();
    }
  });
  jQuery('.qsm-extra-shortcode-table').on( 'change', 'input[type="number"], input[type="date"], .qsm_quiz_param, .quiz-score-by', function ( event ) {
    event.preventDefault();
    qsm_copy_shortcode(jQuery(this).parents('.extra-shortcode-options-field').find('.extra-shortcode-generate-shortcode-button'));
  });
  jQuery('.qsm-extra-shortcode-table').on( 'keyup', 'input[type="text"]', function ( event ) {
    event.preventDefault();
    qsm_copy_shortcode(jQuery(this).parents('.extra-shortcode-options-field').find('.extra-shortcode-generate-shortcode-button'));
  });
  jQuery('.qsm-extra-shortcode-table').on('irischange', '.qsm-shortcode-color-field', function(event, ui) {
    qsm_copy_shortcode(jQuery(this).parents('.extra-shortcode-options-field').find('.extra-shortcode-generate-shortcode-button'));
  });

  // --------------

  QSM_EXTRA_SHORTCODE = {
    onload: function(){
      QSM_EXTRA_SHORTCODE.condition_or_categor_change();
    },
    popup: function ($this){
      var result_index = $this.data('id');
      jQuery(document).find('.button-primary.qsm-extra-shortcode-insert').attr('data-id', result_index);
      MicroModal.show('qsm-extra-shortcode-modal');
      QSM_EXTRA_SHORTCODE.condition_or_categor_change();
    },
    get_shortcode: function() {
      let container = jQuery('#qsm-extra-shortcode-modal');
      let shortcode = '[qsm_conditions';
      
      // Get the selected type
      let selectedType = jQuery('.qsm-extra-shortcode-type:visible').val();
      if (selectedType) {
          shortcode += ' type="' + selectedType + '"';
      }

      // Get the condition
      let condition = jQuery('.qsm-extra-shortcode-relation:visible').val();
      shortcode += ' condition="' + condition + '"';

      var selecteConditiondValue = $('.qsm-extra-shortcode-condition-type').val();
      var shortcodeDescription = jQuery('#qsm-extra-shortcodes-description').val().trim();
      
      // Show/hide containers based on selected radio button
      if (selecteConditiondValue == 'quiz') {
          let value = container.find('input[name="qsm_extra_shortcode_condition_quiz_value"]').val();
          shortcode += ' value="' + value + '"'; 
      } else if (selecteConditiondValue == 'category') {
        let categories = [];
        let ismultiple = '';
        let selectedCondition = jQuery('.qsm-extra-shortcode-condition').val();
        jQuery('.qsm-extra-shortcode-select-category').each(function() {
            let selectedValues = jQuery(this).find('.extra-shortcode-multiple-categories').val(); // Get selected values
            let limit = jQuery(this).find('input[name="qsm_extra_shortcode_category_value"]').val(); // Get the limit value
            
            if (selectedValues && limit) {
                let categoryList = [];
                
                // For each selected value, append to the categoryList array with the format 'value:limit'
                jQuery.each(selectedValues, function(index, value) {
                    categoryList.push(value + ':' + limit);
                });

                // Push the categoryList to the categories array
                categories.push(categoryList);
            }
        });

        ismultiple = "false";
        shortcode += ' category_condition="' + selectedCondition + '"';
        shortcode += ' category="' + categories + '"';
        shortcode += ' ismultiple="' + ismultiple + '"';
      }

      shortcode += ']';
      
      shortcode += shortcodeDescription + '[/qsm_conditions]';
      return shortcode;
    },
    insert_or_copy: function ($this, shortcode) {
      console.log(shortcode)
      if($this.hasClass('qsm-extra-shortcode-insert')){
        // Action if element has 'qsm-extra-shortcode-insert' class
        var id = $this.data('id');
        var editor = tinymce.get(id);
        editor.focus();
        if (typeof qsmConvertContentToShortcode === 'function') {
          editor.selection.setContent(qsmConvertContentToShortcode(shortcode));
        } else {
          editor.selection.setContent(shortcode);
        } 
      } else {
          // Action if element does NOT have 'qsm-extra-shortcode-insert' class
          $this.html(qsm_extra_shortcodes_obj.copytext).css('font-weight', 'bold');
        setTimeout(() => {
          $this.html(qsm_extra_shortcodes_obj.copyshortcode).css('font-weight', 'initial');
        }, 2000);
        let tempInput = document.createElement('input');
        tempInput.value = shortcode;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
      }
      MicroModal.close('qsm-extra-shortcode-modal');
    },
    condition_or_categor_change: function(){
      // 
      var selectedValue = $('.qsm-extra-shortcode-condition-type').val();
      var selectedType = jQuery('.qsm-extra-shortcode-type').val();
      if (selectedValue === 'quiz') {
          $('.qsm-extra-shortcode-quiz-section-inside-bottom').show();
          $('.qsm-extra-shortcode-category-section, .qsm-extra-shortcode-result-container .qsm-extra-shortcode-logical').hide();
      } else if (selectedValue === 'category') {
          $('.qsm-extra-shortcode-quiz-section-inside-bottom').hide();
          $('.qsm-extra-shortcode-category-section, .qsm-extra-shortcode-result-container .qsm-extra-shortcode-logical').show();
          $('.qsm-extra-shortcode-select-category-multiple').show();
      }
      if(jQuery('.qsm-extra-shortcode-type:visible')) {
        selectedType = jQuery('.qsm-extra-shortcode-type:visible').val()
      }
      var inputs = document.querySelectorAll('input[type="text"].qsm-small-text');
      let shortcodeRelation = jQuery('.qsm-extra-shortcode-relation:visible').val();
      inputs.forEach(function(input) {
          var format = shortcodeRelation === 'between' ? ' (e.g., 5-10)' : ' (e.g., 10)';
          if (selectedType == 'points') {
              input.placeholder = qsm_extra_shortcodes_obj.point_placeholder + format;
          } else if (selectedType == 'score') {
              input.placeholder = qsm_extra_shortcodes_obj.score_placeholder + format;
          }
      });
    }
  };

  jQuery(document).on('qsm_after_add_result_block', function(event, conditions, page, redirect, total) {
    var $matchingElement = $(`#results-page-${total}`);
    var $button = $matchingElement.parents('.results-page-show').find('.qsm-extra-shortcode-resultpage-button');
    $button.attr('data-id', total - 1);
  });

  jQuery(document).on('qsm_after_add_email_block', function(event, conditions, to, subject, content, replyTo, total) {
    var $matchingElement = $(`#email-template-${total}`);
    var $button = $matchingElement.parents('.email-show').find('.qsm-extra-shortcode-emailpage-button');
    $button.attr('data-id', total - 1);
  });

  jQuery(document).on('click', '.qsm-extra-shortcode-resultpage-button, .qsm-extra-shortcode-emailpage-button', function(event) {
    event.preventDefault();
    QSM_EXTRA_SHORTCODE.popup(jQuery(this));
  });

  if( jQuery('.extra-shortcode-multiple-categories').length ) {
    $('.extra-shortcode-multiple-categories').multiselect({
        columns: 1,
        placeholder: qsm_extra_shortcodes_obj.select,
        search: true,
        selectAll: true,
        dropdownAutoWidth: false,
    });
  }

  jQuery(document).on('click', '.qsm-extra-shortcode-add-more-category', function() {
    let container = jQuery(this).closest('.qsm-extra-shortcode-select-category-container');

    // Generate a unique ID for the new select element
    let uniqueId = 'select-' + new Date().getTime(); // Use timestamp to ensure uniqueness

    // Create a new select element with a unique ID
    let newSelectElement = jQuery('<select></select>')
        .attr('id', uniqueId) // Set the unique ID
        .attr('name', 'extra_shortcode_multiple_quiz[]')
        .attr('multiple', 'multiple')
        .addClass('extra-shortcode-multiple-categories');

    // Populate the select options based on the categories list
    jQuery.each(qsm_extra_shortcodes_obj.categories.list, function(value, label) {
        newSelectElement.append(jQuery('<option></option>').attr('value', label).text(label));
    });

    // Set the select's value to blank to ensure no option is selected by default
    newSelectElement.val('');

    // Create a new input field with the desired name attribute
    let newInputElement = jQuery('<input>')
        .attr('type', 'text')
        .attr('name', 'qsm_extra_shortcode_category_value')
        .addClass('small-text qsm-small-text')
        .val('');

    // Create the delete button element
    let deleteButton = jQuery('<a></a>')
        .attr('href', 'javascript:void(0)')
        .addClass('delete-category-button')
        .html('<img class="qsm-common-svg-image-class" src="'+qsm_extra_shortcodes_obj.remove_image_url+'" alt="trash-light.svg"/>');

    // Create a new div or container for the select, input field, and delete button
    let newDiv = jQuery('<div></div>').addClass('qsm-extra-shortcode-select-category');
    newDiv.append(newSelectElement).append(newInputElement).append(deleteButton); // Add the elements to the div

    // Insert the new div into the DOM
    newDiv.insertBefore(container.find('.qsm-extra-shortcode-add-more-link'));

    // Initialize the multiselect plugin on the new select element
    newSelectElement.multiselect({
        columns: 1,
        placeholder: qsm_extra_shortcodes_obj.select,
        search: true,
        selectAll: true,
        dropdownAutoWidth: false,
    });

    // If any additional function needs to be called, do it after initialization
    QSM_EXTRA_SHORTCODE.condition_or_categor_change();
  });


  // Attach change event handler to radio buttons
  $('.qsm-extra-shortcode-type, .qsm-extra-shortcode-condition-type, .qsm-extra-shortcode-relation').change(QSM_EXTRA_SHORTCODE.condition_or_categor_change);

  // Copy shortcode
  jQuery(document).on('click', '.button.qsm-extra-shortcode-copy, .button-primary.qsm-extra-shortcode-insert', function(e) {
    e.preventDefault();
    let shortcode = QSM_EXTRA_SHORTCODE.get_shortcode();
    QSM_EXTRA_SHORTCODE.insert_or_copy(jQuery(this), shortcode);
  });

  jQuery(document).on('click', '.delete-category-button', function() {
    if((jQuery('div.qsm-extra-shortcode-select-category').length) > 1){
        jQuery(this).parent('.qsm-extra-shortcode-select-category').remove();
    }
    let nextDiv = jQuery('.qsm-extra-shortcode-select-category-container').next('div');
    if(nextDiv.next('div.qsm-extra-shortcode-add-more-link').length === 0 ) {
        jQuery(".qsm-extra-shortcode-add-more-link").show();
    }
  });
  
  // Call the function initially on page load
  QSM_EXTRA_SHORTCODE.onload();

});