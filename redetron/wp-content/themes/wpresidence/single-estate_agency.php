<?php
/** MILLDONE
 * Single Agency Template
 * src: single-estate_agency.php
 * This template displays the single view of an agency in the WpResidence theme.
 * It includes agency details, listings, agents, reviews, and contact information.
 *
 * @package WpResidence
 * @subpackage Templates
 * @since 1.0.0
 */

get_header();

// Retrieve theme options and global variables
$wpestate_options = get_query_var('wpestate_options');
$show_compare     = 1;
$wpestate_options['content_class'] = 'col-lg-12';

// Start of HTML output
?>
<div class="wpresidence-content-container-wrapper col-12 d-flex flex-wrap">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="<?php echo esc_attr($wpestate_options['content_class']); ?>">
        <?php
        // Retrieve agency details
        $post = get_post();
        if ($post) {
            $agency_id = $post->ID;
            $thumb_id = get_post_thumbnail_id($agency_id);
            $preview = wp_get_attachment_image_src($thumb_id, 'property_listings');
            $preview_img = $preview[0] ?? '';
            
         
            
            $name = get_the_title($agency_id);
            $realtor_details = wpestate_return_agent_details($agency_id, $agency_id);

            // Rest of the code remains the same...
        ?>

        <div class="col-md-12">
            <div class="agency_content_wrapper flex-column flex-md-row">
                <div class="col-md-8 agency_content">
                    <h4><?php esc_html_e('About Us', 'wpresidence'); ?></h4>
                    <?php 
                    echo apply_filters('the_content', $post->post_content);
                    echo wpestate_return_agent_share_social_icons($realtor_details, 'agency_socialpage_wrapper', 'agency_social');
                    ?>
                </div>
                <div class="col-md-4 agency_tax">
                    <div class="agency_taxonomy">
                        <?php
                        $taxonomies = array('county_state_agency', 'city_agency', 'area_agency', 'category_agency', 'action_category_agency');
                        foreach ($taxonomies as $taxonomy) {
                            echo get_the_term_list($agency_id, $taxonomy, '', '', '');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
            // Include agency listings and agents
            include(locate_template('templates/agency_templates/agency_listings.php'));
            include(locate_template('templates/agency_templates/agency_developer_agents.php'));

            // Display reviews if enabled
            $wp_estate_show_reviews = wpresidence_get_option('wp_estate_show_reviews_block', '');
            if (is_array($wp_estate_show_reviews) && in_array('agency', $wp_estate_show_reviews, true)) {
                include(locate_template('templates/agency_templates/agency_developer_reviews.php'));
            }
        ?>

        <div class="agency_contact_container">
            <?php  
                include( locate_template('templates/agency_templates/agency_contact_form.php')); 
            ?>
        </div>


        <?php
        } else {
            // No agency found
            esc_html_e('No agency found.', 'wpresidence');
        }
        ?>
    </div>
</div>

<?php
include(locate_template('templates/agency_templates/agency_map.php'));
get_footer();
?>