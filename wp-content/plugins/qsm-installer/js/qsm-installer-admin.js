jQuery(document).ready(function ($) {
    // Install Plugin - Working
    $(document).on('click', '#qsm-add-installer .qsm-installer-button', function () {
        var $span = $(this).parents('.qsm-installer-container').find('.qsm-ajax-response');
        $span.html(qsm_installer_js.install);
        $span.show();
        var $button = $(this).find('button');
        var $this = $(this);
        var $slug = $(this).data('slug');
        $button.attr('disabled', true);
        qsm_installer_pre_span($button); // add update icon
        $this.addClass('qsm-disabled-td');
        var data = {
            action: 'qsm_handle_ajax_install',
            nonce: qsm_installer_js.nonce,
            slug: $(this).data('slug'),
        };
        $.ajax({
            type: "POST",
            url: qsm_installer_js.ajaxurl,
            data: data,
            success: function (response) {
                qsm_installer_remove_span($button);
                $button.prop('disabled', false);
                if (typeof response !== 'object' ) {
                    const jsonRegex = /\{.*\}/;
                    response = response.match(jsonRegex);
                    response = JSON.parse(response);
                }
                $this.removeClass('qsm-disabled-td');

                if ($slug === 'sync-with-google-sheets' && response.data.zip_url !== undefined ) {
                    $span.html(response.data.message);
                    const zip_url = response.data.zip_url;
                    if (zip_url) {
                        const qsmAnchorTag = document.createElement('a');
                        qsmAnchorTag.href = zip_url;
                        qsmAnchorTag.download = '';
                        document.body.appendChild(qsmAnchorTag);
                        qsmAnchorTag.click();
                        document.body.removeChild(qsmAnchorTag);
                    }
                    return;
                }

                if (response.data.message.includes("Download failed. Unauthorized")) {
                    $span.html(qsm_installer_js.install_key_error);
                } else if (response.data.message.includes("Plugin installed successfully")) {
                    $button.text(qsm_installer_js.deactivatebtn);
                    $this.removeClass('qsm-installer-button');
                    $this.addClass('qsm-deactivate-button');
                    $this.data('single', 'bundle');
                    $span.html(response.data.message);
                    $this.find('.qsm-plugin-status').html(qsm_installer_js.activated);
                } else if (response.data.message.includes("Please try again")) {
                    $span.html(qsm_installer_js.install_key_error);
                } else {
                    $span.html(response.data.message);
                    if (response.data.message.includes("The addon installer option is currently unavailable")) {
                        setTimeout(() => {
                            window.location.reload(true);
                        }, 3000);
                    }
                }
            },
        });
    });

    // Activate Plugin - Working
    $(document).on('click', '#qsm-add-installer .qsm-activate-button', function () {

        var $span = $(this).parents('.qsm-installer-container').find('.qsm-ajax-response');
        $span.show();
        var $button = $(this).find('button');
        $button.attr('disabled', true);
        qsm_installer_pre_span($button);
        $span.html(qsm_installer_js.activate);
        var $this = $(this);
        $this.addClass('qsm-disabled-td');
        var data = {
            action: 'qsm_handle_ajax_activate',
            nonce: qsm_installer_js.nonce,
            slug: $(this).data('slug'),
            single: $(this).data('single'),
        };
        $.ajax({
            type: "POST",
            url: qsm_installer_js.ajaxurl,
            data: data,
            success: function (response) {
                $button.prop('disabled', false);
                qsm_installer_remove_span($button);
                $span.html(response.data.message);
                $this.removeClass('qsm-disabled-td');
                if (response.data.message.includes("Plugin activated successfully")) {
                    $this.removeClass('qsm-activate-button');
                    $this.addClass('qsm-deactivate-button');
                    $button.html(qsm_installer_js.deactivatebtn);
                    $this.find('.qsm-plugin-status').html(qsm_installer_js.activated);
                }
            },
        });
    });

    // Deactivate Plugin - Working
    $(document).on('click', '#qsm-add-installer .qsm-deactivate-button', function () {

        var $span = $(this).parents('.qsm-installer-container').find('.qsm-ajax-response');
        $span.show();
        var $button = $(this).find('button');
        $button.text(qsm_installer_js.deactivate);
        $button.attr('disabled', true);
        qsm_installer_pre_span($button);
        $span.html(qsm_installer_js.deactivate);
        var $this = $(this);
        $this.addClass('qsm-disabled-td');
        var data = {
            action: 'qsm_handle_ajax_deactivate',
            nonce: qsm_installer_js.nonce,
            slug: $(this).data('slug'),
            single: $(this).data('single'),
        };
        $.ajax({
            type: "POST",
            url: qsm_installer_js.ajaxurl,
            data: data,
            success: function (response) {
                $button.prop('disabled', false);
                qsm_installer_remove_span($button);
                $span.html(response.data.message);
                $this.removeClass('qsm-disabled-td');
                if (response.data.message.includes("Plugin deactivated successfully")) {
                    $this.find('.qsm-plugin-status').html(qsm_installer_js.deactivated);
                    $this.removeClass('qsm-deactivate-button');
                    $this.addClass('qsm-activate-button');
                    $button.html(qsm_installer_js.activebtn);
                }
            },
        });
    });

    jQuery(document).on('click', '.qsm-add-license-keys', function (event) {
        event.preventDefault();
        jQuery(".addon-installer-tab-wrapper .tab-licensemanager").trigger('click');
        jQuery("#license_key").focus();
    });

    jQuery(document).on('click', '.qsm-check-license-key-status', function (event) {
        var $this_button = jQuery(this);
        $.ajax({
            type: "POST",
            url: qsm_installer_js.ajaxurl,
            data: {
                action: 'qsm_handle_ajax_check_license',
                nonce: qsm_installer_js.nonce
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.success == 1) {
                    window.location.reload(true);
                }else {
                    $this_button.remove();
                    $('.qsm-installer-warning span').html(data.message);
                }
            },
        });
    });

    jQuery(document).on('click', '.qsm-installer-change-license, .qsm-installer-try-again-license', function (event) {
        var $qsm_parentdiv =  jQuery(this).parents('.qsm-table-license-status');
        $qsm_parentdiv.find('.qsm-installer-license-details').hide();
        $qsm_parentdiv.find('.qsm-installer-license-form').show();
        $qsm_parentdiv.find('.qsm-installer-license-response').hide();
    });


    jQuery(document).on('click', '.qsm-installer-cancel-license, .qsm-installer-view-details-license', function (event) {
        var $qsm_parentdiv =  jQuery(this).parents('.qsm-table-license-status');
        $qsm_parentdiv.find('.qsm-installer-license-details').show();
        $qsm_parentdiv.find('.qsm-installer-license-form').hide();
        $qsm_parentdiv.find('.qsm-installer-license-response').hide();
    });

    jQuery(document).on('keydown', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            return false;
        }
    });

    jQuery(document).on('click', '.qsm-validate-individual-license', function (e) {
        e.preventDefault();
        var $qsm_parentdiv =  jQuery(this).parents('.qsm-table-license-status');
        var $qsm_license_message = $qsm_parentdiv.find('.qsm-installer-license-response');
        var $qsm_license_key = $qsm_parentdiv.find('.qsm-license-individual-input');

        $qsm_parentdiv.find('.qsm-installer-license-form').hide();
        $qsm_license_message.show();
        $qsm_license_message.html(qsm_installer_js.hold);

        if( $qsm_license_key.val() != "") {
            var data = {
                action: 'qsm_installer_validate_single_license',
                nonce: qsm_installer_js.nonce,
                slug: $(this).data('slug'),
                input: $qsm_license_key.val(),
            };
            $.ajax({
                type: "POST",
                url: qsm_installer_js.ajaxurl,
                data: data,
                success: function (response) {
                    if(response.data.success == 1){
                        $qsm_license_key.val("");
                        $qsm_parentdiv.find('.qsm-installer-addon-lastvalidate').html(response.data.last_validate);
                        $qsm_parentdiv.find('.qsm-installer-license-details').html(response.data.html);
                        $qsm_license_message.html(response.data.message + '<a href="javascript:void(0);" class="qsm-installer-view-details-license">'+qsm_installer_js.view_details+'</a>');
                        setTimeout(function() {
                            // $qsm_parentdiv.find('.qsm-installer-license-details').show();
                            // $qsm_parentdiv.find('.qsm-installer-license-response').hide();
                        }, 5000);
                    } else {
                        $qsm_license_message.html(response.data.message + '<a href="javascript:void(0);" class="qsm-installer-try-again-license">'+qsm_installer_js.try_again+'</a>');
                    }
                }
            });
        } else {
            // Empty license key case
            $qsm_license_message.hide();
            $qsm_parentdiv.find('.qsm-installer-license-form').show();
            $qsm_parentdiv.find('.qsm-license-individual-input').focus();
        }
    });
});

function qsm_installer_pre_span($element) {
    $element.prepend('<span class="dashicons dashicons-update"></span>');
}

function qsm_installer_remove_span($element) {
    $element.find('span.dashicons-update').remove();
}
jQuery(document).ready(function ($) {

    $(document).on('click', '.addon-installer-tab-wrapper .addon-installer', function () {
        var tab = $(this).data('tab');
        $('.custom-addon-upper .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        if(tab == "addons") {
            $('.addon-insteller-licensemanager-wrap').hide();
            $('.addon-insteller-addon-wrap').show();
        }else if(tab == "licensemanager") {
            $('.addon-insteller-addon-wrap').hide();
            $('.addon-insteller-licensemanager-wrap').show();
        }
    });

    $(document).on('click', '.addon-installer-sub-tab-menu .subsubsub li .quiz-style-tab', function () {
        jQuery("#qsm-add-installer .qsm-quiz-page-addon").hide();
        console.log(jQuery("#qsm-add-installer ." + $(this).data('tab')));
        jQuery("#qsm-add-installer ." + $(this).data('tab')).show();
    });
    $('.tab-content:not(:first)').hide();

    jQuery(document).on('click', '.custom-addon-upper li .nav-tab', function (e) {
        jQuery(".custom-addon-upper li a").removeClass('current');
        jQuery(this).addClass('current');
        jQuery("#qsm_add_addons").show();
        jQuery("#qsm-installed-addons").hide();
    });

    jQuery(document).on('click', '.license-input-div .cancel-license-btn', function (e) {
        $parent = jQuery(this).parents('.license-input-div');
        jQuery('.qsm-wrap-license').hide();
        jQuery('.other-license-info').show();
    });

    jQuery(document).on('click', '.license-input-div .qsm-change-license', function (e) {
        $parent = jQuery(this).parents('.license-input-div');
        $parent.find('.other-license-info').hide();
        $parent.find('.qsm-wrap-license').show();
        $parent.find('.cancel-license-btn').show();
        $parent.find('.validate-license').text(qsm_installer_js.change_license);
    });

});