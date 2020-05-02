<?php

include 'dbconnect.php';

if (isset($_POST['btnsave'])) {

    $pname  = $_POST['txtname'];
    $price  = $_POST['textprice'];

    if (!empty($pname && $price)) {
        $insert = $pdo->prepare("insert into tbl_product(productname, productprice) values(:name, :price)");
        $insert->bindparam(':name', $pname);
        $insert->bindparam(':price', $price);
        $insert->execute();

        if ($insert->rowCount()) {
            echo "Insert Successfull";
        }else{
            echo "Insert fail";
        }

    } else{

        echo 'Fields are empty';

    }

} //this is the end of save btn (storing data)

if (isset($_POST['btnupdate'])) {

    $pname = $_POST['txtname'];
    $price = $_POST['txtprice'];
    $id    = $_POST['txtid'];

    if (!empty($pname && $price)) {

        $update = $pdo->prepare("update tbl_product set ProductName=:pname, productprice=:price where id=".$id);

        $update->bindparam(':pname', $pname);
        $update->bindparam(':price', $price);

        $update->execute();

        if ($update->rowCount()) {
            echo 'Data Update Successfull';
        }else{
            echo 'Data Update Fail';
        }

    }else{
        echo 'fields can not be empty';
    }

}else{} // btn update code end here

if (isset($_POST['btndelete'])) {
    $delete = $pdo->prepare("delete  from tbl_product where id=".$_POST['btndelete']);

    $delete->execute();

    if ($delete->rowCount()) {
        echo "Data Deleted Successfull";
    }else{
        echo "Delete Fail!!!";
    }

}
?>




<h1>CRUD with PDO USING RAW PHP</h1>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD</title>
</head>
<body>
    <form action="" method="post">

<?php

if (isset($_POST['btnedit'])) {

    $select = $pdo->prepare("select * from tbl_product where id =".$_POST['btnedit']);
    $select->execute();

    if ($select) {
        $row = $select->fetch(PDO::FETCH_OBJ);

        echo '

            <p><input type="text" name="txtname" value="'.$row->productname.'"></p>

            <p><input type="text" name="txtprice" value="'.$row->productprice.'"></p>

            <p><input type="hidden" name="txtid" value="'.$row->id.'"></p>

            <button type="submit" name="btnupdate">Update</button>
            <button type="submit" name="btncancel">Cancel</button>

            ';
        // print_r($row);
    }



}else{

    echo '

        <p><input type="text" name="txtname" placeholder="ProductName"></p>

        <p><input type="text" name="textprice" placeholder="ProductPrice"></p>

        <input type="submit" value="Save" name="btnsave">

        ';

}

?>




        <br>
        <br>
        <hr>
        <br>
        <br>
        <table id="producttable" border="1">
        <thead>
            <th>ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>

            <?php
            $select = $pdo->prepare("select * from tbl_product");
            $select->execute();

            while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                echo '
                    <tr>
                    <td>'.$row->id.'</td>
                    <td>'.$row->productname.'</td>
                    <td>'.$row->productprice.'</td>
                    <td><button type="submit" value="'.$row->id.'" name="btnedit">Edit</button></td>
                    <td><button type="submit" value="'.$row->id.'" name="btndelete">Delete</button></td>
                    </tr>
                    ';
            }


            ?>

        </tbody>
    </table>
    </form>
</body>
</html>

<hr>

 <?php
/**
$select = $pdo->prepare("select * from tbl_product");

$select->execute();
echo '<pre>';

// while($row = $select->fetch(PDO::FETCH_OBJ)) {

//     // echo $row[1]."<br>"; //fetch_num

//     // echo $row['productname']; //FETCH_ASSOC

//     echo $row->productname."<br>";

// print_r($row);

// }

$row = $select->fetchAll();

print_r($row);


fetch_codes

*/

?>
