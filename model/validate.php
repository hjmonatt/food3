<?php
    /*
     * model/validate.php
     * Contains validation functions for Food app
     *
     */

/** validFood() returns true if food is not empty and contains only letters */
function validFood($food)
{
    //$validFoods = array("tacos", "eggs", "pizza");
    // && in_array(strtolower($food), $validFoods);
    //$food = trim($food);

    /*
    if(!empty($food) && ctype_alpha($food))
        return true;
    else
        return false;
    */

    return !empty($food) && ctype_alpha($food);
}