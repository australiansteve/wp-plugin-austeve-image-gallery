<?php // display the admin options page
function austeve_image_gallery_options_page() {
?>
<div>
	<h2>AUSteve Gallery settings</h2>
	Options relating to the AUSteve Image Gallery plugin.

	<form action="options.php" method="post">

		<?php settings_fields('austeve_image_gallery_options'); ?>
		<?php do_settings_sections('austeve_image_gallery'); ?>
	 
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
</div>
<?php
}

$preview_format_list = array( 
	0 => "Grid view 1", 
	1 => "Small panel view" 
);

function austeve_image_gallery_section_text() {
	echo '<p></p>';
} 

function austeve_image_gallery_setting_num_sidebars() {
	$options = get_option('austeve_image_gallery_options');
	$num_sidebars_val = isset($options['num_sidebars']) ? $options['num_sidebars'] : '1';
	echo "<input id='austeve_image_gallery_num_sidebars' name='austeve_image_gallery_options[num_sidebars]' size='40' type='text' value='{$num_sidebars_val}' />";
} 

function austeve_image_gallery_setting_preview_format() {
	global $preview_format_list;
	$options = get_option('austeve_image_gallery_options');
	$preview_format_val = isset($options['preview_format']) ? $options['preview_format'] : '0';

	echo "<select id='austeve_image_gallery_preview_format' name='austeve_image_gallery_options[preview_format]'>";

	foreach($preview_format_list as $key => $value) {
		echo "<option value='".$key."'";
		if ($key == $preview_format_val) {
			echo " selected";
		}
		echo ">".$value."</option>";
	}
	echo "</select>";
	echo "<br/><strong>Note: </strong><em>Only change this setting if you are sure that your theme supports the selected choice.</em>";
} 

function austeve_image_gallery_setting_container() {
	$container_list = array( 
		'li' => 'li (List Item)', 
		'div' => 'div' 
	);

	$options = get_option('austeve_image_gallery_options');
	$container_val = isset($options['container']) ? $options['container'] : $container_list['li'];

	echo "<select id='austeve_image_gallery_container' name='austeve_image_gallery_options[container]'>";

	foreach($container_list as $key => $value) {
		echo "<option value='".$key."'";
		if ($key == $container_val) {
			echo " selected";
		}
		echo ">".$value."</option>";
	}
	echo "</select>";
} 

function austeve_image_gallery_setting_classes() {
	$options = get_option('austeve_image_gallery_options');
	$classes_val = isset($options['classes']) ? $options['classes'] : '';
	echo "<input id='austeve_image_gallery_classes' name='austeve_image_gallery_options[classes]' size='40' type='text' value='{$classes_val}' />";
} 

// add the admin settings and such
function austeve_image_gallery_admin_init(){
	register_setting( 'austeve_image_gallery_options', 'austeve_image_gallery_options', 'austeve_image_gallery_options_validate' );
	add_settings_section('austeve_image_gallery_main', 'Main Settings', 'austeve_image_gallery_section_text', 'austeve_image_gallery');
	add_settings_field('austeve_image_gallery_num_sidebars', 'Number of sidebars [1-9]:', 'austeve_image_gallery_setting_num_sidebars', 'austeve_image_gallery', 'austeve_image_gallery_main');
	add_settings_field('austeve_image_gallery_preview_format', 'Gallery preview format:', 'austeve_image_gallery_setting_preview_format', 'austeve_image_gallery', 'austeve_image_gallery_main');
	add_settings_field('austeve_image_gallery_container', 'Container:', 'austeve_image_gallery_setting_container', 'austeve_image_gallery', 'austeve_image_gallery_main');
	add_settings_field('austeve_image_gallery_classes', 'Additional classes:', 'austeve_image_gallery_setting_classes', 'austeve_image_gallery', 'austeve_image_gallery_main');
}
add_action('admin_init', 'austeve_image_gallery_admin_init');

// validate our options
function austeve_image_gallery_options_validate($input) {
	global $preview_format_list;
	$options = get_option('austeve_image_gallery_options');

	//validation on num_sidebars
	$options['num_sidebars'] = trim($input['num_sidebars']);

	if(!preg_match('/^[1-9]$/i', $options['num_sidebars'])) {
		$options['num_sidebars'] = '1';

		add_settings_error(
	        'sidebars_non_numeric',
	        esc_attr( 'settings_updated' ),
	        'Number of sidebars must be 1-9. Default of 1 used',
	        'error'
	    );
	    return;
	}

	//validation on preview_format
	$options['preview_format'] = $input['preview_format'];

	if(!preg_match('/^[0-9]$/i', $options['preview_format'])) {
		$options['preview_format'] = '0';

		add_settings_error(
	        'preview_format_non_numeric',
	        esc_attr( 'settings_updated' ),
	        'Gallery preview format is invalid. Defaulting to '.$preview_format_list[0],
	        'error'
	    );
	    return;
	}

	$options['container'] = $input['container'];

	$options['classes'] = $input['classes'];

	return $options;
}

// add the admin options page itself
function austeve_gallery_admin_add_page() {
    add_options_page('AUSteve Gallery settings', 'AUSteve Gallery settings', 'manage_options', 'austeve_image_gallery', 'austeve_image_gallery_options_page');
}
add_action('admin_menu', 'austeve_gallery_admin_add_page');
?>