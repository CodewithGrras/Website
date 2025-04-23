<?php
if (isset($_GET['file'])) {
    $file_url = urldecode($_GET['file']); // Decode URL if necessary
    $file_name = basename($file_url);

    // Set headers to force download
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$file_name\"");
    header("Content-Transfer-Encoding: binary");
    readfile($file_url);
    exit;
} else {
    die("No file specified.");
}
?>
