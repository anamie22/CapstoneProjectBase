<?php
session_start();

if(isset($_POST['login_btn'])) {
    if(isset($_POST['Login_email']) && isset($_POST['Login_password'])) {
        // Retrieve form data
        $email = $_POST['Login_email'];
        $password = $_POST['Login_password'];
        
        // Validate form data (you should perform more robust validation and sanitization)
        if(!empty($email) && !empty($password)) {
            // Check if the email and password match a valid user (replace with your authentication logic)
            if($email === "example@example.com" && $password === "password123") {
                // Set session variables to mark the user as logged in
                $_SESSION['logged_in'] = true;
                // Redirect to a dashboard or any other page after successful login
                header('Location: dashboard.php');
                exit();
            } else {
                // Invalid credentials
                $error_message = "Invalid email or password. Please try again.";
            }
        } else {
            // Missing email or password
            $error_message = "Please enter both email and password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
</head>
<body>

<?php if(isset($error_message)): ?>
<div><?php echo $error_message; ?></div>
<?php endif; ?>

<form id="loginForm" class="user" method="POST">
    <div class="form-group">
        <input type="email" name="Login_email" class="form-control form-control-user" id="exampleInputEmail"
            aria-describedby="emailHelp" placeholder="Enter Email Address...">
    </div>
    <div class="form-group">
        <input type="password" name="Login_password" class="form-control form-control-user" id="exampleInputPassword"
            placeholder="Password">
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="customCheck">
            <label class="custom-control-label" for="customCheck">Remember Me</label>
        </div>
    </div>
    <a href="#" id="loginLink" class="btn btn-primary btn-user btn-block">Login</a>
</form>

<script>
document.getElementById("loginLink").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default behavior of the anchor tag (i.e., navigating to another page)
    document.getElementById("loginForm").submit(); // Submit the form
});
</script>

</body>
</html>