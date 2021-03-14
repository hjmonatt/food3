<?php

/* model.dataLayer.php
 * returns data for my app
 *
 */

class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    function getOrders()
    {
        //Define the query
        $sql = "SELECT * FROM orders";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters

        //Execute
        $statement->execute();

        //Get results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        return $result;
    }

    function saveOrder($order)
    {

        //var_dump($order);
        //echo "<p>Saving order</p>";

        //Define the query
        $sql = "INSERT INTO orders(food, meal, condiments) 
	            VALUES (:food, :meal, :condiments)";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':food', $order->getFood(), PDO::PARAM_STR);
        $statement->bindParam(':meal', $order->getMeal(), PDO::PARAM_STR);
        $statement->bindParam(':condiments', $order->getCondiments(), PDO::PARAM_STR);

        //Execute
        $statement->execute();
        $id = $this->_dbh->lastInsertId();

    }

    /**
     * getMeals() returns an array of meals
     * @return string[]
     */
    function getMeals()
    {
        return array("breakfast", "2nd breakfast", "lunch", "dinner");
    }

    /**
     * getCondiments() returns an array of condiments
     * @return string[]
     */
    function getCondiments()
    {
        return array("mayonnaise", "ketchup", "mustard", "sriracha");
    }

    /** lookup() looks up a $food in the DB
     *  Used by an Ajax call
     *  prints 1 if found and 0 if not found
     *  @param string the food item
     */
    function lookup($food)
    {
        //Define the query
        $sql = "SELECT * FROM food WHERE food_name = :food";

        //Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(':food', $food, PDO::PARAM_STR);

        //Execute
        $statement->execute();

        //Print the result (return to Ajax call)
        $count = $statement->rowCount();
        echo $count > 0 ? 1 : 0;
    }

}



