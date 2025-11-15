<?php 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $surname = $_POST["surname"];
    
    try {
        require_once "inc_dtbHandler.php";

        $query = "INSERT INTO users (name, surname) 
        VALUES (:name, :surname)";



        $statement = $connection->prepare($query);
        
        $statement->bindParam(":name", $name);
        $statement->bindParam(":surname", $surname);

        $statement->execute();


        
        header("Location: ../");

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {

    header("Location: ../");
}

