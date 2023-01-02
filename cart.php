<?php
    session_start();
    // $_SESSION['cart'];
    // session_destroy();
    require "include/header.php";
    if(isset($_POST['add_to_cart'])){
        // $_SESSION['cart'] = $_SESSION['cart'];
        if(isset($_SESSION['cart'])){
            $session_array_id = array_column($_SESSION['cart'], "id");

            if(!in_array($_GET['id'], $session_array_id)){
                $session_array = array(
                    'id' => $_GET['id'],
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'quantity' => $_POST['quantity'],
                );
    
                $_SESSION['cart'][] = $session_array;

            }

        }
        else{
            $session_array = array(
                'id' => $_GET['id'],
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'quantity' => $_POST['quantity'],
            );

            $_SESSION['cart'][] = $session_array;
        }
    }
?>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Shopping Cart</h2>
                <div class="col-md-12">
                    <div class="row">
                        <?php 
                            require "controller/connect.php";

                            $query = "SELECT * FROM cart";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_array($result)) { ?>
                                <div class="col-md-4">
                                    <form method="post" action="cart.php?id=<?=$row['id']; ?>">
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
                            <?php }
                        
                        ?>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h2 class="text-center">Selected Items</h2>
                <?php 
                    // var_dump($_SESSION['cart']);
                    $total = 0;            
                    $output = "";

                    $output .= "
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th> ID</th>
                                    <th> Name</th>
                                    <th> Price</th>
                                    <th> Quantity</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                        
                            </thead>
                    ";

                    if(!empty($_SESSION['cart'])){
                        foreach ($_SESSION['cart'] as $key => $value){
                            $output.= "
                                <tr>
                                    <td>".$value['id']."</td>
                                    <td>".$value['name']."</td>
                                    <td>$".number_format($value['price'], 2)."</td>
                                    <td>".$value['quantity']."</td>
                                    <td>$".number_format($value['price'] * $value['quantity'], 2)."</td>
                                    <td>
                                        <a href='cart.php?action=remove&id=".$value['id']."'>
                                            <button class='btn btn-danger btn-block'>Remove</button>
                                        </a?
                                    </td>
                                </tr>" ;

                                $total = $total + $value['quantity'] * $value['price'];
                        }
                        $output.= "
                        <tr>
                            <td class='text-center' colspan='4'>Overall Price</td>
                            <td>$".number_format($total, 2)."</td>
                            <td>
                                <a href='cart.php?action=clearall '>
                                    <button class='btn btn-warning btn-block'>Clear All</button>
                                </a?
                            </td>
                        </tr>" ;        
                    }
                    "</table>";

                    echo $output;
                ?>
            </div>
        </div>
    </div>
</div>

<?php

    if(isset($_GET['action'])){
        if ($_GET['action'] == "clearall") {
            unset($_SESSION['cart']);
        }
    }

    if(isset($_GET['action'])){
        if ($_GET['action'] == "remove") {
            foreach ($_SESSION['cart'] as $key => $value){
                if($value['id'] == $_GET['id']){
                    
            unset($_SESSION['cart'][$key]);
                }
              }
        }
    }

?>

<script>
    $(document).ready(function() {
        $("form").submit(function(e) {
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
    require "include/footer.php";
?>