<?php

function theme_install_dummy_data(){
	define('WP_LOAD_IMPORTERS', true);

	if ( !class_exists( 'WP_Import' ) ) {
		require_once (THEME_PLUGINS . '/wordpress-importer/wordpress-importer.php');
	}

	$content_xml = THEME_DIR."/demo/content.txt";
	if(!is_file($content_xml)) {
		echo sprintf(__("The XML file containing the dummy content is not available or could not be read in <pre>%s/demo/content.txt</pre>", 'theme_admin'), THEME_DIR);
	} else {
		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		$wp_import->import($content_xml);

		theme_install_dummy_menus();
		theme_install_dummy_options();
		theme_install_dummy_widgets();

		theme_check_image_folder();
		theme_clear_cache();
		theme_save_skin_style();
	}
}

function theme_install_dummy_menus() {
	global $wpdb;
	$table_db_name = $wpdb->prefix . "terms";
	$rows = $wpdb->get_results("SELECT * FROM $table_db_name where name='Main Navigation' OR name='Footer Menu'",ARRAY_A);
	$menu_ids = array();
	foreach($rows as $row) {
		$menu_ids[$row["name"]] = $row["term_id"] ;
	}
	$locations = get_nav_menu_locations();
	if( !has_nav_menu( 'primary-menu' ) ){
		$locations['primary-menu'] = (int)$menu_ids['Main Navigation'];
	}
	if( !has_nav_menu( 'footer-menu' ) ){
		$locations['footer-menu'] = (int)$menu_ids['Footer Menu'];
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}

function theme_install_dummy_options() {
	$dummy_options = THEME_DIR."/demo/options.txt";
	if(is_file($dummy_options)) {
		$data = file_get_contents($dummy_options);
		$options_array = unserialize( base64_decode( $data ) );
		if(is_array($options_array)){
			foreach($options_array as $name => $options){
				update_option('theme_' . $name, $options);
			}
		}
	}
}

/* thanks to Steven Gliebe (Widget Importer & Exporter) */
function theme_install_dummy_widgets() {
	$dummy_widgets = THEME_DIR."/demo/widgets.php";
	if(!is_file($dummy_widgets)){
		return;
	}
	$data = include ($dummy_widgets);

	global $wp_registered_sidebars;
	global $wp_registered_widget_controls;

	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $wp_registered_widget_controls as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}

	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {

		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}

		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( !isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			continue;
		}

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {

			$fail = false;

			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			if ( ! $fail && ! isset( $widget_instances[$id_base] ) ) {
				$fail = true;
			}

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {
				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$sidebar_id] ) ? $sidebars_widgets[$sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {
					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
						$fail = true;
						break;
					}
				}
			}

			// No failure
			if ( ! $fail ) {
				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = (array) $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data
			}
		}
	}
}