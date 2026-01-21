<?php
/*
* Skt-Maintenance menu.
*/
if ( is_admin() ) {
    add_action( 'admin_menu', 'sktm_maintenance_mainmenu', 100 );
}
if ( ! function_exists ( 'sktm_maintenance_mainmenu' ) ) {
ob_start();

  function sktm_maintenance_mainmenu() {
    add_menu_page('SKT Maintenance Settings', 'SKT Maintenance', 'administrator', 'skt-maintenance-settings', 'sktm_maintenance_mainmenu_callback' ,'dashicons-universal-access-alt');
    add_action( 'admin_init', 'sktm_maintenance_register_settings' );
  }
}
if ( ! function_exists ( 'sktm_maintenance_mainmenu_callback' ) ) {
	function sktm_maintenance_mainmenu_callback(){
		global $wpdb;
		$mode = sanitize_text_field(wp_unslash ( isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '' ) );
  		
		$maintenancemode = get_option('maintenancemode');
		$page_title = esc_attr(get_option('page_title'));
		$testeditor =  get_option('test-editor');
		$site_title_color = esc_attr(get_option('site_title_color'));
		$site_title_font_size = esc_attr(get_option('site_title_font_size'));
		$heading_color = esc_attr(get_option('heading_color'));
		$headingfont_size = esc_attr(get_option('headingfont_size'));
		$description_color = esc_attr(get_option('description_color'));
		$descriptionfont_size = esc_attr(get_option('descriptionfont_size'));
		$footer_text = esc_attr(get_option('footer_text'));
		$footer_text_color = esc_attr(get_option('footer_text_color'));
		$footer_textfont_size = esc_attr(get_option('footer_textfont_size'));
		$custom_css = esc_attr(get_option('custom_css'));
		$background_bodycss = esc_attr(get_option('background_bodycss'));
		$background_overlay_bodycss = esc_attr(get_option('background_overlay_bodycss'));
		$background_overlay_opc_bodycss = esc_attr(get_option('background_overlay_opc_bodycss'));
		$logo_width = esc_attr(get_option('logo_width'));
		$logo_height = esc_attr(get_option('logo_height'));
    	include_once SKTM_MAINTENANCE_DIR . '/admin/google-fonts.php' ;
?>
<div class="wrap">
	<h1 class="skt-maintenance-title"><?php esc_attr_e('SKT Maintenance','skt-maintenance'); ?></h1>
	<div class="skt-maintenance-options-wrap">
		<form method="post" enctype="multipart/form-data" action="options.php">
			<?php settings_fields( 'sktm_maintenance-settings-group' ); ?>
    		<?php do_settings_sections( 'sktm_maintenance-settings-group' ); ?>
    		<h3 class="skt-maintenance-options-title"><?php esc_attr_e('General Options','skt-maintenance'); ?></h3>
    		<table class="skt-maintenance-options-table">
    			<tr>
    				<td><?php esc_attr_e('Maintenance Mode','skt-maintenance'); ?></td>
    				<td>
    				<select name="maintenancemode">
						<option value="0" <?php if($maintenancemode=="0"){echo "selected";}?>><?php esc_attr_e('Off','skt-maintenance');?></option>
						<option value="1" <?php if($maintenancemode=="1"){echo "selected";}?>><?php esc_attr_e('On','skt-maintenance');?></option>
					</select>
    				</td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Page Title','skt-maintenance'); ?></td>
    				<td><input type="text" class="" name="page_title" value="<?php echo esc_attr( get_option('page_title') ); ?>" placeholder="<?php esc_attr_e('Enter page title','skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Site Title Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="site_title_color" class="color-field"  value="<?php echo esc_html( $site_title_color ); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Site Title Font Size','skt-maintenance'); ?></td>
    				<td><input type="number" name="site_title_font_size" value="<?php echo esc_html( $site_title_font_size ); ?>" placeholder="<?php esc_attr_e('Enter site title font size without px','skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Headline','skt-maintenance'); ?></td>
    				<td><input type="text" name="heading" value="<?php echo esc_attr( get_option('heading') ); ?>" placeholder="<?php esc_attr_e('Enter headline','skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Headline Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="heading_color" class="color-field"  value="<?php echo esc_html( $heading_color ); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e( 'Headline Font Size', 'skt-maintenance' ); ?></td>
    				<td>
            		<input type="number" name="headingfont_size" value="<?php echo esc_html( $headingfont_size ); ?>" placeholder="<?php esc_attr_e('Enter headline font size without px','skt-maintenance'); ?>">
    				</td>
    			</tr>
    			<tr>
					<td><?php esc_attr_e( 'Logo', 'skt-maintenance' ); ?></td>
					<td>
						<?php
					    	if( get_option( 'header_logo' ) != '' ){
					    ?>
						<div class="skt-maintenance-image">
							<img class="header_logo" src="<?php echo esc_url(get_option('header_logo')); ?>">
						</div>
						<?php } ?>
				    	<input id="mylogoimage" class="header_logo_url" type="text" name="header_logo" style="width: 100%;" value="<?php echo esc_attr(get_option('header_logo')); ?>">
				    	<a href="#" class="header_logo_upload"><?php esc_attr_e('Upload Logo','skt-maintenance'); ?></a>
				    	<?php if(get_option('header_logo') !=''){ ?>
					    	<div class="header_logo_remove" onclick="document.getElementById('mylogoimage').value = ''"><?php esc_attr_e('Remove','skt-maintenance'); ?></div>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php esc_attr_e('Set Logo Width', 'skt-maintenance' ); ?></td>
					<td><input type="number" name="logo_width" value="<?php if($logo_width !=''){echo esc_html( $logo_width );} ?>" placeholder="<?php esc_attr_e('Enter logo width without px', 'skt-maintenance'); ?>"></td>
				</tr>
				<tr>
					<td><?php esc_attr_e('Set Logo Height', 'skt-maintenance' ); ?></td>
					<td><input type="number" name="logo_height" value="<?php if($logo_height !=''){echo esc_html( $logo_height );} ?>" placeholder="<?php esc_attr_e('Enter logo height without px','skt-maintenance'); ?>"></td>
				</tr>
    			<tr>
    				<td><?php esc_attr_e('Description','skt-maintenance'); ?></td>
    				<td>
					<?php
					$settings = array(
					    'wpautop' => true,
					    'media_buttons' =>  false,
					    'textarea_name' => 'test-editor',
					    'textarea_rows' => get_option('default_post_edit_rows', 10),
					    'tabindex' => '',
					    'editor_css' => '',
					    'editor_class' => '',
					    'teeny'               => false,
					    'dfw'                 => false,
					    '_content_editor_dfw' => false,
					    'quicktags'           => true,
					    'tinymce' => array(
					    'theme_advanced_buttons1' => 'bold,italic,underline' 
					    )
					);
					wp_editor( $testeditor, 'test-editor', $settings );
					?>
    				</td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Description Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="description_color" class="color-field"  value="<?php echo esc_html( $description_color ); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Description Font Size','skt-maintenance'); ?></td>
    				<td><input type="number" name="descriptionfont_size" value="<?php echo esc_html( $descriptionfont_size ); ?>" placeholder="<?php esc_attr_e('Enter description font size without px','skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Footer Text','skt-maintenance'); ?></td>
    				<td><input type="text" class="" name="footer_text" value="<?php echo esc_attr( get_option('footer_text') ); ?>" placeholder="<?php esc_attr_e('Enter footer text','skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Footer Text Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="footer_text_color" class="color-field" value="<?php echo esc_html( $footer_text_color ); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Footer Text Font Size','skt-maintenance'); ?></td>
    				<td><input type="number" name="footer_textfont_size" value="<?php echo esc_html( $footer_textfont_size ); ?>" placeholder="<?php esc_attr_e('Enter footer text font size without px', 'skt-maintenance'); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Font Family','skt-maintenance'); ?></td>
    				<td>
					<select name="fontfamily">
					    <?php foreach ( $family as $key => $value ) { ?>
					    <option <?php if ( esc_attr(get_option('fontfamily') == $value ) ) { ?> selected <?php } ?> value="<?php echo esc_html( $value ); ?>"><?php echo esc_html( $value ); ?></option>
					    <?php } ?>
					    </select>
    				</td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Background Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="background_bodycss" class="color-field" value="<?php echo esc_html( $background_bodycss ); ?>"></td>
    			</tr>
    			<tr>
					<td><?php esc_attr_e('Background Image','skt-maintenance'); ?></td>
					<td>
						<?php
			    			if(get_option('header_back') !=''){
					    ?>
						    <div class="skt-maintenance-image">
						    	<img class="header_back" src="<?php echo esc_url(get_option('header_back')); ?>"/>
						    </div>
						<?php } ?>
					    <input class="header_back_url" type="text" name="header_back" style="width: 100%;" id="mybackgroundimage" value="<?php echo esc_attr(get_option('header_back')); ?>">
					    <a href="#" class="header_back_upload"><?php esc_attr_e('Upload Image','skt-maintenance'); ?></a>
					    <?php
					    	if(get_option('header_back') !=''){
					    ?>
					    	<div class="header_back_remove" onclick="document.getElementById('mybackgroundimage').value = ''"><?php esc_attr_e('Remove','skt-maintenance'); ?></div>
						<?php } ?>
					</td>
				</tr>
    			<tr>
    				<td><?php esc_attr_e('Background Overlay Color','skt-maintenance'); ?></td>
    				<td><input type="text" name="background_overlay_bodycss" class="color-field" value="<?php echo esc_html( $background_overlay_bodycss ); ?>"></td>
    			</tr>
    			<tr>
    				<td><?php esc_attr_e('Background Overlay Opacity','skt-maintenance'); ?></td>
    				<td><input type="number" min="0" max="1" step=".1" name="background_overlay_opc_bodycss" value="<?php echo esc_html( $background_overlay_opc_bodycss ); ?>" placeholder="<?php esc_attr_e('Enter background overlay opacity from 0 to 1','skt-maintenance'); ?>"></td>
    			</tr>
				<tr>
    				<td><?php esc_attr_e('Custom CSS','skt-maintenance'); ?></td>
    				<td><textarea name="custom_css"><?php if($custom_css !=''){echo esc_html( $custom_css );}?></textarea></td>
    			</tr>
    		</table>
    		<?php submit_button(); ?>
		</form>
	</div>
<?php
  	$sktm_maintenance_excludepage = $wpdb->prefix . 'skt_maintenance_excludepage';
  	$select_maintenancemodeexcludepage = $wpdb->get_results( "SELECT* FROM $sktm_maintenance_excludepage" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
  	$countrecord = $wpdb->num_rows;

  	if ( !isset( $_POST['add_excludepage'] ) || !wp_verify_nonce($_POST['add_excludepage'], 'excludepage_nonce' ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
     } else {
	  	if ( $mode== "excludepage" ) {
	  		$exclude_page_id= implode(',',sktm_maintenance_sanitize_option_field($_POST['exclude_page_id'])); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	  		$exclude_post_id = implode(',',sktm_maintenance_sanitize_option_field($_POST['exclude_post_id'])); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	  		if( $countrecord == '0' ){
	  			$insert_query = $wpdb->query("INSERT INTO $sktm_maintenance_excludepage(exclude_page_id,exclude_post_id)values ('$exclude_page_id','$exclude_post_id')"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	  		}else{  			
				$update_query = $wpdb->query("UPDATE $sktm_maintenance_excludepage SET exclude_page_id='$exclude_page_id',exclude_post_id='$exclude_post_id' WHERE ID=1"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	  		}
	  	}
	}

	$select_exclidepage = $wpdb->get_row("SELECT* FROM $sktm_maintenance_excludepage WHERE ID='1'"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery,  WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	if ( $select_exclidepage ) {
		$exclude_page_id = $select_exclidepage->exclude_page_id;
		$explode_page_id = explode(',', $exclude_page_id);
		$exclude_post_id = $select_exclidepage->exclude_post_id;
		$explode_post_id = explode(',', $exclude_post_id);
	} else {
		$exclude_page_id = "";
		$explode_page_id = "";

		$exclude_post_id ="";
		$explode_post_id ="";
	}
?>
		<div class="skt-maintenance-options-wrap">
			<form method="post" enctype="multipart/form-data">
				<h3 class="skt-maintenance-options-title"><?php esc_attr_e('Exclude Posts/Pages From Maintenance Mode','skt-maintenance'); ?></h3>
				<table class="skt-maintenance-options-table">
					<tr>
						<td><?php esc_attr_e('Exclude Pages','skt-maintenance'); ?></td>
						<td>
						<select name="exclude_page_id[]" multiple required="">
							<option value=""><?php esc_attr_e('None','skt-maintenance');?></option>
							<?php
		                    $exludepage = get_pages(); 
		                    foreach ( $exludepage as $exlude_page ) { 
		                    $exlude_pagestitle = $exlude_page->post_title;
		                    $exlude_pagesid = $exlude_page->ID;
		                    ?>
		                    <option value="<?php echo esc_html( $exlude_pagesid ); ?>" <?php if (in_array($exlude_pagesid, $explode_page_id)){echo "selected";}?>><?php echo esc_html( $exlude_pagestitle ); ?></option>
		                    <?php } ?>
	                	</select>
						</td>
					</tr>
					<tr>
						<td><?php esc_attr_e('Exclude Posts','skt-maintenance'); ?></td>
						<td>
						<select name="exclude_post_id[]" multiple required="">
							<option value=""><?php esc_attr_e('None','skt-maintenance');?></option>
							<?php
		                    $exludepost = get_posts($args = null); 
		                    foreach ($exludepost as $exlude_post) { 
		                    $exlude_poststitle = $exlude_post->post_title;
		                    $exlude_postsid = $exlude_post->ID;
		                    ?>
		                    <option value="<?php echo esc_attr($exlude_postsid);?>" <?php if (in_array($exlude_postsid, $explode_post_id)) { echo 'selected'; }?>><?php echo esc_html($exlude_poststitle);?></option>
		                    <?php } ?>
	                	</select>
						</td>
					</tr>
				</table>
			<input type="hidden" name="mode" value="excludepage">
			<?php wp_nonce_field( 'excludepage_nonce', 'add_excludepage' ); ?>
			<p class="submit"><input type='submit' name="Submit" value="<?php esc_attr_e('Save Changes','skt-maintenance');?>"></p>
		</form>
		</div>
		<div class="skt-maintenance-options-wrap">
			<h3 class="skt-maintenance-options-title"><?php esc_attr_e('Ready To Use Themes','skt-maintenance'); ?></h3>
			<div class="skt-themes-about"><?php esc_attr_e('At SKT Themes we handpick our professional WordPress themes and create it as per client demands and current market trends. So be it responsive or be it google fonts or theme options to make the site easy to use, our themes have all of the features.','skt-maintenance'); ?></div>
			<div class="skt-themes-row">
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo esc_url( SKTM_MAINTENANCE_URI.'/images/mountain-biking.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/mountainbiking/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/cycling-club-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/cycling-club-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Mountain Biking','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/skt-tattoo.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/tattoo/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/tattoo-studio-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/tattoo-studio-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Tattoo','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/skt-tailor.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/tailor/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/tailor-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/tailor-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Tailor','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/motorcycle.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/motorcycle/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/auto-parts-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/auto-parts-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Motorcycle','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/school-uniform.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/uniform/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/uniform-store-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/uniform-store-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('School Uniform','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/event-planners.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/demos/event-planners/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/event-agency-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/event-agency-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Event Planners Pro','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/swimming-pool.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/swimming/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/swimming-pool-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/swimming-pool-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Swimming Pool','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/skt-aquarium.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/aquarium/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/aquarium-services-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/aquarium-services-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Aquarium','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/real-estate.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/demos/realestate/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/real-estate-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/real-estate-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Real Estate','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/summer-camp.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/summercamp/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/camping-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/camping-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Summer Camp','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/bicycle-shop.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/bicycleshop/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/cycling-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/cycling-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Bicycle Shop','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/skt-association.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/association/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/association-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/association-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Association','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/skt-municipality.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/themepack/municipality/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/city-government-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/city-government-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('SKT Municipality','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/flower-shop.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktperfectdemo.com/demos/flowershop/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/florist-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/florist-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Flower Shop','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
				<div class="skt-themes-column">
					<div class="skt-themes-inner">
						<div class="skt-themes-image">
							<img src="<?php echo  esc_url( SKTM_MAINTENANCE_URI.'/images/complete-pro.jpg' ); ?>">
							<a class="skt-themes-demo" href="https://sktthemesdemo.net/complete/" target="_blank"><?php esc_attr_e('View Demo','skt-maintenance'); ?></a>
							<a class="skt-themes-buy" href="https://www.sktthemes.org/shop/complete-wordpress-theme/" target="_blank"><?php esc_attr_e('Buy Now','skt-maintenance'); ?></a>
						</div>
						<div class="skt-themes-content"><a href="https://www.sktthemes.org/shop/complete-wordpress-theme/" target="_blank"><h3><?php esc_attr_e('Complete Pro','skt-maintenance'); ?></h3></a></div>
					</div>
				</div>
			
			</div>
			<a class="skt-view-all" href="https://www.sktthemes.org/themes/" target="_blank"><?php esc_attr_e('View All Themes','skt-maintenance'); ?></a>
		</div>
</div>
<?php } }