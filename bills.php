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
            transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1.0);
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
    max-height: 300px; 
    padding: 15px; 
    overflow: auto; 
}

.box2 {
    grid-column: 2; 
    grid-row: 1;    
    background-color: #423ed9;
    color: white;
}

.box3 {
    grid-column: 3; 
    grid-row: 1;    
    display: flex;
    flex-direction: column;
    gap: 20px;
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

.calcu-row-button{
    height: 25px;
    width: 31.5px;
    margin-bottom: 5px;
    border-radius: 5px;
    border: none;
    transition: all 0.2s cubic-bezier(0.25, 0.1, 0.25, 1.0);
    cursor: pointer;
}

.calcu-row-button:hover{
    box-shadow: 5px 5 5px rgba(31, 31, 31, 0.7);
    background-color: #ffa124;
}

.calcu-row-text{
    height: 25px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: none;
    padding-left: 5px;
}

.convert-row-button{
    height: 35px;
    width: 50px;     
}

.convert-row-text{
    height: 35px;
    padding-left: 5px;
}


.convert-center{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 5px;
}

.bill-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.bill-item label {
    font-size: 14px; 
    color: #555;
    flex: 1;
}

.bill-item input {
    width: 100px; 
    padding: 5px; 
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px; 
    color: #333;
}

.total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px; 
    border-top: 2px solid #ddd;
    padding-top: 10px;
}

.total label {
    font-size: 16px; 
    font-weight: bold;
    color: #000;
}

.total input {
    width: 100px;
    padding: 5px; 
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    color: #333;
    background-color: #f9f9f9; 
}

.calculate-button {
    margin-top: 10px;
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; 
}

.calculate-button:hover {
    background-color: #0056b3; 
}

@keyframes pop {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

.pop {
    animation: pop 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0);
}

.prevpres{
    display: flex;
    flex-direction: row;
}

.prevpresmain{
    display: flex;
    flex-direction: column;
}

@keyframes arrowbounce{
0%{
    transform: translateX(0);
}

50%{
    transform: translateX(5px);
}

100%{
    transform: translateX(0);
}
}

.arrowAnnimate {
    animation: arrowbounce 0.5s cubic-bezier(0.25, 0.1, 0.25, 1.0);
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

<div class="sidenav-menus">
    <span class="material-icons">logout</span>
    <p>Logout</p>
</div>
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
                    <label for="electricity">Electricity</label>

                    <div class="prevpresmain">
                    <div class="prevpres">
                        <p>Previous</p>
                        <input type="number" id="previousreading" style="width: 50px;" class="value" value="123" readonly/>
                    </div>

                    <div class="prevpres">
                        <p>Present</p>
                        <input type="number" id="presentreading" style="width: 50px;" class="value" value=""/>
                    </div>
                    </div>

                    <span class="material-icons arrow_forward">arrow_forward</span>

                    <input type="text" id="firstcalculation" class="value" value="" readonly/>

                    <p>=</p>

                    <input type="text" id="electricity" class="value" value="" readonly/>
                </div>
                <div class="bill-item">
                    <label for="Water">Water</label>

                    <div class="prevpresmain">
                    <div class="prevpres">
                        <p>Previous</p>
                        <input type="number" id="waterpreviousreading" style="width: 50px;" class="value" value="123" readonly/>
                    </div>

                    <div class="prevpres">
                        <p>Present</p>
                        <input type="number" id="waterpresentreading" style="width: 50px;" class="value" value=""/>
                    </div>
                    </div>

                    <span class="material-icons arrow_forward_water">arrow_forward</span>

                    <input type="text" id="waterfirstcalculation" class="value" value="" readonly/>

                    <p>=</p>

                    <input type="text" id="water" class="value" value="" readonly/>
                </div>
                <div class="bill-item">
                    <label for="house-rent">House Rent</label>
                    <input type="text" id="house-rent" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="internet">Internet</label>
                    <input type="text" id="internet" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="gas">Gas</label>
                    <input type="text" id="gas" class="value" value="" />
                </div>
                <div class="bill-item">
                    <label for="trash">Trash Collection</label>
                    <input type="text" id="trash" class="value" value="" />
                </div>
                <div class="total">
                    <label for="total">Total:</label>
                    <input type="text" id="total" class="value" value="" readonly />
                </div>
            </div>

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


            </script>
            
</body>
</html>
