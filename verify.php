<?php
session_start();

$base_url = htmlspecialchars($_SERVER["PHP_SELF"]);
$phone = $_SESSION["phone"];
$email = $_SESSION["email"];
$code = $_SESSION["code"];
$verified = false;


$verified = verify($phone, $email, $code);

var_dump($_SESSION["code"]);
if ($verified) {
       ?>
   <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Verify your <?php echo $_POST["email"] != null ? "email" : "phone"; ?> address</title>
    </head>
    <body>
    <main>
        <h1>Verify your <?php echo $_POST["email"] != null ? "email" : "phone"; ?> address</h1>
        <p>Verification successful!</p>
    </main>
    </body>
    </html>
<?php
}else{
    if($_GET["verify"] == "mail"){
       ?>
   <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Verify your email address</title>
    </head>
    <body>
    <main>
        <h1>Verify your email address</h1>
        <form action="<?php echo $base_url;?>?verify=mail" method="post">
            <p>A 6-digit code has been sent as a text messge to <?php echo $email ?></p>
            <div>
                <label for="code">Verification code:</label>
                <input type="number" id="code" name="code" required>
                <input type="email" id="email" name="email" value=<?php echo $email?> class="hidden">
                <span class="error"> <?php echo $err;?></span>
            </div>
            <section>
                <button type="submit">Continue</button>
            </section>
            <a href="<?php echo $base_url;?>?verify=phone">Send verification code on mobile no.</a>
        </form>
    </main>
    </body>
    </html>
<?php
} 
if($_GET["verify"] == "phone"){
    ?>
   <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Verify your mobile number</title>
    </head>
    <body>
    <main>
        <h1>Verify your mobile number</h1>
        <form action="<?php echo $base_url;?>?verify=phone" method="post">
            <p>A 6-digit code has been sent as a text messge to <?php echo $phone ?></p>
            <div>
                <label for="code">Verification code:</label>
                <input type="number" id="code" name="code" minlength="6"  required>
                <input type="number" id="phone" name="phone" value=<?php echo $phone?> class="hidden">
                <span class="error"> <?php echo $err;?></span>
            </div>
            <section>
                <button type="submit">Continue</button>
            </section>
            <a href="<?php echo $base_url;?>?verify=mail">Send verification code on email</p>
        </form>
    </main>
    </body>
    </html>
<?php
} 
}

function verify($phone, $email, $code){
    if($_POST["code"] != null && $_POST["code"] == $code){
        if($_POST["phone"] != null && $phone != $_POST["phone"]){
            header("Location:  /test/verify.php?verify=phone");
            return false;;
        }
        if($_POST["email"] != null && $email != $_POST["email"]){
            header("Location:  /test/verify.php?verify=mail");
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}
