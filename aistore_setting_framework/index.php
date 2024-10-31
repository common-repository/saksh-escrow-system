<?php


 
 add_action('admin_enqueue_scripts', 'saksh_cstm_css_and_js');

 
 
  
function saksh_cstm_css_and_js($hook) {



//if (!str_contains($hook, 'saksh_escrow')) return "";
    
if (!str_contains($hook, 'escrow')) return "";
     
    $url= plugins_url( '/saksh-escrow-system/aistore_assets/css/bootstrap.css' );
    
    
    

    wp_enqueue_style('boot_css', $url);
     wp_enqueue_script('boot_js', '//cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js');
 }
 
 