<?php
    require_once "includes/database.php";

    $search = $_GET['search'] ?? '';
    $search = mysqli_real_escape_string($db, $search);

    // query to run on the database
    $query = "SELECT BirdID, BirdName,
                    BirdIMG  
                    FROM StateBirds
                    WHERE BirdName LIKE '%$search%'
                    ORDER BY BirdName";

    // run the query
    // in production
    //$result = @mysqli_query($db, $query) or die('Error in query.');

    // in development
    $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));
    ?>
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
