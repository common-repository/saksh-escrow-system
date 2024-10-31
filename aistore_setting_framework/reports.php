<?php

 
add_action('admin_menu', 'register_crypto_menu_page_report');

function register_crypto_menu_page_report()
{
    add_menu_page(__('Escrow Report') , 'Escrow Report', 'manage_options', 'saksh_escrow_report_framework', 'aistore_crypto_report');
    
    
}

 
 

function aistore_crypto_report()

{

 //  $saksh = get_option('saksh_escrow_reports');


echo "<div class='b5'>";
   
 echo "<h1>Saksh Escrow Reports</h1>";

   echo '<br/>Reports and statistics from our escrow system ';
       
    echo " <br/><br/><strong> Whatsapp +91 8840574997 or +91  9559190379 for any support </strong><br/><br/>  https://api.whatsapp.com/send?phone=919559190379&text=Hello%20via%20sakshstore.com <br/><br/>";
    //$saksh = get_option('aistore_escrow_payment_optons');
    

    $saksh_escrow_reports = array();

    $saksh_escrow_reports = apply_filters('saksh_escrow_reports', $saksh_escrow_reports);

 //  var_dump($saksh_escrow_reports);
   echo '<nav>  <div class="nav nav-tabs" id="nav-tab" role="tablist">';

    $active = "active";
    foreach ($saksh_escrow_reports as $group => $field)
    {

        echo '    <button class="nav-link ' . $active . ' " id="nav-' . $group . '-tab" data-bs-toggle="tab" data-bs-target="#nav-' . $group . '" type="button" role="tab" aria-controls="nav-' . $group . '" aria-selected="true">' . ucfirst(str_replace("_"," ", $group) ) . '</button> ';
        $active = "";
    }

    echo ' </div></nav>';

    echo '<div class="tab-content" id="nav-tabContent">';
    $active = "show active";

    foreach ($saksh_escrow_reports as $group => $rows)
    {

        echo ' <div class="tab-pane fade ' . $active . '" id="nav-' . $group . '" role="tabpanel" aria-labelledby="nav-' . $group . '-tab" tabindex="0">  <br />';
 
    
     
        
    
      
      print_table($group, $rows );
      
      
 
        echo '</div>';

        $active = "";

    }

    echo ' </div> ';
    echo ' </div> ';

  //echo " <hr />Debug log";

 // echo "<pre>";
 

 //p/rint_r($saksh_escrow_reports);
 //
 //echo "</pre>";

} 





function print_table($group, $rows  )
{
  if(count($rows) <1) {echo  "We have no data in this tab"; return "" ;  } 
 
    echo "<br/><strong>" . ucfirst(str_replace("_"," ", $group) ) . "  </strong><br/> ";
echo "<table class='table'>";
    echo "<tr>";
    foreach ($rows[0] as $row => $value)
    {
        

 echo "<td>";
 
   echo ucfirst(str_replace("_"," ", $row) );
 
 echo "</td>";
 
 
    } 
    
    echo "</tr>";
 
    
        
            foreach ($rows as $row )
    {
        
            echo "<tr>";
            
          
 
 
 
    foreach ($row as $column => $value)
    {
    
 
 
 echo "<td>";
 
   echo $row->$column;
 
 echo "</td>";
 

 
    }
        echo "</tr>";
    }


echo "</table>";
     

}
