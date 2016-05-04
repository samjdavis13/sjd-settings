<?php
/*
Plugin Name: SJD Settings Page
Plugin URI: http://sjd.co
Description: Simple, customisable settings page.
Version: 1.1
Author: Samuel Davis
Author URI: http://sjd.co
*/

/**
* Get current file dir
*/
$dir = plugin_dir_path( __FILE__ );

/**
* Load our variables
*/
require_once( $dir . "/overrides/variables.php" );

/** Potentially override our variables with user created ones */
if ( file_exists( get_template_directory() . '/sjd-settings/variables.php' ) ) {
    require_once( get_template_directory() . '/sjd-settings/variables.php' );
}

/**
* Add basic settings page to wordpress admin
*/

/** Dislay sjd-settings callback */
function sjd_settings_page() {
    global $sjdco_settings;
    ?>
	    <div class="wrap">

	    <h1><?php echo $sjdco_settings['page_name']; ?></h1>
	    <form method="post" action="options.php">

            <?php if( isset($_GET['settings-updated']) ) : ?>
                <div id="message" class="updated notice is-dismissible"><p>Settings updated successfully.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
            <?php endif; ?>

	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");
	            submit_button();
	        ?>
	    </form>
		</div>
	<?php
}

/** Create menu page using above callback */
function add_sjd_settings_menu_item() {
    global $sjdco_settings;
    add_menu_page( $sjdco_settings["page_name"], $sjdco_settings["page_name"], "manage_options", $sjdco_settings["slug_name"], "sjd_settings_page", null, 3 );
}

/** Hook creation of menu page to admin_menu function */
add_action("admin_menu", "add_sjd_settings_menu_item");


/**
* Register settings fields
*/

function display_sjd_input(array $args) {
    $id = $args['id'];
    $name = $args['name'];
    $type = $args['type']; ?>

    <?php if ($type === "textarea"): ?>
        <textarea type="<?php echo $type ?>" name="<?php echo $id ?>" class="sjd-settings-input" id="<?php echo $id ?>"><?php echo get_option($id); ?></textarea>
    <?php else: ?>
        <input type="<?php echo $type ?>" name="<?php echo $id ?>" class="sjd-settings-input" id="<?php echo $id ?>" value="<?php echo get_option($id); ?>">
        <?php if ($type === "url"): ?>
            <p class="description">Must begin with http:// or https://</p>
        <?php endif; ?>
    <?php endif; ?>



<?php }


/** Registers form inputs using the above callbacks */
function display_sjd_settings_fields() {

    add_settings_section( "section", "", null, "theme-options" );

    global $setting_fields;
    $index = 0;
    foreach ($setting_fields as $field) {
        $index++;

        $args = array(
            "id" => $field['field_id'],
            "type" => $field['input_type'],
            "name" => $field['field_name'],
        );

        add_settings_field( $field['field_id'], $field['field_name'], 'display_sjd_input', 'theme-options', 'section', $args);
        register_setting( "section", $field['field_id']);
    }
}

/** Hook registering of fields to the admin_init function */
add_action("admin_init", "display_sjd_settings_fields");

/**
* Enqueue Scripts and Styles
*/
function add_plugin_styles() {
    wp_enqueue_style( "sjd-settings-styles", plugins_url('/css/style.css', __FILE__) );
}
add_action('admin_print_styles', 'add_plugin_styles');

?>