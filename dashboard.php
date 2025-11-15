<?php 




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Dashboard</h1>
        <form action="dashboard.php" method="post">
            <input type="text" placeholder="Search..." name="searchdata">
        </form>

        <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                
    
                try {
                    require_once "includes/inc_dtbHandler.php";

                    $name = $_POST["searchdata"];

                    $query = "SELECT * FROM users WHERE name = :searchdata;";

                    $statement = $connection->prepare($query);
                    $statement->bindParam(':searchdata', $name);

                    $statement->execute();
                    $results = $statement->fetchAll(PDO::FETCH_ASSOC);


                } catch (PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }

            }

            if (!empty($results)) {
                foreach ($results as $item) {
                    $name = htmlspecialchars($item["name"]);
                    $surname = htmlspecialchars($item["surname"]);

                    echo"<div class='res-item'>";
                        echo"<p1>{$name}</p1>";
                        echo"<p1>{$surname}</p1>";
                    echo"</div>";
                }
            } else {
                echo"empty";
            }
        
        ?>
    </main>
</body>
</html>

