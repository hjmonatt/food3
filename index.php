<?php

/**Create a food order form*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');

//Create an instance of the Base class
$f3 = Base::instance();

//fat-free debugging
$f3->set('DEBUG', 3);

//Define a default route (home page)
$f3->route('GET /', function() {
    //echo "Home Page";
    //Display a view
    $view = new Template();
    echo $view->render('views/home.html');
    //echo '<img src="images/food2.jpg">';
});

//Define a order route
$f3->route('GET /order', function($f3) {

    //$meals = getMeals();
    //var_dump($meals);
    $f3->set('meals', getMeals());

    //echo "Order Route";
    $view = new Template();
    echo $view->render('views/form1.html');
});

//Define an order2 route
$f3->route('POST /order2', function($f3) {

    $f3->set('condiments', getCondiments());

    //Add data from form1 to session array
    //var_dump($_POST);
    if(isset($_POST['food'])){
        $_SESSION['food'] = $_POST['food'];
    }
    //var_dump($_POST);
    if(isset($_POST['meal'])){
        $_SESSION['meal'] = $_POST['meal'];
    }

    //display a view
    //echo "Order 2 Route";
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a summary route
$f3->route('POST /summary', function() {

    //echo "<p>POST:<p>";
    //var_dump($_POST);           //post array only contains the most updated data

    //echo "<p>SESSION:<p>";
    //var_dump($_SESSION);        //session array most secure array for data

    //add data from form 2 to session array
    if(isset($_POST['conds'])){
        $_SESSION['conds'] = implode(", ", $_POST['conds']);
    }

    //echo "Summary Route";
    $view = new Template();
    echo $view->render('views/summary.html');

});


//Run fat free
$f3->run();