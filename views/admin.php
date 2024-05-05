<?php
session_start();

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';

if (!_is_admin()) {
  header('Location: /login');
  exit();
}


$db = _db();
$sql = $db->prepare('SELECT * FROM users
ORDER BY user_id DESC LIMIT 10;');
$sql->execute();
$users = $sql->fetchAll();

$db = _db();
$sql = $db->prepare('SELECT * FROM orders
ORDER BY order_id ASC;');
$sql->execute();
$orders = $sql->fetchAll();
?>
<nav id="admin-nav">
  <li>
    Welcome <h4 <?php echo $_SESSION['user_role']; ?>> Admin</h4>
  </li>
  <li>
    <a href="/company2/views/logout.php">Logout</a>
  </li>
</nav>
<link rel="stylesheet" href="/company2/css/admin.css">

<section id="users">
  <form id="frm_search">
    <input name="query" id="search_query" type="text" placeholder="Search">
    <button type="submit">Search</button>
  </form>
  <div id="query_results" style="display: none;"></div>

  <?php foreach ($users as $user) : ?>
    <div id="viewUsers">
      <div>
        <div><label for="user_id" name="User ID">User ID: </label>
        </div>
        <?= $user['user_id'] ?>
      </div>
      <div>
        <div><label for="user_name" name="User Name">User Name: </label>
        </div>
        <?= $user['user_name'] ?>
      </div>
      <div>
        <div><label for="user_last_name" name="User Last Name">User Last Name: </label>
        </div>
        <?= $user['user_last_name'] ?>
      </div>
      <div>
        <div>
          <label for="view_user" name="View User">View User: </label>
        </div>
        <a href="/views/user.php?user_id=<?= $user['user_id'] ?>">
          👁️
        </a>
      </div>
      <div>
        <label for="view_role" name="View Role">View Role: </label>
        <div>
          <?= $user['user_role'] ?>
        </div>
      </div>
      <button onclick="toggle_blocked(<?= $user['user_id'] ?>,<?= $user['user_is_blocked'] ?>)">
        <?= $user['user_is_blocked'] == 0 ? "unblocked" : "blocked" ?>
      </button>
      <div id="id_box">
        <form onsubmit="delete_user(); return false">
          <input name="user_id" type="text" value="<?= $user['user_id'] ?>">
          <button>
            🗑️
          </button>
      </div>
      </form>
    </div>
  <?php endforeach ?>
</section>




<section id="orders">
  <form id="frm_search">
    <input name="query" id="search_query" type="text" placeholder="Search">
    <button type="submit">Search</button>
  </form>
  <div id="query_results" style="display: none;"></div>
  <?php foreach ($orders as $order) : ?>
    <div id="vieworders">
      <div>
        <div><label for="order_id" name="order id">Order ID:</label>
        </div>
        <?= $order['order_id'] ?>
      </div>

      <div>
        <div><label for="order_user_fk" name="order user fk">Order user fk:</label>
        </div>
        <?= $order['order_user_fk'] ?>
      </div>

      <div>
        <div><label for="order_product_fk" name="order product fk Last Name">Order product fk:</label>
        </div>
        <?= $order['order_product_fk'] ?>
      </div>

      <div>
        <div><label for="order_amount_paid" name="order amount paid">Order amount paid:</label>
        </div>
        <?= $order['order_amount_paid'] ?>
      </div>

      <div>
        <div><label for="order_status" name="order status">Order status:</label>
        </div>
        <?= $order['order_status'] ?>
      </div>
      </form>
    </div>
  <?php endforeach ?>
</section>


<?php require_once __DIR__ . '/_footer.php'  ?>