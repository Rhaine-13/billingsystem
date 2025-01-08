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

    $justTenantIdquery = 220035;
    $DateToday = date('Y-m-d');
    $Due = date('Y-m-d', strtotime($DateToday . ' + 5 days'));

    $prev_read_elec = $_POST['previousreading'];
    $pres_read_elec = $_POST['presentreading']; 
    $total_elec = $_POST['electricity'];   
    $prev_read_water = $_POST['waterpreviousreading'];     
    $pres_read_water = $_POST['waterpresentreading']; 
    $total_water = $_POST['water'];
    $houserent = $_POST['house-rent'];
    $internet = $_POST['internet'];
    $gas = $_POST['gas'];
    $trash = $_POST['trash'];
    $total = $_POST['total'];

    $prev_read_elec = preg_replace('/[^\d.]/', '', $prev_read_elec);
    $pres_read_elec = preg_replace('/[^\d.]/', '', $pres_read_elec);
    $total_elec = preg_replace('/[^\d.]/', '', $total_elec);
    $prev_read_water = preg_replace('/[^\d.]/', '', $prev_read_water);  
    $pres_read_water = preg_replace('/[^\d.]/', '', $pres_read_water);
    $total_water = preg_replace('/[^\d.]/', '',  $total_water);
    $houserent = preg_replace('/[^\d.]/', '', $houserent);
    $internet = preg_replace('/[^\d.]/', '', $internet);
    $gas = preg_replace('/[^\d.]/', '', $gas);
    $trash = preg_replace('/[^\d.]/', '', $trash);
    $total = preg_replace('/[^\d.]/', '', $total);


    $prev_read_elec = intval($prev_read_elec);
    $pres_read_elec = intval($pres_read_elec);
    $total_elec = intval($total_elec);
    $prev_read_water = intval($prev_read_water);  
    $pres_read_water = intval($pres_read_water);
    $total_water = intval($total_water);
    $houserent = intval($houserent);
    $internet = intval($internet);
    $gas = intval($gas);
    $trash = intval($trash);
    $total = intval($total);

    
    $prev_read_elec = mysqli_real_escape_string($connection, $prev_read_elec);
    $pres_read_elec = mysqli_real_escape_string($connection, $pres_read_elec);
    $total_elec = mysqli_real_escape_string($connection, $total_elec);
    $prev_read_water = mysqli_real_escape_string($connection, $prev_read_water);
    $pres_read_water = mysqli_real_escape_string($connection, $pres_read_water);
    $total_water = mysqli_real_escape_string($connection, $total_water);
    $houserent = mysqli_real_escape_string($connection, $houserent);
    $internet = mysqli_real_escape_string($connection, $internet);
    $gas = mysqli_real_escape_string($connection, $gas);
    $trash = mysqli_real_escape_string($connection, $trash);
    $total = mysqli_real_escape_string($connection, $total);
      
    $query = "INSERT INTO bill (TenantId, ElectricityPrevious, ElectricityPresent, ElectricityTotal, WaterPrevious, WaterPresent, WaterTotal, MeterImageElectricity, MeterImageWater, HouseRent, Internet, Gas, TrashCollection, Total, CalculationDate, DueDate) 
                            VALUES ('$justTenantIdquery', '$prev_read_elec', '$pres_read_elec', '$total_elec', '$prev_read_water', '$pres_read_water', '$total_water', '', '', '$houserent', '$internet', '$gas', '$trash', '$total', '$DateToday', '$Due')";

    if(mysqli_query($connection, $query)){
        header("Location: bills.php");
        exit();
    } else {
        echo "ERROR: Could not execute $query. " . mysqli_error($connection);
    }

}

$queryTenants = "SELECT t.TenantId, t.FullName FROM tenant t RIGHT JOIN bill b ON t.TenantId = b.TenantId";
$sqlTenants = mysqli_query($connection, $queryTenants);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Layout with CSS Grid</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./styles/bills.css">
</head>
<body>
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
            <p class="panel-title">Compute Bills</p>
            <div class="bill-item">
                    <label for="house-rent">House Rent</label>
                    <select id="select-tenant" name="select-tenant" class="select-tenant" value="">
                    <option value="nothing">Select Tenant</option>   
                        <?php while($results = mysqli_fetch_array($sqlTenants)) { ?>
                        <option value="<?php echo $results['TenantId']; ?>"><?php echo $results['TenantId'] . ' - ' . $results['FullName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <form id="bills-form" class="bills-class" method="post" action="bills.php">
                <div class="bill-item">
                    <label for="electricity">Electricity</label>

                    <div class="prevpresmain">
                    <div class="prevpres">
                        <p>Previous</p>
                        <input type="number" id="previousreading" name="previousreading" style="width: 50px;" class="value" value="" readonly/>
                    </div>

                    <div class="prevpres">
                        <p>Present</p>
                        <input type="number" id="presentreading" name="presentreading" style="width: 50px;" class="value" value=""/>
                    </div>
                    </div>

                    <span class="material-icons arrow_forward">arrow_forward</span>

                    <input type="text" id="firstcalculation" name="firstcalculation" class="value" value="" readonly/>

                    <p>=</p>

                    <input type="text" id="electricity" name="electricity" class="value" value="" readonly/>
                </div>
                <div class="bill-item">
                    <label for="Water">Water</label>

                    <div class="prevpresmain">
                    <div class="prevpres">
                        <p>Previous</p>
                        <input type="number" id="waterpreviousreading" name="waterpreviousreading" style="width: 50px;" class="value" value="" readonly/>
                    </div>

                    <div class="prevpres">
                        <p>Present</p>
                        <input type="number" id="waterpresentreading" name="waterpresentreading" style="width: 50px;" class="value" value=""/>
                    </div>
                    </div>

                    <span class="material-icons arrow_forward_water">arrow_forward</span>

                    <input type="text" id="waterfirstcalculation" name="waterfirstcalculation" class="value" value="" readonly/>

                    <p>=</p>

                    <input type="text" id="water" name="water" class="value" value="" readonly/>
                </div>
                <div class="bill-item">
                    <label for="house-rent">House Rent</label>
                    <input type="text" id="house-rent" name="house-rent" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="internet">Internet</label>
                    <input type="text" id="internet" name="internet" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="gas">Gas</label>
                    <input type="text" id="gas" name="gas" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="trash">Trash Collection</label>
                    <input type="text" id="trash" name="trash" class="value" value="" />
                </div>
                <div class="total">
                    <label for="total">Total:</label>
                    <input type="text" id="total" name="total" class="value" value="" readonly />
                </div>
                <div class="bill-item">
                    <input type="submit" id="record-bill" class="record-bill" value="Record Bill" />
                </div>
            </div>
    </form>

            <div class="content-box box2">
                <div class="box-stretch-fit">
                    <div class="box-2-top">
                        <p class="panel-title">Calculator</p>
                    </div>
                    <div class="box-2-bottom">
                        <input type="textbox" class="calcu-row-text" id="calcu-text">
                        <div class="calcu-row">
                            <input type="button" class="calcu-row-button" id="1" value="1">
                            <input type="button" class="calcu-row-button" id="2" value="2">
                            <input type="button" class="calcu-row-button" id="3" value="3">
                            <input type="button" class="calcu-row-button" id="4" value="4">
                            <input type="button" class="calcu-row-button" id="5" value="5">
                            <input type="button" class="calcu-row-button" id="+" value="+">
                        </div>

                        <div class="calcu-row">
                            <input type="button" class="calcu-row-button" id="6" value="6">
                            <input type="button" class="calcu-row-button" id="7" value="7">
                            <input type="button" class="calcu-row-button" id="8" value="8">
                            <input type="button" class="calcu-row-button" id="9" value="9">
                            <input type="button" class="calcu-row-button" id="10" value="10">
                            <input type="button" class="calcu-row-button" id="-" value="-">
                        </div>

                        <div class="calcu-row">
                            <input type="button" class="calcu-row-button" id="" value="<">
                            <input type="button" class="calcu-row-button" id="1" value=">">
                            <input type="button" class="calcu-row-button" id="c" value="c">
                            <input type="button" class="calcu-row-button" id="=" value="=">
                            <input type="button" class="calcu-row-button" id="/" value="/">
                            <input type="button" class="calcu-row-button" id="x" value="x">
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-box box3">
                <p class="panel-title">Convert Currency</p>
                <div class="convert-center">
                    <div class="convert-money">
                        <select class="convert-row-button" id="currency-select">
                            <option value="">Select Currency</option>
                            <option value="PHP">PHP (Philippine Peso)</option>
                            <option value="USD">USD (United States Dollar)</option>
                            <option value="EUR">EUR (Euro)</option>
                            <option value="JPY">JPY (Japanese Yen)</option>
                            <option value="GBP">GBP (British Pound Sterling)</option>
                            <option value="AUD">AUD (Australian Dollar)</option>
                            <option value="CAD">CAD (Canadian Dollar)</option>
                            <option value="CHF">CHF (Swiss Franc)</option>
                            <option value="CNY">CNY (Chinese Yuan)</option>
                            <option value="INR">INR (Indian Rupee)</option>
                            <option value="SGD">SGD (Singapore Dollar)</option>
                            <option value="HKD">HKD (Hong Kong Dollar)</option>
                            <option value="NZD">NZD (New Zealand Dollar)</option>
                            <option value="RUB">RUB (Russian Ruble)</option>
                            <option value="ZAR">ZAR (South African Rand)</option>
                            <option value="MXN">MXN (Mexican Peso)</option>
                            <option value="BRL">BRL (Brazilian Real)</option>
                            <option value="SEK">SEK (Swedish Krona)</option>
                            <option value="NOK">NOK (Norwegian Krone)</option>
                            <option value="DKK">DKK (Danish Krone)</option>
                            <option value="THB">THB (Thai Baht)</option>
                            <option value="MYR">MYR (Malaysian Ringgit)</option>
                            <option value="IDR">IDR (Indonesian Rupiah)</option>
                            <option value="PKR">PKR (Pakistani Rupee)</option>
                            <option value="AED">AED (United Arab Emirates Dirham)</option>
                            <option value="ILS">ILS (Israeli New Shekel)</option>
                            <option value="CLP">CLP (Chilean Peso)</option>
                            <option value="COP">COP (Colombian Peso)</option>
                            <option value="PEN">PEN (Peruvian Sol)</option>
                            <option value="VND">VND (Vietnamese Dong)</option>
                            <option value="LKR">LKR (Sri Lankan Rupee)</option>
                            <option value="HUF">HUF (Hungarian Forint)</option>
                            <option value="CZK">CZK (Czech Koruna)</option>
                            <option value="RON">RON (Romanian Leu)</option>
                            <option value="BGN">BGN (Bulgarian Lev)</option>
                            <option value="HRK">HRK (Croatian Kuna)</option>
                            <option value="ISK">ISK (Icelandic Króna)</option>
                            <option value="JMD">JMD (Jamaican Dollar)</option>
                            <option value="DOP">DOP (Dominican Peso)</option>
                            <option value="NPR">NPR (Nepalese Rupee)</option>
                            <option value="MUR">MUR (Mauritian Rupee)</option>
                            <option value="MAD">MAD (Moroccan Dirham)</option>
                            <option value="KWD">KWD (Kuwaiti Dinar)</option>
                            <option value="BHD">BHD (Bahraini Dinar)</option>
                            <option value="OMR">OMR (Omani Rial)</option>
                            <option value="QAR">QAR (Qatari Rial)</option>
                            <option value="JOD">JOD (Jordanian Dinar)</option>
                            <option value="TWD">TWD (New Taiwan Dollar)</option>
                        </select>
                        <input type="textbox" class="convert-row-text">
                    </div>
                    <p>=</p>
                    <div class="convert-money">
                        <select class="convert-row-button" id="currency-select">
                            <option value="">Select Currency</option>
                            <option value="PHP">PHP (Philippine Peso)</option>
                            <option value="USD">USD (United States Dollar)</option>
                            <option value="EUR">EUR (Euro)</option>
                            <option value="JPY">JPY (Japanese Yen)</option>
                            <option value="GBP">GBP (British Pound Sterling)</option>
                            <option value="AUD">AUD (Australian Dollar)</option>
                            <option value="CAD">CAD (Canadian Dollar)</option>
                            <option value="CHF">CHF (Swiss Franc)</option>
                            <option value="CNY">CNY (Chinese Yuan)</option>
                            <option value="INR">INR (Indian Rupee)</option>
                            <option value="SGD">SGD (Singapore Dollar)</option>
                            <option value="HKD">HKD (Hong Kong Dollar)</option>
                            <option value="NZD">NZD (New Zealand Dollar)</option>
                            <option value="RUB">RUB (Russian Ruble)</option>
                            <option value="ZAR">ZAR (South African Rand)</option>
                            <option value="MXN">MXN (Mexican Peso)</option>
                            <option value="BRL">BRL (Brazilian Real)</option>
                            <option value="SEK">SEK (Swedish Krona)</option>
                            <option value="NOK">NOK (Norwegian Krone)</option>
                            <option value="DKK">DKK (Danish Krone)</option>
                            <option value="THB">THB (Thai Baht)</option>
                            <option value="MYR">MYR (Malaysian Ringgit)</option>
                            <option value="IDR">IDR (Indonesian Rupiah)</option>
                            <option value="PKR">PKR (Pakistani Rupee)</option>
                            <option value="AED">AED (United Arab Emirates Dirham)</option>
                            <option value="ILS">ILS (Israeli New Shekel)</option>
                            <option value="CLP">CLP (Chilean Peso)</option>
                            <option value="COP">COP (Colombian Peso)</option>
                            <option value="PEN">PEN (Peruvian Sol)</option>
                            <option value="VND">VND (Vietnamese Dong)</option>
                            <option value="LKR">LKR (Sri Lankan Rupee)</option>
                            <option value="HUF">HUF (Hungarian Forint)</option>
                            <option value="CZK">CZK (Czech Koruna)</option>
                            <option value="RON">RON (Romanian Leu)</option>
                            <option value="BGN">BGN (Bulgarian Lev)</option>
                            <option value="HRK">HRK (Croatian Kuna)</option>
                            <option value="ISK">ISK (Icelandic Króna)</option>
                            <option value="JMD">JMD (Jamaican Dollar)</option>
                            <option value="DOP">DOP (Dominican Peso)</option>
                            <option value="NPR">NPR (Nepalese Rupee)</option>
                            <option value="MUR">MUR (Mauritian Rupee)</option>
                            <option value="MAD">MAD (Moroccan Dirham)</option>
                            <option value="KWD">KWD (Kuwaiti Dinar)</option>
                            <option value="BHD">BHD (Bahraini Dinar)</option>
                            <option value="OMR">OMR (Omani Rial)</option>
                            <option value="QAR">QAR (Qatari Rial)</option>
                            <option value="JOD">JOD (Jordanian Dinar)</option>
                            <option value="TWD">TWD (New Taiwan Dollar)</option>
                        </select>
                        <input type="textbox" class="convert-row-text" readonly>
                    </div>
                </div>
            </div>

            <div class="content-box box4">
                <p class="panel-title">Due Date</p>
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
                <p class="panel-title">Transaction History</p>
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

document.getElementById('select-tenant').addEventListener('change', function() {
            var TenantId = this.value;
            if (TenantId !== 'nothing') {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_tenant_bills.php?TenantId=' + TenantId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                // Set the values in the input fields
                document.getElementById('previousreading').value = data.ElectricityPrevious || '';
                document.getElementById('presentreading').value = data.ElectricityPresent || '';
                document.getElementById('waterpreviousreading').value = data.WaterPrevious || '';
                document.getElementById('waterpresentreading').value = data.WaterPresent || '';
            }
                };
                xhr.send();
            }
        });

document.addEventListener('DOMContentLoaded', function(){

       function calculateTotal() {

        const deducted = document.getElementById('firstcalculation');
const prev = document.getElementById('previousreading');
const next = document.getElementById('presentreading');
const totalelectricity = document.getElementById('electricity');

const waterdeducted = document.getElementById('waterfirstcalculation');
const waterprev = document.getElementById('waterpreviousreading');
const waternext = document.getElementById('waterpresentreading');
const totalwater = document.getElementById('water');

waternext.addEventListener('input', function(){
    const waternextval = parseFloat(waternext.value) || 0;
    const waterprevval = parseFloat(waterprev.value) || 0;

    if (waternextval <= waterprevval) {
        waternext.value = waterprevval;
        return;
    }

    const waterdeduct = waternextval - waterprevval;
    waterdeducted.value = waterdeduct.toLocaleString() + ' x 35';
    totalwater.value = waterdeduct * 35;

    const arrowIcon = document.querySelector('.arrow_forward_water');
    arrowIcon.classList.add('arrowAnnimate');

    arrowIcon.addEventListener('animationend', function(){
        arrowIcon.classList.remove('arrowAnnimate');
    });

    calculateTotal();  
});

next.addEventListener('input', function(){
    const nextval = parseFloat(next.value) || 0;
    const prevval = parseFloat(prev.value) || 0;

    if (nextval <= prevval) {
            next.value = prevval; 
            return; 
        }

    const deduct = nextval - prevval;
    deducted.value = deduct.toLocaleString() + ' x 22';
    totalelectricity.value = deduct * 22;

    const arrowIcon = document.querySelector('.arrow_forward');
        arrowIcon.classList.add('arrowAnnimate');

        arrowIcon.addEventListener('animationend', function() {
            arrowIcon.classList.remove('arrowAnnimate');
        });


    calculateTotal();  
});


        const totalelectricityprocess = parseInt(document.getElementById('electricity').value.replace(/[^0-9.-]+/g, "")) || 0;
    const totalwaterprocess = parseInt(document.getElementById('water').value.replace(/[^0-9.-]+/g, "")) || 0;
    const houseRent = parseInt(document.getElementById('house-rent').value.replace(/[^0-9.-]+/g, "")) || 0;
    const internet = parseInt(document.getElementById('internet').value.replace(/[^0-9.-]+/g, "")) || 0;
    const gas = parseInt(document.getElementById('gas').value.replace(/[^0-9.-]+/g, "")) || 0;
    const trash = parseInt(document.getElementById('trash').value.replace(/[^0-9.-]+/g, "")) || 0;

    document.getElementById('electricity').value = (totalelectricityprocess > 0) ? 'P ' + totalelectricityprocess.toLocaleString() : 'P 0';
    document.getElementById('water').value = (totalwaterprocess > 0) ? 'P ' + totalwaterprocess.toLocaleString() : 'P 0';
    document.getElementById('house-rent').value = (houseRent > 0) ? 'P ' + houseRent.toLocaleString() : 'P 0';
    document.getElementById('internet').value = (internet > 0) ? 'P ' + internet.toLocaleString() : 'P 0';
    document.getElementById('gas').value = (gas > 0) ? 'P ' + gas.toLocaleString() : 'P 0';
    document.getElementById('trash').value = (trash > 0) ? 'P ' + trash.toLocaleString() : 'P 0';
    

    const total = totalelectricityprocess + totalwaterprocess + houseRent + internet + gas + trash;
    
    
    
    document.getElementById('total').value = 'P ' + total.toLocaleString();
}

const inputs = document.querySelectorAll('.value');
inputs.forEach(input => {
    input.addEventListener('input', calculateTotal);
});

calculateTotal();

});

document.addEventListener('DOMContentLoaded', function(){

    const calcutext = document.getElementById('calcu-text');
    const buttons = [
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '+', '-', '/', 'c', 'x'
    ];

    buttons.forEach(num => {
                const button = document.getElementById(num);
                if (button) {
                    button.addEventListener('click', function() {
                        calcutext.value += num;
                    });
                }
            });

            document.getElementById('c').addEventListener('click', function() {
                calcutext.value = "";
            });

    calcutext.addEventListener('input', function (){
        this.value = this.value.replace(/[^0-9+\-\/]/g, '');

        this.value = this.value.replace(/([+\-\/])\1+/g, '$1'); 
        this.value = this.value.replace(/([+\-\/])([+\-\/])/g, '$1');
    });
    
});



document.querySelector('.record-bill').addEventListener('click', async function(event) {
    event.preventDefault();

    var ele_prev = document.getElementById('previousreading');
    var ele_pres = document.getElementById('presentreading');
    var ele = document.getElementById('electricity');
    var wat_prev = document.getElementById('waterpreviousreading');
    var wat_pres = document.getElementById('waterpresentreading');
    var wat = document.getElementById('water');
    var hou_rent = document.getElementById('house-rent');
    var inter = document.getElementById('internet');
    var gas = document.getElementById('gas');
    var tra = document.getElementById('trash');
    var total = document.getElementById('total');

    if (!ele_pres.value || !ele.value || !wat_pres || total.value === 0 || total.value === "P 0" || ele.value === "P 0" || wat.value === "P 0") {
        alert('Please fill all required fields!');
        return;
    }

    if (confirm("Are you sure you want to record this?")) {
        const formData = new FormData(document.getElementById('bills-form'));
        
        try {
            const response = await fetch('bills.php', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                alert("Recorded Successfully");
            } else {
                const errorText = await response.text();
                console.error("Error:", errorText);
                alert("There was an error recording the bill.");
            }
        } catch (error) {
            console.error("Fetch error:", error);
            alert("There was a network error.");
        }
    }
});


            </script>
            
</body>
</html>
