<?php
add_filter("after_aistore_escrow_form", "AFU_form_fields");

/**
 * This function is used to File to attach
 * @pdf
 * @xlsx
 * @ppt
 * @doc
 */
function AFU_form_fields($eid)
{
    $set_file = get_option("escrow_file_type"); ?>

	<label for="documents"><?php _e("File to attach", "aistore"); ?>: </label>
	
	
     <input type="file" name="file"    /><br>
     
     <div><p> <?php _e(
         "Note : We accept only " .
             $set_file .
             ' file and
	You can upload many pdf file then go to next escrow details page.',
         "aistore"
     ); ?></p></div>
	
	<?php
}

/**
       * This function is used to aistore escrow tab button
       * Files and documents
     
      */

add_filter("aistore_escrow_tab_button", "AFU_files_tab_button", 10);

function AFU_files_tab_button($escrow)
{
    ?>
      <button class="nav-link" id="nav-files-tab" data-bs-toggle="tab" data-bs-target="#nav-files" type="button" role="tab" aria-controls="nav-files" aria-selected="false">Files and documents</button>
      
      <?php
}

add_filter("aistore_escrow_tab_contents", "aistore_escrow_files_tab_contents");

function aistore_escrow_files_tab_contents($escrow)
{
    $eid = $escrow->id;

    if (isset($_POST["submit"]) and $_POST["action"] == "escrow_system") {
        if (
            !isset($_POST["aistore_nonce"]) ||
            !wp_verify_nonce($_POST["aistore_nonce"], "aistore_nonce_action")
        ) {
            return _e("Sorry, your nonce did not verify", "aistore");
            exit();
        }

        global $wpdb;

        $user_id = get_current_user_id();

        $set_file = get_option("escrow_file_type");

        $fileType = $_FILES["file"]["type"];

        if ($fileType == "application/" . $set_file) {
            $upload_dir = wp_upload_dir();

            if (!empty($upload_dir["basedir"])) {
                $user_dirname = $upload_dir["basedir"] . "/documents/" . $eid;

                if (!file_exists($user_dirname)) {
                    wp_mkdir_p($user_dirname);
                }

                $filename = wp_unique_filename(
                    $user_dirname,
                    $_FILES["file"]["name"]
                );

                move_uploaded_file(
                    sanitize_text_field($_FILES["file"]["tmp_name"]),
                    $user_dirname . "/" . $filename
                );

                $image =
                    $upload_dir["baseurl"] .
                    "/documents/" .
                    $eid .
                    "/" .
                    $filename;

                // save into database  $image
                $object_escrow = new AistoreEscrowSystem();

                $ipaddress = $object_escrow->aistore_ipaddress();

                $wpdb->query(
                    $wpdb->prepare(
                        "INSERT INTO {$wpdb->prefix}escrow_documents ( eid, documents,user_id,documents_name,ipaddress) VALUES ( %d,%s,%d,%s,%s)",
                        [$eid, $image, $user_id, $filename, $ipaddress]
                    )
                );
            }
        } else {
             ?>
            <p> <?php _e(
                "Note : We accept only " . $set_file . " file",
                "aistore"
            ); ?></p><?php
        }
    }
    ?>
     
   <div class="tab-pane fade   " id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
       
       
     <form method="POST" action="" name="escrow_system" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>

                
	<label for="documents"><?php _e("File to attach", "aistore"); ?>: </label>
    
    
     <input type="file" name="file"    /><br>
     
     
 <!--    <div><p> <?php _e(
     "Note : We accept only " .
         $set_file .
         ' file and-->
	<!--You can upload many pdf file then go to next escrow details page.',
     "aistore"
 ); ?></p>-->
	
	
	<!--</div>-->
	
<input 
 type="submit" class="button button-primary  btn  btn-primary "   name="submit" value="<?php _e(
     "Submit",
     "aistore"
 ); ?>"/>
 
 
<input type="hidden" name="action" value="escrow_system" />



 
 
 
 </form>
 
 
   <?php echo AFU_files($escrow); ?>
 
 
  </div>
     
      <?php
}

/**
       * This function is used to list escrow documents
       * @params eid
       * Documents files
       * Documents name
       * Date
     
      */

function AFU_files($escrow)
{
    //  print_r($escrow);

    $eid = $escrow->id;
    //   echo $eid;

    global $wpdb;

    $escrow_documents = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}escrow_documents WHERE eid=%d",
            $eid
        )
    );
    //   print_r($escrow_documents);

    foreach ($escrow_documents as $row): ?> 
	
	<div class="aistore_document_list">
   



<a href="<?php echo esc_url($row->documents); ?>" target="_blank">
	       <b><?php echo esc_attr($row->documents_name); ?></b></a>
	       <br />
  <h6 > <?php echo esc_attr($row->created_at); ?></h6>
  
<hr>
</div>

    
    <?php endforeach;
}
