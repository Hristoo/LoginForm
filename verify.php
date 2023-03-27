<?php
session_start();

$base_url = htmlspecialchars($_SERVER["PHP_SELF"]);
$phone = $_SESSION["phone"];
$email = $_SESSION["email"];
$code = $_SESSION["code"];
$verified = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verified = verify($phone, $email, $code);
    $verified ? $err = "" : $err = "Please enter your verification code";
}

function verify($phone, $email, $code)
{
    if ($_POST["code"] != null && $_POST["code"] == $code) {
        if ($_POST["phone"] != null && $phone != $_POST["phone"]) {
            header("Location:  /test/verify.php?verify=phone");
            return false;
            ;
        }
        if ($_POST["email"] != null && $email != $_POST["email"]) {
            header("Location:  /test/verify.php?verify=mail");
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

if (!$verified) {
    echo "Code: " + $_SESSION["code"];
}

if ($verified) {
    ?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Verify your
            <?php echo $_POST["email"] != null ? "email" : "phone"; ?> address
        </title>
    </head>

    <body>
        <?php readfile('templates/header.html'); ?>
        <main>
            <h1>Verify your
                <?php echo $_POST["email"] != null ? "email" : "phone"; ?> address
            </h1>
            <div class="meter orange nostripes">
                <span style="width: 15%"></span>
            </div>
            <form action="<?php echo $base_url; ?>?verify=mail" method="post" class="login-form success-form">
                <img src="img/success.png" />
                <h5>Verification successful!</h5>
            </form>
        </main>
    </body>
    </html>
    <?php
} else {
    if ($_GET["verify"] == "mail") {
        ?>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>Verify your email address</title>
        </head>
        <body>
            <?php readfile('templates/header.html'); ?>
            <main>
                <h1>Verify your email address</h1>
                <div class="meter orange nostripes">
                    <span style="width: 15%"></span>
                </div>
                <form action="<?php echo $base_url; ?>?verify=mail" method="post" class="login-form">
                    <section class="top-section">
                        <a href="login.php">
                            <img src="img/arrow.png" />
                        </a>
                        <h5>A 6-digit code has been sent as a text messge to <span>
                                <?php echo $email ?>
                            </span></h5>
                    </section>
                    <div>
                        <label for="code">Verification code:</label>
                        <input <?php echo $err != null ? 'class="error"' : 'class=""'; ?> type="number" id="code" name="code"
                            placeholder="Enter 6-digit verification code here" required>
                        <span class="<?php echo $err != '' ? 'error' : ''; ?>"> <?php echo $err; ?></span>
                    </div>
                    <section>
                        <button type="submit">Continue</button>
                    </section>
                    <h5>Didn’t receive code? <a href="#">Resend code</a></h5>
                    <p>OR</p>
                    <a href="<?php echo $base_url; ?>?verify=phone">Send verification code on mobile no.</a>
                </form>
            </main>
        </body>
        </html>
        <?php
    }

    if ($_GET["verify"] == "phone") {
        ?>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style.css">
            <title>Verify your mobile number</title>
        </head>
        <body>
            <?php readfile('templates/header.html'); ?>
            <main>
                <h1>Verify your mobile number</h1>
                <div class="meter orange nostripes">
                    <span style="width: 15%"></span>
                </div>
                <form action="<?php echo $base_url; ?>?verify=phone" method="post" class="login-form">
                    <section class="top-section">
                        <a href="login.php">
                            <img src="img/arrow.png">
                        </a>
                        <h5>A 6-digit code has been sent as a text messge to <span>
                                <?php echo $phone ?>
                            </span></h5>
                    </section>
                    <div>
                        <label for="code">Verification code:</label>
                        <input <?php echo $err != null ? 'class="error"' : 'class=""'; ?> type="number" id="code" name="code"
                            placeholder="Enter 6-digit verification code here" required>
                        <span class="<?php echo $err != '' ? 'error' : ''; ?>"> <?php echo $err; ?></span>
                    </div>
                    <section>
                        <button type="submit">Continue</button>
                    </section>
                    <h5>Didn’t receive code? <a href="#">Resend code</a></h5>
                    <p>OR</p>
                    <a href="<?php echo $base_url; ?>?verify=mail">Send verification code on email</p>
                </form>
            </main>
        </body>
        </html>
        <?php
    }
}