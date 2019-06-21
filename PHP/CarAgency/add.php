<?php
require "db.php";

$db = new DBLink("db");
$errDesc = "";
$errYear = "";
$errModel = "";
$errMake = "";
$added = false;
$worked = "";

if (isset($_POST['add'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $desc = $_POST['desc'];

    if ($desc == "")
        $errDesc = 'fill desc up';
    if($year == "")
        $errYear = 'fill year up';
    if ($model == "")
        $errModel = 'fill model up';
    if ($make == "")
        $errMake = 'fill make up';
    else {
        $db->insertData($make, $model, $year, $desc);
        $added = true;
        $worked = "Item added!";
    }
}

?>

<html>
    <head>
        <title>Add Cars</title>
    <style>
    div {
        text-align: center;
        border:1px solid black;
        width: 950px;
        margin: auto;
        padding: 10px;
        margin-bottom: 10px;
    }

    table {
        margin: auto;
        width: 1000px;
        height: 600px;
        padding: 50px;
        border-spacing: 15px;
    }

    tr, th, td {
        padding: 10px;
        border:1px solid black; 
        text-align: center;
    }

    textarea {
        resize: none;
    }
    </style>
    </head>

    <body>
    <div>
        Hello everyone<br>
        <a href="view.php">View cars</a>
        <?php
        if ($added) {
            echo "<br>". $worked;
            sleep(3);
            header('location:./add.php');
        }
        ?>
    </div>

    <form action="" method="post">
        <table border="1">
            <tr>
                <th colspan="2">Hey</th>
            </tr>
            <tr>
                <td>Make</td>
                <td><input type="text" name="make" id="make"> <?php echo $errMake; ?></td>
            </tr>
            <tr>
                <td>Model</td>
                <td><input type="text" name="model" id="model"> <?php echo $errModel; ?></td>
            </tr>
            <tr>
                <td>Year</td>
                <td><input type="text" name="year" id="year"> <?php echo $errYear; ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea name="desc" id="desc"></textarea> <?php echo $errDesc; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="add" id="add" value="Submit">
                    <input type="reset" name="reset" id="reset" value="Reset">
                </td>
            </tr>
        </table>
    </form>

    <div></div>
    </body>
</html>