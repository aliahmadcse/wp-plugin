<?php

/*
Plugin Name: Assignment
Plugin URI: http://test.website
Description: This plugin helps you manage the lectures
Version: 1.0
Author: Ali Ahmad
Text Domain:  myplugin
Domain Path:  /languages
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// existing on direct access
if (!defined('ABSPATH'))
    exit;

// registering the activation hook and creating the table
register_activation_hook(__FILE__, function () {

    global $wpdb;
    $db_table_name = $wpdb->prefix . 'lecture_description';  // table name
    $charset_collate = $wpdb->get_charset_collate();

    //Check to see if the table exists already, if not, then create it
    if ($wpdb->get_var("show tables like '$db_table_name'") != $db_table_name) {
        $sql = "CREATE TABLE $db_table_name (
                id int(11) NOT NULL auto_increment,
                title varchar(255) NOT NULL,
                description text NOT NULL,
                UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
});


function styles_and_scripts()
{
    $pluginPath = plugin_dir_url(dirname(__FILE__));
    wp_enqueue_script('jquery', $pluginPath . 'js/jquery.min.js');
    wp_enqueue_style('bootstrapCSS', $pluginPath . 'css/bootstrap.min.css');
    wp_enqueue_script('bootstrapJS', $pluginPath . 'js/bootstrap.min.js');
    wp_enqueue_script('customJS', $pluginPath . 'js/script.js');
}

add_action('wp_enqueue_scripts', 'styles_and_scripts');


// add top-level administrative menu
include "php\lectureList.php";

function assignment_add_menu()
{
    /* 
		add_menu_page(
			string   $page_title, 
			string   $menu_title, 
			string   $capability, 
			string   $menu_slug, 
			callable $function = '', 
			string   $icon_url = '', 
			int      $position = null 
		)
    */
    add_menu_page(
        'Lectures List',
        'Lectures',
        'manage_options',
        'lectures',
        'assignment_list_lectures'
    );

    /*
	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = ''
	);	
    */

    add_submenu_page(
        'lectures',
        'Add Lecture',
        'Add Lecture',
        'manage_options',
        'add_lecture',
        'assignment_add_lecture'
    );
}
add_action('admin_menu', 'assignment_add_menu');

add_shortcode('SC_LectureSummary', 'assignment_list_lectures');

include "php\quiz.php";
add_shortcode('SC_ResultFilter', 'assignment_quiz_dropdown');
add_shortcode('SC_ResultSheet', 'assignment_display_result');
