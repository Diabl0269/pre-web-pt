<?php

require_once './CommonInterface.php';

class DatabaseInterface
{
    const debug = true;

    public function __construct()
    {
        $DB_URL = is_file("/.dockerenv") ? "db" : "127.0.0.1";
        $this->MySQLdb = new PDO("mysql:host=" . $DB_URL . ";dbname=forum", "root", "");
        $this->MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function GetMySQLdb()
    {
        return $this->MySQLdb;
    }

    /*
     * CheckErrors - if debug mode is set we will output the error in the response, if the debug is off we will be redirected to 404.php
     */
    public function CheckErrors($e, $pass = false)
    {
        if ($pass == true)
            return true;

        if (self::debug) {
            die($e->getMessage());
        } else {
            // return error if there is something strange in the database
            return_error(":)");
        }
    }

    public function GetTopics()
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT id,name,description FROM topics");
            $cursor->execute();

            return $cursor->fetchAll();
        } catch (PDOException $e) {
            $this->CheckErrors($e);
            return false;
        }
    }
    public function GetMessages($topicName)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT m.content, u.displayName  FROM messages m   JOIN users u  ON m.userId = u.id  JOIN topics t  ON m.topicId = t.id WHERE m.topicId = t.id AND t.name = :name");
            $cursor->execute(array(":name" => $topicName));

            return $cursor->fetchAll();
        } catch (PDOException $e) {
            $this->CheckErrors($e);
            return false;
        }
    }

    public function CreateMessage($content, $topic, $userId)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT id FROM topics WHERE name=:name");
            $cursor->execute(array(":name" => $topic));
            $topicId = $cursor->fetchAll()[0]["id"];

            $cursor = $this->MySQLdb->prepare("INSERT INTO messages (userId, content, topicId) VALUES (:userId, :content, :topicId)");
            $cursor->execute(array('userId' => $userId, 'content' => $content, 'topicId' => $topicId));
            return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
            return false;
        }
    }

    public function Register($username, $password, $displayName)
    {
        try {
            # Check if the username or displayName is taken
            $cursor = $this->MySQLdb->prepare("SELECT username FROM users WHERE username=:username OR displayName=:displayName");
            $cursor->execute(array(":username" => $username, ":displayName" => $displayName));
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }

        /* New User */
        if (!($cursor->rowCount())) {
            try {
                $cursor = $this->MySQLdb->prepare("INSERT INTO users (username, password, displayName,role) value (:username,:password,:displayName,false)");
                $cursor->execute(array(":password" => $password, ":username" => $username, ":displayName" => $displayName));
                return array("success" => true, "data" => "You have successfully registered");
            } catch (PDOException $e) {
                $this->CheckErrors($e);
            }
        }
        /* Already exists */else {
            return array("success" => false, "data" => "Username or Display Name already exists in the system");
        }
    }

    public function Update($id, $oldUsername, $oldDisplayName, $username, $password, $displayName)
    {
        $query = "";
        $queryMap = array();
        if ($username !== $oldUsername) {
            $query = $query . "username=:username";
            $queryMap = array_merge($queryMap, array(":username" => $username));
        }
        if ($oldDisplayName !== $displayName) {
            $displayNameQuery = "displayName=:displayName";
            $query = strlen($query) > 0 ? "OR " . $displayNameQuery : $displayNameQuery;
            $queryMap = array_merge($queryMap, array(":displayName" => $displayName));
        }
        if (strlen($query) > 0) {
            try {
                # Check if the username or displayName is taken
                $cursor = $this->MySQLdb->prepare("SELECT username FROM users WHERE " . $query);
                $cursor->execute($queryMap);

                if ($cursor->rowCount()) {
                    return return_error("Username or Display Name already exists in the system");
                }
            } catch (PDOException $e) {
                $this->CheckErrors($e);
                return return_error("Server error");
            }
        }

        /* Update User */
        try {
            $arr = array(":id" => $id, ":username" => $username, ":displayName" => $displayName);
            $update_fields = "username=:username, displayName=:displayName";
            if ($password) {
                $update_fields = $update_fields . ", password=:password";
                $arr = array_merge($arr, array(":password" => $password));
            }

            $cursor = $this->MySQLdb->prepare("UPDATE users SET " . $update_fields . " WHERE id=:id");
            $cursor->execute($arr);
            return array("data" => "You have successfully updated your profile", "username" => $username, 'displayName' => $displayName);
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
    }

    public function CreateTopic($name, $description)
    {
        try {
            $cursor = $this->MySQLdb->prepare("INSERT INTO topics (name, description) VALUES (:name, :description)");
            $cursor->execute(array(":name" => $name, ":description" => $description));
            return array("success" => true, "data" => "Topic created successfully");
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), "Duplicate")) {
                return return_error("Name already exists.");
            }
            $this->CheckErrors($e);
        }
    }

    public function UpdateTopic($id, $name, $description)
    {
        try {
            $cursor = $this->MySQLdb->prepare("UPDATE topics SET name=:name, description=:description WHERE id=:id");
            $cursor->execute(array(":name" => $name, ":description" => $description, ":id" => $id));
            return array("success" => true, "data" => "Topic updated successfully");
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), "Duplicate")) {
                return return_error("Name already exists.");
            }
            $this->CheckErrors($e);
        }
    }

    public function DeleteTopic($id)
    {
        try {
            $cursor = $this->MySQLdb->prepare("DELETE FROM topics WHERE id=:id");
            $cursor->execute(array(":id" => $id));
            $cursor = $this->MySQLdb->prepare("DELETE FROM messages WHERE topicId=:id");
            $cursor->execute(array(":id" => $id));
            return array("success" => true, "data" => "Topic deleted successfully");
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
    }

    public function Login($username, $password)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
            $cursor->execute();
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }

        if (!$cursor->rowCount()) {
            return array("success" => false, "data" => "Wrong Username/Password!");
        } else {
            $cursor->setFetchMode(PDO::FETCH_ASSOC);
            return array("success" => true, "data" => $cursor->fetch());
        }
    }
}