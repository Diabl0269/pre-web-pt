<?php
require_once "./permissions.php";
require_once "./CommonInterface.php";
require_once "./DatabaseInterface.php";

$userid = $_SESSION["userid"];
$username = $_SESSION["user"];
$displayName = $_SESSION["displayName"];
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
            $response = $databaseObj->Update($userid, $username, $displayName, $input->data->username, $input->data->password, $input->data->displayName)
        ) {
            if (array_key_exists("username", $response)) {
                $_SESSION["user"] = $response["username"];
            }
            if (array_key_exists("displayName", $response)) {
                $_SESSION["displayName"] = $response["displayName"];
            }
            return_success($response);
        } else {
            return_error("Malformed request");
        }
        break;

    case "getTopics":
        if ($data = $databaseObj->GetTopics()) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "getMessages":
        if (!($input->topic || $input->topic)) {
            return return_error("Please supply a topic");
        }
        if ($data = $databaseObj->GetMessages($input->topic)) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "createMessage":
        if (!$input->content) {
            return return_error("Please supply a content");
        }
        if ($data = $databaseObj->CreateMessage($input->content, $input->topic, $userid)) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "createTopic":
        if (!($input->data->name && $input->data->description)) {
            return return_error("Please supply name and description");
        }
        if ($data = $databaseObj->CreateTopic($input->data->name, $input->data->description)) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "updateTopic":
        if (!($input->data->name && $input->data->description && $input->data->id)) {
            return return_error("Please supply name, description and ID");
        }
        if ($data = $databaseObj->UpdateTopic($input->data->id, $input->data->name, $input->data->description)) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "deleteTopic":
        if (!$input->id) {
            return return_error("Please supply ID");
        }
        if ($data = $databaseObj->DeleteTopic($input->id)) {
            return_success($data);
        } else {
            return_error("Server error");
        }

    case "logout":
        session_destroy();
        return_success("logged out");
        break;

    default:
        return_error("Malformed request");
}