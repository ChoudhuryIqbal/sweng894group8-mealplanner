<?php
///////////////////////////////////////////////////////////////////////////////
// MealPlanner                              Penn State - Cohorts 19 & 20 @ 2018
///////////////////////////////////////////////////////////////////////////////
// Unit Class
///////////////////////////////////////////////////////////////////////////////
namespace Base\Models;
require_once __DIR__.'/../../vendor/autoload.php';

class Unit
{
    private
        $id,
        $name,
        $baseEqv;

    public function setId($id)
    {
        if(!$id)
        {
            throw new \Exception("Id cannot be empty", 1);
        }

        if(gettype($id) !== 'integer'){
            throw new \Exception("Id must be an integer", 1);
        }

        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    //////////
    // Name //
    //////////
    public function setName($name){
        $name = trim($name);

        /*
         * Regex rules:
         * - Only letters and parentheses
         * - Case insensitive
         * - From 1-20 characters
         */
        $regex = '/^[a-z\(\)]{1,20}$/i';

        if(!preg_match_all($regex, $name, $matches)){
            throw new \Exception(
                "Food Item name must only contain letters and parentheses, and must be 1-20 characters in length", 1);
        }

        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    //////////////////
    // Abbreviation //
    //////////////////
    public function setAbbreviation($abbreviation){
        $abbreviation = trim($abbreviation);

        if($abbreviation == ''){
            throw new \Exception(
                "Food Item abbreviation cannot be empty", 1);
        }

        if(strlen($abbreviation) > 4){
            throw new \Exception(
                "Food Item abbreviation cannot be longer than 4 characters", 1);
        }

        if(!preg_match_all('/^[a-z]+$/i', $abbreviation, $matches)){
            throw new \Exception(
                "Food Item abbreviation must be alphabetical", 1);
        }

        $this->abbreviation = $abbreviation;
    }

    public function getAbbreviation(){
        return $this->abbreviation;
    }


    public function setBaseEqv($eqv)
    {
        if($eqv <= 0){
            throw new \Exception("Base Equivalence must be greater than 0", 1);
        }
        $this->baseEqv = $eqv;
    }
    public function getBaseEqv(){
      return $this->baseEqv;
    }
}

?>
