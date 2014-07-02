<?php
/*
Plugin Name: Gracepoint Banner Widget

/* License

    Gracepoint Banner Widget

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License gpfor more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/
include_once dirname( __FILE__ ) . '/gp-banner-widget.php';

function add_settings_page() {
	add_options_page('GP Banner Widget', 'GP Banner Widget', 'manage_options', 'gp-banner.php', 'settings_page'); 
}

function settings_page() {
    
    $gp_banner_widget_options = get_option( "gp-banner-widget-settings" );
    
    if ( empty($gp_banner_widget_options) ) {
        $gp_banner_widget_options = array();
    }   
	
	if (isset($_POST['info_update'])) {
	    $count = count( $gp_banner_widget_options );
	    $gp_banner_widget_options = array();
	    
	    for( $i = 0; $i < $count; $i++ ) {
	        $linkUrl = $_POST["linkURL_" . $i];
    	    $largeImg = $_POST["largeIMG_" . $i];
    	    $smallImg = $_POST["smallIMG_" . $i];

    	    $entry_array = array("linkUrl" => $linkUrl, "largeImg" => $largeImg, "smallImg" => $smallImg);
    	    array_push( $gp_banner_widget_options, $entry_array );
	    }  
		update_option( 'gp-banner-widget-settings', $gp_banner_widget_options );
		#delete_option( 'gp-banner-widget-settings' );
	} 

	if (isset($_POST['add_entry'])) {
	    $count = count($gp_banner_widget_options);
	    
	    $linkUrl = $_POST["linkURL_" . $count];
	    $largeImg = $_POST["largeIMG_" . $count];
	    $smallImg = $_POST["smallIMG_" . $count];
	    
	    $entry_array = array("linkUrl" => $linkUrl, "largeImg" => $largeImg, "smallImg" => $smallImg);
	    
	    array_push( $gp_banner_widget_options, $entry_array );
	    
	    update_option( 'gp-banner-widget-settings', $gp_banner_widget_options);
	}
	
	if (isset($_POST['delete_entry'])) {
	    $entry_id = $_POST['delete_entry'];
	    unset($gp_banner_widget_options[$entry_id]);
	    
	    $gp_banner_widget_options = array_values($gp_banner_widget_options);
	    
	    update_option( 'gp-banner-widget-settings', $gp_banner_widget_options );
	}
	
	?>
		<div class="wrap">
            <h2>GP Banner Widget</h2>
			<form method="post" action="options-general.php?page=gp-banner.php" id="gp-banner-widget-settings">

			<h3>Gracepoint Banner Settings</h3>
			<table class="form-table">
			    <tr valign="top">
			        <th>Link URL</th>
			        <th>Large Image</th>
			        <th>Small Image</th>
			        <th>Add/Delete</th>
			    </tr>
			    <?php 
			        $count = 0;
			        foreach ( $gp_banner_widget_options as $entry ) {
			            echo '<tr valign="top">';
			            echo '<td><input name="linkURL_'.$count.'" type="text" value="'.$entry["linkUrl"].'" /></td>';
			            echo '<td><input name="largeIMG_'.$count.'" type="text" value="'.$entry["largeImg"].'" /></td>';
			            echo '<td><input name="smallIMG_'.$count.'" type="text" value="'.$entry["smallImg"].'" /></td>';
			            echo '<td><button name="delete_entry" class="button-secondary" value="'.$count.'" type="submit">Delete</button></td>';
			            echo '</tr>';
			            $count++;
			        }
                ?>
                <tr valign="top">
                    <td><input name="<?php echo "linkURL_" . $count; ?>" type="text" /></td>
                    <td><input name="<?php echo "largeIMG_" . $count; ?>" type="text" /></td>
                    <td><input name="<?php echo "smallIMG_" . $count; ?>" type="text" /></td>
                    <td><input type="submit" name="add_entry" class="button-secondary" value="Add" /></td>
                </tr>  
			</table>
			<p class="submit">
				<input type="submit" name="info_update" class="button-primary" value="Save" />
			</p>
			</form>
		</div>
	<?php
}

function register_mysettings() {
	register_setting( 'gp-banner-widget-settings-group', 'gp-banner-widget-api_key' );
	register_setting( 'gp-banner-widget-settings-group', 'gp-banner-widget-user_id' );
}

function gp_banner_widget_settings_link($links, $file) {
    static $this_plugin;
 
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
 
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
        // the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
        $settings_link = '<a href="options-general.php?page=gp-banner.php">Settings</a>';
        // add the link to the list
        array_unshift($links, $settings_link);
    }
 
    return $links;
}
// Run code and init
add_filter('plugin_action_links', 'gp_banner_widget_settings_link', 10, 2);
add_action('admin_menu', 'add_settings_page');
add_action( 'admin_init', 'register_mysettings' );

?>
