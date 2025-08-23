var QSM_Admin_Advance_Timer;
jQuery(document).ready(function(){

    jQuery('.show_legacy_timers').change(function(e){
      if (jQuery(this).is(':checked')) {
        jQuery('.legace_timer_options').show();
      }else{
        jQuery('.legace_timer_options').hide();
      }
    });

    jQuery('.orher_timer_options').on('click', '.other_timers', function (event) {
      jQuery('.orher_timer_options .other_timers').removeClass('active');
      jQuery(this).addClass('active');
      var relatedInputClass = jQuery(this).data('class');
      if('v_line_timer' == relatedInputClass || 'box_timer' == relatedInputClass || 'oval_timer' == relatedInputClass) {
        jQuery('.advance-background-color').show();
      }else{
        jQuery('.advance-background-color').hide();
      }
      var timerInput = jQuery(".orher_timer_options input[name='qsm_timer_design']." + relatedInputClass);
      timerInput.prop("checked", true);
    });

    jQuery('#qsm-refresh-timer-on-reload, #qsm-show-stop-timer').on('change', function (event) {
      if(jQuery('#qsm-refresh-timer-on-reload:checked').is(':checked') || jQuery('#qsm-show-stop-timer:checked').is(':checked')) {
        jQuery('.qsm-timer-continue-after-close').addClass('qsm-disabled-td');
        jQuery('#qsm-timer-continues-after-closing').prop("checked", false);
      }else{
        jQuery('.qsm-timer-continue-after-close').removeClass('qsm-disabled-td');
      }
    });

    jQuery('#qsm-timer-continues-after-closing').on('change', function (event) {
      if( jQuery(this).is(':checked') ) {
        jQuery('.qsm-refresh-timer-on-reload-section').addClass('qsm-disabled-td');
        jQuery('#qsm-refresh-timer-on-reload').prop("checked", false);
      }else{
        jQuery('.qsm-refresh-timer-on-reload-section').removeClass('qsm-disabled-td');
      }
    });

    jQuery('#qsm-show-warning').on('click', function (event) {
      if(jQuery(this).is(':checked')) {
        jQuery('.qsm-custome-timer-warning').show();
      }else{
        jQuery('.qsm-custome-timer-warning').hide();
      }
    });

    if (jQuery('.advance-timer-settings').length) {
      jQuery('.color-picker').wpColorPicker();
      advacetimer_show_legacy_timers();
    }


    function qsm_advance_timer_extends_object_before( targetF, originalF, parent ) {
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


    QSM_Admin_Advance_Timer = {
      openEditPagePopup: function (pageID) {
        var page = QSMQuestion.qpages.get(pageID);

        var adv_seconds = page.get('pagetimer_second') != undefined ? parseInt(page.get('pagetimer_second')) : 0;
        var adv_minutes = page.get('pagetimer') != undefined ? parseFloat(page.get('pagetimer')) : 0;
        var adv_minutesecond = adv_minutes * 60;
        var totalSeconds = adv_minutesecond + adv_seconds;
        var update_minutes = Math.floor(totalSeconds / 60);
        var update_seconds = totalSeconds % 60;
        page.set('pagetimer', Math.round(update_minutes));
        page.set('pagetimer_second', Math.round(update_seconds));

        var adv_warning_seconds = page.get('pagetimer_warning_second') != undefined ? parseInt(page.get('pagetimer_warning_second')) : 0;
        var adv_warning_minutes = page.get('pagetimer_warning') != undefined ? parseFloat(page.get('pagetimer_warning')) : 0;
        var adv_warning_minutesecond = adv_warning_minutes * 60;
        var totalWarningSeconds = adv_warning_minutesecond + adv_warning_seconds;
        var update_warning_minutes = Math.floor(totalWarningSeconds / 60);
        var update_warning_seconds = totalWarningSeconds % 60;
        page.set('pagetimer_warning', Math.round(update_warning_minutes));
        page.set('pagetimer_warning_second', Math.round(update_warning_seconds));

        if(page.get('warning_checkbox') == undefined && adv_warning_minutes > 0) {
          page.set('warning_checkbox', '1');
        }

      }
    };

    if (jQuery('.question-controls').length) {
      qsm_advance_timer_extends_object_before( QSM_Admin_Advance_Timer.openEditPagePopup, QSMQuestion.openEditPagePopup, QSMQuestion );
    }
    jQuery('#timer_limit_seconds-input').change(function(){
        var seconds = parseInt(jQuery(this).val());
        var minutes = parseInt(jQuery('#timer_limit-input').val());
        var hours = parseInt(jQuery('#timer_limit_hour-input').val());
        
        if (seconds >= 60) {
            minutes += Math.floor(seconds / 60);
            seconds = seconds % 60;
        }
        if (minutes >= 60) {
            hours += Math.floor(minutes / 60);
            minutes = minutes % 60;
        }
        
        jQuery('#timer_limit_seconds-input').val(seconds);
        jQuery('#timer_limit-input').val(minutes);
        jQuery('#timer_limit_hour-input').val(hours);
    });
    
    jQuery('#timer_limit-input').change(function(){
        var minutes = parseInt(jQuery(this).val());
        var hours = parseInt(jQuery('#timer_limit_hour-input').val());
        
        if (minutes >= 60) {
            hours += Math.floor(minutes / 60);
            minutes = minutes % 60;
        }
        
        jQuery('#timer_limit-input').val(minutes);
        jQuery('#timer_limit_hour-input').val(hours);
    });
});

function advacetimer_show_legacy_timers() {
  var checkbox = jQuery('.orher_timer_options input[name="qsm_timer_design"]:checked');
  if (checkbox.is(':checked')) {
    if('right_bottom_timer' == checkbox.attr('class') || 'big_timer' == checkbox.attr('class')) {
      jQuery('.show_legacy_timers').prop("checked", true);
      jQuery('.legace_timer_options').show();
    }else{
      jQuery('.legace_timer_options').hide();
    }
    if('v_line_timer' == checkbox.attr('class') || 'box_timer' == checkbox.attr('class') || 'oval_timer' == checkbox.attr('class')) {
      jQuery('.advance-background-color').show();
    }else{
      jQuery('.advance-background-color').hide();
    }
  }

  if(jQuery('#qsm-show-warning:checked').is(':checked')) {
    jQuery('.qsm-custome-timer-warning').show();
  }else{
    jQuery('.qsm-custome-timer-warning').hide();
  }

  if(jQuery('#qsm-refresh-timer-on-reload:checked').is(':checked') || jQuery('#qsm-show-stop-timer:checked').is(':checked')) {
    jQuery('.qsm-timer-continue-after-close').addClass('qsm-disabled-td');
    jQuery('#qsm-timer-continues-after-closing').prop("checked", false);
  }else{
    jQuery('.qsm-timer-continue-after-close').removeClass('qsm-disabled-td');
  }

}

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
      action: 'qsm_advanced_t_validate_license',
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
jQuery( '.qsm_advanced_t_validate_parent' ).on( 'click', '.qsm_advanced_t_validate_button', function ( event ) {
    event.preventDefault();
    var license_message = jQuery('.qsm_advanced_t_validate_message');
    jQuery("#qsm-license_message").show();
    if( jQuery('.qsm_advanced_t_validate_input').val() != "") {
      license_message.html(qsm_advanced_t_obj.please_wait);
      var data = {
        action: 'qsm_advanced_t_validate_license',
        input: jQuery('.qsm_advanced_t_validate_input').val(),
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
          license_message.html(qsm_advanced_t_obj.invalid).fadeIn();
        }
      });
    }else{
      license_message.html(qsm_advanced_t_obj.license_msg);
      jQuery('.qsm_advanced_t_validate_input').focus();
    }
});

jQuery(document).ready(function() { 
  jQuery('#timer_limit').closest('td').addClass('qsm-timers-settings-row');
  var timers_labels = jQuery('<fieldset>', {
    'class': 'buttonset buttonset-hide',
    'data-hide': '1',
    'id': 'timers_labels'
  });
  jQuery('#timer_limit_seconds').after(timers_labels);
  timers_labels.append(jQuery('#timer_limit').find('label.qsm-opt-desc'));
  jQuery('#timer_limit').find('label.qsm-opt-desc').remove();
});
