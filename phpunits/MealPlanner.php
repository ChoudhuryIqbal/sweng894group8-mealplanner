<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner.php                             Penn State (@) Capstone Group 8
///////////////////////////////////////////////////////////////////////////////
//    Wrapper for Object layer abstraction of Meal Planner web-app framework.  
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// $_SERVER (Mimic Environment) 
///////////////////////////////////////////////////////////////////////////////
//    Necessary for testing Web-Application code
///////////////////////////////////////////////////////////////////////////////
$_SERVER['DOCUMENT_ROOT'] = '../mobi.mealplanner/';

$_REQUEST = array();
$_REQUEST['userid'] = 1;               // Default to UserID 1 for testing

///////////////////////////////////////////////////////////////////////////////
// MealPlanner class
///////////////////////////////////////////////////////////////////////////////
class MealPlanner
{
    var $location;

    function __construct()
    {
    }

    function setLocation($location)
    {
        $this->location = $_SERVER['DOCUMENT_ROOT'] . $location . 'index.php';
    }

    function setVariables($arguments)
    {
        $_REQUEST = $arguments;
    }

    function execute()
    {
        ob_start();
        require_once($this->location);
        ob_end_clean();
    }
}

?>
