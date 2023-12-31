<?php require "../config/connection.php"; 
session_start();
define("FILEPATH", "http://localhost/pos1");?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <link rel="stylesheet" href="Style/style2.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>

    <div class="modal fade" id="ShowModal1" tabindex="-1" aria-labelledby="ShowModal1" aria-hidden="true" style="display: none;">

        

        <div class="h1-text">
            <h4>Kindly ask our employee about this, <br> Thank you.</h4>
        </div>

        <button class="btn">I understood</button>

        
    </div>

    <div class="wrapper">

        <form action="<?php echo FILEPATH;?>/auth/recovery.php" method="POST">

            <h1>Login</h1>

            <div class="input-box">
                <input type="text" name="email" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Recovery Code" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <div class="remember-forgot">
                <a href="login.php">Back to Sign in</a>
            </div>

            <input type="submit" class="btn" name="kiosk-signin-button" value="Login">

            <div class="register-link">
                <p>Don't have an account? <a href="#" id="registerLink">Register</a></p>
            </div>

            <div class="continue">
                <a href="index.php">Continue without an account</a>
            </div>
            
        </form>

    </div>

    <script>
        var modal = document.getElementById('ShowModal1');
        var registerLink = document.getElementById('registerLink');
        var understandButton = document.querySelector('.modal .btn');
    
        registerLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            modal.style.display = 'block'; // Show the modal when Register is clicked
        });
    
        // Hide the modal when clicking outside of it or when clicking the 'X' button
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    
        // Close the modal when "I understand" button is clicked
        understandButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    </script>
</body>
</html>
