<?php
/** MILLDONE
 * Agency and Developer Review Functions
 * src: libs\agency_developers_functions\agency_developers_functions.php
 * This file contains functions for handling functions for agencies and developers in the WpResidence theme.
 *
 * @package WpResidence
 * @subpackage functions
 * @since 1.0.0
 */





 add_action( 'wp_ajax_nopriv_wpestate_agency_listings', 'wpestate_agency_listings' );
 add_action( 'wp_ajax_wpestate_agency_listings', 'wpestate_agency_listings' );
 

/**
 * Handles AJAX requests for agent/agency/developer listings.
 * This function filters and returns property listings based on the selected term.
 * * @param object $_POST from ajax.
 * @return string The URL of the reviewer's profile image.
 */

 if( !function_exists('wpestate_agency_listings') ):

    function wpestate_agency_listings() {
        // Verify nonce for security
        check_ajax_referer('wpestate_developer_listing_nonce', 'security');

        // Retrieve and sanitize input data
        $prop_no = intval(wpresidence_get_option('wp_estate_prop_no', ''));
        $wpestate_options=array();
        $wpestate_options['content_class'] ='';

        if(isset($_POST['page_with_sidebar'])  && intval($_POST['page_with_sidebar'] )!== 1){
                // Set up options for display
                $wpestate_options = array(
                    'content_class' => 'col-lg-12',
                    'sidebar_class' => '',
                );
    
        }

        // if we have agency or developer
        if(isset($_POST['agency_id'])){
            $user_agency = intval($_POST['agency_id']);
            $agent_list = array_filter((array)get_user_meta($user_agency, 'current_agent_list', true));
            $agent_list[] = $user_agency;

        

        }else if( isset($_POST['agent_id'])){
            // if we have agent
            $agent_list[]=intval($_POST['agent_id']);
        }
   
        if(isset($agent_list) && is_array($agent_list)){
            $agent_list=array_filter($agent_list);
        }


        $term_name ='';
        if(isset($_POST['term_name'])){
            $term_name = sanitize_text_field($_POST['term_name']);
        }
    
        $is_agency = intval($_POST['is_agency']);
        $post_id = intval($_POST['post_id']);

        // Determine the correct taxonomy based on agency or developer
        $taxonomy = $is_agency ? 'property_action_category' : 'property_category';
        $action_array = array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term_name
        );

        // Set up the base query arguments
        $args = array(
            'post_type'      => 'estate_property',
            'posts_per_page' => $prop_no,
            'post_status'    => 'publish',
            'meta_key'       => 'prop_featured',
            'orderby'        => 'meta_value',
            'order'          => 'DESC',
        );

        // Add author or meta query based on agent list
        if (empty($agent_list)) {
            $args['meta_query'] = array(
                array(
                    'key'   => 'property_agent',
                    'value' => $post_id,
                ),
            );
        } else {
            $args['author__in'] = $agent_list;
        }

        // Add taxonomy query if a specific term is selected
        if ($term_name !== 'all' && $term_name !== '') {
            $args['tax_query'] = array(
                'relation' => 'AND',
                $action_array,
            );
        }

        // Handle offset for pagination
        if (isset($_POST['loaded']) && intval($_POST['loaded']) > 0) {
            $args['offset'] = intval($_POST['loaded']);
        }

     

        // Fetch the properties
        $prop_selection = wpestate_return_filtered_by_order($args);

        // Capture the HTML output
        ob_start();
        wpresidence_display_property_list_as_html($prop_selection, $wpestate_options, 'shortcode_list');
        $html_content = ob_get_clean();

        // Prepare the response
        $response = array(
            'success' => true,
            '$wpestate_options'=>  $wpestate_options ,
            'data' => array(
                'html' => $html_content,
                'found_posts' => $prop_selection->post_count,
                'max_num_pages' => $prop_selection->max_num_pages
            )
        );

        // Send JSON response
        wp_send_json($response);
    }
endif;
 
 



 
/**
 * Get the reviewer's profile image.
 *
 * This function retrieves the profile image of the reviewer, either from their agent profile
 * or their user meta. If no image is found, it returns a default image.
 *
 * @param object $comment The comment object.
 * @return string The URL of the reviewer's profile image.
 */
function wpresidence_agency_developer_get_reviewer_image($comment) {
    $userid_agent = get_user_meta($comment->user_id, 'user_agent_id', true);
    if ($userid_agent) {
        // If the user is an agent, get their profile picture
        $thumb_id = get_post_thumbnail_id($userid_agent);
        $preview = wp_get_attachment_image_src($thumb_id, 'thumbnail');
    } else {
        // If not an agent, try to get the user's custom picture
        $user_small_picture_id = get_the_author_meta('small_custom_picture', $comment->user_id, true);
        $preview = wp_get_attachment_image_src($user_small_picture_id, 'agent_picture_thumb');
    }
    // Return the image URL or a default image if none found
    return isset($preview[0]) ? $preview[0] : get_theme_file_uri('/img/default_user_agent.png');
}

/**
 * Generate the HTML template for a single review.
 *
 * This function creates the HTML structure for displaying a single review,
 * including the reviewer's image, name, rating, and review content.
 *
 * @param object $comment The comment object.
 * @param string $reviewer_name The name of the reviewer.
 * @param string $preview_img The URL of the reviewer's profile image.
 * @param int $rating The rating given by the reviewer.
 * @return string The HTML template for the review.
 */
function wpresidence_agency_developer_generate_review_template($comment, $reviewer_name, $preview_img, $rating) {
    $review_title = get_comment_meta($comment->comment_ID, 'review_title', true);
    ob_start();
    ?>
    <div class="listing-review">
        <div class="review-list-content norightpadding">
            <div class="reviewer_image" style="background-image: url(<?php echo esc_url($preview_img); ?>);"></div>
            <div class="reviwer-name"><?php echo esc_html__('Posted by ', 'wpresidence') . esc_html($reviewer_name); ?></div>
            <div class="review-title"><?php echo esc_html($review_title); ?></div>
            <div class="property_ratings">
                <?php echo wpresidence_agency_developer_generate_star_rating($rating); ?>
                <span class="ratings-star">(<?php echo esc_html($rating . ' ' . __('of', 'wpresidence') . ' 5'); ?>)</span>
            </div>
            <div class="review-date">
                <?php echo esc_html__('Posted on ', 'wpresidence') . get_comment_date('j F Y', $comment->comment_ID); ?>
            </div>
            <div class="review-content">
                <?php echo wp_kses_post($comment->comment_content); ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Generate HTML for star rating.
 *
 * This function creates the HTML for displaying a star rating,
 * using Font Awesome icons for filled and empty stars.
 *
 * @param int $rating The rating to display (1-5).
 * @return string The HTML for the star rating.
 */
function wpresidence_agency_developer_generate_star_rating($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= $i <= $rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
    }
    return $stars;
}

/**
 * Display the review submission form.
 *
 * This function outputs the HTML for the review submission form,
 * including the rating stars, title input, and review content textarea.
 *
 * @param string $review_type The type of review (e.g., 'Agency' or 'Developer').
 */
function wpresidence_agency_developer_display_review_form($review_type) {
    if (!is_user_logged_in()) {
        echo '<h5 class="review_notice">' . 
             esc_html__('You need to ', 'wpresidence') . 
             '<span id="login_trigger_modal">' . esc_html__('login', 'wpresidence') . '</span> ' . 
             esc_html__('in order to post a review ', 'wpresidence') . 
             '</h5>';
        return;
    }

    $current_user = wp_get_current_user();
    $userID = $current_user->ID;
    $user_comment = wpresidence_agency_developer_get_user_comment($userID, get_the_ID());

    $review_title = $user_comment ? get_comment_meta($user_comment->comment_ID, 'review_title', true) : '';
    $review_stars = $user_comment ? get_comment_meta($user_comment->comment_ID, 'review_stars', true) : '';
    $comment_content = $user_comment ? $user_comment->comment_content : '';

    // Output the review form HTML
    ?>
    <h5>
        <div class="review_tag">
            <?php 
            if ($user_comment) {
                echo esc_html(sprintf(__('Update %s Review ', 'wpresidence'), $review_type));
                if (wp_get_comment_status($user_comment->comment_ID) == 'unapproved') {
                    echo ' - ' . esc_html__('pending approval', 'wpresidence');
                }
            } else {
                echo esc_html(sprintf(__('Write a %s Review ', 'wpresidence'), $review_type));
            }
            ?>
        </div>
    </h5>
    <div class="add_review_wrapper">
        <!-- Rating stars -->
        <div class="rating">
            <span class="rating_legend"><?php esc_html_e('Your Rating & Review', 'wpresidence'); ?></span>
            <?php
            for ($i = 1; $i <= 5; $i++) {
                $selected = $i <= $review_stars ? ' starselected starselected_click' : '';
                echo '<span class="empty_star' . $selected . '"></span>';
            }
            ?>
        </div>
        <!-- Review title input -->
        <input type="text" id="wpestate_review_title" name="wpestate_review_title" value="<?php echo esc_attr($review_title); ?>" class="form-control" placeholder="<?php esc_attr_e('Review Title', 'wpresidence'); ?>">
        <!-- Review content textarea -->
        <textarea rows="8" id="wpestare_review_content" name="wpestare_review_content" class="form-control" placeholder="<?php esc_attr_e('Your Review', 'wpresidence'); ?>"><?php echo esc_textarea($comment_content); ?></textarea>
        <?php
        // Submit button
        if ($user_comment) {
            echo '<input type="submit" class="wpresidence_button col-md-3" id="edit_review" data-coment_id="' . esc_attr($user_comment->comment_ID) . '" data-listing_id="' . get_the_ID() . '" value="' . esc_attr__('Edit Review', 'wpresidence') . '">';
        } else {
            echo '<input type="submit" class="wpresidence_button col-md-3" id="submit_review" data-listing_id="' . get_the_ID() . '" value="' . esc_attr__('Submit Review', 'wpresidence') . '">';
        }

        // AJAX nonce for security
        $ajax_nonce = wp_create_nonce("wpestate_review_nonce");
        echo '<input type="hidden" id="wpestate_review_nonce" value="' . esc_attr($ajax_nonce) . '" />';
        ?>
    </div>
    <?php
}

/**
 * Get the user's existing comment for a post.
 *
 * This function retrieves the user's existing comment for a specific post,
 * if one exists.
 *
 * @param int $user_id The ID of the user.
 * @param int $post_id The ID of the post.
 * @return object|null The comment object if found, or null if not found.
 */
function wpresidence_agency_developer_get_user_comment($user_id, $post_id) {
    $comments = get_comments(array(
        'user_id' => $user_id,
        'post_id' => $post_id,
        'number' => 1,
        'status' => 'approve',
    ));
    return !empty($comments) ? $comments[0] : null;
}

/**
 * Get the name of the reviewer.
 *
 * This function determines the name to display for the reviewer,
 * which could be an admin, an agent, or a regular user.
 *
 * @param object $comment The comment object.
 * @return string The name of the reviewer.
 */
function wpresidence_agency_developer_get_reviewer_name($comment) {
    $userId = $comment->user_id;
    if ($userId == 1) {
        return "admin";
    }
    $userid_agent = get_user_meta($userId, 'user_agent_id', true);
    if ($userid_agent) {
        return get_the_title($userid_agent);
    }
    return $comment->comment_author;
}