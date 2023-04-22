<?php
include 'includes/header.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/stylesheet.css">
    <title>State Birds - Final Project - States Database</title>
</head>
<body>
<div class="container">
    <h1>State Birds</h1>
    <?php
    require_once "includes/database.php";


    // query to run on the database
    $query = "SELECT BirdID, BirdName, BirdIMG  
                    FROM StateBirds
                    ORDER BY BirdName";

    // run the query
    // in production
    //$result = @mysqli_query($db, $query) or die('Error in query.');

    // in development
    $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));
    ?>

    <form>
        <label>Search: <input id="search"></label>

    </form>

    <table id="birds-table" class="table">
        <thead>
            <tr>
                <th scope="col">Bird</a></th>
                <th scope="col">Bird Image</th>
            </tr>
        </thead>
        <tbody>
        <?php


        // loop through results
        // each time mysqli_fetch_array is called, it retrieves the next record
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            // $row represents a record in the database

            ?>
            <tr>
                <td><a href="bird-state.php?birdID=<?= $row['BirdID'] ?>"><?= $row['BirdName'] ?></a></td>
                <td><img src="<?= $row['BirdIMG'] ?>" style="width: 220px" alt="<?= $row['BirdName'] ?>"></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <?php
    // close database connection
    mysqli_close($db);
    ?>
</div>

<?php
include 'includes/footer.php';
?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/search-birds.js"></script>
</body>
</html>