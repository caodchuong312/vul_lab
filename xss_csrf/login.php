<?php
    session_start();
    include_once 'dbconnect.php';
    if(isset($_SESSION['username']))
    {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
 <div class="container mt-5">
        <h3 class="text-center mt-10">Login Form</h3>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="d-flex flex-column align-items-center">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control w-300" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control w-300" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <br>
            <p><a class="link-opacity-75-hover" href="/register.php">Register</a></p>
            <br>
        </form>
        <?php
  if(isset($_POST['username']) && isset($_POST['password'])){
      $username = $_POST['username'];
      $password = hash("sha512", $_POST['password']);
      if($username === "" || $password === "")
       {
           echo "<center>Please fullfill your information</center>";
       }
       else{
	
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) != 0) {
         $_SESSION['username'] = $username;
	    header('Location: index.php');
        exit();
    } else {
       	echo "<center class='alert alert-danger'>Wrong username or password</center>";
    }
        mysqli_close($conn);
    }

}
?>
    </div>
</body>
</html>


