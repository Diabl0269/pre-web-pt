<?php
require_once "./permissions.php";
require_once "./CommonInterface.php";
require_once "./DatabaseInterface.php";

$userid = $_SESSION["userid"];
$username = $_SESSION["user"];
$databaseObj = new DatabaseInterface();

$input = json_decode(file_get_contents('php://input'), false);

if (!is_object($input)) {
    return_error("nice try :)");
}

if (!isset($input->action)) {
    return_error("nice try :)");
}
switch ($input->action) {
    case "update_profile":
        if (
            $response = $databaseObj->Update($userid, $username, $input->data->username, $input->data->password)
        ) {
            if (array_key_exists("username", $response)) {
                $_SESSION["user"] = $response["username"];
            }
            return_success($response);
        } else {
            return_error("Malformed request");
        }
        break;

    case "get_all_transactions":
        if ($data = $databaseObj->GetUserTransactions($userid)) {
            return_success($data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "new_transaction":
        if ($databaseObj->NewTransaction($userid, $username, $input->data)) {
            return_success($input->data);
        } else {
            return_error("Malformed request");
        }
        break;

    case "logout":
        session_destroy();
        return_success("logged out");
        break;

    default:
        return_error("Malformed request");
}