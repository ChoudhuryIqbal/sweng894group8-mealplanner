<?php
namespace Base\Repositories;
require_once __DIR__.'/../../vendor/autoload.php';

use Base\Repositories\Repository;
use Base\Helpers\Session;
use Base\Factories\RecipeFactory;


class RecipeRepository extends Repository {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    /**
     * Find a single recipe by id
     * @param  integer $id items's id
     * @return object  A recipe object
     */
    public function find($id){

        $query = $this->db->prepare('SELECT * FROM recipes WHERE id = ?');
        $query->bind_param("s", $id);
        if($query->execute()) {
          $result = $query->get_result();
          $recipeRow = $result->fetch_assoc();

          $recipe = (new RecipeFactory($this->db))->make($recipeRow);
          return $recipe;
        }
        else {
          $error = $query->error;
          echo "\n" . __CLASS__ . "::" . __FUNCTION__ . ":" . $error . "\n";
          return null;
        }

    }

    /**
     * Inserts or updates a recipe in the database
     * @param  Base\Models\Recipe $recipe recipe to be saved
     * @return void
     */
    public function save($recipe){

        if( $recipe->getId() && $this->find($recipe->getId()))
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
     * Get all recipes added by a user
     * @param  User $user [description]
     * @return array Associative array of recipes
     */
    public function allForUser($user){
        $query = $this->db->prepare('SELECT * FROM recipes WHERE user_id = ? ORDER by name');
        @$query->bind_param("s", $user->getId());

        if($query->execute()) {
          $result = $query->get_result();
          return $result->fetch_all(MYSQLI_ASSOC);
        }
        else {
          $error = $query->error;
          echo "\n" . __CLASS__ . "::" . __FUNCTION__ . ":" . $error . "\n";
          return null;
        }

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
    protected function insert($recipe){
        $query = $this->db
            ->prepare('INSERT INTO recipes
                (name, description, servings, source, notes, user_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("ssissi",
            $recipe->getName(),
            $recipe->getDescription(),
            $recipe->getServings(),
            $recipe->getSource(),
            $recipe->getNotes(),
            (new Session())->get('user')->getId()

        );

        //$query->insert_id should return the id of the newly inserted row.
        $bool = $query->execute();

        if($bool) {
          echo "\nrecipe id = ". $query->insert_id . "\n";
          $recipe->setId($query->insert_id);
        }
        else {
          $query->error;
          echo "\n" . __CLASS__ ."::" . __FUNCTION__ . ":" . $error . "\n";

        }

        return $bool;
    }

    /**
     * Update recipe in database
     * @param  Base\Models\Recipe $recipe Recipe to be updated
     * @return bool                 Whether query was successful
     */
    protected function update($recipe){
        $query = $this->db
            ->prepare('UPDATE recipes
                SET
                    name = ?,
                    description = ?,
                    servings = ?,
                    source = ?,
                    notes = ?
                WHERE id = ?
            ');

        // @ operator to suppress bind_param asking for variables by reference
        // See: https://stackoverflow.com/questions/13794976/mysqli-prepared-statement-complains-that-only-variables-should-be-passed-by-ref
        @$query->bind_param("ssissi",
            $recipe->getName(),
            $recipe->getDescription(),
            $recipe->getServings(),
            $recipe->getSource(),
            $recipe->getNotes(),
            $recipe->getId()
        );
        $bool = $query->execute();

        if(!bool) {
          $query->error;
          echo "\n" . __CLASS__ ."::" . __FUNCTION__ . ":" . $error . "\n";
        }
      return $bool;

    }

    /**
     * Check if recipe belongs to a user_id
     * @param  integer $reciped  Recipe's id
     * @param  integer $userId  Current user's id
     * @return bool             Whether recipe belongs to user
     */
    public function recipeBelongsToUser($recipeId, $user)
    {
        $id = $user->getId();

        $query = $this->db->prepare('SELECT * FROM recipes WHERE id = ? AND user_id = ?');
        $query->bind_param("si", $recipeId, $id);
        $query->execute();

        $result = $query->get_result();
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

}
