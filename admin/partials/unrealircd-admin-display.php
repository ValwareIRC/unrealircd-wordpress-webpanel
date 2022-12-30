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
    <h2>IRC Overview Panel</h2>
    <table class='unrealircd_overview'>
        <tr><td>Users</td><td>".count(RPC_List::$user)."</td></tr>
        <tr><td>Opers</td><td>".RPC_List::$opercount."</td></tr>
        <tr><td>Services</td><td>".RPC_List::$services_count."</td></tr>
        <tr><td>Most popular channel</td><td>".RPC_List::$most_populated_channel." (".RPC_List::$channel_pop_count." users)</td></tr>
        <tr><td>Channels</td><td>".count(RPC_List::$channel)."</td></tr>
        <tr><td>Server bans</td><td>".count(RPC_List::$tkl)."</td></tr>
        <tr><td>Spamfilter entries</td><td>".count(RPC_List::$spamfilter)."</td></tr>
    </table>";
?>
<br><br>
<h1>Latest from UnrealIRCd</h1>
<a width="30%" height="600px" class="twitter-timeline" href="https://twitter.com/Unreal_IRCd?ref_src=twsrc%5Etfw">Tweets by Unreal_IRCd</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
