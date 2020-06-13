<?php
    require_once('db.php');
    session_start();
    if ( !isset($_SESSION['name']) ) 
    {
        die("ACCESS DENIED");
        
    }
    //// after form submission
    if ( isset($_POST['Save']) &&  isset($_POST['id']) && isset($_POST['make']) &&  isset($_POST['model'])  &&  isset($_POST['year']) &&  isset($_POST['mileage']) )
    {
        if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) 
        {
            $_SESSION['error'] = "All fields are required";
            header("Location: edit.php?autos_id=".$_REQUEST['id']);
            return;       

        }
        elseif ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) 
        {
            $_SESSION['error'] = 'Mileage and year must be numeric';

            header("Location: edit.php?autos_id=".$_REQUEST['id']);
            return;            
        }
        else 
        {
            // echo "<pre>";
            // print_r($_POST);
            // die();
            $sql = "UPDATE autos SET 
                    make = :mk,
                    model = :mdl,
                    year = :yr,
                    mileage = :mi
                    WHERE auto_id = :xyz";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(
                        array(
                            ':mk' => $_POST['make'],
                            ':mdl' => $_POST['model'],
                            ':yr' => $_POST['year'],
                            ':mi' =>  $_POST['mileage'],
                            ':xyz' =>  $_POST['id']
                        )
            );


            $_SESSION['success'] = "Record edited";
            header("Location: index.php");
            return;
            
        }

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


    $make = $row['make'];
    $year = $row['year'];
    $mileage = $row['mileage'];
    $model = $row['model'];
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
        <h1 style="text-align:center; margin-bottom: 50px"> 
            Editing Automobile
        </h1>
        <?php
            // Note triple not equals and think how badly double
            // not equals would work here...
            if ( isset($_SESSION['error'] ) ) 
            {
                // Look closely at the use of single and double quotes
                echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                unset( $_SESSION['error'] );
            }
            // else 
            // {
            //     echo "<pre>";
            //     print_r($_SESSION);
            // }

        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= $row['auto_id'] ?>">

            <label>Make:
                <input type="text" class="form-control" name="make" size="60" value="<?= $make ?>"/>
            </label>
            <br>
            

            <label>Model:
                <input type="text" class="form-control" name="model" size="60" value="<?= $model ?>"/>
            </label>
            <br>

            <label>Year:
                <input type="text" class="form-control" name="year" value="<?= $year ?>"/>
            </label>
            <br>

            <label>Mileage:
                <input type="text" class="form-control" name="mileage" value="<?= $mileage ?>"/>
            </label>
            <br>
            <br>
            <br>

            <input type="submit" value="Update" name="Save" class="btn btn-success">
            <a href="index.php" class="btn btn-warning">Cancel</a>
        </form>
    
    </div>