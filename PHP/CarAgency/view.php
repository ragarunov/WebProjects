<?php
require "db.php";

$db = new DBLink("db");
$isAvailable = false;

$results = $db->query();
$count = 1;

?>

<html>
    <head>
        <title>View Cars</title>
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

    td {
        border:1px solid black; 
    }

    tr, th, td {
        text-align: center;
    }
    
    </style>
    </head>

    <body>
    <div>
        Hello everyone<br>
        <a href="add.php">Add new</a>
    </div>
    
    <table>
        <tr>
            <th></th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Description</th>
            <th>Availability</th>
        </tr>
        <?php foreach ($results as $r) { ?>
        <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $r['make'] ?></td>
            <td><?php echo $r['model']; ?></td>
            <td><?php echo $r['year']; ?></td>
            <td><?php echo $r['description']; ?></td>
            <td>
                <?php
                if ($r['is_posted'])
                    echo "<a href='?lend=". $r['id'] ."'>Lend</a>";
                else
                    echo "<a href='?return=". $r['id'] ."'>Return</a>";

                ?>
            </td>
        </tr>
        <?php 
        }
            if (isset($_GET['lend'])) {
                if(!isset($_SERVER['HTTP_REFERER'])){
                    // redirect them to your desired location
                    header('location:./view.php');
                    exit;
                } else {
                    $db->makeUnAvailable($_GET['lend']);
                    header('location:./view.php');
                }
            }

            else if (isset($_GET['return'])) {
                if(!isset($_SERVER['HTTP_REFERER'])){
                    // redirect them to your desired location
                    header('location:./view.php');
                    exit;
                } else {
                    $db->makeAvailable($_GET['return']);
                    header('location:./view.php');
                }
            }
        ?>
    </table>

    <div>Righted</div>
    </body>
</html>