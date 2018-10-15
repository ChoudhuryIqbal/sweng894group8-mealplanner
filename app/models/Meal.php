<?php
namespace Base\Models;
require_once __DIR__.'/../../vendor/autoload.php';

class Meal{
	private $id;
	private $recipe;
	private $date;
	private $isComplete;
	private $addedDate;
	private $scale;

	public function createMeal($r,$d,$s){

		$this->setRecipe($r);
		$this->setDate($d);
		$this->setScale($s);
		$this->isComplete = false;
		$this->addedDate = date('Y-m-d');
	}

	public function setScale($newScale){
		if(!$newScale)
		{
				$this->scale = 1.0;
				throw new \Exception("Scale cannot be empty. Defaulting to 1.0", 1);
		}

		if(gettype($newScale) !== 'double' AND gettype($newScale) !== 'integer' AND gettype($newScale) !== 'float'){
				throw new \Exception("Id must be a number", 1);
		}

		$this->scale = $newScale;
	}

	public function getScale($newScale){
		return $this->scale;
	}

	public function isComplete(){
		return $this->isComplete;
	}

	public function complete(){
		$this->isComplete = true;
	}

	public function markIncomplete(){
		$this->isComplete = false;
	}

	public function getIngredientQuantity($anIngredientName){
		return $this->recipe->getIngredientByName($anIngredientName)->getQuantity() * $this->scale;
	}

	public function getRecipe(){
		return $this->recipe;
	}

	public function getRecipeId(){
		return $this->recipe->getId();
	}

	public function setRecipe($aRecipe){
		if(!$aRecipe)
		{
			throw new \Exception("Meal must reference a Recipe")
		}
		$this->recipe = $aRecipe;
	}

	public function getId(){
		return $this->id;
	}

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

	public function getDate(){
		return $this->date;
	}

	public function getAddedDate(){
		return $this->addedDate;
	}

	public function setDate($newDate)
	{
			if(!$newDate)
			{
					throw new \Exception("Date cannot be empty", 1);
			}

			if(gettype($newDate) !== 'timestamp'){
					throw new \Exception("Date must be a timestamp", 1);
			}

			$this->date = $newDate;
	}
}
?>
