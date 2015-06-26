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

function austeve_image_gallery_section_text() {
	echo '<p></p>';
} 

function austeve_image_gallery_setting_num_sidebars() {
	$options = get_option('austeve_image_gallery_options');
	$num_sidebars_val = isset($options['num_sidebars']) ? $options['num_sidebars'] : '1';
	echo "<input id='austeve_image_gallery_num_sidebars' name='austeve_image_gallery_options[num_sidebars]' size='40' type='text' value='{$num_sidebars_val}' />";
} 

// add the admin settings and such
function austeve_image_gallery_admin_init(){
	register_setting( 'austeve_image_gallery_options', 'austeve_image_gallery_options', 'austeve_image_gallery_options_validate' );
	add_settings_section('austeve_image_gallery_main', 'Main Settings', 'austeve_image_gallery_section_text', 'austeve_image_gallery');
	add_settings_field('austeve_image_gallery_num_sidebars', 'Number of sidebars [1-9]:', 'austeve_image_gallery_setting_num_sidebars', 'austeve_image_gallery', 'austeve_image_gallery_main');
}
add_action('admin_init', 'austeve_image_gallery_admin_init');

// validate our options
function austeve_image_gallery_options_validate($input) {
	$options = get_option('austeve_image_gallery_options');
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
	return $options;
}

// add the admin options page itself
function austeve_gallery_admin_add_page() {
    add_options_page('AUSteve Gallery settings', 'AUSteve Gallery settings', 'manage_options', 'austeve_image_gallery', 'austeve_image_gallery_options_page');
}
add_action('admin_menu', 'austeve_gallery_admin_add_page');
?>