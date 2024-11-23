<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );

// Script personalizado
function enqueue_custom_script() {

    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

//Widget
require_once get_stylesheet_directory() . '/widgets/my-widgets.php';

// Función para registrar cpt retos
function registrar_cpt_retos() {
    $labels = [
        'name'               => 'Retos',
        'singular_name'      => 'Reto',
        'add_new'            => 'Añadir Nuevo',
        'add_new_item'       => 'Añadir Nuevo Reto',
        'edit_item'          => 'Editar Reto',
        'new_item'           => 'Nuevo Reto',
        'view_item'          => 'Ver Reto',
        'search_items'       => 'Buscar Retos',
        'not_found'          => 'No se encontraron Retos',
        'not_found_in_trash' => 'No se encontraron Retos en la papelera',
        'all_items'          => 'Todos los Retos',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'retos'],
        'supports'           => ['title', 'editor', 'thumbnail'],
        'menu_icon'          => 'dashicons-awards',
        'show_in_rest'       => true,
    ];

    register_post_type('retos', $args);
}
add_action('init', 'registrar_cpt_retos');

function generar_codigo_unico($post_id) {
    if (get_post_type($post_id) !== 'retos') {
        return;
    }

    if (wp_is_post_revision($post_id)) {
        return;
    }

    if (!get_field('codigo_unico', $post_id)) {
        $codigo_unico = uniqid('');
        update_field('codigo_unico', $codigo_unico, $post_id);
    }
}
add_action('save_post', 'generar_codigo_unico');


function guardar_lead() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'leads';

    $nombre_cliente = sanitize_text_field($_POST['nombre_cliente']);
    $nit = sanitize_text_field($_POST['nit']);
    $nombre_punto = sanitize_text_field($_POST['nombre_punto']);
    $nombre_equipo = sanitize_text_field($_POST['nombre_equipo']);
    $ciudad = isset($_POST['ciudad']) ? sanitize_text_field($_POST['ciudad']) : '';
    $promotor = sanitize_text_field($_POST['promotor']);
    $rtc = sanitize_text_field($_POST['rtc']);
    $capitan_usuario = sanitize_text_field($_POST['capitan_usuario']);
    $ip = $_SERVER['REMOTE_ADDR'];

    if (empty($nombre_cliente) || empty($nit)) {
        echo 'error';
        wp_die();
    }

    $resultado = $wpdb->insert($tabla, [
        'nombre_cliente' => $nombre_cliente,
        'nit' => $nit,
        'nombre_punto' => $nombre_punto,
        'nombre_equipo' => $nombre_equipo,
        'ciudad' => $ciudad,
        'promotor' => $promotor,
        'rtc' => $rtc,
        'capitan_usuario' => $capitan_usuario,
        'ip' => $ip,
    ]);

    if ($resultado) {
        echo 'success';
    } else {
        echo 'error';
    }
    wp_die();
}

add_action('wp_ajax_guardar_lead', 'guardar_lead');
add_action('wp_ajax_nopriv_guardar_lead', 'guardar_lead');

function descargar_leads() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'leads';
    $leads = $wpdb->get_results("SELECT * FROM $tabla", ARRAY_A);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=leads.csv');

    $salida = fopen('php://output', 'w');
    fputcsv($salida, array_keys($leads[0]));
    foreach ($leads as $lead) {
        fputcsv($salida, $lead);
    }
    fclose($salida);
    exit;
}

add_action('admin_post_descargar_leads', 'descargar_leads');

function shortcode_descargar_leads() {

    if (!current_user_can('manage_options')) {
        return '<p>No tienes permisos para descargar los leads.</p>';
    }

    $url = admin_url('admin-post.php?action=descargar_leads');
    return '<a href="' . esc_url($url) . '" class="btn-descargar-leads" style="padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Descargar Leads</a>';
}

add_shortcode('descargar_leads', 'shortcode_descargar_leads');