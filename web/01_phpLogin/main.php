<?php
    require __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $host = $_ENV['TUTORIAL_PHP_HOST'];
    $user = $_ENV['TUTORIAL_PHP_DB_USER'];
    $dbPassword = $_ENV['TUTORIAL_PHP_DB_PASSWORD'];
    $db = $_ENV['TUTORIAL_PHP_DB'];

    $sessionId = $_COOKIE["sessionid"];
    $username = '';

    $mysqli = new mysqli($host, $user, $dbPassword, $db);
    if ($mysqli->connect_error) {
        exit();
    } 
    
    $mysqli->set_charset('utf8');

    $sql = "SELECT * from user WHERE sessionid='".$sessionId."'";

    if($result = $mysqli->query($sql)) {
        if(mysqli_num_rows($result) === 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
        } else {
            header("Location: login.php");
        }
    }

    $mysqli->close();
?>

<html>
    <body>
        こんにちは、<?php echo($username) ?>さん
    </body>
</html>