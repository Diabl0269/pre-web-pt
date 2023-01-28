<?php

require_once './CommonInterface.php';

class DatabaseInterface
{
    const debug = true;

    public function __construct()
    {
        $DB_URL = is_file("/.dockerenv") ? "db" : "127.0.0.1";
        $this->MySQLdb = new PDO("mysql:host=" . $DB_URL . ";dbname=bank", "root", "");
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

    public function GetUserTransactions($id)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM transactions WHERE user_from_id='" . $id . "' OR user_to_id='" . $id . "' ");
            $cursor->execute();
            $retval = "";

            foreach ($cursor->fetchAll() as $obj) {
                if ($obj["user_from_id"] == $id) {
                    $retval .= "<li class='speech-bubble-right'><p class='h2'>To: {$obj["user_to_name"]}</p><p>Amount: {$obj["amount"]}</p><input value='{$obj["transaction_id"]}' hidden></li>";
                } else {
                    $retval .= "<li class='speech-bubble-left'><p class='h2'>From: {$obj["user_from_name"]}</p><p>Amount: {$obj["amount"]}</p><input name='transaction_id' value='{$obj["transaction_id"]}' hidden></li>";
                }
            }

            return $retval;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function NewTransaction($userid, $username, $data)
    {
        try {
            // Validate the recipient exists
            $cursor = $this->MySQLdb->prepare("SELECT id FROM users WHERE username='" . $data->user_to_name . "'");
            $cursor->execute();
            if (!$cursor->rowCount())
                return false;

            $id_to = $cursor->fetch()["id"];

            $cursor = $this->MySQLdb->prepare("INSERT INTO transactions (user_from_id,user_from_name,user_to_id,user_to_name,amount) value (:user_from_id,:user_from_name,:user_to_id,:user_to_name,:amount)");
            $cursor->execute(array(":user_from_id" => $userid, ":user_from_name" => $username, ":user_to_id" => $id_to, ":user_to_name" => $data->user_to_name, ":amount" => $data->amount));
            if ($cursor->rowCount())
                return true;
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }
        return false;
    }

    public function Register($username, $password, $displayName)
    {
        try {
            # Check if the username or displayName is taken
            $cursor = $this->MySQLdb->prepare("SELECT username FROM users WHERE username=:username OR displayName:displayName");
            $cursor->execute(array(":username" => $username, ":displayName" => $displayName));
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }

        /* New User */
        if (!($cursor->rowCount())) {
            try {
                $cursor = $this->MySQLdb->prepare("INSERT INTO users (username, password, displayName) value (:username,:password,:displayName)");
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

    public function Update($id, $old_username, $username, $password)
    {
        if ($username !== $old_username) {
            try {
                # Check if the username is taken
                $cursor = $this->MySQLdb->prepare("SELECT username FROM users WHERE username=:username");
                $cursor->execute(array(":username" => $username));

                if ($cursor->rowCount()) {
                    return return_error("username already exists in the system");
                }
            } catch (PDOException $e) {
                $this->CheckErrors($e);
                return return_error("username already exists in the system");
            }
        }

        /* Update User */
        try {

            $arr = array(":id" => $id, ":username" => $username);
            $update_fields = "username=:username";
            if ($password) {
                $update_fields = $update_fields . ", password=:password";
                $arr = array_merge($arr, array(":password" => $password));
            }

            $cursor = $this->MySQLdb->prepare("UPDATE users SET " . $update_fields . " WHERE id=:id");
            $cursor->execute($arr);
            return array("data" => "You have successfully updated your profile", "username" => $username);
        } catch (PDOException $e) {
            $this->CheckErrors($e);
        }

    }

    public function Login($username, $password)
    {
        try {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
            $cursor->execute();
        }
        //SQL injection
        catch (PDOException $e) {
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