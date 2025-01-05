<?php
session_start();
require('./database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
    $password = password_hash(mysqli_real_escape_string($connection, $_POST['password']), PASSWORD_DEFAULT);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $address = 'Unset';
    
    // Default values
    $phoneNumber = 'Unset'; 
    $accountCreationDate = date('Y-m-d'); 
    $status = 'Pending'; 
    $profileImageData = null;

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $profileImageData = file_get_contents($_FILES['profile_image']['tmp_name']);
    }

   
        $sql = "INSERT INTO tenant (FullName, Email, Location, PhoneNumber, AccountCreationDate, Status, Password, tenantImage) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $connection->prepare($sql);

        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssssssss", $fullname, $email, $address, $phoneNumber, $accountCreationDate, $status, $password, $profileImageData);

            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful!";
            } else {
                $_SESSION['badmessage'] = "Error during execution: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $_SESSION['badmessage'] = "SQL Error: " . $connection->error;
        }

    // Redirect to the same page to display messages
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coldovero Billing System</title>
    <link rel="stylesheet" href="./styles/loginstyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div id="custom-alert-modal" class="modal">
    <div class="modal-content">
        <span class="close-button" id="close-modal">&times;</span>
        <h2>Alert</h2>
        <p id="modal-message">
            <?php
            if (!empty($_SESSION['message'])) {
                echo htmlspecialchars($_SESSION['message']);
                unset($_SESSION['message']); // Clear message after displaying
            } elseif (!empty($_SESSION['badmessage'])) {
                echo htmlspecialchars($_SESSION['badmessage']);
                unset($_SESSION['badmessage']); // Clear bad message after displaying
            }
            ?>
        </p>
        <button class="ok-button" id="ok-button">OK</button>
    </div>
</div>

<p id="modal-message">
    <?php
    if (!empty($_SESSION['badmessage'])) {
        echo htmlspecialchars($_SESSION['badmessage']);
        unset($_SESSION['badmessage']); // Clear bad message after displaying
    }
    ?>
</p>


    <div class="main-login">
        <div class="login-form" id="loginForm">
            <div class="login-blue-main">
                <div class="login-blue">
                    <img src="assets/logo.png" class="csbs-logo" class="logo-billing" alt="Logo">
                    <p class="csbs">CSBS is a Smart Billing System</p>
                    <div class="meter">
                        <img src="assets/meter.png" class="icon-meter" alt="Logo">
                        <div class="lever-container">
                            <div class="lever" id="lever"></div>
                        </div>
                        <video class="electric-video" id="electricVideo" autoplay loop muted>
                            <source src="assets/overlayelectric.mp4" type="video/mp4">
                        </video>
                        <p>Simplifying Billing for Landlords and Property Managers, One Click at a Time - Ensuring Accuracy and Efficiency in Every Calculation.</p>
                    </div>
                    
                    <div class="blocks">
                        <div class="first-block">
                            <img src="assets/paper.png" alt="Logo">
                            <p>Introducing an automated calculation system for landlords and property managers, simplifying tenant expense management with ease.</p>
                            <input type="button" value="Learn more">
                        </div>
                        <div class="second-block">
                            <img src="assets/deadline.png" alt="Logo">
                            <p>Introducing an automated calculation system for landlords and property managers, simplifying tenant expense management with ease.</p>
                            <input type="button" value="Learn more">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="login-form-details" id="loginFormDetails">
            <div class="login-form-details-contents">
                <p>Admin Login</p>
                <p>Enter your account details to login.</p>
                <form class="form-login" id="login-form" method="post" action="login-handler.php">
                    <div class="login-inputs">
                        <label>Username</label>
                        <input type="textbox" class="username-input" id="username" name="username" placeholder="Enter your email">
                    </div>
                    <div class="login-inputs">
                        <label>Password</label>
                        <input type="password" id="passwordInput" name="passwordInput" class="password-input" placeholder="Enter your password">
                    </div>
                    <div class="blw-inputs">
                        <label><input type="checkbox" id="showPassCheck" onclick="myFunction()">Show password</label>
                        <p>Recover my account</p>
                    </div>
                    <div class="login-button">
                    <input type="submit" id="loginButton" class="login-btn" value="Login">
                        <hr class="button-divider">
                        <input type="button" class="create-btn" value="Create Account" onclick="toggleForm()">
                    </div>
                    </form>
        <div id="error-message" style="color: red;"></div>

        <!-- Loader -->
        <div class="loader" id="loader">
            <div class="circle one"></div>
            <div class="circle two"></div>
            <div class="circle three"></div>
        </div>
            </div>
        </div>
    </div>

    <script>


        document.addEventListener('DOMContentLoaded', function () {
            const addatinput = document.getElementById('username');
            addatinput.addEventListener('input', function () {
                if (this.value.includes('@') && !this.value.includes('@gmail.com')) {
                    const [addgmail] = this.value.split('@');
                    this.value = `${addgmail}@gmail.com`;
                }
            });
        });

        function toggleForm() {
            const loginForm = document.getElementById("loginForm");
            const loginFormDetails = document.getElementById("loginFormDetails");

            loginForm.style.transform = 'translateX(100%)';
            loginFormDetails.style.transform = 'translateX(-100%)';

            loginFormDetails.innerHTML = `
                <div class="login-form-details-contents">
                    <p>Create Account</p>
                    <p>Fill out the form to create your account.</p>
                     <form id="signup-form" method="POST" action="loginpage.php" enctype="multipart/form-data">
                    <div class="signup-main-textbox">
                        <div class="signup-inputs">
                            <label>Fullname</label>
                            <input type="text" class="signup-fullname" id="fullname" name="fullname" placeholder="Enter your fullname" required>
                        </div>
                        <div class="signup-inputs">
                            <label class="class-pass">Password</label>
                            <input type="password" class="signup-password" id="password" name="password" placeholder="Choose a password" required>
                        </div>
                    </div>
                    <div class="signup-main-textbox">
                        <div class="signup-inputs">
                            <label>Email Address</label>
                            <input type="email" class="signup-emailaddress" name="email" id="emailadd" placeholder="Enter your email address" required>
                        </div>
                        <div class="signup-inputs">
                            <label class="class-confpass">Confirm Password</label>
                            <input type="password" class="signup-confirmpassword" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" required>
                        </div>
                    </div>
                    <div class="signup-image-upload">
                        <label class="image-upload">
                            <input type="file" class="profile_picture" id="profile_picture" name="profile_image" accept="image/*" onchange="previewImage(event)">
                          
                        </label>
                    </div>
                    <div class="login-button">
                        <input type="submit" class="signup-btn" id="signup-button" value="Create Account">
                        <hr class="button-divider">
                        <input type="button" class="signup-create-btn" value="Back to Login" onclick="backToLogin()">
                    </div>
                </form>
                </div>
            `;

            const addatinput = document.getElementById('emailadd');
            if (addatinput) {
                addatinput.addEventListener('input', function () {
                    if (this.value.includes('@') && !this.value.includes('@gmail.com')) {
                        const [addgmail] = this.value.split('@');
                        this.value = `${addgmail}@gmail.com`;
                    }
                });
            }

            document.getElementById('signup-form').addEventListener('submit', function(event){
    var reqFields = [
        document.getElementById('fullname').value,
        document.getElementById('emailadd').value,
        document.getElementById('password').value,
        document.getElementById('confirmpassword').value
    ];

    if(reqFields.some(inputs => inputs.trim() === '')){
        alert('Please fill in all required fields');
        event.preventDefault();
        return;
    }

    const pass = document.getElementById('password').value;
    const confpass = document.getElementById('confirmpassword').value;

    if(pass !== confpass){
        document.getElementById('password').style.borderColor = 'red';
        document.getElementById('confirmpassword').style.borderColor = 'red';

        

        document.getElementById('modal-message').innerText = "Passwords do not match!";
        document.getElementById('custom-alert-modal').style.display = 'block';
        event.preventDefault();
        return;
    } else {
        document.getElementById('password').style.borderColor = '';
        document.getElementById('confirmpassword').style.borderColor = '';
    }

    if(confirm("Are you sure you want to enroll?")){
        document.getElementById('signup-form').submit();
    }
});
        }

        function backToLogin() {
            const loginForm = document.getElementById("loginForm");
            const loginFormDetails = document.getElementById("loginFormDetails");

            loginForm.style.transform = 'translateX(0)';
            loginFormDetails.style.transform = 'translateX(0)';

            loginFormDetails.innerHTML = `
                <div class="login-form-details-contents">
                    <p>Admin Login</p>
                    <p>Enter your account details to login.</p>
                    <div class="login-inputs">
                        <label>Username</label>
                        <input type="textbox" class="username-input" placeholder="Enter your email">
                    </div>
                    <div class="login-inputs">
                        <label>Password</label>
                        <input type="password" id="passwordInput" class="password-input" placeholder="Enter your password">
                    </div>
                    <div class="blw-inputs">
                        <label><input type="checkbox" id="showPassCheck" onclick="myFunction()">Show password</label>
                        <p>Recover my account</p>
                    </div>
                    <div class="login-button">
                        <input type="button" class="login-btn" value="Login">
                        <hr class="button-divider">
                        <input type="button" class="create-btn" value="Create Account" onclick="toggleForm()">
                    </div>
                </div>
            `;
        }

        

        document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('custom-alert-modal');
    const closeButton = document.getElementById('close-modal');
    const okButton = document.getElementById('ok-button');

    // Close modal when close button is clicked
    closeButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Close modal when OK button is clicked
    okButton.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Show modal if there is a message
    if (document.getElementById('modal-message').innerText.trim() !== "") {
        modal.style.display = 'block';
    }

    document.getElementById('signup-form').addEventListener('submit', function(event){
        var reqFields = [
            document.getElementById('fullname').value,
            document.getElementById('emailadd').value,
            document.getElementById('password').value,
            document.getElementById('confirmpassword').value
        ];

        if(reqFields.some(inputs => inputs.trim() === '')){
            alert('Please fill in all required fields');
            event.preventDefault();
            return;
        }

        const pass = document.getElementById('password').value;
        const confpass = document.getElementById('confirmpassword').value;

        if(pass !== confpass){
            document.getElementById('password').style.borderColor = 'red';
            document.getElementById('confirmpassword').style.borderColor = 'red';
            document.getElementById('modal-message').innerText = "Passwords do not match!";
            modal.style.display = 'block'; // Show the modal
            event.preventDefault(); // Prevent form submission
            return;
        } else {
            document.getElementById('password').style.borderColor = '';
            document.getElementById('confirmpassword').style.borderColor = '';
        }

        if(confirm("Are you sure you want to enroll?")){
            document.getElementById('signup-form').submit();
        }
    });
});


        const lever = document.getElementById('lever');
        const electricVideo = document.getElementById('electricVideo');

        lever.addEventListener('click', () => {
            lever.classList.toggle('pulled');

            if (lever.classList.contains('pulled')) {
                electricVideo.style.opacity = '1';
            } else {
                electricVideo.style.opacity = '0';
            }
        });

        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        }


        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('custom-alert-modal');
            const closeButton = document.getElementById('close-modal');
            const okButton = document.getElementById('ok-button');

            // Show modal if there is a message
            if (document.getElementById('modal-message').innerText.trim() !== "") {
                modal.style.display = 'block';
            }

            closeButton.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            okButton.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        });

        function myFunction() {
            var x = document.getElementById("passwordInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }


    </script>
</body>
</html>