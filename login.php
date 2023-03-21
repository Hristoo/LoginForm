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
    if (filter_var($phone, FILTER_VALIDATE_INT)) {
      $phoneErr = "Invalid phone";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email ";
    }
  }
  
  if($phoneErr == "" && $emailErr == ""){
    generateCode();
    saveData();
    header("Location:  /test/verify.php?verify=phone");
    exit;
  }
}

function generateCode(){
    $_SESSION["code"] = rand(100000,999999);
}

function saveData(){
    $_SESSION["phone"] = $_POST["phone"];
    $_SESSION["email"] = $_POST["email"];
}

function test_input($data) {
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
<main>
    <h1>Welcome to Website </h1>
    <form action="<?php echo $base_url;?>" method="post">
        <p>Enter your mobile no. & email id</p>
        <div>
            <label for="mobile">Mobile no.:</label>
            <input type="tel" id="phone" name="phone" required>
            <span class="error"> <?php echo $phoneErr;?></span>
        </div>
        <div>
            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required>
            <span class="error"> <?php echo $emailErr;?></span>
        </div>
        <section>
            <button type="submit">Continue</button>
        </section>
    </form>
</main>
</body>
</html>
