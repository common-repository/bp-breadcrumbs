<?php

/**
 * BP_Breadcrumbs_Admin
 *
 * Loads plugin admin area
 */
class BP_Breadcrumbs_Admin {

	/**
	 * init()
	 *
	 * Load up the plugin
	 *
	 * @uses do_action
	 */
	function init () {
		/**
		 * For developers:
		 * ---------------------
		 * If you want to make sure your code is loaded after this plugin
		 * have your code load on this action
		 */
		do_action ( 'bp_breadcrumbs_admin_init' );
	}
}

?>
