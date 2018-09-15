<?php
namespace Base\Repositories;

require_once __DIR__.'/../repositories/Repository.php';


use Base\Repositories\Repository;


class FoodItemRepository extends Repository {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function find($id){
        $query = $this->db->prepare('SELECT * FROM food WHERE id = ?');
        $query->bind_param(array(
            'id' => $food->id
        ));
        return $query->execute() || NULL;
    }

    public function save($foodItem){
        if(isset($this->id) && $this->find($foodItem->id))
        {
            $this->update($foodItem);
        }
        else {
            $this->insert($foodItem);
        }
    }
    public function all(){
        return $this->db->query('SELECT * FROM food')->fetch_all();
    }
    public function remove($object){
        $query = $this->db->prepare('DELETE FROM food WHERE id = ?');
        $query->bind_param(array(
            'id' => $food->id
        ));
    }

    protected function insert($object){
        $query = $this->db
            ->prepare('INSERT INTO food
                (name, unitcost, userid)
                VALUES(?,?,?)');
        $query->bind_param(array(
            'name' => $food->name,
            'name' => $food->unitCost,
            'name' => $food->user_id,
        ));
        $query->execute();
    }

    protected function update($object){
        $query = $this->db
            ->prepare('UPDATE food
                SET name = ?, unitcost =?)
                VALUES(?,?)');
        $query->bind_param(array(
            'name' => $food->name,
            'name' => $food->unitCost,
        ));
        $query->execute();
    }
}