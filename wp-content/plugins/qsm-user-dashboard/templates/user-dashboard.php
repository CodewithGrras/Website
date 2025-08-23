<?php
$previous_button = $next_button = "";
$upload_dir = wp_upload_dir();
if ( $result_page > 0 ) {
	$previous_page = $result_page - 2;
	$previous_button = '<a class="button" id="prev_page" href="?' . $admin_page . 'result_page=' . $previous_page . '">' . $options['previous_button_text'] . '</a> ';
	if ( $results_remaining > $table_limit ) {
		$next_button = '<a class="button" id="next_page" href="?' . $admin_page . 'result_page=' . $result_page . '">' . $options['next_button_text'] . '</a> ';
	}
} elseif ( 0 === $result_page ) {
	if ( $results_remaining > $table_limit ) {
		$next_button = '<a class="button" id="next_page" href="?' . $admin_page . 'result_page=' . $result_page . '">' . $options['next_button_text'] . '</a> ';
	}
} elseif ( $results_remaining < $table_limit ) {
	$previous_page = $results_remaining - 2;
	$previous_button = '<a class="button" id="prev_page" href="?' . $admin_page . 'result_page=' . $previous_page . '">' . $options['previous_button_text'] . '</a> ';
}
?>
<div class="user-dashboard-pagination">
	<span class="previous-button"><?php echo $previous_button; ?></span>
	<span class="next-button"><?php echo $next_button; ?></span>
</div>
<table class="widefat user-dashboard-list">
	<thead>
		<tr>
			<?php foreach ( $options['dashboard_options_order'] as $dashboard_option ) : ?>
				<?php if ( 'view_text' === $dashboard_option && 1 === intval($options[ $dashboard_option.'_check' ]) ) { ?>			
					<th><?php echo __( $options['view_header_text'], 'qsm-user-dashboard' ); ?></th>
				<?php } elseif ( 'quiz_certificate_link' == $dashboard_option && 1 === intval($options[ $dashboard_option.'_check' ]) ) { ?>			
					<th><?php echo __( $options['quiz_certificate_link_header_text'], 'qsm-user-dashboard' ); ?></th>
				<?php } elseif ( isset( $options[ $dashboard_option.'_check' ] ) && 1 === intval($options[ $dashboard_option.'_check' ]) ) { ?>			
					<th><?php echo __( $options[ $dashboard_option . '_text' ], 'qsm-user-dashboard' ); ?></th>
				<?php } ?>
			<?php endforeach; ?>			
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $user_results as $result ) {
			$mlw_qmn_results_array = @unserialize($result->quiz_results);
			?>
			<tr class="alternate">
				<?php
				foreach ( $options['dashboard_options_order'] as $dashboard_option ) {
					if ( isset( $options[ $dashboard_option.'_check' ] ) && 1 === intval($options[ $dashboard_option.'_check' ]) ) {
						if ( 'quiz_time_to_complete' === $dashboard_option ) {
							echo call_user_func( 'display_'.$dashboard_option, $mlw_qmn_results_array, $result, $options );
						} elseif ( 'quiz_certificate_link' === $dashboard_option ) {
							echo call_user_func( 'display_'.$dashboard_option, $upload_dir, $mlw_qmn_results_array, $result, $options );
						} else {
							echo call_user_func( 'display_'.$dashboard_option, $result, $options );
						}
					}
				}
				?>							
			</tr>
			<?php
		}
		?>
	</tbody>
</table>