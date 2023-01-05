
<?php

    // Start the session
    session_start();

    // Include the header file
    require "include/header.php";

?>

<?php 

    // Check if the form has been submitted
    if (isset($_POST['add_to_cart'])) {
        // Check if the required form data has been set
        if (isset($_GET['id'], $_POST['name'], $_POST['price'], $_POST['quantity'])) {
            // Validate the quantity value
            if (is_numeric($_POST['quantity']) && intval($_POST['quantity']) > 0) {
                // Initialize the session cart array if it doesn't already exist
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                // Check if the product is already in the cart
                $product_exists = false;
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $_GET['id']) {
                        // Update the quantity of the existing product
                        $item['quantity'] += intval($_POST['quantity']);
                        $product_exists = true;
                        break;
                    }
                }

                // Add the product to the cart if it doesn't already exist
                if (!$product_exists) {
                    $session_array = [
                        'id' => $_GET['id'],
                        'name' => $_POST['name'],
                        'price' => $_POST['price'],
                        'quantity' => intval($_POST['quantity']),
                    ];
                    $_SESSION['cart'][] = $session_array;
                }

                // Display a message to the user
                echo "<script> alert('Added to cart! '); </script>";
                            
            } else {
                // Display an error message if the quantity is invalid
                echo "Invalid quantity!";
            }
        } else {
            // Display an error message if the required form data is missing
            echo "Missing form data!";
        }
    }
?>

<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center pb-5">STORE</h2>
                <div class="col-md-12">
                    <div class="row">
                        <?php 
                            require "controller/connect.php";
                            // if(error_log())

                            $query = "SELECT * FROM cart";
                            $result = mysqli_query($conn, $query);
                            if(!$conn) {
                                echo "<script> alert(</script><div class='alert alert-danger'>Product not found!</div>) </script>";
                            }else{

                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <div class="col-md-4">
                                        <form method="post" action="index.php?id=<?=$row['id']; ?>">
                                            <img src="img/<?=$row['image']; ?>" alt="" style="height:15rem; width: 100%;">
                                            <h5 class="text-center"><?=$row['name']; ?></h5>
                                            <h5 class="text-center">$<?= number_format($row['price'], 2); ?></h5>
                                            <input type="hidden" name="id" value="<?=$row['id'];?>">
                                            <input type="hidden" name="name" value="<?=$row['name'];?>">
                                            <input type="hidden" name="price" value="<?=$row['price'];?>">
                                            <input type="number" class="form-control" name="quantity" value="1">
                                            <input class="btn btn-warning btn-block" type="submit" name="add_to_cart" value="Add To Cart"><br>
                                        </form>
                                    </div>

                                <?php 

                                }
                            }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="top"> 
       <a tabindex="-1" href="#" id="metadata-link" data-target="#modal" data-toggle="modal">Metadata</a>
    </div>

    <div class="modal fade in" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: block;">

      <div class="modal-header">header<a class="close" data-dismiss="modal">x</a></div>
      <div class="modal-body"><h1 class="text-primary text-center">Let's Go</h1></div>
      <div class="modal-footer">footer</div>
   </div>

<script>

    // $(document).ready(function() {
    //     $('#top').find('a').trigger('click');

    // });
</script>

<script>
    $(document).ready(function() {
        $("form").submit(function(e) {
            location.reload();
            // return false;
            // e.preventDefault();
            // var id = $("#id").val();
            // var name = $("#name").val();
            // var price = $("#price").val();
            // var quantity = $("#quantity").val();
            // var total_price = $("#total_price").val();
        })
    })
</script>

<?php

    // Include the footer file
    require "include/footer.php";

?>