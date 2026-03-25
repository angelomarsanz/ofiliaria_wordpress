<?php
/*
 * Add/Debitar Saldo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit ; // Exit if accessed directly.
}
if ( ! class_exists( 'RSAddorRemovePoints' ) ) {

	class RSAddorRemovePoints {

		public static function init() {

			add_action( 'rs_default_settings_fprsaddremovepoints' , array( __CLASS__, 'set_default_value' ) ) ;

			add_action( 'woocommerce_rs_settings_tabs_fprsaddremovepoints' , array( __CLASS__, 'reward_system_register_admin_settings' ) ) ; // Call to register the admin settings in the Reward System Submenu with general Settings tab        

			add_action( 'woocommerce_update_options_fprsaddremovepoints' , array( __CLASS__, 'reward_system_update_settings' ) ) ; // call the woocommerce_update_options_{slugname} to update the reward system

			add_action( 'woocommerce_admin_field_rs_add_remove_remove_reward_points' , array( __CLASS__, 'rs_buttons_to_add_or_remove_points' ) ) ;

			add_action( 'woocommerce_admin_field_rs_inc_user_to_add_remove_points' , array( __CLASS__, 'rs_inc_user_to_add_remove_points' ) ) ;

			add_action( 'woocommerce_admin_field_rs_exc_user_to_add_remove_points' , array( __CLASS__, 'rs_exc_user_to_add_remove_points' ) ) ;

			add_action( 'woocommerce_admin_field_rs_datepicker_for_expiry' , array( __CLASS__, 'rs_datepicker_for_expiry' ) ) ;
		}

		/*
		 * Function label settings to Member Level Tab
		 */

		public static function reward_system_admin_fields() {
						/**
						 * Hook:woocommerce_fprsaddremovepoints_settings.
						 * 
						 * @since 1.0
						 */
			return apply_filters( 'woocommerce_fprsaddremovepoints_settings' , array(
				array(
					'type' => 'rs_modulecheck_start',
				),
				array(
					'name' => __( 'Acreditar/Remover Saldo por Usuario' , 'rewardsystem' ),
					'type' => 'title',
					'id'   => 'rs_add_remove_points_setting',
				),
				array(
					'name'    => __( 'Tipo de selección' , 'rewardsystem' ),
					'type'    => 'select',
					'id'      => 'rs_select_user_type',
					'newids'  => 'rs_select_user_type',
					'class'   => 'rs_select_user_type',
					'options' => array(
						'1' => __( 'Todos' , 'rewardsystem' ),
						'2' => __( 'Incluir Usuarios' , 'rewardsystem' ),
						'3' => __( 'Excluir Usuarios' , 'rewardsystem' ),
						'4' => __( 'Incluir Roles' , 'rewardsystem' ),
						'5' => __( 'Excluir Roles' , 'rewardsystem' ),
					),
					'std'     => '1',
					'default' => '1',
				),
				array(
					'type' => 'rs_inc_user_to_add_remove_points',
				),
				array(
					'type' => 'rs_exc_user_to_add_remove_points',
				),
				array(
					'name'        => __( 'Seleccionar roles a incluir' , 'rewardsystem' ),
					'id'          => 'rs_select_to_include_customers_role',
					'css'         => 'min-width:343px;',
					'std'         => '',
					'default'     => '',
					'placeholder' => 'Buscar por Rol de Usuario',
					'type'        => 'multiselect',
					'options'     => fp_user_roles(),
					'newids'      => 'rs_select_to_include_customers_role',
					'desc_tip'    => false,
				),
				array(
					'name'     => __( 'Seleccionar roles de Usuario a excluir' , 'rewardsystem' ),
					'id'       => 'rs_select_to_exclude_customers_role',
					'css'      => 'min-width:343px;',
					'std'      => '',
					'default'  => '',
					'type'     => 'multiselect',
					'options'  => fp_user_roles(),
					'newids'   => 'rs_select_to_exclude_customers_role',
					'desc_tip' => false,
				),
				array(
					'name'              => __( 'Saldo a Actualizar' , 'rewardsystem' ),
					'type'              => 'number',
					'id'                => 'rs_reward_addremove_points',
					'newids'            => 'rs_reward_addremove_points',
					'class'             => 'rs_reward_addremove_points',
					'std'               => '',
					'default'           => '',
					'custom_attributes' => array(
						'min' => 0,
					),
				),
				array(
					'name'    => __( 'Descripción/Referencia' , 'rewardsystem' ),
					'type'    => 'textarea',
					'id'      => 'rs_reward_addremove_reason',
					'newids'  => 'rs_reward_addremove_reason',
					'class'   => 'rs_reward_addremove_reason',
					'std'     => '',
					'default' => '',
				),
				array(
					'name'    => __( 'Tipo de Selección' , 'rewardsystem' ),
					'type'    => 'select',
					'id'      => 'rs_reward_select_type',
					'newids'  => 'rs_reward_select_type',
					'class'   => 'rs_reward_select_type',
					'options' => array(
						'1' => __( 'Acreditar Saldo' , 'rewardsystem' ),
						'2' => __( 'Debitar Saldo' , 'rewardsystem' ),
					),
					'std'     => '1',
					'default' => '1',
				),
				array(
					'type' => 'rs_datepicker_for_expiry',
				),
				array(
					'name'    => __( 'Enviar notificación de Email para informar sobre el cambio' , 'rewardsystem' ),
					'type'    => 'checkbox',
					'id'      => 'send_mail_add_remove_settings',
					'newids'  => 'send_mail_add_remove_settings',
					'class'   => 'send_mail_add_remove_settings',
					'std'     => 'no',
					'default' => 'no',
				),
				 array(
					'name'    => __( 'Tipo de Email' , 'rewardsystem' ),
					'type'    => 'select',
					'id'      => 'rs_add_point_email_type',
					'newids'  => 'rs_add_point_email_type',
					'class'   => 'rs_add_point_email_type',
					'options' => array(
						'1' => __( 'WooCommerce Template' , 'rewardsystem' ),
						'2' => __( 'Plain Text' , 'rewardsystem' ),
					),
					'std'     => '1',
					'default' => '1',
				),
				array(
					'name'    => __( 'Asunto' , 'rewardsystem' ),
					'type'    => 'textarea',
					'id'      => 'rs_email_subject_message',
					'newids'  => 'rs_email_subject_message',
					'class'   => 'rs_email_subject_message',
					'std'     => 'Notificación de Acreditación de Saldo Ofiliaria',
					'default' => 'Notificación de Acreditación de Saldo Ofiliaria',
				),
				array(
					'name'    => __( 'Mensaje' , 'rewardsystem' ),
					'type'    => 'textarea',
					'id'      => 'rs_email_message',
					'newids'  => 'rs_email_message',
					'class'   => 'rs_email_message',
					'std'     => 'Hola [username],<br/><br/><b>$ [rs_earned_points]</b> UYU han sido acreditados en tu cuenta por el equipo administrativo de Ofiliaria.<br/><b> El saldo actual disponible en tu cuenta ahora es de: $ [balance_points] UYU. Visita tu cuenta: [my_account_page] para ver más detalles.<br/><br/>Saludos cordiales',
					'default' => 'Hola [username],<br/><br/><b>$ [rs_earned_points]</b> UYU han sido acreditados en tu cuenta por el equipo administrativo de Ofiliaria.<br/><b> El saldo actual disponible en tu cuenta ahora es de: $ [balance_points] UYU. Visita tu cuenta: [my_account_page] para ver más detalles.<br/><br/>Saludos cordiales',
				),
				array(
					'name'    => __( 'Enviar notificación de e-mail para informar sobre debito de saldo' , 'rewardsystem' ),
					'type'    => 'checkbox',
					'id'      => 'send_mail_settings',
					'newids'  => 'send_mail_settings',
					'class'   => 'send_mail_settings',
					'std'     => 'no',
					'default' => 'no',
				),
				array(
					'name'    => __( 'Tipo de Email' , 'rewardsystem' ),
					'type'    => 'select',
					'id'      => 'rs_remove_point_email_type',
					'newids'  => 'rs_remove_point_email_type',
					'class'   => 'rs_remove_point_email_type',
					'options' => array(
						'1' => __( 'WooCommerce Template' , 'rewardsystem' ),
						'2' => __( 'Plain Text' , 'rewardsystem' ),
					),
					'std'     => '1',
					'default' => '1',
				),
				array(
					'name'    => __( 'Asunto' , 'rewardsystem' ),
					'type'    => 'textarea',
					'id'      => 'rs_email_subject_for_remove',
					'newids'  => 'rs_email_subject_for_remove',
					'class'   => 'rs_email_subject_for_remove',
					'std'     => 'Notificación de Actualización de tu Saldo Ofiliaria',
					'default' => 'Notificación de Actualización de tu Saldo Ofiliaria',
				),
				array(
					'name'    => __( 'Mensaje' , 'rewardsystem' ),
					'type'    => 'textarea',
					'id'      => 'rs_email_message_for_remove',
					'newids'  => 'rs_email_message_for_remove',
					'class'   => 'rs_email_message_for_remove',
					'std'     => 'Hola [username],<br/></br/><b>$ [rs_deleted_points] UYU</b> Han sido debitados de tu cuenta Ofiliaria por nuestro equipo de administración.<br/> El saldo total disponible en tu cuenta es de $ [balance_points] UYU. Puedes visitar tu cuenta en ofiliaria: [my_account_page] Para conocer más detalles.<br/><br/>Saludos cordiales',
					'default' => 'Hola [username],<br/></br/><b>$ [rs_deleted_points] UYU</b> Han sido debitados de tu cuenta Ofiliaria por nuestro equipo de administración.<br/> El saldo total disponible en tu cuenta es de $ [balance_points] UYU. Puedes visitar tu cuenta en ofiliaria: [my_account_page] Para conocer más detalles.<br/><br/>Saludos cordiales',
				),
				array(
					'type' => 'rs_add_remove_remove_reward_points',
				),
				array( 
					'type' => 'sectionend', 
					'id' => 'rs_add_remove_points_setting', 
				),
				array(
					'name' => __( 'Variables para el Email' , 'rewardsystem' ),
					'type' => 'title',
					'id'   => 'rs_email_shortcodes',
				),
				array(
					'type' => 'title',
					'desc' =>__('<b>[username]</b> - Mostrar nombre de usuario<br><br>'
					. '<b>[rs_earned_points]</b> - Muestra el Saldo acreditado<br><br>'
					. '<b>[balance_points]</b> - Muestra el saldo actual disponible<br><br>'
										. '<b>[site_name]</b> - Nombre del sitio web<br><br>'
										. '<b>[rs_expiry]</b> - Muestra fecha de vencimiento del saldo (sólo si el vencimiento está activo)<br><br>'
										. '<b>[rs_deleted_points]</b> - Muestra el Saldo Debitado<br><br>'
					. '<b>[my_account_page]</b> - Muestra la URL para ir a la página de "Mi Cuenta"<br><br>', 'rewardsystem'),
				),
								array(
					'type' => 'title',
					'desc' => __('<b>Nota:</b> <br/>Recomendamos no usar los códigos cortos anteriores en ningún lugar de su sitio. Solo se mostrará el valor en el lugar predefinido.<br/> Por favor verifique utilizando los códigos cortos disponibles en la Pestaña <b>Shortcodes (Códigos Cortos) </b> para usar las variables globales.', 'rewardsystem'),
					'id'   => 'rs_shortcode_note_gift_voucher',
				),
				array( 'type' => 'sectionend', 'id' => 'rs_email_shortcodes' ),
				array(
					'type' => 'rs_modulecheck_end',
				),
					) ) ;
		}

		/**
		 * Registering Custom Field Admin Settings of SUMO Reward Points in woocommerce admin fields funtion
		 */
		public static function reward_system_register_admin_settings() {
			woocommerce_admin_fields( self::reward_system_admin_fields() ) ;
		}

		/**
		 * Update the Settings on Save Changes may happen in SUMO Reward Points
		 */
		public static function reward_system_update_settings() {
			woocommerce_update_options( self::reward_system_admin_fields() ) ;
		}

		public static function set_default_value() {
			foreach ( self::reward_system_admin_fields() as $setting ) {
				if ( isset( $setting[ 'newids' ] ) && isset( $setting[ 'std' ] ) ) {
					add_option( $setting[ 'newids' ] , $setting[ 'std' ] ) ;
				}
			}
		}

		public static function rs_inc_user_to_add_remove_points() {
			$incfield_id    = 'rs_select_to_include_customers' ;
			$incfield_label = esc_html__( 'Seleccionar Usuarios a incluir' , 'rewardsystem' ) ;
			$getincuser     = get_option( 'rs_select_to_include_customers' ) ;
			echo do_shortcode(user_selection_field( $incfield_id , $incfield_label , $getincuser ) );
		}

		public static function rs_exc_user_to_add_remove_points() {
			$excfield_id    = 'rs_select_to_exclude_customers' ;
			$excfield_label = esc_html__( 'Seleccionar Usuarios a Excluir' , 'rewardsystem' ) ;
			$getexcuser     = get_option( 'rs_select_to_exclude_customers' ) ;
			echo do_shortcode(user_selection_field( $excfield_id , $excfield_label , $getexcuser ) );
		}

		public static function rs_datepicker_for_expiry() {
			?>
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label for="rs_expired_date"><?php esc_html_e( 'Vence el' , 'rewardsystem' ) ; ?></label>
				</th>
				<td class="forminp forminp-select">
					<input type="text" class="rs_expired_date" value="" name="rs_expired_date" id="rs_expired_date" />                                
				</td>
			</tr>
			<?php
		}

		public static function rs_buttons_to_add_or_remove_points() {
			?>
			<tr valign='top'>
				<td>
					<input type='button' name='rs_remove_points' id='rs_remove_points'  class='button-primary' value='<?php esc_html_e('Debitar Saldo', 'rewardsystem'); ?>'/>                            
					<img class="gif_rs_sumo_reward_button_for_remove" src="<?php echo esc_url(SRP_PLUGIN_DIR_URL) ; ?>/assets/images/update.gif"/>
				</td>
				<td>
					<input type='button' name='rs_add_points' id='rs_add_points' class='button-primary rs_button' value='<?php esc_html_e('Acreditar Saldo', 'rewardsystem'); ?>'/>
					<img class="gif_rs_sumo_reward_button_for_add" src="<?php echo esc_url(SRP_PLUGIN_DIR_URL) ; ?>/assets/images/update.gif"/><br>
				</td>
			</tr>
			<?php
		}
	}

	RSAddorRemovePoints::init() ;
}
