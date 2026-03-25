<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'RSWCPdfPackingslips' ) ) {

	class RSWCPdfPackingslips {

		public static function init() {
			add_action( 'wpo_wcpdf_after_order_details', array( __CLASS__, 'display_earned_redeemed_message' ), 10, 2 );
			add_action( 'wpo_wcpdf_after_order_details', array( __CLASS__, 'display_gateway_redeemed_message' ), 10, 2 );
		}

		public static function display_earned_redeemed_message( $template, $order ) {
			if ( 'no' == get_option( 'rs_product_purchase_activated' ) ) {
				return;
			}
			/**
			 * Hook:rs_display_earn_messages_in_pdf.
			 *
			 * @since 1.0
			 */
			if ( ! apply_filters( 'rs_display_earn_messages_in_pdf', true ) ) {
				return;
			}

			// Getting Order details
			$order_object = srp_order_obj( $order );
			$order_id     = isset( $order_object['order_id'] ) ? $order_object['order_id'] : 0;
			$user_id      = isset( $order_object['order_userid'] ) ? $order_object['order_userid'] : 0;

			$points_data = new RS_Points_Data( $user_id );
			$available_points = $points_data->total_available_points();

			$earned_and_redeemed_point = get_earned_redeemed_points_message( $order_id, true );
			if ( ! srp_check_is_array( $earned_and_redeemed_point ) ) {
				return;
			}

			$earned_point   = implode( ',', array_keys( $earned_and_redeemed_point ) );
			$redeemed_point = implode( ',', array_values( $earned_and_redeemed_point ) );

			// Getting Earned/Redeeming messages in PDF.
			$replacemsgforearnedpoints = ! empty( $earned_point ) ? str_replace( '[earnedpoints]', round_off_type( $earned_point ), get_option( 'rs_msg_for_earned_points' ) ) : '';
			$replacemsgforearnedpoints = str_replace( '[available_points]', round_off_type( $available_points ), $replacemsgforearnedpoints );
			$replacemsgforredeempoints = ! empty( $redeemed_point ) ? str_replace( '[redeempoints]', $redeemed_point , get_option( 'rs_msg_for_redeem_points' ) ) : '';
			$replacemsgforredeempoints = str_replace( '[available_points]', round_off_type( $available_points ), $replacemsgforredeempoints );

			// Displaying Earned/Redeeming messages in PDF.
			if ( 'yes' == get_option( 'rs_enable_msg_for_earned_points' ) ) {
				if ( 'yes' == get_option( 'rs_enable_msg_for_redeem_points' ) ) {
					echo wp_kses_post( '<h3>' . $replacemsgforearnedpoints . '</h3><br>' );
					if ( 'reward_gateway' != $order->get_payment_method() ) {
						echo wp_kses_post( '<h3>' . $replacemsgforredeempoints . '</h3>' );
					}
				} else {
					echo wp_kses_post( '<h3>' . $replacemsgforearnedpoints . '</h3>' );
				}
			} elseif ( 'yes' == get_option( 'rs_enable_msg_for_redeem_points' ) ) {
				if ( 'reward_gateway' != $order->get_payment_method() ) {
					echo wp_kses_post( '<h3>' . $replacemsgforredeempoints . '</h3>' );
				}
			}
		}

		public static function display_gateway_redeemed_message( $template, $order ) {
			if ( 'no' == get_option( 'rs_gateway_activated' ) ) {
				return;
			}
			/**
			 * Hook:rs_display_earn_messages_in_pdf.
			 *
			 * @since 30.6.0
			 */
			if ( ! apply_filters( 'rs_display_gateway_redeemed_messages_in_pdf', true ) ) {
				return;
			}

			if ( 'reward_gateway' != $order->get_payment_method() ) {
				return;
			}

			// Getting Order details
			$order_object = srp_order_obj( $order );
			$order_id     = isset( $order_object['order_id'] ) ? $order_object['order_id'] : 0;
			$user_id      = isset( $order_object['order_userid'] ) ? $order_object['order_userid'] : 0;

			$points_data = new RS_Points_Data( $user_id );
			$available_points = $points_data->total_available_points();

			$redeemed_points = gateway_points( $order_id );

			if ( empty( $redeemed_points ) ) {
				return;
			}

			// Getting Earned/Redeeming messages in PDF.
			$replacemsgforredeempoints = str_replace( '[redeemed_points]', $redeemed_points , get_option( 'rs_msg_for_redeemed_points_through_gateway' ) );
			$replacemsgforredeempoints = str_replace( '[available_points]', round_off_type( $available_points ), $replacemsgforredeempoints );

			// Displaying Earned/Redeeming messages in PDF.
			if ( 'yes' == get_option( 'rs_enable_msg_for_redeemed_points_through_gateway' ) ) {
				echo wp_kses_post( '<h3>' . $replacemsgforredeempoints . '</h3>' );
			}
		}
	}

}

RSWCPdfPackingslips::init();
