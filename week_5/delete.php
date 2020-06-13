<?php
    require_once('db.php');
    session_start();
    if ( !isset($_SESSION['name']) ) 
    {
        die("ACCESS DENIED");
        
    }
    //// after form submission
    if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) 
    {
      echo "<pre>";
      print_r($_POST);

      $sql = 'DELETE FROM autos WHERE auto_id = :zip';
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
          'zip' => $_POST['auto_id']
      ]);

      $_SESSION['success'] = 'Record deleted';
      header('Location: index.php');
      return;
    }


    ////check auto_id exist or not
    $sql = 'SELECT * FROM autos WHERE auto_id = :xyz';    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'xyz' => $_GET['autos_id']
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) 
    {
        $_SESSION['error'] = 'Bad value for auto_id';
        
        header('Location: index.php');
        return;
    }
?>

<!-- if exist -->
<!DOCTYPE html>
<html>
<head>
<title>Sarker Sunzid Mahmud</title>

<?php require_once "bootstrap.php"; ?>

</head>
    <body>

    <div class="container">
        <h1> Confirm: Deleting <?= htmlentities($row['make'] ) ?></h1>

        <form  method="post">
            <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">

            <input type="submit" value="Delete" name="delete" class="btn btn-danger" >
            <a href="index.php" class="btn btn-warning">Cancel</a>
        </form>


    </div>