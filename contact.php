<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'email@example.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfuly!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm.. seems there is a problem, sorry!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if(
    !isset($_POST['contact-name']) || 
  !isset($_POST['contact-phone']) ||
  !isset($_POST['contact-address']) ||
    empty($_POST['contact-name']) ||
    empty($_POST['contact-phone']) ||
    empty($_POST['contact-address'])
) {
  
  if( empty($_POST['contact-name']) ) {
    $json_arr = array( "type" => "error", "msg" => $fillMsg );
    echo json_encode( $json_arr );    
  } else {

    $fields = "";
    if( !isset( $_POST['contact-name'] ) || empty( $_POST['contact-name'] ) ) {
      $fields .= "Name";
    }
    
    if( !isset( $_POST['contact-phone'] ) || empty( $_POST['contact-phone'] ) ) {
      if( $fields == "" ) {
        $fields .= "Phone";
      } else {
        $fields .= ", Phone";
      }
    }
    
    if( !isset( $_POST['contact-address'] ) || empty( $_POST['contact-address'] ) ) {
      if( $fields == "" ) {
        $fields .= "Address";
      } else {
        $fields .= ", Address";
      }
    }
    
    $json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
    echo json_encode( $json_arr );    
  
  }

} else {

  // Validate e-mail
  if (!preg_match("/^[a-zA-Z ]*$/",$_POST['contact-name']) == false ) {
    
    $msg = "Name: ".$_POST['contact-name']."\r\n";    
    $msg .= "Phone: ".$_POST['contact-phone']."\r\n";
    $msg .= "Address: ".$_POST['contact-address']."\r\n";
    if( isset( $_POST['textarea-message'] ) && $_POST['textarea-message'] != '' ) { $msg .= "Message: ".$_POST['textarea-message']."\r\n"; }
    
    $success = @mail($mailTo, $_POST['contact-name'], $msg, 'From: ' . $_POST['contact-name'] . '<' . $_POST['contact-name'] . '>');
    
    if ($success) {
      $json_arr = array( "type" => "success", "msg" => $successMsg );
      echo json_encode( $json_arr );
    } else {
      $json_arr = array( "type" => "error", "msg" => $errorMsg );
      echo json_encode( $json_arr );
    }
    
  } else {
     $json_arr = array( "type" => "error", "msg" => "Please enter valid email address!" );
    echo json_encode( $json_arr );  
  }

}