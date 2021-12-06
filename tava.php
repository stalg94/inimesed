<?php
require("vendor/config.php");
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ab_login.php');
    exit();
}

require("functions.php");
$sort = "kaubanimi";
$search_term = "";
if(isset($_REQUEST["sort"])) {
    $sort = $_REQUEST["sort"];
}
if(isset($_REQUEST["search_term"])) {
    $search_term = $_REQUEST["search_term"];
}
if(isset($_REQUEST["kaubagrupi_lisamine"])) {
    addGroup($_REQUEST["kaubagrupi_nimi"]);
    header("Location: tava.php");
    exit();
}
if(isset($_REQUEST["kauba_lisamine"])) {
    addGood($_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
    header("Location: tava.php");
    exit();
}
if(isset($_REQUEST["delete"])) {
    deleteGood($_REQUEST["delete"]);
    header("Location: tava.php");
    exit();
}
if(isset($_REQUEST["save"])) {
    saveGood($_REQUEST["changed_id"], $_REQUEST["kaubanimi"], $_REQUEST["hind"], $_REQUEST["kaubagrupp_id"]);
}
$goods = groupData($sort, $search_term);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<!--     <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>-->
    <title>Kaubad ja Kaubagruppid</title>
</head>
<body>
<header class="header">
    <p>Tere tulemast, tava!</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
    <div class="container">
        <h1>Tabelid | Kaubad ja kaubagruppid</h1>
    </div>
</header>
<main class="main">
    <div class="container">
        <form action="tava.php">
            <input type="text" name="search_term" placeholder="Otsi...">
        </form>
    </div>
    <?php if(isset($_REQUEST["edit"])): ?>
        <?php foreach($goods as $good): ?>
            <?php if($good->id == intval($_REQUEST["edit"])): ?>
                <div class="container">
                    <form action="tava.php">
                        <input type="hidden" name="changed_id" value="<?=$good->id ?>"/>
                        <input type="text" name="kaubanimi" value="<?=$good->kaubanimi?>">
                        <input type="text" name="hind" value="<?=$good->hind?>">
                        <?php echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id"); ?>
                        <a title="Katkesta muutmine" class="cancelBtn" href="tava.php" name="cancel">X</a>
                        <input type="submit" name="save" value="&#10004;">
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="flex justify-around ">
        <div   class="border-gray-400 rounded py-4">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th><a href="tava.php?sort=kaubanimi" class="m-2">Kauba nimi</a></th>
                    <th><a href="tava.php?sort=hind" class="m-2">Kauba Hind</a></th>
                    <th><a href="tava.php?sort=kaubagrupp" class="m-2">Kauba Grupp</a></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($goods as $good): ?>
                    <tr>
                        <td><strong><?=$good->id ?></strong></td>
                        <td><?=$good->kaubanimi ?></td>
                        <td><?=$good->hind ?></td>
                        <td><?=$good->kaubagrupp ?></td>
                        <td>
                            <a title="Kustuta kaup" class="deleteBtn" href="tava.php?delete=<?=$good->id?>"
                               onclick="return confirm('Oled kindel, et soovid kustutada?');">X</a>
                            <a title="Muuda kaup" class="editBtn" href="tava.php?edit=<?=$good->id?>">&#9998;</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div>
            <form action="tava.php">
                <h2>Kaubagruppi lisamine:</h2>
                <dl>
                    <dt>Kaubagruppi nimi:</dt>
                    <dd><input type="text" name="kaubagrupi_nimi" placeholder="Sisesta kaubagrupp..."></dd>
                    <input type="submit" name="kaubagrupi_lisamine" value="Lisa kaubagrupp" class="cursor-pointer ">
                </dl>
            </form>
        </div>
        <div>
            <form action="tava.php">
                <h2>Kauba lisamine:</h2>
                <dl>
                    <dt>Kauba nimetus:</dt>
                    <dd><input type="text" name="kaubanimi" placeholder="Sisesta kaubanimi..."></dd>
                    <dt>Kauba hind:</dt>
                    <dd><input type="text" name="hind" placeholder="Sisesta kauba hind..."></dd>
                    <dt>Kaubagrupp</dt>
                    <dd><?php
                        echo createSelect("SELECT id, kaubagrupp FROM kaubagrupid", "kaubagrupp_id");
                        ?></dd>
                    <input type="submit" name="kauba_lisamine" value="Lisa kaup">
                </dl>
            </form>
        </div>

    </div>
</main>

</body>
</html>

