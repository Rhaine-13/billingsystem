<?php
require('./database.php');

if (isset($_GET['TenantId'])) {
    $TenantId = $_GET['TenantId'];

    $query = "SELECT ElectricityPrevious, ElectricityPresent, WaterPrevious, WaterPresent FROM bill WHERE TenantId = '$TenantId'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        error_log("Query Error: " . mysqli_error($connection));
        echo json_encode(['error' => 'Database query failed']);
        return;
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}
?>