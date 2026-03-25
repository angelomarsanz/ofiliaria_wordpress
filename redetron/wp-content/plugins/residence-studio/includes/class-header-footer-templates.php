<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WpResidence_Elementor_Header_Footer_Templates {

    public $header_footer_templates = [];

    public function __construct() {
        add_action('wp', [$this, 'initialize_header_footer_templates']);
    }

    /**
     * Initialize header and footer templates
     */
    public function initialize_header_footer_templates() {
        $this->header_footer_templates = $this->display_head_foot();
    }

    /**
     * Display custom Elementor header
     */
    public function display_custom_elementor_header() {
        $first_before_header_key = array_search('wpestate_template_before_header', $this->header_footer_templates);
        $wpestate_template_header = array_search('wpestate_template_header', $this->header_footer_templates);
        $wpestate_template_after_header = array_search('wpestate_template_after_header', $this->header_footer_templates);

        echo '<div class="wpestate_elementor_header_custom">';
        if ($first_before_header_key !== false) {
            $this->render_elementor_post($first_before_header_key);
        }
        if ($wpestate_template_header !== false) {
            $this->render_elementor_post($wpestate_template_header);
        }
        if ($wpestate_template_after_header !== false) {
            $this->render_elementor_post($wpestate_template_after_header);
        }
        echo '</div>';
    }
    
    
    /**
     * Display custom Elementor footer
     */
    public function display_custom_elementor_footer() {
        $first_before_footer_key        = array_search('wpestate_template_before_footer', $this->header_footer_templates);
        $wpestate_template_footer       = array_search('wpestate_template_footer', $this->header_footer_templates);
        $wpestate_template_after_footer = array_search('wpestate_template_after_footer', $this->header_footer_templates);

        echo '<div class="wpestate_elementor_footer_custom">';
            if ($first_before_footer_key !== false) {
                $this->render_elementor_post($first_before_footer_key);
            }
            if ($wpestate_template_footer !== false) {
                $this->render_elementor_post($wpestate_template_footer);
            }
            if ($wpestate_template_after_footer !== false) {
                $this->render_elementor_post($wpestate_template_after_footer);
            }
        echo '</div>';
    }
    
    
    
    
    
    
    
    
    
    /**
     * Render Elementor post content
     *
     * @param int $post_id The ID of the post to render.
     */
    public function render_elementor_post($post_id) {
        if (\Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor()) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($post_id);
        } else {
            echo apply_filters('the_content', get_post_field('post_content', $post_id));
        }
    }

    /**
     * Display header and footer based on conditions
     *
     * @return array The array of header and footer templates.
     */
    public function display_head_foot() {
        $conditions = $this->build_conditions_for_post();
        $args = array(
            'post_type' => 'wpestate-studio',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );

        $posts = get_posts($args);

        if (empty($posts)) {
            return [];
        }

        $return = array();
        foreach ($posts as $post) {
            $position = get_post_meta($post->ID, 'wpestate_head_foot_position', true);
            foreach ($conditions as $condition) {
                $condition_parts = explode(':', $condition['value']);
                $condition_base = $condition_parts[0];
                if ($position === 'standard-singulars' && is_singular() ||
                    $position === 'standard-archives' && is_archive() ||
                    $position === 'standard-global' ||
                    $condition_base === $position) {
                    $return[$post->ID] = get_post_meta($post->ID, 'wpestate_head_foot_template', true);
                    continue 2;
                }
            }
        }
        return array_unique($return);
    }

    /**
     * Build conditions for the current post or page
     *
     * @return array Array of conditions.
     */
    public function build_conditions_for_post() {
        $conditions = [];
        if (is_front_page()) {
            $conditions[] = ['type' => 'special', 'value' => 'front_page'];
        } elseif (is_home()) {
            $conditions[] = ['type' => 'special', 'value' => 'blog'];
        } elseif (is_404()) {
            $conditions[] = ['type' => 'special', 'value' => '404'];
        } elseif (is_search()) {
            $conditions[] = ['type' => 'special', 'value' => 'search'];
        } elseif (is_date()) {
            $conditions[] = ['type' => 'special', 'value' => 'date'];
        } elseif (is_author()) {
            $conditions[] = ['type' => 'special', 'value' => 'author'];
        } elseif (function_exists('is_shop') && is_shop()) {
            $conditions[] = ['type' => 'special', 'value' => 'woocommerce_shop'];
        }
        if (is_archive()) {
            $conditions[] = ['type' => 'archive', 'value' => 'archive'];
        }
        if (is_tax() || is_category() || is_tag()) {
            $taxonomy = get_queried_object();
            if ($taxonomy && !is_wp_error($taxonomy)) {
                $conditions[] = ['type' => 'taxonomy', 'value' => $taxonomy->taxonomy . ':' . $taxonomy->term_id];
            }
        }
        if (is_singular()) {
            $post = get_post();
            if (!empty($post->post_type)) {
                $conditions[] = ['type' => 'post_type', 'value' => $post->post_type];
            }
            $conditions[] = ['type' => 'specific', 'value' => $post->ID];
        }
        return $conditions;
    }

    /**
     * Helper function to remove and display information
     */
    public function wpestate_helper_remove() {
    
        global $post;    return;
        $post_id = isset($post->ID) ? $post->ID : null;
        $conditions = $this->build_conditions_for_post($post_id);

        echo '<pre style="margin-top:100px;"> for ' . $post_id;
        print_r($conditions);
        echo '</pre>';
        echo '<pre style="margin-top:100px;"> for id: ' . $post_id . '  ';
        print_r($this->header_footer_templates);

        foreach ($this->header_footer_templates as $key => $value) {
            print 'we show ' . get_the_title($key) . '</br>';
        }
        echo '</pre>';
    }
}
?>
