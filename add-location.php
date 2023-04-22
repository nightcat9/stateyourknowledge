<?php
include 'includes/header.php';
require_once "includes/database.php";
?>
<?php

    // get state id from the URL
    $stateid = $_GET['stateID'] ?? '';

    // sanitize inputs
    $stateid = mysqli_real_escape_string($db, $stateid);
    $stateid = intval($stateid);

    $query = "SELECT * FROM States
                    WHERE StateID = '$stateid'";

    $result = mysqli_query($db, $query) or die('Error in query');
    $state = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
    <title><?= $state['StateName'] ?> -- Final Project - States Database</title>
</head>
<body>
<div class="container">
    <h1>Add Place</h1>

    <h3>Hiking Destinations</h3>
    <?php

    // if form was submitted
    if(isset($_POST['add'])) {
    // get values from form
    $stateid = $_POST['state_id'] ?? '';
    $locationname = $_POST['location_name'] ?? '';
    $reviewername = $_POST['reviewer_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $rating = $_POST['rating'] ?? '';


    // query to get hiking locations ($id comes from the URL)
    $query = "INSERT INTO `HikingLocations`
                (`LocationID`, `StateID`, `LocationName`, `ReviewerName`, `Description`, `Rating`)
                VALUES 
                    (NULL, ?, ?, ?, ?, ?);";

        $stmt = mysqli_prepare($db, $query) or die('Invalid query');

        mysqli_stmt_bind_param($stmt, 'isssi',
        $stateid, $locationname, $reviewername, $description, $rating);

        mysqli_stmt_execute($stmt);

        // check if record was added
        // this will give you the id of the record that was just added
        if(mysqli_insert_id($db)){
            // redirect
            header('Location: states.php?stateid=' . $stateid);
        }else{
            // TODO: let the user know there was an error
        }
    }

    // close database connection (put in footer to avoid doing multiple times)
    mysqli_close($db);
    ?>
    <form method="post">
        <p>
            <label for="location_name">Location: </label>
            <input type="text" id="location_name" name="location_name">
        </p>
        <p>
            <label for="reviewer_name">Reviewer Name: </label>
            <input type="text" id="reviewer_name" name="reviewer_name">
        </p>
        <p>
            <label for="state">City: </label>
            <input type="hidden" name="state_id" value="<?= $state['StateID'] ?>">
            <input type="text" id="state" value="<?= $state['StateName'] ?>" disabled>
        </p>
        <p>
            <label for="description">Description: </label>
            <textarea id="description" name="description"></textarea>
        </p>
        <p>
            <label for="rating">Rating: </label>
            <select id="rating" name="rating">
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </p>
        <p>
            <button type="submit" name="add" class="btn btn-primary">Add Location</button>
        </p>
    </form>

</div>
<?php
include 'includes/footer.php';
?>
</body>
</html>