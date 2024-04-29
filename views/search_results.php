<?php
session_start();
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';


$db = _db();
$q = $db->prepare(' SELECT * FROM users 
                    WHERE user_name = :word COLLATE NOCASE 
                    OR user_last_name = :word COLLATE NOCASE');
                    
$q->bindValue(':word', $_GET['query']);
$q->execute();
$users = $q->fetchAll();

?>

<main>
<?php foreach($users as $user): ?>
    <div>
      <div><?= $user['user_id'] ?></div>
      <div><?php out($user['user_name']) ?></div>
      <div><?php out($user['user_last_name']) ?></div>
      <div><?php out($user['user_email']) ?></div>
      <div><?php out($user['user_role_name']) ?></div>
      <button>🗑️</button>
    </div>
  <?php endforeach ?>
</main>

<?php
require_once __DIR__.'/_footer.php';
?>