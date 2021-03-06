<?php
namespace Base\Repositories;
require_once __DIR__.'/../../vendor/autoload.php';

use Base\Repositories\Repository;
use Base\Helpers\Session;
use Base\Factories\RecipeFactory;

/**
 * SQL command wrapper for recipes
 */
class RecipeRepository extends Repository implements EditableModelRepository {
    private $db,
        $recipeFactory;

    public function __construct($db, $recipeFactory){
        $this->db = $db;
        $this->recipeFactory = $recipeFactory;
    }

    /**
     * Find a single recipe by id
     * @param  integer $id items's id
     * @return object  A recipe object
     */
    public function find($id){

        $query = $this->db->prepare('SELECT * FROM recipes WHERE id = ?');
        $query->bind_param("s", $id);
        if(!$query->execute()){
            return NULL;
        }
        $result = $query->get_result();

        if(!$result || !$result->num_rows){
            return NULL;
        }
        $recipeRow = $result->fetch_assoc();
        $recipe = $this->recipeFactory->make($recipeRow);

        return $recipe;
    }

    /**
     * Find a single recipe by name
     * @param  string $name The name of the recipe
     * @return object  A recipe object or null
     */

    public function findRecipeByName($name){

        $query = $this->db->prepare('SELECT * FROM recipes WHERE name = ?');
        $query->bind_param("s", $name);
        if(!$query->execute()){
            return NULL;
        }
        $result = $query->get_result();

        if(!$result || !$result->num_rows){
            return NULL;
        }
        $recipeRow = $result->fetch_assoc();
        $recipe = $this->recipeFactory->make($recipeRow);

        return $recipe;
    }

    /**
     * Inserts or updates a recipe in the database
     * @param  Base\Models\Recipe $recipe recipe to be saved
     * @return void
     */
    public function save($recipe){

        $success = false;
        if($recipe->getId() && $this->find($recipe->getId()))
        {
            $success = $this->update($recipe);
        }
        else {
            $success = $this->insert($recipe);
        }

        return $success;
    }

    /**
     * Get all recipes
     * @return array Associative array of recipes
     */
    public function all(){
        return $this->db->query('SELECT * FROM recipes ORDER by name')->fetch_all(MYSQLI_ASSOC);

        $error = $query->error;
        echo "\n" . __CLASS__ . "::" . __FUNCTION__ . ":" . $error . "\n";
    }

    /**
     * Get all recipes for a household
     * @param  Household $household [description]
     * @return array Associative array of recipes
     */
    public function allForHousehold($household){

        $query = $this->db->prepare('SELECT * FROM recipes WHERE householdId = ? ORDER by name');
        @$query->bind_param("i", $household->getId());

        if($query->execute()) {
          $result = $query->get_result();
          $recipeRows = $result->fetch_all(MYSQLI_ASSOC);

          if($recipeRows) {
            $collection = array();

            foreach($recipeRows as $recipeRow){
                $collection[] = $this->recipeFactory->make($recipeRow);
            }

          }
          else $collection = null;
        }
        else {
          $error = $query->error;
          echo "\n" . __CLASS__ . "::" . __FUNCTION__ . ":" . $error . "\n";
          $collection = null;
        }

        return $collection;

     }

    /**
     * Delete a recipe from the database
     * @param  integer $id  item's id
     * @return bool         Whether query was successful
     */
    public function remove($id){

        $query = $this->db->prepare('DELETE FROM recipes WHERE id = ?');
        $query->bind_param("s", $id);
        $bool = $query->execute();

        if(!bool) {
          $error = $query->error;
          echo "\n" . __CLASS__ ."::" . __FUNCTION__ . ":" . $error . "\n";
        }

        return $bool;
    }

    /**
     * Insert recipe into the database
     * @param  Base\Models\Recipe $recipe   Recipe to be stored
     * @return bool                     Whether query was successful
     */
    public function insert($recipe){
        $query = $this->db
            ->prepare('INSERT INTO recipes
                (name, directions, servings, source, notes, householdId)
                VALUES (?, ?, ?, ?, ?, ?)
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("ssissi",
            $recipe->getName(),
            $recipe->getDirections(),
            $recipe->getServings(),
            $recipe->getSource(),
            $recipe->getNotes(),
            //(new Session())->get('user')->getId(),
            (new Session())->get('user')->getCurrHousehold()->getId()

        );

        //$query->insert_id should return the id of the newly inserted row.
        $bool = $query->execute();

        if($bool) {
          $recipe->setId($query->insert_id);
        }
        else {
          $error = $query->error;
          echo "\n" . __CLASS__ ."::" . __FUNCTION__ . ":" . $error . "\n";

        }

        return $bool;
    }

    /**
     * Update recipe in database
     * @param  Base\Models\Recipe $recipe Recipe to be updated
     * @return bool                 Whether query was successful
     */
    public function update($recipe){
        $query = $this->db
            ->prepare('UPDATE recipes
                SET
                    name = ?,
                    directions = ?,
                    servings = ?,
                    source = ?,
                    notes = ?
                WHERE id = ?
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("ssissi",
            $recipe->getName(),
            $recipe->getDirections(),
            $recipe->getServings(),
            $recipe->getSource(),
            $recipe->getNotes(),
            $recipe->getId()
        );
        $bool = $query->execute();

        if(!$bool) {
          $error = $query->error;
          echo "\n" . __CLASS__ ."::" . __FUNCTION__ . ":" . $error . "\n";
        }
      return $bool;

    }

    /**
     * Check if recipe belongs to a household
     * @param  integer $reciped  Recipe's id
     * @param  integer $household  Current household
     * @return bool             Whether recipe belongs to household
     */
    public function recipeBelongsToHousehold($recipeId, $household)
    {
        $id = $household->getId();

        $query = $this->db->prepare('SELECT * FROM recipes WHERE id = ? AND householdId = ?');
        $query->bind_param("si", $recipeId, $id);
        $query->execute();

        $result = $query->get_result();
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

    /**
     * Count all recipes added by a household
     * @param  Household    $household Household to check
     * @return integer      Total recipes for household
     */
    public function countForHousehold($household){
        $query = $this->db->prepare('SELECT * FROM recipes WHERE householdId = ? ORDER by name');
        @$query->bind_param("i", $household->getId());
        $query->execute();

        $result = $query->get_result();

        return $result->num_rows;
    }
}
