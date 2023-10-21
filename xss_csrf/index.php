<?php
session_start();
include_once "dbconnect.php";
if(!isset($_SESSION['username'])){
    header("location:login.php");
    exit();
}
?>
<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Home</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 </head>
 <body>
    <?php
        include 'nav.php';
    ?>
     <div class="container ms-5 me-1">
         <form action="" method="get" class="mt-5 mb-5">
             <div class="input-group">
                 <input type="text" class="form-control" id="search" name="search" placeholder="Enter your search term"  >
                 <div class="input-group-append">
                     <button class="btn btn-primary" type="submit">Search</button>
                 </div>
             </div>
         </form>
       
     <div class="row">
         <?php
            $search = isset($_GET['search']) ? $_GET['search'] : "";
            if($search!= ""){
                echo "<h3 class='result'>search for '".$search."'</h3>";
            }
            $search = "%" . $search . "%";
            $sql = "SELECT * FROM posts WHERE title LIKE ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($rows = $result->fetch_assoc()) { ?>
             <div class="mb-3">
                 <div class="card">
                     <div class="card-body">
                         <h5 class="card-title"><a href="/view.php?id=<?=$rows['id']?>" ><?php echo $rows['title']; ?></a></h5>
                         <p class="card-text">authordId: <?php echo $rows['authorid']; ?></p>
                     </div>
                 </div>
             </div>
         <?php
            }
            ?>
     </div>
	</div>
    <!-- <script>
            document.getElementById("search").setAttribute("value", "<?=$search?>");
    </script> -->
 </body>
 </html>
