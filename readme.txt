=== BP Breadcrumbs ===
Contributors: johnjamesjacoby
Tags: buddypress, breadcrumb, trail
Requires at least: 3.0
Tested up to: 3.0.
Stable tag: 1.1

== Description ==

Adds a breadcrumb API to be used by BuddyPress installations.

== Installation ==

1. Upload all files to to the `/wp-content/plugins/bp-breadcrumb` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Call `bp_breadcrumbs_add( $name, $url, $desc, $parms, $img )` in places you want to add a breadcrumb

== Frequently Asked Questions ==

= Does this plugin automatically add breadcrumbs? =

No, but that is planned.

= Does this plugin check against existing slugs? =

No. It takes whatever `$url` you give it. This makes it fairly flexible for any BuddyPress installation with any component.

== Screenshots ==

1. None yet

== Changelog ==

= trunk =
* Original upload to trunk