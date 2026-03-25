<?php
class WpResidence_Custom_Columns {

    public function __construct() {
        add_filter('manage_edit-wpestate_head_foot_columns', [$this, 'customize_columns']);
        add_action('manage_posts_custom_column', [$this, 'populate_columns']);
        add_filter('manage_edit-wpestate_head_foot_sortable_columns', [$this, 'sortable_columns']);
    }

    public function customize_columns($columns) {
        $slice = array_slice($columns, 2, 2);
        unset($columns['comments']);
        unset($slice['comments']);
        $splice = array_splice($columns, 2);
        $columns['head_foot_price'] = esc_html__('Price', 'wpresidence-core');
        $columns['head_foot_for'] = esc_html__('Billing For', 'wpresidence-core');
        $columns['head_foot_type'] = esc_html__('Headers & Footers Type', 'wpresidence-core');
        $columns['head_foot_user'] = esc_html__('Purchased by User', 'wpresidence-core');
        $columns['head_foot_status'] = esc_html__('Status', 'wpresidence-core');
        return array_merge($columns, array_reverse($slice));
    }

    public function populate_columns($column) {
        $the_id = get_the_ID();
        if ('head_foot_price' == $column) {
            echo get_post_meta($the_id, 'item_price', true);
        }

        if ('head_foot_for' == $column) {
            echo get_post_meta($the_id, 'head_foot_type', true);
        }

        if ('head_foot_type' == $column) {
            echo get_post_meta($the_id, 'biling_type', true);
        }

        if ('head_foot_user' == $column) {
            $user_id = get_post_meta($the_id, 'buyer_id', true);
            $user_info = get_userdata($user_id);
            if (isset($user_info->user_login)) {
                echo esc_html($user_info->user_login);
            }
        }
        if ('head_foot_status' == $column) {
            $stat = get_post_meta($the_id, 'pay_status', 1);
            if ($stat == 0) {
                esc_html_e('Not Paid', 'wpresidence-core');
            } else {
                esc_html_e('Paid', 'wpresidence-core');
            }
        }
    }

    public function sortable_columns($columns) {
        $columns['head_foot_price'] = 'head_foot_price';
        $columns['head_foot_user'] = 'head_foot_user';
        $columns['head_foot_for'] = 'head_foot_for';
        $columns['head_foot_type'] = 'head_foot_type';
        $columns['head_foot_status'] = 'head_foot_status';
        return $columns;
    }
}
