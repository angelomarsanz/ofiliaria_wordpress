<?php
class WpResidence_Meta_Boxes {

    public function __construct() {
        add_action('add_meta_boxes', [$this, 'add_head_foot_metabox']);
        add_action('save_post', [$this, 'save_head_foot_metabox']);
    }

    public function add_head_foot_metabox() {
        add_meta_box(
            'wpestate_head_foot_metabox',
            esc_html__('Template Settings', 'wpresidence-core'),
            [$this, 'render_head_foot_metabox'],
            'wpestate-studio',
            'normal',
            'high'
        );
    }

    public function render_head_foot_metabox($post) {
        // Retrieve the current values
        $template = get_post_meta($post->ID, 'wpestate_head_foot_template', true);
        $position = get_post_meta($post->ID, 'wpestate_head_foot_position', true);

        // Nonce field for security
        wp_nonce_field('wpestate_save_head_foot_metabox', 'wpestate_head_foot_nonce');

        // Get the template types and location options
        $types = wpestate_desing_template_types();
        $location = wpestate_templates_selection_options();
        ?>

        <p>
            <label class="post-attributes-label">
                <?php esc_html_e('Template Type', 'wpresidence-core');?>
            </label>
        </p>
        <?php echo wpestate_template_create_select_field('wpestate_head_foot_template', $types, $template); ?>

        <p>
            <label class="post-attributes-label">
                <?php esc_html_e('Display Location', 'wpresidence-core');?>
            </label>
        </p>
        <?php echo wpestate_create_nested_select_field('wpestate_head_foot_position', $location, $position); ?>
        <?php
    }

    public function save_head_foot_metabox($post_id) {
        // Verify nonce
        if (!isset($_POST['wpestate_head_foot_nonce']) || !wp_verify_nonce($_POST['wpestate_head_foot_nonce'], 'wpestate_save_head_foot_metabox')) {
            return;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Sanitize and save the fields
        if (isset($_POST['wpestate_head_foot_template'])) {
            update_post_meta($post_id, 'wpestate_head_foot_template', sanitize_text_field($_POST['wpestate_head_foot_template']));
        }

        if (isset($_POST['wpestate_head_foot_position'])) {
            update_post_meta($post_id, 'wpestate_head_foot_position', sanitize_text_field($_POST['wpestate_head_foot_position']));
        }
    }
}
