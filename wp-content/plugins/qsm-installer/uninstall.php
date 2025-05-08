<?php
/**
 * This file handles the uninstall process of the addon.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Delete any options you have created with the addon.

