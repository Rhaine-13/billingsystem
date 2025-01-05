<?php
require('./database.php');
session_start();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // If not logged in, redirect to the login page
    header("Location: loginpage.php");
    exit();
}

$querytotalTenant = "SELECT COUNT(*) AS total FROM tenant";
$sqltotalTenant = mysqli_query($connection, $querytotalTenant);
$row = mysqli_fetch_assoc($sqltotalTenant);
$totalTenants = $row['total']; // Store the total count

// The rest of your dashboard code goes here
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
            display: flex;
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
            width: 220px; 
    transition: width 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0);
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
            transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1.0);
        }

        .sidenav-menus:hover {
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
        flex: 1;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: auto auto auto; 
    gap: 20px; 
    margin: 20px 20px 20px 0;
}

.content-box {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.box1, .box2, .box3 {
    height: 200px;
}

.box4, .box5{
    height: 155px; 
}


.box1 {
    grid-column: 1; 
    grid-row: 1;    
}

.box2 {
    grid-column: 2; 
    grid-row: 1;    
}

.box3 {
    grid-column: 3; 
    grid-row: 1;    
}

.box4 {
    grid-column: 1 / span 3;
    grid-row: 2;
    overflow: hidden; 
}

.box5 {
    grid-column: 1 / span 3;
    grid-row: 3;           
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


.panel-title{
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 2px;
}

.below-title{
    font-size: 10px;
    font-weight: 300;
}

.number-title{
    font-size: 60px;
    font-weight: 800;
}

.box2 {
    display: flex;
    flex-direction: column;
    gap: 20px; 
    padding-bottom: 0; 
    margin-bottom: 0; 
}

.box-2-bottom {
    display: flex;
    flex-direction: column;
    margin: 0; 
}

.box-2-bottom img{
    height: 30px;
    width: 30px;
}

.box3 {
    display: flex;
    flex-direction: column;
    gap: 20px; 
    padding-bottom: 0; 
    margin-bottom: 0; 
}

.box-3-bottom {
    display: flex;
    flex-direction: column;
    margin: 0; 
}

.box-3-bottom img{
    height: 30px;
    width: 30px;
}

.box-stretch-fit {
    height: 100%;
}

.box-2-top,
.box-2-bottom {
    margin-bottom: 20px; 
}

.box-2-bottom:last-child {
    margin-bottom: 0;
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

#enrollmentChart {
    width: 100% !important;
    height: auto !important;
}

.profile-nav{
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
            align-items: flex-start;
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

    </style>
</head>
<body>
    <div class="sidenav-main">
        <div class="sidenav-header">
            <img src="assets/logo2.png" id="tupi" alt="">
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
        <img src="data:image/jpeg;base64,<?php echo htmlspecialchars($_SESSION['tenantImage']); ?>" style="height: 50px; width: 50px;">
            <div class="profile-nav">
            <p><?php echo isset($_SESSION['FullName']) ? htmlspecialchars($_SESSION['FullName']) : ''; ?></p>
                <p>Home owner</p>
            </div>
        </div>
    </div>

        <div class="body-content">
            <div class="content-box box1">
                <div class="table-container">
                    <canvas id="enrollmentChart" width="400" height="200"></canvas>
                </div>
            </div>

            <div class="content-box box2">
                <div class="box-stretch-fit">
                    <div class="box-2-top">
                        <p class="panel-title">Total Tenants</p>
                        <p class="below-title">View your tenants total count</p>
                    </div>
                    <div class="box-2-bottom">
                        <p class="number-title"><?php echo $totalTenants; ?></p>
                        <img src="assets/tenant.png" alt="">
                    </div>
                </div>
            </div>

            <div class="content-box box3">
                <div class="box-stretch-fit">
                    <div class="box-2-top">
                        <p class="panel-title">My Wallet</p>
                        <p class="below-title">View the totality of your money here</p>
                    </div>
                    <div class="box-2-bottom">
                        <p class="number-title" id="dollar"></p>
                        <img src="assets/tenant.png" alt="">
                    </div>
                </div>
            </div>

            <div class="content-box box4">
                <p class="panel-title">Summary</p>
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Current Balance</th>
                            <th>Total Bill</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            
            <div class="content-box box5">
                <p class="panel-title">Reminders</p>
                <table class="summary-table">
                    <thead>
                        <tr>
                            <th>Tenant Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                        </tr>
                    <thead>
                    <tbody>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                        <tr>
                            <td>Rhaine Hdart Coldovero</td>
                            <td>coldoverorhainehdart@gmail.com</td>
                            <td>09999562694</td>
                            <td>P100</td>
                            <td>P5000</td>
                            <td>December 24, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
        
        <script>
            window.onload = function() {
                const ctx = document.getElementById('enrollmentChart').getContext('2d');
                const enrollmentData = {
                    labels: ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
                    datasets: [
                        {
                            label: 'Number of Students',
                            data: [50, 60, 55, 70, 65, 80], 
                            borderColor: 'rgba(75, 192, 192, 1)', 
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                            tension: 0.4, 
                            borderWidth: 2 
                        }
                    ]
                };
            
                const enrollmentChart = new Chart(ctx, {
                    type: 'line', 
                    data: enrollmentData,
                    options: {
                        responsive: true, 
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100, 
                                min: 0, 
                                ticks: {
                                    stepSize: 20, 
                                    font: {
                                        family: 'Switzer, sans-serif'
                                    }
                                },
                                grid: {
                                    display: false 
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Grade Level',
                                    font: {
                                        family: 'Switzer, sans-serif'
                                    }
                                },
                                grid: {
                                    display: false 
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    font: {
                                        family: 'Switzer, sans-serif'
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Enrollment Data by Grade Level',
                                font: {
                                    family: 'Switzer, sans-serif'
                                }
                            }
                        }
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', function(){

                const fixdollar = document.getElementById('dollar');

                if(fixdollar && fixdollar.textContent.trim() === ""){
                    fixdollar.textContent = "$0";
                }
            })


            document.addEventListener('DOMContentLoaded', function() {
    const icon = document.getElementById('tupi');
    const sidenav = document.querySelector('.sidenav-main'); // Select the sidenav element
    let isTextVisible = true; // State variable to track visibility

    // Store original text
    const originalTexts = {
        dashboard: 'Dashboard',
        bills: 'Bills',
        tenant: 'Tenant',
        settings: 'Settings',
        logout: 'Logout'
    };

    icon.addEventListener('click', function() {
        if (isTextVisible) {
            // If text is visible, remove it
            const textElements = document.querySelectorAll('.sidenav-main p'); // Select all <p> elements
            textElements.forEach(function(p) {
                p.remove();
            });

            // Reduce the width of the sidenav
            sidenav.style.width = '60px'; // Adjust the width as needed
        } else {
            // If text is not visible, restore it
            const dashboardMenu = document.querySelector('.dashboard-menu');
            const billsMenu = document.querySelector('#billsMenu');
            const tenantMenu = document.querySelector('.sidenav-menus:nth-of-type(3)');
            const settingsMenu = document.querySelector('.sidenav-menus:nth-of-type(4)');
            const logoutMenu = document.querySelector('.sidenav-menus:last-of-type');

            // Restore the text by creating new <p> elements
            dashboardMenu.innerHTML += `<p>${originalTexts.dashboard}</p>`;
            billsMenu.innerHTML += `<p>${originalTexts.bills}</p>`;
            tenantMenu.innerHTML += `<p>${originalTexts.tenant}</p>`;
            settingsMenu.innerHTML += `<p>${originalTexts.settings}</p>`;
            logoutMenu.innerHTML += `<p>${originalTexts.logout}</p>`;

            // Restore the width of the sidenav
            sidenav.style.width = '220px'; // Reset to original width
        }

        // Toggle the visibility state
        isTextVisible = !isTextVisible;
    });
});
       
            </script>
            
</body>
</html>
