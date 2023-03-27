<?php
session_start();

$phoneErr = "";
$emailErr = "";
$base_url = htmlspecialchars($_SERVER["PHP_SELF"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["phone"])) {
    $phoneErr = "Phone is required";
  } else {
    $phone = test_input($_POST["phone"]);
    $phoneErr = checkPhone($phone);
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    $emailErr = checkEmail($email);
  }

  if ($phoneErr == "" && $emailErr == "") {
    generateCode();
    saveData();
    header("Location:  /test/verify.php?verify=phone");
    exit;
  }
}

function checkPhone($phone)
{
  if (preg_match('/^[0-9]{10}+$/', $phone)) {
    return "";
  }
  return "Please enter your phone";
}

function checkEmail($email)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "Please enter your email id";
  }
  return "";
}

function generateCode()
{
  $_SESSION["code"] = rand(100000, 999999);
}

function saveData()
{
  $_SESSION["phone"] = $_POST["phone"];
  $_SESSION["email"] = $_POST["email"];
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Login</title>
</head>

<body>
  <?php readfile('templates/header.html'); ?>
  <main>
    <h1>Welcome to Website </h1>
    <div class="meter orange nostripes">
      <span style="width: 15%"></span>
    </div>
    <form action="<?php echo $base_url; ?>" method="post" class="login-form">
      <section class="top-section">
        <a href="index.php">
          <img src="img/arrow.png" />
        </a>
        <h5>Enter your mobile no. & email id</h5>
      </section>
      <img src="img/phone.png" />
      <div>
        <label for="mobile">Mobile no.:</label>
        <input <?php echo $phoneErr != null ? 'class="error"' : 'class=""'; ?> type="tel" id="phone" name="phone"
          placeholder="Enter your mobile no." required>
        <span <?php echo $phoneErr != null ? 'class="error"' : 'class=""'; ?>> <?php echo $phoneErr; ?></span>
      </div>
      <div>
        <label for="email">Email Address:</label>
        <input <?php echo $emailErr != null ? 'class="error"' : 'class=""'; ?> type="email" name="email" id="email"
          placeholder="Enter your email id" required>
        <span <?php echo $emailErr != null ? 'class="error"' : 'class=""'; ?>> <?php echo $emailErr; ?></span>
      </div>
      <section>
        <button type="submit">Continue</button>
      </section>
      <div>
        <p>By signing up, I agree to the <a href="#">Privacy Policy</a> & <a href="#">Terms of Use</a></p>
      </div>
    </form>
  </main>
</body>

</html>