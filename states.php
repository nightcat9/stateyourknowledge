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
    <title>Final Project - States Database</title>
</head>
<body>
<div class="container">
    <h1>States</h1>
<?php
    require_once "includes/database.php";

    $sort = $_GET['sort'] ?? 'StateName';
    $dir = $_GET['dir'] ?? 'ASC';

    $sort = in_array($sort, ['StateName', 'StateCapital', 'StateAbbr', 'BirdName', 'FlowerName']) ? $sort : 'StateName';
    $dir = in_array($dir, ['ASC', 'DESC' ]) ? $dir : 'ASC';


    // query to run on the database
    $query = "SELECT StateID, StateName, 
                    StateCapital, 
                    StateAbbr, 
                    StateBirds.BirdName, 
                    StateFlowers.FlowerName 
                    FROM States 
                        LEFT JOIN StateBirds 
                            ON States.BirdID=StateBirds.BirdID 
                        LEFT JOIN StateFlowers 
                            ON StateFlowers.FlowerID=States.FlowerID
                            ORDER BY $sort $dir";

    // run the query
    // in production
    //$result = @mysqli_query($db, $query) or die('Error in query.');

    // in development
    $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));
?>
    <form>
        <label>Search: <input id="search"></label>

    </form>

    <table id="states-table" class="table">
          <thead>
            <tr>
              <th scope="col"><a href="?sort=StateName">State</a></th>
                <th scope="col"><a href="?sort=StateCapital">Capital</a></th>
                <th scope="col"><a href="?sort=StateAbbr">State Abbreviation</a></th>
                <th scope="col"><a href="?sort=BirdName">State Bird</a></th>
                <th scope="col"><a href="?sort=FlowerName">State Flower</a></th>
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
              <td><a href="stateinfo.php?stateID=<?= $row['StateID'] ?>"><?= $row['StateName'] ?></a></td>
              <td><?= $row['StateCapital'] ?></td>
              <td><?= $row['StateAbbr'] ?></td>
              <td><?= $row['BirdName'] ?></td>
              <td><?= $row['FlowerName'] ?></td>
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
<script src="js/search-states.js"></script>
</body>
</html>
