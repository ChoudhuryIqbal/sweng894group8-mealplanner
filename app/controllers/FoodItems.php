<?php
namespace Base\Controllers;

// Autoload dependencies
require_once __DIR__.'/../../vendor/autoload.php';


//////////////////////
// Standard classes //
//////////////////////
use Base\Core\Controller;
use Base\Core\DatabaseHandler;
use Base\Helpers\Session;
use Base\Helpers\Redirect;
use Base\Helpers\Format;
use \Valitron\Validator;

///////////////////////////
// File-specific classes //
///////////////////////////
use Base\Models\FoodItem;
use Base\Repositories\FoodItemRepository;
use Base\Repositories\UnitRepository;
use Base\Repositories\CategoryRepository;



class FoodItems extends Controller {

    private $foodItemRepository;
    private $dbh;

    public function __construct()
    {
        parent::__construct(...func_get_args());

        // Set FoodItemRepository
        /* TODO Find a way to inject it using the constructor (or other methods)
         * instead of creating it here
         */
        $this->dbh = DatabaseHandler::getInstance();
        $this->foodItemRepository = new FoodItemRepository($this->dbh->getDB());
    }

    public function index(){
        // echo "In ".__CLASS__."@".__FUNCTION__;
        $foods = $this->foodItemRepository->allForUser($_SESSION['id']);
        $this->view('food/index', compact('foods'));
    }

    public function edit($id){
        $db = $this->dbh->getDB();
        $categoryRepository = new CategoryRepository($db);
        $unitRepository = new UnitRepository($db);

        // Get user's categories, and list of units
        $categories = $categoryRepository->allForUser($_SESSION['id']);
        $units = $unitRepository->all();

        // Get food details
        $food = $this->foodItemRepository->find($id);

        $this->view('food/edit', compact('food', 'categories', 'units'));
    }

    public function create(){
        $db = $this->dbh->getDB();
        $categoryRepository = new CategoryRepository($db);
        $unitRepository = new UnitRepository($db);

        // Get user's categories, and list of units
        $categories = $categoryRepository->allForUser($_SESSION['id']);
        $units = $unitRepository->all();

        $this->view('food/create', compact('categories', 'units'));
    }

    public function store(){

        $input = $_POST;

        Session::flashOldInput($input);

        // Validate input
        $this->validateInput($input, 'create');

        // Find unit and category
        $db = $this->dbh->getDB();
        $categoryRepository = new CategoryRepository($db);
        $unitRepository = new UnitRepository($db);

        // Get user's categories
        $category = $categoryRepository->find($input['category_id']);
        $unit = $unitRepository->find($input['unit_id']);

        $food = new FoodItem();
        $food->setName($input['name']);
        $food->setStock($input['stock']);
        $food->setCategory($category);
        $food->setUnit($unit);
        $food->setUnitsInContainer($input['units_in_container']);
        $food->setContainerCost($input['container_cost']);
        $food->setUnitCost();

        $this->foodItemRepository->save($food);

        // Flash success message and flush old input
        Session::flashMessage('success', ucfirst($food->getName()).' was added to your list.');
        Session::flushOldInput();

        // Redirect back after updating
        Redirect::toControllerMethod('FoodItems', 'index');
        return;
    }

    public function delete($id){
            $food = $this->foodItemRepository->find($id);

            // If food doesn't exist, load 404 error page
            if(!$food){
                Redirect::toControllerMethod('Errors', 'show', array('errorCode' => 404));
                return;
            }

            // If food doesn't belong to user, do not delete, and show error page
            if(!$this->foodItemRepository->foodBelongsToUser($id, $_SESSION['id'])){
                Redirect::toControllerMethod('Errors', 'show', array('errorCode' => 403));
                return;
            }

            $this->foodItemRepository->remove($id);

            Session::flashMessage('success', $food['name'].' was removed from your items.');

            // Redirect to list after deleting
            $this->index();
            return;

    }

    public function update($id){
        $foodArray = $this->foodItemRepository->find($id);
        $this->checkFoodBelongsToUser($id);

        $input = $_POST;

        $this->validateInput($input, 'edit', [$id]);


        // Find unit and category
        $db = $this->dbh->getDB();
        $categoryRepository = new CategoryRepository($db);
        $unitRepository = new UnitRepository($db);

        // Get user's categories
        $category = $categoryRepository->find($input['category_id']);
        $unit = $unitRepository->find($input['unit_id']);

        $food = new FoodItem();
        $food->setId($id);
        $food->setName($input['name']);
        $food->setStock($input['stock']);
        $food->setCategory($category);
        $food->setUnit($unit);
        $food->setUnitsInContainer($input['units_in_container']);
        $food->setContainerCost($input['container_cost']);
        $food->setUnitCost();

        $this->foodItemRepository->save($food);

        // Flash success message
        Session::flashMessage('success', ucfirst($food->getName()).' was updated.');

        // Redirect back after updating
        Redirect::toControllerMethod('FoodItems', 'edit', array('foodId' => $food->getId()));
        return;
    }

    public function checkFoodBelongsToUser($id){
        // If food doesn't belong to user, show forbidden error
        if(!$this->foodItemRepository->foodBelongsToUser($id, $_SESSION['id'])){
            Redirect::toControllerMethod('Errors', 'show', array('errrorCode', '403'));
            return;
        }
    }

    private function validateInput($input, $method, $params = NULL){
        Session::flashOldInput($input);

        // Validate input
        $validator = new Validator($input);
        $twoSigDigFloatRegex = '/^[0-9]{1,4}(.[0-9]{1,2})?$/';
        $safeStringRegex = '/^[0-9a-z #\/\(\)-]+$/i';
        $rules = [
            'required' => [
                ['name'],
                ['category_id'],
                ['unit_id'],
                ['units_in_container'],
                ['container_cost'],
                ['stock']
            ],
            'integer' => [
                ['category_id'],
                ['unit_id']
            ],
            'regex' => [
                ['name', $safeStringRegex],
                ['units_in_container', $twoSigDigFloatRegex],
                ['container_cost', $twoSigDigFloatRegex],
                ['stock', $twoSigDigFloatRegex]
            ]
        ];
        $validator->rules($rules);
        $validator->labels(array(
            'category_id' => 'Category',
            'unit_id' => 'Unit'
        ));
        
        if(!$validator->validate()) {

            $errorMessage = Format::validatorErrors($validator->errors());
            // Flash danger message
            Session::flashMessage('danger', $errorMessage);

            // Redirect back with errors
            Redirect::toControllerMethod('FoodItems', $method, $params);
            return;
        }
    }
}
