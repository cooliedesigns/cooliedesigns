<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<link rel="stylesheet" href="css/styles.css">
<title>Sign In</title>
</head>
<body>

<div class="img">
      <div class="row">
        <img src="images/logo2.png" alt="logo">
      </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4 offset-md-4 form-div">
      <form action="signin.php" method="post">
        <h3 class="text-center">Sign In</h3>

        <?php if(count($errors) > 0): ?>
          <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <label for="username">Username or Email</label>
          <input id="username" type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
        </div><br>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control form-control-lg">
        </div><br>
        <div>
          <button type="submit" name="signin-btn" class="btn btn-primary btn-block btn-lg">Sign In</button>
        </div><br>
        <p>Not a member? <a href="signup.php">Sign Up</a></p>
      </form>
    </div>
  </div>
</div>
</body>
</html>