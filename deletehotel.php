<?php
include 'DBConnect.php';

// the related data row will be deleted when Delete button is clicked
$sql = "DELETE FROM hotel WHERE id =". $_GET['delete_id'];
$result = $conn->query($sql);

if ($result) {
    echo "Deleted Successfully";
    header("Location: hotelindex.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}