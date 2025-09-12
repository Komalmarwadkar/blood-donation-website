<?php
include("include/connection.php");

// Signup form processing
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = trim($_POST['name']);
    $blood_group= $_POST['blood_group'];
    $gender     = $_POST['gender'];
    $dob        = $_POST['dob'];
    $email      = trim($_POST['email']);
    $contact_no = trim($_POST['contact_no']);
    $city       = trim($_POST['city']);
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];
    $agree      = isset($_POST['agree']) ? 1 : 0;

    if (empty($name) || empty($blood_group) || empty($gender) || empty($dob) || empty($email) || empty($contact_no) || empty($city) || empty($password) || empty($confirm)) {
        $message = "⚠ All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "⚠ Invalid email format!";
    } elseif ($password !== $confirm) {
        $message = "⚠ Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $message = "⚠ Password must be at least 6 characters!";
    } elseif (strlen($contact_no) < 10) {
        $message = "⚠ Contact number must be at least 10 digits!";
    } elseif (!$agree) {
        $message = "⚠ You must agree to donate and show your info!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("INSERT INTO donor (name, blood_group, gender, dob, email, contact_no, city, password, agree_to_donate, show_info) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssii", $name, $blood_group, $gender, $dob, $email, $contact_no, $city, $hashed_password, $agree, $agree);

        if ($stmt->execute()) {
            $message = "✅ Registration Successful!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Donation Portal</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; background: #f9f9f9; }

        /* Navigation Bar (Only Donate Page Special Design) */
        .navbar {
            background: #fff;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar a {
            color: #e74c3c;
            margin: 0 20px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .navbar a:hover {
            background: #e74c3c;
            color: white;
        }

        /* Donate Header */
        .donate-header {
            background: #e74c3c;
            color: white;
            font-size: 28px;
            text-align: center;
            padding: 15px;
            font-weight: bold;
        }

        /* Signup Form */
        h2.signup-title {
            background: ;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            width: 200px;
            margin: 20px auto;
        }
        form {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        .error { color: red; margin-top: 5px; text-align: center; }
        .success { color: green; margin-top: 5px; text-align: center; }
        button {
            background: #e74c3c;
            color: #fff;
            padding: 10px;
            margin-top: 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button:hover { background: #e74c3c; }

        
    </style>
</head>
<body>

<!-- Navigation -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="donors.php">Donate Donor</a>
    <a href="search.php">Search</a>
    <a href="signin.php">Sign In</a>
    <a href="about.php">About Us</a>
</div>

<!-- Donate Header -->
<div class="donate-header">Donate</div>

<!-- Signup Section -->
<h2 class="signup-title">Signup</h2>

<?php if ($message != ""): ?>
    <p class="<?php echo (strpos($message, '✅') !== false) ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </p>
<?php endif; ?>

<form method="POST" action="">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Blood Group</label>
    <select name="blood_group" required>
        <option value="">-- Select Blood Group --</option>
        <option>A+</option><option>A-</option>
        <option>B+</option><option>B-</option>
        <option>AB+</option><option>AB-</option>
        <option>O+</option><option>O-</option>
    </select>

    <label>Gender</label>
    <input type="radio" name="gender" value="Male" required> Male
    <input type="radio" name="gender" value="Female"> Female
    <input type="radio" name="gender" value="Other"> Other

    <label>Date of Birth</label>
    <input type="date" name="dob" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Contact Number</label>
    <input type="text" name="contact_no" required>

    <label>City</label>
    <input type="text" name="city" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <label>
        <input type="checkbox" name="agree" required> I agree to donate and show my info
    </label>

    <button type="submit">Sign Up</button>
</form>



</body>
</html>