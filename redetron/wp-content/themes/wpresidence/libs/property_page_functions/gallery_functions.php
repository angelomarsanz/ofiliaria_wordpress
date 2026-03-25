<?php

/**
 * Generates an array of image attachment IDs for a given property.
 *
 * This function retrieves all image attachments associated with a specific property
 * and returns their IDs in an array. The images are ordered by their menu order in ascending order.
 *
 * @param int $propID The ID of the property for which to retrieve image attachment IDs.
 * @return array An array of image attachment IDs.
 */

 function wpestate_generate_property_slider_image_ids($propID,$include_thumbnail=false) {
    // Check if the wpestate_property_gallery meta exists
    $gallery_meta = get_post_meta($propID, 'wpestate_property_gallery', true);

    if (!empty($gallery_meta)) {


        if(is_string($gallery_meta)){
            $gallery_meta = array_filter( explode(',', $gallery_meta));
        }
    

        // If include_thumbnail is true, add the post thumbnail ID at the beginning of the array
        if ($include_thumbnail) {
            $thumbnail_id = get_post_thumbnail_id($propID);
            if ($thumbnail_id) {
                array_unshift($gallery_meta, $thumbnail_id);
            }
        }

        // enforce unique values
        $gallery_meta= array_unique(   $gallery_meta);
      

        // If meta exists, return it as an array
        return $gallery_meta;
    }

    // If meta doesn't exist, fetch attachments
    $arguments = array(
        'numberposts' => -1,
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'post_parent' => $propID,
        'post_status' => null,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'fields' => 'ids' // Return only the IDs
    );

    $post_attachments = get_posts($arguments);

    // If we have attachments, save them as post meta
    if (!empty($post_attachments)) {

        $gallery_meta = implode(',', $post_attachments);
        update_post_meta($propID, 'wpestate_property_gallery', $gallery_meta);
    } else {
     
        // If no attachments found, save an empty string to prevent future queries
        update_post_meta($propID, 'wpestate_property_gallery', '');
        $post_attachments = array(); // Ensure we return an empty array

        // If include_thumbnail is true, add the post thumbnail ID at the beginning of the array
        if ($include_thumbnail) {
            $thumbnail_id = get_post_thumbnail_id($propID);
            if ($thumbnail_id) {
                array_unshift($post_attachments, $thumbnail_id);
            }
        }
    }




    return $post_attachments;
}




    
    
/**
 * WpResidence Slider Pieces Builder
 *
 * This function builds the media section for property pages, including sliders, maps, videos, and virtual tours.
 *
 * @package WpResidence
 * @subpackage PropertyFunctions
 * @version 1.0
 * 
 * @uses wpresidence_get_option()
 * @uses wpestate_vertical_slider_content()
 * @uses wpestate_horizontal_slider_content()
 * @uses wpestate_classic_slider_content()
 * @uses wpestate_listing_full_width_slider_content()
 * @uses wpestate_slider_enable_maps_v2()
 * @uses wpestate_slider_enable_video()
 * @uses wpestate_slider_enable_virtual()
 * 
 * @param int $postID The ID of the property post.
 * @param string $slider_size The size of the slider.
 * @param string $slider_type The type of slider (vertical, horizontal, classic, full_slider).
 * @return string HTML for the media section.
 */

 if (!function_exists('wpestate_slider_pieces_buider')):
    function wpestate_slider_pieces_buider($postID, $slider_size, $slider_type) {



        $wp_estate_media_buttons_order_items = wpresidence_get_option('wp_estate_media_buttons_order_items', '');
        if (empty($wp_estate_media_buttons_order_items['enabled'])) {
            return '';
        }

        unset($wp_estate_media_buttons_order_items['enabled']['placebo'], $wp_estate_media_buttons_order_items['enabled']['0']);

        $return = '';
        $style_css = "block";
        $map_included = false;

        foreach ($wp_estate_media_buttons_order_items['enabled'] as $key => $value) {
            switch ($key) {
                case 'image':
                    switch ($slider_type) {
                        case 'classic':
                            $return .= wpestate_classic_slider_content($postID, $slider_size, $style_css);
                            break;
                        case 'vertical':
                            $return .= wpestate_vertical_slider_content($postID, $slider_size, $style_css);
                            break;
                        case 'horizontal':
                            $return .= wpestate_horizontal_slider_content($postID, $slider_size, $style_css);
                            break;
                       
                        case 'full_slider':
                            $return .= wpestate_listing_full_width_slider_content($postID, $slider_size, $style_css);
                            break;
                    }
                    break;
                case 'map':
                case 'street':
                    if (!$map_included) {
                        $return .= wpestate_slider_enable_maps_v2($postID, $style_css);
                        $map_included = true;
                    }
                    break;
                case 'video':
                    $return .= wpestate_slider_enable_video($postID, $style_css);
                    break;
                case 'virtual_tour':
                    $return .= wpestate_slider_enable_virtual($postID, $style_css);
                    break;
            }
            $style_css = 'none';
        }

        $first_key = array_key_first($wp_estate_media_buttons_order_items['enabled']);
        if ($first_key === 'map') {
            $return .= "
            <script type='text/javascript'>
                jQuery(document).ready(function(){
                    setTimeout(function() { wpestate_control_media_emable_map(); }, 1000);
                });
            </script>";
        } elseif ($first_key === 'street') {
            $return .= "
            <script type='text/javascript'>
                jQuery(document).ready(function(){
                    setTimeout(function() { jQuery('#slider_enable_street').trigger('click'); }, 1000);
                });
            </script>";
        }

        return $return;
    }
endif;




/**
 * Generate full-width slider wrapper for a property listing
 *
 * @param int    $post_id     The ID of the property post
 * @param string $slider_size The size/style of the slider (default: 'listing_full_slider_1')
 */

if ( ! function_exists( 'wpestate_listing_full_width_slider' ) ) :

    function wpestate_listing_full_width_slider( $post_id, $slider_size = 'listing_full_slider_1' ) {
        // Sanitize inputs
        $post_id = intval( $post_id );
        $slider_size = sanitize_html_class( $slider_size );

        // Open the main wrapper div
        echo '<div class="wpestate_property_media_section_wrapper wpestate_full_width_slider_wrapper wpestate_' . esc_attr( $slider_size ) . '">';
        
        // Display property status
        echo wpestate_return_property_status( $post_id, 'horizontalstatus' );
        
        // Display media control buttons
        echo wpestate_control_media_buttons( $post_id );
        
        // Generate and display the slider content
        echo wpestate_slider_pieces_buider( $post_id, $slider_size, 'full_slider' );
        
        // Close the main wrapper div
        echo '</div>';
    }
endif;



 /**
 * Generate full-width slider content for a property listing
 *
 * @param int    $post_id     The ID of the property post
 * @param string $slider_size The size of the slider images (default: 'full')
 * @param string $style_css   Additional CSS for the slider container (default: '')
 * @return string HTML markup for the slider
 */

 if ( ! function_exists( 'wpestate_listing_full_width_slider_content' ) ) :
   
    function wpestate_listing_full_width_slider_content( $post_id, $slider_size = 'full', $style_css = '' ) {
        // Get all attachment IDs for the property
        $post_attachments = wpestate_generate_property_slider_image_ids( $post_id, true );
        
        // Initialize variables
        $counter_lightbox = 0;
        $items = '';
        $indicator = '';

        // Process all slides
        foreach ( $post_attachments as $index => $attachment_id ) {
            // Check if the attachment is an image
            if ( ! wp_attachment_is_image( $attachment_id ) ) {
                continue;
            }

            $full_image = wp_get_attachment_image_src( $attachment_id, $slider_size );
            $thumb = wp_get_attachment_image_src( $attachment_id, 'slider_thumb' );
            
            $full_image_url = isset( $full_image[0] ) ? $full_image[0] : '';
            $thumb_url = isset( $thumb[0] ) ? $thumb[0] : '';
            
            // Generate HTML for the slide
            $active_class = $index === 0 ? ' active' : '';
            $items .= '<div class="carousel-item ' . $active_class . '">
                <div class="propery_listing_main_image lightbox_trigger" style="background-image:url(' . esc_url( $full_image_url ) . ')" data-slider-no="' . $counter_lightbox . '"></div>
                <div class="carousel-caption"></div>
            </div>';
            
            // Generate HTML for the indicator
            $active_class = $index === 0 ? ' class="active" aria-current="true"' : '';
            $indicator .= ' <button type="button" data-bs-target="#carousel-property-page-header" data-bs-slide-to="' . $counter_lightbox . '"' . $active_class . ' aria-label="Slide ' . ($counter_lightbox ) . '">
                <div class="carousel-property-page-header-overalay"></div>
                <img src="' . esc_url( $thumb_url ) . '" alt="Property Thumbnail">
            </button>';

            
            $counter_lightbox++;
        }
        
        // Construct the final HTML structure
        $slider_html = '<div class="wpestate_property_slider_v3 wpestate_property_carousel wpestate_property_slider_thing" style="display:' . esc_attr( $style_css ) . '">
            <div id="carousel-property-page-header" class="carousel slide propery_listing_main_image" >
                <div class="carousel-inner" role="listbox">' . $items . '</div>
                <div class="carousel-indicators-wrapper-header-prop">
                    <div class="carousel-indicators">' . $indicator . '</div>
                </div>
                <button class="carousel-control-prev wpresidence-carousel-control" type="button" data-bs-target="#carousel-property-page-header" data-bs-slide="prev">
                    <i class="demo-icon icon-left-open-big"></i>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next wpresidence-carousel-control" type="button" data-bs-target="#carousel-property-page-header" data-bs-slide="next">
                    <i class="demo-icon icon-right-open-big"></i>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>';
        
        return $slider_html;
    }
endif;





/**
 * Generate a multi-image slider for a property listing
 *
 * @param int    $prop_id        The ID of the property post
 * @param string $slider_size    The size of the slider images
 * @param int    $display_slides The number of slides to display (default: 3)
 */

if ( ! function_exists( 'wpestate_multi_image_slider' ) ) :

    function wpestate_multi_image_slider( $prop_id, $slider_size, $display_slides = 3 ) {
        // Enqueue required JavaScript
        wp_enqueue_script( 'slick.min' );

        // Get all attachment IDs for the property
        $post_attachments = wpestate_generate_property_slider_image_ids( $prop_id, true );

        // Initialize variables
        $counter_lightbox = 0;
        $items = '';

  
        // Process additional images
        foreach ( $post_attachments as $attachment_id ) {

            if (!wp_attachment_is_image($attachment_id)) {
                continue; // Skip this attachment if it's not an image
            }

            $counter_lightbox++;
            $preview = wp_get_attachment_image_src( $attachment_id, $slider_size );
            $attachment = get_post( $attachment_id );

            $items .= '<div class="item">';
            $items .= '<div class="multi_image_slider_image lightbox_trigger" data-slider-no="' . esc_attr( $counter_lightbox ) . '" style="background-image:url(' . esc_url( $preview[0] ) . ')"></div>';
            $items .= '<div class="carousel-caption">';
            
            if ( $attachment->post_excerpt !== '' ) {
                $items .= '<div class="carousel-caption_underlay"></div>';
                $items .= '<div class="carousel_caption_text">' . esc_html( $attachment->post_excerpt ) . '</div>';
            }
            
            $items .= '</div></div>';
        }

        // Output HTML structure
        ?>
        <div class="property_multi_image_slider" data-auto="0">
            <?php echo $items; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped earlier ?>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                wpestate_enable_slick_theme_slider(<?php echo intval( $display_slides ); ?>);
            });
        </script>
        <?php
    }
endif;



/**
 * Renders a classic slider for a property.
 *
 * @param int $postID The ID of the property post.
 * @param string $slider_size The size of the slider. Default is "listing_full_slider_1".
 */
if (!function_exists('wpestate_classic_slider')):
    function wpestate_classic_slider($postID, $slider_size = "listing_full_slider_1") {
        $wrapper_class = sprintf('wpestate_property_media_section_wrapper wpestate_classic_slider_wrapper wpestate_%s', esc_attr($slider_size));
        ?>
        <div class="<?php echo $wrapper_class; ?>">
            <?php
            echo wpestate_return_property_status($postID, 'horizontalstatus');
            echo wpestate_control_media_buttons($postID);
            echo wpestate_slider_pieces_buider($postID, $slider_size, 'classic');
            ?>
        </div>
        <?php
    }
endif;




/**
 * Renders a vertical slider for a property.
 *
 * @param int $postID The ID of the property post.
 * @param string $slider_size The size of the slider. Default is "full".
 */
if (!function_exists('wpestate_vertical_slider')):
    function wpestate_vertical_slider($postID, $slider_size = "full") {
        ?>
        <div class="wpestate_property_media_section_wrapper">
            <?php
            echo wpestate_return_property_status($postID, 'verticalstatus');
            echo wpestate_control_media_buttons($postID);
            echo wpestate_slider_pieces_buider($postID, $slider_size, 'vertical');
            ?>
        </div>
        <?php
    }
endif;




/**
 * Renders a horizontal slider for a property.
 *
 * @param int $postID The ID of the property post.
 * @param string $slider_size The size of the slider. Default is "full".
 */
if (!function_exists('wpestate_horizontal_slider')):
    function wpestate_horizontal_slider($postID, $slider_size = "full") {
        $wrapper_class = sprintf('wpestate_property_media_section_wrapper wpestate_horizontal_slider_wrapper wpestate_%s', esc_attr($slider_size));
        ?>
        <div class="<?php echo $wrapper_class; ?>">
            <?php
            echo wpestate_return_property_status($postID, 'horizontalstatus');
            echo wpestate_control_media_buttons($postID);
            echo wpestate_slider_pieces_buider($postID, $slider_size, 'horizontal');
            ?>
        </div>
        <?php
    }
endif;




/**
 * WpResidence Vertical Slider Content Generator
 *
 * The wpestate_vertical_slider_content function, which generates
 * the HTML content for a vertical property slider in the WpResidence theme.
 *
 * @package WpResidence
 * @subpackage PropertyMedia
 * @version 1.0
 * 
 * @uses wpestate_slider_slide_generation()
 * @uses wpresidence_get_option()
 * 
 * Dependencies:
 * - WordPress core functions
 * - WpResidence theme-specific functions
 * 
 */

 if (!function_exists('wpestate_vertical_slider_content')):
    function wpestate_vertical_slider_content($postId, $slider_size, $style_css) {
        // Generate slider components
        $post_attachments = wpestate_generate_property_slider_image_ids($postId, true);
        $slider_components = wpestate_slider_slide_generation($post_attachments, $slider_size);

        // Determine map type and corresponding class
        $wp_estate_kind_of_map = esc_html(wpresidence_get_option('wp_estate_kind_of_map', ''));
        $wp_estate_kind_of_map = ($wp_estate_kind_of_map == 2) ? 'open_street' : $wp_estate_kind_of_map;
        $wp_estate_kind_of_map_class = $wp_estate_kind_of_map . '_carousel';

        // Start building the HTML output
        ob_start();
        ?>
        <div  style="display:<?php echo esc_attr($style_css); ?>" 
             class="wpestate_property_carousel wpestate_property_slider_thing slide post-carusel carouselvertical <?php echo esc_attr($wp_estate_kind_of_map_class); ?>" 
             data-touch="true" data-interval="false">

            <!-- Wrapper for slides -->
            <div class="carousel-inner owl-carousel owl-theme carouselvertical" id="property_slider_carousel">
                <?php echo trim($slider_components['slides']); ?>
            </div>

            <!-- Indicators -->
            <ol id="carousel-indicators-vertical" class="carousel-indicators-vertical">
                <?php echo trim($slider_components['indicators']); ?>
            </ol>

            <div class="caption-wrapper vertical-wrapper">
                <div class="vertical-wrapper-back"></div>
                <?php echo trim($slider_components['captions']); ?>
            </div>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function(){
                wpestate_property_slider();
            });
        </script>
        <?php

        return ob_get_clean();
    }
endif;


/*
*
* Horizontal Slider Builder
*
*
*/
if( !function_exists('wpestate_horizontal_slider_content') ):
    function wpestate_horizontal_slider_content($postId,$slider_size,$style_css){
    
        $post_attachments           =   wpestate_generate_property_slider_image_ids($postId, true);
        $slider_components          =   wpestate_slider_slide_generation($post_attachments,$slider_size);
        $wp_estate_kind_of_map      =   esc_html ( wpresidence_get_option('wp_estate_kind_of_map','') );
        if($wp_estate_kind_of_map==2){
            $wp_estate_kind_of_map='open_street';
        }
    
        $wp_estate_kind_of_map_class=$wp_estate_kind_of_map.'_carousel';
    
    
        $return_string= '<div style="display:'.esc_attr($style_css).'" class="slide wpestate_property_carousel wpestate_property_slider_thing '.esc_attr($wp_estate_kind_of_map_class).' carouselhorizontal" data-interval="false">';
        $return_string.= '
            <!-- Wrapper for slides -->
            <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
              '.trim($slider_components['slides']).'
            </div>
    
            <!-- Indicators -->
            <div class="carusel-back"></div>
            <ol class="carousel-indicators">
              '.trim($slider_components['indicators']).'
            </ol>
    
            <ol class="carousel-round-indicators">
                '.trim($slider_components['round_indicators']).'
            </ol>
    
            <div class="caption-wrapper">
              '. trim($slider_components['captions']).'
                <div class="caption_control"></div>
            </div>
    
            </div>';
    
            $return_string.= '
            <script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                   wpestate_property_slider();
                });
                //]]>
            </script>';
    
            return $return_string;
       
    
    }
endif;







/**
 * WpEstate Classic Slider Content Builder
 *
 * This function generates the content for the classic slider on property pages.
 *
 * @package WpEstate
 * @subpackage PropertyMedia
 * @version 1.0
 *
 * @param int $postId The ID of the property post.
 * @param string $slider_size The size of the slider. Default is "listing_full_slider_1".
 * @param string $style_css Additional CSS for the slider. Default is empty string.
 * @return string The HTML content for the classic slider.
 */

if (!function_exists('wpestate_classic_slider_content')):
    function wpestate_classic_slider_content($postId, $slider_size = "listing_full_slider_1", $style_css = '') {
        $post_attachments = wpestate_generate_property_slider_image_ids($postId, true);
        $slider_components = wpestate_slider_slide_generation($post_attachments, $slider_size, 'yes');
        $wp_estate_kind_of_map = esc_html(wpresidence_get_option('wp_estate_kind_of_map', ''));
        $wp_estate_kind_of_map = ($wp_estate_kind_of_map == 2) ? 'open_street' : $wp_estate_kind_of_map;
        $wp_estate_kind_of_map_class = $wp_estate_kind_of_map . '_carousel';

        if (empty($post_attachments) && !has_post_thumbnail($postId)) {
            return '';
        }

        $carousel_class = sprintf('classic-carousel slide wpestate_property_carousel wpestate_property_slider_thing post-carusel %s', esc_attr($wp_estate_kind_of_map_class));
        $carousel_style = sprintf('style="display:%s"', esc_attr($style_css));

        ob_start();
        ?>
        <div <?php echo $carousel_style; ?> class="<?php echo $carousel_class; ?>" data-interval="false">
            <div class="carousel-inner owl-carousel owl-theme" id="property_slider_carousel">
                <?php echo trim($slider_components['slides']); ?>
            </div>
            <ol class="carousel-indicators carousel-indicators-classic">
                <?php echo trim($slider_components['indicators']); ?>
            </ol>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                wpestate_property_slider();
            });
        </script>
        <?php
        return ob_get_clean();
    }
endif;



/**
 * Generate a masonry-style gallery for a property listing - type 2
 *
 * @param int    $prop_id              The ID of the property post
 * @param string $main_image_masonry   The size for the main image (default: 'listing_full_slider')
 * @param string $second_image_masonry The size for secondary images (default: 'listing_full_slider')
 * @param string $is_shortcode         Indicates if the function is called from a shortcode (default: '')
 */

if ( ! function_exists( 'wpestate_header_masonry_gallery_type2' ) ) :
  
    function wpestate_header_masonry_gallery_type2( $prop_id, $main_image_masonry = 'listing_full_slider', $second_image_masonry = 'listing_full_slider', $is_shortcode = '' ) {
        // Get all attachment IDs for the property
        $post_attachments = wpestate_generate_property_slider_image_ids( $prop_id, true );
        $total_pictures   = count( $post_attachments );

        // Start gallery wrapper
        echo '<div class="gallery_wrapper row">';

        // Display main image if it exists
        if ( ! empty( $post_attachments ) ) {
            $main_image_id = $post_attachments[0];
            $full_prty = wp_get_attachment_image_src( $main_image_id, $main_image_masonry );
            $full_prty_src = $full_prty ? $full_prty[0] : '';

            echo wpestate_return_property_status( $prop_id, 'horizontalstatus' );
            ?>
            <div class="col-md-8 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url(<?php echo esc_url( $full_prty_src ); ?>)">
                <div class="img_listings_overlay"></div>
            </div>
            <?php
            unset( $post_attachments[0] );
        }
        // If we have only 1 image (meaning $post_attachments is now empty after unset)
        if(empty($post_attachments)) {
            echo '</div>'; // close .gallery_wrapper
            return;
        }
   
        $image_class = 'col-md-4';
        $i=0;	
        // Display secondary images
        //for ( $i = 1; $i < min( 6, $total_pictures ); $i++ ) {
        foreach ( $post_attachments as  $attachment_id ) {    
        
            if (!wp_attachment_is_image($attachment_id)) {
                continue; // Skip this attachment if it's not an image
            }
            $i++;

            // exit loop after 6 images
            if($i>6)    break;

            $full_prty = wp_get_attachment_image_src( $attachment_id, $second_image_masonry );
            
            $special_border = '';
            if ( $i == 1 ) {
                $special_border = ' special_border_top ';
            } elseif ( $i == 3 ) {
                $special_border = ' special_border_left ';
            }



            if ( $i <= 4 ) {
                if($i===1){ 
                    $image_class='';?>
                    <div class="col-md-4 wpresidence_gallery_first_col">
                <?php 
                }
                ?>

                <div class=" image_gallery lightbox_trigger <?php echo esc_attr(  $image_class.$special_border ); ?>" data-slider-no="<?php echo esc_attr( $i + 1 ); ?>" style="background-image:url(<?php echo esc_url( $full_prty[0] ); ?>)">
                    <div class="img_listings_overlay"></div>
                </div>
                <?php

                if($i===2 ||  count($post_attachments) == 1){ 
                    $image_class = 'col-md-4';	
                    ?>
                    </div>
                <?php 
                }
               
                


            } elseif ( $i == 5 ) {
                ?>
                <div class="col-md-4 image_gallery last_gallery_item lightbox_trigger" data-slider-no="<?php echo esc_attr( $i + 1 ); ?>" style="background-image:url(<?php echo esc_url( $full_prty[0] ); ?>)">
                    <div class="img_listings_overlay img_listings_overlay_last"></div>
                    <span class="img_listings_mes"><?php echo esc_html( sprintf( __( 'See all %d photos', 'wpresidence' ), $total_pictures ) ); ?></span>
                </div>
                <?php
            }
        }

        // Close gallery wrapper
        echo '</div>';
    }
endif;







/**
 * Generate a masonry-style gallery for a property listing
 *
 * @param int    $prop_id              The ID of the property post
 * @param string $main_image_masonry   The size for the main image (default: 'listing_full_slider_1')
 * @param string $second_image_masonry The size for secondary images (default: 'listing_full_slider')
 * @param string $is_shortcode         Indicates if the function is called from a shortcode (default: '')
 */
if ( ! function_exists( 'wpestate_header_masonry_gallery' ) ) :
 
    function wpestate_header_masonry_gallery( $prop_id, $main_image_masonry = 'listing_full_slider_1', $second_image_masonry = 'listing_full_slider', $is_shortcode = '' ) {
        // Get all attachment IDs for the property
        $post_attachments = wpestate_generate_property_slider_image_ids( $prop_id, false );
    
        $total_pictures   = count( $post_attachments );

        // Start gallery wrapper
        echo '<div class="gallery_wrapper row property_header_gallery_wrapper">';

        // Display property status
        echo wpestate_return_property_status( $prop_id, 'horizontalstatus' );

        // Display main image (right column)
        $main_image_id =  get_post_thumbnail_id( $prop_id );
      
      

        $post_attachments = array_values(array_filter($post_attachments, function($value) use ($main_image_id) {
            return (int)$value !== (int)$main_image_id && $value !== 'undefined';
        }));


        $full_prty = wp_get_attachment_image_src( $main_image_id, $main_image_masonry );
        if ( $full_prty ) {
            ?>
            <div class="col-md-6 row gallery-right-column image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url(<?php echo esc_url( $full_prty[0] ); ?>)">
                <div class="img_listings_overlay"></div>
            </div>
            <?php
        }

        // Start left column for secondary images
        echo '<div class="col-md-6 gallery-left-column">';


        $post_attachments= array_values($post_attachments);
        $data_slider_no=1;
        
        // Display secondary images
        for ( $i = 0; $i < min( 4, $total_pictures ); $i++ ) {
            if( !isset($post_attachments[$i]) ) {
                continue; // Skip this attachment if it's not an image
            }
            if (!wp_attachment_is_image( $post_attachments[$i]) ) {
                continue; // Skip this attachment if it's not an image
            }

            $attachment_id = $post_attachments[$i];
            $full_prty = wp_get_attachment_image_src( $attachment_id, $second_image_masonry );
            
            if ( ! $full_prty ) continue;

            $special_border = ( $i <= 1 ) ? ' special_border_top ' : '';

            if ( $i <= 2 ) {
                ?>
                <div class="col-md-6 image_gallery lightbox_trigger <?php echo esc_attr( $special_border ); ?>" data-slider-no="<?php echo esc_attr(   $data_slider_no + 1 ); ?>" style="background-image:url(<?php echo esc_url( $full_prty[0] ); ?>)">
                    <div class="img_listings_overlay"></div>
                </div>
                <?php
            } elseif ( $i == 3 ) {
                ?>
                <div class="col-md-6 image_gallery last_gallery_item lightbox_trigger" data-slider-no="<?php echo esc_attr( $data_slider_no + 1 ); ?>" style="background-image:url(<?php echo esc_url( $full_prty[0] ); ?>)">
                    <div class="img_listings_overlay 
                    <?php
                    if ( $is_shortcode !== 'yes' ) {
                        print 'img_listings_overlay_last';
                    }
                    ?>
                    "></div>
                    <?php
                    if ( $is_shortcode !== 'yes' ) {
                        echo '<span class="img_listings_mes">' . sprintf( esc_html__( 'See all %d photos', 'wpresidence' ), $total_pictures ) . '</span>';
                    }
                    ?>
                </div>
                <?php
            }
            $data_slider_no++;
        }

        // Close left column and gallery wrapper
        echo '</div></div>';
    }
endif;



 ?>
