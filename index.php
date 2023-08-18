<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
    th, td {
        padding: 10px;
    }

    th {
        background: #606060;
        color: #fff;
    }

    td {
        background: #b5b5b5;
    }
</style>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>&#9998;</th>
            <th>&#10006;</th>
        </tr>
        <?php
            require_once 'config/connect.php';

            $products = mysqli_query($connect, "SELECT * FROM `products`");
            $products = mysqli_fetch_all($products);
            foreach ($products as $product) {
                ?>
                
                <tr>
                    <td><?php echo $product[0] ?></td>
                    <td><?php echo  $product[1] ?></td>
                    <td><?php echo $product[3] ?></td>
                    <td><?php echo $product[2] ?></td>
                    <td><a href="update.php?id=<?php echo  $product[0] ?>">Update</a></td>
                    <td><a class="deleteProduct" style="color: red; cursor: pointer;" data-id="<?php echo $product[0] ?>">Delete</a></td>
                </tr>
                <?php
            }
        ?>
    </table>
    <h3>Add new product</h3>
    <form action="vendor/create.php"  method="post">
        <p>Title</p>
        <input type="text"  name="title">
        <p>Description</p>
        <textarea name="description"></textarea>
        <p>Price</p>
        <input type="number"  name="price"> <br>  <br>
        <button type="submit">Add new product</button>
    </form>

    <script>
        $(document).ready(function() {
            $(".deleteProduct").click(function() {
                var productId = $(this).data("id");
                var $clickedElement = $(this);

                $.ajax({
                    url: "vendor/delete.php",
                    type: "POST",
                    data: { id: productId },
                    dataType: "json", 
                    success: function(response) {
                        console.log("Ответ сервера:", response);
                        if (response.status === "success") {
                            console.log(response.message);
                            $clickedElement.closest("tr").remove();
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ошибка при удалении продукта:", error);
                    }
                });
            });
        });
    </script>
</body>
</html>
<!-- <h1>проверочка</h1> -->
