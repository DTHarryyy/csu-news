
<?php
    session_start();
    include('./database/database.php');

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users_account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {   
            $row = $res->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];

                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Incorrect credentials');</script>";
            }
        } else {
            echo "<script>alert('Incorrect email');</script>";
        }

        $stmt->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="./assets/css/nav.css">
  <link rel="stylesheet" href="./assets/css/general.css">
  <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="./assets/css/form.css">
  <title>CSUNEWS login</title>
</head>
<body>
  <?php include('./includes/nav.php') ?>

  <main class="mainForm">
    <section class="login-container" aria-label="Login form">
      <h2>Sign in to your account</h2>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" class="form" id="loginForm">
        <label for="email">Email address</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="you@example.com"
          required
          autocomplete="email"
          aria-required="true"
        />
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          required
          autocomplete="current-password"
          aria-required="true"
        />
        <button type="submit" aria-label="Sign in">Sign In</button>
      </form>
      <div class="footer-links">
        <a href="#" >Forgot password?</a> 
        <a href="./register.php">Create an account</a>
      </div>
    </section>
  </main>
  <?php include('./includes/footer.php')?>
</body>
</html>




