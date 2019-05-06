<?php
/*
Plugin Name: Calendar of Events
Description: A simple and convenient calendar of events will not allow you to forget something important!
Version:     1.0
Plugin URI:  #
Author:      Mikhail Isakin
Author URI:  https://www.upwork.com/freelancers/~01c3b60e7b0f68c266
Text Domain: calendarofevents
*/

/*  Copyright 2019 Isakin Mikhail (email: isakin.mikhail@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define COE_PLUGIN_FILE.
if ( ! defined( 'COE_PLUGIN_FILE' ) ) {
    define( 'COE_PLUGIN_FILE', __FILE__ );
}

// Include the main COE_Main class.
if ( ! class_exists( 'COE_Main' ) ) {
    include_once dirname( __FILE__ ) . '/includes/Main.php';
}

/**
 * Main instance.
 *
 * Returns the Main instance of plugin to prevent the need to use globals.
 *
 * @return COE_Main
 */
if( ! function_exists('wp_coe_main') ) {
    function wp_coe_main() {
        return COE_Main::get_instance();
    }

    wp_coe_main();
}