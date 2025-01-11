<?php
require('./database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenantId = $_POST['tenant_id'];
    
    $deleteQuery = "DELETE FROM tenant WHERE TenantId = ?";

    $stmt = $connection->prepare($deleteQuery);
    
    // Check if prepare was successful
    if ($stmt === false) {
        die("MySQL prepare error: " . $connection->error);
    }

    $stmt->bind_param("i", 
        $tenantId
    );

    if ($stmt->execute()) {
        echo "Tenant deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($connection);
}
?>