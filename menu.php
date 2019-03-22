<?php
$menus[] = ['link' =>'index.php', 'name' => 'Accueil'];
$menus[] = ['link' =>'presentation.php', 'name' => 'Présentation'];
$menus[] = ['link' =>'articles.php', 'name' => 'Articles'];
$menus[] = ['link' =>'users.php', 'name' => 'Utilisateurs', 'admin' => true];
$menus[] = ['link' =>'login.php', 'name' => 'Login', 'connect' => false];
$menus[] = ['link' =>'logout.php', 'name' => 'Logout', 'connect' => true];

function isActive(array $menu)
{
    if (stripos($_SERVER["REQUEST_URI"],$menu['link']) ) {
        return true;
    }
    return false;
}

function hasRight(array $menu) {

    if (isset($menu['admin']) && $menu['admin'] === true) {
        if (isset($_SESSION['admin']) && ($_SESSION['admin'] === true)) {
            return true;
        }
        return false;
    }

    if (isset($menu['connect'], $_SESSION['id']) && $menu['connect'] === true) {
        return true;
    }


    if (isset($menu['connect']) && $menu['connect'] === false && isset($_SESSION['id']) === false ) {
        return true;
    }

    if (isset($menu['connect']) === false) {
        return true;

    }

    return false;


}
?>

<nav>
    <ul class="menu">
        <?php foreach($menus as $menu) {?>
            <?php if(hasRight($menu)) {?>
            <li <?php if(isActive($menu)) {?> class="active" <?php } ?>>
                <a href="<?php echo $menu['link']; ?>"><?php echo $menu['name']; ?></a>
            </li>
        <?php }
        }?>
    </ul>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Bienvenue <?= $_SESSION['username']?></p>
        <?php if (isset($_SESSION['admin']) && ($_SESSION['admin'] === true)) echo "Vous êtes admin"; ?>
    <?php endif ?>
</nav>
