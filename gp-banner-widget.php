<?php

function gp_banner_widget_init() {

	function gp_banner_widget($args) {

		// "$args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys." - These are set up by the theme
		extract($args);

		// These are our own options
		$gp_banner_widget_options = get_option( "gp-banner-widget-settings" );
		$num_entries = count($gp_banner_widget_options);
		
		echo '<div id="gp-banner-gallery">';
		for ( $i = $num_entries - 1; $i >= 0; $i-- ) {
		    $entry = $gp_banner_widget_options[$i];
		    echo '<a href="'.$entry['linkUrl'].'">';
		    echo '<img src="'.$entry['largeImg'].'"/>';
		    echo '</a>';
		}
		echo '</div>';
		
		echo '<div id="gp-banner-thumbs">';
		for ( $i = $num_entries - 1; $i >= 0; $i-- ) {
		    $entry = $gp_banner_widget_options[$i];
		    if ( empty($entry['smallImg']) ) {
		        $entry['smallImg'] = $entry['largeImg'];
		    }
		    echo '<a href="'.$entry['linkUrl'].'">';
		    echo '<img src="'.$entry['smallImg'].'"/>';
		    echo '</a>';
		}
		echo '</div>';
		
	}

	// Register widget for use
	wp_register_sidebar_widget(
		'gp_banner_widget',        // your unique widget id
		'Gracepoint Banner Widget', // widget name
		'gp_banner_widget',  // callback function
		array(                  // options
			'description' => 'App Store like banner widget'
		     )
	); 
	
	wp_register_style('gp_banner_widget', WP_PLUGIN_URL . '/gp-banner-widget/gp-banner-widget.css');
	wp_enqueue_style( 'gp_banner_widget' );

}
// Run code and init
add_action('widgets_init', 'gp_banner_widget_init');

?>
