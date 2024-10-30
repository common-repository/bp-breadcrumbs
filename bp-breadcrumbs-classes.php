<?php

/* Simple breadcrumb trail class for BuddyPress */
class BP_Breadcrumbs {
	var $crumbs = array();

	function init() {
		// Run action on plugin activation
		register_activation_hook( __FILE__,	array( 'BP_Breadcrumbs', 'install' ) );

		// Localization
		add_action ( 'plugins_loaded',		array( 'BP_Breadcrumbs', 'load_textdomain' ), 10 );

		// Setup BuddyPress Globals
		add_action ( 'bp_setup_globals',	array( 'BP_Breadcrumbs', 'setup_globals' ), 11 );

		// Setup BuddyPress Navigation
		add_action ( 'bp_setup_nav',		array( 'BP_Breadcrumbs', 'setup_nav' ), 11 );

		// Admin check
		if ( is_admin() )
			add_action ( 'admin_menu',		array( 'BP_Breadcrumbs', 'check_installed' ), 2 );

	}

	function install() { }

	function load_textdomain() { }

	function setup_globals() {
		global $bp;

		// For internal identification
		$bp->breadcrumbs->id = 'breadcrumbs';

		// For internal identification
		$bp->breadcrumbs->slug = BP_BREADCRUMB_SLUG;

		// Register this in the active components array
		$bp->active_components[$bp->breadcrumbs->slug] = $bp->breadcrumbs->id;

		$bp->breadcrumbs = new BP_Breadcrumbs();

		do_action( 'bp_breadcrumbs_setup_globals' );
	}

	function setup_nav() { }

	function check_installed() { }

	/* Setup breadcrumb */
	function bp_breadcrumbs( $root = true ) {
		$this->clear( $root );
	}

	/* Clear contents of breadcrumb and set home link */
	function clear( $add_root ) {

		$this->crumbs = array();

		if ( true === $add_root )
			$this->add( apply_filters( 'bp_breadcrumbs_root', __( 'Home' ) ), bp_get_root_domain(), (string)get_site_option( 'name' ), '', get_bloginfo( 'template_directory' ) . '/favicon.ico' );

	}

	/* Add an item to the breadcrumb */
	function add( $name, $url, $desc = '', $parms = '', $img = '' ) {
		$this->crumbs[] = new BP_Breadcrumbs_Breadcrumb(  '', $name, $url, $desc, $parms, $img );
	}
}

/* Class for individual breadcrumb in trail */
class BP_Breadcrumbs_Breadcrumb {
	var $id;

	var $name;
	var $url;
	var $desc;
	var $parms;
	var $img;

	/* Create new breadcrumb entry in array */
	function bp_breadcrumbs_breadcrumb( $id = '', $name = '', $url = '', $desc = '', $parms = '', $img = '' ) {
		if ( is_numeric( $id ) ) {
			$this->id = $id;
			$this->populate( $this->id );
		} else {
			$this->add( $name, $url, $desc, $parms, $img );
		}
	}

	/* If populating, do so in a safe way */
	function populate( $id ) {
		global $bp;

		$this->name		= esc_html( $bp->breadcrumbs->crumbs[$id]->name );
		$this->desc		= esc_html( $bp->breadcrumbs->crumbs[$id]->desc );
		$this->url		= esc_url( $bp->breadcrumbs->crumbs[$id]->url );
		$this->img		= esc_url( $bp->breadcrumbs->crumbs[$id]->img );
		$this->parms	= $bp->breadcrumbs->crumbs[$id]->parms;
	}

	/* Add values to array in a safe way */
	function add( $name = '', $url = '', $desc = '', $parms = '', $img = '' ) {

		// Check each argument for errors
		if ( is_string( $name ) )
			$this->name		= esc_html( $name );

		if ( is_string( $desc ) )
			$this->desc		= esc_html( $desc );

		if ( is_string( $url ) )
			$this->url		= esc_url( $url );

		if ( is_string( $img ) )
			$this->img		= esc_url( $img );

		$this->parms	= $parms;
	}
}

?>
