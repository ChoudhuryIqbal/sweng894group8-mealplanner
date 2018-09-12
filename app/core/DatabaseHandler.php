<?php
namespace Base\Core;

date_default_timezone_set('America/New_York');
/**
 * Handle database connection
 */
class DatabaseHandler
{
    private static $host = 'localhost';
    private static $dbName   = 'capstone';
    private static $user = 'capstone';
    private static $pass = 'CmklPrew!';
    private static $charset = 'utf8';

    private static $instance = NULL;
    private $db;

    /**
     * Private constructor to prevent outside use
     */
    private function __construct(){}

    /**
     * Return an instance of itself, creating it if necessary
     * @return Base\Core\DatabaseHandler Instance of itself
     */
    public static function getInstance(){
        if(!self::$instance)
        {
            self::$instance = new DatabaseHandler();
            self::$instance->connect();
        }
        return self::$instance;
    }

    /**
     * Connect to the database
     * @return boolean Whether connection was successful
     */
    private function connect()
    {
        $this->db = new \mysqli('localhost', self::$user, self::$pass, self::$dbName);

        if($this->db->connect_errno > 0){
            return false;
        };
        return true;
    }

    /**
     * Return instance of database connection object
     * @return [type] [description]
     */
    public function getDB(){
        return $this->db;
    }

    /**
     * Disconnect from database
     * @return [type] [description]
     */
    public function disconnect()
    {
        $this->db->close();
    }

    public function __destruct()
    {
        if($this->db && $this->db->ping()){
            $this->disconnect();
        };
    }
}
