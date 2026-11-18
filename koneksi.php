<?php 
$conn = mysqli_connect(
    "localhost", "root", "", "futsal_booking"
);
if(!$conn){
die("Koneksi gagal: " . mysqli_connect_error());
}
?>