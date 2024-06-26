<?php

include_once "C:/xampp/htdocs/progWeb/models/User.php";
include_once "C:/xampp/htdocs/progWeb/repositories/UserRepository.php";
include_once "C:/xampp/htdocs/progWeb/services/UserService.php";

class UserController
{
    private UserRepository $userRepository;
    private UserService $userService;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userService = new UserService($this->userRepository);
    }

    public function getAllUsers()
    {
        try {
            $allUsers = $this->userService->getAllUsers();

            http_response_code(200);
            echo json_encode(["message" => "Se ha obtenido los datos de los usuarios", "statusCode" => 200, "data" => $allUsers]);

        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo json_encode(["error" => $exception->getMessage(), "statusCode" => $exception->getCode()]);
        }
    }

    public function updateUser()
    {
        try {

            $datos = json_decode(file_get_contents("php://input"));

            if (!isset($datos->userName, $datos->userEmail, $_GET["userId"])) {
                throw new Exception("Error faltan crendenciales", 400);
            }

            $userId = $_GET["userId"];

            $user = new User();
            $user->setUserId($userId);
            $user->setUserEmail($datos->userEmail);
            $user->setUserName($datos->userName);

            $userData = $this->userService->updateUser($user);

            http_response_code(200);
            echo json_encode(["message" => "Se ha actualizado correctamente el usuario", "statusCode" => 200, "data" => ["userName" => $userData->getUserName(), "email" => $userData->getUserEmail(), "userRoles" => $userData->getUserRoles()]]);

        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo json_encode(["error" => $exception->getMessage(), "statusCode" => $exception->getCode()]);
        }
    }

    public function deleteUser()
    {
        try {

            if (!isset($_GET["userId"])) {
                throw new Exception("Error faltan crendenciales", 400);
            }


            $userId = $_GET["userId"];

            $user = new User();
            $user->setUserId($userId);

            $this->userService->deleteUser($user);

            http_response_code(200);
            echo json_encode(["message" => "Se ha borrado el usuario correctamente", "statusCode" => 200]);

        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo json_encode(["error" => $exception->getMessage(), "statusCode" => $exception->getCode()]);
        }
    }

    public function createUser()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"));

            if (!isset($datos->userName, $datos->userPassword, $datos->userEmail)) {
                throw new Exception("Error faltan crendenciales", 400);
            }

            $user = new User();
            $user->setUserName($datos->userName);
            $user->setUserEmail($datos->userEmail);
            $user->setUserPassword($datos->userPassword);

            $this->userService->createUser($user);

            http_response_code(200);
            echo json_encode(["message" => "Se ha creado el usuario correctamente", "statusCode" => 200]);

        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo json_encode(["error" => $exception->getMessage(), "statusCode" => $exception->getCode()]);
        }
    }


    public function signIn()
    {
        try {
            $datos = json_decode(file_get_contents("php://input"));
            if (!isset($datos->userEmail, $datos->userPassword)) {
                throw new Exception("Error faltan crendenciales", 400);
            }

            $user = new User();
            $user->setUserEmail($datos->userEmail);
            $user->setUserPassword($datos->userPassword);

            $userData = $this->userService->signIn($user);

            http_response_code(200);
            echo json_encode(["message" => "Se ha iniciado sesión correctamente", "statusCode" => 200, "data" => ["userName" => $userData->getUserName(), "email" => $userData->getUserEmail(), "userRoles" => $userData->getUserRoles()]]);

        } catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo json_encode(["error" => $exception->getMessage(), "statusCode" => $exception->getCode()]);
        }
    }

    public function logOut()
    {
        $this->logOut();
        http_response_code(200);
        echo json_encode(["msg" => "Se ha cerrado sesión correctamente", "statusCode" => 200]);
    }
}

$userController = new UserController();