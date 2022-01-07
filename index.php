<?php
    // initialize DB
    $dbconn = require_once("dbstr.php");

    require_once ("models/car.php");

    // prevent XSS
    $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // check for bearer token
    require_once("middleware/token.php");

    // simple routing from $_GET['path];
    $path = $_GET['path'] ?? '';
    $path = explode ("/", $path);

    /*
     Request method:
     - GET for view all or search by query parameters
        -- list: list all or search by query parameters
        -- get: get the details of an record
     - POST for update or insert (upsert)
     - DELETE for delete by id
    */
    
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $response = null;

    if ( ! empty ( $path[0] ) )
    {
        $car = new Car($dbconn);
        if ( $path[0] == "upsert" && $method == "POST" ) {
            $response = $car->upsert($_POST);
        }
        else if ( $path[0] == "delete" && $method == "DELETE" ) {
            $response = $car->delete($path[1]??null);
        }
        else if ( $path[0] == "get" && $method == "GET" ) {
            $response = $car->get($path[1]??null);
        }
        else if ( $path[0] == "list" && $method == "GET" ) {
            $response = $car->list($_GET);
        }
    }

    if ( ! empty ( $response ) )
        die (json_encode($response));

    require_once ( "views/home.php" );

?>