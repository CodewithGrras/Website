<?php

echo '<div class="mo_registration_table_layout px-mo-4" id="selected_form_details">
			<div class="flex gap-mo-4 m-mo-4" id="mo_forms">
			<p class="text-lg flex-1 font-medium pr-mo-44 my-mo-1">
                           Gravity Contact Form:
                        </p>
					<span>
							<input  name="save" id="ov_settings_button" ' . mo_gf_esc_string( $disabled, 'attr' ) . ' 
									class="mo-button medium inverted" 
									value="' . esc_attr( mogf_( 'Save Settings' ) ) . '" type="submit" />
					</span>
				</div>

				<div id="new_form_settings">
					<div id="form_details">';
						require $controller . 'forms/GravityForm.php';
	echo '          </div>
				</div>

				
		</div>';
