<?php

//return pg_connect("host=ec2-176-34-237-141.eu-west-1.compute.amazonaws.com port=5432 dbname=d1b4oe0cmou81i user=jljbzxjcxicvvn password=f608bcd12574fc48e322dcc08ca5dc6829404f3cb598eb36812439392ad2b4d7 sslmode=require");

try {
    $dsn = "pgsql:host=localhost;port=5432;dbname=hendry_cartrack";
    $pdo = new PDO($dsn, "user1", "password1", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
	die('Unable to connect to Database: '. $e->getMessage());
}

return $pdo;
