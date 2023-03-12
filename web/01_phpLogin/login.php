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
    <h1 id="loginLabel">Login</h1>
    <div id="loginForm">
        <form action="/login.php" id="form1">
            <label class="loginFormLabel">Username</label><br>
            <input type="text" id="username" name="username" class="loginFormInput"><br>
            <label class="loginFormLabel">Password</label><br>
            <input type="password" id="password" name="password" class="loginFormInput"><br>
            <input type="submit" value="Login">
        </form>
        <div id="errorLabel" style="color: #e24848;"><?=$error;?></div>
    </div>
</body>

<style>
    body {
        font-family: monospace;
    }
    #loginLabel {
        color: #2c2c2c;
        text-align: center;
        margin: 20px 0px 20px 0px;
    }
    #loginForm {
        background-color: #efeff3;
        padding: 10px;
        margin-left: auto;
        margin-right: auto;
        width: 300px;
        border-style: solid;
        border-color: #a1a1b3;
        border-width: 1px;
    }
    .loginFormLabel {
        position: relative;
        left: 10px;
    }
    .loginFormInput {
        position: relative;
        left: 10px;
        width: 280;
        margin-bottom: 10px;
    }
    input[type="submit"] {
        font-family: monospace;
        margin: 30px 10px 10px 10px;
        width: 280; 
    }
</style>
