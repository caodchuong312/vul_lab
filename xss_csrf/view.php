<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>     
<title>View</title>
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
    if(!isset($_GET['id'])){
    die("no id");
    }
    $postId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {?>
    <div class="container mt-5">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><b><?=$row['title']?></b></p>
                    <p class="card-title"><?=$row['content']?></p>
                </div>
            </div>
        </div>

        <?php
        }
    }?>

    <div id="postid" class=""></div>
    <script>
          var urlParams = new URLSearchParams(window.location.search);
          var postId = urlParams.get("id");
          document.getElementById("postid").innerHTML = "Post id: " + postId;
    </script>   
    </div>
<?php
    $stmt = $conn->prepare("SELECT * FROM comments WHERE postid = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {?>
    <div class="container mt-5">
        <div class="mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><b><?=$row['authorname']?></b></p>
                    <p class="card-title"><?=$row['content']?></p>
                </div>
            </div>
        </div>
        
    </div><?php
        }
    }
?>



<div class="container mt-5">
 <h4>Add a comment:</h4>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="small mb-1" for="comment">Comment</label>
            <textarea  class="form-control" id="comment" name="comment" rows="4" placeholder="Enter your comment"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Submit Comment</button>
    </form>
</div>
<?php
if(isset($_POST['comment'])){
    $comment =$_POST['comment'];
    $stmt = $conn->prepare("insert into comments (authorname, postid, content) values (?, ?, ?)");
    $stmt->bind_param("sis", $_SESSION['username'], $postId, $comment);
    $stmt->execute();
    header("Location: /view.php?id=" . $postId);
    exit;
}
?>

</body>
</html>
