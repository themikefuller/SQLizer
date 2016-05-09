# sqlizer
SQLizer is a PHP MySQL class with support for PDO.

## HOW TO USE THIS CLASS:

These examples will get you started with the SQLizer class and perform a couple of simple operations on the users table. You can change the query to fit your database scheme.


## GETTING STARTED

### Require sqlizer.php in your script.

    require_once('/path/to/sqlizer.php');


### Create a new instance of the sqlizer class, passing the database settings as parameters.

    $host = 'localhost';
    $port = '3306';
    $user = 'username';
    $pass = 'password';
    $name = 'database';
    $sqlizer = new SQLizer($host,$port,$user,$pass,$name);


## PERFORMING DATABASE OPERATIONS

### SELECT

### Add a SQL statement to the statement key of an array.

    $sql['statement'] = "select * from users where username = :username";


### Add values to the values key of the same array.

    $sql['values'] = [':username'=>'mike'];


### Run the RunSQL method of the sqlizer class on the array.

    $result = $sqlizer->RunSQL($sql);
    

### Output the result of the query or use it elsewhere.

    var_dump($result);


## INSERT

This next example will insert a row into the users table using a prepared statement.
An insert will return the primary id of the inserted row as a string if available.

    require_once('/path/to/sqlizer.php');
    $sqlizer = new SQLizer($host,$port,$user,$pass,$name);
    $username = 'mike';
    $password = 'password';
    $email = 'mike@mike.mike';
    $sql['statement'] = "insert into users (username,password,email) values (:username,:password,:email)";
    $sql['values'] = [':username'=>$username,':password'=>$password,':email'=>$email];
    $id = $sqlizer->RunSQL($sql);
    echo $id;


## EMPTY QUERY RESULTS RETURN AS FALSE

When a query returns no rows, the RunSQL method will return a boolean false. This makes some queries easier to test:

    // Check if user exists in user table
    $username = 'mike';
    $sql['statement'] = "select id from users where username = :username";
    $sql['values'] = [':username'=>$username];
    $result = $sqlizer->RunSQL($sql);
    if ($result) {
        $userid = $result[0]['id'];
        echo 'User exists. User ID is ' . $userid;
    } else {
        echo 'No such user.';
    }
