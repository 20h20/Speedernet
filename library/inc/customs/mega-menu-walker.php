<?php

/**
 * Mega Menu Walker
 *
 * Depth semantics in WordPress Walker:
 *   start_el / end_el  → depth = the ITEM's own depth  (0, 1, 2 …)
 *   start_lvl / end_lvl → depth = the PARENT item's depth
 *
 * So for the megamenu "Product" (depth 0):
 *   – start_lvl(depth=0) opens the main sub-menu <ul>        ← let parent handle
 *   – start_lvl(depth=1) opens sub-sub-menus for each sidebar item ← SUPPRESS
 *   – end_lvl(depth=1)   closes those sub-sub-menus           ← SUPPRESS
 *   – end_lvl(depth=0)   closes the main sub-menu <ul>        ← assemble mega-wrap here
 *
 * On mobile (< 1283px) the <ul class="sub-menu"> contains .mobile-item links
 * (with icon + sidebar-desc) that feed the existing panel slide-in system. A
 * .mobile-item with depth-2 children gets its own nested "menu-item-has-children"
 * sub-menu, opening a further panel with those children on click.
 *
 * On desktop (≥ 1283px) .mobile-item is hidden and .mega-wrap (with the
 * two-panel layout) is shown.
 *
 * Icon:        add CSS class "mega-icon--<name>" to the menu item in WP admin.
 * Description: enable via WP admin → Menus → Screen Options → Description.
 */
class CBO_Walker_Mega_Menu extends Walker_Nav_Menu {

	private $in_mega            = false;
	private $sidebar_html       = '';
	private $panels_html        = '';
	private $panel_idx          = 0;
	private $mobile_link_html   = '';
	private $mobile_children    = '';

	// ─── Level hooks ────────────────────────────────────────────────

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// depth=1 means a depth-1 sidebar item is opening its sub-sub-menu.
		// We buffer those items, so suppress the <ul> wrapper entirely.
		if ( $this->in_mega && 1 === $depth ) {
			return;
		}
		parent::start_lvl( $output, $depth, $args );
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $this->in_mega ) {
			// depth=1: closing a sidebar item's sub-sub-menu — was never opened.
			if ( 1 === $depth ) {
				return;
			}
			// depth=0: closing the main sub-menu of the megamenu trigger.
			// All sidebar items have been collected → inject mega-wrap now.
			if ( 0 === $depth ) {
				$output .= '<li class="mega-wrap">';
				$output .= '<div class="mega-container">';
				$output .= '<div class="mega-sidebar"><ul class="sidebar-list">' . $this->sidebar_html . '</ul></div>';
				$output .= '<div class="mega-panels">' . $this->panels_html . '</div>';
				$output .= '</div>';
				$output .= '</li>';
				$this->in_mega = false;
			}
		}
		parent::end_lvl( $output, $depth, $args );
	}

	// ─── Item hooks ─────────────────────────────────────────────────

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		// Detect megamenu trigger and reset buffers.
		if ( 0 === $depth && in_array( 'megamenu', $item->classes, true ) ) {
			$this->in_mega      = true;
			$this->sidebar_html = '';
			$this->panels_html  = '';
			$this->panel_idx    = 0;
			// Fall through → parent::start_el outputs the top-level <li><a>.
		}

		// ── Depth-1 sidebar item ─────────────────────────────────────
		if ( $this->in_mega && 1 === $depth ) {
			$title    = apply_filters( 'the_title', $item->title, $item->ID );
			$desc     = ! empty( $item->description ) ? $item->description : '';
			$href     = ! empty( $item->url ) ? $item->url : '#';
			$panel_id = 'mega-panel-' . absint( $item->ID );
			$active   = 0 === $this->panel_idx ? ' is-active' : '';

			$icon_class = '';
			foreach ( $item->classes as $class ) {
				if ( 0 === strpos( $class, 'mega-icon--' ) ) {
					$icon_class = ' ' . $class;
					break;
				}
			}

			// ACF image field (field: mega_menu_icon)
			$icon_image  = function_exists( 'get_field' ) ? get_field( 'mega_menu_icon', $item ) : null;
			$icon_img_html = '';
			if ( ! empty( $icon_image['url'] ) ) {
				$icon_img_html = '<img'
					. ' src="' . esc_url( $icon_image['sizes']['thumbnail'] ?? $icon_image['url'] ) . '"'
					. ' alt="' . esc_attr( $icon_image['alt'] ?? '' ) . '"'
					. ' width="44" height="44"'
					. ' decoding="async" loading="lazy"'
					. '>';
			}

			// Mobile fallback: link with icon + description, finalized in end_el()
			// once we know whether this item has depth-2 children (mega-panel items).
			$this->mobile_children = '';
			$this->mobile_link_html = '<a href="' . esc_url( $href ) . '">'
				. '<span class="sidebar-icon' . esc_attr( $icon_class ) . ( $icon_img_html ? ' has-image' : '' ) . '" aria-hidden="true">'
				. $icon_img_html
				. '</span>'
				. '<span class="sidebar-text">'
				. '<span class="sidebar-title">' . esc_html( $title ) . '</span>'
				. ( $desc ? '<span class="sidebar-desc">' . esc_html( $desc ) . '</span>' : '' )
				. '</span>'
				. '</a>';

			// Buffer sidebar item
			$this->sidebar_html .= '<li class="sidebar-item' . esc_attr( $active ) . '" data-panel="' . esc_attr( $panel_id ) . '">';
			$this->sidebar_html .= '<a href="' . esc_url( $href ) . '" class="sidebar-link">';
			$this->sidebar_html .= '<span class="sidebar-icon' . esc_attr( $icon_class ) . ( $icon_img_html ? ' has-image' : '' ) . '" aria-hidden="true">';
			$this->sidebar_html .= $icon_img_html;
			$this->sidebar_html .= '</span>';
			$this->sidebar_html .= '<div class="sidebar-text">';
			$this->sidebar_html .= '<span class="sidebar-title">' . esc_html( $title ) . '</span>';
			if ( $desc ) {
				$this->sidebar_html .= '<span class="sidebar-desc">' . esc_html( $desc ) . '</span>';
			}
			$this->sidebar_html .= '</div></a></li>';

			// Open a panel slot for this sidebar item
			$this->panels_html .= '<div class="mega-panel' . esc_attr( $active ) . '" id="' . esc_attr( $panel_id ) . '"><ul class="panel-list">';
			$this->panel_idx++;
			return; // mobile-item <li> is assembled and closed in end_el()
		}

		// ── Depth-2 panel link (buffered) ────────────────────────────
		if ( $this->in_mega && 2 === $depth ) {
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			$href  = ! empty( $item->url ) ? $item->url : '#';
			$this->panels_html .= '<li class="panel-item">';
			$this->panels_html .= '<a href="' . esc_url( $href ) . '">' . esc_html( $title ) . '</a>';
			$this->panels_html .= '</li>';

			// Mobile: same link, buffered into this sidebar item's own sub-menu panel.
			$this->mobile_children .= '<li class="menu-item">';
			$this->mobile_children .= '<a href="' . esc_url( $href ) . '">' . esc_html( $title ) . '</a>';
			$this->mobile_children .= '</li>';
			return;
		}

		parent::start_el( $output, $item, $depth, $args, $id );
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( $this->in_mega && 1 === $depth ) {
			$this->panels_html .= '</ul></div>'; // close panel

			// Mobile item: emitted here, once its depth-2 children (if any) are known.
			$has_children = '' !== $this->mobile_children;
			$classes      = 'mobile-item menu-item' . ( $has_children ? ' menu-item-has-children' : '' );
			$output      .= '<li class="' . esc_attr( $classes ) . '">';
			$output      .= $this->mobile_link_html;
			if ( $has_children ) {
				$output .= '<ul class="sub-menu">' . $this->mobile_children . '</ul>';
			}
			$output .= '</li>';
			return;
		}
		if ( $this->in_mega && 2 === $depth ) {
			return; // buffered in start_el
		}
		parent::end_el( $output, $item, $depth, $args );
	}
}