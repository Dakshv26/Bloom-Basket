<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){

   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'payment has been updated!';

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
         <form action="" method="POST">
    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
    <p>Payment status: <?= $fetch_orders['payment_status']; ?></p>
    <select name="update_payment" class="drop-down">
        <option value="" disabled>Select Payment Status</option>
        <option value="pending" <?= ($fetch_orders['payment_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="completed" <?= ($fetch_orders['payment_status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
    </select>

    <p>Order status: <?= $fetch_orders['order_status']; ?></p>
    <select name="update_order_status" class="drop-down">
        <option value="" disabled>Select Order Status</option>
        <option value="pending" <?= ($fetch_orders['order_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="dispatched" <?= ($fetch_orders['order_status'] == 'dispatched') ? 'selected' : ''; ?>>Dispatched</option>
        <option value="on its way" <?= ($fetch_orders['order_status'] == 'on its way') ? 'selected' : ''; ?>>On its way</option>
        <option value="delivered" <?= ($fetch_orders['order_status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
    </select>

    <div class="flex-btn">
        <input type="submit" name="update_order" class="option-btn" value="Update">
        <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
    </div>
</form>

      </div>




      <?php

if (isset($_POST['update_order'])) {
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   
   // Check if 'update_order_status' is set, otherwise set a default value
   $update_order_status = isset($_POST['update_order_status']) ? $_POST['update_order_status'] : 'pending';

   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_order_status = filter_var($update_order_status, FILTER_SANITIZE_STRING);

   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ?, order_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $update_order_status, $order_id]);
   $message = [];
   $message[] = 'Payment and order status have been updated!';
}

?>


      <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

   </div>

</section>












<script src="js/script.js"></script>

</body>
</html>