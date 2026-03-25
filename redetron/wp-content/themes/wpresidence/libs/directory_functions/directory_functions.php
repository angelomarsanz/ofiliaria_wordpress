<?php


add_action( 'wp_ajax_nopriv_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );
add_action( 'wp_ajax_wpestate_classic_ondemand_directory', 'wpestate_classic_ondemand_directory' );

if( !function_exists('wpestate_classic_ondemand_directory') ):

    function wpestate_classic_ondemand_directory(){



        wp_suspend_cache_addition(false);


        $allowed_html=array();
        $wpestate_options                    =   wpestate_page_details(intval($_POST['postid']));
        $type_name      =   'category_values';
        $type_name_value=   wp_kses( $_REQUEST[$type_name] ,$allowed_html );
        $action_name    =   'action_values';
        if(isset($_REQUEST[$action_name] )){
            $action_name_value  = wp_kses( $_REQUEST[$action_name] ,$allowed_html );
        }else{
            $action_name_value='';
        }
        $categ_array='';
        if ( $type_name_value!='all' && $type_name_value!='' ){
            $taxcateg_include   =   array();
            $taxcateg_include   =   sanitize_title ( wp_kses( $type_name_value ,$allowed_html ) );

            $categ_array=array(
                'taxonomy'     => 'property_category',
                'field'        => 'slug',
                'terms'        => $taxcateg_include
            );
        }

        $action_array='';
        if ( $action_name_value !='all' && $action_name_value !='') {
            $taxaction_include   =   array();
            $taxaction_include   =   sanitize_title ( wp_kses( $action_name_value ,$allowed_html) );

            $action_array=array(
                 'taxonomy'     => 'property_action_category',
                 'field'        => 'slug',
                 'terms'        => $taxaction_include
            );
         }

         $city_array ='';
        if (isset($_REQUEST['city']) and $_REQUEST['city'] != 'all' && $_REQUEST['city'] != '') {
            $taxcity[] = sanitize_title ( wp_kses ( $_REQUEST['city'],$allowed_html ) );
            $city_array = array(
                'taxonomy'     => 'property_city',
                'field'        => 'slug',
                'terms'        => $taxcity
             );
         }

       $area_array = '';
        if (isset($_REQUEST['area']) and $_REQUEST['area'] != 'all' && $_REQUEST['area'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy'     => 'property_area',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }



        $county_array='';
        if (isset($_REQUEST['county']) and $_REQUEST['county'] != 'all' && $_REQUEST['county'] != '') {
            $taxarea[] = sanitize_title ( wp_kses ($_REQUEST['county'],$allowed_html) );
            $county_array = array(
                'taxonomy'     => 'property_county_state',
                'field'        => 'slug',
                'terms'        => $taxarea
            );
        }


        $pagination = intval($_POST['pagination']);

        $price_low='';
        if( isset($_POST['price_low'])){
            $price_low = floatval( $_POST['price_low'] );
        }

        $price_max='';
        if( isset($_POST['price_max'])){
            $price_max = floatval( $_POST['price_max'] );
        }

        $min_size='';
        if( isset($_POST['min_size'])){
            $min_size =wpestate_convert_measure( floatval( $_POST['min_size'] ));
        }

        $max_size='';
        if( isset($_POST['max_size'])){
            $min_size = wpestate_convert_measure(floatval( $_POST['max_size']) );
        }

        $min_lot_size='';
        if( isset($_POST['min_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['min_lot_size']) );
        }

        $max_lot_size='';
        if( isset($_POST['max_lot_size'])){
            $min_lot_size= wpestate_convert_measure(floatval( $_POST['max_lot_size'] ));
        }

        $min_rooms='';
        if( isset($_POST['min_rooms'])){
            $min_rooms= floatval( $_POST['min_rooms'] );
        }

        $max_rooms='';
        if( isset($_POST['max_rooms'])){
            $max_rooms= floatval( $_POST['max_rooms'] );
        }

        $min_bedrooms='';
        if( isset($_POST['min_bedrooms'])){
            $min_bedrooms= floatval( $_POST['min_bedrooms'] );
        }

        $max_bedrooms='';
        if( isset($_POST['max_bedrooms'])){
            $max_bedrooms= floatval( $_POST['max_bedrooms'] );
        }

        $min_bathrooms='';
        if( isset($_POST['min_bathrooms'])){
            $min_bathrooms= floatval( $_POST['min_bathrooms'] );
        }

        $max_bathrooms='';
        if( isset($_POST['max_bathrooms'])){
            $max_bathrooms= floatval( $_POST['max_bathrooms'] );
        }

        $status='';
        $status_array='';
        if( isset($_POST['status']) && $_POST['status']!=''){
            $status = esc_html( $_POST['status'] );
            $status= html_entity_decode($status,ENT_QUOTES);

            $status_array = array(
                'taxonomy'     => 'property_status',
                'field'        => 'name',
                'terms'        => $status
            );

        }




        $wpestate_keyword='';
        if( isset($_POST['keyword'])){
            $wpestate_keyword = esc_html( $_POST['keyword'] );
        }

        $meta_order         =   'prop_featured';
      
        

      
        $price_max          =   '';
        $custom_fields      =   wpresidence_get_option( 'wp_estate_multi_curr', '');
        $price_low          =   floatval($_REQUEST['price_low']);

        if( isset($_REQUEST['price_max'])  && $_REQUEST['price_max'] && floatval($_REQUEST['price_max'])>0 ){
            $price_max          = floatval($_REQUEST['price_max']);

            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i=intval($_COOKIE['my_custom_curr_pos']);
                $price_max       =   $price_max / $custom_fields[$i][2];
                $price_low       =   $price_low / $custom_fields[$i][2];
            }


            $price['key']       = 'property_price';
            $price['value']     = array($price_low, $price_max);
            $price['type']      = 'numeric';
            $price['compare']   = 'BETWEEN';
            $meta_query[]       = $price;
        }


        $max_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_size']),1 );
        $min_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_size']),1 );
        $size_array             =   array();
        $size_array['key']      =   'property_size';
        $size_array['value']    =   array($min_size, $max_size);
        $size_array['type']     =   'numeric';
        $size_array['compare']  =   'BETWEEN';
        $meta_query[]           =   $size_array;


        $max_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['max_lot_size']),1);
        $min_lot_size               =   wpestate_convert_measure ( floatval($_REQUEST['min_lot_size']),1);
        $lotsize_array              =   array();
        $lotsize_array['key']       =   'property_lot_size';
        $lotsize_array['value']     =   array($min_lot_size, $max_lot_size);
        $lotsize_array['type']      =   'numeric';
        $lotsize_array['compare']   =   'BETWEEN';
        $meta_query[]               =   $lotsize_array;


        $max_rooms                  =   floatval($_REQUEST['max_rooms']);
        $min_rooms                  =   floatval($_REQUEST['min_rooms']);
        $rooms_array                =   array();
        $rooms_array['key']         =   'property_rooms';
        $rooms_array['value']       =   array($min_rooms, $max_rooms);
        $rooms_array['type']        =   'numeric';
        $rooms_array['compare']     =   'BETWEEN';
        $meta_query[]               =   $rooms_array;



        $max_bedrooms                  =   floatval($_REQUEST['max_bedrooms']);
        $min_bedrooms                  =   floatval($_REQUEST['min_bedrooms']);
        $bedrooms_array                =   array();
        $bedrooms_array['key']         =   'property_bedrooms';
        $bedrooms_array['value']       =   array($min_bedrooms, $max_bedrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;


        $max_bathrooms                 =   floatval($_REQUEST['max_bathrooms']);
        $min_bathrooms                 =   floatval($_REQUEST['min_bathrooms']);
        $bedrooms_array                =   array();
        $bedrooms_array['key']         =   'property_bathrooms';
        $bedrooms_array['value']       =   array($min_bathrooms, $max_bathrooms);
        $bedrooms_array['type']        =   'numeric';
        $bedrooms_array['compare']     =   'BETWEEN';
        $meta_query[]                  =   $bedrooms_array;





        $prop_no    =   intval( wpresidence_get_option('wp_estate_prop_no', '') );
        $features_array = wpestate_add_feature_to_search('ajax');
        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,

            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'paged'           => $pagination,
            'posts_per_page'  => $prop_no,
            'meta_key'        => $meta_order,
          //  'orderby'         => $order_by,
            //'order'           => $meta_directions,
            'tax_query'       => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array,
                                    $county_array,
                                    $features_array,
                                    $status_array

                                )
        );

        
        $order_array=array();
        if(isset($_POST['order'])) {
            $order          =   intval( $_POST['order'] );
            $order_array    =   wpestate_create_query_order_by_array($order);
        }

        $args           =   array_merge($args,$order_array['order_array']);
        $features = array();
        $metas = wpestate_convert_meta_to_postin($meta_query);
        if( !empty($metas)){
            $all_ids = $metas;
        }





        if(empty($all_ids)){
            $all_ids[]=0;
        }


        $args['post__in']=$all_ids;


        global $wpestate_keyword;
        $wpestate_keyword=esc_html ( $_POST['keyword']);

        if( !empty($wpestate_keyword)  ){
          add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }

        $prop_selection= new Wp_Query($args);


        ob_start();

        wpresidence_display_property_list_as_html($prop_selection,$wpestate_options  ,'shortcode_list');

        $cards= ob_get_contents();
        ob_end_clean();


        if( !empty($wpestate_keyword) ){
            if(function_exists('wpestate_disable_filtering')){
                wpestate_disable_filtering( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }
        }



        echo json_encode( array(
                            'args'      =>  $args,
                            'cards'   =>  $cards,
                            'no_results'=>  $prop_selection->found_posts,
                        ));
       wp_suspend_cache_addition(false);
       die();
  }

 endif; // end   ajax_filter_listings


