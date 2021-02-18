<?php

//controllers/controller.php

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }
    /** Display home page */
    function home()
    {

        $view = new Template();
        echo $view->render('views/home.html');
        //echo '<img src="images/food2.jpg">';
    }

    /** Display order1 page */
    function order()
    {
        //Add data from form1 to session array
        //var_dump($_POST);
        global $validator;
        global $dataLayer;
        global $order;

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
                $order->setFood($userFood); //setting data in food in order object
            }
            //data is not valid -> set an error in F3 hive
            else {
                $this->_f3->set('errors["food"]', "Food cannot be blank and must contain only characters");
            }
            //var_dump($_POST);
            if($validator->validMeal($userMeal)){
                $order->setMeal($userMeal);  //setting data in meal in order object
            }
            else{
                $this->_f3->set('errors["meal"]', "Select a meal");
            }

            //If there are no errors, redirect to /order2
            if(empty($this->_f3->get('errors'))){
                $_SESSION['order'] = $order;
                $this->_f3->reroute('/order2');  //GET = reroute, header = GET
            }
        }
        //var_dump($_POST);
        //$meals = getMeals();
        //var_dump($meals);
        $this->_f3->set('meals', $dataLayer->getMeals());
        //sticky form
        $this->_f3->set('userFood', isset($userFood) ? $userFood : "");
        $this->_f3->set('userMeal', isset($userMeal) ? $userMeal : "");

        //echo "Order Route";
        $view = new Template();
        echo $view->render('views/form1.html');

    }

    function order2()
    {
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
                    $condimentString = implode(", ", $userCondiments);
                    $_SESSION['order']->setCondiments($condimentString);
                }
                //data is not valid -> We've been spoofed
                else{
                    $this->_f3->set('errors["conds"]', "Go away, evildoer!");
                }

                //If there are no errors, redirect to /order2
                if(empty($this->_f3->get('errors'))){
                    $this->_f3->reroute('/summary');  //GET = reroute, header = GET
                }

                //send user to summary page //condiments are mandatory
                //$f3->reroute('/summary');
            }
        }

        $this->_f3->set('condiments', $dataLayer->getCondiments());

        //display a view
        //echo "Order 2 Route";
        $view = new Template();
        echo $view->render('views/form2.html');
    }

    function summary()
    {
        echo "<p>SESSION:</p>";
        var_dump($_SESSION);

        //echo "Summary Route";
        $view = new Template();
        echo $view->render('views/summary.html');

        //Clear the SESSION array
        session_destroy();
    }

}