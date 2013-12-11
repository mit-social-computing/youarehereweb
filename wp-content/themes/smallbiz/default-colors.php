<?php
// If called with header as a parameter, act as an ajax call:
if(isset($_REQUEST["header"])){
    $colors =    smallbiz_get_default_colors_for_header($_REQUEST["header"]);
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Content-type: application/json');    
    echo json_encode($colors);
}

// main function -- can be included as well.
function smallbiz_get_default_colors_for_header($header){
    $header = strtolower($header);    
    switch ($header) {
    
        case "light_swoop_green":
            $arr = array(
                'name_color'       => '333333',
                'sub_header_color' => '333333',
                'street_color'     => '333333',
                'city_color'       => '333333',
                'state_color'      => '333333',
                'zip_color'        => '333333',
                'telephone_color'  => '333333',
                'headeremail_color'=> '333333',
        
                'menu_color'       => '262525',
                'active_color'     => 'FFFFFF',
                'passive_color'    => '88AB4F',
                'hover_color'      => 'FFFFFF',
        
                'headertag_color'  => '85AC54',        
            );			
             break;
        default:
            // Defaults:
            $arr = array(
                'name_color'       => '333333',
                'sub_header_color' => '333333',
                'street_color'     => '333333',
                'city_color'       => '333333',
                'state_color'      => '333333',
                'zip_color'        => '333333',
                'telephone_color'  => '333333',
                'headeremail_color'=> '333333',
        
                'menu_color'       => '333333',
                'active_color'     => 'FFFFFF',
                'passive_color'    => '999999',
                'hover_color'      => 'FFFFFF',
        
                'headertag_color'  => '333333',        
            );			
           
    }            
    return $arr;
}   
?>