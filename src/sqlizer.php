<?php

class SQLizer {

    // The SQLizer connection as a PDO object
    private $conn;
    // A message for humans indicating the status of the SQLizer.
    public $status;

    // Connection information
    public $message;

    // Name of the database
    public $database;

    // The constructor attempts to the establish a connection when the SQLizer object is created.
    public function __construct($db_host,$db_port,$db_user,$db_pass,$db_name) {
        // Attempt to establish a connection with the database.
        $this->conn = $this->Connect($db_host,$db_port,$db_user,$db_pass,$db_name);
    }

    private function Connect($db_host,$db_port,$db_user,$db_pass,$db_name) {
       // Try to establish a connection to the database.
       try{
            $conn = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $ex){
            // Set the connection to false if the connection attempt failed.
            $conn = false;
        }
        // If the settings are invalid, null properties, set and echo error status.
        if (!$conn) {
            $this->status = false;
            $this->message = "Failed to make a connection to the database. Check database configuration.";
        // If the settings are valid, set the properties and maintain connection.
        } else {
            $this->status = true;
            $this->message = "Connected to " . $db_name . " at " . $db_host . " as " . $db_user;
            $this->database = $db_name;
        }
        return $conn;
    }    

    // Run a SQL statement
    public function RunSQL($sql) {
        if ($this->status == false) {
            return ['SQLizer'=>'Error: Incorrect Database Settings'];
        }
        // Set the connection attribute to handle prepared statments.
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // If $sql is an array and the statement key is set, use it as the prepared statement.
        if (is_array($sql) and isset($sql['statement'])) {
            $statement = $sql['statement'];
        // If $sql is not an array, use $sql as the complete statement.
        } else {
            $statement = $sql;
        }
        // Try to prepare the statement.
        try {
            $stmt = $this->conn->prepare($statement);
        }
        // Fail if the statement is not valid.
        catch (PDOException $pdo_error) {
            echo 'Database Error' . "\n";
            echo $pdo_error->getMessage();
            die();
        }
        // If $sql['values'] are not set, set to a null array.
        if (!isset($sql['values'])) {
            $values = array();
        // Use the $sql['values'] if they exist.
        } else {
            $values = $sql['values'];
        }
        // Execute the statement.
        $stmt->execute($values);
        // For select statements
        if (isset($statement) and (substr(strtolower($statement),0,6) == 'select' or substr(strtolower($statement),0,4) == 'show')) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // For Insert statements. Return the last inserted ID.
        if (isset($statement) and substr(strtolower($statement),0,6) == 'insert') {
            $result = $this->conn->lastInsertId();
        }
        // If no rows exist in the results, return boolean false.
        if (!isset($result) or sizeof($result) < 1) {
            $result = false;
        }
        return $result;
    }

}
