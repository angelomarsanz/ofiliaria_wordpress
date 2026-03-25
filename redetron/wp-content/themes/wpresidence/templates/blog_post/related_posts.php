<?php
/** MILLDONE
 * Related Posts Template
 * src: templates\blog_post\related_posts.php
 * This template displays related posts based on shared tags.
 * It's designed to show a specified number of related posts with thumbnails.
 *
 * @package WPEstate
 * @subpackage Templates
 * @since 1.0
 * @version 2.0
 */

// Ensure this file is only used as part of a WordPress theme
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;
$wpestate_options = get_query_var('wpestate_options');



// Determine if we're using a full-width layout
$is_full_width = (sanitize_html_class($wpestate_options['content_class']) === 'col-md-12');

// Set the column class and number of posts to display based on layout and settings
$similar_posts_count = intval(wpresidence_get_option('wp_estate_similar_blog_post', 3));
$posts_to_show = $similar_posts_count == 3 ? ($is_full_width ? 3 : 2) : ($is_full_width ? 4 : 3);


//Dermine which column class we will use
$blog_unit_class_request    = wpestate_blog_unit_column_selector($wpestate_options,'similar','');
$blog_unit_class            = $blog_unit_class_request['col_class'];



// Get the tags of the current post
$tags = wp_get_post_tags($post->ID);

// Only proceed if the post has tags
if ($tags) {
    $tag_ids = wp_list_pluck($tags, 'term_id');

    // Set up the query arguments for related posts
    $args = array(
        'tag__in'           => $tag_ids,
        'post__not_in'      => array($post->ID),
        'posts_per_page'    => $posts_to_show,
        'post_status'       => 'publish',
        'orderby'           => 'rand',
        'meta_query'        => array(
            array(
                'key'     => '_thumbnail_id',
                'compare' => 'EXISTS'
            ),
        )
    );

    // Reset the main query
    wp_reset_query();

    // Execute the query
    $related_query = new WP_Query($args);

    // Check if there are related posts
    if ($related_query->have_posts()) : ?>

        <div class="related_posts row"> 
            <h3><?php esc_html_e('Related Posts', 'wpresidence'); ?></h3>   
            
          
                <?php
                // Loop through the related posts
                while ($related_query->have_posts()) :
                    $related_query->the_post();

                    // Only display posts with thumbnails
                    if (has_post_thumbnail()) :
                        ?>
                      
                        <?php include(locate_template('templates/blog_card_templates/blog_unit2.php')); ?>
                        
                    <?php
                    endif;
                endwhile;
                ?>
           
        </div>		
    <?php
    endif; // End if have posts

    // Reset the query
    wp_reset_postdata();
} // End if tags
?>