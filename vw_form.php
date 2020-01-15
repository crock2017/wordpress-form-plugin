<?php
/*
  Plugin Name: vw_form
  Plugin URI: http://none.none
  Description: creates form for vw start up theme. Use shortCode [vw_form]
  Version: 1.0.0
  Author: crock@vodafone.de
  Author URI: http://none.none
 */
//=== ajax object & ajax url & admin js===
function vwforms_scripts() {
wp_enqueue_script( 'vw_form', plugin_dir_url( __FILE__ ) . 'vw_form.js', array( 'jquery' ));
wp_localize_script( 'vw_form', 'vw_formajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
wp_register_style('prefix-style', plugins_url('vw_form.css', __FILE__) );	
wp_enqueue_style( 'prefix-style' );
	
}
add_action('wp_enqueue_scripts','vwforms_scripts');

//==== add admin menu==========
add_action('admin_menu', 'admin_menu_vwForm');
function admin_menu_vwForm() {
	add_menu_page('Settings', 'vw form setting', 'administrator', 'vfForm_menu', 'vwForm_admin_page');	
}
function vwForm_admin_page(){
	 if (!current_user_can('manage_options')) {
        wp_die('Unauthorized user');
    }
	// =====bind BD=======
	if(isset($_POST['submit'])){
		
		if(isset($_POST['vw_email_1'])) {
		update_option('vw_email_1', $_POST['vw_email_1']);
		}
		if(isset($_POST['vw_email_2'])) {
		update_option('vw_email_2', $_POST['vw_email_2']);
		}
		if(isset($_POST['vw_email_3'])) {
		update_option('vw_email_3', $_POST['vw_email_3']);
		}
	}
	?>
	<form method='post' action=''>	  
	<?php  
		settings_fields( 'vwForm_email' ); 
    	do_settings_sections('vwForm_email');
		submit_button(); 
		  ?>
	 </form>
	<?php
	
}
//========call register Email settings section & its fields function===============================
add_action('admin_init', 'register_email_vwForm_settings');

function register_email_vwForm_settings() {

	add_settings_section('email_settings_section', 'Email options', 'email_callback','vwForm_email');
	add_settings_field('Email','Email','email_options_callback', 'vwForm_email', 'email_settings_section');
	register_setting('vwForm_email', 'vwForm_email');					
} 
		//========== Email section ========
function email_callback(){
	?>
<p>Insert at least one Email for the contact form. Otherwise will be used default administrator email.</p>
<?php
}
		// ======== Email fields========
function email_options_callback(){
	
	?>
	<table class='form-table'>
		  <tr valing='top'>
			  <th scope='row'>email_1</th>
			  <td><input type='text' name='vw_email_1' value="<?php echo esc_attr( get_option('vw_email_1') ); ?>"/></td>
			  </tr>
		<tr valign='top'>
			 <th scope='row'>email_2</th>
			  <td><input type='text' name='vw_email_2' value="<?php echo esc_attr( get_option('vw_email_2') ); ?>"/></td>
		</tr>
		<tr valign='top'>
			 <th scope='row'>email_3</th>
			  <td><input type='text' name='vw_email_3' value="<?php echo esc_attr( get_option('vw_email_3') ); ?>"/></td>
		</tr>
			 
		  </table>
<?php
}

// ==== send Mail ajax process callback_form_function ======
add_action( "wp_ajax_frontvwFormaction", "callback_form_function" );
add_action( "wp_ajax_nopriv_frontvwFormaction", "callback_form_function" );

function callback_form_function(){

$email_1 = get_option('vw_email_1');
$email_2 = get_option('vw_email_2');
$email_3 = get_option('vw_email_3');
$admin_email = get_option('admin_email');
$empty = '1';
if(!$email_1 && !$email_2 && !$email_3) $empty = '0';
$UserPhone = '';
if(isset($_POST['vw_phone']))$UserPhone = $_POST['vw_phone'];
$headers = array('Content-Type: text/html; charset=UTF-8');
$toEmails='';
	if($empty == '0') {
		$toEmails = $admin_email;
	}else {
		if($email_1) $toEmails = $email_1.',';
		if($email_2) $toEmails .= $email_2.',';
		if($email_3) $toEmails .= $email_3;
	}
$subject = 'Заказ';
$body = '<table><tr><td>Телефон: </td><td>'.$UserPhone.'</td></tr></table>';
$sendEmails = wp_mail( $toEmails, $subject, $body, $headers );
if ($sendEmails){
	echo 'ok';
	
exit;
}else {
	echo 'error';
}	
	
	 wp_die();
}

//========== Register a new shortcode: [vw_form]================
add_shortcode( 'vw_form', 'vw_form_shortCode' );
 

function vw_form_shortCode() {
    ob_start();
	
   include( plugin_dir_path( __FILE__ ) . 'vw_form.html.php'); 
	
    return ob_get_clean();
}