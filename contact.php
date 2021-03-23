<?php
/*
 *  CONFIGURE EVERYTHING HERE
 * <!-- Credit https://bootstrapious.com/p/how-to-build-a-working-bootstrap-contact-form -->
 */

// an email address that will be in the From field of the email.
$from = 'Demo contact form <demo@domain.com>';

// subject of the email
$subject = 'New message from contact form';

// message that will be displayed when everything is OK :)
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message');



// If something goes wrong, we will display this message.
$errorMessage = 'There was an error while submitting the form. Please try again later';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);
function addToDB($from, $subject, $emailText) {

  $servername = "localhost";
  $username = "mailer";
  $password = "Asfdasd3423423;";
  $dbname = "contacts";
  $dateCreated = date("Y-m-d H:i:s");

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $from = filter_var($from, FILTER_SANITIZE_EMAIL);
  $sql = "INSERT INTO contacts (contacts.id, contacts.from, contacts.subject, contacts.emailText)
VALUES (DEFAULT, '"  . $from . "', '" . $subject . "','" . $emailText . "')";

  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }
  $conn->close();
}
try {
  if(count($_POST) == 0) throw new \Exception('Form is empty');
  $emailText = "";

  foreach ($_POST as $key => $value) {
    // If the field exists in the $fields array, include it in the email
    if (isset($fields[$key])) {
      $emailText .= "<b>$fields[$key]:</b> $value<br/>";
    }
  }
  // Send email
  if (addToDB($fields["email"], $subject, $emailText)) {
    $responseArray = array('type' => 'success', 'message' => $okMessage);

  } else {
    $responseArray = array('type' => 'danger', 'message' => 'Unable to send message.');
  }

}
catch (\Exception $e)
{
  $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}
// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $encoded = json_encode($responseArray);

  header('Content-Type: application/json');

  echo $encoded;
}
// else just display the message
else {
  echo $responseArray['message'];
}
?>
