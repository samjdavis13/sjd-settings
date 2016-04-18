<?php
/*
Plugin Name: SJD Settings Page
Plugin URI: http://sjd.co
Description: Simple settings page for use on SJD.co
Version: 0.1
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

/** Display Twitter Element Callback */
function display_twitter_element() {
    ?>
        <input type="text" class="sjd-settings-input" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>">
    <?php
}

/** Display Facebook Element Callback */
function display_facebook_element() {
    ?>
        <input type="text" class="sjd-settings-input" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>">
    <?php
}

/** Display Phone Number Element Callback */
function display_phone_number_element() {
    ?>
        <input type="phone" name="phone_number" class="sjd-settings-input" id="phone_number" value="<?php echo get_option('phone_number'); ?>">
    <?php
}

/** Registers form inputs using the above callbacks */
function display_sjd_settings_fields() {

    add_settings_section( "section", "General", null, "theme-options" );

    add_settings_field( "twitter_url", "Twitter URL", "display_twitter_element", "theme-options", "section" );
    add_settings_field( "facebook_url", "Facebook URL", "display_facebook_element", "theme-options", "section" );
    add_settings_field( "phone_number", "Phone Number", "display_phone_number_element", "theme-options", "section" );

    register_setting( "section", "twitter_url" );
    register_setting( "section", "facebook_url" );
    register_setting( "section", "phone_number" );
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