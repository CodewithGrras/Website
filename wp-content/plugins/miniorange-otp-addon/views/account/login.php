<?php		

echo'	<form name="f" method="post" action="">';
            wp_nonce_field($nonce);
echo'		<input type="hidden" name="option" value="mogf_registration_connect_verify_customer" />
			<div class="mo_registration_divided_layout mo-otp-full">
				<div class="mo_registration_table_layout mo-otp-center">
					<h2>
					    '.mogf_("LOGIN WITH MINIORANGE").'
					    <span style="float:right;margin-top:-10px;">
                            <a href="#goBackButton" class="mo-button secondary">Go back to Registration Page</a>
                        </span>
                    </h2>
					<hr>
					<p>
					    <b>
					        '.mogf_("It seems you already have an account with miniOrange. Please enter your miniOrange email and password.").'
					    </b>
					</p>
					<table class="mo_registration_settings_table">
						<tr>
							<td><b><font color="#FF0000">*</font>'.mogf_("Email:").'</b></td>
							<td><input class="mo_registration_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="'.mo_gf_esc_string($admin_email,"attr").'" /></td>
						</tr>
						<tr>
							<td><b><font color="#FF0000">*</font>'.mogf_("Password:").'</b></td>
							<td><input class="mo_registration_table_textbox" required type="password"
								name="password" placeholder="'.mogf_("Enter your miniOrange password").'" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
							    <input type="submit" class="button button-large" style="width:23%;" value="Login"/>
								<a href="#forgot_password" class="button button-secondary button-large">Forgot Password</a>
						</tr>
					</table>
				</div>
			</div>
		</form>
		<form id="forgotpasswordform" method="post" action="">';
			wp_nonce_field( $nonce ); 	
echo'		<input type="hidden" name="option" value="mogf_registration_forgot_password" />
		</form>
		<form id="goBacktoRegistrationPage" method="post" action="">';
			wp_nonce_field( $nonce ); 	
echo'		<input type="hidden" name="option" value="mogf_registration_go_back" />
		</form>
		<script>
			jQuery(document).ready(function(){
				$mo(\'a[href="#forgot_password"]\').click(function(){
					$mo("#forgotpasswordform").submit();
				});

				$mo(\'a[href="#goBackButton"]\').click(function(){
					$mo("#goBacktoRegistrationPage").submit();
				});
			});
		</script>';