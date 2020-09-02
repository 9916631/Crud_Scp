<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Update SCP-Foundation subject form</title>
</head>

<body class="container bg-secondary">

  <?php

  $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : die("Error subject not found!"); //will have to pass id varible

  include 'config/connection.php';

  try {
    $query = "select * from subject where id = ? limit 0,1"; //if more then one record then limit to first record found

    $read = $conn->prepare($query);

    $read->bindParam(1, $id);
    $read->execute();

    $row = $read->fetch(PDO::FETCH_ASSOC); //save asoc array
    $item = $row['item'];
    $class = $row['class'];
    $containment = $row['containment'];
    $description = $row['description'];
    $image = $row['image'];
  }
  catch (PDOException $exception) 
  {
    die('ERROR: ' . $exception->getMessage());    
  }

  if (isset($_REQUEST['update'])) //if this page gets submit valiue then run code
  {    
    try {
      //insert items from form
      //insert query createing parameters to field use same name as field do this order
      $query = "update subject set item=:item, class=:class, containment=:containment, description=:description, image=:image where id=:id"; //need to add where ? thing

      $update = $conn->prepare($query); 
      $statement = $conn->prepare($query);

      $id = htmlspecialchars(strip_tags($_POST['id']));
      $item = htmlspecialchars(strip_tags($_POST['item']));
      $class = htmlspecialchars(strip_tags($_POST['class']));
      $containment = htmlspecialchars(strip_tags($_POST['containment']));
      $description = htmlspecialchars(strip_tags($_POST['description']));
      $image = htmlspecialchars(strip_tags($_POST['image']));

      //bind first
      $statement->bindParam(':id', $id);
      $statement->bindParam(':item', $item);
      $statement->bindParam(':class', $class);
      $statement->bindParam(':containment', $containment);
      $statement->bindParam(':description', $description);
      $statement->bindParam(':image', $image);

      //execute the query update
      if ($statement->execute()) 
      {
        echo "<div class='alert alert-success'>Record {$id} was updated.</div>";
      } 
      else 
      {
        echo "<div class='alert alert-danger'>Unable to update record, please try again</div>";
      }
    } 
    catch (PDOException $exception)
    {
      die('ERROR: ' . $exception->getMessage());
    }
  } 
  else 
  {
    echo "<div class='alert alert-danger'>Record is ready to be updated</div>";
  }
  ?>

  <h1>Update SCP-Foundation subject</h1>  

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-group">
    <label>SCP Item number:</label>
    <br>
    <input type="text" name="item" class="form-control" value="<?php echo $item; ?>">
    <br>
    <label>SCP Class:</label>
    <br>
    <input type="text" name="class" class="form-control" value="<?php echo $class; ?>">
    <br>
    <label>Containment:</label>
    <br>
    <textarea class="form-control" name="containment"><?php echo $containment; ?></textarea>
    <br>
    <label>Description:</label>
    <br>
    <textarea class="form-control" name="description"><?php echo $description; ?></textarea>
    <br>
    <label>Image</label>
    <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
    <br>
    <br>
    <input type="submit" value="Save Changes" name="update" class="btn btn-primary">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
  </form>

  <button onclick="deletesubject(<?php echo $id; ?>)" class='btn btn-danger'>Delete</button>
  <a href="index.php" class="btn btn-primary">Back to home page</a>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- using ajax so slim is not suitable <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <?php
  $delete = isset($_GET['action']) ? $_GET['action'] : "";

  //if directed from delete .php 
  if ($delete == 'deleted') 
  {
    echo "<div class='alert alert-success'>Record was deleted</div>";
  }
  ?>
  <script type="text/javascript">
    function deletesubject(id) {
      console.log(1);
      console.log(2);
      var answer = confirm('Would you like to delete this record?');
      if (answer) {
        console.log(444444)
        $.ajax({
          url: "/crud_scp/delete.php?",
          method: "POST",
          data: {
            id: id
          },
          success: function(result) {
            window.location.replace("/crud_scp/index.php?action=deleted");
          },
          fail: function(result) {
            console.log('delete failed');
          }
        });
      }
      console.log(5)
    }
  </script>
</body>
</html>