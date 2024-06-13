<?php
include 'DBConnect.php';

// the id of the row will be selected (and show in url) when Edit button is clicked
$Eid = $_GET['edit_id'];
$sql = "SELECT * FROM hotel WHERE id = $Eid";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// the related data row will be updated when Update button is clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['hname'];
    $add = $_POST['hcity'];
    $hrate = $_POST['rating'];

    if (isset($_FILES['hfile']) && $_FILES['hfile']['error'] == 0) {
        // Read the file name
        $hfile = $_FILES['hfile']['name'];
        // Read the file Path
        $hfile_tmp = $_FILES['hfile']['tmp_name'];
    }

    if (!empty($hfile)) {
        $sql_update = "UPDATE hotel SET name = '$name', city = '$add', rating = '$hrate', picture = '$hfile' WHERE id =" . $_GET['edit_id'];
    } else {
        $sql_update = "UPDATE hotel SET name = '$name', city = '$add', rating = '$hrate' WHERE id =" . $_GET['edit_id'];
    }
    $result_query = $conn->query($sql_update);


    if ($result_query) {
        echo "<script>alert('Hotel Updated');</script>";
        // delete the existing image if a new image is uploaded
        if (!empty($hfile)) {
            unlink("images/" . $row['picture']);
        }
        // upload new image to folder
        move_uploaded_file($hfile_tmp, "images/" . $hfile);
        // redirect to hotelindex.php after update
        header("Location: hotelindex.php");
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Hotel Administration</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-12">
                <form action="?edit_id=<?php echo $row['id']; ?>" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <h2>Update Hotel</h2>
                        <div class="form-group">
                            <input type="text" class="form-control" name="hname" value="<?php echo $row['name']; ?>" placeholder="Hotel Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="hcity" value="<?php echo $row['city']; ?>" placeholder="Hotel's Location (City)">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="rating" id="hrate">
                                <?php
                                if (isset($_GET['edit_id'])) {
                                ?>
                                    <option value="<?php echo $row['rating']; ?>"><?php echo $row['rating']; ?></option>
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
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control-file" name="hfile" value="<?php echo $row['picture']; ?>">

                        </div>

                        <!-- "Cancel" button go back to hotelindex.php without submitting any data to the server -->
                        <button type="button" class="btn btn-danger" onclick="window.location.href='hotelindex.php'">Cancel</button>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>