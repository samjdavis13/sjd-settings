<?php
/*
Plugin Name: SJD Settings Page
Plugin URI: http://github.com/samjdavis13/sjd-settings
Description: Simple, customisable settings page.
Version: 2.0
Author: Samuel Davis
Author URI: http://sjd.co
*/

/**
* Get current file dir
*/
$dir = plugin_dir_path( __FILE__ );

/**
* Get our config variables from variables.json file
*/
if ( file_exists( get_template_directory() . '/sjd-settings/variables.json' ) ) {
    // Read users config file
    $raw_setting_data = file_get_contents( get_template_directory() . '/sjd-settings/variables.json' );
    $setting_data = json_decode($raw_setting_data, true);
} else {
    // Read default config file
    $raw_setting_data = file_get_contents( $dir . 'overrides/variables.json', true);
    $setting_data = json_decode($raw_setting_data, true);
}

/**
* Add basic settings page to wordpress admin
*/

/** Dislay sjd-settings callback */
function sjd_settings_page() {
    global $setting_data;
    ?>
	    <div class="wrap">

	    <h1><?php echo $setting_data['sjdco_settings']['page_name']; ?></h1>
	    <form method="post" action="options.php">

            <?php if( isset($_GET['settings-updated']) ) : ?>
                <div id="message" class="updated notice is-dismissible"><p>Settings updated successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
            <?php endif; ?>

	        <?php
                // global $setting_data;
                // var_dump($setting_data);
                foreach ($setting_data['setting_fields'] as $section) {
                    $section_name = $section['section_name'];
                    $section_id = str_replace( ' ', '_', strtolower($section_name));
                    settings_fields($section_id);
                }
	            do_settings_sections("theme-options");
	            submit_button();
	        ?>
	    </form>
		</div>
	<?php
}

/** Create menu page using above callback */
function add_sjd_settings_menu_item() {
    global $setting_data;
    add_menu_page( $setting_data['sjdco_settings']["page_name"], $setting_data['sjdco_settings']["page_name"], "manage_options", $setting_data['sjdco_settings']["slug_name"], "sjd_settings_page", null, 3 );
}

/** Hook creation of menu page to admin_menu function */
add_action("admin_menu", "add_sjd_settings_menu_item");

/**
* Register settings fields
*/
function display_sjd_input(array $args) {
    $id = $args['id'];
    $name = $args['name'];
    $type = $args['type'];
    $message = $args['message']; ?>

    <?php if ($type === "textarea"): ?>

        <textarea type="<?php echo $type ?>" name="<?php echo $id ?>" class="sjd-settings-input" id="<?php echo $id ?>"><?php echo get_option($id); ?></textarea>

    <?php else: ?>

        <input type="<?php echo $type ?>" name="<?php echo $id ?>" class="sjd-settings-input" id="<?php echo $id ?>" value="<?php echo get_option($id); ?>">

        <?php if ($type === "url"): ?>
            <p class="description">Must begin with http:// or https://</p>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ($message !== ""): ?>
        <p class="description"><?php echo $message; ?></p>
    <?php endif; ?>

<?php }


/** Registers form inputs using the above callbacks */
function display_sjd_settings_fields() {

    // global $setting_fields;
    global $setting_data;

    // Create setting sections
    foreach ($setting_data['setting_fields'] as $section) {

        $section_name = $section['section_name'];
        $section_id = str_replace( ' ', '_', strtolower($section_name));

        add_settings_section( $section_id, $section_name, null, "theme-options" );
    }

    // Add fields to the sections
    foreach ($setting_data['setting_fields'] as $section) {
        $section_name = $section['section_name'];
        $section_id = str_replace( ' ', '_', strtolower($section_name));

        foreach ($section['fields'] as $field) {
                $field_id = str_replace( ' ', '_', strtolower($field['field_name']));
                $args = array(
                    // "id" => $field['field_id'],
                    "type" => $field['input_type'],
                    "name" => $field['field_name'],
                    "id" => $field_id,
                    "message" => $field['message']
                );
                add_settings_field( $field_id, $field['field_name'], 'display_sjd_input', 'theme-options', $section_id, $args);
                register_setting( $section_id, $field_id);
        }
    }
}

/** Hook registering of fields to the admin_init function */
add_action("admin_init", "display_sjd_settings_fields");

/**
* Enqueue Custom Scripts and Styles
*/
function add_plugin_styles() {
    wp_enqueue_style( "sjd-settings-styles", plugins_url('/css/style.css', __FILE__) );
}
add_action('admin_print_styles', 'add_plugin_styles');