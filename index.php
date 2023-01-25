<?php
  require_once 'controllers/authController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="styles.css">
<title>Homepage</title>
<style>
  img {
  display: block;
  margin-top: 100px;
  margin-left: auto;
  margin-right: auto;
}
</style>
</head>
<body>
<div class="img">
      <div class="row">
        <img src="images/logo2.png" alt="logo">
      </div>
</div>
<div class="container">
  <div class="row">
    <div class="col-md4 offset-md-4 form-div login">

    <?php if (isset($_SESSION['verified'])): ?>    
      <div class="alert <?php echo $_SESSION['alert-class']; ?>">
        <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
          unset($_SESSION['alert alert-class']);
        ?>
      </div>
    <?php endif; ?>

      <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

      <a href="signin.php" class="logout">Sign In</a>

      <?php if (!$_SESSION['verified']): ?>
      <div class="alert alert-warning">
        You need to verify your account.
        Sign in to your email account and click on the
        verification link we just emailed you at
        <strong><?php echo $_SESSION['email']; ?></strong>
      </div>
      
      <?php endif; ?>

      <?php if ($_SESSION['verified']): ?>
      <button class="btn btn-block btn-lg btn-primary">I am verified!</button>
      <?php endif; ?>

    </div>
  </div>
</div>
  
</body>
</html>