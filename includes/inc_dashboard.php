<?php 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    try {
        require_once "inc_dtbHandler.php";

        $query = "SELECT * FROM users;";

        $statement = $connection->prepare($query);
        
        $statement->execute();
        $results = $statement->fetchAll();


    } catch (PDOException $e) {

        die("Query failed: " . $e->getMessage());
    }

} else {

    header("Location: ../index.php");
}

