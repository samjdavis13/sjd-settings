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
        "section_name"  => "General",
        "fields"        => array(
            array(
                "field_name"    =>  "Phone Number",
                "input_type"    =>  "tel"
            ),
            array(
                "field_name"    =>  "Facebook URL",
                "input_type"    =>  "url"
            ),
            array(
                "field_name"    =>  "Youtube URL",
                "input_type"    =>  "url"
            ),
        )
    ),
    array(
        "section_name"  => "Advanced",
        "fields"        => array(
            array(
                "field_name"    =>  "API Token",
                "input_type"    =>  "textarea",
                "message"       =>  "Please do not edit this unless you know what you are doing. Do not share this code with anyone."
            ),
        )
    ),
);

?>