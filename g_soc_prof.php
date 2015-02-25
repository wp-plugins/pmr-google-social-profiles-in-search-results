<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/* 
Plugin Name: PMR | Google Social Profiles
Plugin URI: Unknown
Description: Display your social profiles in Google search results
Version: 1.0
Author: Paul Riley
License: GPL2
*/

//register the plugin activation hook:
register_activation_hook(__FILE__, 'pmr_gsp_install');

function pmr_gsp_install() {
	
	global $wp_version;
	
	if (version_compare($wp_version, '3.5', '<')){
		
		wp_die('This plugin requires WordPress version 3.5 or higher.');
		
	}//end if

}	

//Create options page
add_action( 'admin_menu', 'pmr_gsp_options_menu' );

function pmr_gsp_options_menu() {
	
	//set sidebar icon
	$pmr_gsp_options_menu_icon = "";
	
	//add page
	add_menu_page( 'PMR GSP Settings', 'GSP Settings', 'administrator', __FILE__, 'pmr_gsp_settings_page');
	
	//register setting for menu page
	add_action( 'admin_init', 'register_pmr_gsp_settings' );
	
}

function register_pmr_gsp_settings() {
	//register our settings
	register_setting( 'pmr-gsp-settings', 'pmr_status' );
	register_setting( 'pmr-gsp-settings', 'pmr_name' );
	register_setting( 'pmr-gsp-settings', 'pmr_siteurl' );
	register_setting( 'pmr-gsp-settings', 'pmr_logo' );
	register_setting( 'pmr-gsp-settings', 'pmr_facebook' );
	register_setting( 'pmr-gsp-settings', 'pmr_twitter' );
	register_setting( 'pmr-gsp-settings', 'pmr_google' );
	register_setting( 'pmr-gsp-settings', 'pmr_instagram' );
	register_setting( 'pmr-gsp-settings', 'pmr_pinterest' );
	register_setting( 'pmr-gsp-settings', 'pmr_youtube' );
		
}

function pmr_gsp_settings_page() {
?>
<div class="wrap">
<h2>PMR Google Search Results Social Profiles</h2>
<p>By entering the details below this plugin will load the necessary code into your website which gives Google the information needed to display your business' social profiles in their search results</p>

<div style="width:49%;float:left;">
<form method="post" action="options.php">
    <?php settings_fields( 'pmr-gsp-settings' ); ?>
    <?php do_settings_sections( 'pmr-gsp-settings' ); ?>
	
    <table class="form-table">
        <tr valign="top">
			<th scope="row">Enable GSP Plugin</th>
			<td><input type="checkbox" name="pmr_status" <?php if (get_option('pmr_status') ) { echo "checked"; } ?> /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Site Name</th>
			<td><input type="text" name="pmr_name" value="<?php echo esc_attr( get_option('pmr_name') ); ?>" /></td>
        </tr> 
		
		<tr valign="top">
			<th scope="row">Site URL<br/><small style="color:rgba(194, 10, 4, 0.51);">http://www.domain.co.uk/</small></th>
			<td><input type="text" name="pmr_siteurl" value="<?php echo esc_attr( get_option('pmr_siteurl') ); ?>" /></td>
        </tr>
		
        <tr valign="top">
			<th scope="row">Site Logo URL<br/><small style="color:rgba(194, 10, 4, 0.51);">full url from Media Library</small></th>
			<td><input type="text" name="pmr_logo" value="<?php echo esc_attr( get_option('pmr_logo') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
			<th scope="row">Facebook<br/><small style="color:rgba(194, 10, 4, 0.51);">https://www.facebook.com/<u>*****</u></small></th>
			<td><input type="text" name="pmr_facebook" value="<?php echo esc_attr( get_option('pmr_facebook') ); ?>" /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Twitter<br/><small style="color:rgba(194, 10, 4, 0.51);">https://www.twitter.com/<u>*****</u></small></th>
			<td><input type="text" name="pmr_twitter" value="<?php echo esc_attr( get_option('pmr_twitter') ); ?>" /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Google<br/><small style="color:rgba(194, 10, 4, 0.51);">https://plus.google.com/<u>*****</u></small></th>
			<td><input type="text" name="pmr_google" value="<?php echo esc_attr( get_option('pmr_google') ); ?>" /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Instagram<br/><small style="color:rgba(194, 10, 4, 0.51);">http://www.instagram.com/<u>*****</u></small></th>
			<td><input type="text" name="pmr_instagram" value="<?php echo esc_attr( get_option('pmr_instagram') ); ?>" /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">Pinterest<br/><small style="color:rgba(194, 10, 4, 0.51);">https://www.pinterest.com/<u>*****</u></small></th>
			<td><input type="text" name="pmr_pinterest" value="<?php echo esc_attr( get_option('pmr_pinterest') ); ?>" /></td>
        </tr>
		
		<tr valign="top">
			<th scope="row">YouTube<br/><small style="color:rgba(194, 10, 4, 0.51);">https://www.youtube.com/user/<u>*****</u></small></th>
			<td><input type="text" name="pmr_youtube" value="<?php echo esc_attr( get_option('pmr_youtube') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<div style="width:50%;float:left;">
<img style="width:100%;margin-bottom:25px;" src="<?php echo plugins_url('results.jpg', __FILE__) ?>" />
<p>This code has been tested with the <a href="https://developers.google.com/structured-data/testing-tool/" target="_blank">Google Structured Data Testing Tool</a></p> 
<img style="width:100%;margin-top:20px;" src="<?php echo plugins_url('example.jpg', __FILE__) ?>" />
</div>
</div>
<?php } 

add_action('wp_head', 'pmr_gsp_addtohead');

function pmr_gsp_addtohead() {
	
	if (get_option('pmr_status')) {
	?>
	
<script type="application/ld+json">
	{ 
		"@context" : "http://schema.org",
		"@type" : "Organization",
		"name" : "<?php echo esc_attr( get_option('pmr_name') ); ?>",
		"url" : "<?php echo esc_attr( get_option('pmr_siteurl') ); ?>",
		"logo": "<?php echo esc_attr( get_option('pmr_logo') ); ?>",
		"sameAs" : [ 
			"https://www.facebook.com/<?php echo esc_attr( get_option('pmr_facebook') ); ?>",
			"https://twitter.com<?php echo esc_attr( get_option('pmr_twitter') ); ?>",
			"https://plus.google.com<?php echo esc_attr( get_option('pmr_google') ); ?>",
			"http://instagram.com<?php echo esc_attr( get_option('pmr_instagram') ); ?>",
			"https://www.pinterest.com<?php echo esc_attr( get_option('pmr_pinterest') ); ?>/",
			"https://www.youtube.com/user/<?php echo esc_attr( get_option('pmr_youtube') ); ?>"
			] 
}
</script>
	
	<?php
	}
}

?>
