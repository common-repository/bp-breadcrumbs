<?php
/*
Plugin Name: BP Breadcrumbs
Plugin URI: http://buddypress.org/download/
Description: This will add breadcrumb trail navigation to a BuddyPress installation
Author: John James Jacoby
Version: 1.1
Author URI: http://buddypress.org/developers/
Site Wide Only: true
Tags: buddypress, breadcrumb, api
*/


/**
 * BP_Breadcrumbs_Init
 *
 * Loads plugin
 */
class BP_Breadcrumbs_Init {

	/**
	 * init()
	 *
	 * Load up the plugin
	 *
	 * @uses do_action
	 */
	function init () {
		// Define all the constants
		BP_Breadcrumbs_Init::constants();

		// Include required files
		BP_Breadcrumbs_Init::includes();

		// Initialize site action hooks
		BP_Breadcrumbs::init();

		// Admin initialize
		if ( is_admin() )
			BP_Breadcrumbs_Admin::init();

		/**
		 * For developers:
		 * ---------------------
		 * If you want to make sure your code is loaded after this plugin
		 * have your code load on this action
		 */
		do_action ( 'bp_breadcrumbs_init' );
	}

	/**
	 * constants()
	 *
	 * Default component constants that can be overridden or filtered
	 */
	function constants () {

		if ( !defined( 'BP_BREADCRUMB_SLUG' ) )
			define( 'BP_BREADCRUMB_SLUG', 'breadcrumb' );

		// Allow external plugins to call additional actions
		do_action( 'bp_breadcrumb_constants' );
	}

	/**
	 * includes()
	 *
	 * Load required files
	 *
	 * @uses is_admin If in WordPress admin, load additional file
	 */
	function includes () {
		// Get required files
		require_once ( WP_PLUGIN_DIR . '/bp-breadcrumbs/bp-breadcrumbs-classes.php' );
		require_once ( WP_PLUGIN_DIR . '/bp-breadcrumbs/bp-breadcrumbs-templatetags.php' );

		// Quick admin check
		if ( is_admin() )
			require_once ( WP_PLUGIN_DIR . '/bp-breadcrumbs/bp-breadcrumbs-admin.php' );

		// Allow external plugins to call additional actions
		do_action( 'bp_breadcrumbs_includes' );
	}
}

// Do the ditty
if ( defined( 'BP_VERSION' ) || did_action( 'bp_include' ) )
	BP_Breadcrumbs_Init::init();
else
	add_action( 'bp_include', array( 'BP_Breadcrumbs_Init', 'init' ) );

?>
