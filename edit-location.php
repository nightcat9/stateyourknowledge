<?php
include 'includes/header.php';
require_once "includes/database.php";
?>
<?php

    // get state id from the URL
    $locationid = $_GET['locationID'] ?? '';

    // sanitize inputs
    $locationid = mysqli_real_escape_string($db, $locationid);
    $locationid = intval($locationid);

    $query = "SELECT HikingLocations.*, States.StateName
                FROM HikingLocations
                LEFT JOIN States ON HikingLocations.StateID = States.StateID
                    WHERE LocationID = '$locationid'";

    $result = mysqli_query($db, $query) or die('Error loading state.');

    $location = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
    <title>Edit <?= $location['LocationName'] ?> -- Final Project - States Database</title>
</head>
<body>
<div class="container">
    <h1>Edit Location</h1>

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
    $locationID = $_POST['locationID'] ?? '';


    // query to get hiking locations ($id comes from the URL)
    $query = "UPDATE `HikingLocations` 
                SET `LocationName` = '$locationname', 
                    `ReviewerName` = '$reviewername', 
                    `Description` = '$description', 
                    `Rating` = '$rating' 
                WHERE `HikingLocations`.`LocationID` = $locationid;";

    $result = mysqli_query($db, $query) or die("Error adding location.");
        // check if record was edited
        //if(mysqli_affected_rows($db)){
            // redirect
            header('Location: states.php?stateid=' . $stateid);
        //}
    }

    // close database connection (put in footer to avoid doing multiple times)
    mysqli_close($db);
    ?>
    <form method="post">
        <p>
            <label for="location_name">Location: </label>
            <input type="text" id="location_name" name="location_name" value="<?= $location['LocationName'] ?>">
        </p>
        <p>
            <label for="reviewer_name">Reviewer Name: </label>
            <input type="text" id="reviewer_name" name="reviewer_name" value="<?= $location['ReviewerName'] ?>">
        </p>
        <p>
            <label for="state">City: </label>
            <input type="hidden" name="state_id" value="<?= $location['StateID'] ?>">
            <input type="text" id="state" value="<?= $location['StateName'] ?>" disabled>
        </p>
        <p>
            <label for="description">Description: </label>
            <textarea id="description" name="description"><?= $location['Description'] ?></textarea>
        </p>
        <p>
            <label for="rating">Rating: </label>
            <select id="rating" name="rating">
                <option value="1" <?= $location['Rating'] == 1 ? 'selected' : '' ?>>⭐</option>
                <option value="2" <?= $location['Rating'] == 2 ? 'selected' : '' ?>>⭐⭐</option>
                <option value="3" <?= $location['Rating'] == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                <option value="4" <?= $location['Rating'] == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                <option value="5" <?= $location['Rating'] == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
            </select>
        </p>
        <p>
            <button type="button" hidden name="locationID" value="<?= $location['LocationID'] ?>"/>
            <button type="submit" name="add" class="btn btn-primary">Update Location</button>
        </p>
    </form>

</div>
<?php
include 'includes/footer.php';
?>
</body>
</html>