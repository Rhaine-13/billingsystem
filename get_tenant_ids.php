<?php
require('./database.php');

$query = "SELECT DISTINCT TenantId FROM tenant";
$result = mysqli_query($connection, $query);

$tenantIds = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tenantIds[] = $row;
}

echo json_encode($tenantIds);
mysqli_close($connection);
?>