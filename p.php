<?php
session_start();
require('./database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    // Prepare the SQL statement
    $sql = "INSERT INTO tenant (FullName, Email, Location, PhoneNumber, AccountCreationDate, Status, Password, tenantImage) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $connection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $fullname, $email, $address, $phoneNumber, $accountCreationDate, $status, $password, $profileImageData);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful!";
        } else {
            $_SESSION['badmessage'] = "Error during execution: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['badmessage'] = "SQL Error: " . $connection->error;
    }

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        
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

.alert-message {
    display: none;
    background-color: lightgreen;
    color: green;
    padding: 10px ;
    border: 1px solid lightgreen;
    border-radius: 5px;
    margin: 20px;
    text-align: center;
}

.alert-message-green {
    display: none;
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px ;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    margin: 20px;
    text-align: center;
}
    </style>
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
                unset($_SESSION['badmessage']);
            }
            ?>
        </p>
        <button id="ok-button">OK</button>
    </div>
</div>

        <div class="login-form-details-contents">
                    <p>Create Account</p>
                    <p>Fill out the form to create your account.</p>
                     <form id="signup-form" method="POST" action="" enctype="multipart/form-data">
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
                            <input type="password" class="signup-confirmpassword" name="confirmpassword" placeholder="Confirm your password" required>
                        </div>
                    </div>
                    <div class="signup-image-upload">
                        <label class="image-upload">
                            <input type="file" class="profile_picture" id="profile_picture" name="profile_image" accept="image/*" onchange="previewImage(event)">
                            <p>Upload an image</p>
                            <img id="imagePreview" src="" alt="Image Preview" style="display: none; width: 100%; height: auto; max-width: 150px; margin-top: 10px; border-radius: 10px; overflow: hidden;">
                        </label>
                    </div>
                    <div class="login-button">
                        <input type="submit" class="signup-btn" id="signup-button" value="Create Account">
                        <hr class="button-divider">
                        <input type="button" class="signup-create-btn" value="Back to Login" onclick="backToLogin()">
                    </div>
                </form>
            </div>



    <script>
            const addatinput = document.getElementById('emailadd');
            if (addatinput) {
                addatinput.addEventListener('input', function () {
                    if (this.value.includes('@') && !this.value.includes('@gmail.com')) {
                        const [addgmail] = this.value.split('@');
                        this.value = `${addgmail}@gmail.com`;
                    }
                });
            }
        

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

    </script>
</body>
</html>
