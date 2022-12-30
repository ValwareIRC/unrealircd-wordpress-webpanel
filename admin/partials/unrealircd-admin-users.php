<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://github.com/ValwareIRC
 * @since      1.0.0
 *
 * @package    Unrealircd
 * @subpackage Unrealircd/admin/partials
 */

rpc_pop_lists();
echo "

<link href=\"".plugin_dir_path(__FILE__)."admin/css/unrealircd-admin.css\" rel=\"stylesheet\">
<h1>UnrealIRCd</h1>
    <h2>Users</h2>
    <table class='unrealircd_overview'>
        <tr>
        <td>Nick</td>
        <td>UID</td>
        <td>IP</td>
        <td>Nick</td>
        <td>Nick</td>
        <td>Nick</td>
        </tr>
    </table>";
?>