<?php
require_once 'templates/header.php';

$host     = 'localhost';
$database = 'PHP_connect';
$user     = 'root';
$password = 'mysql';

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['message'])) :
    $username = $_POST['username'];
    $message = $_POST['message'];
    $stmt = $db->prepare("INSERT INTO `posts`(`name`, `message`) VALUES ($username, $message)");
    $stmt->execute(['username' => $username, 'message' => $message]);
endif;

$posts = $db->query("SELECT * FROM `posts`");

foreach ($posts as $post) :
?>
    <div class="card">
        <div class="card-header">
            <span><?php echo $post["name"] ?></span>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo $post["message"] ?></p>
        </div>
    </div>
    <hr>
<?php
endforeach;
?>

<form action="index.php" method="POST">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
        </div>
    </div>

    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Add new post</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>
