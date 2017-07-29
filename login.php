<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// Check login data sent from js
// If valid, save the customer data to the session

session_start();
if (isset($_SESSION["customer"])) {
    echo "You are logged in.";
    return;
}
$custm = array(
        "email" => clean_input($_GET["email"]),
        "pass"  => $_GET["pass"]
);

$xml = "../../data/customer.xml";
$dom = DOMDocument::load($xml);
$custms = $dom->getElementsByTagName("customer");
$result = "false";

foreach($custms as $oneCus)
{
    $email = $oneCus->getElementsByTagName("email");
    $email = $email->item(0)->nodeValue;

    $pass = $oneCus->getElementsByTagName("pass");
    $pass = $pass->item(0)->nodeValue;

    $id = $oneCus->getElementsByTagName("id");
    $id = $id->item(0)->nodeValue;

    $fname = $oneCus->getElementsByTagName("fname");
    $fname = $fname->item(0)->nodeValue;

    if ($custm["email"] == $email && $custm["pass"] == $pass)
    {
        $result = "true";
        $custm["id"] = $id;
        $custm["fname"] = $fname;
        $_SESSION["customer"] = $custm;
    }
}
echo $result;

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
