<?php
error_reporting(E_ALL);
spl_autoload_register(function ($class_name) {
    include 'classes/'.$class_name . '.php';
});
//--Include mailchimp class
include "classes/vendor/autoload.php";

$config = parse_ini_file('config/config.ini', TRUE);

try {
    $db = new Db($config['database']);
    $view = new View();
    $application = new Application($db, $view, $config);
    if(isset($_REQUEST['action'])){
        $action = preg_replace('/[^a-z]/i','', $_REQUEST['action']);
    }
    else{
        $action = 'main';
    }

    $application->setAction($action, $_REQUEST);
}
catch(Throwable $e){
    die($e->getCode().':'.$e->getMessage());
}
?>