<?php
$menu = 'user';
include('header.php');

$message = null;
if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    try {
        $instance = new PDO("mysql:host=localhost;dbname=tp", 'tp', 'secret');
        $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Échec lors de la connexion : '.$e->getMessage();
    }
    $reponse = $instance->prepare('INSERT INTO user (username, password) VALUES(:username, :password)');
    $reponse->execute(
        [
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_ARGON2I),
        ]
    );
    $message = "Utilisateur bien ajouté";
}

?>
<div class="container">
    <?php include('menu.php'); ?>
    <?php
    if ($message !== null) {
        echo "<div class='alert alert-success'>";
        echo $message;
        echo "</div>";
    }
    ?>
        <form method="post">
            <div class="form-group">
                <label>Nom :</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label>Password :</label>
                <input type="text" name="password" class="form-control">
            </div>
            <button class="btn btn-primary">Ajouter</button>
        </form>
</div>
</body>
</html>