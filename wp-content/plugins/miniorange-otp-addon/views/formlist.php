<?php

use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoMessages;

$className = "YourOwnForm";
$className =  $className."#".$className;
// $link = $action;
// $link = str_replace("form","page=mosettings&form",$link);
$request_uri = $_SERVER['REQUEST_URI'];
$url = add_query_arg(
                        ['page' => "mosettings",'form' => $className],
                        $request_uri
                    );

echo'			<div class=""';
                     echo mo_gf_esc_string($formName,"attr") ? "hidden" : "";
echo'		         id="form_search">
					<table style="width:100%">
						<tr>
							<td colspan="2">
								<h2 style="display:none;">
								    '.mogf_("SELECT YOUR FORM FROM THE LIST BELOW").':';
echo'							    
							        <span style="float:right;margin-top:-10px;">
							            <a  class="show_configured_forms button button-primary button-large" 
                                            href="'.mo_gf_esc_string($action,"url").'">
                                            '.mogf_("Show All Enabled Forms").'
                                        </a>
                                        <span   class="mo-dashicons dashicons dashicons-arrow-up toggle-div" 
                                                data-show="false" 
                                                data-toggle="modropdown"></span>
                                    </span>
                                </h2> ' ;
                    echo   '<b><font color="#0085ba"><a style = "text-decoration: none; display:none;" href="'.mo_gf_esc_string($url,"url").'" data-form="YourOwnForm#YourOwnForm">Not able to find your form.</a></font></b>';
// echo                                     '<span class="tooltip">
//                                                 <span class="dashicons dashicons-editor-help"></span>
//                                                 <span class="tooltiptext">
//                                                     <span class="header"><b><i>'.mo_gf_esc_string(MoMessages::showMessage(MoMessages::FORM_NOT_AVAIL_HEAD),"attr").'</i></b></span><br/><br/>
//                                                     <span class="body">We are actively adding support for more forms. Please contact us using the support form on your right or email us at <a onClick="otpSupportOnClick();""><font color="white"><u>'.mo_gf_esc_string(MoConstants::FEEDBACK_EMAIL,"attr").'</u>.</font></a> While contacting us please include enough information about your registration form and how you intend to use this plugin. We will respond promptly.</span>
//                                                 </span>
//                                               </span>';

echo							'</td>
						</tr>
						<tr>
							<td colspan="2">';
                           get_otp_verification_form_dropdown_gf();
echo'							
							</td>
						</tr>
					</table>
				</div>';