<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Bento Grid Layout</title>
    <style>
       *, *::before, *::after {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'SF Pro Display', sans-serif;
            user-select: none;
       }

       img {
max-width: 80%;
display: block;
}

body, html {
    height: 100%;
        width: 100%;
        overflow: auto; 
        background-color: #dee3e9;
        color: black;
       }

    .bento-grid-main{
        padding: 1rem;
    }

       .bento-grid-main{
        display: grid;
        gap: 1rem;
        grid-template-columns: 1fr 2fr 1fr 1fr;
        grid-template-rows: 1fr 1fr 1fr;
        grid-template-areas: 
        'grid1 grid2 grid3 grid4'
        'grid1 grid5 grid5 grid5'
        'grid1 grid6 grid6 grid6';
        ;
        height: 100vh;
        margin-inline: auto;
    }

    .grid-one{grid-area: grid1;}
    .grid-two{grid-area: grid2;}
    .grid-three{grid-area: grid3;}
    .grid-four{grid-area: grid4;}
    .grid-five{grid-area: grid5;}
    .grid-six{grid-area: grid6;}
    
       .grid-item{
        padding: 1rem;
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
    }

       .grid-one, .grid-two, .grid-four, .grid-five, .grid-six{
        background-color: white;
        border-radius: 20px;
       }

       .grid-three{
        background-color: #423ed9;
        border-radius: 20px;
       }

       /*grid one*/
       .grid-one {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.grid-one-inner {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 0.4fr 3fr 0.4fr;
    gap: 1rem;
    height: 100%;
}

       .one-header{
        font-size: 12px;
        font-weight: 500;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
       }

       .one-header img{
        width: 45px;
        height: 45px;
       }

       .one-body{
        display: flex;
        flex-direction: column;
       }

       .one-body a {
    text-decoration: none;
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

       .sidenav-menus{
        display: flex;
        flex-direction: row;
        border-radius: 12px;
        padding: 10px 0 10px 10px;
        transition: all 0.3s cubic-bezier(0.25, 0.1, 0.25, 1.0);
       }

       .sidenav-menus p {
            margin-left: 10px;
            text-decoration: none;
            color: black;
        }

        .sidenav-menus p:hover {
            color: white;
        }

       .sidenav-menus a{
        text-decoration: none;
       }

       .sidenav-menus:hover{
        text-decoration: none;
        background-color: #f27e23;
    }

    .submenu {
        width: 200px;
        display: none;
        list-style-type: none;
        padding: 10px;
        position: absolute;  
        top: 147px;
        left: 31px;
        background-color: #fff;
        box-shadow: 0 0 5px #f27e23;
        border-radius: 15px;
        z-index: 1000;
    }

    .submenu li {
        list-style-type: none;
    }

.submenu li a {
    color: black;
    text-decoration: none;
    display: block; 
    padding: 10px;
}

.submenu li a:hover {
    color: #f27e23; 
    text-decoration: none;
    background-color: #f0f0f0;
    border-radius: 5px; 
}
       

       .one-footer{
        font-size: 12px;
        font-weight: 500;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 10px;
       }

       .one-footer img{
        width: 40px;
        height: 40px;
       }
       /*grid one*/

       
    </style>
</head>
<body>

        <div class="submenu">
            <ul>
                <li style="font-size: 11px; font-weight: 600;" readonly>Dashboard</li>
                <li><a href="subpage1.php">Subpage 1</a></li>
                <li><a href="subpage2.php">Subpage 2</a></li>
            </ul>
        </div>
            

    <main class="bento-grid-main">
        <div class="grid-item grid-one">
            <div class="grid-one-inner">
                <div class="one-header">
                    <img src="assets/logo2.png" alt="">
                    <p>Coldovero Smart Billing System</p>
                </div>
    
                <div class="one-body">
                    <a href="dashboard.php">
                        <div class="sidenav-menus dashboard" id="dashboard">
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

                    <a href="loginpage.php">
                        <div class="sidenav-menus">
                            <span class="material-icons">logout</span>
                            <p>Logout</p>
                        </div>
                    </a>
                </div>            
    
                <div class="one-footer">
                    <img src="assets/logo2.png" alt="">
                    <p>Coldovero Smart Billing System</p>
                </div>            
            </div>
        </div>

        <div class="grid-item grid-two">
            <h4>hello</h4>
        </div>
        
        <div class="grid-item grid-three">
            <h4>Calculator</h4>
        </div>
        
        <div class="grid-item grid-four">
            <h4>Converter</h4>
        </div>
        
        <div class="grid-item grid-five">
            <h4>Due</h4>
        </div>
        
        <div class="grid-item grid-six">
            <h4>Transaction History</h4>
        </div>
    
    </main>

    <script>
 document.addEventListener('DOMContentLoaded', function(){
    const dashboardMenu = document.getElementById('dashboard');
    const subMenu = document.querySelector('.submenu');
    const dashboardStyle = document.querySelector('.dashboard');
    const dashboardText = dashboardStyle.querySelector('p');
    const dashboardSpan = dashboardStyle.querySelector('span');
    
    let timeout;

    dashboardMenu.addEventListener('mouseenter', function(){
        clearTimeout(timeout);
        subMenu.style.display = 'block';
        dashboardStyle.style.backgroundColor = '#f27e23'; 
        dashboardSpan.style.color = 'white'; 
        dashboardText.style.color = 'white'; 

    });

    dashboardMenu.addEventListener('mouseleave', function(){
        timeout = setTimeout(() => {
            subMenu.style.display = 'none';
            dashboardStyle.style.backgroundColor = 'white'; 
        dashboardSpan.style.color = 'black'; 
        dashboardText.style.color = 'black'; 
        }, 200); // Delay before hiding
    });

    subMenu.addEventListener('mouseenter', function() {
        clearTimeout(timeout);
    });

    subMenu.addEventListener('mouseleave', function() {
        subMenu.style.display = 'none';
        dashboardStyle.style.backgroundColor = 'white'; 
        dashboardSpan.style.color = 'black'; 
        dashboardText.style.color = 'black'; 
    });
});
    </script>
</body>
</html>