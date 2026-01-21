<?php
if ( ! function_exists ( 'sktm_maintenance_register_settings' ) ) {
	function sktm_maintenance_register_settings() {

		register_setting( 'sktm_maintenance-settings-group', 'page_title' );
		register_setting( 'sktm_maintenance-settings-group', 'maintenancemode' );
		register_setting( 'sktm_maintenance-settings-group', 'heading' );
		register_setting( 'sktm_maintenance-settings-group', 'test-editor' );

		register_setting( 'sktm_maintenance-settings-group', 'site_title_color' );
		register_setting( 'sktm_maintenance-settings-group', 'site_title_font_size' );

		register_setting( 'sktm_maintenance-settings-group', 'heading_color' );
		register_setting( 'sktm_maintenance-settings-group', 'headingfont_size' );
		register_setting( 'sktm_maintenance-settings-group', 'description_color' );
		register_setting( 'sktm_maintenance-settings-group', 'descriptionfont_size' );

		register_setting( 'sktm_maintenance-settings-group', 'footer_text' );
		register_setting( 'sktm_maintenance-settings-group', 'footer_text_color' );
		register_setting( 'sktm_maintenance-settings-group', 'footer_textfont_size' );

		register_setting( 'sktm_maintenance-settings-group', 'custom_css' );
		register_setting( 'sktm_maintenance-settings-group', 'background_bodycss' );

		register_setting( 'sktm_maintenance-settings-group', 'background_overlay_bodycss' );
		register_setting( 'sktm_maintenance-settings-group', 'background_overlay_opc_bodycss' );

		register_setting( 'sktm_maintenance-settings-group', 'fontfamily' );

	

	
register_setting( 'sktm_maintenance-settings-group', 'logo_width' );
register_setting( 'sktm_maintenance-settings-group', 'logo_height' );
register_setting( 'sktm_maintenance-settings-group', 'header_logo' );
register_setting( 'sktm_maintenance-settings-group', 'header_back' );




	}
}