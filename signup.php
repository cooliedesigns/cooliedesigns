<?php require_once 'controllers/authController.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<title>Sign Up</title>
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
      <form action="signup.php" id="registerForm" method="post">
        <h3 class="text-center">Sign Up</h3>

        <?php if(count($errors) > 0): ?>
          <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        
        <div class="form-group">
          <label for="username">Username</label>
          <input id="username" type="text" name="username" value="<?php echo $username; ?>" class="form-control form-control-lg">
        </div><br>
        <div class="form-group">
          <label for="Email">Email</label>
          <input id="email" type="email" name="email" value="<?php echo $email; ?>" class="form-control form-control-lg">
        </div><br>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control form-control-lg">
        </div><br>
        <div class="form-group">
          <label for="passwordConf">Confirm Password</label>
          <input id="passwordConf" type="password" name="passwordConf" class="form-control form-control-lg">
        </div><br>
        <div>
          <button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>
        </div><br>
        <p>Already a member? <a href="signin.php">Sign In</a></p>
      </form>
    </div>
  </div>
</div>
</body>
</html>