<?php
use GFOTP\Helper\GravityFormList;
use GFOTP\Objects\TabDetails;
use GFOTP\Objects\Tabs;

echo '	
<!-- Title Bar -->
		<div id="otp_addon_tab_content" class="wrap">
		<div class="mo-section-header">
			<div><img style="float:left;" src="' . MOV_GF_LOGO_URL . '"></div>
					<h5 class="text-lg font-bold" style="flex: 1 1 0%;">' . esc_html( mogf_( 'Gravity Form OTP Verification' ) ) . '</h5>';
				echo '  

				<div id="mogf_account_sections" class="flex">
                <a class="mo-button secondary" style="margin:5px;" id="gfaccountButton" href="' . mo_gf_esc_string( $profile_url, 'url' ) . '">' . mogf_( 'Account' ) . '</a>';

echo '
        </div>
	        <div class="mo-otp-help-button static">';
			if ( $is_logged_in && $is_free_plugin ) {
				echo '
						<div class="flex text-white text-xs">
							<div id="mogf_check_transactions" class="mo-transaction-show ' . esc_attr( $active_class ) . '">
								Email:' . esc_attr( $remaining_email ) . '  |  SMS: ' . esc_attr( $remaining_sms ) . '		
								<button class="mo-refresh-btn ' . esc_attr( $active_class ) . '">
									<svg width="18" height="18" viewBox="0 0 512 512">
										<path d="M320,146s24.36-12-64-12A160,160,0,1,0,416,294" style="fill:none;stroke:#000;stroke-linecap:square;stroke-miterlimit:10;stroke-width:32px"/>
										<polyline points="256 58 336 138 256 218" style="fill:none;stroke:#000;stroke-linecap:square;stroke-miterlimit:10;stroke-width:32px"/>
									</svg>
								</button>
							</div>
							<div> 
								<a href="' . esc_url( MOV_PORTAL ) . '/initializePayment?requestOrigin=wp_otp_verification_basic_plan" target="_blank" type="button" class="mo-button recharge">Recharge</a>
							</div>
						</div>';
			}
			echo '
        </div>
    </div>
	<form id="mogf_check_transactions_form" style="display:none;" action="" method="post">';

			wp_nonce_field( 'mogf_check_transactions_form', '_nonce' );
echo '<input type="hidden" name="option" value="mogf_check_transactions" />
        </form></div>';
		
			echo '    
        </div>';

echo '	<div id="tab">
			<h2 class="nav-tab-wrapper">';

			$count       = 0;
			$formHandler = GravityFormList::instance();
			$tabDetails  = TabDetails::instance();
			$request_uri = $_SERVER['REQUEST_URI'];
foreach ( $formHandler->getList() as $key => $form ) {

			$count++;
			$className = get_mo_gf_class( $form );
			$className = $form->isFormEnabled() ? $className : $className . '#' . $className;
			$url       = add_query_arg(
				array(
					'page' => $tabDetails->_tabDetails[ Tabs::FORMS ]->_menuSlug,
					'form' => $className,
				),
				$request_uri
			);
}

foreach ( $tabDetails->_tabDetails as $tabs ) {
	if ( $tabs->_showInNav ) {
		echo '<a  class="nav-tab 
                        ' . ( $active_tab === $tabs->_menuSlug ? 'nav-tab-active' : '' ) . '" 
                        href="' . $url . '"
                        style="' . $tabs->_css . '"
                        id="' . $tabs->_id . '">
                        ' . $tabs->_tabName . '
                    </a>';
	}
	if ( $tabs->_tabName == 'Forms' ) {
		break;
	}
}

		echo '</h2>';

if ( ! $registered ) {
	echo '<div  style="width: 96%;margin-left: 1px;background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . $registerMsg . '</h2>
                  </div>';
} elseif ( ! $activated ) {
	echo '<div  style="background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . $activationMsg . '</h2>
                  </div>';
} elseif ( ! $gatewayconfigured ) {
	echo '<div  style="background-color:rgba(255,5,0,0.29);font-size:0.9em;" 
                        class="notice notice-error">
                        <h2>' . $gatewayMsg . '</h2>
                  </div>';
}
