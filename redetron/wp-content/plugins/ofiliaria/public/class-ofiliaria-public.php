<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://redetronic.com
 * @since      1.0.0
 *
 * @package    Ofiliaria
 * @subpackage Ofiliaria/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ofiliaria
 * @subpackage Ofiliaria/public
 * @author     Ángel Omar Sanz <angelomarsanz@gmail.com>
 */
class Ofiliaria_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    public $vectorCamposWpMeli;
    public $vector_campos_wp_meli_excepciones;
    public $vector_infocasas_campos;
    public $tablas_infocasas;
	public $parametros_importacion_meli;
    
    // --- NUEVO: Propiedad para almacenar las páginas que usan React ---
    private $paginas_usan_react;

    // --- NUEVO: Propiedad para cachear las zonas de Infocasas ---
    private $departamentos_zonas_infocasas = null;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) 
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // --- NUEVO: Inicializar el array de páginas que usan React ---
        // Aquí se definen los slugs de las páginas donde se carga tu aplicación React.
        $this->paginas_usan_react = [
            'garantias',
            'seleccionar-aseguradora', // Asegúrate de que los slugs coincidan con las URLs de tus rutas de React
            'datos-propiedad',
            'datos-arrendatario',
            'personas-adicionales',
            'detalle-garantia',
            'garantia-enviada',
            'revision-garantia',
            'contrato-garantia',
            'inventario-garantia',
            'firma-contrato',
            'pago-garantia'
        ];

		$this->parametros_importacion_meli = 
			[
				'id_autor' => null, // Colocar en null para evitar ejecutar por accidente
				'id_usuario_meli' => '145761976',
				'vector_agentes_id_user_wp' => [
					'Nombre Apellido' => 0
				],
				'url_base' => "https://api.mercadolibre.com/users/145761976/items/search?status=active",
				'importar_solo_la_primera_publicacion' => 'No', // Colocar 'No' si se desea importar todas las publicaciones
				'indicador_verificacion_proceso_descripcion_ejecutado' => 'Sí',
				'indicador_actualizar_descripcion' => 'Sí',
				'ejecutar_obtener_url_archivos' => 'No', // Colocar 'No' para evitar ejecutar por accidente
				'ejecutar_asociar_archivos_publicacion' => 'No', // Colocar 'No' para evitar ejecutar por accidente
			];

        // -----------------------------------------------------------

        add_filter( 'theme_page_templates', array($this, 'agrega_plantillas_select'), 2, 4 );
        add_filter( 'page_template', array($this, 'slug_plantillas'), 1);
        add_filter( 'allowed_http_origins', array($this, 'add_allowed_origins'), 1);
        add_action( 'wp_ajax_validacion_publicacion', array( $this, 'validacion_publicacion') );
        add_action( 'wp_loaded', array($this, 'crear_ayudantes_contenidos'));
        add_action( 'wp_ajax_guardar_token_meli', array( $this, 'guardar_token_meli') );
		add_action( 'wp_ajax_error_token_meli', array( $this, 'error_token_meli') );
        add_action( 'wp_ajax_verificar_token_meli', array( $this, 'verificar_token_meli') );
        add_action( 'wp_ajax_paquetes_usuario_meli', array( $this, 'paquetes_usuario_meli') );
        add_action( 'wp_ajax_preguntas_meli', array( $this, 'preguntas_meli') );
        add_action( 'wp_ajax_validar_inmueble_meli', array( $this, 'validar_inmueble_meli') );
        add_action( 'wp_ajax_mostrar_post', array( $this, 'mostrar_post') );
        add_action( 'wp_ajax_listado_inmuebles', array( $this, 'listado_inmuebles') );
        add_action( 'wp_ajax_obtener_url_archivos', array( $this, 'obtener_url_archivos') );
        add_action( 'wp_ajax_importar_archivo_meli', array( $this, 'importar_archivo_meli') );
        add_action( 'wp_ajax_asociar_archivos_publicacion', array( $this, 'asociar_archivos_publicacion') );
        add_action( 'wp_ajax_cambiar_agente', array( $this, 'cambiar_agente') );
        add_action( 'agregar_publicacion_meli', array( $this, 'envio_publicacion_meli'), 10, 6 );
        add_action( 'editar_publicacion_meli', array( $this, 'envio_publicacion_meli'), 10, 6 );
        add_action( 'agregar_publicacion_infocasas', array( $this, 'publicacion_infocasas'), 10, 3 );
        add_action( 'editar_publicacion_infocasas', array( $this, 'publicacion_infocasas'), 10, 3 );
        add_action( 'eliminar_publicacion_meli', array( $this, 'eliminar_publicacion_meli'), 10, 2 );
        add_shortcode( 'garantias', array( $this, 'garantias_shortcode'));
        add_action( 'wp_ajax_verificar_usuario_conectado', array( $this, 'verificar_usuario_conectado') );
        add_action( 'wp_login', array($this, 'inicio_sesion_laravel'), 10, 2);
        add_action( 'wp_ajax_previo_importar_publicaciones_meli', array( $this, 'previo_importar_publicaciones_meli') );
		add_action( 'wp_ajax_importar_publicaciones_meli', array( $this, 'importar_publicaciones_meli') );
        add_action( 'wp_ajax_buscar_usuarios_infocasas', array( $this, 'buscar_usuarios_infocasas') );
        add_action( 'wp_ajax_crear_xml_infocasas', array( $this, 'crear_xml_infocasas') );
        add_action( 'wp_ajax_reparar_tabla_imagenes', array( $this, 'reparar_tabla_imagenes') );
        add_action( 'wp_ajax_buscar_publicaciones_ofiliaria', array( $this, 'buscar_publicaciones_ofiliaria') );
        add_action( 'wp_ajax_procesar_publicacion_ofiliaria', array( $this, 'procesar_publicacion_ofiliaria') );
        add_action( 'wp_ajax_buscar_publicaciones_descripcion', array( $this, 'buscar_publicaciones_descripcion') );
        add_action( 'wp_ajax_procesar_publicacion_descripcion', array( $this, 'procesar_publicacion_descripcion') );
        add_action( 'wp_ajax_eliminar_indicador_infocasas_publicaciones_importadas', array( $this, 'eliminar_indicador_infocasas_publicaciones_importadas') );
        add_action( 'wp_ajax_buscar_publicaciones_importadas_meli', array( $this, 'buscar_publicaciones_importadas_meli') );
        add_action( 'wp_ajax_procesar_publicacion_importada_meli', array( $this, 'procesar_publicacion_importada_meli') );
        add_filter( 'ofiliaria_filtro_buscar_publicacion_meli', array($this, 'filtro_buscar_publicacion_meli'), 10, 3 );
        add_action( 'wp_ajax_destaque_publicacion_meli', array( $this, 'destaque_publicacion_meli') );
        add_filter( 'ofiliaria_filtro_agentes_agencia', array($this, 'filtro_agentes_agencia'), 10, 2 );
        add_action( 'wp_ajax_reasignacion_de_agente', array( $this, 'reasignacion_de_agente') );
        add_action( 'wp_ajax_buscar_campos_meli', array( $this, 'buscar_campos_meli') );
        add_action( 'wp_ajax_buscar_publicaciones_redimension_imagenes_meli', array( $this, 'buscar_publicaciones_redimension_imagenes_meli') );
        add_action( 'wp_ajax_procesar_publicacion_redimension_imagenes_meli', array( $this, 'procesar_publicacion_redimension_imagenes_meli') );
        add_action( 'wp_ajax_buscar_publicaciones_agregar_whatsapp', array( $this, 'buscar_publicaciones_agregar_whatsapp') );
        add_action( 'wp_ajax_procesar_publicacion_agregar_whatsapp', array( $this, 'procesar_publicacion_agregar_whatsapp') );
        add_action( 'wp_ajax_verificar_datos_envio_publicaciones_meli', array( $this, 'verificar_datos_envio_publicaciones_meli') );
        add_action( 'pausar_activar_publicacion_meli', array( $this, 'pausar_activar_publicacion_meli'), 10, 3 );
		add_action( 'wp_ajax_obtener_publicacion_meli', array( $this, 'obtener_publicacion_meli') );
        
        // --- NUEVO: Filtro para agregar etiqueta (Infocasas) a las ciudades ---
        add_filter( 'ofiliaria_city_select_label', array($this, 'add_infocasas_label_to_city'), 10, 2 );
        
        require_once ABSPATH . 'wp-content/plugins/ofiliaria/includes/tablas/campos_wp_meli.php';
        $this->vectorCamposWpMeli = $wp_meli;
        require_once ABSPATH . 'wp-content/plugins/ofiliaria/includes/tablas/campos_wp_meli_excepciones.php';
        $this->vector_campos_wp_meli_excepciones = $wp_meli_excepciones;
        require_once ABSPATH . 'wp-content/plugins/ofiliaria/includes/tablas/infocasas_campos.php';
        $this->vector_infocasas_campos = $infocasas_campos;
        require_once ABSPATH . 'wp-content/plugins/ofiliaria/includes/tablas/infocasas.php';
        $this->tablas_infocasas = $tablas_infocasas;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ofiliaria_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ofiliaria_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ofiliaria-public.css', array(), time(), 'all' );
        
        // --- NUEVO: Obtener el slug de la página actual ---
        // Se usa get_queried_object() para obtener el objeto del post/página actual.
        // Se accede a post_name si el objeto es una instancia de WP_Post.
        $current_post = get_queried_object();
        $current_slug = $current_post instanceof WP_Post ? $current_post->post_name : '';

        // --- NUEVO: Condición para cargar el CSS del módulo jQuery/JS ---
        // Solo carga el CSS de js_ofiliaria si la página actual NO es una de las páginas de React.
        if (!in_array($current_slug, $this->paginas_usan_react)) {
            wp_enqueue_style("js_ofiliaria_style", plugin_dir_url(__FILE__) . "js_ofiliaria/dist/js_ofiliaria-main-style.css", array(), time(), 'all');
        }
        // ----------------------------------------------------------------
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ofiliaria_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ofiliaria_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        /*
        $id_usuario_wp2 = 0;
        $rol_usuario_wp = 0;

        if (is_user_logged_in()) 
        {
            $usuario_actual_wp = wp_get_current_user();
            $id_usuario_wp2 = $usuario_actual_wp->ID;
            $rol_usuario_wp = intval(get_user_meta($usuario_actual_wp->ID, 'user_estate_role', true));
        }
        */
        $variables_php_javascript = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'client_id_meli' => get_option('_ofiliaria_client_id_meli'),
            'client_secret_meli' => get_option('_ofiliaria_client_secret_meli'),
            // 'id_usuario_wp2' => $id_usuario_wp2,
            // 'rol_usuario_wp' => $rol_usuario_wp 
        );

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ofiliaria-public.js', array( 'jquery' ), time(), false );
        wp_localize_script($this->plugin_name, 'variables_php_javascript', $variables_php_javascript ); 

        // --- NUEVO: Obtener el slug de la página actual ---
        // Se usa get_queried_object() para obtener el objeto del post/página actual.
        // Se accede a post_name si el objeto es una instancia de WP_Post.
        $current_post = get_queried_object();
        $current_slug = $current_post instanceof WP_Post ? $current_post->post_name : '';

        // --- NUEVO: Condición para cargar el JavaScript del módulo jQuery/JS ---
        // Solo carga el JavaScript de js_ofiliaria si la página actual NO es una de las páginas de React.
        if (!in_array($current_slug, $this->paginas_usan_react)) {
            wp_enqueue_script("js_ofiliaria_script", plugin_dir_url(__FILE__) . "js_ofiliaria/dist/js_ofiliaria-main-script.js", array( 'jquery' ), time(), true);
        }
        // -----------------------------------------------------------------------
    }

    public function garantias_shortcode()
    {               
        // Este código sigue siendo el mismo, ya que siempre se cargará cuando el shortcode esté presente.
        wp_enqueue_script("main_ofiliaria_react", plugin_dir_url(__FILE__) . "app_react/garantias/dist/main-script.js", [ "wp-element"], time(), true);
        wp_enqueue_style("main_ofiliaria_react_style", plugin_dir_url(__FILE__) . "app_react/garantias/dist/main-style.css", array(), time(), 'all');
        return "<div class='ra_garantias'></div>";  
    }

	public function agrega_plantillas_select( $post_templates, $wp_theme, $post, $post_type ) 
	{
		$post_templates['ofiliaria-mercadolibre.php'] = __('Mercado Libre');
		$post_templates['garantias.php'] = __('Garantías');
		$post_templates['seleccionar-aseguradora.php'] = __('Seleccionar aseguradora');
		$post_templates['datos-propiedad.php'] = __('Datos propiedad');
		$post_templates['datos-arrendatario.php'] = __('Datos arrendatario');
		$post_templates['personas-adicionales.php'] = __('Personas adicionales');
		$post_templates['detalle-garantia.php'] = __('Detalle garantía');
		$post_templates['garantia-enviada.php'] = __('Garantía enviada');
		$post_templates['revision-garantia.php'] = __('Revisión garantía');
		$post_templates['contrato-garantia.php'] = __('Contrato garantía');
		$post_templates['inventario-garantia.php'] = __('Inventario garantía');
		$post_templates['firma-contrato.php'] = __('Firma contrato');
		$post_templates['pago-garantia.php'] = __('Pago garantía');
		$post_templates['ofiliaria-infocasas.php'] = __('Infocasas');
		$post_templates['notificaciones-meli.php'] = __('Notificaciones Meli');
		$post_templates['notificaciones-infocasas.php'] = __('Notificaciones Infocasas');
    	return $post_templates;
	}

	public function slug_plantillas( $page_template )
	{	
		if ( get_page_template_slug() == 'ofiliaria-mercadolibre.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/ofiliaria-mercadolibre.php';
		}
		else if ( get_page_template_slug() == 'garantias.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/garantias.php';
		}
		else if ( get_page_template_slug() == 'seleccionar-aseguradora.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/seleccionar-aseguradora.php';
		}								
		else if ( get_page_template_slug() == 'datos-propiedad.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/datos-propiedad.php';
		}								
		else if ( get_page_template_slug() == 'datos-arrendatario.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/datos-arrendatario.php';
		}								
		else if ( get_page_template_slug() == 'personas-adicionales.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/personas-adicionales.php';
		}	
		else if ( get_page_template_slug() == 'detalle-garantia.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/detalle-garantia.php';
		}			
		else if ( get_page_template_slug() == 'garantia-enviada.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/garantia-enviada.php';
		}								
		else if ( get_page_template_slug() == 'revision-garantia.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/revision-garantia.php';
		}								
		else if ( get_page_template_slug() == 'contrato-garantia.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/contrato-garantia.php';
		}								
		else if ( get_page_template_slug() == 'inventario-garantia.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/inventario-garantia.php';
		}								
		else if ( get_page_template_slug() == 'firma-contrato.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/firma-contrato.php';
		}								
		else if ( get_page_template_slug() == 'pago-garantia.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/pago-garantia.php';
		}	
		else if ( get_page_template_slug() == 'ofiliaria-infocasas.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/ofiliaria-infocasas.php';
		}
		else if ( get_page_template_slug() == 'notificaciones-meli.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/notificaciones-meli.php';
		}	
		else if ( get_page_template_slug() == 'notificaciones-infocasas.php' ) 										  
		{
			$page_template = dirname( __FILE__ ) . '/templates/notificaciones-infocasas.php';
		}																						
		return $page_template;
	}

	public function crear_ayudantes_contenidos() 
	{
		if ( get_option('wpresidence_ofiliaria_setup') !== 'yes') 
		{
		   	$page_creation = array(
				array(
					'name'      => 'Mercado Libre',
					'template'  => 'ofiliaria-mercadolibre.php'),
				array(
					'name'      => 'Garantías',
					'template'  => 'garantias.php'),
				array(
					'name'      => 'Seleccionar aseguradora',
					'template'  => 'seleccionar-aseguradora.php'),
				array(
					'name'      => 'Datos propiedad',
					'template'  => 'datos-propiedad.php'),
				array(
					'name'      => 'Datos arrendatario',
					'template'  => 'datos-arrendatario.php'),
				array(
					'name'      => 'Personas adicionales',
					'template'  => 'personas-adicionales.php'),
				array(
					'name'      => 'Detalle garantía',
					'template'  => 'detalle-garantia.php'),		
				array(
					'name'      => 'Garantía enviada',
					'template'  => 'garantia-enviada.php'),	
				array(
					'name'      => 'Revisión garantía',
					'template'  => 'revision-garantia.php'),						
				array(
					'name'      => 'Contrato garantía',
					'template'  => 'contrato-garantia.php'),						
				array(
					'name'      => 'Inventario garantia',
					'template'  => 'inventario-garantia.php'),						
				array(
					'name'      => 'Firma contrato',
					'template'  => 'firma-contrato.php'),						
				array(
					'name'      => 'Pago garantía',
					'template'  => 'pago-garantia.php'),
				array(
					'name'      => 'Infocasas',
					'template'  => 'ofiliaria-infocasas.php'),														
				array(
					'name'      => 'Notificaciones Meli',
					'template'  => 'notificaciones-meli.php'),
				array(
					'name'      => 'Notificaciones Infocasas',
					'template'  => 'notificaciones-infocasas.php'),
				);
  
			foreach($page_creation as $key => $template)
			{
				if ($this->obtener_enlace_template($template['template'], 1) == home_url('/') )
				{
					$my_post = array(
						'post_title'    => $template['name'],
						'post_type'     => 'page',
						'post_status'   => 'publish',
						);
					$new_id = wp_insert_post($my_post);
					update_post_meta($new_id, '_wp_page_template', $template['template'] );
				}
			}
			update_option('wpresidence_ofiliaria_setup', 'yes');
		}
	}
    
   	public function obtener_enlace_template( $template_name  ,$bypass = 0)
   	{
	   	$pages = get_pages(array(
		   	'meta_key'      => '_wp_page_template',
			'meta_value'    => $template_name
		   ));
  
		if($pages)
		{
			$template_link =  esc_url (  get_permalink( $pages[0]->ID ) );
		}
		else
		{
			$template_link = esc_url( home_url('/') );
		}
		return esc_url($template_link);
   	}
	
	public function guardar_token_meli($token = null, $refresh_token = null, $usuario_duenio_token = null)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');

		$usuario_conectado = wp_get_current_user();
		$indicador_peticion_ajax = 0;
		$respuesta = '';

		if (isset($_POST['token']))
		{
			$indicador_peticion_ajax = 1;
			$token = $_POST['token'];
			$refresh_token = $_POST['refresh_token'];
			if ($_POST['usuario_duenio_token'] == 0) // Para token por primera vez
			{
				$usuario_duenio_token = $usuario_conectado->ID;
			}
			else
			{
				$usuario_duenio_token = $_POST['usuario_duenio_token'];
			}
		}

		$fecha_hora_token = date("Y-m-d H:i:s");		
		update_user_meta($usuario_duenio_token, '_token_meli', $token);
		update_user_meta($usuario_duenio_token, '_refresh_token_meli', $refresh_token);
		update_user_meta($usuario_duenio_token, '_fecha_hora_token_meli', $fecha_hora_token);

		$respuesta = 
			[
				'resultado' => true,
				'mensaje' => ' Se guardó el token, el refresh_token, la fecha y hora'
			];

		if ($indicador_peticion_ajax == 0)
		{
			return $respuesta;
		}
		else
		{
			echo json_encode($respuesta);
			die;
		}
	}

	public function error_token_meli()
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');

		$usuario_conectado = wp_get_current_user();
		$error_token_meli = $_POST['error_token_meli'];
		$mensaje_error_token_meli = $_POST['mensaje_error_token_meli'];

		// Imprimir en el debug.log el usuario, error y mensaje de error
		error_log("Usuario: " . $usuario_conectado->user_login . " - Error token Meli: " . $error_token_meli . " - Mensaje error token Meli: " . $mensaje_error_token_meli);	

		$fecha_hora_error_token_meli = date("Y-m-d H:i:s");		
		update_user_meta($usuario_conectado->ID, '_error_obtener_refrescar_token_meli', $error_token_meli);
		update_user_meta($usuario_conectado->ID, '_mensaje_error_obtener_refrescar_token_meli', $mensaje_error_token_meli);
		update_user_meta($usuario_conectado->ID, '_fecha_hora_obtener_refrescar_error_token_meli', $fecha_hora_error_token_meli);

		$respuesta = 
			[
				'resultado' => true,
				'mensaje' => ' Se guardó el error del token de MELI'
			];

		echo json_encode($respuesta);
		die;
	}

	public function verificar_token_meli($id_usuario_a_verificar = null) 
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		
		$indicador_ajax = 0;
		if ($id_usuario_a_verificar == null)
		{
			$usuario_conectado = wp_get_current_user();
			$id_usuario_a_verificar = $usuario_conectado->ID;
			$indicador_ajax = 1;
		}

		$codigo_retorno_token_meli = 0;
		$fecha_hora_token_meli_bd = "";
		$token_meli_bd = "";
		$refresh_token_meli_bd = "";
		$usuario_duenio_token = 0;
		$respuesta = [];
		
		$rol_agencia_agente = get_user_meta($id_usuario_a_verificar, 'user_estate_role', true);

		if ($rol_agencia_agente == '' || $rol_agencia_agente < 2)
		{
			$codigo_retorno_token_meli = 1; // Usuario no tiene rol de agencia o agente
		}
		else
		{
			if ($rol_agencia_agente > 2)
			{
				$usuario_duenio_token = $id_usuario_a_verificar;
			}
			else
			{
				$id_post_agencia_agente = get_user_meta($id_usuario_a_verificar, 'user_agent_id', true);
				if ($id_post_agencia_agente == '')
				{
					$codigo_retorno_token_meli = 2; // Usuario no está asignado a una agencia agencia o agente
				}
				else
				{
					$post_agencia_agente = get_post($id_post_agencia_agente);	
					if ($post_agencia_agente->post_author == 0)
					{
						$usuario_duenio_token = $id_usuario_a_verificar;
					}
					else
					{
						$usuario_duenio_token = $post_agencia_agente->post_author;
					}	
				}
			}

		}

		if ($usuario_duenio_token > 0)
		{
			$fecha_hora_token_meli_bd = get_user_meta($usuario_duenio_token, '_fecha_hora_token_meli', true);
			
			if( $fecha_hora_token_meli_bd == "")
			{
				$codigo_retorno_token_meli = 3; // Usuario no tiene token
			}
			else
			{
				$fecha_hora_token_meli_objeto = new DateTime($fecha_hora_token_meli_bd );
				$fecha_hora_actual_objeto = new DateTime('now');
				$intervalo_diferencia = $fecha_hora_token_meli_objeto->diff($fecha_hora_actual_objeto);

				if ($intervalo_diferencia->y > 0)
				{
					$codigo_retorno_token_meli = 4;
				}
				elseif ($intervalo_diferencia->m > 0)
				{
					$codigo_retorno_token_meli = 4;
				}
				elseif ($intervalo_diferencia->d > 0)
				{
					$codigo_retorno_token_meli = 4;
				}
				elseif ($intervalo_diferencia->h > 4)
				{
					$codigo_retorno_token_meli = 4;
				}
				
				if ($codigo_retorno_token_meli == 0)
				{
					$token_meli_bd = get_user_meta($usuario_duenio_token, '_token_meli', true);
				}
				else
				{
					$refresh_token_meli_bd = get_user_meta($usuario_duenio_token, '_refresh_token_meli', true);
				}
			}
		}

		$respuesta = 
			[
				'codigo_retorno_token_meli' => $codigo_retorno_token_meli,
				'fecha_hora_token_meli_bd' => $fecha_hora_token_meli_bd,
				'token_meli_bd' => $token_meli_bd,
				'refresh_token_meli_bd' => $refresh_token_meli_bd,
				'usuario_duenio_token' => $usuario_duenio_token
			];

		if ($indicador_ajax == 0)
		{
			return $respuesta;
		}
		else
		{
			echo json_encode($respuesta);
			die;
		}
	}
	
	public function previo_importar_publicaciones_meli()
	{
		set_time_limit(900);
    	ini_set('memory_limit', '512M');
		// --- Inicio parámetros ---
		$id_autor = $this->parametros_importacion_meli['id_autor']; 
		$id_usuario_meli = $this->parametros_importacion_meli['id_usuario_meli'];
		$vector_agentes_id_user_wp = $this->parametros_importacion_meli['vector_agentes_id_user_wp'];
		$url_base = $this->parametros_importacion_meli['url_base'];
		// --- Fin parámetros ---

		$publicaciones_importadas = [];
		$publicaciones_sincronizadas = [];
		$busqueda_contador_publicaciones_sincronizadas = '';
		$contador_publicacion = 0;
		$contador_publicaciones_contactos_en_blanco = 0;
		$contador_publicaciones_sincronizadas = 0;
		$publicaciones_anteriores = [];
		$publicaciones_no_encontradas = [];
		$lista_agentes = [];
		$atributos_no_encontrados_wp_meli = [];
		$id_post_agencia_agente = get_user_meta($id_autor, 'user_agent_id', true);		
	
		if ( $id_post_agencia_agente != "")
		{
			$indicador_usuario_importacion_meli = get_user_meta($id_autor, '_ofiliaria_importacion_meli', true);
			if ($indicador_usuario_importacion_meli == '') 
			{
				global $wpdb;
				$nombre_tabla = $wpdb->prefix.'imagenes_publicaciones';		
				$busqueda_contador_registros = "SELECT COUNT(*) FROM {$nombre_tabla}";
				$contador_registros = $wpdb->get_var($busqueda_contador_registros);

				if (empty($contador_registros))
				{
					$respuesta_buscar_publicaciones_meli = $this->buscar_publicaciones_meli($id_autor, $url_base);	
					if ($respuesta_buscar_publicaciones_meli['codigo_retorno'] == 0)
					{
						$vector_publicaciones_meli = $respuesta_buscar_publicaciones_meli['vector_publicaciones_meli'];
						// Guardar en el log de errores el vector $vector_publicaciones_meli
						error_log('Guardando en el log de errores el vector $vector_publicaciones_meli');
						error_log(print_r($vector_publicaciones_meli, true));

						$vector_categorias_meli = $this->buscar_categorias_meli();

						foreach ($vector_publicaciones_meli as $publicacion)
						{	
							$nombre_tabla = $wpdb->prefix.'postmeta';		
							$busqueda_contador_publicaciones_sincronizadas = "SELECT COUNT(*) FROM {$nombre_tabla} WHERE meta_value = '{$publicacion}'";
							$contador_publicaciones_sincronizadas = $wpdb->get_var($busqueda_contador_publicaciones_sincronizadas);
				
							if (empty($contador_publicaciones_sincronizadas))
							{
								$respuesta_buscar_publicacion_meli = $this->buscar_publicacion_meli($id_autor, $publicacion);
								if ($respuesta_buscar_publicacion_meli['codigo_retorno'] == 0)
								{
									$publicaciones_importadas[] = $publicacion;
									$vector_publicacion_meli = $respuesta_buscar_publicacion_meli['vector_publicacion_meli'];
									$argumentos_terminos = 
										[
											'taxonomy' => 'property_category',
											'hide_empty' => false
										];
									$terminos_property_category = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_action_category',
										'hide_empty' => false
									];
									$terminos_property_action_category = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_county_state',
										'hide_empty' => false
									];
									$terminos_property_county_state = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_city',
										'hide_empty' => false
									];
									$terminos_property_city = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_area',
										'hide_empty' => false
									];
									$terminos_property_area = get_terms($argumentos_terminos);	
									
									$contador_publicacion++;
									
									if (isset($vector_publicacion_meli->seller_contact->contact)) {
										$nombre_contacto = trim($vector_publicacion_meli->seller_contact->contact);
										
										// Verificamos que no sea nulo ni esté vacío
										if (!empty($nombre_contacto)) {
											// Lo agregamos al vector. Usamos el nombre como clave para evitar duplicados
											// y que la lista final sea única y limpia.
											$lista_agentes[$nombre_contacto] = $nombre_contacto;
										}
										else {
											$contador_publicaciones_contactos_en_blanco++;
										}
									}

									foreach ($vector_publicacion_meli->attributes as $atributo)
									{
										$campo_encontrado_wp_meli = false;
										foreach ($this->vectorCamposWpMeli as $wpMeli)
										{
											if ($atributo->id == $wpMeli['meli'])
											{
												$campo_encontrado_wp_meli = true;
											}
										}
										if (!$campo_encontrado_wp_meli)
										{
											if (!isset($atributos_no_encontrados_wp_meli[$atributo->id]))
											{
												$atributos_no_encontrados_wp_meli[$atributo->id] = $atributo;
											}
										}
									}
								}
								else
								{
									$publicaciones_no_encontradas[] = $publicacion;
								}	
							}
							else
							{
								$publicaciones_sincronizadas[] = $publicacion;
							}		
						}
						$vector_respuesta = 
							[
								'codigo_retorno' => 0,
								'mensaje' => 'Se importarán '.$contador_publicacion.' publicaciones',
								'publicaciones_importadas' => $publicaciones_importadas,
								'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
								'publicaciones_anteriores' => $publicaciones_anteriores,
								'publicaciones_no_encontradas' => $publicaciones_no_encontradas,
								'lista_agentes' => $lista_agentes,
								'contactos_en_blanco' => $contador_publicaciones_contactos_en_blanco,
								'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
							];
						update_user_meta($id_autor, '_ofiliaria_previo_importar_publicaciones_meli', $vector_respuesta);
						exit(json_encode($vector_respuesta, JSON_FORCE_OBJECT));
					}
					else
					{
						exit(json_encode(array(
							'codigo_retorno' => 4,
							'mensaje' => $respuesta_buscar_publicaciones_meli['mensaje'],
							'publicaciones_importadas' => $publicaciones_importadas,
							'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
							'publicaciones_anteriores' => $publicaciones_anteriores,
							'lista_agentes' => $lista_agentes,
							'contactos_en_blanco' => $contador_publicaciones_contactos_en_blanco,
							'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
						), JSON_FORCE_OBJECT));	
					}
				}
				else
				{
					exit(json_encode(array(
						'codigo_retorno' => 3,
						'mensaje' => 'La tabla ofil_imagenes_publicaciones no está vacía',
						'publicaciones_importadas' => $publicaciones_importadas,
						'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
						'publicaciones_anteriores' => $publicaciones_anteriores,
						'lista_agentes' => $lista_agentes,
						'contactos_en_blanco' => $contador_publicaciones_contactos_en_blanco,
						'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
					), JSON_FORCE_OBJECT));	
				}
			}
			else
			{
				exit(json_encode(array(
					'codigo_retorno' => 2,
					'mensaje' => 'Las publicaciones de este usuario ya se importaron anteriormente',
					'publicaciones_importadas' => $publicaciones_importadas,
					'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
					'publicaciones_anteriores' => $publicaciones_anteriores,
					'lista_agentes' => $lista_agentes,
					'contactos_en_blanco' => $contador_publicaciones_contactos_en_blanco,
					'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
				), JSON_FORCE_OBJECT));
			}
		}
		else
		{
			exit(json_encode(array(
				'codigo_retorno' => 1,
				'mensaje' => 'El usuario no tiene agente asignado',
				'publicaciones_importadas' => $publicaciones_importadas,
				'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
				'publicaciones_anteriores' => $publicaciones_anteriores,
				'lista_agentes' => $lista_agentes,
				'contactos_en_blanco' => $contador_publicaciones_contactos_en_blanco,
				'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
			), JSON_FORCE_OBJECT));
		}
	}

	public function importar_publicaciones_meli()
	{
		set_time_limit(900);
    	ini_set('memory_limit', '512M');
		// --- Inicio parámetros ---
		$id_autor = $this->parametros_importacion_meli['id_autor']; 
		$id_usuario_meli = $this->parametros_importacion_meli['id_usuario_meli'];
		$vector_agentes_id_user_wp = $this->parametros_importacion_meli['vector_agentes_id_user_wp'];
		$url_base = $this->parametros_importacion_meli['url_base'];
		// --- Fin parámetros ---

		$publicaciones_importadas = [];
		$publicaciones_sincronizadas = [];
		$busqueda_contador_publicaciones_sincronizadas = '';
		$contador_publicacion = 0;
		$contador_publicaciones_sincronizadas = 0;
		$publicaciones_anteriores = [];
		$publicaciones_no_encontradas = [];
		$atributos_no_encontrados_wp_meli = [];
		$id_post_agencia_agente = get_user_meta($id_autor, 'user_agent_id', true);		
		if ( $id_post_agencia_agente != "")
		{
			$indicador_usuario_importacion_meli = get_user_meta($id_autor, '_ofiliaria_importacion_meli', true);
			if ($indicador_usuario_importacion_meli == '') 
			{
				global $wpdb;
				$nombre_tabla = $wpdb->prefix.'imagenes_publicaciones';		
				$busqueda_contador_registros = "SELECT COUNT(*) FROM {$nombre_tabla}";
				$contador_registros = $wpdb->get_var($busqueda_contador_registros);

				if (empty($contador_registros))
				{
					$respuesta_buscar_publicaciones_meli = $this->buscar_publicaciones_meli($id_autor, $url_base);	
					if ($respuesta_buscar_publicaciones_meli['codigo_retorno'] == 0)
					{
						$vector_publicaciones_meli = $respuesta_buscar_publicaciones_meli['vector_publicaciones_meli'];
						update_user_meta($id_autor, '_ofiliaria_importacion_meli', 'Sí');
						$vector_categorias_meli = $this->buscar_categorias_meli();

						$contador_publicaciones_a_importar = 0;
						foreach ($vector_publicaciones_meli as $publicacion)
						{	
							if ($contador_publicaciones_a_importar > 0 && $this->parametros_importacion_meli['importar_solo_la_primera_publicacion'] == 'Sí')
							{
								break;
							}
							$contador_publicaciones_a_importar++;

							$nombre_tabla = $wpdb->prefix.'postmeta';		
							$busqueda_contador_publicaciones_sincronizadas = "SELECT COUNT(*) FROM {$nombre_tabla} WHERE meta_value = '{$publicacion}'";
							$contador_publicaciones_sincronizadas = $wpdb->get_var($busqueda_contador_publicaciones_sincronizadas);
				
							if (empty($contador_publicaciones_sincronizadas))
							{
								$respuesta_buscar_publicacion_meli = $this->buscar_publicacion_meli($id_autor, $publicacion);
								if ($respuesta_buscar_publicacion_meli['codigo_retorno'] == 0)
								{
									$publicaciones_importadas[] = $publicacion;

									$vector_publicacion_meli = $respuesta_buscar_publicacion_meli['vector_publicacion_meli'];
									$argumentos_terminos = 
										[
											'taxonomy' => 'property_category',
											'hide_empty' => false
										];
									$terminos_property_category = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_action_category',
										'hide_empty' => false
									];
									$terminos_property_action_category = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_county_state',
										'hide_empty' => false
									];
									$terminos_property_county_state = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_city',
										'hide_empty' => false
									];
									$terminos_property_city = get_terms($argumentos_terminos);
									
									$argumentos_terminos = 
									[
										'taxonomy' => 'property_area',
										'hide_empty' => false
									];
									$terminos_property_area = get_terms($argumentos_terminos);
									
									// --- LÓGICA DE ASIGNACIÓN DE AUTOR (AGENTE) ---

									// Por defecto, empezamos con el ID de la agencia (autor principal)
									$id_autor_final = $id_autor; 

									// Verificamos si existe la estructura seller_contact y el campo contact no está vacío
									if (isset($vector_publicacion_meli->seller_contact->contact) && !empty(trim($vector_publicacion_meli->seller_contact->contact))) {
										
										$nombre_contacto_meli = trim($vector_publicacion_meli->seller_contact->contact);
										
										// Buscamos si el nombre que viene de Meli existe en nuestro mapa de agentes
										if (isset($vector_agentes_id_user_wp[$nombre_contacto_meli])) {
											// Si existe, asignamos el ID del agente de WordPress
											$id_autor_final = $vector_agentes_id_user_wp[$nombre_contacto_meli];
										}
										// Si no existe en el mapa, se queda con el $id_autor por defecto (la agencia)
									}

									// Ahora creamos el post con el autor ya definido
									$post_publicacion = array(
										'post_author'   => $id_autor_final,
										'post_content'  => $vector_publicacion_meli->title,
										'post_title'    => $vector_publicacion_meli->title,
										'post_type'     => 'estate_property',
										'post_status'   => 'publish',
									);

									$id_post_publicacion = wp_insert_post($post_publicacion);
									// --- FIN LÓGICA DE AUTOR ---

									update_post_meta($id_post_publicacion, '_ofiliaria_publicacion_importada_meli', 'Sí' );
									update_post_meta($id_post_publicacion, '_ofiliaria_permalink_publicacion_meli', $vector_publicacion_meli->permalink);
									$contador_publicacion++;	

									update_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', $vector_publicacion_meli->id );
									update_post_meta($id_post_publicacion, '_ofiliaria_id_usuario_meli', $vector_publicacion_meli->seller_id );
									update_post_meta($id_post_publicacion, '_ofiliaria_id_categoria_meli', $vector_publicacion_meli->category_id );

									$id_post_agencia_agente_final = $id_post_agencia_agente;

									if ($id_autor != $id_autor_final)
									{
										$user_agent_id = get_user_meta($id_autor_final, 'user_agent_id', true);
										if (!empty($user_agent_id))
										{
											$id_post_agencia_agente_final = $user_agent_id;
										}
									}

									update_post_meta($id_post_publicacion, 'property_agent', $id_post_agencia_agente_final );

									update_post_meta($id_post_publicacion, 'sidebar_agent_option', 'global' );
									update_post_meta($id_post_publicacion, 'local_pgpr_slider_type', 'global' );
									update_post_meta($id_post_publicacion, 'local_pgpr_content_type', 'global' );
									update_post_meta($id_post_publicacion, 'prop_featured', 0 );
									update_post_meta($id_post_publicacion, 'pay_status', 'not paid' );
									update_post_meta($id_post_publicacion, 'page_custom_zoom', 16 );
									update_post_meta($id_post_publicacion, 'header_type', 1 );
									
									$nombre_categoria_meli = 'Sin nombre de categoría';
									$tipo_operacion_meli = 'Sin tipo de operación'; 
									foreach ($vector_categorias_meli as $categoria)
									{
										if ($categoria->identificador_meli == $vector_publicacion_meli->category_id)
										{
											$nombre_categoria_meli = $categoria->nivel_2;
											$tipo_operacion_meli = $categoria->nivel_3;
											foreach ($terminos_property_category as $termino_category)
											{
												if ($termino_category->name == $nombre_categoria_meli)
												{
													wp_set_object_terms( $id_post_publicacion, $termino_category->term_id, 'property_category' );
													foreach ($terminos_property_action_category as $termino_action)
													{
														if ($termino_action->name == $tipo_operacion_meli)
														{
															wp_set_object_terms( $id_post_publicacion, $termino_action->term_id, 'property_action_category' );
														}
													}
												}
											}
											break;
										}
									}
									
									update_post_meta($id_post_publicacion, '_ofiliaria_nombre_categoria_meli', $nombre_categoria_meli );
									update_post_meta($id_post_publicacion, '_ofiliaria_tipo_operacion', $tipo_operacion_meli );
									
									update_post_meta($id_post_publicacion, 'property_price', $vector_publicacion_meli->price );
									update_post_meta($id_post_publicacion, 'divisa', $vector_publicacion_meli->currency_id );
									update_post_meta($id_post_publicacion, '_ofiliaria_cantidad_disponible_propiedad', $vector_publicacion_meli->available_quantity );
									update_post_meta($id_post_publicacion, '_ofiliaria_modo_compra_propiedad', $vector_publicacion_meli->buying_mode );
									update_post_meta($id_post_publicacion, '_ofiliaria_id_paquete_publicacion_meli', $vector_publicacion_meli->listing_type_id );
									update_post_meta($id_post_publicacion, 'display_name', $vector_publicacion_meli->seller_contact->contact );
									update_post_meta($id_post_publicacion, 'mobile', $vector_publicacion_meli->seller_contact->phone );
									update_post_meta($id_post_publicacion, 'user_email', $vector_publicacion_meli->seller_contact->email );
									update_post_meta($id_post_publicacion, 'property_address', $vector_publicacion_meli->location->address_line );
									
									$estado_meli = '';
									$ciudad_meli = '';
									$barrio_meli = '';
									if ($vector_publicacion_meli->location->state->id != '')
									{
										foreach ($terminos_property_county_state as $termino_county_state)
										{
											if ($termino_county_state->description == $vector_publicacion_meli->location->state->id)
											{
												wp_set_object_terms( $id_post_publicacion, $termino_county_state->term_id, 'property_county_state' );
												$estado_meli = $termino_county_state->name;
											}
										}
									}

									if ($vector_publicacion_meli->location->city->id != '')
									{
										foreach ($terminos_property_city as $termino_city)
										{
											if ($termino_city->description == $vector_publicacion_meli->location->city->id)
											{
												wp_set_object_terms( $id_post_publicacion, $termino_city->term_id, 'property_city' );
												$ciudad_meli = $termino_city->name;
											}
										}
									}

									if ($vector_publicacion_meli->location->neighborhood->id != '')
									{
										foreach ($terminos_property_area as $termino_area)
										{
											if ($termino_area->description == $vector_publicacion_meli->location->neighborhood->id)
											{
												wp_set_object_terms( $id_post_publicacion, $termino_area->term_id, 'property_area' );
												$barrio_meli = $termino_area->name;
											}
										}
									}

									update_post_meta($id_post_publicacion, 'hidden_address', $vector_publicacion_meli->location->address_line.', , '.$barrio_meli.', '.$ciudad_meli.', '.$estado_meli.',' );

									update_post_meta($id_post_publicacion, 'property_country', $vector_publicacion_meli->location->country->name );
									update_post_meta($id_post_publicacion, 'property_zip', $vector_publicacion_meli->location->zip_code );
									update_post_meta($id_post_publicacion, 'property_latitude', $vector_publicacion_meli->location->latitude );
									update_post_meta($id_post_publicacion, 'property_longitude', $vector_publicacion_meli->location->longitude );
									
									if (isset($vector_publicacion_meli->video_id) && !empty($vector_publicacion_meli->video_id)) {
										
										$video_raw = $vector_publicacion_meli->video_id;
										
										// Separamos el ID del sufijo (si lo tiene)
										$vector_video = explode(";", $video_raw);
										$id_puro = $vector_video[0];
										$sufijo = isset($vector_video[1]) ? $vector_video[1] : '';

										if ($sufijo == 'matterport') {
											// Reconstruimos link de Matterport
											$url_completa = "https://my.matterport.com/show/?m=" . $id_puro;
											update_post_meta($id_post_publicacion, 'embed_virtual_tour', $url_completa);
											
											// Limpiamos los otros campos por si existía info previa
											update_post_meta($id_post_publicacion, 'embed_video_id', '');
											update_post_meta($id_post_publicacion, 'embed_video_type', '');
										} 
										elseif ($sufijo == 'meli') {
											// Reconstruimos link interno de Meli (Clips)
											// Nota: Meli no suele dar una URL pública directa tipo youtube, 
											// pero guardamos la URL de referencia interna si tu CRM la necesita.
											$url_meli = "https://www.mercadolibre.com.ar/video/" . $id_puro; 
											update_post_meta($id_post_publicacion, 'embed_video_id', $url_meli);
											update_post_meta($id_post_publicacion, 'embed_video_type', 'meli');
											
											update_post_meta($id_post_publicacion, 'embed_virtual_tour', '');
										} 
										else {
											// Si no tiene sufijo o el sufijo no es reconocido, asumimos YouTube
											// Mercado Libre guarda los IDs de 11 caracteres de YT sin sufijo
											$url_youtube = "https://www.youtube.com/watch?v=" . $id_puro;
											update_post_meta($id_post_publicacion, 'embed_video_id', $url_youtube);
											update_post_meta($id_post_publicacion, 'embed_video_type', 'youtube');
											
											update_post_meta($id_post_publicacion, 'embed_virtual_tour', '');
										}
									}

									foreach ($vector_publicacion_meli->attributes as $atributo)
									{
										$campo_encontrado_wp_meli = false;
										foreach ($this->vectorCamposWpMeli as $wpMeli)
										{
											if ($atributo->id == $wpMeli['meli'])
											{
												switch ($atributo->id)
												{
													case 'TOTAL_AREA':
													case 'COVERED_AREA':
													case 'BALCONY_AREA':
													case 'PROPERTY_AGE':
													case 'LAND_AREA':		
													case 'PAVED_ROAD_DISTANCE':
													case 'FARM_HOUSE_AREA':
													case 'MAINTENANCE_FEE':
														$vector_valor = explode(" ", $atributo->value_name);
														update_post_meta($id_post_publicacion, $wpMeli['wp'], $vector_valor[0] );
														break;
													default:
														update_post_meta($id_post_publicacion, $wpMeli['wp'], $atributo->value_name);
														break;	
												}
												$campo_encontrado_wp_meli = true;
											}
										}
										if (!$campo_encontrado_wp_meli)
										{
											if (!isset($atributos_no_encontrados_wp_meli[$atributo->id]))
											{
												$atributos_no_encontrados_wp_meli[$atributo->id] = $atributo;
											}
										}
									}
									
									$tabla_imagenes = $wpdb->prefix . 'imagenes_publicaciones';
									$data = [];
									$format = array(
										'%d',
										'%s',
										'%s',
										'%d'
									);

									/*
									Para importar las fotos de mayor resolución sustituir la letra -O por -F. Ejemplo:
									https://http2.mlstatic.com/D_920893-MLU89145830786_082025-O.jpg
									Se sustituye por
									https://http2.mlstatic.com/D_920893-MLU89145830786_082025-F.jpg
									En la información que envía Mercado Libre de las foto, en el atributo max_size se indica el máximo que puede ampliarse la foto.
									{
										"id": "825056-MLU86050032279_062025",
										"url": "http://http2.mlstatic.com/D_825056-MLU86050032279_062025-O.jpg",
										"secure_url": "https://http2.mlstatic.com/D_825056-MLU86050032279_062025-O.jpg",
										"size": "500x375",
										"max_size": "1200x900",
										"quality": ""
									},
									*/
									foreach ($vector_publicacion_meli->pictures as $picture) {
										$data['id_post_crm'] = $id_post_publicacion;	
										// Obtenemos la URL segura original
										$url_original = $picture->secure_url;

										/* Explicación de la Regex:
										-O         : Busca la cadena -O
										(?=\.[a-z]+$) : "Lookahead" positivo. Asegura que lo que sigue es un punto 
														seguido de letras (la extensión) y el final de la cadena ($).
										*/
										$url_imagen_ajustada = preg_replace('/-O(?=\.[a-z]+$)/i', '-F', $url_original);

										$data['url_imagen'] = $url_imagen_ajustada;
										$data['tipo_imagen'] = 'General';
										$data['id_post_imagen'] = null;

										$wpdb->insert($tabla_imagenes, $data, $format);
										$id_nuevo_registro = $wpdb->insert_id;  
									}
								}
								else
								{
									$publicaciones_no_encontradas[] = $publicacion;
								}	
							}
							else
							{
								$publicaciones_sincronizadas[] = $publicacion;
							}
						}
						$vector_respuesta = 
							[
								'codigo_retorno' => 0,
								'mensaje' => 'Se importaron '.$contador_publicacion.' publicaciones',
								'publicaciones_importadas' => $publicaciones_importadas,
								'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
								'publicaciones_anteriores' => $publicaciones_anteriores,
								'publicaciones_no_encontradas' => $publicaciones_no_encontradas,
								'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
							];
						update_user_meta($id_autor, '_ofiliaria_importar_publicaciones_meli', $vector_respuesta);
						exit(json_encode($vector_respuesta, JSON_FORCE_OBJECT));
					}
					else
					{
						exit(json_encode(array(
							'codigo_retorno' => 4,
							'mensaje' => $respuesta_buscar_publicaciones_meli['mensaje'],
							'publicaciones_importadas' => $publicaciones_importadas,
							'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
							'publicaciones_anteriores' => $publicaciones_anteriores,
							'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
						), JSON_FORCE_OBJECT));	
					}
				}
				else
				{
					exit(json_encode(array(
						'codigo_retorno' => 3,
						'mensaje' => 'La tabla ofil_imagenes_publicaciones no está vacía',
						'publicaciones_importadas' => $publicaciones_importadas,
						'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
						'publicaciones_anteriores' => $publicaciones_anteriores,
						'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
					), JSON_FORCE_OBJECT));	
				}
			}
			else
			{
				exit(json_encode(array(
					'codigo_retorno' => 2,
					'mensaje' => 'Las publicaciones de este usuario ya se importaron anteriormente',
					'publicaciones_importadas' => $publicaciones_importadas,
					'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
					'publicaciones_anteriores' => $publicaciones_anteriores,
					'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
				), JSON_FORCE_OBJECT));
			}
		}
		else
		{
			exit(json_encode(array(
				'codigo_retorno' => 1,
				'mensaje' => 'El usuario no tiene agente asignado',
				'publicaciones_importadas' => $publicaciones_importadas,
				'publicaciones_sincronizadas' => $publicaciones_sincronizadas,
				'publicaciones_anteriores' => $publicaciones_anteriores,
				'atributos_no_encontrados_wp_meli' => $atributos_no_encontrados_wp_meli
			), JSON_FORCE_OBJECT));
		}
	}

	public function buscar_categorias_meli()
	{
		$urlBase = $this->urlBase();
		if ($urlBase == 'https://ofiliaria.com.uy')
		{
			$url = "https://backend.ofiliaria.com.uy/public/api/v1/categorias";
		}
		else
		{
			$url = "https://dev-backend.ofiliaria.com/public/api/v1/categorias";
		}

		$headers = 
			[
				//
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($curl);
		curl_close($curl);
		update_post_meta(1, '_ofiliaria_respuesta_buscar_categorias_meli', $respuesta);
		$vector_categorias_meli = json_decode($respuesta);
		return $vector_categorias_meli->categorias;
	}

	public function buscar_publicaciones_meli($id_usuario = null, $url_base = null)
	{
		$token_meli = '';
		$codigo_retorno = 0;
		$mensaje = 'Se encontraron publicaciones de Mercado Libre para el usuario con el id '.$id_usuario;
		$vector_publicaciones_meli = [];
    	$offset = 0;
    	$limit = 50; // Mercado Libre recomienda 50 para mayor estabilidad
    	$total = 0;
	    $primera_vuelta = true;

		$respuesta = '';

		$respuesta_obtener_token_meli = $this->obtener_token_meli($id_usuario);
		if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_obtener_token_meli['token_meli'];
		}
		elseif ($respuesta_obtener_token_meli['codigo_retorno'] == 1)
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo refrescar el token del usuario';
		}
		else
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo obtener el token del usuario con id '.$id_usuario;
		}

		if ($codigo_retorno == 0)
		{
			// Limpiamos la URL base de parámetros previos de paginación
			$url_base = preg_replace('/([?&])offset=\d+(&?)/', '$1', $url_base);
			$url_base = preg_replace('/([?&])limit=\d+(&?)/', '$1', $url_base);
			$url_base = rtrim($url_base, '&? ');

			do {
				// Construcción dinámica de la URL
				$conector = (strpos($url_base, '?') === false) ? '?' : '&';
				$url_final = $url_base . $conector . "offset=" . $offset . "&limit=" . $limit;

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url_final);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Bearer ' . $token_meli,
					'Content-Type: application/json'
				));
				
				$response = curl_exec($ch);
				$curl_error_code = curl_errno($ch); // Error de conexión (DNS, Timeout, etc.)
				$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Error de la API (404, 401, 500)
				curl_close($ch);

				// Validar error de conexión (cURL)
				if ($curl_error_code !== 0) {
					$codigo_retorno = 4;
					$mensaje = "Ocurrió un error cURL ({$curl_error_code}). Host: api.mercadolibre.com no resolvió en el offset " . $offset . ", el total es " . $total . ", url_final: " . $url_final;
					break;        
				}

				// Validar error de la API (HTTP Status)
				if ($http_code !== 200) {
					$codigo_retorno = 4;
					$error_detalle = json_decode($response);
					$mensaje_error = isset($error_detalle->message) ? $error_detalle->message : 'Error desconocido';
					$mensaje = 'Código error $http_code ' . $http_code . ' - ' . $mensaje_error . ' en el offset ' . $offset . ', el total es ' . $total . ', url_final: ' . $url_final;
					break;        
				}

				if ($response && $http_code == 200) {
					$resultado = json_decode($response);
					// Guardar en el log de wordpress el valor de $resultado
					error_log('Guardando el valor de $resultado');
					error_log(print_r($resultado, true));

					// En la primera respuesta, capturamos el TOTAL real de la cuenta
					if ($primera_vuelta) {
						if (isset($resultado->paging->total)) {
							$total = (int) $resultado->paging->total;
							$primera_vuelta = false;
						} else {
							$codigo_retorno = 3;
							$mensaje = "La respuesta de la API de MELI no tiene paging total, algo salió mal con el token o la URL en el offset " . $offset . ", el total es " . $total . ", url_final: " . $url_final;
							break; 
						}
					}

					// Guardamos los resultados de este lote
					if (!empty($resultado->results)) {
						foreach ($resultado->results as $id_item) {
							$vector_publicaciones_meli[] = $id_item;
						}
					}

					// Incrementamos el puntero
					$offset += $limit;

				}			
			} while ($offset < $total); // El ciclo sigue hasta que el offset alcance el total reportado
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'total_encontrados' => count($vector_publicaciones_meli),
				'vector_publicaciones_meli' => $vector_publicaciones_meli
			];
		return $respuesta;
	}
	
	public function buscar_publicacion_meli($id_usuario = null, $codigo_publicacion = null)
	{
		$token_meli = '';
		$codigo_retorno = 0;
		$mensaje = "La publicación se encontró exitosamente";
		$vector_publicacion_meli = '';
		$respuesta = '';

		$respuesta_obtener_token_meli = $this->obtener_token_meli($id_usuario);
		if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_obtener_token_meli['token_meli'];
		}
		elseif ($respuesta_obtener_token_meli['codigo_retorno'] == 1)
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo refrescar el token del usuario';
		}
		else
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo obtener el token del usuario';
		}

		if ($codigo_retorno == 0)
		{
			$respuesta_obtener_publicacion_meli = $this->obtener_publicacion_meli($token_meli, $codigo_publicacion);
			if ($respuesta_obtener_publicacion_meli['codigo_retorno'] == 0)
			{
				$vector_publicacion_meli = $respuesta_obtener_publicacion_meli['vector_publicacion_meli'];
			}
			else
			{
				$codigo_retorno = 3;
				$mensaje = 'Publicación no encontrada';
			}
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'vector_publicacion_meli' => $vector_publicacion_meli
			];
		return $respuesta;
	}

	public function obtener_publicacion_meli($token_meli = null, $codigo_publicacion = null)
	{
		$codigo_retorno = 0;
		$mensaje = "La publicación se encontró exitosamente";
		$respuesta = '';

		$indicador_ajax = 0;
		if (isset($_POST['token_meli']))
		{
			$token_meli = $_POST['token_meli'];
			$codigo_publicacion = $_POST['id_publicacion_meli'];
			$indicador_ajax = 1;
		}

		$url = "https://api.mercadolibre.com/items/".$codigo_publicacion;
		$headers = 
			[
				"Authorization: Bearer ".$token_meli
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$vector_publicacion_meli = json_decode($respuesta);

		if (isset($vector_publicacion_meli->error) && $vector_publicacion_meli->error == 'resource not found')
		{
			$codigo_retorno = 1;
			$mensaje = 'Publicación no encontrada';
		}
		elseif (isset($vector_publicacion_meli->status) && $vector_publicacion_meli->status == 404)
		{
			$codigo_retorno = 1;
			$mensaje = 'Publicación no encontrada';
		}

		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'error_meli' => $vector_publicacion_meli->error,
				'estatus_meli' => $vector_publicacion_meli->status,
				'vector_publicacion_meli' => $vector_publicacion_meli
			];

		if ($indicador_ajax == 0)
		{
			return $respuesta;
		}
		else
		{
			exit(json_encode($respuesta, JSON_FORCE_OBJECT));
		}
	}

	public function filtro_buscar_publicacion_meli($publicacion_meli = null, $id_autor_publicacion = null, $id_meli_publicacion = null)
	{
		$respuesta_buscar_publicacion_meli = $this->buscar_publicacion_meli($id_autor_publicacion, $id_meli_publicacion);
		if ($respuesta_buscar_publicacion_meli['codigo_retorno'] == 0)
		{
			$publicacion_meli = $respuesta_buscar_publicacion_meli['vector_publicacion_meli'];
		}
		return $publicacion_meli;
	}

	public function preguntas_meli()
	{	
		$url = "https://api.mercadolibre.com/questions/search?item=MLU638862683&api_version=4";
		$headers = 
			[
				"Authorization: Bearer APP_USR-6732449785458614-052218-5ae2b2c32e2adcd64c769d45113db76c-1532684552"
			];
		
		$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($curl);
    	curl_close($curl);
		echo json_encode( array(
			'resultado' => true,
			'mensaje' => $response
		));
		die;
	}
	public function validar_inmueble_meli():void
	{	
		$respuesta = '';
		$codigo_retorno = 0;

		$informacion_token = $this->buscar_token_meli();

		if ($informacion_token['codigo_retorno_token_meli'] != 0)
		{
			$respuesta = 'El usuario no tiene token o debe refrescar el token';
			$codigo_retorno = 1;
		}
		else
		{
			$url = "https://api.mercadolibre.com/items/validate";
			$headers = 
				[
					"Authorization: Bearer ".$informacion_token['token_meli_bd']
				];
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($_POST["datos_inmueble"]));
			$respuesta = curl_exec($curl);
			$codigo_retorno = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
		}
		exit(json_encode(array(
			'respuesta' => $respuesta,
			'codigo_retorno' => $codigo_retorno
		), JSON_FORCE_OBJECT));
	}
		
	public function listado_inmuebles()
	{	
		$agenciaId = $_POST['agencia_id'];
		$agenteId = $_POST['agente_id'];
		$idsAgentesAgencia = [];
		$vectorInmuebles = [];
		$busquedaAgencia = new WP_Query(array( 'post_type' => 'estate_property', 'post_status' => 'publish', 'author' => $agenciaId)); 
		while($busquedaAgencia->have_posts()) : 
			$busquedaAgencia->the_post();
			$id_post = get_the_ID();
			$direccion_inmueble = get_post_meta($id_post, 'property_address', true);
			$vectorInmuebles[] = ["id" => $id_post, "name" => get_the_title(), "direccion" => $direccion_inmueble];
		endwhile; 

		$busquedaAgentesAgencia = new WP_Query(array( 'post_type' => 'estate_agent', 'post_status' => 'publish', 'author' => $agenciaId)); 
		while($busquedaAgentesAgencia->have_posts()) : 
			$busquedaAgentesAgencia->the_post();
			$id_post = get_the_ID();
			$agente = reset(
				get_users(
					array(
					'meta_key' => 'user_agent_id',
					'meta_value' => $id_post,
					'number' => 1
					)
				)
				);
			$idsAgentesAgencia[] = $agente->ID;
		endwhile; 
		foreach ($idsAgentesAgencia as $idAgente)
		{
			$busquedaAgente = new WP_Query(array( 'post_type' => 'estate_property', 'post_status' => 'publish', 'author' => $idAgente)); 
			while($busquedaAgente->have_posts()) : 
				$busquedaAgente->the_post();
				$id_post = get_the_ID();
				$direccion_inmueble = get_post_meta($id_post, 'property_address', true);
				$vectorInmuebles[] = ["id" => $id_post, "name" => get_the_title(), "direccion" => $direccion_inmueble];
			endwhile; 
		}

		if (empty($vectorInmuebles)) {
			exit(json_encode(array(
				'codigo_retorno' => 1,
				'mensaje'        => 'No se encontraron inmuebles',
				'listado_inmuebles' => []
			)));
		}
		else {
			exit(json_encode(array(
				'codigo_retorno' => 0,
				'mensaje' => 'Búsqueda exitosa',
				'listado_inmuebles' => $vectorInmuebles,
				'agencia_id' => $agenciaId,
				'agente_id' => $agenteId,
				'idsAgentesAgencia' => $idsAgentesAgencia
			)));
		}
	}

	public function obtener_url_archivos()
	{
		if ($this->parametros_importacion_meli['ejecutar_obtener_url_archivos'] == 'Sí')
		{
			global $wpdb;
			$nombre_tabla = $wpdb->prefix.'imagenes_publicaciones';
			$busqueda = "SELECT * FROM {$nombre_tabla} WHERE id_post_imagen IS NULL";
			$url_archivos = $wpdb->get_results($busqueda);
			
			$resultado = 
			[
				'codigo_retorno' => 0,
				'mensaje' => 'Búsqueda exitosa',
				'url_archivos' => $url_archivos
			];
			exit(json_encode($resultado));
		}	
	}

	public function importar_archivo_meli() 
	{
		global $wpdb;
		$image_id = 0;
		$mensaje = '';
		$mensaje_actualizacion = '';
		
		$id_url_archivo = $_POST['id_url_archivo'];
		$id_post_crm = $_POST['id_post_crm'];
		$url_imagen = $_POST['url_imagen'];
		$tipo_imagen = $_POST['tipo_imagen'];
		$resultado = [];
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		$image_id = media_sideload_image($url_imagen, $id_post_crm, null, 'id');
    
		if (is_wp_error($image_id)) 
		{
			$resultado = 
				[
					'codigo_retorno' => 1,
					'mensaje' => 'No se pudo mover al directorio de Wordpress la imagen que corresponde a la url del archivo con id: '.$id_url_archivo,
					'id_post_imagen' => $image_id
				];
		}
		else
		{
			$nombre_tabla = $wpdb->prefix.'imagenes_publicaciones';
			$datos = [];
			$formato = array(
				'%d',
				'%s',
				'%s',
				'%d'
			);
			$formato_donde = array(
				'%d'
			);

			$busqueda = "SELECT * FROM {$nombre_tabla} WHERE id = {$id_url_archivo}";
			
			$url_archivo = $wpdb->get_row( $busqueda, OBJECT );
	
			if (is_object($url_archivo) && !empty($url_archivo)) 
			{
				$datos['id_post_crm'] = $url_archivo->id_post_crm;
				$datos['url_imagen'] = $url_archivo->url_imagen;
				$datos['tipo_imagen'] = $url_archivo->tipo_imagen;
				$datos['id_post_imagen'] = $image_id;
	
				$donde = ['id' => $url_archivo->id];
	
				$url_actualizada = $wpdb->update( $nombre_tabla, $datos, $donde, $formato, $formato_donde );
	
				if ( false === $url_actualizada ) 
				{
					$resultado = 
						[
							'codigo_retorno' => 3,
							'mensaje' => 'No se pudo actualizar el registro de la URL del archivo con el id: '.$id_url_archivo,
							'id_post_imagen' => $image_id,
						];
				} 
				else 
				{
					$resultado = 
						[
							'codigo_retorno' => 0,
							'mensaje' => 'Importación exitosa',
							'id_post_imagen' => $image_id,
						];
				}
			}
			else
			{
				$resultado = 
					[
						'codigo_retorno' => 2,
						'mensaje' => 'No se encontró el registro de la URL del archivo con el id: '.$id_url_archivo,
						'id_post_imagen' => $image_id,
					];
			}
		}
	
		exit(json_encode($resultado));	
	}

	public function asociar_archivos_publicacion()
	{
		if ($this->parametros_importacion_meli['ejecutar_asociar_archivos_publicacion'] == 'Sí')
		{		
			global $wpdb;
			$nombre_tabla = $wpdb->prefix.'imagenes_publicaciones';		
			$busqueda_contador_registros = "SELECT COUNT(*) FROM {$nombre_tabla} WHERE tipo_imagen = 'General' AND id_post_imagen IS NOT NULL";
			$contador_registros = $wpdb->get_var($busqueda_contador_registros);

			if (empty($contador_registros) == false && $contador_registros > 0)
			{
				$busqueda = "SELECT * FROM {$nombre_tabla} WHERE tipo_imagen = 'General' AND id_post_imagen IS NOT NULL";
				$url_archivos = $wpdb->get_results($busqueda);

				$contador = 0;
				$contador_publicaciones_asociadas = 0;
				$id_post_crm_actual = 0;
				$id_post_crm_anterior = 0;
				$wpestate_property_gallery = [];

				foreach ($url_archivos as $archivo)
				{
					$id_post_crm_actual = $archivo->id_post_crm;
					if ($contador == 0)
					{
						$id_post_crm_anterior = $id_post_crm_actual;
						set_post_thumbnail($id_post_crm_actual, $archivo->id_post_imagen);
					}
					$contador++;
					if ($id_post_crm_anterior != $id_post_crm_actual)
					{
						$indicador_asociacion = get_post_meta($id_post_crm_anterior, '_ofiliaria_archivos_asociados_publicacion', true);
						if ($indicador_asociacion !== 'Sí')
						{
							delete_post_meta($id_post_crm_anterior, 'wpestate_property_gallery');
							update_post_meta($id_post_crm_anterior, 'wpestate_property_gallery', $wpestate_property_gallery);
							update_post_meta($id_post_crm_anterior, '_ofiliaria_archivos_asociados_publicacion', 'Sí');
							$contador_publicaciones_asociadas++;
						}
						$id_post_crm_anterior = $id_post_crm_actual;
						$wpestate_property_gallery = [];
						$wpestate_property_gallery[] = $archivo->id_post_imagen;
						set_post_thumbnail($id_post_crm_actual, $archivo->id_post_imagen);
					}
					else
					{
						$wpestate_property_gallery[] = $archivo->id_post_imagen;
					}
					if ($contador == $contador_registros)
					{
						$indicador_asociacion = get_post_meta($id_post_crm_actual, '_ofiliaria_archivos_asociados_publicacion', true);
						if ($indicador_asociacion !== 'Sí')
						{
							delete_post_meta($id_post_crm_actual, 'wpestate_property_gallery');
							update_post_meta($id_post_crm_actual, 'wpestate_property_gallery', $wpestate_property_gallery);
							update_post_meta($id_post_crm_actual, '_ofiliaria_archivos_asociados_publicacion', 'Sí');
							$contador_publicaciones_asociadas++;
						}
						break;
					}
				}

				$resultado = 
				[
					'codigo_retorno' => 0,
					'mensaje' => 'Asociación exitosa',
					'contador_publicaciones_asociadas' => $contador_publicaciones_asociadas,
					'contador_registros' => $contador_registros,
					'cantidad_archivos_procesados' => $contador
				];
			}
			else
			{
				$resultado = 
				[
					'codigo_retorno' => 1,
					'mensaje' => 'No hay archivos para asociar a la publicación',
				];	
			}

			exit(json_encode($resultado));	
		}		
	}

	public function add_allowed_origins($origins) {
		$origins[] = 'http://localhost';
		return $origins;
	}
	public function buscar_token_meli() 
	{
		$codigo_retorno_token_meli = 0;
		$fecha_hora_token_meli_bd = "";
		$token_meli_bd = "";
		$refresh_token_meli_bd = "";
		
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$usuario_conectado = wp_get_current_user();

		$fecha_hora_token_meli_bd = get_user_meta($usuario_conectado->ID, '_fecha_hora_token_meli', true);
		
		if( $fecha_hora_token_meli_bd == "")
		{
			$codigo_retorno_token_meli = 1; // Usuario no tiene token
		}
		else
		{
			$fecha_hora_token_meli_objeto = new DateTime($fecha_hora_token_meli_bd );
			$fecha_hora_actual_objeto = new DateTime('now');
			$intervalo_diferencia = $fecha_hora_token_meli_objeto->diff($fecha_hora_actual_objeto);

			if ($intervalo_diferencia->y > 0)
			{
				$codigo_retorno_token_meli = 2;
			}
			elseif ($intervalo_diferencia->m > 0)
			{
				$codigo_retorno_token_meli = 2;
			}
			elseif ($intervalo_diferencia->d > 0)
			{
				$codigo_retorno_token_meli = 2;
			}
			elseif ($intervalo_diferencia->h > 4)
			{
				$codigo_retorno_token_meli = 2;
			}
			
			if ($codigo_retorno_token_meli == 0)
			{
				$token_meli_bd = get_user_meta($usuario_conectado->ID, '_token_meli', true);
			}
			else
			{
				$refresh_token_meli_bd = get_user_meta($usuario_conectado->ID, '_refresh_token_meli', true);
			}
			
		}
		
		return array(
			'codigo_retorno_token_meli' => $codigo_retorno_token_meli,
			'fecha_hora_token_meli_bd' => $fecha_hora_token_meli_bd,
			'token_meli_bd' => $token_meli_bd,
			'refresh_token_meli_bd' => $refresh_token_meli_bd  
		);
	}
	public function verificar_usuario_conectado()
	{
		error_log('Ejecutando la función verificar_usuario_conectado');
		$usuario_administrador = '';
		$id_usuario_agencia = 0;
		$id_usuario_conectado = 0;
		$rol_usuario_conectado = 0;
		$id_post_agencia_agente = 0;
		$tipo_agencia_agente = '';
		$token_laravel = '';

		$usuario_conectado = wp_get_current_user();

		if (isset($usuario_conectado->ID))
		{
			if (current_user_can('administrator'))
			{
				$usuario_administrador = 'Sí';
			} 
			else
			{
				$usuario_administrador = 'No';
			}
			$id_usuario_conectado = $usuario_conectado->ID;
			// Se debe revisar, si no existe el user_meta user_estate_role: Qué valor se asignaría?
			$rol_usuario_conectado = intval(get_user_meta($usuario_conectado->ID, 'user_estate_role', true));
			$id_post_agencia_agente = get_user_meta($usuario_conectado->ID, 'user_agent_id', true);
			
			if( $id_post_agencia_agente == "")
			{
				$id_usuario_agencia = $usuario_conectado->ID;
			}
			else
			{
				$post_agencia_agente = get_post($id_post_agencia_agente);	
				if (isset($post_agencia_agente->post_type))
				{
					
					$tipo_agencia_agente = $post_agencia_agente->post_type;
					if ($tipo_agencia_agente == 'estate_agency')
					{
						$id_usuario_agencia = $usuario_conectado->ID;
					}
					elseif ($tipo_agencia_agente == 'estate_agent')
					{
						$id_usuario_agencia = $post_agencia_agente->post_author;
					}			
				}
				
			}
			$registro_laravel = get_user_meta($usuario_conectado->ID, '_laravel_registro', true);
			if ( $registro_laravel == "")
			{		
				$respuesta_creacion_laravel = $this->crear_usuario_laravel($usuario_conectado->user_login, $usuario_conectado);
				if (isset($respuesta_creacion_laravel['codigo_respuesta']) && $respuesta_creacion_laravel['codigo_respuesta'] == 2) {
					exit(json_encode(array(
						'codigo_retorno' => 2,
						'mensaje' => 'El correo ya está registrado para otro usuario.',
						'email_existente' => $respuesta_creacion_laravel['email_existente']
					)));
				}
			}
			$token_laravel = $this->obtener_token_laravel($usuario_conectado);	
		}

		exit(json_encode(array(
			'codigo_retorno' => 0,
			'mensaje' => 'Verificación exitosa',
			'usuario_administrador' => $usuario_administrador,
			'id_usuario_agencia' => $id_usuario_agencia,
			'id_usuario_conectado' => $id_usuario_conectado,
			'rol_usuario_conectado' => $rol_usuario_conectado,
			'tipo_agencia_agente' => $tipo_agencia_agente,
			'token_laravel' => $token_laravel
		)));
	}
	public function obtener_token_laravel($usuario)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');

		$fecha_hora_token_laravel = get_user_meta($usuario->ID, '_laravel_fecha_hora_token', true);

		$indicador_actualizar_token = 0;
		$indicador_login = 0;
		$fecha_hora_token_laravel_objeto = new DateTime($fecha_hora_token_laravel);
		$fecha_hora_actual_objeto = new DateTime('now');
		$intervalo_diferencia = $fecha_hora_token_laravel_objeto->diff($fecha_hora_actual_objeto);
		
		if ($intervalo_diferencia->y > 0)
		{
			$indicador_actualizar_token = 1;
		}
		elseif ($intervalo_diferencia->m > 0)
		{
			$indicador_actualizar_token = 1;
		}
		elseif ($intervalo_diferencia->d > 0)
		{
			$indicador_actualizar_token = 1;
		}
		elseif ($intervalo_diferencia->h > 6)
		{
			$indicador_actualizar_token = 1;
		}
		
		if ($indicador_actualizar_token > 0)
		{
			if ($intervalo_diferencia->y > 0)
			{
				$indicador_login = 1;
			}
			elseif ($intervalo_diferencia->m > 0)
			{
				$indicador_login = 1;
			}
			elseif ($intervalo_diferencia->d > 5)
			{
				$indicador_login = 1;
			}
			/*
			if ($indicador_login == 0)
			{
				$this->refrescar_token_usuario_laravel($usuario);
			}
			else
			{*/
				$this->login_usuario_laravel($usuario);
			//}
		}
		$token_laravel = get_user_meta($usuario->ID, '_laravel_token', true);
		return $token_laravel;
	}

	public function inicio_sesion_laravel( $user_login, $user)
	{
		$registro_laravel = get_user_meta($user->ID, '_laravel_registro', true);
		if ( $registro_laravel == "")
		{		
			$this->crear_usuario_laravel($user_login, $user);
		}
		else
		{
			$this->login_usuario_laravel($user);
		}
		return;
	}

	public function crear_usuario_laravel($user_login, $user)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$fecha_hora_token = date("Y-m-d H:i:s");
		$urlBase = $this->urlBase();
		if ($urlBase == 'https://ofiliaria.com.uy')
		{
			$url = "https://backend.ofiliaria.com.uy/public/api/v1/registro";
		}
		else
		{
			$url = "https://dev-backend.ofiliaria.com/public/api/v1/registro";
		}
		
		$token = 'token';
		if ($user->ID != 1) // Super-usuario
		{
			$super_usuario = get_user_by('ID', 1);
			$token = $this->obtener_token_laravel($super_usuario);
		}
		
		$datos = 
		[
			'token' => $token,
			'wordpress_id' => $user->ID,
			'name' => $user_login,
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_USERPWD, $user->user_email . ":" . $user->user_pass);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$respuesta_objeto = json_decode($respuesta, true);
		if (isset($respuesta_objeto['codigo_respuesta'])) {
			if ($respuesta_objeto['codigo_respuesta'] == 0 && $respuesta_objeto['token'] != null)
			{
				update_user_meta($user->ID, '_laravel_registro', 'Sí');
				update_user_meta($user->ID, '_laravel_email', $user->user_email);
				update_user_meta($user->ID, '_laravel_password', $user->user_pass);
				update_user_meta($user->ID, '_laravel_id', $respuesta_objeto['laravel_id']);
				update_user_meta($user->ID, '_laravel_token', $respuesta_objeto['token']);
				update_user_meta($user->ID, '_laravel_refresh_token', $respuesta_objeto['refresh_token']);
				update_user_meta($user->ID, '_laravel_fecha_hora_token', $fecha_hora_token);
			}
			else
			{
				update_user_meta($user->ID, '_laravel_respuesta', $respuesta);
			}
		} else {
			update_user_meta($user->ID, '_laravel_respuesta_desconocida', $respuesta);
		}
		return $respuesta_objeto;
	}
	public function login_usuario_laravel($user)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$fecha_hora_token = date("Y-m-d H:i:s");
		$email_laravel = get_user_meta($user->ID, '_laravel_email', true);
		$password_laravel = get_user_meta($user->ID, '_laravel_password', true);
		$urlBase = $this->urlBase();

		if ($urlBase == 'https://ofiliaria.com.uy')
		{
			$url = "https://backend.ofiliaria.com.uy/public/api/v1/login";
		}
		else
		{
			$url = "https://dev-backend.ofiliaria.com/public/api/v1/login";
		}
		update_user_meta($user->ID, '_laravel_url', $url);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_USERPWD, $email_laravel . ":" . $password_laravel);
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$respuesta_objeto = json_decode($respuesta);
		if ($respuesta_objeto->codigo_respuesta == 0 && $respuesta_objeto->token != null)
		{
			update_user_meta($user->ID, '_laravel_token', $respuesta_objeto->token);
			update_user_meta($user->ID, '_laravel_refresh_token', $respuesta_objeto->refresh_token);
			update_user_meta($user->ID, '_laravel_fecha_hora_token', $fecha_hora_token);
			update_user_meta($user->ID, '_laravel_fecha_hora_token_login', $fecha_hora_token);
		}
		else
		{
			update_user_meta($user->ID, '_laravel_respuesta_login', $respuesta);
		}
	}
	public function refrescar_token_usuario_laravel($usuario)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$fecha_hora_token = date("Y-m-d H:i:s");
		$refresh_token_laravel = get_user_meta($usuario->ID, '_laravel_refresh_token', true);
		$authorizacion = "Authorization: Bearer ".$refresh_token_laravel;
		$email_laravel = get_user_meta($usuario->ID, '_laravel_email', true);

		$urlBase = $this->urlBase();
		if ($urlBase == 'https://ofiliaria.com.uy')
		{
			$url = "https://backend.ofiliaria.com.uy/public/api/v1/refrescar-token";
		}
		else
		{
			$url = "https://dev-backend.ofiliaria.com/public/api/v1/refrescar-token";
		}
		update_user_meta($usuario->ID, '_laravel_url', $url);
		
		$datos = 
		[
			'email' => $email_laravel
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorizacion ));
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$respuesta_objeto = json_decode($respuesta);
		update_user_meta($usuario->ID, '_laravel_respuesta', $respuesta);
		if ($respuesta_objeto->codigo_respuesta == 0 && $respuesta_objeto->token != null)
		{
			update_user_meta($usuario->ID, '_laravel_token', $respuesta_objeto->token);
			update_user_meta($usuario->ID, '_laravel_refresh_token', $respuesta_objeto->refresh_token);
			update_user_meta($usuario->ID, '_laravel_fecha_hora_token', $fecha_hora_token);
			update_user_meta($usuario->ID, '_laravel_fecha_hora_token_refrescar', $fecha_hora_token);
		}
	}
	public function urlBase()
    {
        if(isset($_SERVER['HTTPS']))
        {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'];
    }

	public function validacion_publicacion()
	{		
		global $wpdb;
		$lista_de_errores = '';
		$usuario = wp_get_current_user();
		$identificador = uniqid();
		$codigo_retorno = 0;
		$mensaje = '';
		$errores = [];
		$parametros = [];
		$titulo = '';
		$descripcion_sin_etiquetas = '';
		$descripcion_texto_plano = '';
		$nombre_contacto = '';
		$nombre = '';
		$apellido = '';
		$telefono_movil = '';
		$email = '';
		$post_agencia_agente = 0;
		$categoria_inmueble = '';
		$tipo_operacion = '';
		$termino_categoria = [];
		$id_categoria_meli = '';
		$direccion = '';
		$nombre_provincia = '';
		$nombre_ciudad = '';
		$nombre_barrio = '';
		$city = '';
		$neighborhood = '';
		$termino_ciudad = '';
		$termino_barrio = '';
		$latitud = 0;
		$longitud = 0;
		$campos_generales = [];
		$campos_especificos = [];
		$campos_a_mostrar = [];
		$divisa = '';
		$stock = 0;
		$precio = 0;
		$vector_campos_generales = [];
		$vector_campos_especificos = [];
		$validacion_meli = 'No';
		$id_post_publicacion = 0;

		update_user_meta($usuario->ID, '_ofiliaria_validacion_publicacion_'.$identificador, $identificador);
		
		if (isset($_POST['id_post_publicacion'])) 
		{
			$id_post_publicacion = $_POST['id_post_publicacion'];
		}

		if (!empty($_POST['wpestate_title'])) 
		{
			$titulo = $_POST['wpestate_title'];
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor escriba un título para la publicación';
		}

		if (!empty($_POST['wpestate_description'])) {
			$descripcion_raw = $_POST['wpestate_description'];

			// 1. Normalizar saltos de línea (preserva lo manual del textarea)
			$descripcion_texto_plano = str_replace(array("\r\n", "\r"), "\n", $descripcion_raw);

			// 2. Procesar Títulos HTML (h1-h6) para resaltar con MAYÚSCULAS y subrayado
			$descripcion_texto_plano = preg_replace_callback('/<h[1-6]>(.*?)<\/h[1-6]>/i', function($matches) {
				$texto_titulo = trim(strip_tags($matches[1]));
				if (empty($texto_titulo)) return "";
				$titulo_up = mb_strtoupper($texto_titulo, 'UTF-8');
				return "\n\n" . $titulo_up . "\n" . str_repeat("-", mb_strlen($titulo_up, 'UTF-8')) . "\n";
			}, $descripcion_texto_plano);

			// 3. Formatear Listas y Estructura de Bloque
			$remplazos = array(
				'/<li>/i'                => "• ",        // Viñeta
				'/<\/li>/i'               => "\n",        // Salto al final de cada ítem
				'/<\/p>|<\/div>/i'        => "\n\n",      // Separación de párrafos
				'/<br\s?\/?>/i'          => "\n",        // Salto manual <br>
				'/<blockquote>/i'         => "\n\" ",     // Inicio de cita
				'/<\/blockquote>/i'        => "\"\n",      // Fin de cita
				'/<ul[^>]*>|<ol[^>]*>/i'  => "\n",        // Asegurar inicio de lista
				'/<\/ul>|<\/ol>/i'        => "\n",        // Asegurar fin de lista
			);

			$descripcion_texto_plano = preg_replace(array_keys($remplazos), array_values($remplazos), $descripcion_texto_plano);

			// 4. Eliminar todas las etiquetas HTML restantes (strong, em, ins, etc.)
			$descripcion_texto_plano = strip_tags($descripcion_texto_plano);

			// 5. Decodificar entidades (Convierte &Ntilde; en Ñ, &oacute; en ó, etc.)
			$descripcion_texto_plano = html_entity_decode($descripcion_texto_plano, ENT_QUOTES | ENT_HTML5, 'UTF-8');

			// 6. ELIMINACIÓN RADICAL DE EMOJIS Y CARACTERES NO-TEXTO (Solución al Error 400)
			// Primero eliminamos el rango específico de Emojis de 4 bytes (como 👋)
			$descripcion_texto_plano = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u', '', $descripcion_texto_plano);
			
			// Luego permitimos SOLO caracteres imprimibles, acentos latinos, Ñ y saltos de línea
			// Esto borra cualquier símbolo invisible que Mercado Libre rechace como "no plano"
			$descripcion_texto_plano = preg_replace('/[^\x20-\x7E\xA0-\xFF\n\r\t]/u', '', $descripcion_texto_plano);

			// 7. Filtro de Seguridad (Mercado Libre prohíbe datos de contacto)
			$patrones_seguridad = array(
				'/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i', // Emails
				'/(https?:\/\/|www\.)[^\s]+/i',             // URLs
				'/\b\d{4}[-.\s]?\d{4,6}\b/'                  // Teléfonos
			);
			$descripcion_texto_plano = preg_replace($patrones_seguridad, '[Dato removido]', $descripcion_texto_plano);

			// 8. Limpieza final de líneas vacías para que las listas sean compactas
			$lineas = explode("\n", $descripcion_texto_plano);
			$lineas_limpias = array();
			foreach ($lineas as $linea) {
				$l = trim($linea, "\r\t ");
				// Agregamos la línea si tiene contenido o si es necesaria para separar párrafos (evita triples saltos)
				if ($l !== "" || (count($lineas_limpias) > 0 && end($lineas_limpias) !== "")) {
					$lineas_limpias[] = $l;
				}
			}
			$descripcion_texto_plano = implode("\n", $lineas_limpias);
			$descripcion_texto_plano = trim($descripcion_texto_plano);

			// 9. Validación final de longitud
			if (mb_strlen($descripcion_texto_plano) < 10) {
				$codigo_retorno = 1;
				$errores[] = 'La descripción es inválida o quedó vacía tras la validación.';
			}

		} else {
			$codigo_retorno = 1;
			$errores[] = 'Por favor escriba la descripción de la publicación';
		}

		if (isset($_POST['prop_category_submit']))
		{
			if ($_POST['prop_category_submit'] <= 0 || $_POST['prop_category_submit'] == 'none')
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione una categoría para el inmueble';
			}
			else
			{
				$termino_categoria = get_term($_POST['prop_category_submit']);
				$categoria_inmueble = $termino_categoria->name;				
			}
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor seleccione una categoría para el inmueble';
		}

		if (isset($_POST['prop_action_category_submit']))
		{
			if ($_POST['prop_action_category_submit'] <= 0 || $_POST['prop_action_category_submit'] == 'none')
			{			
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione el tipo de operación';
			}
			else
			{
				$termino_tipo_operacion = get_term($_POST['prop_action_category_submit']);
				$tipo_operacion = $termino_tipo_operacion->name;   
			}
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor seleccione el tipo de operación';
		}

		$nombre_provincia = '';
		$termino_provincia = null;
		$id_provincia = 0;
		if (isset($_POST['property_county']))
		{
			if ($_POST['property_county'] <= 0 || $_POST['property_county'] == 'none')
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione una provincia';
			}
			else
			{
				$nombre_provincia = $_POST['property_county'];
				// En $_POST['property_county'] viene el nombre de la provincia, buscar el id del término por el nombre de la provincia
				$termino_provincia = get_term_by('name', $nombre_provincia, 'property_county_state');
				// Imprimir en el log el valor de $termino_provincia
				error_log('$termino_provincia: '.print_r($termino_provincia, true));
				if ($termino_provincia)
				{
					$id_provincia = $termino_provincia->term_id;
					// Imprimir en el log el valor de $id_provincia
					error_log('$id_provincia: '.$id_provincia);
				}
				else
				{
					$codigo_retorno = 1;
					$errores[] = 'No se encontró el id de la provincia seleccionada: '.$nombre_provincia;
				}
			}
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor seleccione una provincia';
		}

		if (!empty($_POST['ofiliaria_publicar_meli']))
        {
			$validacion_meli = 'Sí';

			if ($id_post_publicacion == 0)
			{
				$id_post_agencia_agente = get_user_meta($usuario->ID, 'user_agent_id', true);
			}
			else
			{
				$post_publicacion_edicion = get_post($id_post_publicacion);
				$id_autor_post_publicacion_edicion = $post_publicacion_edicion->post_author;
				$id_post_agencia_agente = get_user_meta($id_autor_post_publicacion_edicion, 'user_agent_id', true);
			}
			
			if( $id_post_agencia_agente == "")
			{
				$codigo_retorno = 1;
				$errores[] = 'El usuario no está registrado como agencia o agente';
			}
			else
			{
				$post_agencia_agente = get_post($id_post_agencia_agente);

				$nombre_contacto = $post_agencia_agente->post_title;

				$nombre = get_post_meta($id_post_agencia_agente, 'first_name', true);

				if ($nombre != '')
				{
					$nombre_contacto = $nombre.' ';
				}

				$apellido = get_post_meta($id_post_agencia_agente, 'last_name', true);

				if ($apellido != '')
				{
					$nombre_contacto .= $apellido;
				}
		
				if ($post_agencia_agente->post_type == 'estate_agency')
				{
					$telefono_movil = get_post_meta($id_post_agencia_agente, 'agency_mobile', true);
				}
				else
				{
					$telefono_movil = get_post_meta($id_post_agencia_agente, 'agent_mobile', true);
				}
				if ( $telefono_movil == "")
				{
					$codigo_retorno = 1;
					$errores[] = 'La agencia o agente no tiene teléfono móvil registrado';
				}
				$email = get_post_meta($id_post_agencia_agente, 'agent_email', true);
				if ($email == '')
				{
					$codigo_retorno = 1;
					$errores[] = 'La agencia o agente no tiene email registrado';
				}
			}

			$resultados_paquetes_activos_meli = $this->paquetes_activos_meli($usuario);

			$respuesta_buscar_campos_meli = $this->buscar_campos_meli(0, $categoria_inmueble, $tipo_operacion);
			$id_categoria_meli = $respuesta_buscar_campos_meli['id_categoria_meli'];	
			$campos_generales = $respuesta_buscar_campos_meli['campos_generales'];
			$campos_especificos = $respuesta_buscar_campos_meli['campos_especificos'];
			$campos_a_mostrar = $respuesta_buscar_campos_meli['campos_a_mostrar'];

			if ($id_categoria_meli == '')
			{
				$codigo_retorno = 1;
				$errores[] = 'No se encontró la categoría correspondiente en Mercado Libre';
			}

			if (isset($_POST['divisa']))
			{
				if ($_POST['divisa'] != 'No disponible')
				{
					$divisa = $_POST['divisa'];			
				}
				else
				{
					$codigo_retorno = 1;
					$errores[] = 'Por favor seleccione el tipo de moneda';				
				}
			}
			else
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione el tipo de moneda';	
			}

			foreach ($campos_generales as $indice => $campo_general)
			{
				if ($campo_general === 'required')
				{
					if ($indice != 'stock')	
					{
						foreach ($this->vectorCamposWpMeli as $wpMeli)
						{
							if ($indice == $wpMeli['meli_comparacion'] && $wpMeli['tipo'] == 'General')
							{
								if (isset($_POST[$wpMeli['html_comparacion']]))
								{
									if ($indice == 'price')
									{
										if (isset($campos_generales['minimum_price']))
										{
											if ($campos_generales['minimum_price_currency'] == $divisa)
											{
												if ($_POST[$wpMeli['html_comparacion']] >= $campos_generales['minimum_price'])
												{
													$vector_campos_generales[$indice] = $_POST[$wpMeli['html_comparacion']];
												}
												else
												{
													$codigo_retorno = 1;
													$errores[] = 'Para el precio en UYU debe ingresar un valor superior a: '.$campos_generales['minimum_price'];
												}
											}
											else
											{
												$vector_campos_generales[$indice] = $_POST[$wpMeli['html_comparacion']];
											}
										}
										else
										{
											$vector_campos_generales[$indice] = $_POST[$wpMeli['html_comparacion']];
										}
									}
									else
									{
										$vector_campos_generales[$indice] = $_POST[$wpMeli['html_comparacion']];
									}	
								}
								else
								{
									$codigo_retorno = 1;
									$errores[] = 'Por favor ingresar un valor para: '.$wpMeli['descripcion'] ;
								}
							}
						}
					}
				}	
			}

			if (isset($_POST['property_address']))
			{
				if ($_POST['property_address'] != '')
				{
					$direccion = $_POST['property_address'];
				}
				else
				{
					$codigo_retorno = 1;
					$errores[] = 'La dirección del inmueble es requerida';
				}
			}
			else
			{
				$codigo_retorno = 1;
				$errores[] = 'La dirección del inmueble es requerida';
			}

			if ($id_provincia > 0)
			{
				$nombre_ciudad = '';
				$termino_ciudad = null;
				$id_ciudad = 0;
				if (isset($_POST['property_city_submit']))
				{
					if ($_POST['property_city_submit'] != 'none')
					{
						$nombre_ciudad = $_POST['property_city_submit'];
						$args_ciudad = [
							'taxonomy' => 'property_city',
							'hide_empty' => false,
							'search' => $nombre_ciudad
						];
						$posibles_ciudades = get_terms($args_ciudad);
						
						// Imprimir en el log la variable $posibles_ciudades para depuración
						error_log('$posibles_ciudades: ' . print_r($posibles_ciudades, true));

						if (!is_wp_error($posibles_ciudades) && !empty($posibles_ciudades)) 
						{
							foreach ($posibles_ciudades as $t) 
							{
								if ($t->name == $nombre_ciudad) {
									$opcion_term_ciudad = get_option("taxonomy_$t->term_id");
									// Imprimir en el log la variable $opcion_term_ciudad para depuración
									error_log('$opcion_term_ciudad: ' . print_r($opcion_term_ciudad, true));
                            		if (isset($opcion_term_ciudad['stateparent']))
									{
										if ($opcion_term_ciudad['stateparent'] == $nombre_provincia) 
										{
											$termino_ciudad = $t;
											break;
										}
									}
								}
							}
						}

						if ($termino_ciudad != null) 
						{
							$city = $termino_ciudad->description;
							$id_ciudad = $termino_ciudad->term_id;
						} 
						else 
						{
							$codigo_retorno = 1;
							$errores[] = 'No se encontró el código de la ciudad ('.$nombre_ciudad.') con su respectivo departamento';
							// Loguear candidatos encontrados para depuración
							$log = [
								'context' => 'validacion_publicacion - código ciudad no encontrada',
								'nombre_ciudad' => $nombre_ciudad,
								'id_provincia' => $id_provincia,
								'posibles_ciudades' => $posibles_ciudades
							];
							error_log(json_encode($log));
						}	
					}
					else
					{
						$codigo_retorno = 1;
						$errores[] = 'Debe especificar la ciudad o el barrio';
					}
				}
				else
				{
					$codigo_retorno = 1;
					$errores[] = 'Debe especificar la ciudad o el barrio';
				}

				if (isset($_POST['property_area_submit']))
				{
					if ($_POST['property_area_submit'] != 'none')
					{
						$nombre_barrio = $_POST['property_area_submit'];
						$termino_barrio = null;
						$args_barrio = [
							'taxonomy' => 'property_area',
							'hide_empty' => false,
							'search' => $nombre_barrio
						];
						$posibles_barrios = get_terms($args_barrio);
						// Imprimir en el log la variable $posibles_barrios para depuración
						error_log('$posibles_barrios: ' . print_r($posibles_barrios, true));
						
						if (!is_wp_error($posibles_barrios) && !empty($posibles_barrios)) 
						{
							foreach ($posibles_barrios as $t) 
							{
								if ($t->name == $nombre_barrio) 
								{
									$opcion_term_area = get_option("taxonomy_$t->term_id");
									// Imprimir en el log la variable $opcion_term_area para depuración
									error_log('$opcion_term_area: ' . print_r($opcion_term_area, true));

                            		if (isset($opcion_term_area['cityparent']))
									{
										if ($opcion_term_area['cityparent'] == $nombre_ciudad) 
										{
											$termino_barrio = $t;
											break;
										}
									}
								}
							}
						}
						else
						{
							$codigo_retorno = 1;
							$errores[] = 'No se encontraron barrios disponibles';
						}

						if ($termino_barrio != null) 
						{
							$neighborhood = $termino_barrio->description;
						} 
						else 
						{
							$codigo_retorno = 1;
							$errores[] = 'No se encontró el codigo de barrio con su respectiva ciudad';
							// Loguear candidatos encontrados para depuración
							$log = [
								'context' => 'validacion_publicacion - código de barrio no encontrado',
								'nombre_barrio' => $nombre_barrio,
								'id_ciudad' => $id_ciudad,
								'posibles_barrios' => $posibles_barrios
							];
							error_log(json_encode($log));
						}

					}
				}			
			}

			$latitud = $_POST['property_latitude'];
			$longitud = $_POST['property_longitude'];

			foreach ($campos_especificos as $indice => $campo_especifico)
			{
				if (!empty($campo_especifico['tags']['required']))
				{
					foreach ($this->vectorCamposWpMeli as $wpMeli)
					{
						$indicador_invalido = 0;
						if ($campo_especifico['id'] == $wpMeli['meli_comparacion'] && $wpMeli['tipo'] == 'Específico')
						{
							if (isset($_POST[$wpMeli['html_comparacion']]))
							{
								if (!empty($_POST[$wpMeli['html_comparacion']]) || $_POST[$wpMeli['html_comparacion']] == $wpMeli['valor_minimo_permitido'])
								{
									if ($_POST[$wpMeli['html_comparacion']] != 'No disponible')
									{
										if (isset($wpMeli['informacion_adicional']['unidades_permitidas']))
										{
											$vector_campos_especificos[$campo_especifico['id']] = $_POST[$wpMeli['html_comparacion']].' '.$wpMeli['informacion_adicional']['unidades_permitidas'];
										}
										else
										{
											$vector_campos_especificos[$campo_especifico['id']] = $_POST[$wpMeli['html_comparacion']];
										}
									}
									else
									{
										$indicador_invalido = 1;
									}
								}
								else
								{
									$indicador_invalido = 1;
								}
							}
							else
							{
								$indicador_invalido = 1;
							}
							if ($indicador_invalido == 1)
							{
								update_user_meta($usuario->ID, '_ofiliaria_campo_especifico_no_existe_o_datos_invalidos_'.$wpMeli['html_comparacion'], $wpMeli['html_comparacion']);
								$codigo_retorno = 1;
								$errores[] = 'Por favor ingresar un valor para: '.$wpMeli['descripcion'];
							}
						}
					}
				}
			}

			foreach ($campos_a_mostrar as $indice_campo_a_mostrar => $campo_a_mostrar)
			{
				if ($campo_a_mostrar['campo_requerido'] == 0)
				{
					if (isset($campo_a_mostrar['meli']) && !empty($campo_a_mostrar['meli']))
					{
						if (isset($_POST[$indice_campo_a_mostrar]))
						{
							if (!empty($_POST[$indice_campo_a_mostrar]) || (isset($campo_a_mostrar['valor_minimo_permitido']) && $_POST[$indice_campo_a_mostrar] == $campo_a_mostrar['valor_minimo_permitido']))
							{
								if ($_POST[$indice_campo_a_mostrar] != 'No disponible')
								{
									if (isset($campo_a_mostrar['unidades_permitidas']) && !empty($campo_a_mostrar['unidades_permitidas']))
									{
										$vector_campos_especificos[$campo_a_mostrar['meli']] = $_POST[$indice_campo_a_mostrar].' '.$campo_a_mostrar['unidades_permitidas'];
									}
									else
									{
										$vector_campos_especificos[$campo_a_mostrar['meli']] = $_POST[$indice_campo_a_mostrar];
									}
								}
							}
						}
					}
				}
			}
		}

        if (!empty($_POST['ofiliaria_publicar_infocasas']))
        {
			$respuesta_infocasas = $this->validacion_publicacion_infocasas($usuario, $identificador, $validacion_meli, $codigo_retorno, $errores);
			$codigo_retorno = $respuesta_infocasas['codigo_retorno'];
			$errores = $respuesta_infocasas['errores'];
		}

		if ($codigo_retorno == 0)
		{
			if ($validacion_meli == 'Sí')
			{
				$parametros['titulo'] = $titulo;
				$parametros['descripcion_texto_plano'] = $descripcion_texto_plano;
				$parametros['nombre_contacto'] = $nombre_contacto;
				$parametros['telefono_movil'] = $telefono_movil;
				$parametros['email'] = $email;
				$parametros['categoria_inmueble'] = $categoria_inmueble;
				$parametros['tipo_operacion'] = $tipo_operacion;
				$parametros['id_categoria_meli'] = $id_categoria_meli;
				$parametros['direccion'] = $direccion;
				$parametros['latitud'] = $latitud;
				$parametros['longitud'] = $longitud;
				$parametros['neighborhood'] = $neighborhood;
				$parametros['city'] = $city;
				$parametros['divisa'] = $divisa;
				$parametros['campos_generales'] = $campos_generales;
				$parametros['campos_especificos'] = $campos_especificos;
				$parametros['campos_a_mostrar'] = $campos_a_mostrar;
				$parametros['vector_campos_generales'] = $vector_campos_generales;
				$parametros['vector_campos_especificos'] = $vector_campos_especificos;
				update_user_meta($usuario->ID, '_ofiliaria_parametros_publicacion_meli_'.$identificador, $parametros);
				// $array_string = print_r($vector_campos_especificos, true);
				// error_log("vector_campos_especificos:\n". $array_string);
		
			}
			$mensaje = 'Validación exitosa';
		}
		else
		{
			foreach ($errores as $indice => $error)
			{
				$lista_de_errores .= $error.'</br>';
			}
			$mensaje = 'Validación no exitosa';
		}

		$respuesta_validacion_publicacion = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'identificador' => $identificador,
			'lista_de_errores' => $lista_de_errores
		];	
		exit(json_encode($respuesta_validacion_publicacion));
	}

    public function paquetes_activos_meli($usuario)
	{	
		$token_meli = get_user_meta($usuario->ID, '_token_meli', true);
		$vector_token_meli = explode("-", $token_meli);
		$longitud_vector = count($vector_token_meli);
		$id_usuario_meli = $vector_token_meli[$longitud_vector-1];
		
		$url = "https://api.mercadolibre.com/users/".$id_usuario_meli."/classifieds_promotion_packs?package_content=ALL&status=active";
		$headers = 
			[
				"Authorization: Bearer ".$token_meli
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		$respuestaPaquete = json_decode($response);

		update_user_meta($usuario->ID, '_ofiliaria_respuesta_paquetes_activos_meli', $response );	

		if (isset($respuestaPaquete->status))
		{
			if ($respuestaPaquete->status == 404)
			{
				return ['codigo_retorno' => 1, 'mensaje' => 'No se encontraron paquetes'];
			}
			else
			{
				return ['codigo_retorno' => 2, 'mensaje' => 'Hubo un error en la solicitud'];
			}
		}

		if (is_array($respuestaPaquete) && !empty($respuestaPaquete)) {
			$cupos_disponibles = false;

			// Recorremos cada paquete y verificamos distintos campos que pueden indicar
			// cupos disponibles según la respuesta real de la API de Mercado Libre.
			foreach ($respuestaPaquete as $paquete) {
				// 1) Campo top-level remaining_listings (ej: remaining_listings: 71)
				if (isset($paquete->remaining_listings) && intval($paquete->remaining_listings) > 0) {
					$cupos_disponibles = true;
					break;
				}

				// 2) Campos used_listings / available_listings a nivel paquete
				if (isset($paquete->available_listings) && isset($paquete->used_listings)) {
					$disponible = intval($paquete->available_listings) - intval($paquete->used_listings);
					if ($disponible > 0) {
						$cupos_disponibles = true;
						break;
					}
				}

				// 3) listing_details: revisar cada detalle (por listing_type_id)
				if (isset($paquete->listing_details) && is_array($paquete->listing_details)) {
					foreach ($paquete->listing_details as $detalle) {
						if (isset($detalle->remaining_listings) && intval($detalle->remaining_listings) > 0) {
							$cupos_disponibles = true;
							break 2; // salimos de ambos foreach
						}

						if (isset($detalle->available_listings) && isset($detalle->used_listings)) {
							$disp = intval($detalle->available_listings) - intval($detalle->used_listings);
							if ($disp > 0) {
								$cupos_disponibles = true;
								break 2;
							}
						}
					}
				}
			}

			if ($cupos_disponibles) {
				return [
					'codigo_retorno' => 0,
					'mensaje' => 'Se encontraron paquetes activos',
					'paquetes' => $respuestaPaquete
				];
			} else {
				return [
					'codigo_retorno' => 3,
					'mensaje' => 'No hay cupos disponibles en los paquetes activos'
				];
			}
		}
	
		// Cualquier otro error desconocido
		return ['codigo_retorno' => 2, 'mensaje' => 'Hubo un error desconocido en la solicitud'];
	}
	
	/**
	 * Gestiona el envío de publicaciones a la API de Mercado Libre,
	 * incluyendo la republicación de ítems cerrados.
	 *
	 * @param WP_User $usuario                El objeto de usuario de WordPress.
	 * @param string  $identificador          Identificador de la publicación.
	 * @param int     $id_post_publicacion    ID del post de WordPress.
	 * @param string  $id_publicacion_meli    ID de la publicación de Mercado Libre (0 si es nueva).
	 */
	public function envio_publicacion_meli($usuario, $identificador, $id_post_publicacion, $id_publicacion_meli, $estatus_publicacion_meli, $estatus_publicacion_ofiliaria)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$fecha_hora_envio_publicacion_meli = date("Y-m-d H:i:s");			

		$this->registrar_campos_adicionales($id_post_publicacion);
		$parametros = get_user_meta($usuario->ID, '_ofiliaria_parametros_publicacion_meli_'.$identificador, true);
		delete_user_meta($usuario->ID, '_ofiliaria_parametros_publicacion_meli_'.$identificador);
		$eliminar_indicador_publicar_meli = 0;

		error_log('estatus_publicacion_ofiliaria: '.$estatus_publicacion_ofiliaria);
		if (!empty($parametros))
		{
			$indicador_editar_publicacion = 0;
			$es_publicacion_cerrada = false;
			$es_publicacion_pausada = false;
	
			if ($id_publicacion_meli != 0)
			{
				if ($estatus_publicacion_meli == 'active') 
				{
					$indicador_editar_publicacion = 1;
				} 
				elseif ($estatus_publicacion_meli == 'closed') 
				{
					$es_publicacion_cerrada = true;
				}
				elseif ($estatus_publicacion_meli == 'paused')
				{
					$es_publicacion_pausada = true;
				}
			}
	
			// Modificamos la condición para incluir la bandera de publicación cerrada y pausada
			if ($id_publicacion_meli == 0 || $indicador_editar_publicacion == 1 || $es_publicacion_cerrada || $es_publicacion_pausada)
			{
				update_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_mercado_libre', 'Sí');
				error_log('indicador_editar_publicacion: '.$indicador_editar_publicacion);
				if ($estatus_publicacion_ofiliaria == 'draft')
				{	
					if ($indicador_editar_publicacion == 1)
					{
						$resultado_pausar_activar_publicacion = $this->pausar_activar_publicacion_meli($id_post_publicacion, 'disabled', $usuario);
						error_log('resultado_pausar_activar_publicacion: '.print_r($resultado_pausar_activar_publicacion, true));
					}			 
				}
				else
				{
					$nombre_contacto = $parametros['nombre_contacto'];
					$telefono_movil = $parametros['telefono_movil'];
					$telefono_whatsapp = $this->preparar_numero_whatsapp($parametros['telefono_movil']);
					$email = $parametros['email'];
					$categoria_inmueble = $parametros['categoria_inmueble'];
					$tipo_operacion = $parametros['tipo_operacion'];
					$id_categoria_meli = $parametros['id_categoria_meli'];
					$vector_campos_generales = $parametros['vector_campos_generales'];
					$vector_campos_especificos = $parametros['vector_campos_especificos'];
					$divisa = $parametros['divisa'];
					$vector_campos_meli = [];
					$vector_location = [];
					$atributos = [];
					$datos_descripcion = [];
		
					$post_publicacion = get_post($id_post_publicacion);

					if ($es_publicacion_pausada)
					{
						$vector_campos_meli['status'] = 'active';
					}
					
					$vector_campos_meli['title'] = $parametros['titulo'];
					
					$vector_campos_meli['category_id'] = $id_categoria_meli;
					
					foreach ($vector_campos_generales as $indice => $campo_general)
					{
						$vector_campos_meli[$indice] = $campo_general;
					}
		
					$vector_campos_meli['currency_id'] = $divisa;
					$vector_campos_meli['available_quantity'] = 1;
					$vector_campos_meli['buying_mode'] = 'classified';
		
					// El listing_type_id es necesario para la republicación, aunque se puede omitir si se usa el original.
					// Para mayor seguridad, lo incluimos.
					if ($id_publicacion_meli == 0 || $es_publicacion_cerrada)
					{       
						$vector_campos_meli['listing_type_id'] = 'silver';
					}
		
					$vector_campos_meli['condition'] = 'not_specified';
					$vector_campos_meli['channels'] = ["marketplace"];
		
					// --- MEJORA DE LÓGICA DE VIDEO ---
					$video_id_final = '';

					// 1. Prioridad: Matterport (Tour Virtual)
					$embed_virtual_tour = get_post_meta($id_post_publicacion, 'embed_virtual_tour', true);

					// 2. Otros Videos (YouTube / Vimeo)
					$video_type = get_post_meta($id_post_publicacion, 'embed_video_type', true); // "youtube" o "vimeo"
					$video_id_raw = get_post_meta($id_post_publicacion, 'embed_video_id', true);

					if (!empty($embed_virtual_tour)) {
						// Si hay Matterport, lo enviamos con su sufijo
						$video_id_final = $embed_virtual_tour . ';matterport';
					} 
					elseif (!empty($video_id_raw)) {
						if ($video_type === 'youtube') {
							// Limpiamos el link de YouTube para obtener solo los 11 caracteres
							$clean_id = $this->extraer_youtube_id($video_id_raw);
							$video_id_final = $clean_id;
						} 
						elseif ($video_type === 'meli') {
							// Si en el CRM marcas el tipo como 'meli', añadimos el sufijo correspondiente
							$video_id_final = $video_id_raw . ';meli';
						}
					}

					// Asignamos al vector de campos si se encontró algún video
					if (!empty($video_id_final)) {
						$vector_campos_meli['video_id'] = $video_id_final;
					}
					// --- FIN MEJORA DE VIDEO ---
		
					$imagenes_asociadas = get_post_meta($id_post_publicacion, 'wpestate_property_gallery', true);
		
					if (!empty($imagenes_asociadas))
					{
						$imagenes_enviar = [];  
						foreach ($imagenes_asociadas as $imagen)
						{
							global $wpdb;
							$nombre_tabla = $wpdb->prefix.'as3cf_items';    
				
							$busqueda = "SELECT * FROM {$nombre_tabla} WHERE source_id = {$imagen}";                    
							$imagen_aws = $wpdb->get_row( $busqueda, OBJECT );
					
							$url_imagen_aws = '';
							if (is_object($imagen_aws) && !empty($imagen_aws)) 
							{
								$url_imagen_aws = 'https://'.$imagen_aws->bucket.'/'.$imagen_aws->path;                         
							}
							else
							{
								$post_adjunto = get_post($imagen);  
								if ( $post_adjunto === null ) 
								{
									update_user_meta($usuario->ID, '_ofiliaria_agregar_inmueble_meli_imagen_no_encontrada_'.$imagen, $imagen );
								} 
								else 
								{
									$url_imagen_aws = $post_adjunto->guid;
								}
							}
							if ($url_imagen_aws != '')
							{
								$imagenes_enviar[] = ['source' => $url_imagen_aws];   
							}
						}
					}
					else
					{
						update_user_meta($usuario->ID, '_ofiliaria_agregar_inmueble_meli_sin_imagenes_asociadas', $id_post_publicacion );
					}
		
					$vector_campos_meli['pictures'] = $imagenes_enviar;
		
					$vector_campos_meli['seller_contact'] = 
						[
							'contact' => $nombre_contacto,
							"country_code" => "598",
							'phone' => $telefono_whatsapp,
							"country_code2" =>  "598",
							"phone2" => $telefono_whatsapp,
							'email' => $email,
						];
		
					$vector_location['address_line'] = $parametros['direccion'];
		
					if ($parametros['neighborhood'] != '')
					{
						$vector_location['neighborhood'] = ['id' => $parametros['neighborhood']];
					}
					else
					{
						$vector_location['city'] = ['id' => $parametros['city']];
					} 
					$vector_location['latitude'] = $parametros['latitud'];
					$vector_location['longitude'] = $parametros['longitud'];
		
					$vector_campos_meli['location'] = $vector_location; 
		
					foreach ($vector_campos_especificos as $indice => $campo_especifico)
					{
						$atributos[] = 
							[
								'id' => $indice,
								'value_name' => $campo_especifico
							];
					}
		
					$vector_campos_meli['attributes'] = $atributos;
		
					$json_vector_campos_meli = json_encode($vector_campos_meli);
				
					update_post_meta($id_post_publicacion, '_ofiliaria_vector_campos_meli_enviado', $json_vector_campos_meli);

					$respuesta_obtener_token_meli = $this->obtener_token_meli($usuario->ID);
		
					if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
					{
						$token_meli = $respuesta_obtener_token_meli['token_meli'];
			
						$punto_final = '';
						$metodo_http = '';
		
						if ($es_publicacion_cerrada) {
							// Si la publicación está cerrada, usamos el endpoint de republicación.
							// $url = 'https://api.mercadolibre.com/items/'.$id_publicacion_meli.'/relist'; No funciona
							$punto_final = 'items';
							$metodo_http = "POST";
						} elseif ($id_publicacion_meli != 0) {
							// Si existe y está activa, actualizamos con PUT.
							$punto_final = 'items/'.$id_publicacion_meli;
							$metodo_http = "PUT";
						} else {
							// Si es una publicación nueva, usamos POST.
							$punto_final = 'items';
							$metodo_http = "POST";
						}
						
						$respuesta_meli = $this->enviar_solicitud_meli(
							$punto_final,
							$metodo_http,
							$vector_campos_meli,
							true, // Requiere autenticación
							$token_meli
						);

						error_log('respuesta_meli: '.print_r($respuesta_meli, true));

						$respuesta   = $respuesta_meli['respuesta']; 
						$codigo_http = $respuesta_meli['codigo'];
						$error_curl  = $respuesta_meli['error'];
						$success 	 = $respuesta_meli['success'];

						update_post_meta($id_post_publicacion, '_ofiliaria_respuesta_envio_publicacion_meli', $respuesta );
						update_post_meta($id_post_publicacion, '_ofiliaria_codigo_retorno_envio_publicacion_meli', $codigo_http);
						update_post_meta($id_post_publicacion, '_ofiliaria_fecha_hora_envio_publicacion_meli', $fecha_hora_envio_publicacion_meli);
						
						if ($respuesta === false) {
							update_post_meta($id_post_publicacion, '_ofiliaria_curl_error_envio_publicacion_meli', $error_curl); 
						}

						$respuesta_objeto = json_decode($respuesta);

						if (isset($respuesta_objeto->id))
						{
							// Si se republicó o se creó, guardamos el nuevo ID devuelto por la API.
							if ($id_publicacion_meli == 0 || $es_publicacion_cerrada) {
								update_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', $respuesta_objeto->id);
								// Limpiamos el ID anterior para evitar confusiones
								if ($es_publicacion_cerrada) {
								delete_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', $id_publicacion_meli);
								}
							}
							update_post_meta($id_post_publicacion, '_ofiliaria_permalink_publicacion_meli', $respuesta_objeto->permalink);
							update_post_meta($id_post_publicacion, '_ofiliaria_id_usuario_meli', $respuesta_objeto->seller_id );
		
							// Lógica para enviar la descripción
							$punto_final_descripcion = '';
							$metodo_http_descripcion = '';
							
							// Al republicar, la descripción se crea como parte de la nueva publicación.
							// Si se está editando, la URL debe llevar el ID original.
							if ($id_publicacion_meli != 0 && !$es_publicacion_cerrada)
							{
								$punto_final_descripcion = 'items/'.$id_publicacion_meli.'/description?api_version=2';
								$metodo_http_descripcion = "PUT";
							} else {
								// En nuevas publicaciones y republicaciones, usamos el nuevo ID.
								$punto_final_descripcion = 'items/'.$respuesta_objeto->id.'/description';
								$metodo_http_descripcion = "POST";
							}
			
							$datos_descripcion =
								[
									'plain_text' => $parametros['descripcion_texto_plano']
								];

							update_post_meta($id_post_publicacion, '_ofiliaria_descripcion_texto_plano_meli_enviada', $parametros['descripcion_texto_plano']);

							$respuesta_meli_descripcion = $this->enviar_solicitud_meli(
								$punto_final_descripcion,
								$metodo_http_descripcion,
								$datos_descripcion,
								true, // Requiere autenticación
								$token_meli
							);

							$respuesta   = $respuesta_meli_descripcion['respuesta']; 
							$codigo_http = $respuesta_meli_descripcion['codigo'];
							$error_curl  = $respuesta_meli_descripcion['error'];
							$success 	 = $respuesta_meli_descripcion['success'];
								
							update_post_meta($id_post_publicacion, '_ofiliaria_respuesta_descripcion_meli', $respuesta );
							update_post_meta($id_post_publicacion, '_ofiliaria_codigo_retorno_descripcion_meli', $codigo_http);
							update_post_meta($id_post_publicacion, '_ofiliaria_fecha_hora_descripcion_meli', $fecha_hora_envio_publicacion_meli);

							if ($respuesta === false) 
							{
								update_post_meta($id_post_publicacion, '_ofiliaria_curl_error_descripcion_meli', $error_curl); 
							}
						
							$respuesta_objeto = json_decode($respuesta);

							if (isset($respuesta_objeto->plain_text))
							{
								$message_data = [
									'message' => __( '¡La publicación se ha enviado/actualizado correctamente en Mercado Libre!', 'wpresidence' ),
									'type'    => 'success',
								];
								set_transient( 'wpestate_flash_message_' . $usuario->ID, $message_data, 60 );
							}
							else
							{
								$error_list_html = '';
								if (isset($respuesta_objeto->message) && !empty($respuesta_objeto->message)) {
									$error_list_html .= '<ul>';
									
									// Agregamos el mensaje principal
									$error_list_html .= '<li><strong>Error:</strong> ' . esc_html($respuesta_objeto->message) . '</li>';

									// Verificamos si hay causas detalladas (es un array)
									if (isset($respuesta_objeto->cause) && is_array($respuesta_objeto->cause)) {
										foreach ($respuesta_objeto->cause as $causa) {
											if (isset($causa->message)) {
												// Escapamos el mensaje por seguridad
												$error_list_html .= '<li>' . esc_html($causa->message) . '</li>';
											}
										}
									}
									
									$error_list_html .= '</ul>';
								}
								$final_message = !empty($error_list_html) ?
									__('La publicación se envió a Mercado Libre, pero hubo un error al guardar la descripción.', 'wpresidence').$error_list_html.'Si puede corregir el error, por favor hágalo, de lo contrario contacte al personal de soporte de Ofiliaria' :
									__('La publicación se envió a Mercado Libre, pero al guardar la descripción ocurrió un error pero no se logró identificar sus causas. Por favor contacte al personal de soporte de Ofiliaria', 'wpresidence');

								$message_data = [
									'message' => $final_message,
									'type'    => 'danger',
								];
								set_transient( 'wpestate_flash_message_' . $usuario->ID, $message_data, 60 );


							}
						}
						else
						{
							$error_list_html = '';
							if (isset($respuesta_objeto->message) && !empty($respuesta_objeto->message)) {
								$error_list_html .= '<ul>';
								
								// Agregamos el mensaje principal
								$error_list_html .= '<li><strong>Error:</strong> ' . esc_html($respuesta_objeto->message) . '</li>';

								// Verificamos si hay causas detalladas (es un array)
								if (isset($respuesta_objeto->cause) && is_array($respuesta_objeto->cause)) {
									foreach ($respuesta_objeto->cause as $causa) {
										if (isset($causa->message)) {
											// Escapamos el mensaje por seguridad
											$error_list_html .= '<li>' . esc_html($causa->message) . '</li>';
										}
									}
								}
								
								$error_list_html .= '</ul>';
							}
							$final_message = !empty($error_list_html) ?
								__('La publicación no se replicó en Mercado Libre por los siguientes motivos:', 'wpresidence').$error_list_html.'Si puede corregir el error, por favor hágalo, de lo contrario contacte al personal de soporte de Ofiliaria' :
								__('La publicación no se replicó en Mercado Libre debido a un error desconocido. Por favor contacte al personal de soporte de Ofiliaria', 'wpresidence');

							$message_data = [
								'message' => $final_message,
								'type'    => 'danger',
							];
							set_transient( 'wpestate_flash_message_' . $usuario->ID, $message_data, 60 );
						}				
					}
				}
			}
			else
			{
				if ($id_publicacion_meli != 0)
				{
					$eliminar_indicador_publicar_meli = 1; 
				}   
			}
		}
		else
		{
			$eliminar_indicador_publicar_meli = 1; 
		}
		
		if ($eliminar_indicador_publicar_meli == 1)
		{
			$indicador_publicar_meli = get_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_mercado_libre', true);
			if ($indicador_publicar_meli == 'Sí')
			{
				delete_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_mercado_libre');
			}
		}
		return;
	}

	public function registrar_campos_adicionales($id_post_publicacion = null)
	{
		// Campos para la calidad de la publicación

		$_ofiliaria_banio_social = isset($_POST['_ofiliaria_banio_social']) ? sanitize_text_field($_POST['_ofiliaria_banio_social']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_banio_social', $_ofiliaria_banio_social);

		$_ofiliaria_dormitorio_de_servicio = isset($_POST['_ofiliaria_dormitorio_de_servicio']) ? sanitize_text_field($_POST['_ofiliaria_dormitorio_de_servicio']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_dormitorio_de_servicio', $_ofiliaria_dormitorio_de_servicio);

		$_ofiliaria_superficie_de_balcon = isset($_POST['_ofiliaria_superficie_de_balcon']) ? $_POST['_ofiliaria_superficie_de_balcon'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_superficie_de_balcon', $_ofiliaria_superficie_de_balcon);

		$_ofiliaria_ambientes = isset($_POST['_ofiliaria_ambientes']) ? $_POST['_ofiliaria_ambientes'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_ambientes', $_ofiliaria_ambientes);

		$_ofiliaria_parrillero = isset($_POST['_ofiliaria_parrillero']) ? sanitize_text_field($_POST['_ofiliaria_parrillero']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_parrillero', $_ofiliaria_parrillero);

		$_ofiliaria_piscina = isset($_POST['_ofiliaria_piscina']) ? sanitize_text_field($_POST['_ofiliaria_piscina']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_piscina', $_ofiliaria_piscina);

		$_ofiliaria_terraza = isset($_POST['_ofiliaria_terraza']) ? sanitize_text_field($_POST['_ofiliaria_terraza']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_terraza', $_ofiliaria_terraza);

		$_ofiliaria_bodegas = isset($_POST['_ofiliaria_bodegas']) ? $_POST['_ofiliaria_bodegas'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_bodegas', $_ofiliaria_bodegas);

		$estacionamiento = isset($_POST['estacionamiento']) ? $_POST['estacionamiento'] : '';    
		update_post_meta($id_post_publicacion, 'estacionamiento', $estacionamiento);

		$_ofiliaria_camas = isset($_POST['_ofiliaria_camas']) ? $_POST['_ofiliaria_camas'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_camas', $_ofiliaria_camas);

		$_ofiliaria_amoblado = isset($_POST['_ofiliaria_amoblado']) ? sanitize_text_field($_POST['_ofiliaria_amoblado']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_amoblado', $_ofiliaria_amoblado);

		$_ofiliaria_huespedes = isset($_POST['_ofiliaria_huespedes']) ? $_POST['_ofiliaria_huespedes'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_huespedes', $_ofiliaria_huespedes);

		$_ofiliaria_admite_mascotas = isset($_POST['_ofiliaria_admite_mascotas']) ? sanitize_text_field($_POST['_ofiliaria_admite_mascotas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_admite_mascotas', $_ofiliaria_admite_mascotas);

		$_ofiliaria_uso_comercial = isset($_POST['_ofiliaria_uso_comercial']) ? sanitize_text_field($_POST['_ofiliaria_uso_comercial']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_uso_comercial', $_ofiliaria_uso_comercial);

		$_ofiliaria_tipo_de_departamento = isset($_POST['_ofiliaria_tipo_de_departamento']) ? sanitize_text_field($_POST['_ofiliaria_tipo_de_departamento']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_tipo_de_departamento', $_ofiliaria_tipo_de_departamento);

		$_ofiliaria_tipo_de_casa = isset($_POST['_ofiliaria_tipo_de_casa']) ? sanitize_text_field($_POST['_ofiliaria_tipo_de_casa']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_tipo_de_casa', $_ofiliaria_tipo_de_casa);

		$_ofiliaria_tipo_de_campo = isset($_POST['_ofiliaria_tipo_de_campo']) ? sanitize_text_field($_POST['_ofiliaria_tipo_de_campo']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_tipo_de_campo', $_ofiliaria_tipo_de_campo);

		$_ofiliaria_cantidad_de_pisos = isset($_POST['_ofiliaria_cantidad_de_pisos']) ? $_POST['_ofiliaria_cantidad_de_pisos'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_cantidad_de_pisos', $_ofiliaria_cantidad_de_pisos);

		$_ofiliaria_numero_de_piso_de_la_unidad = isset($_POST['_ofiliaria_numero_de_piso_de_la_unidad']) ? $_POST['_ofiliaria_numero_de_piso_de_la_unidad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_numero_de_piso_de_la_unidad', $_ofiliaria_numero_de_piso_de_la_unidad);

		$_ofiliaria_apartamentos_por_piso = isset($_POST['_ofiliaria_apartamentos_por_piso']) ? $_POST['_ofiliaria_apartamentos_por_piso'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_apartamentos_por_piso', $_ofiliaria_apartamentos_por_piso);

		$_ofiliaria_disposicion = isset($_POST['_ofiliaria_disposicion']) ? sanitize_text_field($_POST['_ofiliaria_disposicion']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_disposicion', $_ofiliaria_disposicion);

		$_ofiliaria_orientacion = isset($_POST['_ofiliaria_orientacion']) ? sanitize_text_field($_POST['_ofiliaria_orientacion']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_orientacion', $_ofiliaria_orientacion);

		$_ofiliaria_superficie_cubierta_del_casco = isset($_POST['_ofiliaria_superficie_cubierta_del_casco']) ? $_POST['_ofiliaria_superficie_cubierta_del_casco'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_superficie_cubierta_del_casco', $_ofiliaria_superficie_cubierta_del_casco);

		$_ofiliaria_superficie_de_terreno = isset($_POST['_ofiliaria_superficie_de_terreno']) ? $_POST['_ofiliaria_superficie_de_terreno'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_superficie_de_terreno', $_ofiliaria_superficie_de_terreno);

		$_ofiliaria_forma_del_terreno = isset($_POST['_ofiliaria_forma_del_terreno']) ? sanitize_text_field($_POST['_ofiliaria_forma_del_terreno']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_forma_del_terreno', $_ofiliaria_forma_del_terreno);

		$_ofiliaria_acceso_lote_terreno = isset($_POST['_ofiliaria_acceso_lote_terreno']) ? sanitize_text_field($_POST['_ofiliaria_acceso_lote_terreno']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_acceso_lote_terreno', $_ofiliaria_acceso_lote_terreno);

		$_ofiliaria_distancia_al_asfalto = isset($_POST['_ofiliaria_distancia_al_asfalto']) ? $_POST['_ofiliaria_distancia_al_asfalto'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_distancia_al_asfalto', $_ofiliaria_distancia_al_asfalto);

		$_ofiliaria_anio_construccion_de_la_propiedad = isset($_POST['_ofiliaria_anio_construccion_de_la_propiedad']) ? $_POST['_ofiliaria_anio_construccion_de_la_propiedad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_anio_construccion_de_la_propiedad', $_ofiliaria_anio_construccion_de_la_propiedad);

		$_ofiliaria_antiguedad = isset($_POST['_ofiliaria_antiguedad']) ? $_POST['_ofiliaria_antiguedad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_antiguedad', $_ofiliaria_antiguedad);

		$_ofiliaria_numero_del_apartamento = isset($_POST['_ofiliaria_numero_del_apartamento']) ? sanitize_text_field($_POST['_ofiliaria_numero_del_apartamento']) : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_numero_del_apartamento', $_ofiliaria_numero_del_apartamento);

		$_ofiliaria_numero_de_la_casa = isset($_POST['_ofiliaria_numero_de_la_casa']) ? sanitize_text_field($_POST['_ofiliaria_numero_de_la_casa']) : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_numero_de_la_casa', $_ofiliaria_numero_de_la_casa);

		$_ofiliaria_codigo_de_la_propiedad = isset($_POST['_ofiliaria_codigo_de_la_propiedad']) ? sanitize_text_field($_POST['_ofiliaria_codigo_de_la_propiedad']) : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_codigo_de_la_propiedad', $_ofiliaria_codigo_de_la_propiedad);

		$_ofiliaria_horario_de_contacto = isset($_POST['_ofiliaria_horario_de_contacto']) ? sanitize_text_field($_POST['_ofiliaria_horario_de_contacto']) : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_horario_de_contacto', $_ofiliaria_horario_de_contacto);

		$_ofiliaria_sobre = isset($_POST['_ofiliaria_sobre']) ? sanitize_text_field($_POST['_ofiliaria_sobre']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_sobre', $_ofiliaria_sobre);

		$_ofiliaria_vivienda_social = isset($_POST['_ofiliaria_vivienda_social']) ? sanitize_text_field($_POST['_ofiliaria_vivienda_social']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_vivienda_social', $_ofiliaria_vivienda_social);

		$_ofiliaria_estado = isset($_POST['_ofiliaria_estado']) ? sanitize_text_field($_POST['_ofiliaria_estado']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_estado', $_ofiliaria_estado);

		$_ofiliaria_m2_terraza_propiedad = isset($_POST['_ofiliaria_m2_terraza_propiedad']) ? $_POST['_ofiliaria_m2_terraza_propiedad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_m2_terraza_propiedad', $_ofiliaria_m2_terraza_propiedad);

		$_ofiliaria_acepta_permuta = isset($_POST['_ofiliaria_acepta_permuta']) ? sanitize_text_field($_POST['_ofiliaria_acepta_permuta']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_acepta_permuta', $_ofiliaria_acepta_permuta);

		$_ofiliaria_cantidad_plantas_propiedad = isset($_POST['_ofiliaria_cantidad_plantas_propiedad']) ? $_POST['_ofiliaria_cantidad_plantas_propiedad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_cantidad_plantas_propiedad', $_ofiliaria_cantidad_plantas_propiedad);

		$_ofiliaria_gastos_comunes_propiedad = isset($_POST['_ofiliaria_gastos_comunes_propiedad']) ? $_POST['_ofiliaria_gastos_comunes_propiedad'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_gastos_comunes_propiedad', $_ofiliaria_gastos_comunes_propiedad);

		$_ofiliaria_moneda_gastos_comunes = isset($_POST['_ofiliaria_moneda_gastos_comunes']) ? sanitize_text_field($_POST['_ofiliaria_moneda_gastos_comunes']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_moneda_gastos_comunes', $_ofiliaria_moneda_gastos_comunes);

		$_ofiliaria_ofiliaria_horario_check_in = isset($_POST['_ofiliaria_ofiliaria_horario_check_in']) ? sanitize_text_field($_POST['_ofiliaria_ofiliaria_horario_check_in']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_ofiliaria_horario_check_in', $_ofiliaria_ofiliaria_horario_check_in);

		$_ofiliaria_horario_check_out = isset($_POST['_ofiliaria_horario_check_out']) ? sanitize_text_field($_POST['_ofiliaria_horario_check_out']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_horario_check_out', $_ofiliaria_horario_check_out);

		$_ofiliaria_servicio_de_desayuno = isset($_POST['_ofiliaria_servicio_de_desayuno']) ? sanitize_text_field($_POST['_ofiliaria_servicio_de_desayuno']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_servicio_de_desayuno', $_ofiliaria_servicio_de_desayuno);

		$_ofiliaria_servicio_de_limpieza = isset($_POST['_ofiliaria_servicio_de_limpieza']) ? sanitize_text_field($_POST['_ofiliaria_servicio_de_limpieza']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_servicio_de_limpieza', $_ofiliaria_servicio_de_limpieza);

		$_ofiliaria_estadia_minima_noches = isset($_POST['_ofiliaria_estadia_minima_noches']) ? $_POST['_ofiliaria_estadia_minima_noches'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_estadia_minima_noches', $_ofiliaria_estadia_minima_noches);

		$_ofiliaria_apto_para_oficina = isset($_POST['_ofiliaria_apto_para_oficina']) ? sanitize_text_field($_POST['_ofiliaria_apto_para_oficina']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_apto_para_oficina', $_ofiliaria_apto_para_oficina);

		// Campos adicionales

		$_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre']) ? $_POST['_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre'] : '';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre', $_ofiliaria_adicional_comodidades_equipamiento_numero_de_torre);

		$_ofiliaria_adicional_servicios_acceso_a_internet = isset($_POST['_ofiliaria_adicional_servicios_acceso_a_internet']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_acceso_a_internet']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_acceso_a_internet', $_ofiliaria_adicional_servicios_acceso_a_internet);

		$_ofiliaria_adicional_servicios_gas_natural = isset($_POST['_ofiliaria_adicional_servicios_gas_natural']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_gas_natural']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_gas_natural', $_ofiliaria_adicional_servicios_gas_natural);

		$_ofiliaria_adicional_servicios_linea_telefonica = isset($_POST['_ofiliaria_adicional_servicios_linea_telefonica']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_linea_telefonica']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_linea_telefonica', $_ofiliaria_adicional_servicios_linea_telefonica);

		$_ofiliaria_adicional_servicios_tv_por_cable = isset($_POST['_ofiliaria_adicional_servicios_tv_por_cable']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_tv_por_cable']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_tv_por_cable', $_ofiliaria_adicional_servicios_tv_por_cable);

		$_ofiliaria_adicional_servicios_aire_acondicionado = isset($_POST['_ofiliaria_adicional_servicios_aire_acondicionado']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_aire_acondicionado']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_aire_acondicionado', $_ofiliaria_adicional_servicios_aire_acondicionado);

		$_ofiliaria_adicional_servicios_calefaccion = isset($_POST['_ofiliaria_adicional_servicios_calefaccion']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_calefaccion']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_calefaccion', $_ofiliaria_adicional_servicios_calefaccion);

		$_ofiliaria_adicional_servicios_agua_corriente = isset($_POST['_ofiliaria_adicional_servicios_agua_corriente']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_agua_corriente']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_agua_corriente', $_ofiliaria_adicional_servicios_agua_corriente);

		$_ofiliaria_adicional_servicios_caldera_a_gas_electrica = isset($_POST['_ofiliaria_adicional_servicios_caldera_a_gas_electrica']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_caldera_a_gas_electrica']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_caldera_a_gas_electrica', $_ofiliaria_adicional_servicios_caldera_a_gas_electrica);

		$_ofiliaria_adicional_servicios_con_energia_solar = isset($_POST['_ofiliaria_adicional_servicios_con_energia_solar']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_con_energia_solar']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_con_energia_solar', $_ofiliaria_adicional_servicios_con_energia_solar);

		$_ofiliaria_adicional_servicios_con_conexion_para_lavarropas = isset($_POST['_ofiliaria_adicional_servicios_con_conexion_para_lavarropas']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_con_conexion_para_lavarropas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_con_conexion_para_lavarropas', $_ofiliaria_adicional_servicios_con_conexion_para_lavarropas);

		$_ofiliaria_adicional_servicios_grupo_electrogeno = isset($_POST['_ofiliaria_adicional_servicios_grupo_electrogeno']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_grupo_electrogeno']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_grupo_electrogeno', $_ofiliaria_adicional_servicios_grupo_electrogeno);

		$_ofiliaria_adicional_servicios_con_tv_satelital = isset($_POST['_ofiliaria_adicional_servicios_con_tv_satelital']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_con_tv_satelital']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_con_tv_satelital', $_ofiliaria_adicional_servicios_con_tv_satelital);

		$_ofiliaria_adicional_servicios_jardinero = isset($_POST['_ofiliaria_adicional_servicios_jardinero']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_jardinero']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_jardinero', $_ofiliaria_adicional_servicios_jardinero);

		$_ofiliaria_adicional_servicios_luz_electrica = isset($_POST['_ofiliaria_adicional_servicios_luz_electrica']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_luz_electrica']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_luz_electrica', $_ofiliaria_adicional_servicios_luz_electrica);

		$_ofiliaria_adicional_servicios_saneamiento = isset($_POST['_ofiliaria_adicional_servicios_saneamiento']) ? sanitize_text_field($_POST['_ofiliaria_adicional_servicios_saneamiento']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_servicios_saneamiento', $_ofiliaria_adicional_servicios_saneamiento);

		$_ofiliaria_adicional_comodidades_equipamiento_ascensor = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_ascensor']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_ascensor']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_ascensor', $_ofiliaria_adicional_comodidades_equipamiento_ascensor);

		$_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol', $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_basquetbol);

		$_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle', $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_paddle);

		$_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis', $_ofiliaria_adicional_comodidades_equipamiento_cancha_de_tenis);

		$_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol', $_ofiliaria_adicional_comodidades_equipamiento_con_cancha_de_futbol);

		$_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva', $_ofiliaria_adicional_comodidades_equipamiento_con_cancha_polideportiva);

		$_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples', $_ofiliaria_adicional_comodidades_equipamiento_canchas_de_usos_múltiples);

		$_ofiliaria_adicional_comodidades_equipamiento_chimenea = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_chimenea']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_chimenea']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_chimenea', $_ofiliaria_adicional_comodidades_equipamiento_chimenea);

		$_ofiliaria_adicional_comodidades_equipamiento_con_area_verde = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_area_verde']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_con_area_verde']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_con_area_verde', $_ofiliaria_adicional_comodidades_equipamiento_con_area_verde);

		$_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas', $_ofiliaria_adicional_comodidades_equipamiento_estacionamiento_para_visitas);

		$_ofiliaria_adicional_comodidades_equipamiento_gimnasio = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_gimnasio']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_gimnasio']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_gimnasio', $_ofiliaria_adicional_comodidades_equipamiento_gimnasio);

		$_ofiliaria_adicional_comodidades_equipamiento_heladera = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_heladera']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_heladera']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_heladera', $_ofiliaria_adicional_comodidades_equipamiento_heladera);

		$_ofiliaria_adicional_comodidades_equipamiento_jacuzzi = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_jacuzzi']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_jacuzzi']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_jacuzzi', $_ofiliaria_adicional_comodidades_equipamiento_jacuzzi);

		$_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas', $_ofiliaria_adicional_comodidades_equipamiento_salon_de_fiestas);

		$_ofiliaria_adicional_comodidades_equipamiento_sauna = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_sauna']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_sauna']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_sauna', $_ofiliaria_adicional_comodidades_equipamiento_sauna);

		$_ofiliaria_adicional_comodidades_equipamiento_area_de_cine = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_area_de_cine']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_area_de_cine']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_area_de_cine', $_ofiliaria_adicional_comodidades_equipamiento_area_de_cine);

		$_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles', $_ofiliaria_adicional_comodidades_equipamiento_area_de_juegos_infantiles);

		$_ofiliaria_adicional_comodidades_equipamiento_cisterna = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_cisterna']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_cisterna']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_cisterna', $_ofiliaria_adicional_comodidades_equipamiento_cisterna);

		$_ofiliaria_adicional_comodidades_equipamiento_cowork = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_cowork']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_cowork']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_cowork', $_ofiliaria_adicional_comodidades_equipamiento_cowork);

		$_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas', $_ofiliaria_adicional_comodidades_equipamiento_rampa_para_silla_de_ruedas);

		$_ofiliaria_adicional_comodidades_equipamiento_recepcion = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_recepcion']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_recepcion']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_recepcion', $_ofiliaria_adicional_comodidades_equipamiento_recepcion);

		$_ofiliaria_adicional_comodidades_equipamiento_bebederos = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_bebederos']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_bebederos']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_bebederos', $_ofiliaria_adicional_comodidades_equipamiento_bebederos);

		$_ofiliaria_adicional_comodidades_equipamiento_casco = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_casco']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_casco']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_casco', $_ofiliaria_adicional_comodidades_equipamiento_casco);

		$_ofiliaria_adicional_comodidades_equipamiento_corral = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_corral']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_corral']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_corral', $_ofiliaria_adicional_comodidades_equipamiento_corral);

		$_ofiliaria_adicional_comodidades_equipamiento_galpon = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_galpon']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_galpon']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_galpon', $_ofiliaria_adicional_comodidades_equipamiento_galpon);

		$_ofiliaria_adicional_comodidades_equipamiento_molinos = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_molinos']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_molinos']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_molinos', $_ofiliaria_adicional_comodidades_equipamiento_molinos);

		$_ofiliaria_adicional_comodidades_equipamiento_silos = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_silos']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_silos']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_silos', $_ofiliaria_adicional_comodidades_equipamiento_silos);

		$_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua', $_ofiliaria_adicional_comodidades_equipamiento_tanque_de_agua);

		$_ofiliaria_adicional_comodidades_equipamiento_lavarropa = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_lavarropa']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_lavarropa']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_lavarropa', $_ofiliaria_adicional_comodidades_equipamiento_lavarropa);

		$_ofiliaria_adicional_comodidades_equipamiento_microondas = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_microondas']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_microondas']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_microondas', $_ofiliaria_adicional_comodidades_equipamiento_microondas);

		$_ofiliaria_adicional_comodidades_equipamiento_tv = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_tv']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_tv']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_tv', $_ofiliaria_adicional_comodidades_equipamiento_tv);

		$_ofiliaria_adicional_comodidades_equipamiento_vajilla = isset($_POST['_ofiliaria_adicional_comodidades_equipamiento_vajilla']) ? sanitize_text_field($_POST['_ofiliaria_adicional_comodidades_equipamiento_vajilla']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_comodidades_equipamiento_vajilla', $_ofiliaria_adicional_comodidades_equipamiento_vajilla);

		$_ofiliaria_adicional_seguridad_alarma = isset($_POST['_ofiliaria_adicional_seguridad_alarma']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_alarma']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_alarma', $_ofiliaria_adicional_seguridad_alarma);

		$_ofiliaria_adicional_seguridad_porton_automatico = isset($_POST['_ofiliaria_adicional_seguridad_porton_automatico']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_porton_automatico']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_porton_automatico', $_ofiliaria_adicional_seguridad_porton_automatico);

		$_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad = isset($_POST['_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad', $_ofiliaria_adicional_seguridad_circuito_de_camaras_de_seguridad);

		$_ofiliaria_adicional_seguridad_tipo_de_seguridad = isset($_POST['_ofiliaria_adicional_seguridad_tipo_de_seguridad']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_tipo_de_seguridad']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_tipo_de_seguridad', $_ofiliaria_adicional_seguridad_tipo_de_seguridad);

		$_ofiliaria_adicional_seguridad_acceso_controlado = isset($_POST['_ofiliaria_adicional_seguridad_acceso_controlado']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_acceso_controlado']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_acceso_controlado', $_ofiliaria_adicional_seguridad_acceso_controlado);

		$_ofiliaria_adicional_seguridad_con_barrio_cerrado = isset($_POST['_ofiliaria_adicional_seguridad_con_barrio_cerrado']) ? sanitize_text_field($_POST['_ofiliaria_adicional_seguridad_con_barrio_cerrado']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_seguridad_con_barrio_cerrado', $_ofiliaria_adicional_seguridad_con_barrio_cerrado);

		$_ofiliaria_adicional_ambientes_altillo = isset($_POST['_ofiliaria_adicional_ambientes_altillo']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_altillo']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_altillo', $_ofiliaria_adicional_ambientes_altillo);

		$_ofiliaria_adicional_ambientes_balcon = isset($_POST['_ofiliaria_adicional_ambientes_balcon']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_balcon']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_balcon', $_ofiliaria_adicional_ambientes_balcon);

		$_ofiliaria_adicional_ambientes_cocina = isset($_POST['_ofiliaria_adicional_ambientes_cocina']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_cocina']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_cocina', $_ofiliaria_adicional_ambientes_cocina);

		$_ofiliaria_adicional_ambientes_comedor = isset($_POST['_ofiliaria_adicional_ambientes_comedor']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_comedor']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_comedor', $_ofiliaria_adicional_ambientes_comedor);

		$_ofiliaria_adicional_ambientes_dormitorio_en_suite = isset($_POST['_ofiliaria_adicional_ambientes_dormitorio_en_suite']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_dormitorio_en_suite']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_dormitorio_en_suite', $_ofiliaria_adicional_ambientes_dormitorio_en_suite);

		$_ofiliaria_adicional_ambientes_estudio = isset($_POST['_ofiliaria_adicional_ambientes_estudio']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_estudio']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_estudio', $_ofiliaria_adicional_ambientes_estudio);

		$_ofiliaria_adicional_ambientes_living = isset($_POST['_ofiliaria_adicional_ambientes_living']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_living']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_living', $_ofiliaria_adicional_ambientes_living);

		$_ofiliaria_adicional_ambientes_patio = isset($_POST['_ofiliaria_adicional_ambientes_patio']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_patio']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_patio', $_ofiliaria_adicional_ambientes_patio);

		$_ofiliaria_adicional_ambientes_placards = isset($_POST['_ofiliaria_adicional_ambientes_placards']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_placards']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_placards', $_ofiliaria_adicional_ambientes_placards);

		$_ofiliaria_adicional_ambientes_cuarto_de_juegos = isset($_POST['_ofiliaria_adicional_ambientes_cuarto_de_juegos']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_cuarto_de_juegos']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_cuarto_de_juegos', $_ofiliaria_adicional_ambientes_cuarto_de_juegos);

		$_ofiliaria_adicional_ambientes_con_lavadero = isset($_POST['_ofiliaria_adicional_ambientes_con_lavadero']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_con_lavadero']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_con_lavadero', $_ofiliaria_adicional_ambientes_con_lavadero);

		$_ofiliaria_adicional_ambientes_vestidor = isset($_POST['_ofiliaria_adicional_ambientes_vestidor']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_vestidor']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_vestidor', $_ofiliaria_adicional_ambientes_vestidor);

		$_ofiliaria_adicional_ambientes_desayunador = isset($_POST['_ofiliaria_adicional_ambientes_desayunador']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_desayunador']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_desayunador', $_ofiliaria_adicional_ambientes_desayunador);

		$_ofiliaria_adicional_ambientes_jardin = isset($_POST['_ofiliaria_adicional_ambientes_jardin']) ? sanitize_text_field($_POST['_ofiliaria_adicional_ambientes_jardin']) : 'No disponible';    
		update_post_meta($id_post_publicacion, '_ofiliaria_adicional_ambientes_jardin', $_ofiliaria_adicional_ambientes_jardin);

		return;
	}
	public function cambiar_agente()
	{
		// Inicio parámetros
		$id_usuario = null; // Por seguridad de ejecutarse accidentalmente se colocó null
		// Fin parámetros

		global $wpdb;
		$codigo_retorno = 0;
		$mensaje = '';
		$contador_registros = 0;
		$contador_publicaciones_actualizadas = 0;

		$id_post_agencia_agente = get_user_meta($id_usuario, 'user_agent_id', true);
		
		if ($id_post_agencia_agente == "")
		{
			$codigo_retorno = 1;
			$mensaje = 'El usuario no está registrado como agencia o agente';
		}
		else
		{
			$nombre_tabla = $wpdb->prefix.'posts';		
			$busqueda_contador_registros = "SELECT COUNT(*) FROM {$nombre_tabla} WHERE post_author = {$id_usuario}";
			$contador_registros = $wpdb->get_var($busqueda_contador_registros);

			if (empty($contador_registros) == false && $contador_registros > 0)
			{
				$busqueda = "SELECT * FROM {$nombre_tabla} WHERE post_author = {$id_usuario}";
				$publicaciones_agente = $wpdb->get_results($busqueda);
				foreach ($publicaciones_agente as $publicacion)
				{
					$agente_publicacion = get_post_meta($publicacion->ID, 'property_agent', true );
					if ($agente_publicacion == '' || $agente_publicacion != $id_post_agencia_agente)
					{
						update_post_meta($publicacion->ID, 'property_agent', $id_post_agencia_agente );
						$contador_publicaciones_actualizadas++;
					}
				}
				$codigo_retorno = 0;
				$mensaje = 'Se actualizaron las publicaciones exitosamente';
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'No se encontraron publicaciones del usuario';				
			}
		}
		$resultado = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'cantidad_registros' => $contador_registros,
				'contador_publicaciones_actualizadas' => $contador_publicaciones_actualizadas
			];	
		exit(json_encode($resultado));	
	}	
	public function eliminar_publicacion_meli($id_post_publicacion, $usuario)
	{
		$id_publicacion_meli = get_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', true);
		if ($id_publicacion_meli != '')
		{
			$respuesta_obtener_token_meli = $this->obtener_token_meli($usuario->ID);
			if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
			{
				$token_meli = $respuesta_obtener_token_meli['token_meli'];
				$autorizacion = "Authorization: Bearer ".$token_meli;
					$datos = 
						[
							'status' => 'closed'
						];

					$curl = curl_init();
					$url = 'https://api.mercadolibre.com/items/'.$id_publicacion_meli;
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
					curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , 'Access-Control-Allow-Origin : *', $autorizacion ));
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datos));
					$respuesta = curl_exec($curl);
					curl_close($curl);
					$respuesta_objeto = json_decode($respuesta);
					if (isset($respuesta_objeto->id))
					{
						update_user_meta($usuario->ID, '_ofiliaria_publicacion_meli_cerrada', $respuesta );
					}
					else
					{
						update_post_meta($id_post_publicacion, '_ofiliaria_id_publicacion_meli_no_cerrada', $id_post_publicacion);
					}

			}
		}
	}

	public function buscar_usuarios_infocasas()
	{
		global $wpdb;
		$nombre_tabla = $wpdb->prefix.'usermeta';
		$codigo_retorno = 0;
		$mensaje = 'Búsqueda de usuarios Infocasas exitosa';
		$usuarios_infocasas = '';

		$busqueda_contador_registros = "SELECT COUNT(*) FROM {$nombre_tabla} WHERE meta_key = 'user_agent_id' AND meta_value IS NOT NULL AND meta_value != ''";
		$contador_registros = $wpdb->get_var($busqueda_contador_registros);

		if (empty($contador_registros) == false && $contador_registros > 0)
		{
			$busqueda = "SELECT * FROM {$nombre_tabla} WHERE meta_key = 'user_agent_id' AND meta_value IS NOT NULL AND meta_value != ''";
			$usuarios_infocasas = $wpdb->get_results($busqueda);
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'No se encontraron usuarios para Infocasas';
		}
		
		$resultado = 
		[
			'codigo_retorno' => 0,
			'mensaje' => $mensaje,
			'usuarios_infocasas' => $usuarios_infocasas
		];
		exit(json_encode($resultado));	
	}	
	
	public function crear_xml_infocasas()
	{
		set_time_limit(300); // Aumentar el tiempo de ejecución a 5 minutos (300 segundos). Este proceso puede durar por eso se aumenta el tiempo de ejecución para que el programa no se cancele por tiempo
		global $wpdb;
		global $wp_filesystem;
		WP_Filesystem();
		
		$id_usuario_infocasas = $_POST['id_usuario_infocasas'];
		$lista_agentes = strval($id_usuario_infocasas);
		$codigo_retorno = 0;
		$mensaje = 'Archivo xml generado exitosamente para el usuario con id: '.$id_usuario_infocasas;
		$resultado = [];
		$tabla_posts = $wpdb->prefix.'posts';
		$publicaciones = '';
		$vector_publicaciones = [];
		$id_post = 0;
		$taxonomia = '';
		$categoria_publicacion = '';
		$tipo_operacion_publicacion = '';
		$estado = '';
		$codigo_departamento = 0;
		$ciudad = '';
		$area = '';
		$codigo_zona = 0;
		$descripcion_publicacion = '';
		$titulo_publicacion = '';
		$precio_publicacion = 0;
		$moneda_publicacion = '';
		$imagenes_enviar = [];
		$imagenes_asociadas = '';
		$departamento_infocasas = '';
		$zona_infocasas = '';

		// --- NUEVO: Definir la estructura base de la respuesta ---
		// Se inicializan las variables para que siempre existan en la respuesta.
		$base_response_data = [
			'publicaciones' => $publicaciones,
			'vector_publicaciones' => $vector_publicaciones,
			'user_id' => intval($id_usuario_infocasas),
			'directorio_post_xml' => get_user_meta($id_usuario_infocasas, '_ofiliaria_directorio_xml', true)
		];
		$indicador_crear_xml = 1;

		$campos_infocasas_wp = [];
		foreach ($this->vectorCamposWpMeli as $indice_campo_wm => $campo_wm)
		{
			if (isset($campo_wm['etiquetasXmlInfocasas']))
			{
				if (is_array($campo_wm['etiquetasXmlInfocasas'])) 
				{
					foreach ($campo_wm['etiquetasXmlInfocasas'] as $indiceEtiqueta => $etiqueta)
					{
						$campos_infocasas_wp[$etiqueta] = $campo_wm['wp'];
					}
				}
				else
				{
					$campos_infocasas_wp[$campo_wm['etiquetasXmlInfocasas']] = $campo_wm['wp'];
				}

			}
		}
		$array_string = print_r($campos_infocasas_wp, true);
		error_log("campos_infocasas_wp:\n". $array_string);

		$id_infocasas_agencia_agente = get_user_meta($id_usuario_infocasas, '_ofiliaria_id_infocasas_agencia_agente', true);
		if ($id_infocasas_agencia_agente != '')
		{
			$id_post_agencia_agente = get_user_meta($id_usuario_infocasas, 'user_agent_id', true);
			if ($id_post_agencia_agente != '')
			{
				$post_agencia_agente = get_post($id_post_agencia_agente);
				if ($post_agencia_agente->post_author > 0)
				{
					$mensaje = 'El usuario es un agente de una agencia';
					wp_send_json_error(array_merge($base_response_data, ['message' => $mensaje]));
					$indicador_crear_xml = 0;
				}
				else
				{
					$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario_infocasas);
					if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
					{
						$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
					}	
				}
			}
			else
			{
				$mensaje = 'El usuario no tiene un id de agencia o agente asignado';
				wp_send_json_error(array_merge($base_response_data, ['message' => $mensaje]));
				$indicador_crear_xml = 0;
			}
		}
		else
		{
			$mensaje = 'El usuario no tiene un id de Infocasas';
			wp_send_json_error(array_merge($base_response_data, ['message' => $mensaje]));
			$indicador_crear_xml = 0;
		}

		if ($indicador_crear_xml == 1)
		{
			$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_status = 'publish' AND post_type = 'estate_property'";
			$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);

			if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
			{	
				$documento = new DOMDocument('1.0', 'utf-8');
				$documento->formatOutput = true;
				$xml = $documento->createElement('xml');
				$xml = $documento->appendChild($xml);

				$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_status = 'publish' AND post_type = 'estate_property'";
				$publicaciones = $wpdb->get_results($busqueda_publicaciones);
				foreach ($publicaciones as $indice_publicacion => $publicacion)
				{
					$indicador_publicar_infocasas = get_post_meta($publicacion->ID, '_ofiliaria_publicar_en_infocasas', true);
					// Si aplica publicar en Infocasas
					if ($indicador_publicar_infocasas === 'Sí') 
					{ 
						$id_post = $publicacion->ID;
						$categoria_publicacion = 'Otros Inmuebles';
						$tipo_operacion_publicacion = '';
						$estado = '';
						$codigo_departamento = 0;
						$ciudad = '';
						$area = '';
						$codigo_zona = 0;
						$descripcion_publicacion = '';
						$titulo_publicacion = '';
						$precio_publicacion = 0;
						$moneda_publicacion = '';
						$imagenes_enviar = [];
						$imagenes_asociadas = '';
						$departamento_infocasas = '';
						$zona_infocasas = '';
							
						$propiedad = $documento->createElement('propiedad');
						$propiedad = $xml->appendChild($propiedad);
				
						$id = $documento->createElement('id');
						$id = $propiedad->appendChild($id);
						$idPropiedad = $documento->createTextNode($id_post);
						$idPropiedad = $id->appendChild($idPropiedad);
				
						$taxonomia = 'property_category';
						$termino = wp_get_object_terms( $id_post, $taxonomia );
						if (!isset($termino->errors))
						{
							$categoria_publicacion = $termino[0]->name;
						}

						$vector_publicaciones[$id_post]['property_category'] = $categoria_publicacion;

						$categoria_inmueble_infocasas = $this->tablas_infocasas['categorias_meli_infocasas'][$categoria_publicacion];

						$tipo_propiedad = $documento->createElement('tipoPropiedad');
						$tipo_propiedad = $propiedad->appendChild($tipo_propiedad);
						$texto_tipo_propiedad = $documento->createTextNode($this->tablas_infocasas['infocasas_tipo_propiedad'][$categoria_inmueble_infocasas]);
						// $texto_tipo_propiedad = $tipo_propiedad->appendChild($texto_tipo_propiedad);
						$tipo_propiedad->appendChild($texto_tipo_propiedad);

						$taxonomia = 'property_action_category';
						$termino = wp_get_object_terms( $id_post, $taxonomia );
						if (!isset($termino->errors))
						{
							$tipo_operacion_publicacion = $termino[0]->name;
						}

						$vector_publicaciones[$id_post]['property_action_category'] = $tipo_operacion_publicacion;

						$tipo_operacion_infocasas = $this->tablas_infocasas['operacion_meli_infocasas'][$tipo_operacion_publicacion];

						$tipo_operacion = $documento->createElement('tipoOperacion');
						$tipo_operacion = $propiedad->appendChild($tipo_operacion);
						$texto_tipo_operacion = $documento->createTextNode($this->tablas_infocasas['infocasas_tipo_operacion'][$tipo_operacion_infocasas]);
						// $texto_tipo_operacion = $tipo_operacion->appendChild($texto_tipo_operacion);
						$tipo_operacion->appendChild($texto_tipo_operacion);
										
						$taxonomia = 'property_county_state';
						$termino = wp_get_object_terms( $id_post, $taxonomia );
						if (!isset($termino->errors))
						{
							$estado = $this->normalizar_cadena($termino[0]->name);
						}
						
						$vector_publicaciones[$id_post]['property_county_state'] = $estado;

						$departamentos_zonas = $this->buscar_departamentos_zonas();
						// Me gustaría imprimir en el log del wordpress el vector $departamentos_zonas
						$array_string = print_r($departamentos_zonas, true);
						error_log("departamentos_zonas:\n". $array_string);

						$codigo_departamento = 0;
						$codigo_zona = 0;
						foreach ($departamentos_zonas as $indice => $departamento_zona)
						{
							$departamento_infocasas = $this->normalizar_cadena($departamento_zona->departamento);
							if ($estado == $departamento_infocasas)
							{
								$codigo_departamento = $departamento_zona->id_departamento_infocasas;
							}
						}

						$departamento = $documento->createElement('departamento');
						$departamento = $propiedad->appendChild($departamento);
						if ($codigo_departamento != 0)
						{
							$texto_departamento = $documento->createTextNode($codigo_departamento);
							$departamento->appendChild($texto_departamento);
						}

						$taxonomia = 'property_city';
						$termino = wp_get_object_terms( $id_post, $taxonomia );
						if (!isset($termino->errors))
						{
							$ciudad = $this->normalizar_cadena($termino[0]->name);
						}

						$vector_publicaciones[$id_post]['property_city'] = $ciudad;

						$taxonomia = 'property_area';
						$termino = wp_get_object_terms( $id_post, $taxonomia );
						if (!isset($termino->errors))
						{
							$area = $this->normalizar_cadena($termino[0]->name);
						}
						
						$vector_publicaciones[$id_post]['property_area'] = $area;

						foreach ($departamentos_zonas as $indice => $departamento_zona)
						{
							if ($codigo_departamento != 0 && $departamento_zona->id_departamento_infocasas != $codigo_departamento)
							{
								continue;
							}
							$zona_infocasas = $this->normalizar_cadena($departamento_zona->zona);
							if ($ciudad == $zona_infocasas) 
							{
								$codigo_zona = $departamento_zona->id_zona_infocasas;
							} 
						}
						
						$zona = $documento->createElement('zona');
						$zona = $propiedad->appendChild($zona);
						if ($codigo_zona != 0)
						{
							$texto_zona = $documento->createTextNode($codigo_zona);
							$zona->appendChild($texto_zona);
						}
						else
						{
							update_option('_ofiliaria_zona_no_infocasas_'.$estado.'_'.$ciudad, 'Departamento: '.$codigo_departamento.', '.$estado.', zona: '.$ciudad);
						}

						// --- Definir los campos que se deben procesar para esta categoría y operación ---
						$campos_a_procesar = [];
						if (isset($this->vector_infocasas_campos[$categoria_inmueble_infocasas])) 
						{
							// Campos generales
							if (isset($this->vector_infocasas_campos[$categoria_inmueble_infocasas]['general'])) 
							{
								$campos_a_procesar = array_merge($campos_a_procesar, $this->vector_infocasas_campos[$categoria_inmueble_infocasas]['general']);
							}
							// Campos específicos de la operación
							if (isset($this->vector_infocasas_campos[$categoria_inmueble_infocasas][$tipo_operacion_infocasas])) 
							{
								$campos_a_procesar = array_merge($campos_a_procesar, $this->vector_infocasas_campos[$categoria_inmueble_infocasas][$tipo_operacion_infocasas]);
							}
						}
						error_log("id_post: ".$id_post);
						error_log("categoria_inmueble_infocasas: ".$categoria_inmueble_infocasas);
						error_log("tipo_operacion_infocasas: ".$tipo_operacion_infocasas);
						$array_string = print_r($campos_a_procesar, true);
						error_log("campos_a_procesar:\n". $array_string);

						foreach ($campos_a_procesar as $nombre_campo_xml => $valor_campo) 
						{
							$valor_infocasas = '';
							$meta_key = isset($campos_infocasas_wp[$nombre_campo_xml]) ? $campos_infocasas_wp[$nombre_campo_xml] : null;
							
							if ($meta_key == null)
							{
								if (isset($this->tablas_infocasas['excepciones_datos_infocasas'][$nombre_campo_xml]))
								{
									$meta_key = $this->tablas_infocasas['excepciones_datos_infocasas'][$nombre_campo_xml];
								}
							}
					
							if ($meta_key) 
							{
								$meta_value = get_post_meta($id_post, $meta_key, true);
					
								switch ($nombre_campo_xml) 
								{
									case 'id':
									case 'tipoPropiedad':
									case 'tipoOperacion':    
									case 'departamento':
									case 'zona':
										break;  
									
									case 'idDormitorios':
										// Mapeo para dormitorios
										switch ($meta_value) {
											case 0: $valor_infocasas = 1; break;
											case 1: $valor_infocasas = 2; break; // 1 dormitorio
											case 2: $valor_infocasas = 3; break; // 2 dormitorios
											case 3: $valor_infocasas = 4; break; // 3 dormitorios
											case 4: $valor_infocasas = 5; break; // 4 dormitorios
											case 5:
											case 6:
											case 7: $valor_infocasas = 6; break; // 5+ dormitorios
										}
										break;
					
									case 'idBanios':
										// Lógica de mapeo original para baños
										switch ($meta_value) {
											case 1: $valor_infocasas = 1; break; // 1 baño
											case 2: $valor_infocasas = 2; break; // 2 baños
											case 3:
											case 4:
											case 5:
											case 6: $valor_infocasas = 3; break; // 3+ baños
										}
										break;
					
									case 'estado':
										// Mapeo para el estado de la propiedad
										switch ($meta_value) {
											case 'A estrenar': $valor_infocasas = 1; break;
											case 'Reciclada': $valor_infocasas = 2; break;
											case 'Excelente estado': $valor_infocasas = 3; break;
											case 'Buen estado': $valor_infocasas = 4; break;
											case 'Requiere mantenimiento': $valor_infocasas = 5; break;
											case 'A reciclar': $valor_infocasas = 6; break;
											case 'A definir': $valor_infocasas = 7; break;
											case 'En construccion': $valor_infocasas = 8; break;
											case 'En pozo': $valor_infocasas = 9; break;
										}
										break;
						
									case 'comodidades':
									case 'seguridad':
										$vector_id_valores = [];
										foreach ($valor_campo as $indice_valor => $valor)
										{
											$llave_post_meta = isset($campos_infocasas_wp[$indice_valor]) ? $campos_infocasas_wp[$indice_valor] : null;
											
											if ($llave_post_meta) 
											{
												$valor_post_meta = get_post_meta($id_post, $llave_post_meta, true);  
												if ($valor_post_meta == 'Sí')
												{
													$vector_id_valores[] = $valor;
												}      
											}
										}
										$valor_infocasas = implode(',', $vector_id_valores);
										break;
					
									case 'plantas':
										// Mapeo para cantidad de plantas
										switch ($meta_value) {
											case 1: $valor_infocasas = 1; break;
											case 2: $valor_infocasas = 2; break;
											case 3:
											case 4:
											case 5: $valor_infocasas = 3; break; // 3+ plantas
										}
										break;
					
									case 'orientacion':
										// Mapeo para la orientación de la propiedad
										switch ($meta_value) {
											case 'Sur': $valor_infocasas = 2; break;
											case 'Norte': $valor_infocasas = 3; break;
											case 'Este': $valor_infocasas = 4; break;
											case 'Oeste': $valor_infocasas = 5; break;
											case 'Sureste': $valor_infocasas = 6; break;
											case 'Suroeste': $valor_infocasas = 7; break;
											case 'Noreste': $valor_infocasas = 8; break;
											case 'noroeste': $valor_infocasas = 9; break; 
										}
										break;
					
									case 'disposicion':
										// Mapeo para la disposición de la propiedad
										switch ($meta_value) {
											case 'Frente': $valor_infocasas = 2; break;
											case 'Contrafrente': $valor_infocasas = 3; break;
											case 'Interno': $valor_infocasas = 4; break;
											case 'Lateral': $valor_infocasas = 5; break;
										}
										break;
							
									// No está en la tabla campos_wp_meli
									case 'sobre':
										// Mapeo para la ubicación 'sobre'
										switch ($meta_value) {
											case 'Sobre rambla': $valor_infocasas = 2; break;
											case 'Sobre avenida': $valor_infocasas = 3; break;
										}
										break;
					
									case 'descripcion':
										$descripcion_publicacion = $publicacion->post_content;
										if ($descripcion_publicacion != '' && $descripcion_publicacion != null )
										{
											$valor_infocasas = $this->convertir_a_html($descripcion_publicacion);
										}
										break;
					
									case 'titulo':
										$valor_infocasas = $publicacion->post_title;
										break;
					
									case 'oficina':
									case 'vivienda':
									case 'financia':
									case 'mostrarDireccion':								
									case 'ocupadaAlquilerDiciembre':
									case 'ocupadaAlquilerPrimeraQuincenaDiciembre':
									case 'ocupadaAlquilerSegundaQuincenaDiciembre':
									case 'ocupadaAlquilerEnero':
									case 'ocupadaAlquilerPrimeraQuincenaEnero':
									case 'ocupadaAlquilerSegundaQuincenaEnero':
									case 'ocupadaAlquilerFebrero':
									case 'ocupadaAlquilerPrimeraQuincenaFebrero':
									case 'ocupadaAlquilerSegundaQuincenaFebrero':
									case 'ocupadaAlquilerReveillon':
									case 'ocupadaAlquilerSemanaSanta':
									case 'ocupadaAlquilerVacacionesJulio':
									case 'vistaMar':
										if ($meta_value != '' && $meta_value != 'No disponible')
										{
											$valor_infocasas = ($meta_value == 'Sí') ? 1 : 0;		
										}								
										break;
					
									case 'distanciaMar':
										// Mapeo para la distancia al mar
										switch ($meta_value) {
											case 'Frente_al_mar': $valor_infocasas = 1; break;
											case 'Menos_de_100m': $valor_infocasas = 2; break;
											case '200m': $valor_infocasas = 3; break;
											case '300m': $valor_infocasas = 4; break;
											case '400m': $valor_infocasas = 5; break;
											case '500m': $valor_infocasas = 6; break;
											case 'Menos_de_1000m': $valor_infocasas = 7; break;
											case 'Mas_de_1000m': $valor_infocasas = 8; break;
										}
										break;
					
									case 'ubicacionAproximada':
										if ($meta_value != '')
										{
											// $valor_infocasas = 'Aproximada' ? 1 : 0;
											$valor_infocasas = 0; // Por los momentos se forza a cero porque no existe el campo en la tabla campos_wp_meli
										}
										break;
					
									case 'ocultarPrecioV':
									case 'ocultarPrecioA':
										$valor_infocasas = 0;
										break;
					
									case 'monedaVenta':
									case 'monedaAlquiler':
									case 'IDmonedagc':
									case 'monedaAlquilerDiciembre':
									case 'monedaAlquilerPrimeraQuincenaDiciembre':
									case 'monedaAlquilerSegundaQuincenaDiciembre':
									case 'monedaAlquilerEnero':
									case 'monedaAlquilerPrimeraQuincenaEnero':
									case 'monedaAlquilerSegundaQuincenaEnero':
									case 'monedaAlquilerFebrero':
									case 'monedaAlquilerPrimeraQuincenaFebrero':
									case 'monedaAlquilerSegundaQuincenaFebrero':
									case 'monedaAlquilerReveillon':
									case 'monedaAlquilerSemanaSanta':
									case 'monedaAlquilerVacacionesJulio':
									case 'monedaAlquilerDiario':
									case 'monedaAlquilerMensual':
										// Mapeo para diferentes tipos de moneda
										switch ($meta_value) {
											case 'USD': $valor_infocasas = 1; break;
											case 'UYU': $valor_infocasas = 2; break;
											case 'GS': $valor_infocasas = 3; break;
										}
										break;
									
									case 'imagenes':
									case 'vendedor':
										$valor_infocasas = $nombre_campo_xml;
										break;

									case 'permuta':
										if ($meta_value != '' && $meta_value != 'No disponible')
										{
											$valor_infocasas = ($meta_value == 'Sí') ? 1 : 2;		
										}								
										break;

									default:
										$valor_infocasas = $meta_value;
										break;
								}
					
								// Si el valor mapeado no es vacío, se agrega el elemento.
								if (!empty($valor_infocasas) || $valor_infocasas === 0 || $valor_infocasas === '0') 
								{
									switch ($nombre_campo_xml) 
									{
										case 'descripcion': 
											$descripcion = $documento->createElement('descripcion');
											$descripcion = $propiedad->appendChild($descripcion);	
											$cdata = $documento->createCDATASection($valor_infocasas);
											$descripcion->appendChild($cdata);                        
											break;
										case 'imagenes': 
											$imagenes_asociadas = get_post_meta($id_post, 'wpestate_property_gallery', true);
											if (!empty($imagenes_asociadas))
											{
												$imagenes_enviar = [];	
												foreach ($imagenes_asociadas as $imagen)
												{
													global $wpdb;
													$nombre_tabla = $wpdb->prefix.'as3cf_items';	
										
													$busqueda = "SELECT * FROM {$nombre_tabla} WHERE source_id = {$imagen}";								
													$imagen_aws = $wpdb->get_row( $busqueda, OBJECT );
											
													$url_imagen_aws = '';
													if (is_object($imagen_aws) && !empty($imagen_aws)) 
													{
														$url_imagen_aws = 'https://'.$imagen_aws->bucket.'/'.$imagen_aws->path; 			  
													}
													else
													{
														$post_adjunto = get_post($imagen);	
														if ( $post_adjunto === null ) 
														{
															update_post_meta($id_post, '_ofiliaria_xml_infocasas_id_imagen_no_encontrada_'.$imagen, $imagen );
														} 
														else 
														{
															$url_imagen_aws = $post_adjunto->guid;
														}
													}
													if ($url_imagen_aws != '')
													{
														$imagenes_enviar[] = $url_imagen_aws; 
													}
												}
											}
											else
											{
												update_post_meta($id_post, '_ofiliaria_xml_infocasas_sin_imagenes_asociadas', 'Sin imágenes asociadas' );
											}
						
											$imagenes = $documento->createElement('imagenes');
											$imagenes = $propiedad->appendChild($imagenes);
											if (!(empty($imagenes_enviar)))
											{
												foreach ($imagenes_enviar as $indice => $imagen)
												{
													$url = $documento->createElement('url');
													$url = $imagenes->appendChild($url);
													$texto_url = $documento->createTextNode($imagen);
													$url->appendChild($texto_url);
												}
											}
											break;
										case 'vendedor':
											$resultado_datos_agente = $this->obtener_datos_agente($publicacion->post_author);
											if ($resultado_datos_agente['codigo_retorno'] == 0)
											{
												$datos_contacto_meli = $resultado_datos_agente['datos_contacto'];
					
												$vendedor = $documento->createElement('vendedor');
												$vendedor = $propiedad->appendChild($vendedor);
					
												$email = $documento->createElement('email');
												$email = $vendedor->appendChild($email);
												$texto_email = $documento->createTextNode($datos_contacto_meli['email_contacto']);
												$email->appendChild($texto_email);
					
												$nombre = $documento->createElement('nombre');
												$nombre = $vendedor->appendChild($nombre);
												$texto_nombre = $documento->createTextNode($datos_contacto_meli['nombre_contacto']);
												$nombre->appendChild($texto_nombre);
					
												$telefono = $documento->createElement('telefono');
												$telefono = $vendedor->appendChild($telefono);
												$texto_telefono = $documento->createTextNode($datos_contacto_meli['telefono_whatsapp_meli']);
												$telefono->appendChild($texto_telefono);
											}                
											break;
										default:
											$elemento = $documento->createElement($nombre_campo_xml, $valor_infocasas);
											$propiedad->appendChild($elemento);
											break;
									}
								}
							}
						}
						update_post_meta($id_post, '_ofiliaria_publicar_en_infocasas_enviado', 'Sí');
					}	
				}

				$directorio_post_xml = get_user_meta($_POST['id_usuario_infocasas'], '_ofiliaria_directorio_xml', true);

				if ($directorio_post_xml !== 'Sí')
				{
					$directorio_xml = $wp_filesystem->wp_content_dir().'uploads/infocasas/ofiliaria_'.$id_usuario_infocasas.'/';
					$wp_filesystem->mkdir($directorio_xml);
					update_user_meta($id_usuario_infocasas, '_ofiliaria_directorio_xml', 'Sí');
				}
				
				// Crear un nombre de archivo dinámico con fecha/hora en formato AAAAMMDDHHMM
				// Ejemplo: ofiliaria_26_202511141744.xml (YYYYMMDDHHMM)
				$fecha_hora_suffix = date('YmdHi'); // asumimos YYYYMMDDHHMM
				$nombre_archivo_xml = 'ofiliaria_'.$id_usuario_infocasas.'_'.$fecha_hora_suffix.'.xml';
				$ruta_xml_usuario = $wp_filesystem->wp_content_dir().'uploads/infocasas/ofiliaria_'.$id_usuario_infocasas.'/'.$nombre_archivo_xml;

				$documento->save($ruta_xml_usuario);

				// --- INICIO: Código para llamar a la API de Laravel ---
				if (file_exists($ruta_xml_usuario)) {
					// El archivo XML se creó correctamente. Ahora, lo enviamos a Laravel/S3.

					// 1. Obtener el token de administrador de Laravel (usuario con ID 1).
					$admin_user = get_user_by('ID', 1);
					if (!$admin_user) {
						error_log('Ofiliaria Infocasas: No se pudo encontrar al usuario administrador (ID 1) de WordPress.');
						// Intentar borrar el archivo local antes de devolver error
						if (file_exists($ruta_xml_usuario)) {
							if (isset($wp_filesystem) && method_exists($wp_filesystem, 'delete')) {
								$wp_filesystem->delete($ruta_xml_usuario);
							} else {
								@unlink($ruta_xml_usuario);
							}
						}
						wp_send_json_error(array_merge($base_response_data, ['message' => 'Error de configuración interna del servidor.']));
						return;
					}

					// La función obtener_token_laravel se encarga de loguear o refrescar el token si es necesario.
					$token = $this->obtener_token_laravel($admin_user);

					if (empty($token)) {
						error_log('Ofiliaria Infocasas: No se pudo obtener el token de Laravel para el usuario admin (ID 1).');
						// Borrar el archivo local antes de devolver error
						if (file_exists($ruta_xml_usuario)) {
							if (isset($wp_filesystem) && method_exists($wp_filesystem, 'delete')) {
								$wp_filesystem->delete($ruta_xml_usuario);
							} else {
								@unlink($ruta_xml_usuario);
							}
						}
						wp_send_json_error(array_merge($base_response_data, ['message' => 'Error interno del servidor al autenticar.']));
						return;
					}

					// 2. Determinar la URL de la API de Laravel y el ambiente
					$url_base_wordpress = $this->urlBase();
					if ($url_base_wordpress == 'https://ofiliaria.com.uy') {
						$laravel_api_url = "https://backend.ofiliaria.com.uy/public/api/v1/infocasas/guardar-xml";
						$ambiente = 'Produccion';
					} else {
						$laravel_api_url = "https://dev-backend.ofiliaria.com/public/api/v1/infocasas/guardar-xml";
						$ambiente = 'Desarrollo';
					}
					error_log('laravel_api_url '.$laravel_api_url);

					// 3. Construir la URL del archivo XML
					$upload_dir = wp_upload_dir();
					$url_xml = $upload_dir['baseurl'] . '/infocasas/ofiliaria_' . $id_usuario_infocasas . '/' . $nombre_archivo_xml;
					error_log('url_xml '.$url_xml);

					// 4. Llamar a la API de Laravel para guardar el archivo.
					$api_response = wp_remote_post($laravel_api_url, [
						'method'    => 'POST',
						'headers'   => [
							'Authorization' => 'Bearer ' . $token,
							'Accept'        => 'application/json',
						],
						'body'      => [
							'id_usuario_wordpress' => $id_usuario_infocasas,
							'url_xml'              => $url_xml,
							'ambiente'             => $ambiente,
						],
						'timeout'   => 45,
						'sslverify' => false // Para desarrollo. Considerar cambiar a true en producción.
					]);

					// Independientemente del resultado de la llamada a la API, intentamos borrar el archivo local.
					$borrado_ok = false;
					if (file_exists($ruta_xml_usuario)) {
						if (isset($wp_filesystem) && method_exists($wp_filesystem, 'delete')) {
							$borrado_ok = $wp_filesystem->delete($ruta_xml_usuario);
						} else {
							$borrado_ok = @unlink($ruta_xml_usuario);
						}
						if (! $borrado_ok) {
							error_log('Ofiliaria Infocasas: No se pudo borrar el archivo local ' . $ruta_xml_usuario);
						}
					}

					if (is_wp_error($api_response)) {
						error_log('Ofiliaria Infocasas: WP_Error al llamar a la API de Laravel: ' . $api_response->get_error_message());
						wp_send_json_error(array_merge($base_response_data, ['message' => 'Error de comunicación con el servidor de archivos.']));
					} else {
						$status_code = wp_remote_retrieve_response_code($api_response);
						$body = json_decode(wp_remote_retrieve_body($api_response), true);

						if ($status_code === 200 && isset($body['codigoRetorno']) && $body['codigoRetorno'] === 0) {
							// --- MODIFICADO: Se actualiza la estructura base con los datos finales ---
							$base_response_data['publicaciones'] = $publicaciones;
							$base_response_data['vector_publicaciones'] = $vector_publicaciones;
							wp_send_json_success(array_merge($base_response_data, ['message' => $body['mensaje']]));
						} else {
							$error_message = isset($body['mensaje']) ? $body['mensaje'] : 'Error desconocido al transferir el archivo a AWS.';
							error_log('Ofiliaria Infocasas: Error desde la API de Laravel (HTTP ' . $status_code . '): ' . $error_message);
							wp_send_json_error(array_merge($base_response_data, ['message' => $error_message]));
						}
					}
				} else {
					wp_send_json_error(array_merge($base_response_data, ['message' => 'No se pudo crear el archivo XML localmente.']));
				}
				// --- FIN: Código para llamar a la API de Laravel ---
			}
			else
			{
				$mensaje = 'No se encontraron publicaciones para el usuario con el id: '.$_POST['id_usuario_infocasas'];
				wp_send_json_error(array_merge($base_response_data, ['message' => $mensaje]));
			}
		}

	}
	public function buscar_departamentos_zonas()
	{
		$urlBase = $this->urlBase();
		if ($urlBase == 'https://ofiliaria.com.uy')
		{
			$url = "https://backend.ofiliaria.com.uy/public/api/v1/departamentos";
		}
		else
		{
			$url = "https://dev-backend.ofiliaria.com/public/api/v1/departamentos";
		}

		$headers = 
			[
				//
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$respuesta = curl_exec($curl);
		curl_close($curl);
		$vector_respuesta = json_decode($respuesta);
		return $vector_respuesta->departamentos_zonas;
	}
	public function validacion_publicacion_infocasas($usuario, $identificador, $validacion_meli, $codigo_retorno, $errores)
	{
		$resultado_validacion_infocasas = [];
		$id_post_agencia_agente = get_user_meta($usuario->ID, 'user_agent_id', true);
		$vector_campos = [];
		$vector_campos['prop_category_submit'] = $_POST['prop_category_submit'];
		$vector_campos['prop_action_category_submit'] = $_POST['prop_action_category_submit'];
		$vector_campos['property_county'] = $_POST['property_county'];
		$vector_campos['property_city_submit'] = $_POST['property_city_submit'];
		$vector_campos['wpestate_description'] = $_POST['wpestate_description'];
		$vector_campos['wpestate_title'] = $_POST['wpestate_title'];
		$vector_campos['divisa'] = $_POST['divisa'];
		$vector_campos['property_price'] = $_POST['property_price'];
		$vector_campos['property_latitude'] = $_POST['property_latitude'];
		$vector_campos['property_longitude'] = $_POST['property_longitude'];
		update_post_meta($usuario->ID, '_ofiliaria_campos_obligatorios_infocasas_'.$identificador, $vector_campos);

		if ($validacion_meli == 'No')
		{
			if ( $id_post_agencia_agente == "")
			{
				$codigo_retorno = 1;
				$errores[] = 'El usuario no está registrado como agencia o agente';
			}
			else
			{
				$post_agencia_agente = get_post($id_post_agencia_agente);
		
				if ($post_agencia_agente->post_type == 'estate_agency')
				{
					$telefono_movil = get_post_meta($id_post_agencia_agente, 'agency_mobile', true);
				}
				else
				{
					$telefono_movil = get_post_meta($id_post_agencia_agente, 'agent_mobile', true);
				}
				if ( $telefono_movil == "")
				{
					$codigo_retorno = 1;
					$errores[] = 'La agencia o agente no tiene teléfono móvil registrado';
				}
				$email = get_post_meta($id_post_agencia_agente, 'agent_email', true);
				if ($email == '')
				{
					$codigo_retorno = 1;
					$errores[] = 'La agencia o agente no tiene email registrado';
				}
			}

			if (isset($_POST['divisa']))
			{
				if ($_POST['divisa'] != 'No disponible')
				{
					$divisa = $_POST['divisa'];			
				}
				else
				{
					$codigo_retorno = 1;
					$errores[] = 'Por favor seleccione el tipo de moneda';				
				}
			}
			else
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione el tipo de moneda';	
			}	

			if (isset($_POST['property_price']))
			{
				if ($_POST['property_price'] == '' || $_POST['property_price'] == 0)
				{
					$codigo_retorno = 1;
					$errores[] = 'Por favor ingrese el precio';				
				}
			}
			else
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor ingrese el precio';	
			}	
		}

		if (isset($_POST['property_city_submit']))
		{
			if (empty(trim($_POST['property_city_submit'])) || $_POST['property_city_submit'] == 'none')
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor seleccione una ciudad';
			}
			else
			{
				// --- MODIFICADO: Validar si la ciudad existe en Infocasas ---
				// Se obtienen los nombres directamente del POST, ya que no son IDs.
				$state_name = isset($_POST['property_county']) ? sanitize_text_field($_POST['property_county']) : '';
				$city_name = sanitize_text_field($_POST['property_city_submit']);

				if ( !empty($state_name) && !$this->is_city_valid_for_infocasas($city_name, $state_name) ) {
					$codigo_retorno = 1;
					$errores[] = 'La ciudad seleccionada no está en la lista de Infocasas, por favor seleccione otra ciudad que contenga la etiqueta (Infocasas)';
				}
			}
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor seleccione una ciudad';
		}

		if (isset($_POST['property_latitude']))
		{
			if ($_POST['property_latitude'] == '')
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor ingrese la latitud de la ubicación';
			}	
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor ingrese la latitud de la ubicación';
		}

		if (isset($_POST['property_longitude']))
		{
			if ($_POST['property_longitude'] == '')
			{
				$codigo_retorno = 1;
				$errores[] = 'Por favor ingrese la longitud de la ubicación';	
			}
		}
		else
		{
			$codigo_retorno = 1;
			$errores[] = 'Por favor ingrese la longitud de la ubicación';	
		}

		$respuesta_infocasas = 
			[
				'codigo_retorno' => $codigo_retorno,
				'errores' => $errores
			];

		return $respuesta_infocasas;
	}
	public function publicacion_infocasas($usuario, $identificador, $id_post_publicacion)
	{
		if (isset($_POST['ofiliaria_publicar_infocasas']))
        {
			update_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_infocasas', 'Sí');
		}
		else
		{
			delete_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_infocasas');
			delete_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_infocasas_enviado');
		}
	}
	public function normalizar_cadena($cadena) 
	{
		// Convierte a minúsculas
		$cadena = mb_strtolower($cadena, 'UTF-8');
	
		// Remover acentos 
		$cadena = str_replace(
			array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü'),
			array('a', 'e', 'i', 'o', 'u', 'n', 'u', 'a', 'e', 'i', 'o', 'u', 'n', 'u'),
			$cadena
		);
	
		return $cadena;
	}
	public function reparar_tabla_imagenes()
	{
		// Inicio parámetros
		$id_autor = null; // Se colocó null para evitar se ejecute por accidente
		// Fin parámetros

		global $wpdb;
		$contador_registros_creados = 0;
		$contador_publicaciones_ya_asociadas = 0;
		$tabla_imagenes = $wpdb->prefix.'imagenes_publicaciones';
		$busqueda_contador_imagenes = "SELECT COUNT(*) FROM {$tabla_imagenes}";
		$contador_imagenes = $wpdb->get_var($busqueda_contador_imagenes);
		if (empty($contador_imagenes))
		{
			$tabla_posts = $wpdb->prefix.'posts';		
			$busqueda_contador_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author = {$id_autor} AND post_type = 'estate_property'";
			$contador_publicaciones = $wpdb->get_var($busqueda_contador_publicaciones);
	
			if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
			{		
				$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author = {$id_autor} AND post_type = 'estate_property'";
				$publicaciones_agente = $wpdb->get_results($busqueda_publicaciones);
				foreach ($publicaciones_agente as $publicacion)
				{
					$archivos_asociados = get_post_meta($publicacion->ID, '_ofiliaria_archivos_asociados_publicacion', true);
					if ($archivos_asociados !== 'Sí')
					{
						$busqueda_contador_adjuntos = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author = 2 AND post_parent = {$publicacion->ID} AND post_type = 'attachment'";
						$contador_adjuntos = $wpdb->get_var($busqueda_contador_adjuntos);
				
						if (empty($contador_adjuntos) == false && $contador_adjuntos > 0)
						{
							$busqueda_adjuntos = "SELECT * FROM {$tabla_posts} WHERE post_author = 2 AND post_parent = {$publicacion->ID} AND post_type = 'attachment'";
							$adjuntos = $wpdb->get_results($busqueda_adjuntos);
							foreach ($adjuntos as $adjunto)
							{									 
								$data = [];
								$format = array(
									'%d',
									'%s',
									'%s',
									'%d'
								);
								$data['id_post_crm'] = $publicacion->ID;
								$data['url_imagen'] = '';
								$data['tipo_imagen'] = 'General';
								$data['id_post_imagen'] = $adjunto->ID;
								$wpdb->insert($tabla_imagenes, $data, $format);
								$id_nuevo_registro = $wpdb->insert_id;	
								$contador_registros_creados++;
							}
						}
					}
					else
					{
						$contador_publicaciones_ya_asociadas++;
					}
				}
				$vector_respuesta = 
					[
						'codigo_retorno' => 0,
						'mensaje' => 'Tabla de imágenes reparada correctamente',
						'contador_publicaciones_propiedades' => $contador_publicaciones,
						'contador_publicaciones_ya_asociadas' => $contador_publicaciones_ya_asociadas,
						'total_registros_creados' => $contador_registros_creados
					];
				update_user_meta($id_autor, '_ofiliaria_reparar_tabla_imagenes', $vector_respuesta);
				exit(json_encode($vector_respuesta, JSON_FORCE_OBJECT));	
			}
			else
			{
				exit(json_encode(array(
					'codigo_retorno' => 2,
					'mensaje' => 'No se encontraron post de propiedades',
				), JSON_FORCE_OBJECT));	
			}		
		}
		else
		{
			exit(json_encode(array(
				'codigo_retorno' => 1,
				'mensaje' => 'La tabla ofil_imagenes_publicaciones no está vacía',
			), JSON_FORCE_OBJECT));				
		}		
	}

	public function buscar_publicaciones_ofiliaria()
	{
		// Inicio parámetros
		$id_usuario = null; // Se colocó null por seguridad si se ejecuta por accidente
		// Fin parámetros

		global $wpdb;
		$lista_agentes = strval($id_usuario);
		$tabla_imagenes = $wpdb->prefix.'imagenes_publicaciones';
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$publicaciones_ofiliaria_meli = [];
		$id_meli = '';
		$token_meli = '';

		$respuesta_obtener_token_meli = $this->obtener_token_meli($id_autor);

		if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_obtener_token_meli['token_meli'];
		}
		elseif ($respuesta_obtener_token_meli['codigo_retorno'] == 1)
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo refrescar el token';
		}
		else
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo obtener el token del usuario';
		}

		if ($codigo_retorno == 0)
		{
			$busqueda_contador_imagenes = "SELECT COUNT(*) FROM {$tabla_imagenes}";
			$contador_imagenes = $wpdb->get_var($busqueda_contador_imagenes);

			if (empty($contador_imagenes))
			{
				$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario);
				if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
				{
					$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
				}
				$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
				$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);

				if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
				{	
					$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
					$publicaciones_ofiliaria = $wpdb->get_results($busqueda_publicaciones);
					foreach ($publicaciones_ofiliaria as $indice => $publicacion)
					{
						$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
						if ($id_meli != '')
						{
							$publicaciones_ofiliaria_meli[] = 
								[
									'id_post' => $publicacion->ID,
									'id_meli' => $id_meli
								];
						}
					}
					$mensaje = 'Se encontraron '.$contador_publicaciones.' publicaciones en Ofiliaria para el usuario con el ID: '.$id_usuario;
				}
				else
				{
					$codigo_retorno = 4;
					$mensaje = 'No se encontraron publicaciones para el usuario con el ID: '.$id_usuario;
				}
			}
			else
			{
				$codigo_retorno = 3;
				$mensaje = 'La tabla imagenes_publicaciones no está vacía';
			}
		}

		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'publicaciones_ofiliaria_meli' => $publicaciones_ofiliaria_meli,
			'token_meli' => $token_meli
		];
		exit(json_encode($respuesta));	
	}
	public function procesar_publicacion_ofiliaria()
	{
		global $wpdb;
		$tabla_imagenes = $wpdb->prefix.'imagenes_publicaciones';
		$id_post = $_POST['id_post'];
		$id_meli = $_POST['id_meli'];
		$token_meli = $_POST['token_meli'];
		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso';
		$respuesta_publicacion = '';
		$url = "https://api.mercadolibre.com/items/".$id_meli;
		$headers = 
			[
				"Authorization: Bearer ".$token_meli
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		$respuesta_publicacion = json_decode($response);

		if (isset($respuesta_publicacion->status))
		{
			if ($respuesta_publicacion->status == 'closed' || $respuesta_publicacion->status == '404' || $respuesta_publicacion->status == 404)
			{
				$archivos_asociados = get_attached_media(null, $id_post);
				foreach ($archivos_asociados as $indice => $archivo)
				{
					$data = [];
					$format = array(
						'%d',
						'%s',
						'%s',
						'%d'
					);
					$data['id_post_crm'] = $id_post;
					$data['url_imagen'] = $id_meli;
					$data['tipo_imagen'] = 'General';
					$data['id_post_imagen'] = $archivo->ID;
					$wpdb->insert($tabla_imagenes, $data, $format);
					$id_nuevo_registro = $wpdb->insert_id;	
	
					wp_delete_attachment($archivo->ID, true); 
				}

				wp_delete_post($id_post, true);
				
				$codigo_retorno = 0;
				$mensaje = 'Se eliminó la publicación con id_post '.$id_post.', id_meli '.$id_meli;
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'No se eliminó la publicación con id_post '.$id_post.', id_meli '.$id_meli.' porque está activa';
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'Hubo un error en la respuesta de la API de Mercado Libre. No se pudo procesar la publicación con id_post '.$id_post.', id_meli '.$id_meli;
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'respuesta_publicacion' => $respuesta_publicacion
			];
		exit(json_encode($respuesta));	
	}
	public function buscar_publicaciones_descripcion()
	{
		// Inicio parámetros
		$id_usuario = $this->parametros_importacion_meli['id_autor']; 
		$indicador_verificacion_proceso_descripcion_ejecutado = $this->parametros_importacion_meli['indicador_verificacion_proceso_descripcion_ejecutado'];
		$indicador_actualizar_descripcion = $this->parametros_importacion_meli['indicador_actualizar_descripcion'];
		// Fin parámetros

		global $wpdb;
		$lista_agentes = strval($id_usuario);
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$id_meli = '';
		$indicador_post_meta_publicacion_importada = 0;
		$indicador_option_publicacion_importada = 0;
		$indicador_publicacion_importada = 0;	
		$contador_publicaciones_descripcion = 0;	
		$ofiliaria_publicaciones_descripcion = [];
		$contador_busqueda_agentes = '';
		$contador_agentes = 0;
		$publicaciones_no_actualizar_descripcion = [];
		$indicador_importacion_descripcion = '';
		$token_meli = '';

		$respuesta_obtener_token_meli = $this->obtener_token_meli($id_usuario);

		if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_obtener_token_meli['token_meli'];
		}
		elseif ($respuesta_obtener_token_meli['codigo_retorno'] == 1)
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo refrescar el token';
		}
		else
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo obtener el token del usuario';
		}

		if ($codigo_retorno == 0)
		{
			if ($indicador_verificacion_proceso_descripcion_ejecutado == 'Sí')
			{
				$indicador_importacion_descripcion = get_user_meta($id_usuario, '_ofiliaria_importacion_descripcion_meli', true);
			}
			if ($indicador_importacion_descripcion == '')
			{
				$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario);
				if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
				{
					$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
				}
				$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
				$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);

				if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
				{	
					$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
					$publicaciones = $wpdb->get_results($busqueda_publicaciones);
					foreach ($publicaciones as $indice => $publicacion)
					{
						$id_meli = '';
						$indicador_post_meta_publicacion_importada = 0;
						$indicador_publicacion_importada = 0;

						$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
						if ($id_meli != '')
						{
							$indicador_post_meta_publicacion_importada = get_post_meta($publicacion->ID, '_ofiliaria_publicacion_importada_meli', true);
							if ($indicador_post_meta_publicacion_importada != '')
							{
								$indicador_publicacion_importada = 1;
							}
							elseif (get_option('_ofiliaria_publicacion_importada_meli_'.$id_meli) === 'yes') 
							{
								$indicador_publicacion_importada = 1;
							}

							if ($indicador_publicacion_importada == 1) 
							{
								$indicador_post_meta_publicacion_descripcion_meli = get_post_meta($publicacion->ID, '_ofiliaria_actualizacion_descripcion_publicacion', true);

								if ($indicador_post_meta_publicacion_descripcion_meli == '')
								{									
									$ofiliaria_publicaciones_descripcion[] = 
									[
										'id_post' => $publicacion->ID,
										'id_meli' => $id_meli,
										'id_autor' => $publicacion->post_author
									];
									$contador_publicaciones_descripcion++;
								}
								else
								{
									$publicaciones_no_actualizar_descripcion[] = 
									[
										'id_post' => $publicacion->ID,
										'id_meli' => $id_meli,
										'id_autor' => $publicacion->post_author,
										'motivo_rechazo' => 'La descripción MELI ya fue importada anteriormente'
									];						
								}
							}
							else
							{
								$publicaciones_no_actualizar_descripcion[] = 
									[
										'id_post' => $publicacion->ID,
										'id_meli' => $id_meli,
										'id_autor' => $publicacion->post_author,
										'motivo_rechazo' => 'Publicación no marcada como importada de MELI'
									];						
							} 
						}
					}
					$codigo_retorno = 0;
					$mensaje = 'Se encontraron '.$contador_publicaciones_descripcion.' publicaciones del usuario '.$id_usuario.' a las cuales se les debe actualizar la descripción';
					update_user_meta($id_usuario, '_ofiliaria_importacion_descripcion_meli', 'Sí');
					update_user_meta($id_usuario, '_ofiliaria_publicaciones_descripcion', json_encode($ofiliaria_publicaciones_descripcion));
					update_user_meta($id_usuario, '_ofiliaria_publicaciones_no_actualizar_descripcion', json_encode($publicaciones_no_actualizar_descripcion));
				}
				else
				{
					$codigo_retorno = 4;
					$mensaje = 'No se encontraron publicaciones para el usuario con el ID: '.$id_usuario;
				}
			}
			else
			{
				$codigo_retorno = 3;
				$mensaje = 'Para el usuario con el ID '.$id_usuario.' ya se importaron desde Mercado Libre la descripción de las publicaciones';
			}
		}

		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'ofiliaria_publicaciones_descripcion' => $ofiliaria_publicaciones_descripcion,
			'publicaciones_no_actualizar_descripcion' => $publicaciones_no_actualizar_descripcion,
			'token_meli' => $token_meli,
			'indicador_actualizar_descripcion' => $indicador_actualizar_descripcion
		];
		exit(json_encode($respuesta));	
	}

	public function procesar_publicacion_descripcion()
	{
		global $wpdb;
		$id_post = $_POST['id_post'];
		$id_meli = $_POST['id_meli'];
		$id_autor = $_POST['id_autor'];
		$token_meli = $_POST['token_meli'];
		$indicador_actualizar_descripcion = $_POST['indicador_actualizar_descripcion'];
		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso';
		$respuesta_publicacion = '';
		$url = "https://api.mercadolibre.com/items/".$id_meli."/description";
		$headers = 
			[
				"Authorization: Bearer ".$token_meli
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		$respuesta_publicacion = json_decode($response);

		if (!isset($respuesta_publicacion->status))
		{
			if ($indicador_actualizar_descripcion == 'Sí')
			{
				$nuevo_contenido = $respuesta_publicacion->plain_text;
				$parametros_post = array(
					'ID'           => $id_post,
					'post_content' => $nuevo_contenido,
				);

				$resultado = wp_update_post($parametros_post);

				if (is_wp_error($resultado) || $resultado == 0) 
				{
					$codigo_retorno = 2;
					$mensaje = 'No se pudo actualizar la descripción de la publicación con id_post '.$id_post.' e id_meli '.$id_meli; 
				} 
				else 
				{
					$codigo_retorno = 0;
					$mensaje = 'Actualización exitosa de la descripción de la publicación con id_post '.$id_post.' e id_meli '.$id_meli; 
					update_post_meta($id_post, '_ofiliaria_actualizacion_descripcion_publicacion', 'Sí');
				}
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'En Mercado Libre no se encontró la publicación con id_post '.$id_post.' e id_meli '.$id_meli.'. El status de la publicación que se recibió de Mercado Libre es '.$respuesta_publicacion->status;
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'id_post' => $id_post,
				'id_meli' => $id_meli,
				'id_autor' => $id_autor
			];
		exit(json_encode($respuesta));	
	}

	public function eliminar_indicador_infocasas_publicaciones_importadas()
	{
		global $wpdb;
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$contador_indicador_infocasas_eliminado = 0;
		$publicaciones_indicador_infocasas_eliminado = [];
		$id_meli = '';
		$indicador_post_meta_publicacion_importada = '';
		$indicador_publicacion_importada = 0;	
		$indicador_publicar_infocasas = 0;	

		$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_type = 'estate_property'";
		$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);
		if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
		{	
			$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_type = 'estate_property'";
			$publicaciones = $wpdb->get_results($busqueda_publicaciones);
			foreach ($publicaciones as $indice_publicacion => $publicacion)
			{
				$id_meli = '';
				$indicador_post_meta_publicacion_importada = 0;
				$indicador_publicacion_importada = 0;
				$indicador_publicar_infocasas = 0;
				$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
				if ($id_meli != '')
				{
					$indicador_post_meta_publicacion_importada = get_post_meta($publicacion->ID, '_ofiliaria_publicacion_importada_meli', true);
					if ($indicador_post_meta_publicacion_importada == 'Sí')
					{
						$indicador_publicacion_importada = 1;
					}
					elseif (get_option('_ofiliaria_publicacion_importada_meli_'.$id_meli) === 'yes') 
					{
						$indicador_publicacion_importada = 1;
					}
					if ($indicador_publicacion_importada == 1) 
					{
						$indicador_publicar_infocasas = get_post_meta($publicacion->ID, '_ofiliaria_publicar_en_infocasas', true);
						if ($indicador_publicar_infocasas == 'Sí')
						{
							delete_post_meta($publicacion->ID, '_ofiliaria_publicar_en_infocasas');
							$contador_indicador_infocasas_eliminado++;
							$publicaciones_indicador_infocasas_eliminado[$publicacion->post_author][] =
								[
									'id_post' => $publicacion->ID, 
									'id_meli' => $id_meli
								];
						}
					}
				}
			}
			$codigo_retorno = 0;
			$mensaje = 'Se eliminó el indicador de infocasas a '.$contador_indicador_infocasas_eliminado.' publicaciones';
			update_user_meta(2, '_ofiliaria_eliminar_indicador_infocasas_publicaciones_importadas', json_encode($publicaciones_indicador_infocasas_eliminado));
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'No se encontraron publicaciones de propiedades';
		}

		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'contador_indicador_infocasas_eliminado' => $contador_indicador_infocasas_eliminado,
			'publicaciones_indicador_infocasas_eliminado' => $publicaciones_indicador_infocasas_eliminado
		];
		exit(json_encode($respuesta));	
	}
	public function buscar_agentes_agencia($id_usuario)
	{
		global $wpdb;
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = 'Se encontraron agentes asignados al usuario';
		$vector_usuarios = [$id_usuario];
		$vector_id_usuarios_nombres_agentes = [];
		$id_post_agente_agencia = get_user_meta($id_usuario, 'user_agent_id', true);
		$post_agente_agencia = get_post($id_post_agente_agencia);
		$vector_id_usuarios_nombres_agentes[$id_usuario] = $post_agente_agencia->post_title;

		$contador_busqueda_agentes = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author = {$id_usuario} AND post_type = 'estate_agent'";
		$contador_agentes = $wpdb->get_var($contador_busqueda_agentes);
		if (empty($contador_agentes) == false && $contador_agentes > 0)
		{	
			$busqueda_agentes = "SELECT * FROM {$tabla_posts} WHERE post_author = {$id_usuario} AND post_type = 'estate_agent'";
			$agentes = $wpdb->get_results($busqueda_agentes);
			foreach ($agentes as $indice_agente => $agente)
			{
				$user_agent_id = $agente->ID;
				$meta_key   = 'user_agent_id';
				$meta_value = $user_agent_id; 
				
				$parametros = array(
					'meta_query' => array(
						array(
							'key'     => $meta_key,
							'value'   => $meta_value,
							'compare' => '=', 
							'type'    => 'CHAR'
						),
					),
					'number'  => 1, 
					'fields'  => 'ID'
				);
				
				$usuarios_agentes = get_users($parametros);
				
				if (!empty($usuarios_agentes)) 
				{
					$id_usuario_agente = $usuarios_agentes[0];
					$vector_usuarios[] = (int)$id_usuario_agente;
					$vector_id_usuarios_nombres_agentes[(int)$id_usuario_agente] = $agente->post_title;
				}
			}
			delete_user_meta($id_usuario, '_ofiliaria_agencia_sin_agentes');
			update_user_meta($id_usuario, '_ofiliaria_agentes_agencia', json_encode($vector_usuarios));
			$lista_agentes = implode(",", $vector_usuarios);
			update_user_meta($id_usuario, '_ofiliaria_lista_agentes', $lista_agentes);
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'El usuario no tiene agentes';
			update_user_meta($id_usuario, '_ofiliaria_agencia_sin_agentes', 'Sí');
		}

		$resultado = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'vector_usuarios' => $vector_usuarios,
				'lista_agentes' => $lista_agentes,
				'vector_id_usuarios_nombres_agentes' => $vector_id_usuarios_nombres_agentes
			];
		return $resultado;
	}
	public function buscar_publicaciones_importadas_meli()
	{
		// Inicio parámetros
		$id_usuario = 83;
		$indicador_agregar_permalink = 'Sí';
		// Fin parámetros

		global $wpdb;
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$lista_agentes = strval($id_usuario);
		$id_meli = '';
		$indicador_post_meta_publicacion_importada = 0;
		$indicador_publicacion_importada = 0;
		$publicaciones_importadas_meli = [];

		$respuesta_refrescar_token_meli = $this->refrescar_token_meli($id_usuario);
		if ($respuesta_refrescar_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_refrescar_token_meli['respuesta_objeto_meli']->access_token;

			$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario);
			if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
			{
				$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
			}
			$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
			$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);

			if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
			{	
				$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
				$publicaciones = $wpdb->get_results($busqueda_publicaciones);
				foreach ($publicaciones as $indice => $publicacion)
				{
					$id_meli = '';
					$indicador_post_meta_publicacion_importada = 0;
					$indicador_publicacion_importada = 0;

					$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
					if ($id_meli != '')
					{
						$indicador_post_meta_publicacion_importada = get_post_meta($publicacion->ID, '_ofiliaria_publicacion_importada_meli', true);
						if ($indicador_post_meta_publicacion_importada != '')
						{
							$indicador_publicacion_importada = 1;
						}
						elseif (get_option('_ofiliaria_publicacion_importada_meli_'.$id_meli) === 'yes') 
						{
							$indicador_publicacion_importada = 1;
						}
						if ($indicador_publicacion_importada == 1)
						{
							$publicaciones_importadas_meli[] = 
								[
									'id_post' => $publicacion->ID,
									'id_meli' => $id_meli,
									'id_autor' => $publicacion->post_author
								]; 
						}
					}
				}
				$codigo_retorno = 0;
				$mensaje = "Se encontraron las publicaciones importadas de Mercado Libre";
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'No se encontraron publicaciones importadas de Mercado Libre';
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo refrescar el token';
		}

		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'publicaciones_importadas_meli' => $publicaciones_importadas_meli,
			'token_meli' => $token_meli,
			'indicador_agregar_permalink' => $indicador_agregar_permalink
		];
		exit(json_encode($respuesta));	
	}

	public function procesar_publicacion_importada_meli()
	{
		global $wpdb;
		$id_post = $_POST['id_post'];
		$id_meli = $_POST['id_meli'];
		$id_autor = $_POST['id_autor'];
		$token_meli = $_POST['token_meli'];
		$indicador_agregar_permalink = $_POST['indicador_agregar_permalink'];
		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso';
		$respuesta_publicacion = '';
		$url = "https://api.mercadolibre.com/items/".$id_meli;
		$headers = 
			[
				"Authorization: Bearer ".$token_meli
			];
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		$respuesta_publicacion = json_decode($response);

		if (isset($respuesta_publicacion->status))
		{
			if ($respuesta_publicacion->status == 'active')
			{
				$permalink = $respuesta_publicacion->permalink;
				if ($indicador_agregar_permalink == 'Sí')
				{
					update_post_meta($id_post, '_ofiliaria_permalink_publicacion_meli', $permalink);
				}
				$codigo_retorno = 0;
				$mensaje = 'Se agregó exitosamente el permalink: '.$permalink.' a la publicación con id_post '.$id_post.' e id_meli '.$id_meli;
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'En Mercado Libre no se encontró la publicación con id_post '.$id_post.' e id_meli '.$id_meli.'. El status de la publicación que se recibió de Mercado Libre es '.$respuesta_publicacion->status;
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'Error en respuesta de Mercado Libre para la publicación con id_post '.$id_post.' e id_meli '.$id_meli; 
		}

		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'id_post' => $id_post,
				'id_meli' => $id_meli,
				'id_autor' => $id_autor,
				'permalink' => $permalink
			];
		exit(json_encode($respuesta));	
	}
	public function refrescar_token_meli($id_usuario)
	{
		setlocale(LC_TIME, 'es_UY', 'es_UY.UTF-8', 'es_UY.UTF-8'); 
		date_default_timezone_set('America/Montevideo');
		$fecha_hora_refrescar_token_meli = date("Y-m-d H:i:s");			

		$respuesta = '';
		$codigo_retorno = 0;
		$mensaje = '';
		$codigo_retorno_refrescar_token_meli;
		$respuesta_refrescar_token_meli = '';
		$curl_error_token_meli = '';
		$respuesta_objeto_refrescar_token_meli = '';
		$respuesta_guardar_token_meli = '';

		$client_id_meli = get_option('_ofiliaria_client_id_meli');
		$client_secret_meli = get_option('_ofiliaria_client_secret_meli');
		$refresh_token = get_user_meta($id_usuario, '_refresh_token_meli', true);

		if ($refresh_token != '')
		{
			$data = array(
				'grant_type'    => 'refresh_token',
				'client_id'     => $client_id_meli,
				'client_secret' => $client_secret_meli,
				'refresh_token' => $refresh_token
			);		
			
			$data_string = http_build_query($data);
		
			$url = "https://api.mercadolibre.com/oauth/token";
			$headers = 
				[
					"Content-Type: application/x-www-form-urlencoded",
                    "accept: application/json"
				];
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			$respuesta_refrescar_token_meli = curl_exec($curl);
			$codigo_retorno_refrescar_token_meli = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$curl_error_token_meli = curl_error($curl);
			curl_close($curl);

			update_user_meta($id_usuario, '_codigo_retorno_refrescar_token_meli', $codigo_retorno_refrescar_token_meli);
			update_user_meta($id_usuario, '_respuesta_refrescar_token_meli', $respuesta_refrescar_token_meli);
			update_user_meta($id_usuario, '_fecha_hora_refrescar_token_meli', $fecha_hora_refrescar_token_meli);		
			
			if ($respuesta_refrescar_token_meli === false)
			{
				update_user_meta($id_usuario, '_curl_error_token_meli', $curl_error_token_meli);
				$codigo_retorno = 2;
        		$mensaje = 'Error de conexión con el servidor de Mercado Libre (cURL)';
			}
			elseif ($codigo_retorno_refrescar_token_meli >= 400)
			{
				$codigo_retorno = 3;
				$mensaje = 'Mercado Libre denegó el acceso (Error ' . $codigo_retorno_refrescar_token_meli . ') respuesta completa de Mercado Libre' . $respuesta_refrescar_token_meli;
			}
			else
			{
				$respuesta_objeto_refrescar_token_meli = json_decode($respuesta_refrescar_token_meli);
				if (isset($respuesta_objeto_refrescar_token_meli->access_token)) {
					$token_meli = $respuesta_objeto_refrescar_token_meli->access_token;
					$refresh_token = $respuesta_objeto_refrescar_token_meli->refresh_token;
					$respuesta_guardar_token_meli = $this->guardar_token_meli($token_meli, $refresh_token, $id_usuario);
					$codigo_retorno = 0;
					$mensaje = 'Se refrescó el token exitosamente';
				} else {
					$codigo_retorno = 4;
					$mensaje = 'No se pudo refrescar el token. La respuesta de la API de Mercado Libre no contiene el access_token. Respuesta completa: ' . $respuesta_refrescar_token_meli;
				}
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'Usuario no tiene refresh_token';
		}

		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'codigo_retorno_meli' => $codigo_retorno_refrescar_token_meli,
				'respuesta_objeto_meli' => $respuesta_objeto_refrescar_token_meli, 
				'mensaje_error_token_meli' => $curl_error_token_meli
			];

		return $respuesta;
	}

    public function verificar_url_con_curl(string $url): bool
    {
        $ch = curl_init($url);

        if ($ch === false) {
            // echo "Error al inicializar cURL para la URL: '$url'.\n";
            return false;
        }

        // Establecer la solicitud como HEAD: solo obtener los encabezados, no el cuerpo.
        // Esto es muy eficiente para verificar la existencia de una URL.
        curl_setopt($ch, CURLOPT_NOBODY, true);

        // Devolver el contenido de la respuesta como una cadena (aunque con CURLOPT_NOBODY, esto será vacío)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Seguir redirecciones HTTP (es importante para saber si la URL final existe)
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Establecer un tiempo de espera máximo para la conexión
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 10 segundos para establecer la conexión
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);      // 15 segundos para toda la operación

        // No verificar el certificado SSL (para entornos de desarrollo/pruebas),
        // pero para PRODUCCIÓN, estas líneas deben estar comentadas o configuradas para TRUE
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Ejecutar la solicitud cURL
        curl_exec($ch);

        // Verificar si hubo un error de cURL
        if (curl_errno($ch)) {
            // echo "Error cURL para la URL '$url': " . curl_error($ch) . "\n";
            curl_close($ch);
            return false;
        }

        // Obtener el código de estado HTTP de la respuesta
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Códigos de estado HTTP que indican que la URL "existe" o es válida:
        // 200 OK: Éxito
        // 3xx Redirecciones (301, 302, 303, 307, 308)
        if ($http_code >= 200 && $http_code < 400) {
            // echo "La URL '$url' existe (Código HTTP: " . $http_code . ").\n";
            return true;
        }

        // Otros códigos (404 Not Found, 500 Internal Server Error, etc.)
        // echo "La URL '$url' NO existe o hay un error (Código HTTP: " . $http_code . ").\n";
        return false;
    }
	public function obtener_token_meli($id_usuario)
	{
		$token_meli = '';
		$codigo_retorno = 0;
		$mensaje = '';
		$respuesta = '';

		$respuesta_verificar_token_meli = $this->verificar_token_meli($id_usuario);

		if ($respuesta_verificar_token_meli['codigo_retorno_token_meli'] == 0)
		{
			$token_meli = $respuesta_verificar_token_meli['token_meli_bd'];
			$codigo_retorno = 0;
			$mensaje = 'El token meli está vigente';
		}
		elseif ($respuesta_verificar_token_meli['codigo_retorno_token_meli'] == 4)
		{
			$respuesta_refrescar_token_meli = $this->refrescar_token_meli($respuesta_verificar_token_meli['usuario_duenio_token']);
			if ($respuesta_refrescar_token_meli['codigo_retorno'] == 0)
			{
				$token_meli = $respuesta_refrescar_token_meli['respuesta_objeto_meli']->access_token;
				$codigo_retorno = 0;
				$mensaje = 'El token se refrescó exitosamente';
			}
			else
			{
				$codigo_retorno = 1;
				$mensaje = 'No se pudo refrescar el token del usuario';
			}
		}
		else
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo obtener el token del usuario';
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'token_meli' => $token_meli
			];
		return $respuesta;
	}
	public function destaque_publicacion_meli()
	{
		$codigo_retorno = 0;
		$mensaje = '';
		$usuario_autorizado_destaque = 0;
		$id_autor = 0;
		$respuesta = '';
		
		$id_post = $_POST['id_post'];
		$id_meli_publicacion = $_POST['id_meli_publicacion'];
		$destaque_actual_mercado_libre = $_POST['destaque_actual_mercado_libre'];
		$nuevo_destaque_mercado_libre = $_POST['nuevo_destaque_mercado_libre'];
		$usuario_conectado = wp_get_current_user();

		$id_post_agencia_agente = get_user_meta($usuario_conectado->ID, 'user_agent_id', true);
		if ($id_post_agencia_agente != '')
		{
			$post_agencia_agente = get_post($id_post_agencia_agente);
			$id_autor = $post_agencia_agente->post_author;	
			if ($id_autor == 0)
			{
				$usuario_autorizado_destaque = 1;
			}
		}

		if ($usuario_autorizado_destaque == 1)
		{
			if ($destaque_actual_mercado_libre == 'gold' && $nuevo_destaque_mercado_libre == 'gold_premium')
			{
				$respuesta_curl_destaque_meli = $this->curl_destaque_meli($usuario_conectado->ID, $id_meli_publicacion, 'silver');
				if ($respuesta_curl_destaque_meli['codigo_retorno'] != 0)
				{
					$codigo_retorno = 2;
					$mensaje = 'Por favor vuelva a intentar en 5 minutos';
				}
			}
			if ($codigo_retorno == 0)
			{
				$respuesta_curl_destaque_meli = $this->curl_destaque_meli($usuario_conectado->ID, $id_meli_publicacion,  $nuevo_destaque_mercado_libre);
				if ($respuesta_curl_destaque_meli['codigo_retorno'] == 0)
				{
					$codigo_retorno = 0;
					$mensaje = $respuesta_curl_destaque_meli['mensaje'];
				}
				else
				{
					$codigo_retorno = 2;
					if ($destaque_actual_mercado_libre == 'gold' && $nuevo_destaque_mercado_libre == 'gold_premium')
					{
						$mensaje = 'Por favor vuelva a intentar en 5 minutos...';
					}
					else
					{
						$mensaje = $respuesta_curl_destaque_meli['mensaje'];
					}
				}
			}

		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'Usuario no autorizado para hacer destaques en Mercado Libre';
		}

		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'destaque_actual_mercado_libre' => $destaque_actual_mercado_libre,
				'nuevo_destaque_mercado_libre' => $nuevo_destaque_mercado_libre
			];
		
		update_user_meta($usuario_conectado->id, '_ofiliaria_respuesta_destaque_meli', json_encode($respuesta));
		exit(json_encode($respuesta));	
	}
	public function curl_destaque_meli($id_usuario = null, $id_meli_publicacion = null, $nuevo_destaque_mercado_libre = null)
	{
		$codigo_retorno = 0;
		$mensaje = '';
		$respuesta_curl_objeto = '';
		$httpCode = '';
		$respuesta = '';

		$respuesta_obtener_token_meli = $this->obtener_token_meli($id_usuario);
		if ($respuesta_obtener_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_obtener_token_meli['token_meli'];
			$url = "https://api.mercadolibre.com/items/{$id_meli_publicacion}/listing_type";
			$autorizacion = "Authorization: Bearer ".$token_meli;
			$data = [
				'id' => $nuevo_destaque_mercado_libre
			];

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array($autorizacion, 'Content-Type: application/json', 'Accept: application/json' ));
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
			$respuesta_curl = curl_exec($curl);
			$respuesta_curl_objeto = json_decode($respuesta_curl);
			$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);
			if ($httpCode === 200 || $httpCode === 201) 
			{
				$codigo_retorno = 0;
				$mensaje = 'Destaque de publicación actualizado exitosamente a '.$respuesta_curl_objeto->listing_type_id;
			} 
			else 
			{
				$codigo_retorno = 1;
				$mensaje = 'Error al actualizar el destaque: No tiene el paquete contratado correspondiente o su saldo es insuficiente';
			}
			update_user_meta($id_usuario, '_ofiliaria_curl_destaque_meli', json_encode($respuesta_curl));
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'No se pudo obtener el token de Mercado Libre';
		}

		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'respuesta_curl_objeto' => $respuesta_curl_objeto,
				'httpCode' => $httpCode
			];
		return $respuesta;
	}
	public function filtro_agentes_agencia($agentes_agencia = null, $id_usuario_conectado = null)
	{
		$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario_conectado);
		if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
		{
			$agentes_agencia = $resultado_buscar_agentes_agencia['vector_id_usuarios_nombres_agentes']; 
		}	
		update_user_meta($id_usuario_conectado, '_ofiliaria_vector_nombres_agentes_agencia', json_encode($agentes_agencia));

		return $agentes_agencia;
	}
	
	/**
	 * Reasigna el agente de un post y actualiza los datos del vendedor en Mercado Libre.
	 * Es un manejador AJAX para 'reasignacion_de_agente'.
	 */
	public function reasignacion_de_agente()
	{
		$codigo_retorno = 0;
		$mensaje = '';

		$id_post = isset($_POST['id_post']) ? intval($_POST['id_post']) : 0;
		$id_usuario_agente = isset($_POST['id_usuario_agente']) ? intval($_POST['id_usuario_agente']) : 0;

		// Validar que los IDs sean válidos
		if ($id_post <= 0 || $id_usuario_agente <= 0)
		{
			$codigo_retorno = 1;
			$mensaje = 'ID de publicación o de agente no válidos.';
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		// 1. Actualizar el autor del post en WordPress
		$parametros_post_wp = array(
			'ID'            => $id_post,
			'post_author'   => $id_usuario_agente,
		);

		$resultado_wp_update = wp_update_post($parametros_post_wp);

		if (is_wp_error($resultado_wp_update) || $resultado_wp_update == 0)
		{
			$codigo_retorno = 2;
			$mensaje = 'No se pudo reasignar el agente en WordPress.';
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		// 2. Reasignar el agente en la tabla post_meta
		$id_post_agencia_agente = get_user_meta($id_usuario_agente, 'user_agent_id', true);
		update_post_meta($id_post, 'property_agent', $id_post_agencia_agente );

		// 3. Obtener los datos del agente para Mercado Libre
		$resultado_datos_agente = $this->obtener_datos_agente($id_usuario_agente);

		if ($resultado_datos_agente['codigo_retorno'] != 0)
		{
			$codigo_retorno = 3;
			$mensaje = $resultado_datos_agente['mensaje'];
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		$datos_contacto_meli = $resultado_datos_agente['datos_contacto'];

		// 4. Obtener el ID de la publicación de Mercado Libre
		$id_publicacion_meli = get_post_meta($id_post, '_ofiliaria_id_meli_publicacion', true);

		if (empty($id_publicacion_meli))
		{
			$codigo_retorno = 4;
			$mensaje = 'No se encontró el ID de la publicación de Mercado Libre.';
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		// 5. Refrescar el token de Mercado Libre usando el ID del usuario actual
		// Esta es la corrección: obtener el ID del usuario actual de WordPress
		$current_user_id = get_current_user_id();

		if ($current_user_id === 0)
		{
			$codigo_retorno = 5;
			$mensaje = 'No se pudo obtener el ID del usuario actual. Asegúrate de estar logueado.';
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		$respuesta_refrescar_token_meli = $this->refrescar_token_meli($current_user_id);

		if ($respuesta_refrescar_token_meli['codigo_retorno'] != 0)
		{
			$codigo_retorno = 6; // Cambié el código de retorno para mantener la secuencia
			$mensaje = 'No se pudo refrescar el token de Mercado Libre: ' . $respuesta_refrescar_token_meli['mensaje'];
			exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
		}

		$token_meli = $respuesta_refrescar_token_meli['respuesta_objeto_meli']->access_token;

		// 6. Construir el payload para la API de Mercado Libre
		$datos_put_meli = [
			'seller_contact' => [
				'contact'       => $datos_contacto_meli['nombre_contacto'],
				'other_info'    => '',
				'country_code'  => $datos_contacto_meli['codigo_pais'],
				'area_code'     => $datos_contacto_meli['area_code'],
				'phone'         => $datos_contacto_meli['telefono_movil_meli'],
				'country_code2' => $datos_contacto_meli['codigo_pais_whatsapp'],
				'area_code2'    => $datos_contacto_meli['area_code_whatsapp'],
				'phone2'        => $datos_contacto_meli['telefono_whatsapp_meli'],
				'email'         => $datos_contacto_meli['email_contacto'],
				'webpage'       => ''
			]
		];

		// 7. Enviar la solicitud PUT a la API de Mercado Libre
		$punto_final_meli = 'items/' . $id_publicacion_meli;
		$respuesta_meli_put = $this->enviar_solicitud_meli(
			$punto_final_meli,
			'PUT',
			$datos_put_meli,
			true, // Requiere autenticación
			$token_meli
		);

		$respuesta   = $respuesta_meli_put['respuesta']; 
    	$codigo_http = $respuesta_meli_put['codigo'];
    	$error_curl  = $respuesta_meli_put['error'];
		$success 	 = $respuesta_meli_put['success'];

		if ($respuesta === false) {
			$codigo_retorno = 7;
			$mensaje = 'Error al actualizar datos en Mercado Libre: ';
			$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
		}
		elseif (!$success) {
			$respuesta_vector = json_decode($respuesta, true);
			$codigo_retorno = 7;
			$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
			$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
			$mensaje = 'Error al actualizar datos en Mercado Libre: ';
			$mensaje .= "Código $codigo_http: $msg_error";
		}
		else
		{
			$codigo_retorno = 0;
			$mensaje = 'Reasignación del agente y actualización en Mercado Libre exitosa.';
		}
		exit(json_encode(['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje]));
	}
	
	/**
	 * Obtiene los datos de contacto de un agente o agencia de WordPress.
	 *
	 * @param int $id_usuario_agente El ID del usuario asociado al agente/agencia.
	 * @return array Un array con 'codigo_retorno', 'mensaje' y 'datos_contacto' (si es exitoso).
	 */
	private function obtener_datos_agente(int $id_usuario_agente)
	{
		$id_post_agencia_agente = get_user_meta($id_usuario_agente, 'user_agent_id', true);

		if (empty($id_post_agencia_agente))
		{
			return [
				'codigo_retorno' => 10,
				'mensaje' => 'El usuario no está registrado como agencia o agente.',
				'datos_contacto' => []
			];
		}

		$post_agencia_agente = get_post($id_post_agencia_agente);

		if (!$post_agencia_agente)
		{
			return [
				'codigo_retorno' => 11,
				'mensaje' => 'No se encontró el post de la agencia o agente.',
				'datos_contacto' => []
			];
		}

		$nombre_contacto = $post_agencia_agente->post_title;
		$nombre = get_post_meta($id_post_agencia_agente, 'first_name', true);

		if ($nombre != '')
		{
			$nombre_contacto = $nombre . ' ';
		}

		$apellido = get_post_meta($id_post_agencia_agente, 'last_name', true);

		if ($apellido != '')
		{
			$nombre_contacto .= $apellido;
		}

		$telefono_movil = '';
		if ($post_agencia_agente->post_type == 'estate_agency')
		{
			$telefono_movil = get_post_meta($id_post_agencia_agente, 'agency_mobile', true);
		}
		else // Asumiendo 'agent' o tipo similar si no es 'estate_agency'
		{
			$telefono_movil = get_post_meta($id_post_agencia_agente, 'agent_mobile', true);
		}

		if (empty($telefono_movil))
		{
			return [
				'codigo_retorno' => 12,
				'mensaje' => 'La agencia o agente no tiene teléfono móvil registrado.',
				'datos_contacto' => []
			];
		}

		$email = get_post_meta($id_post_agencia_agente, 'agent_email', true);

		if (empty($email))
		{
			return [
				'codigo_retorno' => 13,
				'mensaje' => 'La agencia o agente no tiene email registrado.',
				'datos_contacto' => []
			];
		}

		// Asumo que preparar_numero_whatsapp() es un método de esta misma clase
		$telefono_whatsapp_preparado = $this->preparar_numero_whatsapp($telefono_movil);

		// Aquí debes determinar los códigos de país y área.
		// Si siempre es "598" para Venezuela y el área_code se extrae del número o es vacío, ajusta aquí.
		// Para este ejemplo, usaré "598" y un area_code vacío como lo mencionaste.
		$codigo_pais_meli = "598";
		$area_code_meli = ""; // Si no lo obtienes de los metadatos, déjalo vacío.
		$codigo_pais_whatsapp_meli = "598";
		$area_code_whatsapp_meli = ""; // Si no lo obtienes de los metadatos, déjalo vacío.

		return [
			'codigo_retorno' => 0,
			'mensaje' => 'Datos de contacto obtenidos exitosamente.',
			'datos_contacto' => [
				'nombre_contacto'        => $nombre_contacto,
				'codigo_pais'            => $codigo_pais_meli,
				'area_code'              => $area_code_meli,
				'telefono_movil_meli'    => $telefono_whatsapp_preparado, // Usamos el número preparado aquí también
				'codigo_pais_whatsapp'   => $codigo_pais_whatsapp_meli,
				'area_code_whatsapp'     => $area_code_whatsapp_meli,
				'telefono_whatsapp_meli' => $telefono_whatsapp_preparado,
				'email_contacto'         => $email
			]
		];
	}
		
	public function buscar_campos_meli($indicador_ajax = null, $categoria_inmueble = null, $tipo_operacion = null)
	{
		$codigo_retorno = 0;
		$mensaje = '';
		$id_categoria_meli = '';	
		$campos_generales = [];
		$campos_especificos = [];
		$campos_a_mostrar = [];
		$indicador_categoria_encontrada = 0;
		$categoria_inmueble_infocasas = '';
		$tipo_operacion_infocasas = '';

		$respuesta = '';	

		$inmuebles_tipo_venta_unica = 
			[
				'Campos' => 'Campos',
				'Cocheras' => 'Cocheras',
				'Depósitos y Galpones' => 'Depósitos y Galpones',
				'Llave de Negocio' => 'Llave de Negocio',
				'Locales' => 'Locales',
				'Otros Inmuebles' => 'Otros Inmuebles',
			];		

		if (isset($_POST['indicador_ajax']))
		{
			$indicador_ajax = $_POST['indicador_ajax'];

			$termino_categoria = get_term($_POST['prop_category_submit']);
			$categoria_inmueble = $termino_categoria->name;	
			
			$termino_tipo_operacion = get_term($_POST['prop_action_category_submit']);
			$tipo_operacion = $termino_tipo_operacion->name;   
		}

		if (isset($this->tablas_infocasas['categorias_meli_infocasas'][$categoria_inmueble])) {
			$categoria_inmueble_infocasas = $this->tablas_infocasas['categorias_meli_infocasas'][$categoria_inmueble];
			error_log("Categoría Infocasas encontrada, MELI :".$categoria_inmueble.", Infocasas: ".$categoria_inmueble_infocasas);
		}

		if (isset($this->tablas_infocasas['operacion_meli_infocasas'][$tipo_operacion])) {
			$tipo_operacion_infocasas = $this->tablas_infocasas['operacion_meli_infocasas'][$tipo_operacion];
		}

		$vector_categorias_meli = $this->buscar_categorias_meli();
		foreach ($vector_categorias_meli as $categoria)
		{
			$indicador_categoria_encontrada = 0;
			if ($categoria->nivel_2 == $categoria_inmueble)
			{
				if ($categoria->nivel_3 == $tipo_operacion)
				{
					if ($categoria->nivel_3 == 'Venta')
					{
						if ($categoria->nivel_4 == null || $categoria->nivel_4 == '' || $categoria->nivel_4 == ' ')
						{
							if (isset($inmuebles_tipo_venta_unica[$categoria->nivel_2]))
							{
								$indicador_categoria_encontrada = 1;
							}
						} 
						elseif ($categoria->nivel_4 == 'Propiedades Individuales' || $categoria->nivel_4 == 'Propiedades Usadas')
						{
							$indicador_categoria_encontrada = 1;
						}
					}
					else
					{
						$indicador_categoria_encontrada = 1;
					}

					if ($indicador_categoria_encontrada == 1)
					{
						$codigo_retorno = 0;
						$mensaje = 'Categoría encontrada';
						$id_categoria_meli = $categoria->identificador_meli;	
						$campos_generales = json_decode($categoria->atributos, true);
						$campos_especificos = json_decode($categoria->atributos_especificos, true);	

						// Llamada única a campos_a_mostrar
						$campos_a_mostrar = $this->campos_a_mostrar($campos_especificos, $campos_a_mostrar, $categoria_inmueble, $tipo_operacion, $categoria_inmueble_infocasas, $tipo_operacion_infocasas);

						break;
					}
				}
			}
		}
		if ($indicador_categoria_encontrada == 0)
		{
			$codigo_retorno = 1;
			$mensaje = 'No se encontró la categoría';
		}
		$respuesta = 
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'id_categoria_meli' => $id_categoria_meli,
				'campos_generales' => $campos_generales,
				'campos_especificos' => $campos_especificos,
				'campos_a_mostrar' => $campos_a_mostrar
			];
		if ($indicador_ajax == 1)
		{
			exit(json_encode($respuesta));	
		}
		else
		{
			return $respuesta; 
		}
	}

    public function campos_a_mostrar($campos_especificos_meli, $campos_a_mostrar, $categoria_inmueble, $tipo_operacion, $categoria_inmueble_infocasas, $tipo_operacion_infocasas)
    {
        // 1. Procesar campos de Mercado Libre
        $campos_meli_ids = array_column($campos_especificos_meli, 'id');

        // Añadir excepciones de MELI
        foreach ($this->vector_campos_wp_meli_excepciones as $excepcion) {
            if ($excepcion['categoria_inmuebles'] == $categoria_inmueble && $excepcion['tipo_operacion'] == $tipo_operacion) {
                $campos_meli_ids[] = $excepcion['meli'];
            }
        }

        foreach ($this->vectorCamposWpMeli as $wpMeli) {
            if (in_array($wpMeli['meli'], $campos_meli_ids)) {
                $html_comparacion = $wpMeli['html_comparacion'];
                if (empty($html_comparacion) || isset($campos_a_mostrar[$html_comparacion])) {
                    continue;
                }

                $campo_requerido = 0;
                foreach ($campos_especificos_meli as $campo_especifico) {
                    if ($campo_especifico['id'] == $wpMeli['meli'] && !empty($campo_especifico['tags']['required'])) {
                        $campo_requerido = 1;
                        break;
                    }
                }

                $datos_campos_a_mostrar = [
                    'meli' => $wpMeli['meli'],
                    'campo_requerido' => $campo_requerido,
                    'valor_minimo_permitido' => $wpMeli['valor_minimo_permitido'],
                    'opciones' => $wpMeli['informacion_adicional']['opciones'] ?? [],
                    'unidades_permitidas' => $wpMeli['informacion_adicional']['unidades_permitidas'] ?? null,
                ];
                $campos_a_mostrar[$html_comparacion] = $datos_campos_a_mostrar;
            }
        }

        // 2. Procesar campos de Infocasas
        if (!empty($categoria_inmueble_infocasas) && isset($this->vector_infocasas_campos[$categoria_inmueble_infocasas])) {
			error_log("Procesando campos de Infocasas para categoría: $categoria_inmueble_infocasas y operación: $tipo_operacion_infocasas");
            $campos_infocasas_categoria = $this->vector_infocasas_campos[$categoria_inmueble_infocasas];

            // Obtener los campos de Infocasas para la categoría y operación dadas.
            $general_fields = $campos_infocasas_categoria['general'] ?? [];
            $operation_fields = $campos_infocasas_categoria[$tipo_operacion_infocasas] ?? [];

            // Extraer los campos anidados de comodidades y seguridad.
            $comodidades_fields = (isset($general_fields['comodidades']) && is_array($general_fields['comodidades'])) ? $general_fields['comodidades'] : [];
            $seguridad_fields = (isset($general_fields['seguridad']) && is_array($general_fields['seguridad'])) ? $general_fields['seguridad'] : [];

            foreach ($this->vectorCamposWpMeli as $wpMeli) {
                $etiquetas_xml = $wpMeli['etiquetasXmlInfocasas'] ?? null;
                if (!$etiquetas_xml) continue;

                $etiquetas_xml_array = is_array($etiquetas_xml) ? $etiquetas_xml : [$etiquetas_xml];

                foreach ($etiquetas_xml_array as $etiqueta) {
                    // Verificar si la etiqueta existe en los campos generales, de operación, comodidades o seguridad.
                    if (
                        array_key_exists($etiqueta, $general_fields) ||
                        array_key_exists($etiqueta, $operation_fields) ||
                        array_key_exists($etiqueta, $comodidades_fields) ||
                        array_key_exists($etiqueta, $seguridad_fields)
                    ) {
                        $html_comparacion = $wpMeli['html_comparacion'];
                        if (empty($html_comparacion) || isset($campos_a_mostrar[$html_comparacion])) {
                            continue 2; // Salta al siguiente $wpMeli
                        }

                        // El campo es de Infocasas pero no fue agregado por Meli.
                        $datos_campos_a_mostrar = [
                            'meli' => '', // Campo solo para Infocasas
                            'campo_requerido' => 0, // Por ahora no son requeridos
                            'valor_minimo_permitido' => $wpMeli['valor_minimo_permitido'],
                            'opciones' => $wpMeli['informacion_adicional']['opciones'] ?? [],
                            'unidades_permitidas' => $wpMeli['informacion_adicional']['unidades_permitidas'] ?? null,
                        ];
                        $campos_a_mostrar[$html_comparacion] = $datos_campos_a_mostrar;
                        
                        // Rompemos el bucle de etiquetas para no agregarlo múltiples veces si coincide con varias.
                        break;
                    }
                }
            }
        }
		else
		{
			error_log("No se encontraron campos de Infocasas para la categoría MELI: ".$categoria_inmueble.", categoria Infocasas: ".  $categoria_inmueble_infocasas);
		}

        return $campos_a_mostrar;
    }

	public function convertir_a_html($texto) 
	{
		// 1. Convertir saltos de línea a párrafos
		$html = '<p>' . str_replace("\n", '</p><p>', $texto) . '</p>';

		// Eliminar párrafos vacíos que puedan generarse
		$html = str_replace('<p></p>', '', $html);

		// 2. Intentar detectar negritas (ej: **texto** o *texto*)
		// Puedes ajustar los patrones según cómo introduces las negritas en tu texto
		$html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html); // Para **texto**
		$html = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $html);     // Para *texto* (si no usas asteriscos para listas)

		// 3. Intentar detectar listas (ej: - item o * item)
		// Esto es más complejo en texto plano, pero podemos buscar líneas que empiecen con guiones o asteriscos
		// y encerrarlas en <ul><li>.
		// Necesitaremos un enfoque más sofisticado para listas multilinea.
		// Por simplicidad, esta es una versión básica que busca líneas que parecen ítems de lista.

		// Primero, dividir en líneas para procesar
		$lineas = explode("\n", $texto);
		$html_con_listas = '';
		$en_lista = false;

		foreach ($lineas as $linea) {
			$linea_trim = trim($linea);
			if (preg_match('/^(\s*[-*]\s*)(.*)/', $linea_trim, $matches)) {
				// Parece un ítem de lista
				if (!$en_lista) {
					$html_con_listas .= '<ul>';
					$en_lista = true;
				}
				$html_con_listas .= '<li>' . $matches[2] . '</li>';
			} else {
				// No es un ítem de lista
				if ($en_lista) {
					$html_con_listas .= '</ul>';
					$en_lista = false;
				}
				// Asegurarse de que el resto del texto plano se convierta a HTML de párrafo
				$html_con_listas .= '<p>' . str_replace("\n", '</p><p>', $linea) . '</p>';
			}
		}
		if ($en_lista) {
			$html_con_listas .= '</ul>';
		}

		// Unir las lógicas: primero párrafos y negritas, luego intentar integrar las listas
		// La forma más robusta es procesar el texto original con ambas reglas.
		// Reintentaremos la función combinando las lógicas.

		$output_html = '';
		$lines = explode("\n", $texto);
		$in_list = false;

		foreach ($lines as $line) {
			$trimmed_line = trim($line);

			// Detectar ítems de lista
			if (preg_match('/^[-*]\s*(.*)/', $trimmed_line, $matches)) {
				if (!$in_list) {
					$output_html .= '<ul>';
					$in_list = true;
				}
				$item_content = $matches[1];
				// Aplicar negritas dentro del ítem de lista si es necesario
				$item_content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $item_content);
				$item_content = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $item_content);
				$output_html .= '<li>' . $item_content . '</li>';
			} else {
				// Cerrar la lista si estábamos en una
				if ($in_list) {
					$output_html .= '</ul>';
					$in_list = false;
				}
				// Procesar como párrafo
				if (!empty($trimmed_line)) { // Evitar párrafos vacíos de líneas en blanco
					$paragraph_content = $trimmed_line;
					// Aplicar negritas
					$paragraph_content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $paragraph_content);
					$paragraph_content = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $paragraph_content);
					$output_html .= '<p>' . $paragraph_content . '</p>';
				}
			}
		}

		// Asegurarse de cerrar la lista si el texto termina con una
		if ($in_list) {
			$output_html .= '</ul>';
		}

		// Finalmente, limpiar cualquier párrafo vacío que pueda haberse generado por líneas en blanco excesivas
		$output_html = str_replace('<p></p>', '', $output_html);

		return $output_html;
	}
	public function buscar_publicaciones_redimension_imagenes_meli()
	{
		// Inicio parámetros
		$id_usuario = null; // Se colocó null por seguridad por si se ejecuta la función por accidente
		// Fin parámetros

		global $wpdb;
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$lista_agentes = strval($id_usuario);
		$id_meli = '';
		$indicador_post_meta_publicacion_importada = 0;
		$indicador_publicacion_importada = 0;
		$publicaciones_redimension_imagenes_meli = [];

		if (current_user_can('manage_options'))
		{
			if (extension_loaded('gd') && extension_loaded('imagick')) 
			{
				$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario);
				if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
				{
					$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
				}
				$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
				$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);
		
				if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
				{	
					$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
					$publicaciones = $wpdb->get_results($busqueda_publicaciones);
					foreach ($publicaciones as $indice => $publicacion)
					{
						$id_meli = '';
						$indicador_post_meta_publicacion_importada = 0;
						$indicador_publicacion_importada = 0;
		
						$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
						if ($id_meli != '')
						{
							$publicaciones_redimension_imagenes_meli[] = 
								[
									'id_post' => $publicacion->ID,
									'id_meli' => $id_meli,
									'id_autor' => $publicacion->post_author
								]; 
						}
					}
					$codigo_retorno = 0;
					$mensaje = "Se encontraron las publicaciones para la redimensión de imágenes de Mercado Libre";
				}
				else
				{
					$codigo_retorno = 3;
					$mensaje = 'No se encontraron publicaciones para la redimensión de imágenes de Mercado Libre';
				}
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'Las extensiones gd e imagick no están instaladas en PHP';
			}
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'Permisos insuficientes';
		}
			
		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'id_agencia_agente' => $id_usuario,
			'publicaciones_redimension_imagenes_meli' => $publicaciones_redimension_imagenes_meli,
		];
		exit(json_encode($respuesta));	
	}
	
	public function procesar_publicacion_redimension_imagenes_meli()
	{
		global $wpdb;
		$id_agencia_agente = $_POST['id_agencia_agente'];
		$id_post = $_POST['id_post'];
		$id_meli = $_POST['id_meli'];
		$id_autor = $_POST['id_autor'];
		// Los target base para horizontal (800x600) y vertical (600x800)
		$target_horizontal_width = 800;
		$target_horizontal_height = 600;
		$target_vertical_width = 600;
		$target_vertical_height = 800;

		// Nuevos umbrales de detección específicos por orientación
		$threshold_horizontal_width = 750;
		$threshold_horizontal_height = 550;
		$threshold_vertical_width = 550;
		$threshold_vertical_height = 750;

		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso';
		$vector_imagenes_no_redimensionadas = [];
		$vector_imagenes_redimensionadas = [];
		$tabla_aws = $wpdb->prefix.'as3cf_items';

		$publicacion_importada_meli = get_post_meta($id_post, '_ofiliaria_publicacion_importada_meli', true );
		if ($publicacion_importada_meli == 'Sí')
		{
			delete_post_meta($id_post, '_ofiliaria_publicar_en_mercado_libre');
		}
		
		// Verificación inicial de la extensión Imagick
		if (!extension_loaded('imagick')) {
			$codigo_retorno = 2;
			$mensaje = 'La extensión Imagick de PHP no está cargada. No se puede procesar la imagen.';
			exit(json_encode([
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'id_usuario_agencia' => $id_agencia_agente,
				'id_usuario_agente' => $id_autor,
				'id_post' => $id_post,
				'vector_imagenes_redimensionadas' => [],
				'vector_imagenes_no_redimensionadas' => []
			]));
		}

		error_log("Aviso: Redimensionando imágenes.");

		$imagenes_asociadas = get_post_meta($id_post, 'wpestate_property_gallery', true);

		if (!empty($imagenes_asociadas))
		{
			foreach ($imagenes_asociadas as $imagen)
			{
				// Reiniciar para cada imagen
				$indicador_imagen_no_redimensionada = 0;
				$motivo_imagen_no_redimensionada = '';
				$busqueda = "SELECT * FROM {$tabla_aws} WHERE source_id = {$imagen}";
				$imagen_aws = $wpdb->get_row( $busqueda, OBJECT );

				$image_url_old = '';
				if (is_object($imagen_aws) && !empty($imagen_aws))
				{
					$image_url_old = 'https://'.$imagen_aws->bucket.'/'.$imagen_aws->path;
				}
				else
				{
					$post_adjunto = get_post($imagen);  
					if ( $post_adjunto === null ) 
					{
						$indicador_imagen_no_redimensionada = 1;
						$motivo_imagen_no_redimensionada = 'Imagen no encontrada en AWS y tampoco en el directorio upload de Wordpress';
					} 
					else 
					{
						$image_url_old = $post_adjunto->guid;
					}
				}
				if ($indicador_imagen_no_redimensionada == 0)
				{
					$posicion = strpos($image_url_old, '-MLU');
					if ($posicion !== false)
					{
						$upload_dir_info = wp_upload_dir();
						$temp_download_path = $upload_dir_info['path'] . '/temp_original_imgk_' . uniqid() . '.jpg';
						$temp_new_filepath = $upload_dir_info['path'] . '/imagen_redimensionada_imgk_' . uniqid() . '.jpg';

						// --- Paso 1: Descargar la imagen remota a un archivo temporal local ---
						$image_data = @file_get_contents($image_url_old);

						if ($image_data === false || strlen($image_data) === 0)
						{
							$indicador_imagen_no_redimensionada = 1;
							$motivo_imagen_no_redimensionada = "Error o datos vacíos al descargar la imagen de {$image_url_old} para la publicación con el ID {$id_post}";
						}
						else
						{
							file_put_contents($temp_download_path, $image_data);

							// --- Paso 2: Procesar la imagen con la clase Imagick directamente ---
							try {
								$img = new Imagick($temp_download_path); // Carga la imagen descargada
								$original_width = $img->getImageWidth();
								$original_height = $img->getImageHeight();

								$should_resize = false;
								$current_target_width = 0;
								$current_target_height = 0;

								// Determinar si es horizontal o vertical
								$is_horizontal = ($original_width >= $original_height);

								if ($is_horizontal) {
									// Es horizontal (o cuadrada), verificar umbrales de horizontal
									if ($original_width <= $threshold_horizontal_width && $original_height <= $threshold_horizontal_height) {
										$should_resize = true;
										$current_target_width = $target_horizontal_width; // 800
										$current_target_height = $target_horizontal_height; // 600
									}
								} else {
									// Es vertical, verificar umbrales de vertical
									if ($original_width <= $threshold_vertical_width && $original_height <= $threshold_vertical_height) {
										$should_resize = true;
										$current_target_width = $target_vertical_width; // 600
										$current_target_height = $target_vertical_height; // 800
									}
								}
								
								if ($should_resize) {
									// Calcular las nuevas dimensiones para escalar la imagen, manteniendo su proporción,
									// de modo que la dimensión más pequeña (o ambas) sea al menos el target.
									$ratio_w = $current_target_width / $original_width;
									$ratio_h = $current_target_height / $original_height;

									// Usar el ratio MAYOR para asegurar que al menos una dimensión alcance su objetivo,
									// y la otra será proporcionalmente más grande o igual, pero nunca más pequeña.
									$scale_factor = max($ratio_w, $ratio_h);

									$new_width = (int) round($original_width * $scale_factor);
									$new_height = (int) round($original_height * $scale_factor);
									
									// Asegurarnos que la imagen realmente necesita ser ampliada (no es ya más grande que el target final)
									if ($original_width >= $current_target_width && $original_height >= $current_target_height) {
										$indicador_imagen_no_redimensionada = 1;
										$motivo_imagen_no_redimensionada = "La imagen ({$original_width}x{$original_height}) ya es igual o más grande que su objetivo de escalado por exceso ({$current_target_width}x{$current_target_height}) y no requiere ampliación.";
									} else {
										// Aplicar el redimensionamiento
										$img->resizeImage($new_width, $new_height, Imagick::FILTER_LANCZOS, 1, true);
									}

									// Solo si no se ha marcado como no redimensionada
									if ($indicador_imagen_no_redimensionada === 0) {
										// Forzar el formato de salida a JPEG y ajustar la calidad
										$img->setImageFormat('jpeg');
										$img->setCompression(Imagick::COMPRESSION_JPEG);
										$img->setCompressionQuality(90); // Calidad JPEG (ajusta si es necesario, 0-100)
										$img->stripImage(); // Elimina perfiles y metadatos para reducir tamaño de archivo

										// Guardar la imagen procesada
										$save_success = $img->writeImage($temp_new_filepath);
										$img->destroy(); // Libera los recursos de Imagick

										if (!$save_success || !file_exists($temp_new_filepath) || filesize($temp_new_filepath) === 0) {
											$indicador_imagen_no_redimensionada = 1;
											$motivo_imagen_no_redimensionada = "Error al guardar el archivo redimensionado o archivo vacío en: {$temp_new_filepath}";
										} else {
											list($final_width, $final_height) = getimagesize($temp_new_filepath);

											// --- Paso 3: Sideloading a WordPress y limpieza ---
											@unlink($temp_download_path); // Limpia el archivo temporal original

											$file_array = array(
												'name'     => basename($temp_new_filepath),
												'tmp_name' => $temp_new_filepath,
												'error'    => 0,
												'size'     => filesize($temp_new_filepath),
											);

											$new_attachment_id = media_handle_sideload($file_array, $id_post);
											@unlink($temp_new_filepath); // Limpia el archivo temporal redimensionado

											if (is_wp_error($new_attachment_id))
											{
												$indicador_imagen_no_redimensionada = 1;
												$motivo_imagen_no_redimensionada = "Error al crear el nuevo adjunto para la propiedad con el ID {$id_post}: " . $new_attachment_id->get_error_message();
											}
											else
											{
												$delete_result = wp_delete_attachment($imagen, true);
												if ($delete_result === false)
												{
													// Aquí solo se registra en el log, no se marca como "no redimensionada"
													error_log("DEBUG: FALLO: Error al eliminar el adjunto anterior ID {$imagen} del post {$id_post}.");
												}

												$actualizar_imagenes_asociadas = get_post_meta($id_post, 'wpestate_property_gallery', true);
												$nuevo_vector_imagenes = [];
												foreach ($actualizar_imagenes_asociadas as $id_imagen)
												{
													if ($id_imagen != $imagen)
													{
														$nuevo_vector_imagenes[] = $id_imagen;
													}
												}

												$nuevo_vector_imagenes[] = $new_attachment_id;
												delete_post_meta($id_post, 'wpestate_property_gallery');
												update_post_meta($id_post, 'wpestate_property_gallery', $nuevo_vector_imagenes);

												$url_imagen_redimensionada = wp_get_attachment_url($new_attachment_id);

												$tabla_imagenes_redimensionadas = $wpdb->prefix . 'imagenes_redimensionadas';
												$data = [];
												$format = array(
													'%d', '%d', '%d', '%d', '%s', '%s'
												);

												$data['id_usuario_agencia'] = $id_agencia_agente;
												$data['id_usuario_agente'] = $id_autor;
												$data['id_post_publicacion'] = $id_post;
												$data['id_post_archivo_redimensionado'] = $new_attachment_id;
												$data['url_imagen_anterior'] = $image_url_old;
												$data['url_imagen_redimensionada'] = $url_imagen_redimensionada;

												$wpdb->insert($tabla_imagenes_redimensionadas, $data, $format);
												$id_nuevo_registro = $wpdb->insert_id;

												$vector_imagenes_redimensionadas[] =
													[
														'id_usuario_agencia' => $id_agencia_agente,
														'id_usuario_agente' => $id_autor,
														'id_post_publicacion' => $id_post,
														'id_post_archivo_redimensionado' => $new_attachment_id,
														'url_imagen_anterior' => $image_url_old,
														'url_imagen_redimensionada' => $url_imagen_redimensionada,
														'id_nuevo_registro' => $id_nuevo_registro
													];
											}
										}
									}
								} else {
									// La imagen no cumple las condiciones de tamaño para ser redimensionada según su orientación.
									$motivo_threshold_msg = $is_horizontal ?
										"horizontal (ancho <= {$threshold_horizontal_width}px y alto <= {$threshold_horizontal_height}px)" :
										"vertical (ancho <= {$threshold_vertical_width}px y alto <= {$threshold_vertical_height}px)";

									$indicador_imagen_no_redimensionada = 1;
									$motivo_imagen_no_redimensionada = "La imagen ({$original_width}x{$original_height}) no es considerada pequeña para su orientación ({$motivo_threshold_msg}) y no será redimensionada.";
								}
							}
							catch (ImagickException $e) {
								$indicador_imagen_no_redimensionada = 1;
								$motivo_imagen_no_redimensionada = "Error de Imagick al procesar la imagen: " . $e->getMessage();
								@unlink($temp_download_path); // Limpiar incluso si falla Imagick
								@unlink($temp_new_filepath); // Asegurar limpieza
							}
							// FIN DEL BLOQUE IMAGICK
						}
					}
					else
					{
						$indicador_imagen_no_redimensionada = 1;
						$motivo_imagen_no_redimensionada = 'La imagen no es importada de Mercado Libre';
					}
				}

				// Este bloque ahora se encarga de agregar al vector de NO redimensionadas
				if ($indicador_imagen_no_redimensionada == 1)
				{
					$vector_imagenes_no_redimensionadas[] =
					[
						'id_usuario_agencia' => $id_agencia_agente,
						'id_usuario_agente' => $id_autor,
						'id_post_publicacion' => $id_post,
						'id_post_imagen' => $imagen,
						'motivo_imagen_no_redimensionada' => $motivo_imagen_no_redimensionada
					];
				}
			} // Fin del foreach ($imagenes_asociadas as $imagen)
			$imagenes_asociadas_actualizado = get_post_meta($id_post, 'wpestate_property_gallery', true);
			set_post_thumbnail($id_post, $imagenes_asociadas_actualizado[0]);
		}
		else
		{
			$codigo_retorno = 1;
			$mensaje = 'No se consiguieron imágenes para la publicación con el ID: '.$id_post;
		}

		$respuesta =
			[
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje,
				'id_usuario_agencia' => $id_agencia_agente,
				'id_usuario_agente' => $id_autor,
				'id_post' => $id_post,
				'vector_imagenes_redimensionadas' => $vector_imagenes_redimensionadas,
				'vector_imagenes_no_redimensionadas' => $vector_imagenes_no_redimensionadas
			];
		exit(json_encode($respuesta));
	}
	public function preparar_numero_whatsapp ($telefono) 
	{
		// Definimos el código de país de Uruguay
		$codigo_pais_uruguay = '+598';
		$numero_limpio = $telefono;
	
		// 1. Verificar y suprimir el código de país de Uruguay si está presente
		// Usamos strpos para ver si la cadena comienza con el código
		if (strpos($numero_limpio, $codigo_pais_uruguay) === 0) {
			// Si comienza con +598, lo eliminamos
			$numero_limpio = substr($numero_limpio, strlen($codigo_pais_uruguay));
		}
	
		// 2. Eliminar espacios en blanco, guiones y cualquier otro caracter no numérico
		// Usamos preg_replace con una expresión regular para dejar solo dígitos
		$numero_limpio = preg_replace('/[^0-9]/', '', $numero_limpio);
	
		// Retornamos el número preparado
		return $numero_limpio;
	}
	public function buscar_publicaciones_agregar_whatsapp()
	{
		// Inicio parámetros
		$id_usuario = null; // Se colocó null por seguridad por si se ejecuta por accidente la acción
		// Fin parámetros

		global $wpdb;
		$tabla_posts = $wpdb->prefix.'posts';
		$codigo_retorno = 0;
		$mensaje = '';
		$token_meli = '';
		$lista_agentes = strval($id_usuario);
		$id_meli = '';
		$publicaciones_agregar_whatsapp = [];

		$respuesta_refrescar_token_meli = $this->refrescar_token_meli($id_usuario);
		if ($respuesta_refrescar_token_meli['codigo_retorno'] == 0)
		{
			$token_meli = $respuesta_refrescar_token_meli['respuesta_objeto_meli']->access_token;

			$resultado_buscar_agentes_agencia = $this->buscar_agentes_agencia($id_usuario);
			if ($resultado_buscar_agentes_agencia['codigo_retorno'] == 0)
			{
				$lista_agentes = $resultado_buscar_agentes_agencia['lista_agentes']; 
			}
			$contador_busqueda_publicaciones = "SELECT COUNT(*) FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
			$contador_publicaciones = $wpdb->get_var($contador_busqueda_publicaciones);

			if (empty($contador_publicaciones) == false && $contador_publicaciones > 0)
			{	
				$busqueda_publicaciones = "SELECT * FROM {$tabla_posts} WHERE post_author IN ({$lista_agentes}) AND post_type = 'estate_property'";
				$publicaciones = $wpdb->get_results($busqueda_publicaciones);
				foreach ($publicaciones as $indice => $publicacion)
				{
					$id_meli = '';
					$id_meli = get_post_meta($publicacion->ID, '_ofiliaria_id_meli_publicacion', true);
					if ($id_meli != '')
					{
						$publicaciones_agregar_whatsapp[] = 
							[
								'id_post' => $publicacion->ID,
								'id_meli' => $id_meli,
								'id_autor' => $publicacion->post_author
							]; 
					}
				}
				$codigo_retorno = 0;
				$mensaje = "Se encontraron las publicaciones para agregar Whatsapp";
			}
			else
			{
				$codigo_retorno = 2;
				$mensaje = 'No se encontraron publicaciones para agregar Whatsapp';
			}
		}
		else
		{
			$codigo_retorno = 3;
			$mensaje = 'No se pudo refrescar el token de meli';
		}
			
		$respuesta = 
		[
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'id_agencia_agente' => $id_usuario,
			'token_meli' => $token_meli,
			'publicaciones_agregar_whatsapp' => $publicaciones_agregar_whatsapp
		];
		exit(json_encode($respuesta));	
	}
	
	/**
	 * Envía una solicitud a la API de Mercado Libre.
	 *
	 * @param string $punto_final La parte de la URL de la API (endpoint).
	 * @param string $metodo El método HTTP (GET, POST, PUT, DELETE).
	 * @param array $datos Los datos a enviar.
	 * @param bool $requiere_autenticacion Indica si la solicitud requiere un token de acceso.
	 * @param string|null $token_acceso El token de acceso.
	 * @return array Un array asociativo con la respuesta de la API o un mensaje de error.
	 */
	private function enviar_solicitud_meli($punto_final, $metodo = 'GET', $datos = [], $requiere_autenticacion = false, $token_acceso = null)
	{
		$url_base = 'https://api.mercadolibre.com/';
		$url_completa = $url_base . ltrim($punto_final, '/');

		$encabezados = [
			'Content-Type: application/json',
			'Accept: application/json'
		];

		if ($requiere_autenticacion)
		{
			if (empty($token_acceso))
			{
				return [
					'error' => true,
					'mensaje' => 'Token de acceso no proporcionado para una solicitud autenticada.',
					'codigo' => 401
				];
			}
			$encabezados[] = 'Authorization: Bearer ' . $token_acceso;
		}

		$manejador_curl = curl_init();
		curl_setopt($manejador_curl, CURLOPT_URL, $url_completa);
		curl_setopt($manejador_curl, CURLOPT_RETURNTRANSFER, true);

		switch (strtoupper($metodo))
		{
			case 'POST':
				curl_setopt($manejador_curl, CURLOPT_POST, true);
				curl_setopt($manejador_curl, CURLOPT_POSTFIELDS, json_encode($datos));
				break;
			case 'PUT':
				curl_setopt($manejador_curl, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($manejador_curl, CURLOPT_POSTFIELDS, json_encode($datos));
				break;
			case 'DELETE':
				curl_setopt($manejador_curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			case 'GET':
				if (!empty($datos))
				{
					$url_completa .= '?' . http_build_query($datos);
					curl_setopt($manejador_curl, CURLOPT_URL, $url_completa);
				}
				break;
			default:
				return [
					'error' => true,
					'mensaje' => 'Método HTTP no soportado: ' . $metodo,
					'codigo' => 400
				];
		}

		curl_setopt($manejador_curl, CURLOPT_HTTPHEADER, $encabezados);

		$respuesta_curl = curl_exec($manejador_curl);
		$codigo_http 	= curl_getinfo($manejador_curl, CURLINFO_HTTP_CODE);
		$error_curl 	= curl_error($manejador_curl);

		curl_close($manejador_curl);

		return [
			'respuesta' => $respuesta_curl, // respuesta json sin decodificar, o false si hubo error de conexión
			'codigo'    => $codigo_http,    // Ej: 200, 400, 401
			'error'     => $error_curl,     // Mensaje de cURL si hubo fallo de red
			'success'   => ($respuesta_curl !== false && $codigo_http >= 200 && $codigo_http < 300)
		];
	}
			
	/**
	 * Procesa la publicación para agregar el número de WhatsApp si está ausente en Mercado Libre.
	 * Esta función se ejecuta via WP_Ajax.
	 */
	public function procesar_publicacion_agregar_whatsapp()
	{
		// Inicializar variables de respuesta
		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso.';

		// Validar que los parámetros POST están presentes
		if (
			!isset($_POST['id_agencia_agente']) ||
			!isset($_POST['token_meli']) ||
			!isset($_POST['id_post']) ||
			!isset($_POST['id_meli']) ||
			!isset($_POST['id_autor'])
		) 
		{
			$codigo_retorno = 1; // Error tipo 1: Parámetros incompletos
			$mensaje = 'Parámetros POST incompletos.';
			$respuesta = [
				'codigo_retorno' => $codigo_retorno,
				'mensaje' => $mensaje
			];
			wp_send_json($respuesta);
			exit;
		}

		// Sanitizar y asignar variables
		$id_agencia_agente = sanitize_text_field($_POST['id_agencia_agente']);
		$token_meli = sanitize_text_field($_POST['token_meli']);
		$id_post_wp = sanitize_text_field($_POST['id_post']); // ID del post de WordPress
		$id_meli_publicacion = sanitize_text_field($_POST['id_meli']); // ID de la publicación en Mercado Libre
		$id_autor = sanitize_text_field($_POST['id_autor']);

		// 1. Consultar la publicación en Mercado Libre
		$respuesta_meli = $this->enviar_solicitud_meli(
			"items/{$id_meli_publicacion}",
			'GET',
			[],
			true, // Requiere autenticación
			$token_meli
		);

		$respuesta   = $respuesta_meli['respuesta']; // Ya viene decodificado o es false
    	$codigo_http = $respuesta_meli['codigo'];
    	$error_curl  = $respuesta_meli['error'];
		$success 	 = $respuesta_meli['success'];

		if ($respuesta === false) {
			$codigo_retorno = 2;
			$mensaje = 'Error al consultar la publicación en Mercado Libre: ';
			$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
		}
		elseif (!$success) {
			$respuesta_vector = json_decode($respuesta, true);
			$codigo_retorno = 2;
			$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
			$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
			$mensaje = 'Error al consultar la publicación en Mercado Libre: ';
			$mensaje .= "Código $codigo_http: $msg_error";
		}
		else
		{
			$datos_publicacion_meli = json_decode($respuesta, true); // Datos de la publicación obtenidos de Mercado Libre

			// 2. Verificar si 'seller_contact' y sus sub-elementos están vacíos
			$whatsapp_existe_y_valido = false;
			if (
				isset($datos_publicacion_meli['seller_contact']) &&
				is_array($datos_publicacion_meli['seller_contact']) &&
				isset($datos_publicacion_meli['seller_contact']['country_code2']) &&
				isset($datos_publicacion_meli['seller_contact']['phone2']) &&
				!empty($datos_publicacion_meli['seller_contact']['country_code2']) &&
				!empty($datos_publicacion_meli['seller_contact']['phone2'])
			) 
			{
				// *** INICIO DEL CAMBIO ***
				$whatsapp_existe_y_valido = true;
				$codigo_retorno = 8; // Código tipo 8: WhatsApp ya existe en la publicación
				$mensaje = 'La publicación ya tiene el número de WhatsApp.';
				// *** FIN DEL CAMBIO ***
			}

			if (!$whatsapp_existe_y_valido)
			{
				// Los campos están vacíos o no existen, buscar el número de WhatsApp localmente
				$telefono_agente = '';

				// Obtener ID del post de la agencia/agente
				$id_post_agencia_agente = get_user_meta($id_autor, 'user_agent_id', true);

				if (empty($id_post_agencia_agente))
				{
					$codigo_retorno = 3; // Error tipo 3: Usuario no registrado como agencia/agente
					$mensaje = 'El usuario no está registrado como agencia o agente.';
				}
				else
				{
					$post_agencia_agente = get_post($id_post_agencia_agente);

					if (null === $post_agencia_agente)
					{
							$codigo_retorno = 4; // Error tipo 4: Post de agencia/agente no encontrado
							$mensaje = 'El post de la agencia o agente no fue encontrado.';
					}
					else
					{
						if ($post_agencia_agente->post_type == 'estate_agency')
						{
							$telefono_agente = get_post_meta($id_post_agencia_agente, 'agency_mobile', true);
						}
						else // Asumimos 'estate_agent'
						{
							$telefono_agente = get_post_meta($id_post_agencia_agente, 'agent_mobile', true);
						}

						if (empty($telefono_agente))
						{
							$codigo_retorno = 5; // Error tipo 5: Agencia/agente sin teléfono WhatsApp
							$mensaje = 'La agencia o agente no tiene un número de teléfono móvil (WhatsApp) registrado.';
						}
						else
						{
							// Preparar el número de WhatsApp usando la función
							$telefono_whatsapp_preparado = $this->preparar_numero_whatsapp($telefono_agente);

							if (empty($telefono_whatsapp_preparado))
							{
								$codigo_retorno = 6; // Error tipo 6: Número WhatsApp no pudo ser preparado
								$mensaje = 'El número de teléfono móvil de la agencia o agente no pudo ser preparado para WhatsApp (quedó vacío después de la limpieza).';
							}
							else
							{
								// Tomar el objeto seller_contact existente de los datos de la publicación
								$datos_seller_contact_actuales = isset($datos_publicacion_meli['seller_contact']) && is_array($datos_publicacion_meli['seller_contact']) ? $datos_publicacion_meli['seller_contact'] : [];

								// Asegurarse de que country_code2 y phone2 se actualizan
								$datos_seller_contact_actuales['country_code2'] = '598'; // Código de país de Uruguay
								$datos_seller_contact_actuales['phone2'] = $telefono_whatsapp_preparado;

								$datos_a_enviar = [
									'seller_contact' => $datos_seller_contact_actuales
								];

								$respuesta_put_meli = $this->enviar_solicitud_meli(
									"items/{$id_meli_publicacion}",
									'PUT',
									$datos_a_enviar,
									true, // Requiere autenticación
									$token_meli
								);

								$respuesta   = $respuesta_put_meli['respuesta']; // Ya viene decodificado o es false
								$codigo_http = $respuesta_put_meli['codigo'];
								$error_curl  = $respuesta_put_meli['error'];
								$success 	 = $respuesta_put_meli['success'];

								if ($respuesta === false) {
									$codigo_retorno = 7;
									$mensaje = 'Error al actualizar la publicación en Mercado Libre: ';
									$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
								}
								elseif (!$success) {
									$respuesta_vector = json_decode($respuesta, true);
									$codigo_retorno = 7;
									$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
									$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
									$mensaje = 'Error al actualizar la publicación en Mercado Libre: ';
									$mensaje .= "Código $codigo_http: $msg_error";
								}
								else
								{
									$mensaje = 'Código: '.$codigo_http.'. Número de WhatsApp agregado/actualizado exitosamente en la publicación de Mercado Libre.';
								}
							}
						}
					}
				}
			}
		}

		// Preparar la respuesta final para el JavaScript
		$respuesta_final = [
			'codigo_retorno' => $codigo_retorno,
			'mensaje' => $mensaje,
			'id_usuario_agencia' => $id_agencia_agente,
			'id_usuario_agente' => $id_autor,
			'id_post' => $id_post_wp,
			'id_meli' => $id_meli_publicacion,
		];

		// Enviar la respuesta JSON y finalizar la ejecución
		wp_send_json($respuesta_final);
		exit;
	}

	private function llamar_api_laravel($ruta_api, $metodo_http = 'GET', $cuerpo_peticion = [], $cabeceras = [])
	{
		$url_base_wordpress = $this->urlBase();

		if ($url_base_wordpress == 'https://ofiliaria.com.uy')
		{
			$url_base_api_laravel = "https://backend.ofiliaria.com.uy/public/api/v1/";
		}
		else
		{
			$url_base_api_laravel = "https://dev-backend.ofiliaria.com/public/api/v1/";
		}
		
		$url_completa = $url_base_api_laravel . $ruta_api;
		
		$cabeceras_defecto = [
			'Content-Type'  => 'application/json',
			'Accept'        => 'application/json',
		];

		$argumentos = [
			'method'    => strtoupper($metodo_http),
			'headers'   => array_merge($cabeceras_defecto, $cabeceras),
			'timeout'   => 45,
			'sslverify' => false, // Cambiar a true en producción
		];

		if (in_array(strtoupper($metodo_http), ['POST', 'PUT']))
		{
			$argumentos['body'] = json_encode($cuerpo_peticion);
		}
		elseif (strtoupper($metodo_http) === 'GET' && !empty($cuerpo_peticion))
		{
			$url_completa .= '?' . http_build_query($cuerpo_peticion);
		}
		
		$respuesta_http = wp_remote_request($url_completa, $argumentos);

		if (is_wp_error($respuesta_http))
		{
			return [
				'codigo_retorno' => 101, // Error de conexión con la API (WP_Error)
				'mensaje'        => 'Error de conexión con la API de Laravel: ' . $respuesta_http->get_error_message(),
				'datos'          => null
			];
		}

		$codigo_http = wp_remote_retrieve_response_code($respuesta_http);
		$cuerpo_respuesta = wp_remote_retrieve_body($respuesta_http);
		$datos_decodificados = json_decode($cuerpo_respuesta, true);

		if ($codigo_http >= 200 && $codigo_http < 300)
		{
			if (isset($datos_decodificados['codigo_retorno']) && $datos_decodificados['codigo_retorno'] !== 0)
			{
					return [
					'codigo_retorno' => $datos_decodificados['codigo_retorno'],
					'mensaje'        => isset($datos_decodificados['mensaje']) ? $datos_decodificados['mensaje'] : 'Error lógico en la API de Laravel.',
					'datos'          => $datos_decodificados['datos'] ?? null
				];
			}
			
			return [
				'codigo_retorno' => 0,
				'mensaje'        => isset($datos_decodificados['mensaje']) ? $datos_decodificados['mensaje'] : 'Petición API exitosa.',
				'datos'          => $datos_decodificados['datos'] ?? null
			];
		}
		else
		{
			if (isset($datos_decodificados['codigo_retorno']) && isset($datos_decodificados['mensaje']))
			{
				return [
					'codigo_retorno' => $datos_decodificados['codigo_retorno'],
					'mensaje'        => $datos_decodificados['mensaje'],
					'datos'          => $datos_decodificados['datos'] ?? null
				];
			}
			
			return [
				'codigo_retorno' => 102,
				'mensaje'        => 'Error en la API de Laravel (Código HTTP: ' . $codigo_http . '): ' . (isset($datos_decodificados['message']) ? $datos_decodificados['message'] : $cuerpo_respuesta),
				'datos'          => $datos_decodificados
			];
		}
	}

	/**
	 * Función AJAX de WordPress para verificar datos de envío de publicaciones MELI.
	 */
	public function verificar_datos_envio_publicaciones_meli()
    {
        $codigo_retorno = 0;
        $mensaje = 'Proceso exitoso';
        $id_categoria = isset($_POST['id_categoria']) ? sanitize_text_field($_POST['id_categoria']) : '';
        $datos_categoria = null;
		$modelo_vector = 
			[
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',	
				'',
				'',		
				'',
				'',
				'',
				'',
				'',
				'',
				'',
				'',	
				'',
				'',				
			];
		$tipo_campos_a_verificar = 
			[
				'calidad' => 
					[
						'Superficie total',
						'Área privada',
						'Acceso',
						'Huéspedes',
						'Dormitorios',
						'Baños',
						'Distancia al asfalto',
						'Forma del terreno',
						'Cocheras',
						'Superficie de balcón',
						'Antigüedad',
						'Ambientes',
						'Camas',	
						'Bodegas',
						'Número de piso de la unidad',
						'Número del apartamento',
						'Apartamentos por piso',
						'Número de piso de la unidad',
						'Tipo de departamento',
						'Disposición',
						'Cantidad de pisos',
						'Número de la casa',
						'Tipo de casa',
						'Orientación',
						'Estadía mínima (noches)',		
						'Horario check in',
						'Horario check out',
						'Código de la propiedad',
						'Baño social',
						'Dormitorio de servicio',
						'Jardín',
						'Parrillero',
						'Piscina',
						'Terraza',
						'Servicio de desayuno',
						'Servicio de limpieza',
						'Superficie del terreno',
						'Mascotas',
						'Uso comercial',
						'Tipo de campo',
						'Superficie cubierta del casco',
						'Cantidad de habitaciones'
					],
				'servicios' => 
					[
						'Acceso a internet',
						'Agua corriente',
						'Saneamiento',
						'Gas natural',
						'Línea telefónica',
						'Luz eléctrica',
						'TV por cable',
						'Energía solar',
						'Conexión para lavarropas',
						'TV satelital',
						'Electrógeno',
						'Jardinero'
					],
				'comodidades_equipamiento' =>
					[
						'Aire acondicionado',
						'Ascensor',
						'Caldera a gas/ eléctrica',
						'Calefacción',
						'Heladera',
						'Lavarropa',
						'Microondas',
						'TV',
						'Vajilla',
						'Chimenea',
						'Cisterna',
						'Estacionamiento para visitas',
						'Gimnasio',
						'Grupo electrógeno',
						'Área verde',
						'Cancha polideportiva',
						'Sauna',
						'Área de cine',
						'Infantil',
						'Número de torre',
						'Rampa para silla de ruedas',
						'Bebederos',
						'Casco',
						'Corral',
						'Galpón',
						'Molinos',
						'Silos',
						'Tanque de agua'
					],
				'espacios_comunes' =>
					[
						'Área de juegos infantiles',
						'Cowork',
						'Caballeriza',
						'Cancha de básquetbol',
						'Cancha de fútbol',
						'Cancha de paddle',
						'Cancha de tenis',
						'Recepción',
						'Salón de fiestas',
						'Salón de usos múltiples',
						'Área de lavandería'
					],
				'ambientes' =>
					[
						'Balcón',
						'Cocina',
						'Comedor',
						'Dormitorio en suite',
						'Estudio',
						'Jacuzzi',
						'Placards',
						'Living',
						'Patio',
						'Cuarto de juegos',
						'Vestidor',
						'Con lavadero',	
						'Altillo',
						'Desayunador'		
					],
				'seguridad' =>
					[
						'Alarma',
						'Portón automático',
						'Circuito de cámaras de seguridad',
						'Tipo de seguridad',
						'Acceso controlado',
						'Barrio cerrado'
					],
				'condiciones_especiales' =>
					[
						'Apto para familias con niños',
						'Se admiten mascotas',
						'Solo familias',
						'Amoblado',
						'Disponible desde'
					],
				'Otros' =>
					[
						'Factor multiplicador de renta',
						'Azotea'
					]
			];
		$indicador_existe_atributos_especificos = 0;
		$campos_no_existen_atributos_especificos = [];
		$indicador_existe_wp_meli = 0;
		$campos_existen_wp_meli = [];
		$campos_no_existen_wp_meli = [];

        if (empty($id_categoria))
        {
            $codigo_retorno = 1;
            $mensaje = 'ID de categoría no proporcionado.';
        }
        else
        {
            $respuesta_api = $this->llamar_api_laravel('categorias/buscarCategoriaMeli/' . $id_categoria, 'GET');

            if ($respuesta_api['codigo_retorno'] === 0)
            {
                $mensaje = $respuesta_api['mensaje'];
                $datos_categoria = $respuesta_api['datos'];

                // Decodificación de 'atributos_especificos' aquí
                if (isset($datos_categoria['atributos_especificos']) && is_string($datos_categoria['atributos_especificos']))
                {
                    $atributos_decodificados = json_decode($datos_categoria['atributos_especificos'], true);
                    
                    if (json_last_error() === JSON_ERROR_NONE)
                    {
                        $datos_categoria['atributos_especificos'] = $atributos_decodificados;
                    }
                    else
                    {
                        // Si la decodificación falla, asignar error y salir
                        $codigo_retorno = 14; // Nuevo código de error para JSON de atributos inválido
                        $mensaje = 'Error: Los atributos específicos de la categoría tienen un formato JSON inválido.';
                        $datos_categoria = null; // Limpiar datos para indicar el error crítico
                        // No es necesario continuar con el foreach si el JSON es inválido
                    }
                }
                // --- INICIO: Nuevo bloque ELSE para manejar si atributos_especificos NO es un array o cadena ---
                elseif (!isset($datos_categoria['atributos_especificos']) || (!is_array($datos_categoria['atributos_especificos']) && !is_string($datos_categoria['atributos_especificos'])))
                {
                    $codigo_retorno = 15; // Nuevo código de error para atributos_especificos faltantes o inesperados
                    $mensaje = 'Error: Los atributos específicos de la categoría no se encontraron o no tienen un formato esperado.';
                    $datos_categoria = null; // Limpiar datos
                }
                // --- FIN: Nuevo bloque ELSE ---

                // Solo procedemos con el foreach si no se asignó un código de error y datos_categoria es válido
                if ($codigo_retorno === 0 && isset($datos_categoria['atributos_especificos']) && is_array($datos_categoria['atributos_especificos']))
                {
					foreach ($tipo_campos_a_verificar as $indice_tipo => $tipo)
					{
						foreach ($tipo as $indice_campo => $campo)
						{
							$indicador_existe_atributos_especificos = 0;
							$indicador_existe_wp_meli = 0;
					
							foreach ($datos_categoria['atributos_especificos'] as $indice_atributo => $atributo)
							{
								if ($campo == $atributo['name'])
								{
									$indicador_existe_atributos_especificos = 1;
									foreach ($this->vectorCamposWpMeli as $indice_campo_wp_meli => $campo_wp_meli)
									{
										if ($atributo['id'] == $campo_wp_meli['meli'])
										{
											$indicador_existe_wp_meli = 1;
											$campos_existen_wp_meli[] = $campo.'_'.$indice_tipo;
											break;
										}
									}   
									if ($indicador_existe_wp_meli == 0)
									{
										$campos_no_existen_wp_meli[] = $campo.'_'.$indice_tipo;
									}
								}
							}
							if ($indicador_existe_atributos_especificos == 0)
							{
								$campos_no_existen_atributos_especificos[] = $campo.'_'.$indice_tipo;
							}
						}
					}
                }
            }
            else
            {
                $codigo_retorno = $respuesta_api['codigo_retorno'];
                $mensaje = 'Error al obtener categoría: ' . $respuesta_api['mensaje'];
            }
        }

        $respuesta = [
            'codigo_retorno'  => $codigo_retorno,
            'mensaje'         => $mensaje,
            'id_categoria'    => $id_categoria,
            'datos_categoria' => $datos_categoria,
			'campos_existen_wp_meli' => $campos_existen_wp_meli,
			'campos_no_existen_wp_meli' => $campos_no_existen_wp_meli,
			'campos_no_existen_atributos_especifico' => $campos_no_existen_atributos_especificos
        ];

        wp_send_json($respuesta);
        exit;
    }
	
	/**
	 * Pausa o activa una publicación de Mercado Libre según el nuevo estatus deseado.
	 *
	 * @param int    $id_post_publicacion ID del post de WordPress de la publicación.
	 * @param string $nuevo_estatus Estatus deseado ('publish' para activar, 'disabled' para pausar).
	 * @param object $usuario Objeto de usuario de WordPress.
	 * @return array Un array con 'codigo_retorno' y 'mensaje'.
	 */
	public function pausar_activar_publicacion_meli($id_post_publicacion, $nuevo_estatus, $usuario)
	{
		$codigo_retorno = 0;
		$mensaje = 'Proceso exitoso';

		// 1. Verificar _ofiliaria_publicar_en_mercado_libre
		$indicador_publicar_mercado_libre = get_post_meta($id_post_publicacion, '_ofiliaria_publicar_en_mercado_libre', true);

		/*
		Se comentó para que cuando se deshabilite la publicación en Ofiliaria, se pueda pausar en Mercado Libre igualmente. Y cuando se habilite en Ofiliaria, se pueda activar en Mercado Libre, siempre y cuando exista el id_publicacion_meli y sin importar si la publicación está marcada o no para publicar en Mercado Libre
		if ($indicador_publicar_mercado_libre !== 'Sí')
		{
			$codigo_retorno = 1; // Error: Publicación no marcada para Mercado Libre
			$mensaje = 'La publicación no está configurada para ser publicada en Mercado Libre.';
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}
		*/

		// 2. Obtener el token de Mercado Libre
		$respuesta_obtener_token_meli = $this->obtener_token_meli($usuario->ID);

		if ($respuesta_obtener_token_meli['codigo_retorno'] !== 0)
		{
			$codigo_retorno = 2; // Error al obtener el token de Mercado Libre
			$mensaje = 'Error al obtener el token de Mercado Libre: ' . $respuesta_obtener_token_meli['mensaje'];
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}

		$token_meli = $respuesta_obtener_token_meli['token_meli'];

		// 3. Obtener el ID de publicación de Mercado Libre
		$id_publicacion_meli = get_post_meta($id_post_publicacion, '_ofiliaria_id_meli_publicacion', true);

		if (empty($id_publicacion_meli))
		{
			$codigo_retorno = 3; // Error: No se encontró ID de publicación de Mercado Libre
			$mensaje = 'No se encontró el ID de publicación de Mercado Libre asociado al post de WordPress.';
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}

		// 4. Obtener el estatus actual de la publicación en Mercado Libre
		$respuesta_api_meli_obtener_estatus = $this->enviar_solicitud_meli(
			'items/' . $id_publicacion_meli,
			'GET',
			[], // No hay datos en el cuerpo para GET
			true, // Requiere autenticación
			$token_meli
		);

		error_log("Respuesta API Mercado Libre (obtener estatus): " . print_r($respuesta_api_meli_obtener_estatus, true));

		$respuesta   = $respuesta_api_meli_obtener_estatus['respuesta']; 
		$codigo_http = $respuesta_api_meli_obtener_estatus['codigo'];
		$error_curl  = $respuesta_api_meli_obtener_estatus['error'];
		$success 	 = $respuesta_api_meli_obtener_estatus['success'];

		if ($respuesta === false) {
			$codigo_retorno = 4;
			$mensaje = 'Error al obtener el estatus de la publicación en Mercado Libre: ';	
			$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}
		elseif (!$success) {
			$codigo_retorno = 4;
			$respuesta_vector = json_decode($respuesta, true);
			$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
			$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
			$mensaje = 'Error al obtener el estatus de la publicación en Mercado Libre: ';
			$mensaje .= "Código $codigo_http: $msg_error";
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}
		else
		{
			$respuesta_vector = json_decode($respuesta, true);
			$estatus_actual_meli = $respuesta_vector['status'] ?? 'desconocido';
		}

		error_log("Estatus actual de la publicación en Mercado Libre: " . $estatus_actual_meli);

		// 5. Lógica para activar o pausar según $nuevo_estatus
		if ($nuevo_estatus === 'publish') // Intentar ACTIVAR la publicación
		{
			if ($estatus_actual_meli === 'paused')
			{
				$datos_actualizacion = ['status' => 'active'];
				$respuesta_api_meli_actualizar = $this->enviar_solicitud_meli(
					'items/' . $id_publicacion_meli,
					'PUT',
					$datos_actualizacion,
					true,
					$token_meli
				);

				error_log("Respuesta API Mercado Libre (activar publicación): " . print_r($respuesta_api_meli_actualizar, true));

				$respuesta   = $respuesta_api_meli_actualizar['respuesta']; 
				$codigo_http = $respuesta_api_meli_actualizar['codigo'];
				$error_curl  = $respuesta_api_meli_actualizar['error'];
				$success 	 = $respuesta_api_meli_actualizar['success'];

				if ($respuesta === false) {
					$codigo_retorno = 5;
					$mensaje = 'Error al activar la publicación en Mercado Libre: ';
					$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
					return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
				}
				elseif (!$success) {
					$codigo_retorno = 5;
					$respuesta_vector = json_decode($respuesta, true);
					$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
					$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
					$mensaje = 'Error al activar la publicación en Mercado Libre: ';
					$mensaje .= "Código $codigo_http: $msg_error";
					return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
				}
				else
				{
					$mensaje = 'Publicación activada exitosamente en Mercado Libre.';
				}
			}
			elseif ($estatus_actual_meli === 'active')
			{
				$codigo_retorno = 6; // Error: La publicación ya está activa
				$mensaje = 'La publicación ya se encuentra activa en Mercado Libre.';
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
			elseif (in_array($estatus_actual_meli, ['closed', 'not_yet_active', 'under_review', 'not_elegible', 'inactive']))
			{
				$codigo_retorno = 7; // Error: Estatus incompatible para activar
				$mensaje = 'No se puede activar la publicación. Estatus actual en Mercado Libre: ' . $estatus_actual_meli;
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
			else
			{
				$codigo_retorno = 8; // Error: Estatus desconocido para activar
				$mensaje = 'Estatus desconocido de la publicación en Mercado Libre para activar: ' . $estatus_actual_meli;
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
		}
		elseif ($nuevo_estatus === 'disabled') // Intentar PAUSAR la publicación
		{
			if ($estatus_actual_meli === 'active')
			{
				$datos_actualizacion = ['status' => 'paused'];
				$respuesta_api_meli_actualizar = $this->enviar_solicitud_meli(
					'items/' . $id_publicacion_meli,
					'PUT',
					$datos_actualizacion,
					true,
					$token_meli
				);

				error_log("Respuesta API Mercado Libre (pausar publicación): " . print_r($respuesta_api_meli_actualizar, true));

				$respuesta   = $respuesta_api_meli_actualizar['respuesta']; 
				$codigo_http = $respuesta_api_meli_actualizar['codigo'];
				$error_curl  = $respuesta_api_meli_actualizar['error'];
				$success 	 = $respuesta_api_meli_actualizar['success'];

				if ($respuesta === false) {
					$codigo_retorno = 9; // Error al pausar la publicación
					$mensaje = 'Error al pausar la publicación en Mercado Libre: ' . 
					$mensaje .= 'Error de conexión con el servidor de Mercado Libre (cURL): ' . $error_curl;	
					return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
				}
				elseif (!$success) {
					$codigo_retorno = 9;
					$respuesta_vector = json_decode($respuesta, true);
					$msg_error = isset($respuesta_vector['message']) ? $respuesta_vector['message'] : 'Error de API';
					$msg_error .=  isset($respuesta_vector['cause']) ? ', '.$respuesta_vector['cause'] : '';
					$mensaje = 'Error al pausar la publicación en Mercado Libre: ';
					$mensaje .= "Código $codigo_http: $msg_error";
					return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
				}
				else
				{
					$mensaje = 'Publicación pausada exitosamente en Mercado Libre.';
				}
			}
			elseif ($estatus_actual_meli === 'paused')
			{
				$codigo_retorno = 10; // Error: La publicación ya está pausada
				$mensaje = 'La publicación ya se encuentra pausada en Mercado Libre.';
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
			elseif (in_array($estatus_actual_meli, ['closed', 'not_yet_active', 'under_review', 'not_elegible', 'inactive']))
			{
				$codigo_retorno = 11; // Error: Estatus incompatible para pausar
				$mensaje = 'No se puede pausar la publicación. Estatus actual en Mercado Libre: ' . $estatus_actual_meli;
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
			else
			{
				$codigo_retorno = 12; // Error: Estatus desconocido para pausar
				$mensaje = 'Estatus desconocido de la publicación en Mercado Libre para pausar: ' . $estatus_actual_meli;
				return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
			}
		}
		else
		{
			$codigo_retorno = 13; // Error: Estatus deseado no válido
			$mensaje = 'Estatus deseado no válido. Debe ser "publish" o "disabled".';
			return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
		}

		// Si todo va bien, regresa el éxito
		return ['codigo_retorno' => $codigo_retorno, 'mensaje' => $mensaje];
	}
	    /**
     * Adds '(Infocasas)' to city names that exist in Infocasas.
     *
     * This function is hooked into the 'ofiliaria_city_select_label' filter.
     * It checks if a given city and state combination exists in the list
     * of locations provided by the Infocasas platform.
     *
     * @since    1.0.0
     * @param    string    $city_name      The name of the city.
     * @param    string    $state_name     The name of the state/province.
     * @return   string    The modified city name with '(Infocasas)' if it exists, otherwise the original name.
     */
    public function add_infocasas_label_to_city($city_name, $state_name) {
        // Cache the Infocasas locations to avoid repeated API calls during the page load.
        if (null === $this->departamentos_zonas_infocasas) {
            $this->departamentos_zonas_infocasas = $this->buscar_departamentos_zonas();
        }

        // If we couldn't fetch the locations or it's not an array, return the original name.
        if (empty($this->departamentos_zonas_infocasas) || !is_array($this->departamentos_zonas_infocasas)) {
            return $city_name;
        }

        // Normalize the input names for a case-insensitive and accent-insensitive comparison.
        $normalized_city = $this->normalizar_cadena($city_name);
        $normalized_state = $this->normalizar_cadena($state_name);

        foreach ($this->departamentos_zonas_infocasas as $location) {
            // Normalize the names from the Infocasas data.
            $normalized_infocasas_zona = $this->normalizar_cadena($location->zona);
            $normalized_infocasas_depto = $this->normalizar_cadena($location->departamento);

            // Check if both the city (zona) and state (departamento) match.
            if ($normalized_city === $normalized_infocasas_zona && $normalized_state === $normalized_infocasas_depto) {
                return $city_name . ' (Infocasas)';
            }
        }

        // If no match was found after checking all locations, return the original name.
        return $city_name;
    }

    /**
     * Checks if a given city and state combination is valid for Infocasas.
     *
     * @since    1.0.0
     * @access   private
     * @param    string    $city_name      The name of the city to check.
     * @param    string    $state_name     The name of the state/province.
     * @return   bool      True if the city is valid for Infocasas, false otherwise.
     */
    private function is_city_valid_for_infocasas($city_name, $state_name) {
        // Cache the Infocasas locations to avoid repeated API calls.
        if (null === $this->departamentos_zonas_infocasas) {
            $this->departamentos_zonas_infocasas = $this->buscar_departamentos_zonas();
        }

        // If we couldn't fetch the locations or it's not an array, assume it's not valid to be safe.
        if (empty($this->departamentos_zonas_infocasas) || !is_array($this->departamentos_zonas_infocasas)) {
            return false;
        }

        // Normalize the input names for a case-insensitive and accent-insensitive comparison.
        $normalized_city = $this->normalizar_cadena($city_name);
        $normalized_state = $this->normalizar_cadena($state_name);

        foreach ($this->departamentos_zonas_infocasas as $location) {
            // Normalize the names from the Infocasas data.
            $normalized_infocasas_zona = $this->normalizar_cadena($location->zona);
            $normalized_infocasas_depto = $this->normalizar_cadena($location->departamento);

            // Check if both the city (zona) and state (departamento) match.
            if ($normalized_city === $normalized_infocasas_zona && $normalized_state === $normalized_infocasas_depto) {
                return true; // Found a match
            }
        }

        // If no match was found after checking all locations, it's not valid.
        return false;
    }
	/**
 	* Extrae el ID de 11 caracteres de un link de YouTube (largo o corto)
 	*/
	private function extraer_youtube_id($url) {
		// Soporta: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID, etc.
		$pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i';
		if (preg_match($pattern, $url, $match)) {
			return $match[1];
		}
		return $url; // Si no hay match, devuelve lo que recibió por si ya era un ID
	}
}