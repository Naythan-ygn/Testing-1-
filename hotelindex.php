<!DOCTYPE html>
<html lang="en">
<?php

include 'DBConnect.php';

// When create button is clicked, the data inside the form will be sent to the server
if (isset($_POST['btnCreate'])) {
    $hname = $_POST['hname'];
    $hcity = $_POST['hcity'];
    $rating = $_POST['rating'];

    if (isset($_FILES['hfile']) && $_FILES['hfile']['error'] == 0) {
        // Read the file name
        $hfile = $_FILES['hfile']['name'];
        // Read the file Path
        $tmp_name = $_FILES['hfile']['tmp_name'];
    }
    $sql = "INSERT INTO hotel (id, name, city, rating, picture) VALUES (NULL, '$hname', '$hcity', '$rating', '$hfile')";
    $result = $conn->query($sql);

    if ($result) {
        echo "<script type='text/javascript'>alert('Hotel Created Successfully');</script>";
        move_uploaded_file($tmp_name, 'images/' . $hfile);
        header("Location: hotelindex.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM hotel";
$result = $conn->query($sql);

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel="stylesheet" href="CSS/hotel.css">
    <title>Hotel</title>
</head>

<body>
    <div class="filter">
        <form action="#" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>
                    <h3>Create Hotel</h3>
                </legend>

                <input type="hidden" name="hid" value="<?php echo (isset($row['id']) ? $row['id'] : ""); ?>">

                <input type="text" name="hname" placeholder="Hotel Name" value="<?php echo (isset($row['name']) ? $row['name'] : ""); ?>" required>

                <input type="text" name="hcity" value="<?php echo (isset($row['city']) ? $row['city'] : ""); ?>" placeholder="Hotel's Location (City)">

                <select name="rating" id="hrate">
                    <?php
                    if (isset($_GET['edit_id'])) {
                    ?>
                        <option value="<?php echo ($row['rating']); ?>"><?php echo ($row['rating']); ?></option>
                    <?php
                    } else {
                    ?>
                        <option selected disabled hidden>---- Select Rating ----</option>
                    <?php } ?>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

                <input type="file" name="hfile">

                <input type="submit" class="form-control" name="btnCreate" value="Create Hotel">
            </fieldset>
        </form>
    </div>


    <?php
    if (!isset($_GET['edit_id'])) {
    ?>
        <div class="list">
            <h3>
                Hotels in Myanmar
            </h3>
            <hr>
            <div class="hotel-list">
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="card">
                        <div class="hotel-img">
                            <img src="<?php echo "images\\" . $row['picture']; ?>" alt="pic" width="100px" height="100px">
                        </div>
                        <div class="hotel-info">
                            <h4>
                                <?php
                                echo $row['id'] . ". " . $row['name'];
                                ?>
                            </h4>

                            <p><?php echo $row['city']; ?> , Rating : <?php echo $row['rating']; ?> <i class="fi fi-ss-star"></i></p>

                            <div class="action">
                                <a href="edithotel.php?edit_id=<?php echo $row['id']; ?>">
                                    <i class="fi fi-rr-edit"></i>
                                    &nbsp;Edit
                                </a>
                                <a href="deletehotel.php?delete_id=<?php echo $row['id']; ?>">
                                    <i class="fi fi-rr-trash"></i>
                                    &nbsp;Delete
                                </a>

                            </div>

                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>
    <?php
    }
    ?>
</body>

</html>