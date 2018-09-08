<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                             Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// PHPUnit Module
///////////////////////////////////////////////////////////////////////////////
$PHPUnitOFF = $_SERVER['phpunit_off'] ?? FALSE;

function PHPUnitCheck($errors)
{
    global $PHPUnitOFF;

    if ($PHPUnitOFF)
    {
        return;
    }

    if (count($errors) > 0)
    {
        throw new Exception('Errors were generated.');
    }
}

?>
