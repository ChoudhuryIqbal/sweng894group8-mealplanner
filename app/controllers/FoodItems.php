<?php
namespace Base\Controllers;

////////////////////////////////////////////////////////////
// Import dependencies. Can be replaced by autoload later //
////////////////////////////////////////////////////////////
require_once __DIR__.'/../core/Controller.php';
require_once __DIR__.'/../core/DatabaseHandler.php';
require_once __DIR__.'/../repositories/FoodItemRepository.php';



/////////////////////////////////////////////////////////////////////
// Load dependencies into current scope. Not the same as importing //
/////////////////////////////////////////////////////////////////////
use Base\Core\Controller;
use Base\Core\DatabaseHandler;
use Base\Repositories\FoodItemRepository;



class FoodItems extends Controller {

    private $foodItemRepository;

    public function __construct()
    {
        parent::__construct(...func_get_args());

        // Set FoodItemRepository
        /* TODO Find a way to inject it using the constructor (or other methods)
         * instead of creating it here
         */
        $dbh = DatabaseHandler::getInstance();
        $this->foodItemRepository = new FoodItemRepository($dbh->getDB());
    }

    public function index(){
        echo "In ".__CLASS__."@".__FUNCTION__;

        var_dump($this->foodItemRepository->all());
    }
}
