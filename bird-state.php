<?php
include 'includes/header.php';
require_once "includes/database.php";

$birdid = $_GET['birdID'] ?? '';

// sanitize inputs
$birdid = mysqli_real_escape_string($db, $birdid);
$birdid = intval($birdid);

$query = "SELECT BirdID, BirdName, 
                    BirdIMG  
                    FROM StateBirds
                    WHERE BirdID = '$birdid'";

$result = mysqli_query($db, $query) or die('Error in query');
$bird = mysqli_fetch_array($result, MYSQLI_ASSOC);

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
    <title><?= $bird['BirdName'] ?>Final Project - States Database</title>
</head>
<body>
<div class="container">

    <h1><?= $bird['BirdName'] ?></h1>
    <img src="<?= $bird['BirdIMG'] ?>" alt="<?= $bird['BirdName'] ?>">

    <?php

    // query to run on the database
    $query = "SELECT
        States.StateName,
        States.StateID,
        StateBirds.BirdID
        FROM StateBirds
        LEFT JOIN States
        ON States.BirdID = StateBirds.BirdID
        WHERE States.BirdID = '$birdid'";

    // run query
    // in production
    //$result = @mysqli_query($db, $query) or die('Error in query.');
    // in development
    $result = @mysqli_query($db, $query) or die('Error in query: ' . @mysqli_error($db));
    // check if any rows were returned
    if(mysqli_num_rows($result) > 0){
        ?>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">States</th>
            </tr>
            </thead>
            <tbody>
            <?php

            // loop through results
            // each time mysqli_fetch_array is called, it retrieves the next record
            while($row = @mysqli_fetch_array($result, MYSQLI_ASSOC)){
                // $row represents a record in the database
                //echo $row['ProductName'] . '<br>';
                ?>
                <tr>
                    <td><a href="stateinfo.php?stateID=<?= $row['StateID'] ?>"><?= $row['StateName'] ?></a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    }else{
        echo "<p>No states found.</p>";
    }

    //close database connection
    mysqli_close($db);

    ?>

</div>

<?php
include 'includes/footer.php';
?>
</body>
</html>