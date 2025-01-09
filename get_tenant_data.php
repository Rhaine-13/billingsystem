<?php
require('./database.php');

if (isset($_GET['select_tenant_id'])) {
    $tenantIdVal = $_GET['select_tenant_id'];

    $queryGetAllTenant = "SELECT TenantId, FullName, Email FROM tenant WHERE TenantId = '$tenantIdVal'";
    $resultGetAllTenant = mysqli_query($connection, $queryGetAllTenant);

if(!$resultGetAllTenant){
error_log("Query Error: " . mysqli_error($connection));
echo json_encode(['error' => 'Database query failed']);
return;
} 

if(mysqli_num_rows($resultGetAllTenant) > 0){
$row = mysqli_fetch_assoc($resultGetAllTenant);
echo json_encode($row);
} else{
echo json_encode([]);
}

}

?>