<?php
    require __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $host = $_ENV['TUTORIAL_PHP_HOST'];
    $user = $_ENV['TUTORIAL_PHP_DB_USER'];
    $dbPassword = $_ENV['TUTORIAL_PHP_DB_PASSWORD'];
    $db = $_ENV['TUTORIAL_PHP_DB'];

    $error = "";

    if(isset($_GET['username']) && isset($_GET['password'])){
        $userName = $_GET['username'];
        $userPassword = $_GET['password'];

        $mysqli = new mysqli($host, $user, $dbPassword, $db);
        if ($mysqli->connect_error) {
            exit();
        } 
        
        $mysqli->set_charset('utf8');

        $sql = "SELECT * from user WHERE username='".$userName."' and password='".$userPassword."'";

        if($result = $mysqli->query($sql)) {
            if(mysqli_num_rows($result) >= 1) {
                $row = $result->fetch_assoc();
                $userId =  $row['id'];
                session_start();
                $sessionId = session_id();

                $sql = $sql = "UPDATE user SET sessionid='".$sessionId."' WHERE id=".$userId;
                if($result = $mysqli->query($sql)) {
                    header("Location: main.php");
                    header("Set-Cookie: sessionid=".$sessionId);
                } else {
                    
                }
            } else {
                $error = $userName.' is invalid.<br>';
            }
        }

        $mysqli->close();
    }

?>

<header>
    <title>Login</title>
</header>
<body>
    <div id="loginLabel">Login</div>
    <div id="loginForm">
        <form action="/login.php" id="form1">
            <label>Username</label>
            <input type="text" id="username" name="username"><br>
            <label>Password</label>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
        <?=$error;?>
    </div>
</body>

<style>
    #loginLabel {
        color: blue;
        text-align: center;
    }
    #loginForm {
        background-color: blue;
        text-align: center;
    }
</style>
