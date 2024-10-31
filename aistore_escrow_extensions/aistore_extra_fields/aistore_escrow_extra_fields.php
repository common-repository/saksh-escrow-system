<?php
 add_filter("AistoreEscrowCreatedafter", "Aistore_Escrow_Created_after");

/**
 * This function is used to File to attach
 * @pdf
 * @xlsx
 * @ppt
 * @doc
 */
function Aistore_Escrow_Created_after($data)
{
 
    
    global $wpdb;
    

   $eid=$data['escrow']->id;
   
 
 
   
   $extra_fields= $data['request'];
 
     
$metafield= json_encode($extra_fields);

 
      $qr=$wpdb->prepare( "INSERT INTO {$wpdb->prefix}escrow_extrafields ( eid,metafield ) VALUES ( %d,%s )", [$eid, $metafield ] );
                
                 
                
 

        $wpdb->query($qr);
 
            
            
    
}





add_filter("saksh_create_escrow_form", "saksh_create_escrow_form_fields");

function saksh_create_escrow_form_fields($saksh_fields)
{
    $fields = [];

    $fields[] = [
        "name" => "PartyName",
        "label" => "Party Name",
        "type" => "string",
 "default" => "",
        "required" => true,
 "description" =>
            "",
    ];

    $fields[] = [
        "name" => "Party addrsss",
        "label" => "partyaddrsss",
        "type" => "string",
 "default" => "",
        "required" => true,

        "description" =>
            "",
    ];

    $fields[] = [
        "name" => "Party phone number",
        "label" => "party_phone_number",
        "type" => "string",
 "default" => "",
        "required" => true,

        "description" =>
            "",
    ];



 

    $saksh_fields["extra_fields"] = $fields;

    return $saksh_fields;
}















 

add_filter("aistore_escrow_first_tab", "aistore_escrow_files_tab_contents1");

function aistore_escrow_files_tab_contents1($escrow)
{
?>

 
  <?php
  
  global $wpdb;  
   $es = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}escrow_extrafields where eid=%d   ",
                $escrow->id 
            )
        );
  
  
  
  
  
    $saksh_create_escrow_form = array();

    $saksh_create_escrow_form = apply_filters('saksh_create_escrow_form', $saksh_create_escrow_form);
  
 
$extra_fields=$saksh_create_escrow_form['extra_fields'];
 
  $metafield=json_decode( $es->metafield ) ;
  
  
  
 
   $fields=array();
   foreach($extra_fields as $extra_field )
  {
      
     $fields[]=$extra_field['name'];
     
      
  }
  
  echo "<table class='table'>";
     
    foreach($fields as $field )
  {
       
 
     echo "<tr>";
     
     echo "<td>";
     
     echo $field;
     
     echo "</td>";
       echo "<td>";
     
    echo $metafield ->$field;
     echo "</td>";
     
         
     echo "</tr>";
    
  } 
  
 
  echo "</table>";
     
  
  

  
  
 

}



