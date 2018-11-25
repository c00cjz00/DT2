<?php
$DT_folder="Editor-PHP-1.8.1";
$DB_host="localhost"; 
$DB_user="root"; 
$DB_pass=""; 
$DB_name="atriGenome_000"; 
$sql_details = array(
	"type" => "Mysql",     // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
	"user" => $DB_user,          // Database user name11
	"pass" => $DB_pass,          // Database password
	"host" => $DB_host, // Database host
	"port" => "",          // Database connection port (can be left empty for default)
	"db"   => $DB_name,          // Database name
	"dsn"  => "",          // PHP DSN extra information. Set as `charset=utf8mb4` if you are using MySQL
	"pdoAttr" => array()   // PHP PDO attributes array. See the PHP documentation for all options
);
?>
