<?php
include 'includes/header.php';
?>
<?php
    require_once "includes/database.php";

    // get state id from the URL
    $stateid = $_GET['stateID'] ?? '';

    // sanitize inputs
    $stateid = mysqli_real_escape_string($db, $stateid);
    $stateid = intval($stateid);

    $query = "SELECT s.StateID, 
                s.StateName, 
                s.StateCapital, 
                s.StateAbbr, 
                s.StateIMG,
                s.StateSlogan,
                s.StatePopulation,
                s.StateIcon,
                StateFlowers.FlowerID, 
                StateFlowers.FlowerName,
                StateFlowers.FlowerIMG,
                StateBirds.BirdID, 
                StateBirds.BirdName,
                StateBirds.BirdIMG
                FROM States AS s
                LEFT JOIN StateFlowers 
                    ON StateFlowers.FlowerID=s.FlowerID
                LEFT JOIN StateBirds 
                    ON s.BirdID=StateBirds.BirdID
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
<style>
    .container{
        background-image: url("<?= $state['StateIMG'] ?>");
        no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        position: relative;
        min-height: 100vh;
    }
</style>
<body>
<div class="container">
    <div id="content-wrap">
    <h1><?= $state['StateName'] ?></h1>
    <div class="row">
        <div class="col">
            <div class="card" style="width: 21rem;">
                <img src="<?= $state['StateIcon'] ?>" class="card-img-top img-fluid" alt="<?= $state['StateName'] ?>">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Capital:</b> <?= $state['StateCapital'] ?></li>
                    <li class="list-group-item"><b>Abbreviation: </b><?= $state['StateAbbr'] ?></li>
                    <li class="list-group-item"><b>Population: </b><?= $state['StatePopulation'] ?></li>
                    <li class="list-group-item"><b>Slogan: </b><?= $state['StateSlogan'] ?></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 20rem">
                <img src="<?= $state['FlowerIMG'] ?>"  class="card-img-top" alt="<?= $state['FlowerName'] ?>">
                <div class="card-body">
                    <h5 class="card-title">State Flower</h5>
                    <p class="card-text"><?= $state['FlowerName'] ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card" style="width: 20rem">
                <img src="<?= $state['BirdIMG'] ?>"  class="card-img-top" alt="<?= $state['BirdName'] ?>">
                <div class="card-body">
                    <h5 class="card-title">State Bird</h5>
                    <p class="card-text"><?= $state['BirdName'] ?></p>
                </div>
            </div>
        </div>

    </div>

    <?php
    // query to get hiking locations ($id comes from the URL)
    $query = "SELECT *
                FROM HikingLocations
                WHERE StateID = $stateid";
    ?>
    <h3>Hiking Destinations</h3>
    <?php

    $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));

    // if rows are returned, display table
    if(mysqli_num_rows($result)):
    ?>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
        <tr>
            <th>Location</th>
            <th>Reviewer Name</th>
            <th>Review</th>
            <th>Rating</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo "<tr>
                            <td>{$row['LocationName']}</td>
                            <td>{$row['ReviewerName']}</td>
                            <td>{$row['Description']}</td>
                            <td>" . implode('', array_fill(0, $row['Rating'], '⭐')) . "</td>
                            <td>
                                <a href='edit-location.php?locationID={$row['LocationID']}' class='btn btn-secondary'>Edit</a>
                                <a href='delete-location.php?locationID={$row['LocationID']}' class='btn btn-danger'>Delete</a>
                            </td>   
                         </tr>";
                }
            ?>
        </tbody>

    </table>
    <?php else: ?>
        <p>No places found.</p>
    <?php

    endif;

    // close database connection (put in footer to avoid doing multiple times)
    mysqli_close($db);
    ?>

    <a href="add-location.php?stateID=<?= $state['StateID'] ?>" class="btn btn-primary">Add Location</a>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
</body>
</html>