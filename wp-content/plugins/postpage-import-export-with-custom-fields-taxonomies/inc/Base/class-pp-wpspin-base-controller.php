<?php
/**
 * Base Controller Class.
 *
 * @package wpx-pp-import-export\Base
 */

namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base Controller for Post/Page import/export with custom fields & taxonomies classes.
 */
class PP_IMPORT_EXPORT_WPSPIN_Base_Controller {

	/**
	 * Post/Page import/export with custom fields & taxonomies plugin path.
	 *
	 * @var $plugin_path
	 */
	public $plugin_path;

	/**
	 * Post/Page import/export with custom fields & taxonomies plugin url.
	 *
	 * @var $plugin_url
	 */
	public $plugin_url;

	/**
	 * Post/Page import/export with custom fields & taxonomies plugin file path.
	 *
	 * @var $plugin
	 */
	public $plugin;

	/**
	 * Set plugin main variables.
	 */
	public function __construct() {
		$this->plugin_path = PP_IMPORT_EXPORT_WPSPIN_PATH;
		$this->plugin_url  = plugin_dir_url( PP_IMPORT_EXPORT_WPSPIN_PATH . '/wpx-pp-import-export' );
		$this->plugin      = PP_IMPORT_EXPORT_WPSPIN_PATH . '/wpx-pp-import-export.php';
		add_filter( 'page_row_actions', array($this, '_pp_wpspin_export_row_actions'), 10, 2 );
		add_filter( 'post_row_actions', array($this, '_pp_wpspin_export_row_actions'), 10, 2 );
		add_action('admin_notices', array($this, '_pp_wpspin_import_button'));
	}

	/*
	 * export post/page data
	 */
	public function _pp_wpspin_import_button() {
		add_thickbox();
		/*
		- The modal will have input field to enter the new post title
		- and file input to upload the file
		- Save & Close button - Close button
		*/
		?>
		<div id="pp_wpspin_import" style="display:none;">
			<form action="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>" method="post" enctype="multipart/form-data" id="pp_wpspin_import_form">
				<?php wp_nonce_field('pp_wpspin_import', 'pp_wpspin_import_nonce'); ?>
				<h2>Import</h2>
				<div style="margin-bottom:15px">
					<label for="pp_wpspin_import_title">Enter the title of the new post</label><br>
					<input type="text" name="pp_wpspin_import_title" id="pp_wpspin_import_title" class="pp_wpspin_import_title">
				</div>
				<div>
					<label for="pp_wpspin_json_file">Choose a JSON file to upload</label><br>
					<input type="hidden" name="action" value="pp_wpspin_import" />
					<input type="file" name="pp_wpspin_json_file" accept="application/JSON" class="pp_wpspin_json_file">
				</div>
				<div style="position:absolute; bottom:10px; left:10px;">
					<input type="submit" value="Save & Close" class="button-primary">
					<input type="button" value="Cancel" onclick="tb_remove();" class="button-secondary">
				</div>
			</form>
		</div>

		<?php
	}


	/**
	 * Meta box callback function
	 */
	public function _pp_wpspin_export_button( $post ) {
		$post_id = $post->ID;
		$export_url = admin_url( 'admin.php?action=export_post&id=' . $post->ID ); // Adjust the URL as needed.

		printf(
			"<div class='pp_wpspin_download_box_wrap'>
			<a href='%s'>Export Data</a>
            </div>",
			esc_url( $export_url )
		);

	}


	/**
	 * Callback function for the page_row_actions filter
	 */
	public function _pp_wpspin_export_row_actions( $actions, $post ) {
		// Add the "Export" link.
		$export_url = admin_url( 'admin.php?action=export_post&id=' . $post->ID ); // Adjust the URL as needed.
		$actions['export'] = '<a href="' . esc_url( $export_url ) . '">Export</a>';

		// Check if it's the desired post type (e.g., 'post' or 'page').
		// if ( 'page' === $post->post_type ) {
			
		// }

		return $actions;
	}
	

}
