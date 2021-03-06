<?php

$menu_classes = 'fl-menu';

if ( $settings->collapse ) {
	$menu_classes .= ' fl-menu-accordion-collapse';
}
if ( $settings->mobile_breakpoint && 'expanded' != $settings->mobile_toggle ) {
	$menu_classes .= ' fl-menu-responsive-toggle-'. $settings->mobile_breakpoint;
}
?>
<div class="<?php echo $menu_classes; ?>">
	<?php $module->render_toggle_button(); ?>
	<div class="fl-clear"></div>
	<?php 

		if( !empty( $settings->menu ) ){
	
			if( isset( $settings->menu_layout ) ){
				if( in_array( $settings->menu_layout, array( 'vertical', 'horizontal' ) ) && isset( $settings->submenu_hover_toggle ) ){
					$toggle = ' fl-toggle-'. $settings->submenu_hover_toggle;
				} elseif ( $settings->menu_layout == 'accordion' && isset( $settings->submenu_click_toggle ) ){
					$toggle = ' fl-toggle-'. $settings->submenu_click_toggle;
				} else {
					$toggle = ' fl-toggle-arrows';
				}
			} else {
				$toggle = ' fl-toggle-arrows';
			}

			$layout = isset( $settings->menu_layout ) ? 'fl-menu-'. $settings->menu_layout : 'fl-menu-horizontal';
	
			$defaults = array(
				'menu'			=> $settings->menu,
				'container'		=> false,
				'menu_class'	=> 'menu '. $layout . $toggle,
				'walker'		=> new FL_Menu_Module_Walker(),
			);
	
			wp_nav_menu( $defaults );
		}
	?>
</div>