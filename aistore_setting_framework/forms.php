<?php

global $saksh;

$saksh = get_option('aistore_escrow_payment_optons');

 

add_action('admin_menu', 'aistore_escrow_register_crypto_menu_page');

function aistore_escrow_register_crypto_menu_page()
{
    add_menu_page(__('Escrow Settings') , 'Escrow Settings', 'manage_options', 'saksh_escrow_settings', 'aistore_crypto_setting_form');
}

 

function aistore_escrow_setting_set_default_value($group, $fields )
{
 $saksh = get_option('aistore_escrow_payment_optons');

if(!$saksh)
        $saksh=array();
        
        
    foreach ($fields as $field)
    {

        if ($field['type'] == "pages")
        {
            $title =  $field['default']['post_title'] ;

            $post_content =  $field['default']['post_content'] ;

            $my_post = array(
                'post_title' => $title,
                'post_type' => 'page',
                'post_content' => $post_content,
                'post_status' => 'publish'
            );

            $default_page_id = wp_insert_post($my_post);

            $name = $field['name'];
            $saksh_ar[$name] = $default_page_id;

        }
        else
        {

            $name = $field['name'];
          
          
            if(isset( $field['default']))
            $saksh_ar[$name] =  $field['default'] ;

        }

    }
    /////// 

    $saksh[$group] = $saksh_ar;
//delete_option("aistore_escrow_payment_optons");
    add_option('aistore_escrow_payment_optons', $saksh);

    update_option('aistore_escrow_payment_optons', $saksh);

    // print_r($saksh);
    

    
}

function aistore_crypto_setting_form()

{
    
    
    //delete_option("aistore_escrow_payment_optons");

   $saksh = get_option('aistore_escrow_payment_optons');

if(!$saksh)
        $saksh=array();


    //if (isset($_GET['set_default']))
   // {
        
        
        
        
   $saksh_default = get_option('aistore_escrow_default_setting');
   
   if($saksh_default <> true)
   {
   
  add_option('aistore_escrow_default_setting',  true);
  update_option('aistore_escrow_default_setting', true);
        
        
        
        
        $saksh_forms_fields = array();

        $saksh_forms_fields = apply_filters('saksh_escrow_settings', $saksh_forms_fields);

        foreach ($saksh_forms_fields as $group => $fields)
        {
      
            aistore_escrow_setting_set_default_value($group, $fields );

        }
        
   }
   // }

    if (isset($_POST['submit']))
    {
 

        $group = $_REQUEST['group'];

        $saksh[$group] = $_REQUEST;
//delete_option("aistore_escrow_payment_optons");
        add_option('aistore_escrow_payment_optons', $saksh);

        update_option('aistore_escrow_payment_optons', $saksh);

    }

    //$saksh = get_option('aistore_escrow_payment_optons');
    

    $saksh_forms_fields = array();

    $saksh_forms_fields = apply_filters('saksh_escrow_settings', $saksh_forms_fields);
    

     echo '<div class="b5">';
     

   
     
    // $url=  admin_url('?page=saksh_escrow_settings&set_default=2') ;
     
     echo '<h2>Settings option for the Saksh Escrow system.</h2>';
     
     
       echo '<br/>We already configure the extension you can edit the defaults values.';
       
       
    echo " <br/><br/><strong> Whatsapp +91 8840574997 or +91  9559190379 for any support </strong><br/><br/>  https://api.whatsapp.com/send?phone=919559190379&text=Hello%20via%20sakshstore.com <br/><br/>";
    
    
       
   // echo '<a class="btn btn-primary" href="'.esc_url($url).'" role="button">Configure Automatically</a>';
    
    

    echo '<nav>  <div class="nav nav-tabs" id="nav-tab" role="tablist">';

    $active = "active";
    foreach ($saksh_forms_fields as $group => $field)
    {

        echo '    <button class="nav-link ' . $active . ' " id="nav-' . $group . '-tab" data-bs-toggle="tab" data-bs-target="#nav-' . $group . '" type="button" role="tab" aria-controls="nav-' . $group . '" aria-selected="true">' .     ucfirst(str_replace("_"," ", $group) ) . '</button> ';
        $active = "";
    }

    echo ' </div></nav>';

    echo '<div class="tab-content" id="nav-tabContent">';
    $active = "show active";

    foreach ($saksh_forms_fields as $group => $field)
    {

        echo ' <div class="tab-pane fade ' . $active . '" id="nav-' . $group . '" role="tabpanel" aria-labelledby="nav-' . $group . '-tab" tabindex="0">  ';

        // echo $group;
        print_form($group, $field,$saksh);

        echo '</div>';

        $active = "";

    }

    echo ' </div> ';

  echo ' </div> ';

}

function print_form($group, $fields,$saksh)
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
    
        
    
  
  
     $action=  admin_url('?page=saksh_escrow_settings') ;
     
     

    $pages = get_pages();

    echo " <strong>" .ucfirst(str_replace("_"," ",$group) )        . " </strong> ";
    
    
    echo "<form method='post' action='".esc_url($action)."' >";

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
            
            echo "<input class='form-control  input saksh_input' type='text'   id='" . $name. "'name='" . $name. "'      value='" .$value . "' /> ";
 
        } 
        
        
        if ($field['type'] == "wp_editor")
        {
            
            
      

wp_editor( $value, $name, $args );





            //echo "<input class='form-control' type='text'   name='" . $name. "'   value='" .$value . "' /><br/>";
 
        }

        if ($field['type'] == "select")
        {

            echo " <select class='form-control  select saksh_select'  name='" . $name . "' >";

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

            echo "<select class='form-control   select saksh_select' name='" . $name. "' >";

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

    echo "<input type='submit' name='submit' value='save' /> ";
    echo "</form>  ";


}

