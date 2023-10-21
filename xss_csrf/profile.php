<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <title>Profile</title>
</head>
<body>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("location:login.php");
        exit();
    }
    include_once 'nav.php';
    include_once 'dbconnect.php';
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result){
        $user = mysqli_fetch_assoc($result);
        $csrfToken = bin2hex(random_bytes(32)); 
        $_SESSION['csrf_token'] = $csrfToken;
?>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header">Welcome, <?=$user['username']?></div>
                <div class="card-body">
                    <h5 class="card-title">Email: <?=$user['email']?></h5>
                    <h5 class="card-text">Profile: <i><?=$user['profile']?></i></h5>
                </div>
            </div>
        </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Change Email</div>
                    <div class="card-body">
                        <form method="post" action="csrfcheck.php">
                            <div class="mb-3">
                                <label for="newEmail" class="form-label">New Email</label>
                                <input type="email" class="form-control" id="newEmail" name="newEmail" value="<?=$user['email']?>">
                            </div>
                            <input require type="hidden" name="csrf_token" value="<?=$csrfToken?>">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Change Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    } else {
        echo 'Error fetching user data';
    }
?>
</body>
</html>
