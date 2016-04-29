<?php
/**
* Currently the only way to customise the information displayed by this plugin.
* DO NOT UPDATE THIS FILE DIRECTLY!
*
* Please duplicate this file to wp-content/your-theme/sjd-settings/
* to make changes that will persist through updates
*/

$sjdco_settings = array(
    page_name => "SJDco Settings",
    slug_name => "sjdco-settings"
);

$setting_fields = array(
    array(
        "field_name"    =>  "Twitter URL",
        "field_id"      =>  "twitter_url",
        "input_type"    =>  "text"
    ),
    array(
        "field_name"    =>  "Facebook URL",
        "field_id"      =>  "facebook_url",
        "input_type"    =>  "text"
    ),
    array(
        "field_name"    =>  "Phone Number",
        "field_id"      =>  "phone_number",
        "input_type"    =>  "phone"
    ),
);

?>