<?php
include_once "../../controllers/UserController.php";

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");


switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        $userController->logOut();
        break;

}