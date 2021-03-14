<?php
    /*
     * model/validate.php
     * Contains validation functions for Food app
     *
     */

class Validate
{
    private $_dataLayer;

    function __construct($dataLayer)
    {
        $this->_dataLayer = $dataLayer;
    }
    /** validFood() returns true if food is not empty and contains only letters
     * @param String $food
     * @return boolean
     */
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

    /** validMeal() returns true if the selected meal is in list of valid options */
    function validMeal($meal)
    {
        $validMeals = $this->_dataLayer->getMeals();
        return in_array($meal, $validMeals);
    }

    function validCondiments($selectedConds)
    {
        //get valid condiments from data layer
        $validCondiments = $this->_dataLayer->getCondiments();

        //check every selected condiment
        foreach ($selectedConds as $selected) {

            //if the selected condiment is not in the valid list, return false
            if (!in_array($selected, $validCondiments)) {
                return false;
            }
        }
        //if we haven't false by now, we're good!
        return true;
    }


}
