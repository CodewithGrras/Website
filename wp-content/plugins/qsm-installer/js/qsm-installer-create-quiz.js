var QSMAInstallerCreateQuiz;
jQuery(function ($) {

    // Install Plugin - Working
    QSMAInstallerCreateQuiz = {
        installPlugin: function (slug, path, $parent, $element, installerActivated, isToggle, isButton) {
            $.ajax({
                type: "POST",
                url: qsm_admin_new_quiz.ajaxurl,
                data: {
                    action: 'qsm_handle_ajax_install',
                    nonce: qsm_admin_new_quiz.nonce,
                    slug: slug,
                },
                success: function (response) {
                    response = QSMAInstallerCreateQuiz.parseResponse(response);

                    if (response.data && response.data.message.includes("Plugin installed successfully")) {
                        // Ensure installedPlugins is an array before pushing
                        if (!Array.isArray(qsm_admin_new_quiz.installed)) {
                            qsm_admin_new_quiz.installed = [];
                        }
                        qsm_admin_new_quiz.installed.push(path);
                        if (!Array.isArray(qsm_admin_new_quiz.activated)) {
                            qsm_admin_new_quiz.activated = [];
                        }
                        qsm_admin_new_quiz.activated.push(path);
                        if (isButton) {
                            QSMAdminDashboard.afterInstall(slug, path, $parent, $element, installerActivated, isToggle, isButton);
                            QSMAdminDashboard.processToSelectTheme($parent);
                        }
                        if (isToggle) {
                            $parent.find('.qsm-dashboard-addon-status').text(qsm_admin_new_quiz.activated_text);
                        }
                        QSMAInstallerCreateQuiz.getPluginVersion(slug, path, $parent, $element, installerActivated, isToggle, isButton);
                    } else {
                        $parent.find('.qsm-dashboard-addon-status').text(qsm_admin_new_quiz.retry);
                        if (isToggle) { $element.prop('checked', false).prop('disabled', false); }
                        if (isButton) { $element.prop('disabled', false); $element.text(qsm_admin_new_quiz.retry); }
                    }
                }
            });
        },

        activatePlugin: function (slug, path, $parent, $element, installerActivated, isToggle, isButton) {
            let action = installerActivated == 1 ? 'qsm_handle_ajax_activate' : 'qsm_activate_plugin';

            $.ajax({
                type: "POST",
                url: qsm_admin_new_quiz.ajaxurl,
                data: {
                    action: action,
                    nonce: qsm_admin_new_quiz.nonce,
                    slug: slug,
                    single: 'bundle',
                    'plugin_path': path
                },
                success: function (response) {
                    response = QSMAInstallerCreateQuiz.parseResponse(response);
                    if (response.data && (response.data.message.includes("Plugin activated successfully") || response.data.message.includes("Plugin is already activated."))) {
                        // Ensure activatedPlugins is an array before pushing
                        if (!Array.isArray(qsm_admin_new_quiz.activated)) {
                            qsm_admin_new_quiz.activated = [];
                        }
                        qsm_admin_new_quiz.activated.push(path);
                        if (isButton) {
                            QSMAdminDashboard.afterInstall(slug, path, $parent, $element, installerActivated, isToggle, isButton);
                            QSMAdminDashboard.processToSelectTheme($parent);
                        }
                        if (isToggle) {
                            $parent.find('.qsm-dashboard-addon-status').text(qsm_admin_new_quiz.activated_text);
                            $element.prop('checked', true).prop('disabled', false);
                        }
                        $element.prop('disabled', false);
                        QSMAInstallerCreateQuiz.getPluginVersion(slug, path, $parent, $element, installerActivated, isToggle, isButton);
                    } else {
                        $parent.find('.qsm-dashboard-addon-status').text(response.data.message);
                        if (isToggle) { $element.prop('checked', false).prop('disabled', false); }
                        if (isButton) { $element.prop('disabled', false); $element.text(qsm_admin_new_quiz.retry); }
                    }
                }
            });
        },

        parseResponse: function (response) {
            if (typeof response !== 'object') {
                const jsonRegex = /\{.*\}/;
                let match = response.match(jsonRegex);
                if (match) {
                    response = JSON.parse(match[0]);
                } else {
                    response = { success: false };
                }
            }
            return response;
        },

        getPluginVersion: async function (slug, path, $parent, $element, installerActivated, isToggle, isButton) {
            response = await QSMAdminDashboard.ajaxRequest('qsm_activate_plugin_ajax_handler', {
                nonce: qsm_admin_new_quiz.nonce,
                plugin_path: path
            });
            if (response.success) {
                if (response.data.version) {
                    $parent.find('.qsm-dashboard-addon-status').text(response.data.version);
                    console.log("Plugin Version:", response.data.version);
                }
            }
        },
    };

    jQuery(document).on("qsm_activate_plugin_button_click_after", function (_event, pluginSlug, pluginPath, $parent, $element, installerActivated, isToggle, isButton) {
        QSMAInstallerCreateQuiz.activatePlugin(pluginSlug, pluginPath, $parent, $element, installerActivated, isToggle, isButton);
    });

    jQuery(document).on("qsm_install_plugin_button_click_after", function (_event, pluginSlug, pluginPath, $parent, $element, installerActivated, isToggle, isButton) {
        QSMAInstallerCreateQuiz.installPlugin(pluginSlug, pluginPath, $parent, $element, installerActivated, isToggle, isButton);
    });


});
