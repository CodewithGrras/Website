<?php
/**
 * This file handles the Quiz Settings tab for the addon
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function qsm_addon_installer_addon_list() {
	?>
	<div class="wrap custom-addon-upper ">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Addon Installer', 'qsm-installer' ); ?></h1>
		<div class="wp-header-end"></div>
		<?php
		global $mlwQuizMasterNext;
		$active_class_addon = 'nav-tab-active';
		$active_class_license = '';
		$settings_data   = QSM_Installer::get_installer_option();
		if ( isset( $_POST['qsm_installer_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qsm_installer_nonce'] ) ), 'addon_installer' ) ) {
			$bundle_license_key   = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';
			if ( isset($_POST['qsm_validate_b_key']) ) {
				qsm_addon_installer_verify_license($bundle_license_key);
			} elseif ( isset($_POST['qsm_deactivate_b_key']) ) {
				$bundle_license_key     = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
				qsm_addon_installer_deactivate_license($bundle_license_key, $settings_data['current_bundle']);
			}
			$active_class_addon = '';
			$active_class_license = 'nav-tab-active';
		}

		$settings_data   = QSM_Installer::get_installer_option();
		$bundle_license_key     = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
		$license_status  = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
		$expiry_date     = isset( $settings_data['expiry_date'] ) ? $settings_data['expiry_date'] : '';
		$date_now = gmdate("d-m-Y");

		$mlwQuizMasterNext->alertManager->showAlerts();
		$selected_bundle         = isset( $settings_data['bundle'] ) ? trim( $settings_data['bundle'] ) : '';
		$tab_array = $mlwQuizMasterNext->pluginHelper->get_addon_tabs();
		$bundleArray = [];
		$all_addons = QSM_Installer::qsm_get_addon_data();
		$installed_plugins = get_plugins();
		$activated_plugins = get_option('active_plugins');
		?>
		<div class="nav-tab-wrapper addon-installer-tab-wrapper">
			<a href="javascript:void(0)"  data-tab="addons" class="tab-addons nav-tab addon-installer <?php echo esc_attr($active_class_addon); ?>"><?php esc_html_e( 'Addons', 'qsm-installer' ); ?></a>
			<a href="javascript:void(0)"  data-tab="licensemanager" class="tab-licensemanager nav-tab addon-installer <?php echo esc_attr($active_class_license); ?>"><?php esc_html_e( 'License Manager', 'qsm-installer' ); ?></a>
		</div>
		<?php
		if ( 0 == $settings_data['api_available'] ) { ?>
			<div class="qsm-popup-upgrade-warning qsm-installer-warning">
				<img src="<?php echo esc_url( QSM_PLUGIN_URL . '/php/images/warning.png' ); ?>" alt="warning">
				<span>
					<?php echo esc_html__('Installer option is currently unavailable. Please try again later.', 'qsm-installer'); ?>
				</span>
				<a href="javascript:void(0)" class="button button-secondary qsm-check-license-key-status">
					<?php echo esc_html__('Check for Installer Availability', 'qsm-installer'); ?>
				</a>
			</div>
		<?php } else {
			if ( '' == $bundle_license_key ) { ?>
				<div class="notice notice-warning is-dismissible ">
					<p>
						<?php esc_html_e('You have not entered any license keys for QSM bundles.', 'qsm-installer')?>
						<br/><br/><a href="javascript:void(0)" class="button button-secondary qsm-add-license-keys"><?php esc_html_e('Add License Key(s) from here', 'qsm-installer'); ?></a>
					</p>
				</div>
			<?php }
		}
		?>
		<div class="addon-insteller-addon-wrap" style="display: <?php echo "" != $active_class_addon ? "block" : "none"; ?>;">
			<div class="qsm_tab_content">
				<div class="qsm-sub-tab-menu addon-installer-sub-tab-menu " style="display: inline-block;width: 100%;">
					<ul class="subsubsub">
						<li>
							<a href="javascript:void(0)" data-tab="qsm-addon-page-list" class="current quiz-style-tab"><?php esc_html_e( 'All Addons', 'qsm-installer' ); ?></a>
						</li>
						<li>
							<a href="javascript:void(0)" data-tab="qsm-addon-theme-list" class="quiz-style-tab"><?php esc_html_e( 'Themes', 'qsm-installer' ); ?></a>
						</li>
						<li>
							<a href="javascript:void(0)" data-tab="qsm-active-addons" class="quiz-style-tab"><?php esc_html_e( 'Installed', 'qsm-installer' ); ?></a>
						</li>
					</ul>
				</div>
			</div>
			<div id="qsm-add-installer" class="qsm-primary-anchor" >
				<div class="qsm-quiz-page-addon qsm-addon-page-list">
					<div class="qsm-popular-addons" id="qsm-popular-addons">
						<div class="qsm-card-group" style="margin: 20px 0 ;">
							<?php
							if ( $all_addons ) {
								$filtered_addons_array = array_filter($all_addons, function ( $element ) use ( $selected_bundle ) {
									return in_array($selected_bundle, explode(', ', $element['bundle']), true);
								});

								$filtered_addons_name = array_column($filtered_addons_array, 'name');

								$nameToIndex = [];
								foreach ( $all_addons as $index => $item ) {
									$nameToIndex[ $item['name'] ] = $index;
								}

								foreach ( $filtered_addons_name as $name ) {
									if ( isset($nameToIndex[ $name ]) ) {
										$bundleArray[] = $all_addons[ $nameToIndex[ $name ] ];
										unset($all_addons[ $nameToIndex[ $name ] ]); // Remove the item from $all_addons to avoid duplicates
									}
								}

								$merged_array = array_merge($bundleArray, array_values($all_addons));

								foreach ( $merged_array as $key => $single_arr ) {
									if ( "addon" !== $single_arr['type'] ) {
										continue;
									}
									?>
									<div class="qsm-installer-container qsm-card-single">
										<div class="qsm-installer-top">
											<div class="qsm-installer-left">
												<div class="qsm-installer-image">
													<img alt="Addon Image" src="<?php echo esc_url( $single_arr['img'] ); ?>">
												</div>
											</div>
											<div class="qsm-installer-right">
												<div class="qsm-installer-paragraph">
													<!-- <h2><?php echo esc_html( $single_arr['name']); ?></h2> -->
													<p><?php echo esc_html( $single_arr['description']); ?></p>
												</div>
											</div>
										</div>
										<div class="qsm-plugin-button-wrap">
											<?php
											$is_activated = '';
											if ( isset($installed_plugins[ $single_arr['path'] ]) ) { ?>
												<span><?php echo esc_html__('Version', 'qsm-installer') . ' ' .  esc_attr( $installed_plugins[ $single_arr['path'] ]['Version'] );?></span> <?php
												$option_settings = wp_parse_args( get_option( $single_arr['option'], array(
													'license_key'    => '',
													'license_status' => '',
													'last_validate'  => 'invalid',
													'expiry_date'    => '',
												)));

												if ( in_array($single_arr['path'], $activated_plugins, true) ) {
													$is_activated = 'active';
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
													<div class="qsm-installer-update-deactivate">
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-deactivate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
															<span class="qsm-plugin-status"><?php esc_html_e( 'Activated', 'qsm-installer' ); ?></span>
															<button class="button button-primary"><?php esc_html_e( 'Deactivate', 'qsm-installer' ); ?></button>
														</div>
													</div>
													<?php } else {
														if ( "" == $option_settings['license_key'] ) { ?>
															<a target="_blank" class="button button-primary" href="?page=qmn_addons&tab=<?php echo esc_attr( strtolower(str_replace(' ', '-', $single_arr['settings_tab'])) ); ?>"><?php esc_html_e( 'Settings', 'qsm-installer' ); ?></a>
														<?php } else { ?>
															<div class="qsm-installer-update-deactivate">
																<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-deactivate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="solo">
																	<span class="qsm-plugin-status"><?php esc_html_e( 'Activated', 'qsm-installer' ); ?></span>
																	<button class="button button-primary"></span><?php esc_html_e( 'Deactivate', 'qsm-installer' ); ?></button>
																</div>
															</div>
														<?php }
													} ?>
												<?php } else {
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-activate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
														<span class="qsm-plugin-status"><?php esc_html_e( 'Deactivated', 'qsm-installer' ); ?></span>
														<button class="button button-primary"><?php esc_html_e( 'Activate', 'qsm-installer' ); ?></button>
													</div>
												<?php } else {
													if ( "" == $option_settings['license_key'] ) { ?>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
															<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/pricing"); ?>"><?php esc_html_e( 'Upgrade Plan', 'qsm-installer' ); ?></a>
														</div>
													<?php } else { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-activate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="solo">
														<span class="qsm-plugin-status"><?php esc_html_e( 'Deactivated', 'qsm-installer' ); ?></span>
														<button class="button button-primary"><?php esc_html_e( 'Activate', 'qsm-installer' ); ?></button>
													</div>
													<?php }
													}
												}
											} else {
												if ( 1 == $settings_data['api_available'] ) {
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-installer-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
															<span class="qsm-plugin-status"></span>
															<button class="button button-secondary"><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Install & Activate', 'qsm-installer' ); ?></button>
														</div>
													<?php } else { ?>
														<span></span>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
															<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/pricing"); ?>"><?php esc_html_e( 'Upgrade Plan', 'qsm-installer' ); ?></a>
														</div>
													<?php }
												}else { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
														<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/downloads/"); ?>"><?php esc_html_e( 'Download', 'qsm-installer' ); ?></a>
													</div>
											<?php }
											} ?>
											<span style="display: none;" class="qsm-ajax-response"></span>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
				<div class="qsm-quiz-page-addon qsm-addon-theme-list" style="display: none;">
					<div class="qsm-popular-themes" id="qsm-popular-themes">
						<div class="qsm-card-group" style="margin: 20px 0 ;">
							<?php
							$all_addons = QSM_Installer::qsm_get_addon_data();
							if ( $all_addons ) {
								$themeBundleArray = array();
								$filtered_addons_array = array_filter($all_addons, function ( $element ) use ( $selected_bundle ) {
									return in_array($selected_bundle, explode(', ', $element['bundle']), true);
								});
								$filtered_addons_name = array_column($filtered_addons_array, 'name');

								$nameToIndex = [];
								foreach ( $all_addons as $index => $item ) {
									$nameToIndex[ $item['name'] ] = $index;
								}

								foreach ( $filtered_addons_name as $name ) {
									if ( isset($nameToIndex[ $name ]) ) {
										$themeBundleArray[] = $all_addons[ $nameToIndex[ $name ] ];
										unset($all_addons[ $nameToIndex[ $name ] ]); // Remove the item from $all_addons to avoid duplicates
									}
								}

								$merged_array = array_merge($themeBundleArray, array_values($all_addons));
								foreach ( $merged_array as $key => $single_arr ) {
									if ( "theme" !== $single_arr['type'] ) {
										continue;
									}
									?>
									<div class="qsm-installer-container qsm-card-single">
										<div class="qsm-installer-top">
											<div class="qsm-installer-left">
												<div class="qsm-installer-image">
													<img alt="Addon Image" src="<?php echo esc_url( $single_arr['img'] ); ?>">
												</div>
											</div>
											<div class="qsm-installer-right">
												<div class="qsm-installer-paragraph">
													<h3><?php echo esc_html( $single_arr['name']); ?></h3>
													<p><?php echo esc_html( $single_arr['description']); ?></p>
												</div>
											</div>
										</div>
										<div class="qsm-plugin-button-wrap">
											<?php
											$is_activated = '';
											if ( isset($installed_plugins[ $single_arr['path'] ]) ) { ?>
												<span><?php echo esc_html__('Version', 'qsm-installer') . ' ' .  esc_attr( $installed_plugins[ $single_arr['path'] ]['Version'] );?></span> <?php
												$option_settings = wp_parse_args( get_option( $single_arr['option'], array(
													'license_key'    => '',
													'license_status' => '',
													'last_validate'  => 'invalid',
													'expiry_date'    => '',
												)));

												if ( in_array($single_arr['path'], $activated_plugins, true) ) {
													$is_activated = 'active';
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
													<div class="qsm-installer-update-deactivate">
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-deactivate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
															<span class="qsm-plugin-status"><?php esc_html_e( 'Activated', 'qsm-installer' ); ?></span>
															<button class="button button-primary"><?php esc_html_e( 'Deactivate', 'qsm-installer' ); ?></button>
														</div>
													</div>
													<?php } else {
														if ( "" == $option_settings['license_key'] ) { ?>
															<a target="_blank" class="button button-primary" href="?page=qmn_addons&tab=<?php echo esc_attr( 'qsm-theme-' . strtolower(str_replace(' ', '-', $single_arr['settings_tab'])) ); ?>"><?php esc_html_e( 'Settings', 'qsm-installer' ); ?></a>
														<?php } else { ?>
															<div class="qsm-installer-update-deactivate">
																<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-deactivate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="solo">
																	<span class="qsm-plugin-status"><?php esc_html_e( 'Activated', 'qsm-installer' ); ?></span>
																	<button class="button button-primary"></span><?php esc_html_e( 'Deactivate', 'qsm-installer' ); ?></button>
																</div>
															</div>
														<?php }
													} ?>
												<?php } else {
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-activate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
														<span class="qsm-plugin-status"><?php esc_html_e( 'Deactivated', 'qsm-installer' ); ?></span>
														<button class="button button-primary"><?php esc_html_e( 'Activate', 'qsm-installer' ); ?></button>
													</div>
												<?php } else {
													if ( "" == $option_settings['license_key'] ) { ?>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
															<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/pricing"); ?>"><?php esc_html_e( 'Upgrade Plan', 'qsm-installer' ); ?></a>
														</div>
													<?php } else { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-activate-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="solo">
														<span class="qsm-plugin-status"><?php esc_html_e( 'Deactivated', 'qsm-installer' ); ?></span>
														<button class="button button-primary"><?php esc_html_e( 'Activate', 'qsm-installer' ); ?></button>
													</div>
													<?php }
													}
												}
											} else {
												if ( 1 == $settings_data['api_available'] ) {
													if ( in_array($single_arr['name'], $filtered_addons_name, true) ) { ?>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" class="qsm-installer-button qsm-installer-action <?php echo esc_attr($is_activated); ?>" data-single="bundle">
															<span class="qsm-plugin-status"></span>
															<button class="button button-secondary"><span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Install & Activate', 'qsm-installer' ); ?></button>
														</div>
													<?php } else { ?>
														<span></span>
														<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
															<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/pricing"); ?>"><?php esc_html_e( 'Upgrade Plan', 'qsm-installer' ); ?></a>
														</div>
													<?php }
												}else { ?>
													<div data-slug="<?php echo esc_attr($single_arr['slug']); ?>" >
														<a class="button button-primary" target="_blank" href="<?php echo esc_url(QSM_INSTALLER_API_URL."/downloads/"); ?>"><?php esc_html_e( 'Download', 'qsm-installer' ); ?></a>
													</div>
											<?php }
											} ?>
											<span style="display: none;" class="qsm-ajax-response"></span>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
				<div id="qsm-installed-addons" class="qsm-quiz-page-addon qsm-active-addons" style="display: none;" >
					<h2 class="installed_title"><?php esc_html_e( 'Installed Addons', 'qsm-installer' ); ?></h2>
					<?php
					$slugs_to_remove = array( 'featured-addons', 'qsm-installer' );
					foreach ( $tab_array as $key => $value ) {
						if ( in_array($value['slug'], $slugs_to_remove, true) ) {
							unset($tab_array[ $key ]);
						}
					}
					if ( ! empty($tab_array) && count( $tab_array ) > 0 ) {
						?>
						<div class="installed_addons_wrapper">
							<?php
							foreach ( $tab_array as $tab ) {
								if ( 'Featured Addons' === trim( $tab['title'] ) || 'qsm-installer' == $tab['slug'] ) {
									continue;
								}
								?>
							<div class="installed_addon">
								<span class="installed_addon_name"><?php echo wp_kses_post( $tab['title'] ); ?></span>
								<span class="installed_addon_link"><a target="_blank" class="button button-default" href="?page=qmn_addons&tab=<?php echo esc_attr( $tab['slug'] ); ?>"><span class="dashicons dashicons-admin-generic"></span><?php esc_html_e( 'Settings', 'qsm-installer' ); ?></a></span>
							</div>
							<?php } ?>
						</div>
					<?php } else {
						?>
						<div class="no_addons_installed">
							<div>
								<?php esc_html_e( 'You haven\'t activated any add-ons yet. Please check out our collection and activate the one that suits your needs.', 'qsm-installer' );?>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php
		$display_form = "block";
		if ( '' != $bundle_license_key && 'valid' == $license_status ) {
			$display_form = "none";
		}

		?>
		<div class="addon-insteller-licensemanager-wrap" style="display: <?php echo '' !== $active_class_addon ? 'none' : 'block'; ?>;">
			<div class="qsm_tab_content">
				<form action="" method="post" class="addon-installer-license-form">
				<?php
				if ( 1 === $settings_data['api_available'] ) {
					?>
					<table class="form-table" style="width: 100%;">
						<tr valign="top">
							<th scope="row"><label for="license_key"><?php esc_html_e( 'Bundle License Key', 'qsm-installer' ); ?></label></th>
							<td class="qsm-license-td">
								<div class="license-input">
									<div class="license-input-div">
										<div class="qsm-wrap-license" style="display: <?php echo esc_attr( $display_form ); ?>;">
											<input type="password" name="license_key" id="license_key" value="" />
											<button class="button-primary validate-license" name="qsm_validate_b_key"><?php esc_html_e( 'Save Changes', 'qsm-installer' ); ?></button>
											<span style="display: none;" class="cancel-license-btn"><?php esc_html_e( 'Cancel', 'qsm-installer' ); ?></span>
										</div>
										<div class="other-license-info">
											<?php
											$date_now = gmdate( 'd-m-Y' );
											if ( '' !== $bundle_license_key && 'valid' === $license_status ) {
												if ( ( isset( $settings_data['expiry_date'] ) && '' !== $settings_data['expiry_date'] ) && strtotime( $date_now ) > strtotime( $settings_data['expiry_date'] ) ) {
													?>
													<span class="dashicons dashicons-warning"></span>
													<p class="license-info warning">
														<b><?php echo esc_html( $settings_data['current_bundle'] ); ?></b>
														<span><?php esc_html_e( 'License | Your license is expired.', 'qsm-installer' ); ?><a target="_blank" href="<?php echo esc_url( QSM_INSTALLER_API_URL . '/pricing' ); ?>"><?php esc_html_e( 'Renew license', 'qsm-installer' ); ?></a></span>
													</p>
												<?php } else { ?>
													<span class="dashicons dashicons-yes-alt"></span>
													<p class="license-info success">
													<?php
													echo '<b>' . esc_html( $settings_data['current_bundle'] ) . '</b> ' .
													esc_html__( 'License | Valid till', 'qsm-installer' ) . ' ' .
													esc_html( gmdate( 'd M Y', strtotime( $expiry_date ) ) );
													?>
													</p>
												<?php } ?>
												<span class="qsm-change-license"><?php esc_html_e( 'Change License', 'qsm-installer' ); ?></span>
												<div class="license-deactivate-div">
													<span>&nbsp;&nbsp;| </span><button class="deactivate-license" name="qsm_deactivate_b_key"><?php esc_html_e( 'Deactivate License', 'qsm-installer' ); ?></button>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				<?php } ?>
				<?php wp_nonce_field( 'addon_installer', 'qsm_installer_nonce' ); ?>

				<?php
				$license_table_array = array();

				foreach ( $merged_array as $key => $single_arr ) {
					if ( isset( $installed_plugins[ $single_arr['path'] ] ) && in_array( $single_arr['path'], $activated_plugins, true ) && isset( $single_arr['option'] ) ) {
						$option_settings = get_option( $single_arr['option'], array() );
						$options         = wp_parse_args(
							$option_settings,
							array(
								'license_key'    => '',
								'license_status' => '',
								'last_validate'  => 'invalid',
								'expiry_date'    => '',
								'name'           => $single_arr['name'],
							)
						);
						if ( '' !== $options['license_key'] ) {
							$license_table_array[] = $single_arr;
						}
					}
				}

				if ( $license_table_array ) {
					?>
					<table class="qsm-installer-table wp-list-table widefat fixed striped posts" style="width: 100%; margin:20px 0;">
						<thead>
							<tr>
								<th width="20%"><?php esc_html_e( 'Name', 'qsm-installer' ); ?></th>
								<th><?php esc_html_e( 'Last Validate', 'qsm-installer' ); ?></th>
								<th width="50%"><?php esc_html_e( 'License Key', 'qsm-installer' ); ?></th>
								<th><?php esc_html_e( 'Settings', 'qsm-installer' ); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ( $license_table_array as $key => $single_arr ) {
							$option_settings = get_option( $single_arr['option'], array() );
							$options         = wp_parse_args(
								$option_settings,
								array(
									'license_key'    => '',
									'license_status' => '',
									'last_validate'  => 'invalid',
									'expiry_date'    => '',
									'name'           => $single_arr['name'],
								)
							);

							if ( '' !== $options['license_key'] ) {
								$item_name = ( 'valid' === $options['license_status'] && $options['license_key'] !== $bundle_license_key ) ? $single_arr['name'] : $settings_data['current_bundle'];
								?>
								<tr valign="top">
									<td class="qsm-installer-addon-title"><span class="row-title"><?php echo esc_html( $single_arr['name'] ); ?></span></td>
									<td class="qsm-installer-addon-lastvalidate"><?php echo esc_html( $options['last_validate'] ); ?></td>
									<td class="qsm-table-license-status">
										<div class="qsm-installer-license-details">
											<span class="dashicons dashicons-yes-alt"></span>
											<p class="license-info success">
												<b><?php echo esc_html( $item_name . ' ' . __( ' License |', 'qsm-installer' ) ); ?></b> <?php esc_html_e( 'Valid till ', 'qsm-installer' ); ?> <?php echo esc_html( gmdate( 'd-m-Y', strtotime( $options['expiry_date'] ) ) ); ?>
												<a href="javascript:void(0);" class="qsm-installer-change-license"><?php esc_html_e( 'Change License', 'qsm-installer' ); ?></a>
											</p>
										</div>
										<div class="qsm-installer-license-form" style="display: none;" >
											<input type="text" class="qsm-license-individual-input" name="license_key_individual" placeholder="<?php esc_attr_e( 'Enter License key', 'qsm-installer' ); ?>"/>
											<button data-slug="<?php echo esc_attr( $single_arr['slug'] ); ?>" class="button button-primary qsm-validate-individual-license"><?php esc_html_e( 'Validate', 'qsm-installer' ); ?></button>
											<a href="javascript:void(0);" class="qsm-installer-cancel-license" href=""><?php esc_html_e( 'Cancel', 'qsm-installer' ); ?></a>
											<p class="qsm-validate-msg"></p>
										</div>
										<div class="qsm-installer-license-response" style="display: none;" ></div>
									</td>
									<td class="qsm-installer-addon-viewsettings"><a class="button button-primary" target="_blank" href="?page=qmn_addons&tab=<?php echo esc_attr( strtolower( str_replace( ' ', '-', $single_arr['settings_tab'] ) ) ); ?>"><?php esc_html_e( 'Settings', 'qsm-installer' ); ?></a></td>
								</tr>
								<?php
							}
						}
						?>
						</tbody>
					</table>
				<?php } ?>
				</form>
			</div>
		</div>
	</div><!-- custom-addon-upper -->
	<?php
}


function qsm_addon_installer_verify_license( $bundle_license_key ) {

	global $mlwQuizMasterNext;

	$bundle_license_key   = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';
	$settings_data    = array();
	$settings_data['license_key'] = $bundle_license_key;
	$older_settings   = QSM_Installer::get_installer_option();
	$return_data = array();
	$license_data = array(
		'timeout'   => 15,
		'sslverify' => false,
		'body'      => array(
			'license_key'     => $bundle_license_key,
			'old_license_key' => $older_settings['license_key'],
			'old_bundle'      => $older_settings['current_bundle'],
			'url'             => home_url(),
		),
	);

	$api_url = QSM_INSTALLER_API_URL.'/wp-json/validate-license/v1/verify';
	$response = wp_remote_post( $api_url, $license_data);
	$body = wp_remote_retrieve_body($response);
	$return_data = json_decode($body, true);
	if ( is_wp_error($response) ) {
		$mlwQuizMasterNext->alertManager->newAlert( $response->get_error_message(), 'error' );
	} else {
		$body = wp_remote_retrieve_body($response);
		$return_data = json_decode($body, true);
		$api_response = array();
		if ( isset($return_data['api_response']) ) {
			$api_response = $return_data['api_response'];
		}
		update_option( 'qsm_addon_installer_settings', wp_parse_args($api_response, array(
			'license_key'    => '',
			'license_status' => '',
			'last_validate'  => '',
			'expiry_date'    => '',
			'download_id'    => '',
			'bundle'         => '',
			'current_bundle' => '',
			'api_available'  => isset($return_data['api_available']) ? $return_data['api_available'] : 0,
		)));
		if ( isset($return_data['success']) && isset($return_data['api_available']) && 1 == $return_data['success'] && 1 == $return_data['api_available'] ) {
			$mlwQuizMasterNext->alertManager->newAlert( __( 'Your settings has been saved successfully!', 'qsm-installer' ), 'success' );
		} else {
			$mlwQuizMasterNext->alertManager->newAlert( $return_data['message'], 'error' );
		}
	}
}


function qsm_addon_installer_deactivate_license( $bundle_license_key, $bundle ) {
	QSM_Installer::license_deactivate($bundle_license_key, $bundle);
	update_option( 'qsm_addon_installer_settings', array(
		'license_key'    => '',
		'license_status' => '',
		'last_validate'  => '',
		'expiry_date'    => '',
		'download_id'    => '',
		'bundle'         => '',
		'current_bundle' => '',
		'api_available'  => 1,
	));
}