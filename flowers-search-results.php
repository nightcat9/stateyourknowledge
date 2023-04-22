 <?php
    require_once "includes/database.php";

    $search = $_GET['search'] ?? '';
    $search = mysqli_real_escape_string($db, $search);

    // query to run on the database
    $query = "SELECT FlowerID, FlowerName, 
                    FlowerIMG  
                    FROM StateFlowers
                    WHERE FlowerName LIKE '%$search%'
                    ORDER BY FlowerName";

    // run the query
    // in production
    //$result = @mysqli_query($db, $query) or die('Error in query.');

    // in development
    $result = @mysqli_query($db, $query) or die('Error in query: ' . mysqli_error($db));
    ?>

    <table id="flowers-table" class="table">
        <thead>
        <tr>
            <th scope="col">Flower</th>
            <th scope="col">Flower Image</th>
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
                <td><a href="flower-state.php?flowerID=<?= $row['FlowerID'] ?>"><?= $row['FlowerName'] ?></a></td>
                <td><img src="<?= $row['FlowerIMG'] ?>" style="width: 220px" alt="<?= $row['FlowerName'] ?>"></td>
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


