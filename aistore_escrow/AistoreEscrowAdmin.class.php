<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

class AistoreEscrowAdmin extends AistoreEscrowSystem
{
    // This function is used to admin release escrow button visible or not
    public function admin_release_escrow_btn_visible($escrow)
    {
        if ($escrow->payment_status != "paid") {
            return false;
        }

        //  if (aistore_isadmin() == $user_email) return "";
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "pending") {
            return false;
        }

        return true;
    }

    // This function is used to admin cancel escrow button visible or not
    function admin_cancel_escrow_btn_visible($escrow)
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }

        /*
            if ($escrow->payment_status == "paid") {
                return false;
            }
        */

        return true;
    }

    function admin_reject_payment_escrow_btn_visible($escrow)
    {
        if ($escrow->payment_status == "paid") {
            return false;
        }

        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }

        return true;
    }

    function admin_accept_payment_escrow_btn_visible($escrow)
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        }

        if ($escrow->payment_status == "paid") {
            return false;
        }

        return true;
    }

    function admin_remove_payment_escrow_btn_visible($escrow)
    {
        if ($escrow->status == "closed") {
            return false;
        } elseif ($escrow->status == "released") {
            return false;
        } elseif ($escrow->status == "cancelled") {
            return false;
        } elseif ($escrow->status == "disputed") {
            return false;
        }

        if ($escrow->payment_status != "paid") {
            return false;
        }

        return true;
    }

    //  This function is to escrow admin button action like released,cancelled
    public function aistore_escrow_btn_admin_actions($eid)
    {
        global $saksh;
        global $wpdb;

        $escrow = $this->AistoreGetEscrow($eid);

        $escrow_admin_user_id = $this->get_escrow_admin_user_id();

        $user_id = get_current_user_id();

        $email_id = get_the_author_meta("user_email", $user_id);
        $user_email = $email_id;

        $escrow_wallet = new AistoreWallet();

        if (isset($_POST["submit"]) and $_POST["action"] == "released") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            if (!$this->admin_release_escrow_btn_visible($escrow)) {
                return;
            }

            $escrow_fee_deducted =
                $saksh["escrow_settings"]["escrow_fee_deducted"];

            if ($escrow_fee_deducted == "released") {
                $message_admin_release_escrow_fee =
                    "Payment transfer fee for the admin release for the escrow  " .
                    $escrow->id;

                $escrow_wallet->aistore_transfer(
                    $escrow->receiver_user_id,
                    $escrow_admin_user_id,
                    $escrow->accept_escrow_fee,
                    $escrow->currency,
                    $message_admin_release_escrow_fee,
                    $escrow->id
                );
            }

            $message_admin_release_escrow_fee =
                "Payment transfer for the admin release for the escrow  " .
                $escrow->id;

            $escrow_wallet->aistore_transfer(
                $escrow_admin_user_id,
                $escrow->receiver_user_id,
                $escrow->amount,
                $escrow->currency,
                $message_admin_release_escrow_fee,
                $escrow->id
            );

            // $email_id = get_user_by("email", $escrow_reciever_email_id);

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'released'  WHERE  payment_status='paid' and  id = %d ",

                    $escrow->id
                )
            );

            $release_escrow_success_message = Aistore_process_placeholder_Text(
                $saksh["escrow_message"]["release_escrow_success_message"],
                $escrow
            );
            ?>
<div>
<strong> <?php echo esc_attr($release_escrow_success_message); ?></strong></div>
<?php
$escrow = $this->AistoreGetEscrow($escrow->id);
do_action("AistoreEscrowAdminReleased", $escrow);

        }

        // Sender Create escrow  to excute cancel button
        // Receiver  accept or cancel escrow
        if (isset($_POST["submit"]) and $_POST["action"] == "cancelled") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
            }

            if (!$this->admin_cancel_escrow_btn_visible($escrow)) {
                return;
            }

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET status = 'cancelled'  WHERE    id =  %d ",

                    $escrow->id
                )
            );

            $escrow = $this->AistoreGetEscrow($escrow->id);

            if ($escrow->payment_status == "paid") {
                $admin_cancel_escrow_message =
                    "Payment transfer for the cancel_escrow_message escrow id " .
                    $escrow->id;

                $escrow_wallet->aistore_transfer(
                    $escrow_admin_user_id,
                    $escrow->sender_user_id,
                    $escrow->amount,
                    $escrow->currency,
                    $admin_cancel_escrow_message,
                    $escrow->id
                );

                //    $cancel_escrow_fee = get_option("cancel_escrow_fee");

                $cancel_escrow_fee =
                    $saksh["escrow_settings"]["cancel_escrow_fee"];

                if ($cancel_escrow_fee == "yes") {
                    $message_admin_cancelled_escrow_fee =
                        "Payment transfer  for the admin fee refund when admin cancelled    the escrow  " .
                        $escrow->id;

                    $escrow_wallet->aistore_transfer(
                        $escrow_admin_user_id,
                        $escrow->sender_user_id,
                        $escrow->create_escrow_fee,
                        $escrow->currency,
                        $message_admin_cancelled_escrow_fee,
                        $escrow->id
                    );
                }
            }

            $admin_cancel_escrow_success_message =
                "Admin cancelled the escrow " . $escrow->id;
            ?>

 
<div>
<strong><?php echo esc_attr(
    $admin_cancel_escrow_success_message
); ?></strong></div>

<?php
$escrow = $this->AistoreGetEscrow($escrow->id);
do_action("AistoreEscrowAdminCancelled", $escrow);

        }

        if (isset($_POST["submit"]) and $_POST["action"] == "accept_payment") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
                exit();
            }

            //  $object_escrow = new AistoreEscrowSystem();

            //  $escrow_admin_user_id = $object_escrow->get_escrow_admin_user_id();

            $escrow = $this->AistoreGetEscrow($eid);

            if (!$this->admin_accept_payment_escrow_btn_visible($escrow)) {
                return;
            }

            $admin_accept_payment_message = Aistore_process_placeholder_Text(
                $saksh["escrow_message"]["admin_accept_payment_message"],
                $escrow
            );

            $escrow_wallet->aistore_transfer(
                $escrow->sender_user_id,
                $escrow_admin_user_id,
                $escrow->amount,
                $escrow->currency,
                $admin_accept_payment_message,
                $eid
            );

            $escrow_fee_debit_by_admin_message = Aistore_process_placeholder_Text(
                $saksh["escrow_message"]["escrow_fee_debit_by_admin_message"],
                $escrow
            );

            $escrow_wallet->aistore_transfer(
                $escrow->sender_user_id,
                $escrow_admin_user_id,
                $escrow->accept_escrow_fee,
                $escrow->currency,
                $escrow_fee_debit_by_admin_message,
                $escrow->id
            );

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'paid'  WHERE id = '%d' ",
                    $eid
                )
            );
            ?>
<div>
<strong><?php echo esc_attr($admin_accept_payment_message); ?></strong></div>

<?php
$escrow = $this->AistoreGetEscrow($eid);

do_action("AistoreEscrowAdminPaymentAccepted", $escrow);

        }

        if (isset($_POST["submit"]) and $_POST["action"] == "reject_payment") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
                exit();
            }

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'rejected'  WHERE id = '%d' ",
                    $eid
                )
            );

            $admin_reject_payment_message = Aistore_process_placeholder_Text(
                $saksh["escrow_message"]["admin_reject_payment_message"],
                $escrow
            );
            ?>
<div>
<strong><?php echo esc_attr($admin_reject_payment_message); ?></strong></div>

<?php
$escrow = $this->AistoreGetEscrow($eid);

do_action("AistoreEscrowAdminPaymentRejected", $escrow);

        }

        if (isset($_POST["submit"]) and $_POST["action"] == "remove_payment") {

            if (
                !isset($_POST["aistore_nonce"]) ||
                !wp_verify_nonce(
                    $_POST["aistore_nonce"],
                    "aistore_nonce_action"
                )
            ) {
                return _e("Sorry, your nonce did not verify", "aistore");
                exit();
            }

            $escrow_admin_user_id = $this->get_escrow_admin_user_id();

            $escrow = $this->AistoreGetEscrow($eid);

            if (!$this->admin_remove_payment_escrow_btn_visible($escrow)) {
                return;
            }

            $admin_remove_payment_message = Aistore_process_placeholder_Text(
                $saksh["escrow_message"]["admin_remove_payment_message"],
                $escrow
            );

            $escrow_wallet->aistore_transfer(
                $escrow_admin_user_id,
                $escrow->sender_user_id,
                $escrow->amount,
                $escrow->currency,
                $admin_remove_payment_message,
                $eid
            );

            $escrow_wallet->aistore_transfer(
                $escrow_admin_user_id,
                $escrow->sender_user_id,
                $escrow->create_escrow_fee,
                $escrow->currency,
                $admin_remove_payment_message,
                $eid
            );

            $wpdb->query(
                $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}escrow_system
    SET payment_status = 'Pending'  WHERE id = '%d' ",
                    $eid
                )
            );
            ?>
<div>
<strong><?php echo esc_attr($admin_remove_payment_message); ?></strong></div>

<?php
$escrow = $this->AistoreGetEscrow($eid);

do_action("AistoreEscrowAdminRemovePayment", $escrow);

        }
    }

    //   This function is used to  admin Cancel Button
    function admin_cancel_escrow_btn($escrow)
    {
        if (!$this->admin_cancel_escrow_btn_visible($escrow)) {
            return;
        } ?>

 <form method="POST" action="" name="cancelled" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"  name="submit"   class="button button-primary  btn  btn-primary "    value="<?php _e(
      "Cancel Escrow",
      "aistore"
  ); ?>">
  <input type="hidden" name="action" value="cancelled" />
</form> <?php
    }

    //   This function is used to  admin Release Button
    public function admin_release_escrow_btn($escrow)
    {
        if (!$this->admin_release_escrow_btn_visible($escrow)) {
            return;
        } ?>

  
 <form method="POST" action="" name="released" enctype="multipart/form-data"> 
 
<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
  <input type="submit"    class="button button-primary  btn  btn-primary "    name="submit" value="<?php _e(
      "Release",
      "aistore"
  ); ?>">
  
  	<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr(
       $escrow->id
   ); ?>" />
  	
  	
  <input type="hidden" name="action" value="released" />
</form> <?php
    }

    public function admin_accept_payment_escrow_btn($escrow)
    {
        if (!$this->admin_accept_payment_escrow_btn_visible($escrow)) {
            return;
        } ?>

 <form method="POST" action="" name="accept_payment" enctype="multipart/form-data"> 

<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>
	<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr(
     $escrow->id
 ); ?>" />
<input 
 type="submit" name="submit" value="<?php _e(
     "Approve Payment",
     "aistore"
 ); ?>"/>
<input type="hidden" name="action" value="accept_payment" />
                </form>
              
                
                <?php
    }
    public function admin_reject_payment_escrow_btn($escrow)
    {
        if (!$this->admin_reject_payment_escrow_btn_visible($escrow)) {
            return;
        } ?>


  <form method="POST" action="" name="reject_payment" enctype="multipart/form-data"> 


<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>


 
		<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr(
      $escrow->id
  ); ?>" />	
		
<input 
 type="submit" name="submit" value="<?php _e("Reject Payment", "aistore"); ?>"/>
<input type="hidden" name="action" value="reject_payment" />
                </form>
                
             


<?php
    }

    public function admin_remove_payment_escrow_btn($escrow)
    {
        if (!$this->admin_remove_payment_escrow_btn_visible($escrow)) {
            return;
        } ?>


  <form method="POST" action="" name="remove_payment" enctype="multipart/form-data"> 


<?php wp_nonce_field("aistore_nonce_action", "aistore_nonce"); ?>



<input type="hidden" name="ecsrow_id" value="<?php echo esc_attr(
    $escrow->id
); ?>" />
		
		
<input 
 type="submit" name="submit" value="<?php _e("Remove Payment", "aistore"); ?>"/>
<input type="hidden" name="action" value="remove_payment" />
                </form>
                
             


<?php
    }
}
