<?php
$featured               =   intval  ( get_post_meta($postID, 'prop_featured', true) );?>

<div class="tag-wrapper">
    <?php
        if($featured==1){
            print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
        }
    ?>                                   
</div>