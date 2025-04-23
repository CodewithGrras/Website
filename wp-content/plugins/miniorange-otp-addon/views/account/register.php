<?php
echo'<!--Register with miniOrange-->
	<form name="f" method="post" action="" id="register-form">';
        wp_nonce_field($nonce);
echo'	<input type="hidden" name="option" value="mogf_registration_register_customer" />
		<div class="mo_registration_divided_layout mo-otp-full">
			<div class="mo_registration_table_layout mo-otp-center">
				<h2>
				    '.mogf_("REGISTER WITH MINIORANGE").'
				    <span style="float:right;margin-top:-10px;">
                        <a href="#goToLoginPage" class="mo-button secondary">'.mogf_("Already Have an Account? Sign In").'</a>
                    </span>
                </h2>
                <hr>
				<p>
				    <div class="mo_idp_help_desc">
                        Register your email adress to enable OTP services. The plugin ships with <b><u><a onClick="otpSupportOnClick();"">10 free SMS and Email transactions</u></a>.</b><br/>
                    </div>
                </p>
				<table class="mo_registration_settings_table">
					<tr>
						<td><b><font color="#FF0000">*</font>'.mogf_("Email:").'</b></td>
						<td><input class="mo_registration_table_textbox" type="email" name="email"
							required placeholder="person@example.com"
							value="'.mo_gf_esc_string($current_user->user_email,"attr").'" /></td>
					</tr>

					<tr>
						<td><b><font color="#FF0000">*</font>'.mogf_("Website/Company Name:").'</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="company"
							required placeholder="'.mogf_("Enter your companyName").'"
							value="'.mo_gf_esc_string($_SERVER["SERVER_NAME"],"attr").'" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;'.mogf_("FirstName:").'</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="fname"
							placeholder="'.mogf_("Enter your First Name").'"
							value="'.mo_gf_esc_string($current_user->user_firstname,"attr").'" /></td>
						<td></td>
					</tr>

					<tr>
						<td><b>&nbsp;&nbsp;'.mogf_("LastName:").'</b></td>
						<td><input class="mo_registration_table_textbox" type="text" name="lname"
							placeholder="'.mogf_("Enter your Last Name").'"
							value="'.mo_gf_esc_string($current_user->user_lastname,"attr").'" /></td>
						<td></td>
					</tr>
					
					<tr>
						<td><b><font color="#FF0000">*</font>'.mogf_("Password:").'</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="password" placeholder="'.mogf_("Choose your password (Min. length 6)").'" /></td>
					</tr>
					<tr>
						<td><b><font color="#FF0000">*</font>'.mogf_("Confirm Password:").'</b></td>
						<td><input class="mo_registration_table_textbox" required type="password"
							name="confirmPassword" placeholder="'.mogf_("Confirm your password").'" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						    <br /><input type="submit" name="submit" value="'.mogf_("Register").'" style="width:50%;"
							class="mo-button medium inverted" />
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
	<form id="goToLoginPageForm" method="post" action="">';
        wp_nonce_field($nonce);
echo'	<input type="hidden" name="option" value="mogf_go_to_login_page" />
	</form>
	<script>
		jQuery(document).ready(function(){
			$mo(\'a[href="#forgot_password"]\').click(function(){
				$mo("#forgotpasswordform").submit();
			});

			$mo(\'a[href="#goToLoginPage"]\').click(function(){
				$mo("#goToLoginPageForm").submit();
			});
		});
	</script>';