<?php
namespace Base\Models;

class Recipe{
	private $name;
	private $description;
	private $servings;
	private $ingredients;
	private $source;
	private $notes;

	public function __construct($theName,$theDescription='',$theServings,$theSource='',$theNotes=''){
		$this->name = $theName;
		$this->description = $theDescription;
		$this->servings = $theServings;
		$this->ingredients = array();
		$this->source = $theSource;
		$this->notes = $theNotes;
	}
	public function addIngredient($anIngredient){
		$this->ingredients[] = $anIngredient;
	}
	public function removeIngredient($anIngredientName){
		for($i=0;$i<count($this->ingredients);$i++){
			if($this->ingredients[$i]->getName() == $anIngredientName)
				unset($this->ingredients[$i]);
		}
	}
	public function swapIngredient($old,$new){
		removeIngredient($old);
		addIngredient($new);
	}
	public function getIngredientByName($anIngredientName){
		for($i=0;$i<count($this->ingredients);$i++){
			if($this->ingredients[$i]->getFood()->getName() == $anIngredientName)
				return $this->ingredients[$i];
		}
	}
	public function getServings(){
		return $this->servings;
	}
	public function getIngredientQuantity($anIngredientName){
		return $this->getIngredientByName($anIngredientName)->getQuantity();
	}
}
?>
