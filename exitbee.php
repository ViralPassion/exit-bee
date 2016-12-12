<?php
/*
  Plugin Name: ExitBee
  Description: ExitBee.
  Version: 0.1
  Author: Viral Passion
  Text Domain: exitbee
  Domain Path: /exitbee
*/


defined( 'ABSPATH' ) or die();

/*run plugin */

add_action('wp_footer', 'exitbee_echo_pixel');
function exitbee_echo_pixel(){
	settings_fields( 'exitbee_settings-group' );
	if(esc_attr( get_option('exitbee_id') )!=""){
		echo ('<script>
				(function(doc) {
				   var xtb = document.createElement("script");
				   xtb.type = "text/javascript";
				   xtb.async = true;
				   xtb.src = document.location.protocol + "//app.exitbee.com/c/'.esc_attr( get_option('exitbee_id') ).'/exitbee.js";
				   document.getElementsByTagName("head")[0].appendChild(xtb);
				 }())
		</script>');
	}
}

// create custom plugin settings menu
add_action('admin_menu', 'vp_exitbee_menu');

function vp_exitbee_menu() {

	//create new top-level menu
	add_submenu_page('options-general.php', 'ExitBee', 'ExitBee', 'administrator', __FILE__, 'exitbee_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_exitbee_settings' );
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'exitbee_add_settings_link' );
function exitbee_add_settings_link($links){
	$settings_link = '<a href="options-general.php?page=exit-bee%2Fexitbee.php">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}

function register_exitbee_settings() {
	//register our settings
	register_setting( 'exitbee_settings-group', 'exitbee_id' );
}

function exitbee_settings_page() {

	$domain = site_url(); //or home
	$domain = str_replace('https://', '', $domain);
	$domain = str_replace('http://', '', $domain);
	$domain = str_replace('www', '', $domain); //add the . after the www if you don't want it
	//$domain = strstr($domain, '/', true); //PHP5 only, this is in case WP is not root
?>
<div class="wrap">
<h2>ExitBee Settings</h2>

<h3>Please add the ExitBee id for the domain: <?php echo $domain; ?></h3>

<form method="post" action="options.php">
    <?php settings_fields( 'exitbee_settings-group' ); ?>
    <?php do_settings_sections( 'exitbee_settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <td><strong>ExitBee Id: </strong><input type="text" name="exitbee_id" value="<?php echo esc_attr( get_option('exitbee_id') ); ?>" /></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>
<?php }

function exitbee_activate() {

	$domain = site_url(); //or home
	$domain = str_replace('https://', '', $domain);
	$domain = str_replace('http://', '', $domain);
	$domain = str_replace('www', '', $domain);
	
}
register_activation_hook( __FILE__, 'exitbee_activate' );
