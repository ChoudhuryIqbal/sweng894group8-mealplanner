<?php
namespace Base\Repositories;
require_once __DIR__.'/../../vendor/autoload.php';

use Base\Repositories\Repository;
use Base\Helpers\Session;
use Base\Factories\IngredientFactory;


class IngredientRepository extends Repository {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    /**
     * Find a single ingredient by id
     * @param  integer $id the ingredient's id
     * @return array       associative array of ingredient's details
     */
    public function find($id){

        $query = $this->db->prepare('SELECT * FROM ingredients WHERE id = ?');
        $query->bind_param("s", $id);
        $query->execute();
        $result = $query->get_result();
        $ingredientRow = $result->fetch_assoc();

        $ingredient = (new IngredientFactory($this->db))->make($ingredientRow);
        return $ingredient;

    }

    /**
     * Inserts or updates an ingredient in the database
     * @param  Base\Models\Ingredient $ingredient ingredient to be saved
     * @return void
     */
    public function save($ingredient){
        if($ingredient->getId() && $this->find($ingredient>getId()))
        {
          $success =   $this->update($ingredient);
        }
        else {
            $success = $this->insert($ingredient);
        }

        return $success;
    }

    /**
     * Get all ingredients
     * @return array Associative array of ingredients
     */
    public function all(){
        //return $this->db->query('SELECT * FROM recipes ORDER by name')->fetch_all(MYSQLI_ASSOC);
    }
    /**
     * Delete an ingredient from the database
     * @param  integer $id  ingredient's id
     * @return bool         Whether query was successful
     */
    public function remove($id){
      /*

        $query = $this->db->prepare('DELETE FROM recipes WHERE id = ?');
        $query->bind_param("s", $id);
        return $query->execute();
        */
    }

    /**
     * Insert ingredient into the database
     * @param  Base\Models\Ingredient $ingredient   Ingredient to be stored
     * @return bool                     Whether query was successful
     */
    //protected
    public function insert($ingredient){

        $query = $this->db
            ->prepare('INSERT INTO ingredients
                (foodid, recipeid, quantity, unit_id)
                VALUES (?, ?, ?, ?)
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("iidi",
            $ingredient->getFood()->getId(),
            $ingredient->getRecipeId(),
            $ingredient->getQuantity()->getValue(),
            $ingredient->getUnit()->getId()
        );

        $bool = $query->execute();
        if($bool) {
          $ingredient->setId($query->insert_id);
        }

        return $bool;

      //  return $query->execute();
    }

    /**
     * Update recipe in database
     * @param  Base\Models\Recipe $recipe Recipe to be updated
     * @return bool                 Whether query was successful
     */
    protected function update($recipe){
      /*
        $query = $this->db
            ->prepare('UPDATE recipes
                SET
                    name = ?,
                    description = ?,
                    servings = ?,
                    ingredients = ?,
                    source = ?,
                    notes = ?,
                WHERE id = ?
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("ssisssi",
            $recipe->getName(),
            $recipe->getDescription(),
            $recipe->getServings(),
            $recipe->getIngredients(),
            $recipe->getSource(),
            $recipe->getNotes(),
            $recipe->getId()
        );
        $query->execute();
*/
    }



}
