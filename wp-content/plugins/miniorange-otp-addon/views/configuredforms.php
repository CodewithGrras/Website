<?php

echo    '<div class="mo_registration_table_layout"';
                echo !$showConfiguredForms ? "hidden" : "";
echo'          id="configured_forms">
                <table style="width:100%">
                    <tr>
                        <td>
                            <h2>
                                <i>'.mogf_("CONFIGURED FORMS").'</i>
                                <span style="float:right;margin-top:-10px;">
                                    <!--<a class="show_form_list button button-primary button-large" style=""
                                        href="'.mo_gf_esc_string($formsListPage,"url").'">
                                        '.mogf_("Back").'
                                    </a>-->
                                    <input  name="save" id="ov_settings_button_config" 
                                            class="button button-primary button-large" '.mo_gf_esc_string($disabled,"attr").' 
                                            value="'.mogf_("Save Settings").'" type="submit">
                                    <span   class="mo-dashicons dashicons dashicons-arrow-up toggle-div" 
                                            data-show="false" 
                                            data-toggle="configured_mo_forms">                                                
                                    </span>
                                </span>	
                            </h2><hr>
                        </td>
                    </tr>
                </table>
                <div id="configured_mo_forms">';
                    //include $controller . 'forms/GravityForm' . '.php';
                    show_configured_form_details_gf($controller,$disabled,$page_list);
    echo'				</div>
            </div>';