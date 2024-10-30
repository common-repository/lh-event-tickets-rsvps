<?php
if (isset($rsvps) && !empty($rsvps)){
    
    echo "<h3>RSVP's</h3>";

foreach ($rsvps AS $key => $value) {
    
    
    
    
if (is_email( $key )){
    
    
    
    
    $user = get_user_by( 'email', $key );
    
    if (!empty($user)){
        
        
        echo self::maybe_use_bp_avatar($user->ID); 
        
        echo $user->display_name;
        
        
        
    } else {
        
      echo self::maybe_use_bp_avatar($key); 
      echo $value['name'];
        
    }
    
    
} else {
    
    $user = get_user_by( 'ID', $key );
    
    
    echo self::maybe_use_bp_avatar($key); 
    
    echo $user->display_name;
    
    
    
    
}
    
}   
    
    

}    



?>