<?php session_start();

    $_SESSION['usedQuestions'] = array();

    $_SESSION['MaxQuestions'] = 5;

    $_SESSION['try']=0;

    $_SESSION['status'] = "";

    $_SESSION['score'] = 0;



    $chapters = array('ch_1','ch_2','ch_3');
        if(!empty($_POST['choice'])) {
            $_SESSION['choice'] = $_POST['choice'];
            if($_SESSION['choice'] == 1) {
                $_SESSION['chapters'] = $chapters;
                header('location: Assignment.php');
            }
        }

?>

<!Doctype html>
<html>
    <head>
    </head>
    <body>
        <?php echo "Logged in as: ".$_SESSION['user'];?>
        <form action="" method="post">
            <input type="submit" name="choice" value="1">
            <input type="submit" name="choice" value="2">
        </form>
    </body>
</html>