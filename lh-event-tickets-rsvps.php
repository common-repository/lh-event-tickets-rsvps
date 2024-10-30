<?php
/**
 * Plugin Name: LH Event Tickets RSVPs
 * Plugin URI: https://lhero.org/plugins/lh-event-tickets-rsvps/
 * Description: Better handling of RSVP display for Moderfn Tribes event tickets rsvps
 * Author: Peter Shaw
 * Version: 1.00
 * Author URI: https://shawfactor.com/
 * Text Domain: lh_event_tickets_rsvps
 * Domain Path: /languages
*/

if (!class_exists('LH_Event_tickets_rsvps_plugin')) {


class LH_Event_tickets_rsvps_plugin {
    
    
    var $namespace = 'lh_event_tickets_rsvps';
    
    
    
    private static $instance;
    
    
static function maybe_use_bp_avatar($userid){
    
    
    if (function_exists('bp_core_fetch_avatar', $size = 75)){
        
        
        $args = array( 
        'item_id' => $userid,  
        'object' => 'user',  
        'type' => 'full',  
        'width' => $size,  
        'height' => $size,  
        'class' => 'avatar',  
        'html' => true,  
); 



return bp_core_fetch_avatar($args);
        
        
        
    } else {
        
        
        return get_avatar($userid, $size);
    }   
        
        
    }
    
    
    
    private function return_usable_attendees($attendees){
        
        
        $rsvps = array();
        
        
        
    foreach ($attendees AS $attendee) {
        
        
        
        if (isset($attendee['user_id']) and !empty($attendee['user_id'])){
            
            
          if (isset($rsvps[$attendee['user_id']]['tickets']) and !empty($rsvps[$attendee['user_id']]['tickets'])){
              
              
              $rsvps[$attendee['user_id']]['tickets'] = $rsvps[$attendee['user_id']]['tickets'] + 1;
              
              
              
          } else {
              
              
             $rsvps[$attendee['user_id']]['tickets'] = 1; 
              
              
          }
           
           
           
            
            
        } else {
            

            
            if (isset($rsvps[$attendee['purchaser_email']]['tickets']) and !empty($rsvps[$attendee['purchaser_email']]['tickets'])){
            
                
                $rsvps[$attendee['purchaser_email']]['tickets'] = $rsvps[$attendee['purchaser_email']]['tickets'] + 1;
              
              
              
          } else {
              
              
             $rsvps[$attendee['purchaser_email']]['tickets'] = 1; 
              
              
          }
            
            
           $rsvps[$attendee['purchaser_email']]['name'] = $attendee['purchaser_name'];  
            
            
        }
        
        
    }
    
    return $rsvps;
        
        
        
        
    }
    
    public function display_rsvps(){
        
        global $post;
        
        $attendees = Tribe__Tickets__Tickets::get_event_attendees( $post->ID );
        
        $rsvps = $this->return_usable_attendees($attendees);
        
        // Now display the newsletter tools screen
        include ('templates/rsvps.php');
        
        }
        
        
    public function plugins_loaded(){

//prepare the plugin to be translated, needs more work to be useful
load_plugin_textdomain( 'lh_event_tickets_rsvps', false, basename( dirname( __FILE__ ) ) . '/languages' );

//add the rsvp display
add_action( 'tribe_events_single_event_before_the_content', array($this,"display_rsvps"));

}
    
    
      /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }
    
    public function __construct() {


add_action( 'plugins_loaded', array($this,"plugins_loaded"));


}
    
}

$lh_event_tickets_rsvps_instance = LH_Event_tickets_rsvps_plugin::get_instance();

}



?>