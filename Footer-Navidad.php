<?php
/*
Plugin Name: Footer Navidad
Plugin URI:  https://www.evolucionstreaming.net
Description: Footer Navidad y Año Nuevo
Version:     1.0.0.0.2
Author:      Evolucion Streaming - Sericios Informáticos
Author URI:  https://www.evolucionstreaming.com
Domain Path: /languages/
Text Domain: Footer_Navidad
 */

defined('ABSPATH') or die('No script please!');

define('DocFooterNavidad', plugin_dir_path(__FILE__));
define('ARCFooterNavidad', plugin_dir_url(__FILE__));


require_once  DocFooterNavidad.'plugin-update-checker/plugin-update-checker.php';

$myUpdateChecker = Puc_v4_Factory :: buildUpdateChecker (
	 'https://grupoevolucion.com.ar/repository/plugins/Footer_Navidad/details.json' ,
	__FILE__,'Footer_Navidad' 
);


function mi_inicio() {
	if(!is_admin()) {
	    
		wp_deregister_script('jquery');

		wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.3.2', true);

		wp_enqueue_script('jquery');
	}
}
add_action('init', 'mi_inicio');


function footer_navidad_js(){
        wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'footer_navidad_js');



// Menú
add_action( 'admin_menu', 'Footer_Navidad_add_admin_menu' );
add_action( 'admin_init', 'Footer_Navidad_settings_init' );

function Footer_Navidad_add_admin_menu(  ) { 

	add_menu_page( 'Footer Navidad', 'Footer Navidad', 'manage_options', 'Footer_Navidad', 'Footer_Navidad_options_page' );

}
function Footer_Navidad_settings_init(  ) { 

	register_setting( 'pluginPage', 'Footer_Navidad_settings' );

	add_settings_section(
		'Footer_Navidad_pluginPage_section', 
		__( '', 'Footer Navidad' ), 
		'Footer_Navidad_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'Footer_Navidad_text_field_1', 
		__( 'Texto inicio del conteo:', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_1_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section',
		[
			'label_for' => 'Footer_Navidad_text_field_1'
		] );
	

	add_settings_field( 
		'Footer_Navidad_text_field_2', 
		__( 'Texto 1 fin del conteo:', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_2_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_2'
		] );
	
	add_settings_field( 
		'Footer_Navidad_text_field_3', 
		__( 'Texto 2 fin del conteo:', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_3_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_3'
		] );
	
	add_settings_field( 
		'Footer_Navidad_text_field_4', 
		__( 'Escribe un deseo', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_4_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_4'
		] );
	
	add_settings_field( 
		'Footer_Navidad_text_field_5', 
		__( 'Nombre de empresa', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_5_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_5'
		] );
	
	add_settings_field( 
		'Footer_Navidad_text_field_6', 
		__( 'Slogan de empresa', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_6_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_6'
		] );
	
	add_settings_field( 
		'Footer_Navidad_text_field_7', 
		__( 'Dirección del sitio (URL):', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_7_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_7'
		] );
	
	add_settings_field( 
		'Footer_Navidad_select_field_0', 
		__( 'Seleccione zona horaria:', 'Footer_Navidad' ), 
		'Footer_Navidad_select_field_0_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_0'
		] );
	add_settings_field( 
		'Footer_Navidad_text_field_9', 
		__( 'Subir imagen:', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_9_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section', 
	[
			'label_for' => 'Footer_Navidad_text_field_9'
		] );
		
	add_settings_field( 
		'Dia', 
		__( 'Fecha y Hora:', 'Footer_Navidad' ), 
		'Footer_Navidad_text_field_8_render', 
		'pluginPage', 
		'Footer_Navidad_pluginPage_section',
		[
			'label_for' => 'Dia'
		] );
		
	


}

function Footer_Navidad_select_field_0_render(  ) { 
$options = get_option( 'Footer_Navidad_settings' );
$current_offset = get_option( 'gmt_offset' );
$tzstring   = $options['Footer_Navidad_select_field_0'];

$check_zone_info = false;

// Remove old Etc mappings. Fallback to gmt_offset.
if ( false !== strpos( $tzstring, 'Etc/GMT' ) ) {
	$tzstring = '';
}

if ( empty( $tzstring ) ) { // Create a UTC+- zone if no timezone string exists.
	$check_zone_info = false;
	if ( 0 == $current_offset ) {
		$tzstring = 'UTC+0';
	} elseif ( $current_offset < 0 ) {
		$tzstring = 'UTC' . $current_offset;
	} else {
		$tzstring = 'UTC+' . $current_offset;
	}
}

function upload_user_file( $file = array(),$path ) {
    if(!empty($file)) 
    {


        $upload_dir=$path;
        $uploaded=move_uploaded_file($file['tmp_name'], $upload_dir.$file['name']);
        if($uploaded) 
        {
            echo "uploaded successfully ";

        }else
        {
            echo "some error in upload " ;print_r($file['error']);  
        }
    }

}

	?>
	
<select name='Footer_Navidad_settings[Footer_Navidad_select_field_0]' id="Footer_Navidad_text_field_0">
		
		<?php echo wp_timezone_choice( $tzstring, get_user_locale() ); ?>
	</select>
	
<p class="description" id="timezone-description">
<?php
	printf(
		/* translators: %s: UTC abbreviation */
		__( 'Choose either a city in the same timezone as you or a %s (Coordinated Universal Time) time offset.' ),
		'<abbr>UTC</abbr>'
	);
	?>
</p>


	
	<?php

}

function Footer_Navidad_text_field_1_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_1'])? 'Falta Para Año Nuevo...':$options['Footer_Navidad_text_field_1'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_1]' id="Footer_Navidad_text_field_1" value='<?php echo esc_html_e( $value ); ?>' class="regular-text">
	<?php

}


function Footer_Navidad_text_field_2_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_2'])? 'feliz':$options['Footer_Navidad_text_field_2'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_2]' id="Footer_Navidad_text_field_2" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_3_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_3'])? 'año nuevo':$options['Footer_Navidad_text_field_3'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_3]' id="Footer_Navidad_text_field_3" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_4_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_4'])? '¡ LES DESEAMOS MUCHAS FELICIDADES !':$options['Footer_Navidad_text_field_4'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_4]' id="Footer_Navidad_text_field_4" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_5_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_5'])? 'EVOLUCION STREAMING - SERVICIOS INFORMÁTICOS':$options['Footer_Navidad_text_field_5'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_5]' id="Footer_Navidad_text_field_5" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_6_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_6'])? '¡Sigamos Creciendo Juntos!':$options['Footer_Navidad_text_field_6'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_6]' id="Footer_Navidad_text_field_6" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_7_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_7'])? 'https://www.evolucionstreaming.com.ar':$options['Footer_Navidad_text_field_7'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_7]' id="Footer_Navidad_text_field_7" value='<?php echo $value; ?>' class="regular-text">
	<?php

}

function Footer_Navidad_text_field_9_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$value = empty($options['Footer_Navidad_text_field_9'])? './wp-content/plugins/Footer_Navidad/images/felices-fiestas.gif':$options['Footer_Navidad_text_field_9'];
	?>
	<input type='text' name='Footer_Navidad_settings[Footer_Navidad_text_field_9]' id="Footer_Navidad_text_field_9" value='<?php echo $value; ?>' class="regular-text">
	<button id='btnsubir' class='btn btn-success'>Subir</button>
	<?php

}

function Footer_Navidad_text_field_8_render(  ) { 

	$options = get_option( 'Footer_Navidad_settings' );
	$valued = empty($options['Dia'])? '01':$options['Dia'];
	$valuem = empty($options['Mes'])? '01':$options['Mes'];
	$valuey = empty($options['Anio'])? '2023':$options['Anio'];
	$valueh = empty($options['Hora'])? '00':$options['Hora'];
	$valuen = empty($options['Minuto'])? '00':$options['Minuto'];
	$values = empty($options['Segundo'])? '00':$options['Segundo'];
	?>
	<input type='text' name='Footer_Navidad_settings[Dia]' id="Dia" value='<?php echo $valued; ?>' class="small-text"> del 
	<input type='text' name='Footer_Navidad_settings[Mes]' id="Mes" value='<?php echo $valuem; ?>' class="small-text"> del 
	<input type='text' name='Footer_Navidad_settings[Anio]' id="Anio" value='<?php echo $valuey; ?>' class="small-text"> a las 
	<input type='text' name='Footer_Navidad_settings[Hora]' id="Hora" value='<?php echo $valueh; ?>' class="small-text">:
	<input type='text' name='Footer_Navidad_settings[Minuto]' id="Minuto" value='<?php echo $valuen; ?>' class="small-text">:
	<input type='text' name='Footer_Navidad_settings[Segundo]' id="Segundo" value='<?php echo $values; ?>' class="small-text">
	<?php

}



function Footer_Navidad_settings_section_callback(  ) { 

	echo __( '', 'Footer_Navidad' );
}


function Footer_Navidad_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<nav class="navbar navbar-default">
	<img src="<?php echo ARCFooterNavidad; ?>images/logo.png" width="72" height="72" style="float:left; margin:7px">
    <h2>Christmas and New Year countdown</h2>
	<p>Complete la configuración necesaria a continuación para disfrutar de todas las funcione correctamente.</p>
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
     
    </div>
  </div>
</nav>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<script>
		    var wkMedia;
		    
            jQuery('#btnsubir').click(function(e) {
                e.preventDefault();
                if (wkMedia) {
                  wkMedia.open();
                  return;
                }
        
                wkMedia = wp.media.frames.file_frame = wp.media({
                  title: 'Select media',
                  button: {
                  text: 'Select media'
                }, multiple: false });
                
                wkMedia.on('select', function() {
                  var attachment = wkMedia.state().get('selection').first().toJSON();
                  document.getElementById('Footer_Navidad_text_field_9').value = attachment.url;
                });
                
                wkMedia.open();
            });
		</script>
		<?php

}

// fin menú

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'Footer_Navidad_action_links');
add_filter('network_admin_plugin_action_links_' . plugin_basename(__FILE__), 'Footer_Navidad_action_links');

function Footer_Navidad_action_links($links) {
	$url = get_admin_url() . "admin.php?page=Footer_Navidad";
    $links[] = '<a href="' . $url . '">' . __('Ajustes', 'textdomain') . '</a>';
    $links[] = '<a style="color:black">' . __('Support') . ':</a>';
    $links[] = '<br><center style="width:275px;color:white;background-color:#02a0d2;border-radius:0px 30px">info@evolucionstreaming.com</center>';
    return $links;
}


function create_Footer_Navidad () {
    $options = get_option( 'Footer_Navidad_settings' );
    $Textoiniciodelconteo = $options['Footer_Navidad_text_field_1'];
    $Texto1findelconteo = $options['Footer_Navidad_text_field_2'];
    $Texto2findelconteo = $options['Footer_Navidad_text_field_3'];
    $Escribeundeseo = $options['Footer_Navidad_text_field_4'];
    $Nombredeempresa = $options['Footer_Navidad_text_field_5'];
    $Slogandeempresa = $options['Footer_Navidad_text_field_6'];
    $URL = $options['Footer_Navidad_text_field_7'];
    $timeZone = $options['Footer_Navidad_select_field_0'];
    $img = empty($options['Footer_Navidad_text_field_9'])? './wp-content/plugins/Footer_Navidad/images/felices-fiestas.gif':$options['Footer_Navidad_text_field_9'];
    $Dia = $options['Dia'];
    $Mes = $options['Mes'];
    $Anio = $options['Anio'];
    $Hora = $options['Hora'];
    $Minuto = $options['Minuto'];
    $Segundo = $options['Segundo'];
echo '<script>
var FooterNavidad = document.createElement("div");
FooterNavidad.insertAdjacentHTML("beforeend", `
<div id="om-pwclai62kz1vbdo4ygaw-holder"><style data-styled="true" data-styled-version="5.1.1">.ccRSXc .ModalV2__Content--header{-webkit-align-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;-ms-flex-pack:end;justify-content:flex-end;line-height:1;padding:10px 10px 10px 20px;width:100%;}/*!sc*/
.ccRSXc .ModalV2__Content--header-close{color:#9fb5da;cursor:pointer;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;padding:10px;}/*!sc*/
.ccRSXc .ModalV2__Content--content{height:100%;overflow:auto;padding:0 50px 50px;width:100%;}/*!sc*/
.ccRSXc .ModalV2__Content{background-color:#fff;border-radius:4px;border:none;box-shadow:0 0 18px 6px rgba(35,48,70,0.25);display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-direction:column;-ms-flex-direction:column;flex-direction:column;max-width:650px;outline:none;overflow:auto;width:100%;}/*!sc*/
.ccRSXc .ModalV2__Content p{line-height:1.4;}/*!sc*/
.ccRSXc .ModalV2__Content p a{color:#0d82df;font-weight:bold;-webkit-text-decoration:underline;text-decoration:underline;}/*!sc*/
.ccRSXc .ModalV2__Overlay{-webkit-align-items:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:rgba(255,255,255,0.8);bottom:0;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;-ms-flex-pack:center;justify-content:center;left:0;position:fixed;right:0;top:0;z-index:1010;}/*!sc*/
data-styled.g23[id="ModalV2__StyledModal-sc-1yn120z-0"]{content:"ccRSXc,"}/*!sc*/
.ciWEKZ{font-family:proxima-nova,Proxima Nova,Helvetica,Arial,sans-serif;}/*!sc*/
.ciWEKZ *{box-sizing:border-box;}/*!sc*/
.ciWEKZ .ModalV2__Content--header{background-color:#087ce1;height:60px;padding:20px 40px;-webkit-box-pack:justify;-webkit-justify-content:space-between;-ms-flex-pack:justify;justify-content:space-between;}/*!sc*/
.ciWEKZ .ModalV2__Content--header-content{color:#ffffff;font-size:20px;font-weight:700;display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;}/*!sc*/
.ciWEKZ .ModalV2__Content--header-content svg{margin-right:8px;}/*!sc*/
.ciWEKZ .ModalV2__Content--header-close{color:#abb7ce;background-color:transparent;border:none;padding:0px;}/*!sc*/
.ciWEKZ .ModalV2__Content--header-close svg{width:14px;height:14px;}/*!sc*/
.ciWEKZ .ModalV2__Content--content{padding:20px 40px;}/*!sc*/
.ciWEKZ .ModalV2__Content{max-width:570px;max-height:80%;}/*!sc*/
.ciWEKZ .ModalV2__Overlay{background-color:rgba(68,77,94,0.6);}/*!sc*/
data-styled.g24[id="Modal__StyledModal-sc-1vmqztf-0"]{content:"ciWEKZ,"}/*!sc*/
.eqRYDV *{box-sizing:border-box;font-family:proxima-nova,Proxima Nova,Helvetica,Arial,sans-serif;}/*!sc*/
.eqRYDV .ModalV2__Content--header{background-color:#ffffff;height:40px;padding:20px 20px 10px 20px;-webkit-box-pack:end;-webkit-justify-content:flex-end;-ms-flex-pack:end;justify-content:flex-end;}/*!sc*/
.eqRYDV .ModalV2__Content--header-close{color:#abb7ce;background-color:transparent;border:none;padding:0px;}/*!sc*/
.eqRYDV .ModalV2__Content--header-close svg{width:14px;height:14px;}/*!sc*/
.eqRYDV .ModalV2__Content--content{padding:0 60px 40px 60px;}/*!sc*/
.eqRYDV .ModalV2__Content{max-height:80%;max-width:570px;min-width:500px;width:570px;}/*!sc*/
data-styled.g25[id="WhiteModal__StyledModal-sc-147xomf-0"]{content:"eqRYDV,"}/*!sc*/
.oQvIu {position: absolute !important;cursor: pointer !important;z-index: 1110 !important;border: none !important;background: linear-gradient(to left bottom, #CC0000 50%, #b80000 50%) !important;padding-top: 5px !important;padding-right: 5px !important;padding-bottom: 5px !important;padding-left: 5px !important;margin-top: 15px !important;margin-right: 15px !important;margin-bottom: 0px !important;margin-left: 0px !important;fill: #ffffff !important;border-radius: 5px !important;min-width: auto !important;}/*!sc*/
.oQvIu:hover,.oQvIu.is-editing-hover{border:none !important;background: #5b5b5b !important;fill:#ffffff !important;}/*!sc*/
.oQvIu svg{fill:inherit !important;}/*!sc*/
data-styled.g216[id="CloseButton__ButtonElement-sc-79mh24-0"]{content:"oQvIu,"}/*!sc*/
.feliz-navida-01 {
    text-transform: uppercase;
    letter-spacing: 0px;
    background-color: rgb(250, 7, 4);
    color: rgb(255, 255, 255);
    border-radius: 5px;
    padding: 5px !important;
}

</style></div><div id="om-nvrrhh3nkcbmafsjd6u9-holder"></div><div id="om-pwclai62kz1vbdo4ygaw" class="oklahomacity-campaign Campaign CampaignType--floating" style="border: 0px none; float: none; letter-spacing: normal; outline: currentcolor none medium; text-decoration: none; text-indent: 0px; text-shadow: none; text-transform: none; visibility: visible; line-height: 1; font-family: Arial, sans-serif; box-shadow: none; appearance: none; position: fixed; z-index: 666666666; left: 0px; width: 100%; margin: 0px; padding: 0px; overflow: visible; min-height: 1px; display: block; bottom: 0px; transition: bottom 0.3s ease 0s;"><div id="om-pwclai62kz1vbdo4ygaw-optin" class="oklahomacity-c-canvas Campaign__canvas" style="width: 100%; display: block;"><div class="oklahomacity-c-wrapper Campaign__innerWrapper" style="position:relative"><button id="Cerrar" class="CloseButton__ButtonElement-sc-79mh24-0 oQvIu oklahomacity-CloseButton oklahomacity-close oklahomacity-ClosePosition--top-right" style="top:0;right:0;bottom:auto;left:auto" title=" Cerrar "><svg viewBox="0 0 1792 1792" style="display:block;height:18px;width:18px"><path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z"></path></svg></button><div class="oklahomacity-c-alpha Campaign__alphaLayer" style="background-color: rgba(255, 255, 255, 0.9);border-top-width:2px;border-right-width:0px;border-bottom-width:0px;border-left-width:0px;border-color:#D40323;border-style:solid;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;box-shadow:0px 0px 0px 0px rgba(0, 0, 0, 0);position:relative;border-top: 3px solid white;filter: drop-shadow(rgb(204, 204, 204) 0px -1px 1px);"><div class="oklahomacity-c-bravo Campaign__bravoLayer"><div id="Cerrar-footer" style="position: absolute;left: 0px;top: -23px;cursor: pointer;" title="Ocultar" onclick="AatroxIcon()"><div style="" id="adzone_footer_text_ad-slot-footer"><img style="width:47px;height:20px;" src="'.ARCFooterNavidad.'images/footer_close_left.png" id="Aatrox"></div></div><a href="'.$URL.'" target="_blank" style="text-decoration: none;"><div class="oklahomacity-c-content Campaign__content" style="position:relative;display:block;text-align:center;margin:0 auto;clear:both;max-width:980px;padding-top:0.0001em;padding-right:0.0001em;padding-left:0.0001em;padding-bottom:0.0001em;background:none"><style id="om-pwclai62kz1vbdo4ygaw-ResetCSS" type="text/css">html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas applet,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas object,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas div:not(.Campaign__content):not(.Row__content):not(.Column__content):not(.Element__content):not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas span:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas iframe,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h1:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h2:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h3:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h4:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h5:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas h6:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas p,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas blockquote,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas pre,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas a:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas abbr,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas acronym,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas address,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas big,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas cite,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas code,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas del,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas dfn,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas em,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas img,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas ins,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas kbd,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas q,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas s,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas samp,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas small,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas strike,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas strong,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas sub,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas sup,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas tt,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas var,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas b,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas u,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas center,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas dl,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas dt,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas dd,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas ol:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas ul:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas li:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas fieldset,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas form,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas label:not(.ignore-reset),html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas legend,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas table,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas caption,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas tbody,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas tfoot,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas thead,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas tr,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas th,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas td,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas article,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas aside,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas canvas,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas details,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas embed,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas figure,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas figcaption,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas footer,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas header,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas hgroup,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas menu,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas nav,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas output,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas ruby,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas section,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas summary,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas time,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas mark,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas audio,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas video,html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas i:not(.fa){margin: 0;padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;}html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas div.Campaign__content, html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas div.Row__content, html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas div.Column__content, html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas div.Element__content{margin: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline;}</style><style id="om-pwclai62kz1vbdo4ygaw-CampaignCSS" type="text/css">
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas *:not(.ignore-reset){box-sizing:border-box}
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas .Element__content {min-height: 30px}
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-c-canvas button:not(.ignore-reset) {width: auto;}
	
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input:not([type="submit"]):not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper select:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper textarea:not(.ignore-reset) {
		background-color: #fff;
		width: 100%;
		height: auto;
		border: 1px solid;
		padding: 10px 6px;
		overflow: hidden;
		margin: 0;
		vertical-align: middle;
		font-style: normal;
		width: 100%;
		line-height: 1.5
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper textarea:not(.ignore-reset) {
		height: 60px;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper textarea:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input:not(.ignore-reset) {
		overflow: hidden;
		-webkit-appearance: none;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input[type=submit]:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper button:not(.ignore-reset) {
		cursor: pointer;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input[type=checkbox]:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input[type=radio]:not(.ignore-reset) {
		width: auto !important;
		outline: invert none medium;
		padding: 0;
		margin: 0;
		height: auto !important;
		box-shadow: none;
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		display: inline;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input[type=checkbox]:not(.ignore-reset) {
		-webkit-appearance: checkbox;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper input[type=radio]:not(.ignore-reset) {
		-webkit-appearance: radio;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper.FieldsElement--vertical input:not(.ignore-reset) {

	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper.FieldsElement--horizontal input:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper.FieldsElement--horizontal button:not(.ignore-reset) {

	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper.FieldsElement--horizontal .FieldsElement--privacyText:not(.ignore-reset) {

	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper strong:not(.ignore-reset) {
		font-weight: bolder;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper em:not(.ignore-reset) {
		font-style: italic;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper ul:not(.ignore-reset) {
		list-style-type: disc;
		margin: 1em 0 1em 1.5em;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper ol:not(.ignore-reset) {
		list-style: decimal;
		margin: 1em 0 1em 1.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper sup:not(.ignore-reset) {
	top: -0.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper sub:not(.ignore-reset) {
	bottom: -0.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper sub:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper sup:not(.ignore-reset) {
		font-size: 75%;
		line-height: 0;
		position: relative;
		vertical-align: baseline;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper p:not(.ignore-reset) {
		margin: 0 0 5px;
		font-weight: inherit !important;
		line-height: inherit !important;
		letter-spacing: inherit !important;
		text-transform: inherit !important;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper p:first-of-type:not(.ignore-reset) {
		margin-top: 0;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-FieldsElement--wrapper p:last-of-type:not(.ignore-reset) {
		margin-bottom: 0;
	}
	
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content strong:not(.ignore-reset) {
		font-weight: bolder;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content em:not(.ignore-reset) {
		font-style: italic;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content ul:not(.ignore-reset) {
		list-style-type: disc;
		margin: 1em 0 1em 1.5em;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content ol:not(.ignore-reset) {
		list-style: decimal;
		margin: 1em 0 1em 1.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content sup:not(.ignore-reset) {
		top: -0.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content sub:not(.ignore-reset) {
		bottom: -0.5em;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content sub:not(.ignore-reset),
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content sup:not(.ignore-reset) {
		font-size: 75%;
		line-height: 0;
		position: relative;
		vertical-align: baseline;
	}

	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content p:not(.ignore-reset) {
		margin: 0 0 5px;
		font-weight: inherit !important;

		letter-spacing: inherit !important;
		text-transform: inherit !important;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content span.fr-emoticon:not(.ignore-reset) {
		vertical-align: middle !important;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content p:first-of-type:not(.ignore-reset){
		margin-top: 0;
	}
	html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content p:last-of-type:not(.ignore-reset) {
		margin-bottom: 0;
	}
	@media screen and (min-width: 1px) and (max-width: 768px) {
	    #oklahomacity-CountdownElement--wrapper--tjtRU67dMo8sR2hNSkvW {text-align: -webkit-center !important;}
	    .feliz-navida-01 {width: 33%;font-size: 22px !important;float: left;}
	    .feliz-navida-02 {float: left;left: -17px;margin: 5px 153px !important;margin-top: -22.5px !important;padding: 7px !important;}
	    .feliz-navida-03 {margin-bottom: -15px !important;margin-top: 18px !important;}
	    #feliz-navidad {position: relative;top: 0;left: 34%;margin-right: -51% !important;transform: translate(-48%, 14%);}
        .deseamos {letter-spacing: 0px !important;font-size: 18px !important;}
        .nameempresa {font-family: sans-serif!important;}
        #contador {margin-left: -60px !important;margin-bottom: 30px !important;padding-right: 8%;}
	    html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-TextElement--content p {font-size: 18px !important;padding: 0px 15px 5px 15px;}
        .sigamosclass {margin-bottom: 20px !important;}
        .sigamosclass2 {font-size: 22px !important;font-weight: 700 !important;}
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-ClosePosition--top-right { right: 0 !important }
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-ClosePosition--top-left { left: 0 !important }
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-ClosePosition--bottom-right { right: 0 !important }
		html div#om-pwclai62kz1vbdo4ygaw .oklahomacity-ClosePosition--bottom-left { left: 0 !important }

		html div#om-pwclai62kz1vbdo4ygaw .Row .Row__content { flex-direction: column; }
		html div#om-pwclai62kz1vbdo4ygaw .Row .Row__content .Column { width: 100% !important; }

		html div#om-pwclai62kz1vbdo4ygaw .FieldsElement--horizontal button {
			width: 100% !important;
		}
	}@media screen and (min-width: 1px) and (max-width: 400px) {
    .deseamos {font-size: 16px !important;}
    .nameempresa {font-size: 12px !important;}
    }
    @media screen and (min-width: 1px) and (max-width: 428px) {}</style><style id="om-pwclai62kz1vbdo4ygaw-CustomCSS" type="text/css"></style><div class="oklahomacity-row oklahomacity-row-1 Row"><div class="oklahomacity-row-content Row__content"><div class="oklahomacity-row-inner" style="display:flex;width:100%;flex-direction:inherit;align-items:center;background:transparent;border-style:solid;border-color:#000000;border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;box-shadow:0px 0px 0px 0px #ffffff;max-width:100%;z-index:0"><div class="oklahomacity-column oklahomacity-col-1 Column" style="display:inline-block;width:30%"><div class="oklahomacity-col-content Column__content" style="height:100%"><div class="oklahomacity-col-inner" style="align-items:flex-start;background:transparent;border-style:solid;border-color:#000000;border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;box-shadow:0px 0px 0px 0px #ffffff;max-width:100%;z-index:0;height:100%"><div class="oklahomacity-element oklahomacity-ele-1 Element"><div class="oklahomacity-ele-content Element__content"><div id="oklahomacity-ImageElement--wrapper--IoPtYMWIbCZ2FncBqqSL" class="oklahomacity-imge-wrapper oklahomacity-ImageElement--wrapper " style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:5px;padding-right:5px;padding-bottom:5px;padding-left:5px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;background:transparent;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;position:relative;z-index:0;overflow:visible;text-align:center;font-size:0"><div class="oklahomacity-imge-content oklahomacity-ImageElement--content"><img src="'.$img.'" style="max-width:100%;height:auto;display:inline;border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-right-radius:0px;border-bottom-left-radius:0px;border-top-width:0px;border-right-width:0px;border-bottom-width:0px;border-left-width:0px;border-style:solid;border-color:#ffffff;box-shadow:0px 0px 0px 0px #ffffff;opacity:1;width:75%" width="213" height="136"></div></div></div></div></div></div></div><div id="feliz-navidad" class="oklahomacity-column oklahomacity-col-2 Column" style="display:inline-block;width:35%"><div id="contador" class="oklahomacity-col-content Column__content" style="height:100%"><div class="oklahomacity-col-inner" style="align-items:flex-start;background:transparent;border-style:solid;border-color:#000000;border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;box-shadow:0px 0px 0px 0px #ffffff;max-width:100%;z-index:0;height:100%"><div class="oklahomacity-element oklahomacity-ele-1 Element"><div class="oklahomacity-ele-content Element__content"><div class="oklahomacity-te-wrapper oklahomacity-TextElement--wrapper " id="oklahomacity-TextElement--wrapper--myYVkDki8hfo6rfyOFIn" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0px;border-right-width:0px;border-bottom-width:0px;border-left-width:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;background:transparent;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;position:relative;z-index:0"><div class="oklahomacity-te-content oklahomacity-TextElement--content" style="overflow-wrap:break-word;color:#000000;font-family:Montserrat;font-weight:400;font-size:16px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal;text-align:left"><p style="text-align: center; line-height: 1.2;"><span style="font-size: 22px; font-family: &quot;Noto Sans&quot;; font-weight: 600;"><span style="letter-spacing: -2px;"><span style="font-size: 22px; font-family: &quot;Noto Sans&quot;; font-weight: 600;"><span style="letter-spacing: -2px;"><span style="background-color: rgb(212, 3, 35); color: rgb(255, 255, 255);"> </span></span></span><span id="feliz-navida-01" style="text-transform: uppercase;letter-spacing: 0px;">'.$Textoiniciodelconteo.'</span></span></span></p></div></div></div></div><div class="oklahomacity-element oklahomacity-ele-2 Element"><div class="oklahomacity-ele-content Element__content"><div class="oklahomacity-cde-wrapper oklahomacity-CountdownElement--wrapper " id="oklahomacity-CountdownElement--wrapper--tjtRU67dMo8sR2hNSkvW" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-top:10px;margin-right:0px;margin-bottom:0px;margin-left:0px;background:transparent;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;position:relative;z-index:0;text-align:center"><div id="oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW" class="oklahomacity-cde-content oklahomacity-CountdownElement--content" data-omcd-time="1637981940" data-omcd-type="static" data-omcd-id="tjtRU67dMo8sR2hNSkvW" data-omcd-local="false"><div class="oklahomacity-days" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;margin-top:0px;margin-right:5px;margin-bottom:0px;margin-left:5px;background: #fa0704;border-style:solid;border-color: #000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;min-width:60px;display:inline-block;text-align:center;z-index:0;"><span id="c_d" class="number-string number-days" style="color:#ffffff;font-family:Noto Sans;font-weight:600;font-size:30px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">0</span><div class="unit-days" style="color:#ffffff;font-family:Noto Sans;font-weight:500;font-size:12px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">D</div></div><div class="oklahomacity-hours" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;margin-top:0px;margin-right:5px;margin-bottom:0px;margin-left:5px;background: #fa0704;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;min-width:60px;display:inline-block;text-align:center;z-index:0;"><span id="c_h" class="number-string number-hours" style="color:#ffffff;font-family:Noto Sans;font-weight:600;font-size:30px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">00</span><div class="unit-hours" style="color:#ffffff;font-family:Noto Sans;font-weight:500;font-size:12px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">H</div></div><div class="oklahomacity-minutes" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;margin-top:0px;margin-right:5px;margin-bottom:0px;margin-left:5px;background: #fa0704;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;min-width:60px;display:inline-block;text-align:center;z-index:0;"><span id="c_m" class="number-string number-minutes" style="color:#ffffff;font-family:Noto Sans;font-weight:600;font-size:30px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">00</span><div class="unit-minutes" style="color:#ffffff;font-family:Noto Sans;font-weight:500;font-size:12px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">M</div></div><div class="oklahomacity-seconds" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;margin-top:0px;margin-right:5px;margin-bottom:0px;margin-left:5px;background: #fa0704;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;min-width:60px;display:inline-block;text-align:center;z-index:0;"><span id="c_s" class="number-string number-seconds" style="color:#ffffff;font-family:Noto Sans;font-weight:600;font-size:30px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">00</span><div class="unit-seconds" style="color:#ffffff;font-family:Noto Sans;font-weight:500;font-size:12px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal">S</div></div></div></div></div></div></div></div></div><div class="oklahomacity-column oklahomacity-col-3 Column" style="display:inline-block;width:48%"><div class="oklahomacity-col-content Column__content" style="height:100%"><div class="oklahomacity-col-inner" style="align-items:flex-start;background:transparent;border-style:solid;border-color:#000000;border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0;border-right-width:0;border-bottom-width:0;border-left-width:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;box-shadow:0px 0px 0px 0px #ffffff;max-width:100%;z-index:0;height:100%"><div class="oklahomacity-element oklahomacity-ele-1 Element"><div class="oklahomacity-ele-content Element__content"><div class="oklahomacity-te-wrapper oklahomacity-TextElement--wrapper " id="oklahomacity-TextElement--wrapper--y552zk3mEdUcb17reKv2" style="border-top-left-radius:0%;border-top-right-radius:0%;border-bottom-right-radius:0%;border-bottom-left-radius:0%;border-top-width:0px;border-right-width:0px;border-bottom-width:0px;border-left-width:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;background:transparent;border-style:solid;border-color:#000000;box-shadow:0px 0px 0px 0px #ffffff;width:auto;max-width:100%;position:relative;z-index:0"><div class="oklahomacity-te-content oklahomacity-TextElement--content" style="overflow-wrap:break-word;color:#000000;font-family:Montserrat;font-weight:400;font-size:16px;text-transform:none;text-decoration:none;line-height:1;letter-spacing:0;font-style:normal;text-align:left"><p style="font-size: 22px;font-family: &quot;Noto Sans&quot;;text-align: center;"><span class="deseamos" style="letter-spacing: -2px;color: rgb(255, 255, 255);background-color: rgb(232 3 0);border-radius: 5px;">&nbsp;&nbsp;'.$Escribeundeseo.'&nbsp;&nbsp;</span></p><p style="text-align: center; line-height: 1.2;"><span class="nameempresa" style="font-size: 13px;font-family: cursive;font-weight: 600;text-align: center;"><span style="letter-spacing: 0px;color: rgb(0 0 0);">'.$Nombredeempresa.'</span></span></p><p class="sigamosclass" style="text-align: center; line-height: 1.2;"><span class="sigamosclass2" style="font-size: 20px;font-family: cursive;font-weight: 500;"><span style="letter-spacing: 0px;">'.$Slogandeempresa.'</span></span></p></div></div></div></div></div></div></div></div></div></div><div id="om-pwclai62kz1vbdo4ygaw-CustomJS" style="display:none"><div id="countdown" class="oklahomacity-cde-content oklahomacity-CountdownElement--content" style="margin-bottom: 12px">
<ul id="oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW"></ul>

</div></div></div></div></div></a></div></div></div></div>`);
document.getElementsByTagName("body")[0].appendChild(FooterNavidad);
-  (function () {
                            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
                            let countDown = new Date("'.$Anio.'-'.$Mes.'-'.$Dia.'T'.$Hora.':'.$Minuto.':'.$Segundo.'").getTime();
                            let x = setInterval(function() {
                                let now = new Date().toLocaleString("ja", {hour12: false, timeZone: "'.$timeZone.'"});
                                now     = new Date(now).getTime();
                                let distance = countDown - now;
                                document.getElementById("c_d").innerText = Math.floor(distance / (day));
                                document.getElementById("c_h").innerText = ("0" + Math.floor((distance % (day)) / (hour))).slice(-2);
                                document.getElementById("c_m").innerText = ("0" + Math.floor((distance % (hour)) / (minute))).slice(-2);
                                document.getElementById("c_s").innerText = ("0" + Math.floor((distance % (minute)) / second)).slice(-2);
                                if (distance < 0) {
                                    document.getElementById("countdown").classList.add("om-pwclai62kz1vbdo4ygaw");
                                    document.getElementById("c_d").innerText = ("0");
                                    document.getElementById("c_h").innerText = ("00");
                                    document.getElementById("c_m").innerText = ("00");
                                    document.getElementById("c_s").innerText = ("00");
                                    document.getElementById("feliz-navida-01").innerHTML = "<span>'.$Texto1findelconteo.'</span>";
                                    document.getElementById("feliz-navida-01").classList.add("feliz-navida-01", "feliz-navida-03");
                                    document.getElementById("oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").classList.add("feliz-navida-01", "feliz-navida-02");
                                    document.getElementById("oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").innerHTML = "<span>'.$Texto2findelconteo.'</span>";
                                    $("#oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").css("font-family", "Noto Sans");
                                    $("#oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").css("margin", "5px 115px");
                                    $("#oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").css("font-weight", "600");
                                    $("#oklahomacity-CountdownElement--tjtRU67dMo8sR2hNSkvW").css("font-size", "22px");
                                    
                                    clearInterval(x);
                                }
                            }, 200)
                        }());
						function cerrar (){
							document.getElementById("om-pwclai62kz1vbdo4ygaw").style.display = "none";
							}
						document.getElementById("Cerrar").onclick = function (){
								cerrar();	
						}	
						
var Aatroxclicks = 0;
function AatroxIcon() {
    Aatroxclicks = Aatroxclicks + 1;
    if (Aatroxclicks % 2 != 0) {
        $("#Aatrox").attr("src", "'.ARCFooterNavidad.'images/footer_open_left.png");
        $("#Cerrar-footer").attr("title", "Mostrar");
        $("#om-pwclai62kz1vbdo4ygaw-optin").attr("style", "height: 0");
    }else{
      $("#Aatrox").attr("src", "'.ARCFooterNavidad.'images/footer_close_left.png");
      $("#Cerrar-footer").attr("title", "Ocultar");
      $("#om-pwclai62kz1vbdo4ygaw-optin").attr("style", "height: auto");
      
      
    }
}
						
</script>';
}
// agrega la acción
add_action ( 'wp_footer' , 'create_Footer_Navidad');


function option_footer_predeterminado()
{
    $argPredeterminado = [
    'Footer_Navidad_text_field_1' => 'Falta Para Año Nuevo...',
    'Footer_Navidad_text_field_2' => 'feliz',
    'Footer_Navidad_text_field_3' => 'año nuevo',
    'Footer_Navidad_text_field_4' => '¡ LES DESEAMOS MUCHAS FELICIDADES !',
    'Footer_Navidad_text_field_5' => 'EVOLUCION STREAMING - SERVICIOS INFORMÁTICOS',
    'Footer_Navidad_text_field_6' => '¡Sigamos Creciendo Juntos!',
    'Footer_Navidad_text_field_7' => 'https://www.evolucionstreaming.com.ar',
    'Footer_Navidad_select_field_0' => 'America/Argentina/Buenos_Aires',
    'Footer_Navidad_select_field_9' => './wp-content/plugins/Footer_Navidad/images/felices-fiestas.gif',
    'Dia' => '01',
    'Mes' => '01',
    'Anio' => '2023',
    'Hora' => '00',
    'Minuto' => '00',
    'Segundo' => '00'
    ];

    update_option("Footer_Navidad_settings", $argPredeterminado);
}

register_activation_hook(__FILE__, 'option_footer_predeterminado');

