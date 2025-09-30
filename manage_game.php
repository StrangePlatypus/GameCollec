<?php

require_once 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM games WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(["id" => $id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);
$is_finished = ($game['is_completed'] == 1) ? "checked" : "";
$platforms = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'SteamDeck', 'Mobile'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $finished = isset($_POST["is_completed"]) ? 1 : 0;
    try{

        $params = [
            "id" => $id,
            'title' => $_POST["title"],
            'platform' => $_POST["platform"],
            'genre' => $_POST["genre"],
            'release' => $_POST["release_year"],
            'price' => $_POST["price"],
            'completed' => $finished,
            'rating' => $_POST["rating"],
            'purchase' => $_POST["purchase_date"],
            'notes' => $_POST["notes"]
        ];

        $sql_post = "UPDATE games
        SET `title` = :title,
        `platform` = :platform,
        `genre` = :genre,
        `release_year` = :release,
        `price` = :price,
        `is_completed` = :completed,
        `rating` = :rating,
        `purchase_date` = :purchase,
        `notes` = :notes
        WHERE id = :id";

        $stmt_post = $pdo->prepare($sql_post);
        $stmt_post->execute($params);
        echo '<script>alert("Le jeu a bien été modifié!");window.location="list_game.php";</script>';
    }catch(Exception $e){
        echo 'ERR : '.$e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les jeux</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main>
        <h2>Modifier le jeu</h2>
        <?php if(isset($_GET['id'])){
        echo '<form method="post" action="">
            <label for="title">Nom du jeu</label>
            <input type="text" name="title" id="title" placeholder="Nom du jeu..." value="'.$game['title'].'"/>
            <label for="platform">Plateforme de jeu</label>
            <select name="platform" id="platform">
            <option value="">Plateforme...</option>';
            foreach ($platforms as $platform) {
                $selected = ($game['platform'] == $platform) ? "selected" : "";
                echo '<option value="'.$platform.'" '.$selected.' >'.$platform.'</option>';
            }
            echo '</select>
            <label for="genre">Type de jeu</label>
            <input type="text" name="genre" id="genre" placeholder="Type de jeu (RPG, Roguelike...)" value="'.$game['genre'].'"/>
            <label for="release_year">Année de sortie</label>
            <input type="number" name="release_year" id="release_year" placeholder="Année de sortie" min="1900" max="2050" value="'.$game['release_year'].'"/>
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" placeholder="Prix" min="0" step="0.01" value="'.$game['price'].'"/>
            <div classname="checkbox_div">
                <input type="checkbox" name="is_completed" id="is_completed" '.$is_finished.'/>
                <label for="is_completed">Terminé</label>
            </div>
            <label for="rating">Note /5</label>
            <input type="number" name="rating" id="rating" placeholder="Note /5" min="0" max="5" step="0.5" value="'.$game['rating'].'"/>
            <label for="purchase_date">Date d\'achat :</label>
            <input type="date" name="purchase_date" id="purchase_date" placeholder="Date d\'achat" value="'.$game['purchase_date'].'"/>
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" placeholder="Notes...">'.$game['notes'].'</textarea>
            <input type="submit" value="Valider mes modifications"/>
        </form>';
        } ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>