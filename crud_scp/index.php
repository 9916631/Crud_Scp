<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>SCP-Foundation</title>
</head>

<body class="container bg-secondary">  

  <?php include 'config/connection.php' ?>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img src="images/scp_logo.svg" class="img-fluid" style="width:50px; height: auto;">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>

        <?php foreach ($record as $menu) : ?>

          <li class="nav-item">
            <a class="nav-link" href="index.php?item='<?php echo $menu['item']; ?>'"><?php echo $menu['item']; ?></a>
          </li>

        <?php endforeach; ?>
        <li class="nav-item active">
          <a class="nav-link" href="create.php">Create new SCP-Foundation subject</a>
        </li>
      </ul>
    </div>
  </nav>

  <?php

  if (isset($_GET['item'])) //if button was clicked then do all this
  {
    //select record from database
    $scp = trim($_GET['item'], "'");

    $item = "select * from subject where item = '$scp'";
    $subject = $conn->prepare($item);
    $subject->execute();

    $display = $subject->fetch(PDO::FETCH_ASSOC); //associate array

    $id = $display['id'];
    echo "
        <div class='card mt-3'>
        <h1 class='card-header text-center'>Subject: {$display['item']} - {$display['class']}</h1>
        <div class='card-body'>
        <h5 class='card-title'>Containment</h5>
        <p class='card-text'>{$display['containment']}</p>
        <p><img class='img-fluid' src='{$display['image']}' style='width: 75% height: auto; box-shadow: 3px, 3px, 3px; margin-left: auto; margin-right:auto; display: block;'></p>
        <h5 class='card-title'>Description</h5>
        <p class='card-text'>{$display['description']}</p>
        <a href='update.php?id={$id}' class='btn btn-warning'>Update record</a>
        </div>
        </div>
        
        ";
  } 
  else 
  {
    echo '
        <div class="card mt-3">
        <h1 class="card-header">
            SCP-Foundation
            </h1>
            <div class="card-body">
            <h5 class="card-title">Welcome to the SCP-Foundation</h5>
            <p class="card-text">Please use the menu above to Create, Read, Update or delete the SCP-Foundation subjects.</p>            
            </div>
        </div>
        
        ';
  }

  ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>