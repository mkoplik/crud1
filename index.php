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
            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            
            $products = mysqli_query($connect, "SELECT * FROM `products`");
            $productsArray = array();

            while ($product = mysqli_fetch_assoc($products)) {
                $productsArray[] = $product;
            }

            foreach ($productsArray as $product) {
                $id = $product['id'];
                $title = $product['title'];
                $price = $product['price'];
                $description = $product['description'];

                ?>
                <tr>
                    <td><?php echo $id ?></td>
                    <td contenteditable="true"><?php echo $title ?></td>
                    <td contenteditable="true"><?php echo $description ?></td>
                    <td contenteditable="true"><?php echo $price ?></td>
                    <td style="cursor: pointer; color:blue" class="updateProduct" data-id="<?php echo $id ?>">
                        <span   class="update">Update</span>
                        <span  data-id="<?php echo $id ?>"  class="save" style="display: none;">Save</span>
                    </td>
                    <td><a class="deleteProduct" style="color: red; cursor: pointer;" data-id="<?php echo $id ?>">Delete</a></td>
                </tr>
                <?php
            }
        ?>
    </table>
    <h3>Add new product</h3>
    <form action="vendor/create.php" method="post">
        <p>Title</p>
        <input type="text"  name="title">
        <p>Description</p>
        <textarea name="description"></textarea>
        <p>Price</p>
        <input type="number"  name="price"> <br>  <br>
        <button type="button" id="addProductButton">Add new product</button>
    </form>

    <script>
        $(document).ready(function() {
            // Обработчик кнопки "Add new product"
            $("#addProductButton").click(function() {
                var formData = {
                    title: $("input[name='title']").val(),
                    description: $("textarea[name='description']").val(),
                    price: $("input[name='price']").val()
                };

                $.ajax({
                    type: "POST",
                    url: "vendor/create.php",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            alert("Product added successfully!");
                            location.reload(); // Перезагрузка страницы для отображения нового продукта
                        } else {
                            alert("Error adding product.");
                        }
                    },
                    error: function() {
                        alert("Error: Unable to add product.");
                    }
                });
            });

            // Обработчик для обновления продукта
            $(".updateProduct").click(function() {
                var $clickedElement = $(this);
                var $row = $clickedElement.closest("tr");
                var productId = $row.find("td:first").text();
                var title = $row.find("td:nth-child(2)").text();
                var price = $row.find("td:nth-child(4)").text();
                var description = $row.find("td:nth-child(3)").text();

                $row.find(".update").hide();
                $row.find(".save").show();

                
                $(".save").click(function () {
                    var formData = {
                        "id": productId,
                        "title": title,
                        "price": price,
                        "description": description
                    };

                    $.ajax({
                        type: "POST",
                        url: "vendor/update.php",
                        data: {
                            _method: "PUT",
                            ...formData
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                alert("Product updated successfully!");
                                window.location.href = "index.php";
                            } else {
                                alert("Error updating product.");
                            }
                        },
                        error: function () {
                            alert("Error: Unable to update product.");
                        }
                    });
                });
            });

            // Обработчик для удаления продукта
            $(".deleteProduct").click(function() {
                var productId = $(this).data("id");
                var $clickedElement = $(this);

                $.ajax({
                    url: "vendor/delete.php?id=" + productId,
                    type: "DELETE",
                    data: { id: productId },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message);
                            $clickedElement.closest("tr").remove();
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error deleting product:", error);
                    }
                });
            });
        });
    </script>
</body>
</html>

