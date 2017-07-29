<?php
// Student: VAN NHI NGUYEN (101256529)
// Assignment 2: COS30020 Web application Developments
// File function:
// add new customer to the system,
// validate inputs from customer
// create new xml if xml doesn't exists
// add new customer node to xml

session_start();
$newCus = array(
    "fname" => $_GET["fname"],
    "lname" => $_GET["lname"],
    "email" => $_GET["email"],
    "id"    => "",
    "pass"  => ""
);

$err = array(
    "fn" => "",
    "ln" => "",
    "em" => ""
);

// check xml exists ? continue : create new
$xml = new DomDocument();
if (!file_exists("../../data/customer.xml"))
{
    $root = $xml->createElement('customers');
    $xml->appendChild($root);
    $xml->save("../../data/customer.xml");
} else {
    $xml->load("../../data/customer.xml");
}

$xml->formatOutput = true;

// check if all inputs are entered
$newCus["fname"] == null ? $err["fn"] = "This field is required" : $err["fn"] = "";
$newCus["lname"] == null ? $err["ln"] = "This field is required" : $err["ln"] = "";
$newCus["email"] == null ? $err["em"] = "This field is required" : $err["em"] = "";

// check if email is unique
$emList = $xml->getElementsByTagName("email");
if ($emList != null)
{
    foreach($emList as $em)
    {
        if ($newCus["email"] == $em->nodeValue)
        {
            $err["em"] = "Sorry someone else is using this email";
        }
    }
}

// generate id and pw when no error
if ($err["fn"] == "" && $err["ln"] == "" && $err["em"] == "")
{
    $newCus["id"]   = uniqid(rand(),true);   // generate an unique id
    $newCus["pass"] = md5($newCus["id"]);    // generate a pass from the id
    $to      = $newCus["email"];
    $subject = "Welcome to ShopOnline";
    $message = "Dear " + $newCus["fname"] + ", "
             + "welcome to use ShopOnline!"
             + "Your customer ID is " + $newCus["id"] + " "
             + "and the password is " + $newCus["pass"];
    $headers = "From registration@shoponline.com.au";

    mail($to, $subject, $message, $headers, "-r 101256529@student.swin.edu.au"); // TODO double check this line
    echo toXml($xml, $newCus);
}
else
{
    echo json_encode($err);
}

function toXml($xml, $newCus)
{
    $root = $xml->documentElement;
    // add new customer to xml
    $oneCus = $xml->createElement("customer");
    $oneCus = $root->appendChild($oneCus);

    $cusFn  = $xml->createElement("fname");
    $cusFn  = $oneCus->appendChild($cusFn);
    $cusFnV = $xml->createTextNode($newCus["fname"]);
    $cusFnV = $cusFn->appendChild($cusFnV);

    $cusLn  = $xml->createElement("lname");
    $cusLn  = $oneCus->appendChild($cusLn);
    $cusLnV = $xml->createTextNode($newCus["lname"]);
    $cusLnV = $cusLn->appendChild($cusLnV);

    $cusEm  = $xml->createElement("email");
    $cusEm  = $oneCus->appendChild($cusEm);
    $cusEmV = $xml->createTextNode($newCus["email"]);
    $cusEmV = $cusEm->appendChild($cusEmV);

    $cusId  = $xml->createElement("id");
    $cusId  = $oneCus->appendChild($cusId);
    $cusIdV = $xml->createTextNode($newCus["id"]);
    $cusIdV = $cusId->appendChild($cusIdV);

    $cusPw  = $xml->createElement("pass");
    $cusPw  = $oneCus->appendChild($cusPw);
    $cusPwV = $xml->createTextNode($newCus["pass"]);
    $cusPwV = $cusPw->appendChild($cusPwV);

    $xml->save("../../data/customer.xml");
    echo true;
}

// save cust to the session until destroy
$_SESSION["customer"] = $newCus;

 ?>
