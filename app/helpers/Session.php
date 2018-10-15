<?php

namespace Base\Helpers;
require_once __DIR__.'/../../vendor/autoload.php';

class Session{

    /**
     * Stores temporary messages in the session
     * @param  string $status  Type of alert. Must be one of: info, success, danger, warning
     * @param  string $message Message to show to user.
     * @return void
     */
    public static function flashMessage($status, $message){
        self::add('status', $status);
        self::add('message', $message);
    }

    /**
     * Displays a flashed (temporary) message and removes it from the session.
     * The message is displayed as a Bootstrap alert.
     * @return void
     */
    public static function renderMessage(){
        if(self::get('status') && self::get('message')){
            $html = '<div class="alert alert-dismissable alert-'.self::get('status').'" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.self::get('message').'</div>';
            echo $html;
            self::remove('status');
            self::remove('message');
        }
    }

    /**
     * Add a key-value pair to the session
     * @param string $key   Identifier to access value
     * @param string $value Value to be stored
     */
    public static function add($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function remove($key){
        unset ($_SESSION[$key]);
    }

    /**
     * Retrieve a key-value pair from the session
     * @param string $key   Identifier to access value
     * @return mixed        Value corresponding to key
     */
    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return;
    }

    /**
     * Store old input in the session. Used in combination with getOldInput to
     * repopulate forms that have errors.
     *
     * @param  array $oldInputs     Array of inputs to store for repopulation
     * @return void
     */
    public static function flashOldInput($oldInputs)
    {
        $_SESSION['old'] = array();
        foreach($oldInputs as $key => $value){
            $_SESSION['old'][$key] = $value;
        }
    }

    /**
     * Store old input in the session. Used in combination with getOldInput to
     * repopulate forms that have errors.
     *
     * @param  string $oldInputKey Field name in form
     * @return string              Old input value
     */
    public static function getOldInput($oldInputKey)
    {
        if(isset($_SESSION['old'][$oldInputKey])){
            $value = $_SESSION['old'][$oldInputKey];
            return $value;
        }
        return;
    }

    /**
     * Remove old input from session
     */
    public static function flushOldInput():void{
        unset($_SESSION['old']);
    }

    /**
     * Remove old input from session
     */
    public static function flush():void{
        $_SESSION = NULL;
    }



}
