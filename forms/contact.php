<?php


// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'farooqsarwar953@gmail.com';

if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
  include( $php_email_form );
} else {
  die( 'Unable to load the "PHP Email Form" Library!');
}

$booking = new PHP_Email_Form;
$booking->ajax = true;

$booking->to = $receiving_email_address;
$booking->from_name = $_POST['name'];
$booking->from_email = $_POST['email'];
$booking->subject = 'Table Booking Request';

// Collecting data for booking a table
$booking->add_message( $_POST['name'], 'Name');
$booking->add_message( $_POST['email'], 'Email');
$booking->add_message( $_POST['phone'], 'Phone Number');
$booking->add_message( $_POST['date'], 'Date');
$booking->add_message( $_POST['time'], 'Time');
$booking->add_message( $_POST['people'], 'Number of People', 10);
$booking->add_message( $_POST['special_requests'], 'Special Requests', 20);

echo $booking->send();
?>
