<?php
namespace Base\Models;
require_once __DIR__.'/../../vendor/autoload.php';

class GroceryListItem {
    private
        $id,
        $name,
        $stock,
        $unit,
        $foodItem,
        $amount,
        $containerCost,
        $unitCost;

    public function setId($id)
    {
        if(!$id)
        {
            throw new \Exception("Id cannot be empty", 1);
        }

        $id = intval($id);
        if($id < 1){
            throw new \Exception("Id must be greater than 0", 1);
        }

        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set grocery list item's associated foodItem
     * @param FoodItem $foodItem Grocery list item's foodItem
     */
    public function setFoodItem($foodItem):void
    {
        $this->foodItem = $foodItem;
    }

    /**
     * Get grocery list item's associated foodItem
     * @return FoodItem Grocery list item's foodItem
     */
    public function getFoodItem():FoodItem{
        return $this->foodItem;
    }

    /**
     * Set how much of the item the user has to buy
     * @param float $amount Amount
     */
    public function setAmount($amount):void {
        if(!preg_match_all('/^\d+(\.\d+)?$/', $amount)){
            throw new \Exception("Amount must be numeric", 1);
        }

        if($amount <= 0 || $amount > 9999.99){
            throw new \Exception('Amount must be a positive number below 9999.99', 1);
        }
        $this->amount = floatval($amount);
    }

    /**
     * Get how much of the item the user has to buy
     * @return float Amount
     */
    public function getAmount():float{
        return $this->amount;
    }

}
