<?php

/**Create a food order form*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require files
require_once('vendor/autoload.php');
require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

//Start a session
session_start();

//Create an instance of the Base class & instantiate classes
$f3 = Base::instance();
$dataLayer = new DataLayer($dbh);
$validator = new Validate($dataLayer);

$order = new Order();
$controller = new Controller($f3);

//fat-free debugging
$f3->set('DEBUG', 3);

//Define a default route (home page)
$f3->route('GET /', function() {
    //echo "Home Page";
    //Display a view
    global $controller;
    $controller->home();
});

//Define a order route
$f3->route('GET|POST /order', function() {

    global $controller;
    $controller->order();

});

//Define an order2 route
$f3->route('GET|POST /order2', function() {

    global $controller;
    $controller->order2();

});

//Define a summary route
$f3->route('GET /summary', function() {

    //echo "<p>POST:<p>";
    //var_dump($_POST);           //post array only contains the most updated data

    //echo "<p>SESSION:<p>";
    //var_dump($_SESSION);        //session array most secure array for data

    global $controller;
    $controller->summary();

});

//Define a order summary route
$f3->route('GET /order-summary', function() {

    global $controller;
    $controller->orderSummary();

});

$f3->route('POST /lookup', function() {

    global $controller;
    $controller->lookup();
});



//Run fat free
$f3->run();