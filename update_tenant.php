<?php
require('./database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenantId = $_POST['tenant_id'];
    $tenantName = $_POST['tenant_name'];
    $emailAddress = $_POST['email_address'];
    $contactNumber = $_POST['contact_number'];
    $emergencyContactName = $_POST['emergency_contact_name'];
    $emergencyNumber = $_POST['emergency_number'];
    $occupation = $_POST['occupation'];
    $address = $_POST['address'];
    $dateOfBirth = $_POST['date_of_birth'];
    $totalIncome = $_POST['total_income'];
    $moveInDate = $_POST['move_in_date'];
    $nationality = $_POST['nationality'];
    $statusTenant = $_POST['status_tenant'];
    $numberOfMembers = $_POST['number_of_members'];
    $leaseDuration = $_POST['lease_duration'];
    $apartmentUnit = $_POST['apartment_unit'];

    $updateQuery = "UPDATE tenant SET FullName = ?, Email = ?, PhoneNumber = ?, EmergencyName = ?, EmergencyContact = ?, Occupation = ?, Location = ?, DateOfBirth = ?, TotalIncome = ?, MoveInDate = ?, Nationality = ?, StatusTenant = ?, NumberOfMembers = ?, LeaseInDuration = ?, ApartmentUnit = ? WHERE TenantId = ?";

    $stmt = $connection->prepare($updateQuery);
    
    // Check if prepare was successful
    if ($stmt === false) {
        die("MySQL prepare error: " . $connection->error);
    }

    $stmt->bind_param("ssisisssissssiis", 
        $tenantName, 
        $emailAddress, 
        $contactNumber, 
        $emergencyContactName, 
        $emergencyNumber, 
        $occupation, 
        $address, 
        $dateOfBirth, 
        $totalIncome, 
        $moveInDate, 
        $nationality, 
        $statusTenant, 
        $numberOfMembers, 
        $leaseDuration, 
        $apartmentUnit, 
        $tenantId
    );

    if ($stmt->execute()) {
        echo "Tenant updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($connection);
}
?>