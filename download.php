<?php
include('./database/config.php');

if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Assuming the files are stored in the 'invoice' table in the 'file' column
    $query = "SELECT file FROM invoice WHERE file = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "s", $file);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result variable
    mysqli_stmt_bind_result($stmt, $file_content);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    if ($file_content !== null) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file_content));
        echo $file_content;
        exit;
    } else {
        echo "File not found.";
    }
}
