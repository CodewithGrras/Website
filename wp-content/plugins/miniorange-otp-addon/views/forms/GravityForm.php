<?php

use GFOTP\Helper\MoUtility;

echo '			<div class="mo_otp_form" id="' . mo_gf_esc_string( get_mo_gf_class( $handler ), 'attr' ) . '">
			                    <input  type="checkbox" ' . mo_gf_esc_string( $disabled, 'attr' ) . '
			                            id="gf_contact" class="app_enable"
			                            data-toggle="gf_contact_options"
			                            name="mo_customer_validation_gf_addon_contact_enable"
										style="margin-bottom:5px;"
			                            value="1" ' . mo_gf_esc_string( $gf_addon_enabled, 'attr' ) . ' /><strong>' . mo_gf_esc_string( 'Enable OTP Verification on Gravity Forms', 'attr' ) . '</strong>';


echo '							<div class="mo_registration_help_desc"  id="gf_contact_options" style="margin-left:5px;">  
									<p><input 	type="radio" ' . mo_gf_esc_string( $disabled, 'attr' ) . ' id="gf_contact_email" class="app_enable"
												data-toggle="gf_contact_email_instructions"
												name="mo_customer_validation_gf_addon_contact_type"
												value="' . mo_gf_esc_string( $gf_type_email, 'attr' ) . '"
												' . ( mo_gf_esc_string( $gf_addon_enabled_type, 'attr' ) === mo_gf_esc_string( $gf_type_email, 'attr' ) ? 'checked' : '' ) . ' />
										<strong>' . mogf_( 'Enable Email Verification' ) . '</strong>
									</p>

										<div ' . ( mo_gf_esc_string( $gf_addon_enabled_type, 'attr' ) != mo_gf_esc_string( $gf_type_email, 'attr' ) ? 'style="display:none;"' : '' ) . '
										     class="mo_registration_help_desc" id="gf_contact_email_instructions" >
											' . mogf_( 'Follow the following steps to enable Email Verification for' ) . ' Gravity form:
											<ol>
												<li><a href="' . mo_gf_esc_string( $gf_field_list, 'url' ) . '" target="_blank">
												    ' . mogf_( 'Click Here' ) . '</a> ' . mogf_( ' to see your list of the Gravity Forms.' ) . '
												</li>
												<li>' . mogf_( 'Add an email field to your existing form' ) . '</li>
												<li>' . mogf_( 'Add a text field with label<b> "Enter Validation Code" </b>in your existing form.' ) . '</li>
												<li>' . mogf_( 'Add the Form ID, Email Field Label and Verification Field Label below:' ) . '<br>
												<br/>' . mogf_( 'Add Form' ) . ' : <input  type="button"  value="+" ' . mo_gf_esc_string( $disabled, 'attr' ) . '
                                                                                            onclick="add_gravity(\'email\',1);"
                                                                                            class="button button-primary" />&nbsp;
													    <input  type="button" value="-" ' . mo_gf_esc_string( $disabled, 'attr' ) . '
													            onclick="remove_gravity(1);"
													            class="button button-primary" /><br/><br/>';
												$gf_form_results = get_multiple_form_select_gf(
													$gf_addon_otp_enabled,
													true,
													true,
													$disabled,
													1,
													'gravity',
													'Label'
												);
												$gfcounter1      = ! MoUtility::isBlank( $gf_form_results['counter'] ) ? max( $gf_form_results['counter'] - 1, 0 ) : 0;

												echo '
												</li>
												<li>' . mogf_( 'Click on the Save Button to save your settings and keep a track of your Form Ids.' ) . '</li>
											</ol>
									</div>
									<p><input 	type="radio" ' . mo_gf_esc_string( $disabled, 'attr' ) . ' id="gf_contact_phone" class="app_enable"
												data-toggle="gf_contact_phone_instructions"
												name="mo_customer_validation_gf_addon_contact_type"
												value="' . mo_gf_esc_string( $gf_type_phone, 'attr' ) . '"
										' . ( mo_gf_esc_string( $gf_addon_enabled_type, 'attr' ) == mo_gf_esc_string( $gf_type_phone, 'attr' ) ? 'checked' : '' ) . ' />
										<strong>' . mogf_( 'Enable Phone Verification' ) . '</strong>
									</p>
									<div ' . ( mo_gf_esc_string( $gf_addon_enabled_type, 'attr' ) !== mo_gf_esc_string( $gf_type_phone, 'attr' ) ? 'style="display:none;"' : '' ) . ' class="mo_registration_help_desc" id="gf_contact_phone_instructions" >
											' . mogf_( 'Follow the following steps to enable phone Verification for Gravity form' ) . ':
											<ol>
												<li><a href="' . mo_gf_esc_string( $gf_field_list, 'url' ) . '" target="_blank">
												    ' . mogf_( 'Click Here' ) . '</a> ' . mogf_( ' to see your list of the Gravity Forms.' ) . '</li>
												<li>' . mogf_( 'Add an phone field to your existing form' ) . '</li>
												<li>' . mogf_( 'Set the Format of the Phone Field to <u>International only</u>.' ) . '</li>
												<li>' . mogf_( 'Add a text field with label <b>"Enter Validation Code"</b> in your existing form.' ) . '</li>
												<li>' . mogf_( 'Add the Form ID, Phone Field Label and Verification Field Label below' ) . ':<br>
												<br/>' . mogf_( 'Add Form' ) . ' : <input type="button"  value="+" ' . mo_gf_esc_string( $disabled, 'attr' ) . '
												                                            onclick="add_gravity(\'phone\',2);"
												                                            class="button button-primary"/>&nbsp;
                                                    <input  type="button" value="-" ' . mo_gf_esc_string( $disabled, 'attr' ) . '
                                                            onclick="remove_gravity(2);"
                                                            class="button button-primary" /><br/><br/>';

												$gf_form_results = get_multiple_form_select_gf(
													$gf_addon_otp_enabled,
													true,
													true,
													$disabled,
													2,
													'gravity',
													'Label'
												);
												$gfcounter2      = ! MoUtility::isBlank( $gf_form_results['counter'] ) ? max( $gf_form_results['counter'] - 1, 0 ) : 0;


												echo '</li>


												<li>' . mogf_( 'Click on the <b>Save Settings</b> Button to save your settings.' ) . '</li>
											</ol>

											<div style="margin-left:10px;">

											<p>
												<input  type="checkbox" ' . esc_attr( $disabled ) . '
														id="mogf_notif_enable"
														name="mo_customer_validation_mogf_customer_sms_notif_enable"
														value="1"
														' . esc_attr( $mogf_customer_sms_notif_enable ) . ' />
												<b>' . esc_html( mogf_( 'Enable SMS Notification on Submission of Form (Customers).' ) ) . '</b>
											</p>	
											<p style="margin-left:2%;">
												<i><b>' . mogf_( 'Customer SMS Template' ) . ':</b></i><br>
													<textarea   name="mo_customer_validation_mogf_sms_template" id="mogf_sms_template" class="mo-textarea"
														rows="2" 
														style="width:60%;"
														placeholder="' . esc_attr( mogf_( 'Enter the SMS Notification template send to Customers.' ) ) . '">' .
															esc_attr( $mogf_notif_template ) .
														'</textarea>
												</p>

											<p>
												<input  type="checkbox" ' . esc_attr( $disabled ) . '
														id="mogf_notif_enable"
														name="mo_customer_validation_mogf_admin_sms_notif_enable"
														value="1"
														' . esc_attr( $mogf_admin_sms_notif_enable ) . ' />
												<b>' . esc_html( mogf_( 'Enable SMS Notification on Submission of Form (Admin).' ) ) . '</b>
											</p>

												<p style="margin-left:2%;">
												<i><b>' . mogf_( 'Admin Phone Number' ) . ':</b></i>
												<span class="tooltip">
													<span class="dashicons dashicons-editor-help"></span>
													<span class="tooltiptext" style="background-color:lightgrey;color:#606060">
														<span class="header" style="color:black">Please enter the phone number with a country code. Example: +12xxxxxxxxx</span>
													</span>
												</span>
												<input  class="mo_registration_table_textbox"
														name="mo_customer_validation_gf_admin_phone_numbers"
														placeholder="Add semi-colon (;) in between two numbers"
														type="text" value="' . mo_gf_esc_string( $admin_phone_numbers, 'attr' ) . '">
												</p>

												<p style="margin-left:2%;">
												<i><b>' . mogf_( 'Admin SMS Template' ) . ':</b></i><br>
													<textarea   name="mo_customer_validation_mogf_admin_sms_template" id="mogf_admin_sms_template" class="mo-textarea"
														rows="2" 
														style="width:60%;"
														placeholder="' . esc_attr( mogf_( 'Enter the SMS Notification template send to the Admins.' ) ) . '">' .
															esc_attr( $mogf_admin_notif_template ) .
														'</textarea>
												</p>

											</div>
									</div>

									<p style="margin-left:2%;">
                                        <i><b>' . mogf_( 'Verification Button text' ) . ':</b></i>
                                        <input  class="mo_registration_table_textbox"
                                                name="mo_customer_validation_gf_addon_button_text"
                                                type="text" value="' . mo_gf_esc_string( $gf_addon_button_text, 'attr' ) . '">
                                    </p>
								</div>
							</div>';


												multiple_from_select_script_generator_gf( true, true, 'gravity', 'Label', array( $gfcounter1, $gfcounter2, 0 ) );
