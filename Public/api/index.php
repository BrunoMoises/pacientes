<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../vendor/autoload.php");
use App\Controller\PacienteController;

$pacienteController = new PacienteController();
$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];
$requestData = null;
$json = file_get_contents('php://input');
$requestData = json_decode($json);
$uriParts = explode("/", $requestUri);
$controller = $id = null;

// Remover as primeiras 3 partes da URI
for ($i = 0; $i < 3; $i++) {
    unset($uriParts[$i]);
}

// Reindexar o array e extrair o nome do controlador e o ID, se existir
$uriParts = array_values(array_filter($uriParts));
if (isset($uriParts[0])) {
    $controller = $uriParts[0];
}
if (isset($uriParts[1])) {
    $id = $uriParts[1];
}

switch ($requestMethod) {
    case 'GET':
        if ($controller !== null && $id === null) {
            echo $pacienteController->readAll();
        } elseif ($controller !== null && $id !== null) {
            echo $pacienteController->readById($id);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'POST':
        if ($controller !== null && $id === null) {
            echo $pacienteController->create($requestData);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'PUT':
        if ($controller !== null && $id !== null) {
            echo $pacienteController->update($id, $requestData);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    case 'DELETE':
        if ($controller !== null && $id !== null) {
            echo $pacienteController->delete($id);
        } else {
            echo json_encode(["result" => "invalid"]);
        }
        break;
    default:
        echo json_encode(["result" => "invalid request"]);
        break;
}