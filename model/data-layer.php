<?php

/* model.data-layer.php
 * returns data for my app
 *
 */

class DataLayer
{
    /**
     * getMeals() returns an array of meals
     * @return string[]
     */
    function getMeals()
    {
        return array("breakfast", "2nd breakfast", "lunch", "dinner");
    }

    function getCondiments()
    {
        return array("mayonnaise", "ketchup", "mustard", "sriracha");
    }
}



