<?php
/*
Plugin Name: GForms Color Picker
Version: 1.2.0
Description: Adds new color picker field to Gravity Forms
Author: Jose Antonio Ferrete
Author URI: https://github.com/JoseAFerrete/
Plugin URI: https://github.com/JoseAFerrete/gravityforms-color-picker
Text Domain: gf-color-picker
Requires at least: 5.3
Requires PHP: 7.3
License: Apache License 2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GF_COLOR_PICKER_ADDON_VERSION', '1.0' );

add_action( 'gform_loaded', array( 'GF_Color_Picker_AddOn_Bootstrap', 'load' ), 5 );
 
class GF_Color_Picker_AddOn_Bootstrap {
 
    public static function load() {
 
        if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
            return;
        }
 
        require_once( 'class-gf-color-picker.php' );
 
        GFAddOn::register( 'GFColorPickerAddOn' );
    }
 
}