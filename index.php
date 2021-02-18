<?php

/**Create a food order form*/

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();
$validator = new Validate();
$dataLayer = new DataLayer();

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
$f3->route('GET|POST /order', function($f3) {

    //Add data from form1 to session array
    //var_dump($_POST);
    global $validator;
    global $dataLayer;


    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') // this statement is false on the first viewing...$_SERVER array always exists and is available, where we come from
    {
        //Get data from the POST array
        $userFood = trim($_POST['food']);
        $userMeal = $_POST['meal'];

        //If the data is valid --> store in session Version B
//        if($GLOBALS['validator']->validFood($userFood)){
//            $_SESSION['food'] = $userFood;
//        }
        if($validator->validFood($userFood)){
            $_SESSION['food'] = $userFood;
        }
        //data is not valid -> set an error in F3 hive
        else {
            $f3->set('errors["food"]', "Food cannot be blank and must contain only characters");
        }
        //var_dump($_POST);
        if($validator->validMeal($userMeal)){
            $_SESSION['meal'] = $userMeal;
        }
        else{
            $f3->set('errors["food"]', "Select a meal");
        }

        //If there are no errors, redirect to /order2
        if(empty($f3->get('errors'))){
            $f3->reroute('/order2');  //GET = reroute, header = GET
        }
    }


    //var_dump($_POST);
    //$meals = getMeals();
    //var_dump($meals);
    $f3->set('meals', $dataLayer->getMeals());
    //sticky form
    $f3->set('userFood', isset($userFood) ? $userFood : "");
    $f3->set('userMeal', isset($userMeal) ? $userMeal : "");

    //echo "Order Route";
    $view = new Template();
    echo $view->render('views/form1.html');
});

//Define an order2 route
$f3->route('GET|POST /order2', function($f3) {

    global $validator;
    global $dataLayer;

    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') // this statement is false on the first viewing...$_SERVER array always exists and is available, where we come from
    {
        //if condiments were selected
        if(isset($_POST['conds'])){

            //get condiments from POST array
            $userCondiments = $_POST['conds'];

            //data is valid -> add to session
            if($validator->validCondiments($userCondiments)){
                $_SESSION['conds'] = implode(", ", $userCondiments);
            }
            //data is not valid -> We've been spoofed
            else{
                $f3->set('errors["conds"]', "Go away, evildoer!");
            }

            //If there are no errors, redirect to /order2
            if(empty($f3->get('errors'))){
                $f3->reroute('/summary');  //GET = reroute, header = GET
            }

            //send user to summary page //condiments are mandatory
            //$f3->reroute('/summary');
        }
        //send user to summary page //condiments are optional
        $f3->reroute('/summary');
    }

    $f3->set('condiments', $dataLayer->getCondiments());

    //display a view
    //echo "Order 2 Route";
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a summary route
$f3->route('GET /summary', function() {

    //echo "<p>POST:<p>";
    //var_dump($_POST);           //post array only contains the most updated data

    //echo "<p>SESSION:<p>";
    //var_dump($_SESSION);        //session array most secure array for data



    //echo "Summary Route";
    $view = new Template();
    echo $view->render('views/summary.html');

    //Clear the SESSION array
    session_destroy();

});


//Run fat free
$f3->run();