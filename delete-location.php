<?php
include "includes/header.php";
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
    <title>Delete <?= $location['LocationName'] ?> -- Final Project - States Database</title>
</head>
<body>
<div class="container">
    <h1>Delete Location</h1>

    <h3>Hiking Destinations</h3>
    <?php

    // if form was submitted
    if(isset($_POST['delete'])) {
    // get values from form
    $locationID = $_POST['locationID'] ?? '';


    // query to get hiking locations ($id comes from the URL)
    $query = "DELETE FROM `HikingLocations`  
                WHERE `HikingLocations`.`LocationID` = $locationid
                LIMIT 1;";

    $result = mysqli_query($db, $query) or die("Error deleting location.");
        // check if record was edited
        //if(mysqli_affected_rows($db)){
            // redirect
            header('Location: states.php?stateid=' . $location['StateID']);
        //}
    }

    // close database connection (put in footer to avoid doing multiple times)
    mysqli_close($db);
    ?>
    <form method="post">
        <p>Are you sure you want to delete "<?= $location['LocationName'] ?>" from <?= $location['StateName'] ?>?</p>
        <p>
            <button type="button" hidden name="locationID" value="<?= $location['LocationID'] ?>"/>
            <button type="submit" name="delete" class="btn btn-danger">Delete Location</button>
        </p>
    </form>

</div>
<?php
include 'includes/footer.php';
?>
</body>
</html>