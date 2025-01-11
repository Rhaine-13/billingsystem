<?php
require('./database.php');
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION['email'])) {
    error_log("Session email not set. Redirecting to login.");
    header("Location: loginpage.php");
    exit();
} else {
    error_log("Session email is set: " . $_SESSION['email']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $ApartmentUnit = $_POST['apartment_unit'];
    $LeaseDuration = $_POST['lease_duration'];
    $NumberOfMembers = $_POST['number_of_members'];
    $StatusTenant = $_POST['status_tenant'];
    $Nationality = $_POST['nationality'];
    $MoveInDate = $_POST['move_in_date'];
    $TotalIncome = $_POST['total_income'];
    $DateOfBirth = $_POST['date_of_birth'];
    $Occupation = $_POST['occupation'];
    $EmergencyNumber = $_POST['emergency_number'];
    $EmergencyContactName = $_POST['emergency_contact_name'];
    $ContactNumber = $_POST['contact_number'];
    $Address = $_POST['address'];
    $EmailAddress = $_POST['email_address'];
    $TenantName = $_POST['tenant_name'];

    $DateToday = date("Y-m-d");
    $DateTodayT = date('Y-m-d', strtotime($DateToday . ' + 1 month'));
    $Status = "Not yet";
    $Password = password_hash("Hey", PASSWORD_DEFAULT);
    $Image = null;
    $DepAm = '10000';

    $tenantsAdd = "INSERT INTO tenant (FullName, Email, Location, PhoneNumber, AccountCreationDate, Status, Password, tenantImage, DepositAmount, DepositPaidDate, DateOfBirth, TotalIncome, MoveInDate, Nationality, StatusTenant, NumberOfMembers, LeaseInDuration, ApartmentUnit, Occupation, EmergencyName, EmergencyContact) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connection->prepare($tenantsAdd);
    
// Check if prepare was successful
if ($stmt === false) {
    die("MySQL prepare error: " . $connection->error);
}

    $stmt->bind_param("sssisssbississsiisssi", 
    $TenantName, 
    $EmailAddress, 
    $Address, 
    $ContactNumber, 
    $DateToday, 
    $Status, 
    $Password, 
    $Image, 
    $DepAm, 
    $DateTodayT, 
    $DateOfBirth, 
    $TotalIncome, 
    $MoveInDate, 
    $Nationality, 
    $StatusTenant, 
    $NumberOfMembers, 
    $ApartmentUnit, 
    $LeaseDuration, 
    $Occupation, 
    $EmergencyContactName, 
    $EmergencyNumber
);
    
    if ($stmt->execute()) {
        echo "Tenant added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    mysqli_close($connection);
}

$queryTenants = "SELECT * FROM tenant";
$sqlTenants = mysqli_query($connection, $queryTenants);

$queryTenantsUnique = "SELECT DISTINCT TenantId FROM tenant";
$sqlTenantsUnique = mysqli_query($connection, $queryTenantsUnique);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Layout with CSS Grid</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            font-family: 'SF Pro Display', sans-serif;
            user-select: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: grid;
            grid-template-columns: 220px 1fr; 
            height: 100vh;
            background-color: #dee3e9;
        }

        .sidenav-main {
            background-color: white;
            display: flex;
            flex-direction: column;
            margin: 20px;
            border-radius: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidenav-header{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px;
            margin-bottom: 50px;
        }

        .sidenav-header img{
            height: 30px;
        }

        .sidenav-header p {
            font-weight: 500;
            font-size: 11px;
        }

        .sidenav-body .sidenav-menus {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .sidenav-menus{
            padding: 10px;
            border-radius: 5px;
        }

        .sidenav-menus img{
            height: 20px;
        }

        .sidenav-menus{
            margin: 0 10px 0 10px;
            transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1.0)-in-out;
        }

        .sidenav-menus:hover{
            color: white;
            background-color: #fe9210;
        }

        .sidenav-footer {
            text-align: center;
            font-size: 12px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 10px;
            margin-top: 150px;
        }

        .sidenav-footer img{
            border-radius: 50px;
        }

    .body-content {
    display: grid;
    grid-template-columns: 2fr;
    grid-template-rows: auto auto; 
    gap: 20px; 
    margin: 20px 20px 20px 0;
    align-items: stretch;
}

.content-box {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    min-height: 200px;
}

.box1 {
    grid-column: 1; 
    grid-row: 1; 
}

.box2 {
    grid-column: 1; 
    grid-row: 2;    
}

.summary-table {
    width: 100%; 
    border-spacing: 0; 
    border-collapse: collapse; 
    font-size: 12px;
}

.summary-table thead {
    background-color: #f27e23;
    color: white;
    font-size: 11px;
}

.summary-table thead th:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

.summary-table thead th:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

.summary-table th, .summary-table td {
    padding: 10px;
    text-align: left;
}

.summary-table tbody {
    display: block; 
    max-height: calc(7 * 30px); 
    overflow-y: auto; 
}

.summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table thead, .summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table tbody tr:nth-child(even) {
    background-color: #f9f9f9; 
}

.summary-table tbody tr:hover {
    background-color: #f5f5f5; 
}


.panel-title{
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 10px;
}

.below-title{
    font-size: 10px;
    font-weight: 300;
}

.number-title{
    font-size: 60px;
    font-weight: 800;
}



@media (max-width: 848px){
    .box2 {
    display: flex;
    flex-direction: column;
    gap: 0px; 
    padding-bottom: 0; 
    margin-bottom: 0; 
}

.number-title{
    font-size: 40px;
    font-weight: 800;
}

.summary-table {
    width: 100%; 
    border-spacing: 0; 
    border-collapse: collapse; 
    font-size: 12px;
}

.summary-table thead {
    background-color: #f27e23;
    color: white;
    font-size: 11px;
}

.summary-table thead th:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

.summary-table thead th:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

.summary-table th, .summary-table td {
    padding: 10px;
    text-align: left;
}

.summary-table tbody {
    display: block; 
    max-height: calc(2 * 30px); 
    overflow-y: auto; 
}

.summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table thead, .summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table tbody tr:nth-child(even) {
    background-color: #f9f9f9; 
}

.summary-table tbody tr:hover {
    background-color: #f5f5f5; 
}
}

@media (max-width: 500px) {
    
    body {
        display: block; 
    }

    .sidenav-main {
        display: flex;
        flex-direction: row; 
        justify-content: space-between;
        padding: 10px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        border-radius: 0;
    }

    .sidenav-body {
        display: flex;
        flex-direction: row;
        gap: 10px;
        
    }

    .content-box {
        width:95%; 
        margin: 10px 10px 10px 10px;
    }

    .body-content {
        display: block; 
        margin: 20px 0 0 0; 
    }

    .sidenav-header p, .sidenav-menus p {
        font-size: 12px;
    }

    .sidenav-footer {
        font-size: 10px;
        text-align: center;
    }

    .sidenav-body .sidenav-menus {
        font-size: 14px;
        padding: 5px 10px;
    }

    .number-title{
    font-size: 60px;
    font-weight: 800;
}

.summary-table {
    width: 100%; 
    border-spacing: 0; 
    border-collapse: collapse; 
    font-size: 12px;
}

.summary-table thead {
    background-color: #f27e23;
    color: white;
    font-size: 11px;
}

.summary-table thead th:first-child {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

.summary-table thead th:last-child {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

.summary-table th, .summary-table td {
    padding: 10px;
    text-align: left;
}

.summary-table tbody {
    display: block; 
    max-height: calc(2 * 30px); 
    overflow-y: auto; 
}

.summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table thead, .summary-table tbody tr {
    display: table; 
    width: 100%; 
}

.summary-table tbody tr:nth-child(even) {
    background-color: #f9f9f9; 
}

.summary-table tbody tr:hover {
    background-color: #f5f5f5; 
}

}

.profile-nav{
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
            align-items: flex-start;
}

.four{
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.bluebutton{
    height: 30px;
    width: 70px;
    background-color: #423ed9;
    color: white;
    border-radius: 20px;
    border: none;
    transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1.0)-in-out;
    cursor: pointer;
    font-size: 11px;
}

.bluebutton:hover{
    color: #423ed9;
    background-color: white;
    border: 1px solid #423ed9;
}

.search{
    border-radius: 20px;
    border: 1px solid black;
    padding-left: 10px;
    cursor: text;
}

.top-box1{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.bottom-box1{
    margin-top: 10px;
}

.bottom-box1-first{
    display: flex;
    flex-direction: row;
    justify-content: center;
    font-size: 12px;
    margin-bottom: 10px;
    gap: 20px;
}

.bottom-box1-label-input input{
    height: 25px;
    width: 320px;
    border-radius: 5px;
    border: 1px solid black;
    padding-left: 5px;
}

.bottom-box1-label-input p{
    margin-bottom: 5px;
}

.bottom-box1-label-input select{
    height: 25px;
    width: 150px;
    border-radius: 5px;
    border: 1px solid black;
    padding-left: 5px;
}

.bottom-box1-label-input-half input{
    height: 25px;
    width: 150px;
    border-radius: 5px;
    border: 1px solid black;
    padding-left: 5px;
}

.bottom-box1-label-input-half p{
    margin-bottom: 5px;
}

.bottom-box1-label-input-occupation select{
    height: 25px;
    width: 150px;
    border-radius: 5px;
    border: 1px solid black;
    padding-left: 5px;
}

.bottom-box1-label-input-occupation p{
    margin-bottom: 5px;
}

.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.5); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px; 
}

.close-button {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-button:hover,
.close-button:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.address-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .suggestions {
            border: 1px solid #ccc;
            border-radius: 5px;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            z-index: 1000;
            width: calc(100% - 22px); 
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }

        .sidenav-menus span {
    text-decoration: none;
    color: black;
            font-size: 20px;
            transition: transform 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0);
        }

        .sidenav-menus:hover span {
            transform: scale(1.2); 
            color: white;
        }

        .sidenav-menus p {
            margin-left: 10px;
            text-decoration: none;
            color: black;
        }

        .sidenav-body a{
            text-decoration: none;
        }

        .sidenav-menus p:hover {
            color: white;
        }

        .profile-nav{
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
            align-items: flex-start;
}

    </style>
     <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>
<body>

    <div id="custom-alert-modal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="close-modal">&times;</span>
            <h2>Alert</h2>
            <p id="modal-message">This is a custom alert message.</p>
            <button id="ok-button">OK</button>
        </div>
    </div>

    <div class="sidenav-main">
        <div class="sidenav-header">
            <img src="assets/logo2.png" alt="">
            <p>Coldovero Smart Billing System</p>
        </div>
        <div class="sidenav-body">

<a href="dashboard.php">
<div class="sidenav-menus dashboard">
    <span class="material-icons">dashboard</span>
    <p>Dashboard</p>
</div>
</a>

<a href="bills.php">
<div class="sidenav-menus" id="billsMenu">
    <span class="material-icons">attach_money</span>
    <p>Bills</p>
</div>
</a>

<a href="tenants.php">
<div class="sidenav-menus">
    <span class="material-icons">people</span>
    <p>Tenant</p>
</div>
</a>

<a href="settings.php">
<div class="sidenav-menus">
    <span class="material-icons">settings</span>
    <p>Settings</p>
</div>
</a>

<a href="logout.php">
            <div class="sidenav-menus">
                <span class="material-icons">logout</span>
                <p>Logout</p>
            </div>
            </a>
</div>
        <div class="sidenav-footer">
            <img src="assets/tenant.png" alt="">
            <div class="profile-nav">
                <p>Archie Coldovero</p>
                <p>Home owner</p>
            </div>
        </div>
    </div>

        <div class="body-content">
            <div class="content-box box1">
                <div class="top-box1">
                    <form id="tenant-form" class="tenant-form" method="post" action="tenants.php">
                    <p class="panel-title">Manage Tenants</p>
                        <div class="four">
                            <select class="search" id="select_tenant_id">
                                <option value="nothing">Select Tenant ID</option>
                                <?php while($results = mysqli_fetch_array($sqlTenantsUnique)) { ?>
                                <option value="<?php echo $results['TenantId']; ?>"><?php echo $results['TenantId']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="search" class="search" placeholder="Search">
                            <input type="submit" id="register-button" class="bluebutton" value="Register">
                            <input type="button" id="modify-button" class="bluebutton" value="Modify">
                            <input type="button" id="archive-button" class="bluebutton" value="End Lease">
                            <input type="button" id="clear-button" class="bluebutton" value="Clear">
                        </div>
                </div>

                <div class="bottom-box1">
                    <div class="bottom-box1-first">
                        <div class="bottom-box1-label-input">
                            <p>ID</p>
                            <input type="textbox" id="tenant_id" name="tenant_id" class="bottom-box1-text" placeholder="Type ID" readonly> 
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Tenant Name</p>
                            <input type="textbox" id="tenant_name" name="tenant_name" class="bottom-box1-text" placeholder="Type Tenant Name">
                        </div>
                        <div class="bottom-box1-label-input-half">
                            <p>Email Address</p>
                            <input type="textbox" id="email_address" name="email_address" class="bottom-box1-text" placeholder="Type Email Address" id="email">
                        </div>
                        <div class="bottom-box1-label-input-half">
                            <p>Contact Number</p>
                            <input type="number" id="contact_number" name="contact_number" class="bottom-box1-text" id="contact-number" placeholder="Type Contact Number" maxlength="11">
                        </div>
                    </div>

                    <div class="bottom-box1-first">
                        <div class="bottom-box1-label-input-half">
                            <p>Emergency Contact Name</p>
                            <input type="textbox" id="emergency_contact_name" name="emergency_contact_name" class="bottom-box1-text" placeholder="Type Contact Name">
                        </div>
                        <div class="bottom-box1-label-input-half">
                            <p>Emergency Number</p>
                            <input type="number" id="emergency_number" name="emergency_number" class="bottom-box1-text" placeholder="Type Contact Name" id="emergencycontactnumber" maxlength="11"> 
                        </div>
                        <div class="bottom-box1-label-input-occupation">
                            <p>Occupation</p>
                            <select class="bottom-box1-text" id="occupation" name="occupation" placeholder="Type Occupation" id="selectOccupation">
                                <option value="" disabled selected>Select Occupation</option>
                                <option value="Others">Others (Type)</option>
                                <option value="Software Engineer">Software Engineer</option>
                                <option value="Data Scientist">Data Scientist</option>
                                <option value="Web Developer">Web Developer</option>
                                <option value="Mobile App Developer">Mobile App Developer</option>
                                <option value="DevOps Engineer">DevOps Engineer</option>
                                <option value="Cloud Engineer">Cloud Engineer</option>
                                <option value="Data Analyst">Data Analyst</option>
                                <option value="Database Administrator">Database Administrator</option>
                                <option value="Network Administrator">Network Administrator</option>
                                <option value="IT Support Specialist">IT Support Specialist</option>
                                <option value="Cybersecurity Analyst">Cybersecurity Analyst</option>
                                <option value="Systems Analyst">Systems Analyst</option>
                                <option value="UX/UI Designer">UX/UI Designer</option>
                                <option value="Machine Learning Engineer">Machine Learning Engineer</option>
                                <option value="Blockchain Developer">Blockchain Developer</option>
                                <option value="Game Developer">Game Developer</option>
                                <option value="Technical Support Engineer">Technical Support Engineer</option>
                                <option value="QA Tester">QA Tester</option>
                                <option value="IT Project Manager">IT Project Manager</option>
                                <option value="Business Intelligence Analyst">Business Intelligence Analyst</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Medical Technologist">Medical Technologist</option>
                                <option value="Radiologic Technologist">Radiologic Technologist</option>
                                <option value="Physical Therapist">Physical Therapist</option>
                                <option value="Occupational Therapist">Occupational Therapist</option>
                                <option value="Clinical Research Associate">Clinical Research Associate</option>
                                <option value="Health Information Technician">Health Information Technician</option>
                                <option value="Medical Assistant">Medical Assistant</option>
                                <option value="Dentist">Dentist</option>
                                <option value="Veterinarian">Veterinarian</option>
                                <option value="Nutritionist">Nutritionist</option>
                                <option value="Psychologist">Psychologist</option>
                                <option value="Anesthesiologist">Anesthesiologist</option>
                                <option value="Surgeon">Surgeon</option>
                                <option value="Emergency Medical Technician (EMT)">Emergency Medical Technician (EMT)</option>
                                <option value="Medical Coder">Medical Coder</option>
                                <option value="Healthcare Administrator">Healthcare Administrator</option>
                                <option value="Laboratory Technician">Laboratory Technician</option>
                                <option value="Accountant">Accountant</option>
                                <option value="Financial Analyst">Financial Analyst</option>
                                <option value="Auditor">Auditor</option>
                                <option value="Tax Consultant">Tax Consultant</option>
                                <option value="Investment Banker">Investment Banker</option>
                                <option value="Business Development Manager">Business Development Manager</option>
                                <option value="Marketing Manager">Marketing Manager</option>
                                <option value="Sales Representative">Sales Representative</option>
                                <option value="Customer Service Representative">Customer Service Representative</option>
                                <option value="Human Resources Manager">Human Resources Manager</option>
                                <option value="Payroll Specialist">Payroll Specialist</option>
                                <option value="Risk Manager">Risk Manager</option>
                                <option value="Compliance Officer">Compliance Officer</option>
                                <option value=" Supply Chain Manager">Supply Chain Manager</option>
                                <option value="Operations Manager">Operations Manager</option>
                                <option value="Project Manager">Project Manager</option>
                                <option value="Business Analyst">Business Analyst</option>
                                <option value="Real Estate Agent">Real Estate Agent</option>
                                <option value="Insurance Agent">Insurance Agent</option>
                                <option value="Credit Analyst">Credit Analyst</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Professor">Professor</option>
                                <option value="Educational Consultant">Educational Consultant</option>
                                <option value="School Administrator">School Administrator</option>
                                <option value="Tutor">Tutor</option>
                                <option value="Training Specialist">Training Specialist</option>
                                <option value="Curriculum Developer">Curriculum Developer</option>
                                <option value="Instructional Designer">Instructional Designer</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Special Education Teacher">Special Education Teacher</option>
                                <option value="Language Instructor">Language Instructor</option>
                                <option value="Corporate Trainer">Corporate Trainer</option>
                                <option value="Early Childhood Educator">Early Childhood Educator</option>
                                <option value="Academic Advisor">Academic Advisor</option>
                                <option value="Researcher">Researcher</option>
                                <option value="Education Program Manager">Education Program Manager</option>
                                <option value="Online Course Developer">Online Course Developer</option>
                                <option value="Vocational Trainer">Vocational Trainer</option>
                                <option value="Education Policy Analyst">Education Policy Analyst</option>
                                <option value="Graphic Designer">Graphic Designer</option>
                                <option value="Content Writer">Content Writer</option>
                                <option value="Copywriter">Copywriter</option>
                                <option value="Social Media Manager">Social Media Manager</option>
                                <option value="Public Relations Specialist">Public Relations Specialist</option>
                                <option value="Marketing Specialist">Marketing Specialist</option>
                                <option value="SEO Specialist">SEO Specialist</option>
                                <option value="Video Editor">Video Editor</option>
                                <option value="Photographer">Photographer</option>
                                <option value="Journalist">Journalist</option>
                                <option value="Art Director">Art Director</option>
                                <option value="Brand Manager">Brand Manager</option>
                                <option value="Event Planner">Event Planner</option>
                                <option value="Fashion Designer">Fashion Designer</option>
                                <option value="Interior Designer">Interior Designer</option>
                                <option value="Music Producer">Music Producer</option>
                                <option value="Film Director">Film Director</option>
                                <option value="Animator">Animator</option>
                                <option value="Web Designer">Web Designer</option>
                                <option value="Creative Director">Creative Director</option>
                                <option value="Civil Engineer">Civil Engineer</option>
                                <option value="Mechanical Engineer">Mechanical Engineer</option>
                                <option value="Electrical Engineer">Electrical Engineer</option>
                                <option value="Chemical Engineer">Chemical Engineer</option>
                                <option value="Industrial Engineer">Industrial Engineer</option>
                                <option value="Environmental Engineer">Environmental Engineer</option>
                                <option value="Structural Engineer">Structural Engineer</option>
                                <option value="Project Engineer">Project Engineer</option>
                                <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                                <option value="Safety Engineer">Safety Engineer</option>
                                <option value="Manufacturing Engineer">Manufacturing Engineer</option>
                                <option value="Petroleum Engineer">Petroleum Engineer</option>
                                <option value="Aerospace Engineer">Aerospace Engineer</option>
                                <option value="Mining Engineer">Mining Engineer</option>
                                <option value="Marine Engineer">Marine Engineer</option>
                                <option value="Geotechnical Engineer">Geotechnical Engineer</option>
                                <option value="Robotics Engineer">Robotics Engineer</option>
                                <option value="Telecommunications Engineer">Telecommunications Engineer</option>
                                <option value="Design Engineer">Design Engineer</option>
                                <option value="HVAC Engineer">HVAC Engineer</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Welder">Welder</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Construction Worker">Construction Worker</option>
                                <option value="HVAC Technician">HVAC Technician ```html
                                <option value="Painter">Painter</option>
                                <option value="Mason">Mason</option>
                                <option value="Landscaper">Landscaper</option>
                                <option value="Chef">Chef</option>
                                <option value="Baker">Baker</option>
                                <option value="Hairdresser">Hairdresser</option>
                                <option value="Tailor">Tailor</option>
                                <option value="Security Guard">Security Guard</option>
                                <option value="Janitor">Janitor</option>
                                <option value="Pest Control Technician">Pest Control Technician</option>
                                <option value="Elevator Installer">Elevator Installer</option>
                                <option value="Locksmith">Locksmith</option>
                                <option value="Automotive Technician">Automotive Technician</option>
                                <option value="Sales Manager">Sales Manager</option>
                                <option value="Retail Sales Associate">Retail Sales Associate</option>
                                <option value="Customer Success Specialist">Customer Success Specialist</option>
                                <option value="Call Center Agent">Call Center Agent</option>
                                <option value="Account Executive">Account Executive</option>
                                <option value="Business Development Representative">Business Development Representative</option>
                                <option value="Field Sales Representative">Field Sales Representative</option>
                                <option value="Inside Sales Representative">Inside Sales Representative</option>
                                <option value="Sales Engineer">Sales Engineer</option>
                                <option value="Brand Ambassador">Brand Ambassador</option>
                                <option value="Technical Sales Specialist">Technical Sales Specialist</option>
                                <option value="Customer Experience Manager">Customer Experience Manager</option>
                                <option value="E-commerce Specialist">E-commerce Specialist</option>
                                <option value="Market Research Analyst">Market Research Analyst</option>
                                <option value="Sales Operations Analyst">Sales Operations Analyst</option>
                                <option value="Retail Store Manager">Retail Store Manager</option>
                                <option value="Merchandiser">Merchandiser</option>
                                <option value="Trade Marketing Specialist">Trade Marketing Specialist</option>
                                <option value="Customer Support Specialist">Customer Support Specialist</option>
                                <option value="Sales Coordinator">Sales Coordinator</option>
                                <option value="Civil Servant">Civil Servant</option>
                                <option value="Policy Analyst">Policy Analyst</option>
                                <option value="Social Worker">Social Worker</option>
                                <option value="Community Organizer">Community Organizer</option>
                                <option value="Public Health Administrator">Public Health Administrator</option>
                                <option value="Urban Planner">Urban Planner</option>
                                <option value="Environmental Scientist">Environmental Scientist</option>
                                <option value="Diplomat">Diplomat</option>
                                <option value="Law Enforcement Officer">Law Enforcement Officer</option>
                                <option value="Firefighter">Firefighter</option>
                                <option value="Emergency Management Specialist">Emergency Management Specialist</option>
                                <option value="Public Affairs Specialist">Public Affairs Specialist</option>
                                <option value="Legislative Assistant">Legislative Assistant</option>
                                <option value="City Planner">City Planner</option>
                                <option value="Public Relations Officer">Public Relations Officer</option>
                                <option value="Nonprofit Manager">Nonprofit Manager</option>
                                <option value="Grant Writer">Grant Writer</option>
                                <option value="Community Development Specialist">Community Development Specialist</option>
                                <option value="Public Health Educator">Public Health Educator</option>
                                <option value="Government Relations Manager">Government Relations Manager</option>
                                <option value="Research Scientist">Research Scientist</option>
                                <option value="Data Entry Clerk">Data Entry Clerk</option>
                                <option value="Administrative Assistant">Administrative Assistant</option>
                            </select>
                        </div>
                        <div class="bottom-box1-label-input-half">
                            <p>Address</p>
        <input type="text" id="address" name="address" class="address-input" placeholder="Type Address">
        <div id="suggestions" class="suggestions" style="display: none;"></div>
                        </div>
                        <div class="bottom-box1-label-input-half">
                            <p>Date of Birth</p>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="bottom-box1-text">
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Total Income</p>
                            <select class="bottom-box1-text" id="total_income" name="total_income">
                                <option value="" disabled selected>Select Total Income Range</option>
                                <option value="less-than-10000">Less than ₱10,000</option>
                                <option value="10000-25000">₱10,000 - ₱25,000</option>
                                <option value="25000-50000">₱25,000 - ₱50,000</option>
                                <option value="50000-100000">₱50,000 - ₱100,000</option>
                                <option value="100000-above">₱100,000 and above</option>
                            </select>
                        </div>                        
                    </div>

                    <div class="bottom-box1-first">
                        <div class="bottom-box1-label-input-half">
                            <p>Move-in Date</p>
                            <input type="date" class="bottom-box1-text" id="move_in_date" name="move_in_date" placeholder="Type Move-in Date">
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Nationality</p>
                            <select class="bottom-box1-text" id="nationality" name="nationality" placeholder="Type Status">
                                <option value="" disabled selected>Select Nationality</option>
                                <option value="Filipino">Filipino</option>
                                <option value="American">American</option>
                                <option value="Canadian">Canadian</option>
                                <option value="British">British</option>
                                <option value="Australian">Australian</option>
                                <option value="Indian">Indian</option>
                                <option value="Chinese">Chinese</option>
                                <option value="Japanese">Japanese</option>
                                <option value="German">German</option>
                                <option value="French">French</option>
                                <option value="Spanish">Spanish</option>
                                <option value="Italian">Italian</option>
                                <option value="Brazilian">Brazilian</option>
                                <option value="Mexican">Mexican</option>
                                <option value="South African">South African</option>
                                <option value="Russian">Russian</option>
                                <option value="Singaporean">Singaporean</option>
                                <option value="Indonesian">Indonesian</option>
                                <option value="Thai">Thai</option>
                                <option value="Vietnamese">Vietnamese</option>
                                <option value="Saudi Arabian">Saudi Arabian</option>
                                <option value="Emirati">Emirati</option>
                            </select>
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Status</p>
                            <select class="bottom-box1-text" id="status_tenant" name="status_tenant" placeholder="Type Status">
                                <option value="" disabled selected>Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Number of Members</p>
                            <select class="bottom-box1-text" id="number_of_members" name="number_of_members" placeholder="Type Status">
                                <option value="" disabled selected>Select Number of Members</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Lease Duration (in months)</p>
                            <select class="bottom-box1-text" id="lease_duration" name="lease_duration" placeholder="Type Status">
                                <option value="" disabled selected>Select Lease Duration</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="bottom-box1-label-input">
                            <p>Apartment/Unit Number</p>
                            <select class="bottom-box1-text" id="apartment_unit" name="apartment_unit" placeholder="Type Status">
                                <option value="" disabled selected>Choose Unit Number</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="content-box box2">
                <p class="panel-title">Tenants</p>
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Tenant ID</th>
                            <th>Tenant Name</th>
                            <th>Email Address</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    <thead>
                    <tbody>
                        <?php while($results = mysqli_fetch_array($sqlTenants)) { ?>
                        <tr>
                        <td><?php echo $results['TenantId']; ?></td>
                            <td><?php echo $results['FullName']; ?></td>
                            <td><?php echo $results['Email']; ?></td>
                            <td><?php echo $results['PhoneNumber']; ?></td>
                            <td><?php echo $results['Location']; ?></td>
                            <td><?php echo $results['Status']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>    
        
        <script>
    document.getElementById('tenant_name').addEventListener('input', function(){
        this.value = this.value.replace(/[^a-zA-Z. ]/g, ''); // Allow space

});


            document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('select_tenant_id').addEventListener('change', function() {
        var select_tenant_id = this.value;

        if (select_tenant_id !== 'nothing') {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_tenant_data.php?select_tenant_id=' + select_tenant_id, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);

                        document.getElementById('tenant_id').value = data.TenantId || '';
                        document.getElementById('tenant_name').value = data.FullName || '';
                        document.getElementById('email_address').value = data.Email || '';
                    
                } 
            };
            xhr.send();
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('custom-alert-modal');
    const closeButton = document.getElementById('close-modal');
    const okButton = document.getElementById('ok-button');

    function showModal(message) {
        document.getElementById('modal-message').innerText = message;
        modal.style.display = 'block';
    }

    closeButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    okButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });


            const contact = document.getElementById('contact-number');
        contact.value = '09';

        contact.addEventListener('input', function (e) {

            this.value = this.value.replace(/\D/g, '');

            if (this.value.length > 11) {
    this.value = this.value.slice(0, 11);
    showModal("Contact number must be 11 digits.");
}

            if (this.value.length < 2) {
                this.value = '09';
            }
        });

        contact.addEventListener('paste', function (e) {
            e.preventDefault();
        });


        const emergencycontact = document.getElementById('emergencycontactnumber');
        emergencycontact.value = '09';

        emergencycontact.addEventListener('input', function (e) {
            this.value = this.value.replace(/\D/g, '');

            if(this.value.length > 11){
                this.value = this.value.slice(0, 11);
                showModal("Emergency contact number must be 11 digits.");
            }

            if(this.value.length < 2){
                this.value = '09';
            }

            emergancycontact.addEventListener('paste', function (e){
                e.preventDefault();
            })
    });

});


document.addEventListener('DOMContentLoaded', function () {
    const occupationSelect = document.getElementById('selectOccupation');
    const occupationDiv = document.querySelector('.bottom-box1-label-input-occupation');

    occupationSelect.addEventListener('change', function (e) {
        if (occupationSelect.value !== "Others") {
            const existingInput = document.getElementById('textOccupation');
            if (existingInput) {
                existingInput.remove();
            }
        }

        if (occupationSelect.value === "Others") {
            if (!document.getElementById('textOccupation')) {
                const inputOccupation = document.createElement('input');
                inputOccupation.type = 'text';
                inputOccupation.className = 'bottom-box1-text';
                inputOccupation.id = 'textOccupation';
                inputOccupation.placeholder = 'Type your occupation';

                inputOccupation.style.height = '25px';
        inputOccupation.style.width = '150px';
        inputOccupation.style.borderRadius = '5px';
        inputOccupation.style.paddingLeft = '5px';
        inputOccupation.style.border = '1px solid black';

        occupationDiv.innerHTML = '<p>Occupation</p>';
        occupationDiv.appendChild(inputOccupation);
            }
        } else {
            occupationDiv.innerHTML = `
                 <p>Occupation</p>
    <select class="bottom-box1-text" placeholder="Type Occupation" id="selectOccupation">
        <option value="" disabled selected>${occupationSelect.value}</option>
                                <option value="Software Engineer">Software Engineer</option>
                                <option value="Data Scientist">Data Scientist</option>
                                <option value="Web Developer">Web Developer</option>
                                <option value="Mobile App Developer">Mobile App Developer</option>
                                <option value="DevOps Engineer">DevOps Engineer</option>
                                <option value="Cloud Engineer">Cloud Engineer</option>
                                <option value="Data Analyst">Data Analyst</option>
                                <option value="Database Administrator">Database Administrator</option>
                                <option value="Network Administrator">Network Administrator</option>
                                <option value="IT Support Specialist">IT Support Specialist</option>
                                <option value="Cybersecurity Analyst">Cybersecurity Analyst</option>
                                <option value="Systems Analyst">Systems Analyst</option>
                                <option value="UX/UI Designer">UX/UI Designer</option>
                                <option value="Machine Learning Engineer">Machine Learning Engineer</option>
                                <option value="Blockchain Developer">Blockchain Developer</option>
                                <option value="Game Developer">Game Developer</option>
                                <option value="Technical Support Engineer">Technical Support Engineer</option>
                                <option value="QA Tester">QA Tester</option>
                                <option value="IT Project Manager">IT Project Manager</option>
                                <option value="Business Intelligence Analyst">Business Intelligence Analyst</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Medical Technologist">Medical Technologist</option>
                                <option value="Radiologic Technologist">Radiologic Technologist</option>
                                <option value="Physical Therapist">Physical Therapist</option>
                                <option value="Occupational Therapist">Occupational Therapist</option>
                                <option value="Clinical Research Associate">Clinical Research Associate</option>
                                <option value="Health Information Technician">Health Information Technician</option>
                                <option value="Medical Assistant">Medical Assistant</option>
                                <option value="Dentist">Dentist</option>
                                <option value="Veterinarian">Veterinarian</option>
                                <option value="Nutritionist">Nutritionist</option>
                                <option value="Psychologist">Psychologist</option>
                                <option value="Anesthesiologist">Anesthesiologist</option>
                                <option value="Surgeon">Surgeon</option>
                                <option value="Emergency Medical Technician (EMT)">Emergency Medical Technician (EMT)</option>
                                <option value="Medical Coder">Medical Coder</option>
                                <option value="Healthcare Administrator">Healthcare Administrator</option>
                                <option value="Laboratory Technician">Laboratory Technician</option>
                                <option value="Accountant">Accountant</option>
                                <option value="Financial Analyst">Financial Analyst</option>
                                <option value="Auditor">Auditor</option>
                                <option value="Tax Consultant">Tax Consultant</option>
                                <option value="Investment Banker">Investment Banker</option>
                                <option value="Business Development Manager">Business Development Manager</option>
                                <option value="Marketing Manager">Marketing Manager</option>
                                <option value="Sales Representative">Sales Representative</option>
                                <option value="Customer Service Representative">Customer Service Representative</option>
                                <option value="Human Resources Manager">Human Resources Manager</option>
                                <option value="Payroll Specialist">Payroll Specialist</option>
                                <option value="Risk Manager">Risk Manager</option>
                                <option value="Compliance Officer">Compliance Officer</option>
                                <option value=" Supply Chain Manager">Supply Chain Manager</option>
                                <option value="Operations Manager">Operations Manager</option>
                                <option value="Project Manager">Project Manager</option>
                                <option value="Business Analyst">Business Analyst</option>
                                <option value="Real Estate Agent">Real Estate Agent</option>
                                <option value="Insurance Agent">Insurance Agent</option>
                                <option value="Credit Analyst">Credit Analyst</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Professor">Professor</option>
                                <option value="Educational Consultant">Educational Consultant</option>
                                <option value="School Administrator">School Administrator</option>
                                <option value="Tutor">Tutor</option>
                                <option value="Training Specialist">Training Specialist</option>
                                <option value="Curriculum Developer">Curriculum Developer</option>
                                <option value="Instructional Designer">Instructional Designer</option>
                                <option value="Guidance Counselor">Guidance Counselor</option>
                                <option value="Librarian">Librarian</option>
                                <option value="Special Education Teacher">Special Education Teacher</option>
                                <option value="Language Instructor">Language Instructor</option>
                                <option value="Corporate Trainer">Corporate Trainer</option>
                                <option value="Early Childhood Educator">Early Childhood Educator</option>
                                <option value="Academic Advisor">Academic Advisor</option>
                                <option value="Researcher">Researcher</option>
                                <option value="Education Program Manager">Education Program Manager</option>
                                <option value="Online Course Developer">Online Course Developer</option>
                                <option value="Vocational Trainer">Vocational Trainer</option>
                                <option value="Education Policy Analyst">Education Policy Analyst</option>
                                <option value="Graphic Designer">Graphic Designer</option>
                                <option value="Content Writer">Content Writer</option>
                                <option value="Copywriter">Copywriter</option>
                                <option value="Social Media Manager">Social Media Manager</option>
                                <option value="Public Relations Specialist">Public Relations Specialist</option>
                                <option value="Marketing Specialist">Marketing Specialist</option>
                                <option value="SEO Specialist">SEO Specialist</option>
                                <option value="Video Editor">Video Editor</option>
                                <option value="Photographer">Photographer</option>
                                <option value="Journalist">Journalist</option>
                                <option value="Art Director">Art Director</option>
                                <option value="Brand Manager">Brand Manager</option>
                                <option value="Event Planner">Event Planner</option>
                                <option value="Fashion Designer">Fashion Designer</option>
                                <option value="Interior Designer">Interior Designer</option>
                                <option value="Music Producer">Music Producer</option>
                                <option value="Film Director">Film Director</option>
                                <option value="Animator">Animator</option>
                                <option value="Web Designer">Web Designer</option>
                                <option value="Creative Director">Creative Director</option>
                                <option value="Civil Engineer">Civil Engineer</option>
                                <option value="Mechanical Engineer">Mechanical Engineer</option>
                                <option value="Electrical Engineer">Electrical Engineer</option>
                                <option value="Chemical Engineer">Chemical Engineer</option>
                                <option value="Industrial Engineer">Industrial Engineer</option>
                                <option value="Environmental Engineer">Environmental Engineer</option>
                                <option value="Structural Engineer">Structural Engineer</option>
                                <option value="Project Engineer">Project Engineer</option>
                                <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                                <option value="Safety Engineer">Safety Engineer</option>
                                <option value="Manufacturing Engineer">Manufacturing Engineer</option>
                                <option value="Petroleum Engineer">Petroleum Engineer</option>
                                <option value="Aerospace Engineer">Aerospace Engineer</option>
                                <option value="Mining Engineer">Mining Engineer</option>
                                <option value="Marine Engineer">Marine Engineer</option>
                                <option value="Geotechnical Engineer">Geotechnical Engineer</option>
                                <option value="Robotics Engineer">Robotics Engineer</option>
                                <option value="Telecommunications Engineer">Telecommunications Engineer</option>
                                <option value="Design Engineer">Design Engineer</option>
                                <option value="HVAC Engineer">HVAC Engineer</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Welder">Welder</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Construction Worker">Construction Worker</option>
                                <option value="HVAC Technician">HVAC Technician</option>
                                <option value="Painter">Painter</option>
                                <option value="Mason">Mason</option>
                                <option value="Landscaper">Landscaper</option>
                                <option value="Chef">Chef</option>
                                <option value="Baker">Baker</option>
                                <option value="Hairdresser">Hairdresser</option>
                                <option value="Tailor">Tailor</option>
                                <option value="Security Guard">Security Guard</option>
                                <option value="Janitor">Janitor</option>
                                <option value="Pest Control Technician">Pest Control Technician</option>
                                <option value="Elevator Installer">Elevator Installer</option>
                                <option value="Locksmith">Locksmith</option>
                                <option value="Automotive Technician">Automotive Technician</option>
                                <option value="Sales Manager">Sales Manager</option>
                                <option value="Retail Sales Associate">Retail Sales Associate</option>
                                <option value="Customer Success Specialist">Customer Success Specialist</option>
                                <option value="Call Center Agent">Call Center Agent</option>
                                <option value="Account Executive">Account Executive</option>
                                <option value="Business Development Representative">Business Development Representative</option>
                                <option value="Field Sales Representative">Field Sales Representative</option>
                                <option value="Inside Sales Representative">Inside Sales Representative</option>
                                <option value="Sales Engineer">Sales Engineer</option>
                                <option value="Brand Ambassador">Brand Ambassador</option>
                                <option value="Technical Sales Specialist">Technical Sales Specialist</option>
                                <option value="Customer Experience Manager">Customer Experience Manager</option>
                                <option value="E-commerce Specialist">E-commerce Specialist</option>
                                <option value="Market Research Analyst">Market Research Analyst</option>
                                <option value="Sales Operations Analyst">Sales Operations Analyst</option>
                                <option value="Retail Store Manager">Retail Store Manager</option>
                                <option value="Merchandiser">Merchandiser</option>
                                <option value="Trade Marketing Specialist">Trade Marketing Specialist</option>
                                <option value="Customer Support Specialist">Customer Support Specialist</option>
                                <option value="Sales Coordinator">Sales Coordinator</option>
                                <option value="Civil Servant">Civil Servant</option>
                                <option value="Policy Analyst">Policy Analyst</option>
                                <option value="Social Worker">Social Worker</option>
                                <option value="Community Organizer">Community Organizer</option>
                                <option value="Public Health Administrator">Public Health Administrator</option>
                                <option value="Urban Planner">Urban Planner</option>
                                <option value="Environmental Scientist">Environmental Scientist</option>
                                <option value="Diplomat">Diplomat</option>
                                <option value="Law Enforcement Officer">Law Enforcement Officer</option>
                                <option value="Firefighter">Firefighter</option>
                                <option value="Emergency Management Specialist">Emergency Management Specialist</option>
                                <option value="Public Affairs Specialist">Public Affairs Specialist</option>
                                <option value="Legislative Assistant">Legislative Assistant</option>
                                <option value="City Planner">City Planner</option>
                                <option value="Public Relations Officer">Public Relations Officer</option>
                                <option value="Nonprofit Manager">Nonprofit Manager</option>
                                <option value="Grant Writer">Grant Writer</option>
                                <option value="Community Development Specialist">Community Development Specialist</option>
                                <option value="Public Health Educator">Public Health Educator</option>
                                <option value="Government Relations Manager">Government Relations Manager</option>
                                <option value="Research Scientist">Research Scientist</option>
                                <option value="Data Entry Clerk">Data Entry Clerk</option>
                                <option value="Administrative Assistant">Administrative Assistant</option>
                            </select>
            `;

        }
    });
});
            
                const addressInput = document.getElementById('address');
                const suggestionsDiv = document.getElementById('suggestions');
        
                addressInput.addEventListener('input', function() {
                    const query = this.value;
        
                    if (query.length < 3) {
                        suggestionsDiv.style.display = 'none'; 
                        return;
                    }
        
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsDiv.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const suggestionItem = document.createElement('div');
                                    suggestionItem.className = 'suggestion-item';
                                    suggestionItem.textContent = item.display_name; // Display the address
                                    suggestionItem.addEventListener('click', function() {
                                        addressInput.value = item.display_name; // Set the input value to the selected suggestion
                                        suggestionsDiv.style.display = 'none'; // Hide suggestions
                                    });
                                    suggestionsDiv.appendChild(suggestionItem);
                                });
                                suggestionsDiv.style.display = 'block'; // Show suggestions
                            } else {
                                suggestionsDiv.style.display = 'none'; // Hide suggestions if no results
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching data from Nominatim:', error);
                            suggestionsDiv.style.display = 'none'; 
                        });
                });
        
                document.addEventListener('click', function(event) {
                    if (!addressInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
                        suggestionsDiv.style.display = 'none';
                    }
                });

                document.addEventListener('DOMContentLoaded', function (){
                    
                    const addatinput = document.getElementById('email');

                    addatinput.addEventListener('input', function (){
                        
                        if(this.value.includes('@') && !this.value.includes('@gmail.com')){
                            const [addgmail] = this.value.split('@');
                            this.value = `${addgmail}@gmail.com`;
                        }
                    });
                    

                });

                document.getElementById('clear-button').addEventListener('click', function(){

                    var clearFields = [
                    document.getElementById('apartment_unit'),
                    document.getElementById('lease_duration'),
                    document.getElementById('number_of_members'),
                    document.getElementById('status_tenant'),
                    document.getElementById('nationality'),
                    document.getElementById('move_in_date'),
                    document.getElementById('total_income'),
                    document.getElementById('date_of_birth'),
                    document.getElementById('address'),
                    document.getElementById('occupation'),
                    document.getElementById('emergency_number'),
                    document.getElementById('emergency_contact_name'),
                    document.getElementById('contact_number'),
                    document.getElementById('email_address'),
                    document.getElementById('tenant_name'),
                    document.getElementById('tenant_id')
                    ];

                    if(clearFields.every(inputs => inputs.value === '')){
                        alert('Fields are empty!');
                        return;
                    }


                    if(confirm("Are you sure want to clear the inputs?")){
                        clearFields.forEach(inputs => inputs.value = '');
                    }

                });


                document.getElementById('register-button').addEventListener('click', async function(event){
                    event.preventDefault();

                    function validateTenantForm() {
                        const ApartmentUnit = document.getElementById('apartment_unit');
                        const LeaseDuration = document.getElementById('lease_duration');
                        const NumberOfMembers = document.getElementById('number_of_members');
                        const StatusTenant = document.getElementById('status_tenant');
                        const Nationality = document.getElementById('nationality');
                        const MoveInDate = document.getElementById('move_in_date');
                        const TotalIncome = document.getElementById('total_income');
                        const DateOfBirth = document.getElementById('date_of_birth');
                        const Address = document.getElementById('address');
                        const Occupation = document.getElementById('occupation');
                        const EmergencyNumber = document.getElementById('emergency_number');
                        const EmergencyContactName = document.getElementById('emergency_contact_name');
                        const ContactNumber = document.getElementById('contact_number');
                        const EmailAddress = document.getElementById('email_address');
                        const TenantName = document.getElementById('tenant_name');
                        const TenantId = document.getElementById('tenant_id');
                        const ID = document.getElementById('select_tenant_id');
                    
                    if(ID.value !== "nothing"){
                        alert('Deselect an ID first!');
                        return;
                    }

                        if (!ApartmentUnit.value || !LeaseDuration.value || !NumberOfMembers.value || !StatusTenant.value || !Nationality.value || !MoveInDate.value || !TotalIncome.value || !DateOfBirth.value || !Address.value || !Occupation.value || !EmergencyNumber.value || !EmergencyContactName.value || !ContactNumber.value || !EmailAddress.value || !TenantName.value) {
                            alert('Please fill in all fields!');
                            return;
                        }
                        return true;
                    }

                    if (!validateTenantForm()) {
                        return;
                    }

                

                    if(confirm("Are you sure you want to record this tenant?")) {
                        const form = new FormData(document.getElementById('tenant-form'));

                        try {
                        const response = await fetch('tenants.php', {
                            method: 'POST',
                            body: form
                        });    

                        if (response.ok){
                            alert('Tenant added successfully!');
                            await updateTenantDropdown();
                            await updateTenantTable();
                            document.getElementById('tenant-form').reset();
                        } else{
                            const errorText = await response.text();
                            console.error("Error:", errorText);
                            alert("There was an error recording the tenant.");
                        } 
                        } catch (error) {
                            console.error("Fetch error:", error);
                            alert("There was a network error.");
                        }
                    }
                });

                
                    
                const ID = document.getElementById('select_tenant_id');
                const TenantId = document.getElementById('tenant_id');

                    ID.addEventListener('input', function(){
                        if(this.value === "nothing"){
                            TenantId.value = '';
                        }
                    });



                    document.getElementById('modify-button').addEventListener('click', async function(event) {
    event.preventDefault();

    const tenantId = document.getElementById('tenant_id').value;
    const tenantName = document.getElementById('tenant_name').value;
    const emailAddress = document.getElementById('email_address').value;
    const contactNumber = document.getElementById('contact_number').value;
    const emergencyContactName = document.getElementById('emergency_contact_name').value;
    const emergencyNumber = document.getElementById('emergency_number').value;
    const occupation = document.getElementById('occupation').value;
    const address = document.getElementById('address').value;
    const dateOfBirth = document.getElementById('date_of_birth').value;
    const totalIncome = document.getElementById('total_income').value;
    const moveInDate = document.getElementById('move_in_date').value;
    const nationality = document.getElementById('nationality').value;
    const statusTenant = document.getElementById('status_tenant').value;
    const numberOfMembers = document.getElementById('number_of_members').value;
    const leaseDuration = document.getElementById('lease_duration').value;
    const apartmentUnit = document.getElementById('apartment_unit').value;

    if (!tenantId) {
        alert('Please select a tenant ID to modify.');
        return;
    }

    const formData = new FormData();
    formData.append('tenant_id', tenantId);
    formData.append('tenant_name', tenantName);
    formData.append('email_address', emailAddress);
    formData.append('contact_number', contactNumber);
    formData.append('emergency_contact_name', emergencyContactName);
    formData.append('emergency_number', emergencyNumber);
    formData.append('occupation', occupation);
    formData.append('address', address);
    formData.append('date_of_birth', dateOfBirth);
    formData.append('total_income', totalIncome);
    formData.append('move_in_date', moveInDate);
    formData.append('nationality', nationality);
    formData.append('status_tenant', statusTenant);
    formData.append('number_of_members', numberOfMembers);
    formData.append('lease_duration', leaseDuration);
    formData.append('apartment_unit', apartmentUnit);

    try {
        const response = await fetch('update_tenant.php', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            alert('Tenant updated successfully!');
            await updateTenantDropdown();
            await updateTenantTable();
        } else {
            const errorText = await response.text();
            console.error("Error:", errorText);
            alert("There was an error updating the tenant.");
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("There was a network error.");
    }
});

document.getElementById('archive-button').addEventListener('click', async function(event) {
    event.preventDefault();

    const tenantId = document.getElementById('tenant_id').value;

    if (!tenantId) {
        alert('Please select a tenant ID to delete.');
        return;
    }

    const formData = new FormData();
    formData.append('tenant_id', tenantId);

    try {
        const response = await fetch('delete_tenant.php', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            alert('Tenant deleted successfully!');
            // Optionally reset the form or update the UI
            document.getElementById('tenant_id').value = ''; // Clear the tenant ID input
            await updateTenantDropdown();
            await updateTenantTable();
        } else {
            const errorText = await response.text();
            console.error("Error:", errorText);
            alert("There was an error deleting the tenant.");
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("There was a network error.");
    }
});


async function updateTenantDropdown() {
    try {
        const response = await fetch('get_tenant_ids.php'); // Create this PHP file
        const tenantIds = await response.json();

        const selectTenantId = document.getElementById('select_tenant_id');
        selectTenantId.innerHTML = '<option value="nothing">Select Tenant ID</option>'; // Reset the dropdown

        tenantIds.forEach(tenant => {
            const option = document.createElement('option');
            option.value = tenant.TenantId;
            option.textContent = tenant.TenantId;
            selectTenantId.appendChild(option);
        });
    } catch (error) {
        console.error("Error fetching tenant IDs:", error);
    }
}


async function updateTenantTable() {
    try {
        const response = await fetch('get_tenants.php');
        const tenants = await response.json();

        const tbody = document.querySelector('.summary-table tbody');
        tbody.innerHTML = ''; // Clear the existing table rows

        tenants.forEach(tenant => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${tenant.TenantId}</td>
                <td>${tenant.FullName}</td>
                <td>${tenant.Email}</td>
                <td>${tenant.PhoneNumber}</td>
                <td>${tenant.Location}</td>
                <td>${tenant.Status}</td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error("Error fetching tenant data:", error);
    }
}


/* Function to handle tenant updates and deletions, shorten way
async function handleTenantAction(action) {
    const tenantId = document.getElementById('tenant_id').value;

    if (!tenantId) {
        alert(`Please select a tenant ID to ${action}.`);
        return;
    }

    const formData = new FormData();
    formData.append('tenant_id', tenantId);

    // Add additional fields for update action
    if (action === 'update') {
        formData.append('tenant_name', document.getElementById('tenant_name').value);
        formData.append('email_address', document.getElementById('email_address').value);
        formData.append('contact_number', document.getElementById('contact_number').value);
        formData.append('emergency_contact_name', document.getElementById('emergency_contact_name').value);
        formData.append('emergency_number', document.getElementById('emergency_number').value);
        formData.append('occupation', document.getElementById('occupation').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('date_of_birth', document.getElementById('date_of_birth').value);
        formData.append('total_income', document.getElementById('total_income').value);
        formData.append('move_in_date', document.getElementById('move_in_date').value);
        formData.append('nationality', document.getElementById('nationality').value);
        formData.append('status_tenant', document.getElementById('status_tenant').value);
        formData.append('number_of_members', document.getElementById('number_of_members').value);
        formData.append('lease_duration', document.getElementById('lease_duration').value);
        formData.append('apartment_unit', document.getElementById('apartment_unit').value);
    }

    try {
        const response = await fetch(`${action}_tenant.php`, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(`Tenant ${action}d successfully!`);
            document.getElementById('tenant_id').value = ''; // Clear the tenant ID input
            await updateTenantDropdown();
        } else {
            console.error("Error:", result.error);
            alert(`There was an error ${action}ing the tenant.`);
        }
    } catch (error) {
        console.error("Fetch error:", error);
        alert("There was a network error.");
    }
}

// Event listeners for buttons
document.getElementById('modify-button').addEventListener('click', async function(event) {
    event.preventDefault();
    await handleTenantAction('update');
});

document.getElementById('archive-button').addEventListener('click', async function(event) {
    event.preventDefault();
    await handleTenantAction('delete');
});

// Function to update the tenant dropdown
async function updateTenantDropdown() {
    try {
        const response = await fetch('get_tenant_ids.php');
        const tenantIds = await response.json();

        const selectTenantId = document.getElementById('select_tenant_id');
        selectTenantId.innerHTML = '<option value="nothing">Select Tenant ID</option>'; // Reset the dropdown

        tenantIds.forEach(tenant => {
            const option = document.createElement('option');
            option.value = tenant.TenantId;
            option.textContent = tenant.TenantId;
            selectTenantId.appendChild(option);
        });
    } catch (error) {
        console.error("Error fetching tenant IDs:", error);
    }
} */
            </script>
</body>
</html>
