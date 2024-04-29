<?php
session_start();

require_once __DIR__.'/_header.php';
require_once __DIR__.'/../_.php';

if( !_is_partner()){
  header('Location: /company2/views/login.php'); 
  exit();
}

$db = _db();
$sql = $db->prepare('SELECT * FROM orders
ORDER BY order_id ASC;');
$sql->execute();
$orders = $sql->fetchAll();
?>
<link rel="stylesheet" href="/company2/css/partner.css">
<nav id="partner-nav">
  <li>
    Welcome <h4 <?php echo $_SESSION['user_role']; ?>> Partner</h4>
  </li>
  <li>
    <a href="/company2/views/logout.php">Logout</a>
  </li>
</nav>


<section id="orders">
<form data-url="<?= $frm_search_url ?>" id="frm_search" action="/company2/views/search-results.php" method="GET">
      <input name="query" type="text"  
      placeholder="Search"
      oninput="search_users()"
      onfocus="document.querySelector('#query_results').classList.remove('hidden')"
      onblur="document.querySelector('#query_results').classList.add('hidden')"
      >
      <button>
        <span>
          Search
        </span>            
      </button>
      <div id="query_results">        
      </div>
    </form>
  <?php foreach($orders as $order):?>
    <div id="vieworders">
      <div>
      <div><label for="order_id" name="order id">Order ID:</label>
      </div>  
      <?= $order['order_id'] ?></div>
      
      <div>
      <div><label for="order_user_fk" name="order user fk">Order user fk:</label>
      </div>  
      <?= $order['order_user_fk'] ?></div>
      
      <div>
      <div><label for="order_product_fk" name="order product fk Last Name">Order product fk:</label>
      </div>  
      <?= $order['order_product_fk'] ?></div>
      
      <div>
      <div><label for="order_amount_paid" name="order amount paid">Order amount paid:</label>
      </div>  
      <?= $order['order_amount_paid'] ?></div>
      
      <div>
      <div><label for="order_status" name="order status">Order status:</label>
      </div>  
      <?= $order['order_status'] ?></div>
    </div>
  <?php endforeach?>
</section>


<?php require_once __DIR__.'/_footer.php'  ?>