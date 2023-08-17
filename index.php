<?php
    require_once('classes/Crud.php');
    require_once('connection/Connection.php');

    $database = new Database();
    $db = $database->getConnection();
    $crud = new Crud($db);

    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'create':
                $crud->create($_POST);
                $rows = $crud->read();
                break;
            case 'read':
                $rows = $crud->read();
                break;
            // case 'update':
            // case 'delete':
            default:
                $rows = $crud->read();
                break;
        }
    } else {
        $rows = $crud->read();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <style>
        form{
            max-width:500px;
            margin: 0 auto;
        }
        label{
          display: flex;
           margin-top:10px
        }
        input[type=text]{
           width:100%;
           padding: 12px 20px;
           margin: 8px 0;
           display:inline-block;
           border: 1px solid #ccc;
           border-radius:4px;
           box-sizing:border-box;
        }
        input[type=submit]{
           background-color:#4caf50;
           color:white;
           padding:12px 20px;
           border:none;
           border-radius:4px;
           cursor:pointer;
           float:right;
        }
        input[type=submit]:hover{
           background-color:#45a049;
        }
        table{
           border-collapse:collapse;
           width:100%;
           font-family:Arial, sans-serif;
           font-size:14px;
           color:#333;
        }
        th, td{
           text-align:left;
           padding:8px;
           border: 1px solid #ddd;
        }
        th{
           background-color:#f2f2f2;
           font-weight:bold; 
        }
        a{
            display:inline-block;
            padding:4px 8px;
            background-color: #007bff;
            color:#fff;
            text-decoration:none;
            border-radius:4px;
        }
        a:hover{
            background-color:#0069d9;
        }

        a.delete{
            background-color: #dc3545;
        }
        a.delete:hover{
            background-color:#c82333;
        }
    </style>
</head>
<body>
    <?php
        if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
            $id = $_GET['id'];
            $result = $crud->readOne($id);

            if($result){
                echo "Register not found.";
                exit();
            }

            $model = $result['model'];
            $brand = $result['brand'];
            $licenseplate = $result['licenseplate'];
            $color = $result['color'];
            $year = $result['year'];
        
    ?>













    <form action="?action=create" method="POST">
        <label for="model">Model</label>
        <input type="text" name="model">

        <label for="brand">Brand</label>
        <input type="text" name="brand">

        <label for="licenseplate">License Plate</label>
        <input type="text" name="licenseplate">

        <label for="color">Color</label>
        <input type="text" name="color">

        <label for="year">Year</label>
        <input type="text" name="year">

        <input type="submit" value="Register" name="send">
    </form>
    <table>
        <tr>
            <td>Id</td>
            <td>Model</td>
            <td>Brand</td>
            <td>License Plate</td>
            <td>Color</td>
            <td>Year</td>
            <td>Ações</td>
        </tr>
        <?php
            if($rows->rowCount() == 0){
                echo "<tr>";
                echo "<td colspan='7'>No data found</td>";
                echo "</tr>";
            } else {
                while($row = $rows->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['brand'] . "</td>";
                    echo "<td>" . $row['licenseplate'] . "</td>";
                    echo "<td>" . $row['color'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>";
                    echo "<a href='?action=update&id=" . $row['id'] . "'>Update</a>";
                    echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Do you really wanna delete this registry?\")' class='delete'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
</body>
</html>