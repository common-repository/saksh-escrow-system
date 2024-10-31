<?php
/*
Plugin Name: Saksh Escrow System
Version:  2.4
Stable tag: 2.4
Plugin URI: #
Author: susheelhbti
Author URI: https://profiles.wordpress.org/susheelhbti/
Description: Saksh Escrow System is a plateform allow parties to complete safe payments.  
 
*/


 

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
    
}



 $dir = plugin_dir_path( __DIR__ );
 
 
 define('SAKSH_ESCROW_DIR', $dir."saksh-escrow-system/");



add_action('init', 'aistore_wpdocs_load_textdomain');

function aistore_wpdocs_load_textdomain()
{
    load_plugin_textdomain('aistore', false, basename(dirname(__FILE__)) . '/languages/');
}

function aistore_scripts_method()
{

   wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js', array('jquery'), NULL, true );
   

        $url= plugins_url( '/saksh-escrow-system/aistore_assets/css/bootstrap.css' );
    
    
    

    wp_enqueue_style('boot_css', $url);
    
    
     
  
//    wp_enqueue_style('aistore', plugins_url('/aistore_assets/css/custom.css', __FILE__) , array());
 //   wp_enqueue_script('aistore', plugins_url('/aistore_assets/js/custom.js', __FILE__) , array(
  //      'jquery'
  //  ));
}

add_action('wp_enqueue_scripts', 'aistore_scripts_method');


//add_action('admin_head', 'saksh_escrow_system_css');

//function saksh_escrow_system_css() {  


 //wp_enqueue_style( 'saksh_escrow_system', plugin_dir_url( __FILE__ ) . 'css/custom.css' );
 
 
  
//}


//function aistore_load_scripts($hook) {

 
  
 // wp_enqueue_script('aistore',plugins_url('/aistore_assets/js/admin.js', __FILE__) ,'','',true);
  
  
   
//}
//add_action('admin_enqueue_scripts', 'aistore_load_scripts');




function aistore_isadmin()
{

    $user = wp_get_current_user();
    $allowed_roles = array(
        'administrator'
    );
    if (array_intersect($allowed_roles, $user->roles))
    {
        return true;
    }
    else
    {

        return false;

    }
}


function aistore_plugin_table_install()
{
    
    global $wpdb;



    $table_escrow_system = "CREATE TABLE   IF NOT EXISTS  " . $wpdb->prefix . "escrow_system (
  id int(100) NOT NULL AUTO_INCREMENT, 
  title varchar(100)   NOT NULL,
  term_condition text ,
  amount double NOT NULL,
  currency  varchar(100)   NOT NULL,
  url  varchar(100)   NOT NULL,
  receiver_email varchar(100)  NOT NULL,
  sender_email varchar(100)   NOT NULL,
  
    receiver_user_id varchar(100)  NOT NULL,
  sender_user_id varchar(100)   NOT NULL,
  
  
  accept_escrow_fee double NOT NULL,
  
  create_escrow_fee double NOT NULL,
   
  
  
  status varchar(100)   NOT NULL DEFAULT 'pending',
  payment_status varchar(100)   NOT NULL DEFAULT 'Pending',
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  
  
  PRIMARY KEY (id)
)  ";




   
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');



    dbDelta($table_escrow_system);
 
 
   $saksh_escrow_tables = array();

        $saksh_escrow_tables = apply_filters('saksh_escrow_tables', $saksh_escrow_tables);
        
        
    foreach($saksh_escrow_tables as $escrow_table  )
    {
    
    dbDelta($escrow_table);
    
    }

        do_action("AistoreEscrow_Install");
}

 
     
     
     
register_activation_hook(__FILE__, 'aistore_plugin_table_install');

include_once dirname(__FILE__) . '/aistore_wallet/index.php';
 
include_once dirname(__FILE__) . '/aistore_setting_framework/forms.php';

include_once dirname(__FILE__) . '/aistore_setting_framework/reports.php';

  
include_once dirname(__FILE__) . '/aistore_escrow/user_escrow.php';
 

include_once dirname(__FILE__) . '/aistore_escrow_extensions/index.php';



include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrow.class.php';

include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSystem.class.php';


include_once dirname(__FILE__) . '/aistore_escrow/aistore_escrow_details.php';

 

include_once dirname(__FILE__) . '/aistore_escrow/AistoreEscrowSystemAdmin.class.php';


 

include_once dirname(__FILE__) . '/admin_setting/page_settings.php';
include_once dirname(__FILE__) . '/admin_setting/escrow_settings.php';
include_once dirname(__FILE__) . '/admin_setting/message_settings.php';


include_once dirname(__FILE__) . '/aistore_setting_framework/index.php';

add_shortcode('aistore_escrow_system', 'aistore_escrow_system');

add_shortcode('aistore_escrow_list',  'aistore_escrow_list');

add_shortcode('aistore_escrow_detail', 'aistore_escrow_detail');

add_shortcode('payment_method_list',  'payment_method_list');

 
function aistore_escrow_list()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_list();
   
} 

 
function payment_method_list()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->payment_method_list();
   
}
 
function aistore_escrow_detail()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_detail();
   
}
function aistore_escrow_system()
{
      if (!is_user_logged_in())
        {
            return "<div class='loginerror'>Kindly login and then visit this page</div>";
        }
        
   $cl=new AistoreEscrowSystem();
   
return    $cl->aistore_escrow_system();
   
}

 
function Aistore_process_placeholder_EID($str, $eid)
{
  
 
 
    
    $str = str_replace("[EID]", $eid, $str);
     
    return ($str);
}



function Aistore_process_placeholder_Text($str, $escrow)
{
 $details_escrow_page_id_url =$escrow->url;
    
    $date = $escrow->created_at;
    
    
date_default_timezone_set('America/Los_Angeles');


$datetime= date('l F j Y g:i:s A', strtotime($date));
    
 
 
$html ='<h1>Escrow Details </h1><br>
    <table><tr><td>Escrow Id :</td><td>'.$escrow->id.'</td></tr>
      <tr><td>Title :</td><td>'.$escrow->title.'</td></tr>
    <tr><td>Amount :</td><td>'.$escrow->amount.' '.$escrow->currency.'</td></tr>
      <tr><td>Accept Escrow Fee :</td><td>'.$escrow->accept_escrow_fee.'</td></tr>
           <tr><td>Create Escrow Fee :</td><td>'.$escrow->create_escrow_fee.'</td></tr>
          <tr><td>Sender :</td><td>'.$escrow->sender_email.'</td></tr>
              <tr><td>Receiver :</td><td>'.$escrow->receiver_email.'</td></tr>
               <tr><td>Status :</td><td>'.$escrow->status.'</td></tr>
        <tr><td>Date :</td><td>'.$datetime.'</td></tr></table><br>';
        
            $html.='<h1>Sender Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->sender_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->sender_email.'</td></tr>
   </table><br>';
        
        
        $html.='<h1>Receiver Details </h1><br>
    <table><tr><td>Email :</td><td>'.$escrow->receiver_email.'</td></tr>
      <tr><td>Name :</td><td>'.$escrow->receiver_email.'</td></tr></table><br>
    ';
    
     $html.='Escrow Details Page to <a href='.$details_escrow_page_id_url.'> Click here</a><br><br>
    ';
    
    $str = str_replace("[EID]", $escrow->id, $str);
      $str = str_replace("[ESCROWDATA]", $html, $str);
    return ($str);
}



function aistore_escrow_getpartner($email,$escrow)
{
 
    $user_email = $escrow->sender_email;
    $party_email = $escrow->receiver_email;
    
    if($email==$user_email )
    return $escrow->receiver_email;
    else
    return  $escrow->sender_email;
    
}


function  AistoregetSupportMsg()

{
    $url = admin_url('admin.php?page=saksh_escrow_settings', 'https');
                
               
    $msg  ="<p> For support plz email wordpress@aistore2030.com or susheel2339@gmail.com or +91 8840574997 </p>";
    
    $msg   .="<p>Complete Escrow settings from this link  <a href='".esc_url($url)."'>Escrow Settings</a> </p>";
    
    
             
 $msg .="<p>OFFER  in Just 100$ we can configure and very well integrte this application exactly as per your requirement. also add upto 10 points more as per the requirement of the website.</p>";
         
         
         
    return $msg;
    
 
}


 

 
 
 
 
 
 add_filter( 'saksh_escrow_reports', 'saksh_escrow_reports' );
     
function saksh_escrow_reports( $saksh_reports_data )
{
        
 
 
 	global $wpdb;
           	 
 
  
 	 
           	    $url = admin_url(
                "admin.php?page=aistore_escrow_details",
                "https"
            );

            
            
            
           
  
  $sql = "SELECT    concat( '<a href=\"' , CONCAT('".$url."&eid=', id ) ,'\" >' , id , '</a>'  )    as id    ,   title ,amount,currency ,receiver_email , sender_email , accept_escrow_fee  , create_escrow_fee  , status,payment_status ,created_at   FROM {$wpdb->prefix}escrow_system    order by id desc limit 500 ";
 
 
 
     	 $results = $wpdb->get_results($sql);
     	 
      


 $saksh_reports_data['escrow']=$results;
    
   
 
    
    
  return $saksh_reports_data;
  
}

 
 add_filter( 'saksh_escrow_reports', 'saksh_escrow_disputed_reports' );
     
function saksh_escrow_disputed_reports( $saksh_reports_data )
{
        
 
 
 	global $wpdb;
           	 
 
  $sql = "SELECT * FROM {$wpdb->prefix}escrow_system where status='disputed'     order by id desc limit 50 ";
 
     	 $results = $wpdb->get_results($sql);
     	 
      


 $saksh_reports_data['escrow_disputed']=$results;
   
 
    
    
  return $saksh_reports_data;
  
}



function qr_to_log($line,$qr)
{
  $my_post = array(
  'post_title'    =>$line,
 'post_content'  => $qr,
  'post_status'   => 'draft' 
 );
 
// Insert the post into the database
 wp_insert_post( $my_post );
    
    
    
}


function saksh_print_form($group, $fields,$saksh)
{
    
     $args = array(
           'textarea_rows' =>  5,
    'teeny' => true,
    'quicktags' => false,
        'media_buttons' => false,
    
    'tinymce'       => array(
        'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
        'toolbar2'      => '',
        'toolbar3'      => '',
        
        
        
    ),
);
    
        
    
  
  
    
     
     

    $pages = get_pages();

    echo " <strong>" .ucfirst(str_replace("_"," ",$group) )        . " </strong> ";
    
     

    foreach ($fields as $field)
    {
        $name=$field['name'];
        
        if(!array_key_exists ( $group ,  $saksh  )  )
          {  
              
               $value=$field['default']  ;
          } 
          else   if(is_array(  $saksh[$group]) && array_key_exists ( $name ,    $saksh[$group]  )  )
          {  
              $value=$saksh[$group][$name] ;
          }
          else
          {
              $value=$field['default']  ;
          }
          
      
      
   echo ' <div class="mb-3  w-50">
   
   
  <label for= "' . $name.'"   class="form-label">'. ucfirst(str_replace("_"," ", $field['label']) ).'</label>  ';
   
   
        
         

        if ($field['type'] == "string")
        {
            
            echo "<input class='form-control input' type='text'   id='" . $name. "'name='" . $name. "'      value='" .$value . "' /> ";
 
        } 
        
        
        if ($field['type'] == "wp_editor")
        {
            
            
      

wp_editor( $value, $name, $args );





            //echo "<input class='form-control' type='text'   name='" . $name. "'   value='" .$value . "' /><br/>";
 
        }

        if ($field['type'] == "select")
        {

            echo " <select class='form-control'  name='" . $name . "' >";

            $options = $field['options'];

            foreach ($options as $option)
            {

                if ($option ==$value)
                {
                    echo '	<option selected value="' . esc_attr($option) . '">' . esc_attr($option) . '</option>';

                }
                else
                {

                    echo '	<option  value="' . esc_attr($option) . '">' . esc_attr($option) . '</option>';

                }
            }

            echo '</select> ';

        }

        if ($field['type'] == "pages")
        {

            echo "<select class='form-control' name='" . $name. "' >";

            foreach ($pages as $page)
            {

                if ($page->ID == $value)
                {
                    echo '	<option selected value="' . esc_attr($page->ID) . '">' . esc_attr($page->post_title) . '</option>';

                }
                else
                {

                    echo '	<option  value="' . esc_attr($page->ID) . '">' . esc_attr($page->post_title) . '</option>';

                }
            }

            echo '</select> ';

        }


 echo '  <small id="' . $name . 'Help" class="form-text text-muted"> ' . $field['description'] . '</small></div> ';
 
 
    }

    echo "<input type='hidden'   name='group'   value='" . $group . "' /> ";

    
   // echo "</form>  ";


}


 
