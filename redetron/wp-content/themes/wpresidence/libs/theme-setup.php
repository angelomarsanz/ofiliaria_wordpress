<?php


if ( ! function_exists( 'wpestate_convert_redux_wp_estate_multi_curr' ) ):
function wpestate_convert_redux_wp_estate_multi_curr(){
    $custom_fields = get_option( 'wp_estate_multi_curr', true);  
    $cur_code=array();
    $cur_label=array();
    $cur_value=array();
    $cur_positin=array();
    $redux_currency=array();
    
    if(is_array($custom_fields)){
        foreach($custom_fields as $field){
            $cur_code[]=$field[0];
            $cur_label[]=$field[1];
            $cur_value[]=$field[2];
            $cur_positin[]=$field[3];
        }
    }
    
    $redux_currency['add_curr_name']=$cur_code;
    $redux_currency['add_curr_label']=$cur_label;
    $redux_currency['add_curr_value']=$cur_value;  
    $redux_currency['add_curr_order']=$cur_positin;
   
    return $redux_currency;
}
endif;


if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_multi_curr' ) ):
function wpestate_reverse_convert_redux_wp_estate_multi_curr(){
    global $wpresidence_admin;
    $final_array = array();
    if(isset($wpresidence_admin['wpestate_currency']['add_curr_name'])){
        foreach ( $wpresidence_admin['wpestate_currency']['add_curr_name'] as $key=>$value ){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_currency']['add_curr_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_currency']['add_curr_label'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_currency']['add_curr_value'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_currency']['add_curr_order'][$key];

            $final_array[]=$temp_array;
        }
    }
    return $final_array;


}
endif;

if ( ! function_exists( 'wpestate_convert_redux_wp_estate_custom_fields' ) ):
function wpestate_convert_redux_wp_estate_custom_fields(){
    $custom_fields      =   get_option( 'wp_estate_custom_fields', true);  
    $add_field_name     =   array();
    $add_field_label    =   array();
    $add_field_order    =   array();
    $add_field_type     =   array();
    $add_dropdown_order =   array();
      
    $redux_custom_fields=array();
    if(is_array($custom_fields)){
        foreach($custom_fields as $key=>$field){
            $add_field_name[]=$field[0];
            $add_field_label[]=$field[1];
            $add_field_type[]=$field[2];
            $add_field_order[]=$field[3];
            if(isset($field[4])){
            $add_dropdown_order[]=$field[4];
            }
        }
    }
    $redux_custom_fields['add_field_name']=$add_field_name;
    $redux_custom_fields['add_field_label']=$add_field_label;
    $redux_custom_fields['add_field_order']=$add_field_order;  
    $redux_custom_fields['add_field_type']=$add_field_type;
    $redux_custom_fields['add_dropdown_order']=$add_dropdown_order;
    update_option( 'wpestate_custom_fields_list', $redux_custom_fields);  
    return $redux_custom_fields;   
    
}
endif;


if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_custom_fields' ) ):
function wpestate_reverse_convert_redux_wp_estate_custom_fields(){
    global $wpresidence_admin;
    $final_array=array();
   
    if(isset($wpresidence_admin['wpestate_custom_fields_list']['add_field_name'])){
        foreach( $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'] as $key=>$value){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_label'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_order'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_type'][$key];
            if( isset(  $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key] ) ){
                $temp_array[4]= $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key];
            }
            $final_array[]=$temp_array;
        }
    }
    
    usort($final_array,"wpestate_sorting_function");
    
    return $final_array;
}

endif;



?>