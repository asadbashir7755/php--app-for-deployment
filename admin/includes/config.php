<?php
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','elms_user');
define('DB_PASS','password');
define('DB_NAME','elms_db');

// Establish database connection.
try
{
    $dbh = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );
}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}
?>
>
