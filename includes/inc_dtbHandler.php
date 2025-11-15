<?php 

    try {
        $db_host = "localhost";
        $db_name = "library";
        $db_user = "root";
        $db_passwd = "";

        $connection = new PDO(
            "mysql:host=$db_host;dbname=$db_name",
             $db_user, $db_passwd
        );

        
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo"Error : " . $e->getMessage();
    };
