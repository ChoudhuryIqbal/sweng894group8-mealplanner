<?php
namespace Base\Repositories;

require_once __DIR__.'/../repositories/Repository.php';


use Base\Repositories\Repository;


class UserRepository extends Repository {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    public function checkUser($uname,$pwd){
      $query = $this->db->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
			$query->bind_param("ss",$uname,$pwd);
      $query->execute();
      $result = $query->get_result();
      $row = $result->fetch_assoc();
      return $row;
	  }

    public function find($username){
        $query = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $query->bind_param("s",$username);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    public function confirmEmail($email){
      $query = $this->db->prepare('UPDATE users SET activated = 1 WHERE email = ?');
			$query->bind_param("s",$email);
      $query->execute();
    }

    public function save($user){
        if(isset($this->id) && $this->find($user->id))
        {
            $this->update($user);
        }
        else {
            $this->insert($user);
        }
    }
    public function all(){
        return $this->db->query('SELECT * FROM users')->fetch_all();
    }
    // Not Implemented yet
    public function remove($object){
        $query = $this->db->prepare('DELETE FROM users WHERE id = ?');
        $query->bind_param(array(
            'id' => $food->id
        ));
    }

    public function insert($object){
        $today = date('Y-m-d');
        $query = $this->db->prepare('INSERT INTO users
                (username, password, email, joined, namefirst, namelast)
                VALUES(?,?,?,?,?,?)');
        $query->bind_param("ssssss",$object['username'],$object['password'],$object['email'],$today,$object['namefirst'],$object['namelast']);
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
