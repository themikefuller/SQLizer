<?php

// HOW TO USE THIS TEST
// Create a MySQL database and a MySQL user with all privileges.

// Replace these settings with your database settings.
$host     = 'localhost';
$port     = '3306';
$user     = 'sqlizer';
$password = 'password';
$name     = 'sqlizer';

// Load the sqlizer class
require_once '../src/sqlizer.php';

// Connect to the database
$sqlizer = new SQLizer($host,$port,$user,$password,$name);

// ---------------------------------------------------------------------


// TEST 1 - Create a Table
// Create a table with a simple statement.

// Set a name for the table
$table_name = 'sqlizer';

// This statement is unprepared and would be dangerous if the value of $table_name was untrusted.
$sql['statement'] = "create table if not exists $table_name (
                     id bigint primary key auto_increment not null,
                     data longtext,
                     timestamp bigint
                     )ENGINE=InnoDB";

// Run the SQL command.
$sqlizer->RuNSQL($sql);


// --------------------------
// --------------------------
// Unset the $sql array.
// Unsetting $sql is unncessary if the RunSQL method is performed within a function elsewhere. $sql would fall out of scope.
// $sql is used again later in this test, so best to keep it clean.
unset($sql);



// TEST 2 - Insert Data
// Insert data into the table with a prepared statement

// Set the value of the data to be inserted.
$data = "\nSQLizer test successful.\n\n";

// Set the timestamp to the current epoch time.
$timestamp = time();

// Prepare a statement within the 'statement' key value of the $sql array.
$sql['statement'] = "insert into $table_name (data,timestamp) values (:data,:timestamp)";

// Set the values as an array within the 'values' key value of the $sql array.
$sql['values'] = [':data'=>$data,':timestamp'=>$timestamp];
$result = $sqlizer->RunSQL($sql);

// Clean up for next test
unset($sql);
unset($data);



// TEST 3 - Select Data
// An INSERT will always return the last inserted primary key value.
// Use this value to select the data from this new row.
$data = null;
$id = $result;
$sql['statement'] = "select data from $table_name where id = :id";
$sql['values'] = array(':id'=>$id);
$data_result = $sqlizer->RunSQL($sql);

// A SELECT will return an array of rows or it will return false if no rows were found.

// Set $first_result to the first (in this case, only) value returned
if (isset($data_result[0])) {
    $first_result = $data_result[0];
}

// Set $data to the 'data' key value from the $first_result row.
if (isset($first_result['data'])) {
    $data = $first_result['data'];
}

// Echo out the 'data' key value of the first returned row.
echo $data;

// Clean up for next test
unset($data);
unset($sql);


// TEST 4 - Delete Data
// Delete the row that was just created.
$sql['statement'] = "delete from $table_name where id = :id";
$sql['values'] = [':id'=>$id];
$sqlizer->RunSQL($sql);
unset($sql);

$sql['statement'] = "show tables";
print_r($sqlizer->RunSQL($sql));

// TEST 5 - Delete Table
// Delete the table
$sql = "drop table $table_name";
$sqlizer->RunSQL($sql);
unset($sql);

// Close database connection
// In this case unnecessary because the script ends here anyway.
unset($sqlizer);
