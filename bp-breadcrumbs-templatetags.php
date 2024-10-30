<?php

class BP_Breadcrumb_Template {
	var $current_breadcrumb = -1;
	var $breadcrumb_count;
	var $breadcrumbs;
	var $breadcrumb;

	var $in_the_loop;

	var $sep;

	function bp_breadcrumb_template( $sep = '&nbsp;&rarr;&nbsp;' ) {
		global $bp;

		$this->breadcrumbs = $bp->breadcrumbs->crumbs;
		$this->breadcrumb_count = count( $this->breadcrumbs );

		$this->sep = $sep;
	}

	function has_breadcrumbs() {
		if ( $this->breadcrumb_count )
			return true;

		return false;
	}

	function next_breadcrumb() {
		$this->current_breadcrumb++;
		$this->breadcrumb = $this->breadcrumbs[$this->current_breadcrumb];

		return $this->breadcrumb;
	}

	function rewind_breadcrumbs() {
		$this->current_breadcrumb = -1;

		if ( $this->breadcrumb_count > 0 )
			$this->breadcrumb = $this->breadcrumbs[0];
	}

	function breadcrumbs() {
		if ( $this->current_breadcrumb + 1 < $this->breadcrumb_count ) {
			return true;
		} elseif ( $this->current_breadcrumb + 1 == $this->breadcrumb_count ) {
			do_action( 'loop_end' );
			$this->rewind_breadcrumbs();
		}

		$this->in_the_loop = false;
		return false;
	}

	function the_breadcrumb() {
		global $breadcrumb, $bp;

		$this->in_the_loop = true;
		$this->breadcrumb = $this->next_breadcrumb();

		/* Did loop just start */
		if ( 0 == $this->current_breadcrumb )
			do_action( 'loop_start' );
	}
}

/* Loop functions */
function bp_has_breadcrumbs( $args = '' ) {
	global $bp, $breadcrumbs_template;

	$defaults = array(
		'sep' => '&nbsp;&rarr;&nbsp;',
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$breadcrumbs_template = new BP_Breadcrumb_Template( $sep );
	return apply_filters( 'bp_breadcrumbs', $breadcrumbs_template->has_breadcrumbs(), &$breadcrumbs_template );
}

function bp_the_breadcrumb() {
	global $breadcrumbs_template;
	return $breadcrumbs_template->the_breadcrumb();
}

function bp_breadcrumbs() {
	global $breadcrumbs_template;
	return $breadcrumbs_template->breadcrumbs();
}

/* Individual entry functions */
function bp_breadcrumb_name() {
	echo bp_get_breadcrumb_name();
}
	function bp_get_breadcrumb_name() {
		global $breadcrumbs_template;

		return apply_filters( 'bp_get_breadcrumb_name', strip_tags( $breadcrumbs_template->breadcrumb->name ) );
	}

function bp_breadcrumb_url() {
	echo bp_get_breadcrumb_url();
}
	function bp_get_breadcrumb_url() {
		global $breadcrumbs_template;

		return apply_filters( 'bp_get_breadcrumb_url', esc_url( $breadcrumbs_template->breadcrumb->url ) );
	}

function bp_breadcrumb_desc() {
	echo bp_get_breadcrumb_desc();
}
	function bp_get_breadcrumb_desc() {
		global $breadcrumbs_template;

		return apply_filters( 'bp_get_breadcrumb_desc', strip_tags( $breadcrumbs_template->breadcrumb->desc ) );
	}

function bp_breadcrumb_parms() {
	echo bp_get_breadcrumb_parms();
}
	function bp_get_breadcrumb_parms() {
		global $breadcrumbs_template;

		return apply_filters( 'bp_get_breadcrumb_parms', $breadcrumbs_template->breadcrumb->parms );
	}

function bp_breadcrumb_img() {
	echo bp_get_breadcrumb_img();
}
	function bp_get_breadcrumb_img() {
		global $breadcrumbs_template;

		return apply_filters( 'bp_get_breadcrumb_img', $breadcrumbs_template->breadcrumb->img );
	}

function bp_breadcrumb_separator() {
	echo bp_get_breadcrumb_separator();
}
	function bp_get_breadcrumb_separator() {
		global $breadcrumbs_template;

		if ( $breadcrumbs_template->current_breadcrumb < $breadcrumbs_template->breadcrumb_count -1 )
			return apply_filters( 'bp_get_breadcrumb_separator', $breadcrumbs_template->sep );
	}

/* Use this in your template to display the breadcrumb trail.
 * You can also copy and past this into a custom function or
 * put a modified version of this code directly in your template.
 */
function bp_breadcrumb_display( $sep = '' ) {
?>
			<div class="breadcrumb-wrapper">
<?php if ( bp_has_breadcrumbs( array( 'sep' => $sep ) ) ) : ?>
				<ul class="breadcrumb-list">
<?php while ( bp_breadcrumbs() ) : bp_the_breadcrumb(); ?>
					<li class="breadcrumb"><a href="<?php bp_breadcrumb_url() ?>" class="breadcrumb-link"><?php bp_breadcrumb_name(); ?></a><?php bp_breadcrumb_separator() ?></li>
<?php endwhile; ?>
				</ul>
<?php endif; ?>
			</div>
<?php
}

/* Add item to breadcrumb trail */
function bp_breadcrumbs_add( $name, $url, $desc = '', $parms = '', $img = '' ) {
	global $bp;

	$bp->breadcrumbs->add( $name, $url, $desc = '', $parms = '', $img = '' );
}

?>