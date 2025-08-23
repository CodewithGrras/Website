jQuery(function ($) {
	console.log(jQuery( '.qsm_logic_validate_parent' ));

    jQuery( '.qsm_logic_validate_parent' ).on( 'click', '.qsm_logic_validate_button', function ( event ) {
        event.preventDefault();
        var license_message = jQuery('.qsm_logic_validate_message');
        jQuery("#qsm-license_message").show();
        if( jQuery('.qsm_logic_validate_input').val() != "") {
          license_message.html(qsm_logic_obj.please_wait);
          var data = {
            action: 'qsm_logic_validate_license',
            input: jQuery('.qsm_logic_validate_input').val(),
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
              license_message.html(qsm_logic_obj.invalid);
            }
          });
        }else{
          license_message.html(qsm_logic_obj.license_msg);
          jQuery('.qsm_logic_validate_input').focus();
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
    jQuery( '.qsm-license-container' ).on( 'click', '#qsm-validate_btn', function ( event ) {
      event.preventDefault();
      var license_message = jQuery('#qsm-license_entry .qsm-validate-msg');
      license_message.html(qsm_license_validate_obj.hold);
      if( jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val() != "") {
        var data = {
          action: 'qsm_logic_validate_license',
          input: jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').val(),
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
        jQuery('.qsm-license-container #qsm-license_entry input[name="license_key"]').focus();
      }
    });
})