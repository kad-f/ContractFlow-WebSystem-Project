<?php
include('config.php');

if (isset($_GET['delete_vendor'])) {
  $vendor_id = $_GET['delete_vendor'];

  $sql = "DELETE FROM vendor WHERE vendor_id = $vendor_id";

  if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('Vendor deleted successfully.');
            window.location.href = 'index.php?view_all_vendor';
        </script>";
    exit();
  } else {
    echo "Error deleting the vendor: " . mysqli_error($conn);
  }
} else {
  header("Location: index.php");
  exit();
}
