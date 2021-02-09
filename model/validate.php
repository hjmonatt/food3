<?php
    /*
     * model/validate.php
     * Contains validation functions for Food app
     *
     */

/** validFood() returns true if food is not empty */
function validFood($food)
{
    //$validFoods = array("tacos", "eggs", "pizza");
    return !empty(trim($food)); // && in_array(strtolower($food), $validFoods);
}