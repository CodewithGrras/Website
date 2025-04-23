<?php

use GFOTP\Helper\MoMessages;

echo'	<div class="mo_registration_divided_layout">
			<form name="f" method="post" action="'.mo_gf_esc_string($action,"url").'" id="mo_otp_verification_settings">
			    <input type="hidden" id="error_message" name="error_message" value="">
				<input type="hidden" name="option" value="mogf_customer_validation_settings" />';

					wp_nonce_field( $nonce );
                  
                    if($formName && !$showConfiguredForms) {
                        include MOV_GF_DIR . 'views/formsettings.php';
                    } 
echo'		</form>
		</div>';