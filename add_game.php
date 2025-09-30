<?php

require_once 'config.php';

date_default_timezone_set('Europe/Paris');


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["title"])){
    try{
        $finished = isset($_POST["is_completed"]) ? 1 : 0;
        $createdAt = date('Y-m-d H:i:s');

        $params = [
            'title' => $_POST["title"],
            'platform' => $_POST["platform"],
            'genre' => $_POST["genre"],
            'release' => $_POST['release_year'],
            'price' => $_POST["price"],
            'completed' => $finished,
            'rating' => $_POST["rating"],
            'purchase' => $_POST["purchase_date"],
            'notes' => $_POST["notes"],
            'created' => $createdAt
        ];
        
        $sql = "INSERT INTO games (title, platform, genre, release_year, price, is_completed, rating, purchase_date, notes, created_at)
         VALUES (:title, :platform, :genre, :release, :price, :completed, :rating, :purchase, :notes, :created)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo "Jeu ajouté à la collection";

        $_POST["title"] = "";
        header('Location: add_game.php?m=success');
   
    } catch(Exception $e){
        echo 'ERR : '.$e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter  un jeu</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main>
        <h2>Ajouter un jeu</h2>
        <form method="post" action="">
            <label for="title">Nom du jeu</label>
            <input type="text" name="title" id="title" placeholder="Nom du jeu..."/>
            <label for="platform">Plateforme de jeu</label>
            <select name="platform" id="platform">
                <option value="">Plateforme...</option>
                <option value="PC">PC</option>
                <option value="PlayStation">PlayStation</option>
                <option value="Xbox">Xbox</option>
                <option value="Nintendo Switch">Nintendo Switch</option>
                <option value="SteamDeck">SteamDeck</option>
                <option value="Mobile">Mobile</option>
            </select>
            <label for="genre">Type de jeu</label>
            <input type="text" name="genre" id="genre" placeholder="Type de jeu (RPG, Roguelike...)" />
            <label for="release_year">Année de sortie</label>
            <input type="number" name="release_year" id="release_year" placeholder="Année de sortie" min="1900" max="2050"/>
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" placeholder="Prix" min="0" step="0.01" />
            <div classname="checkbox_div">
                <input type="checkbox" name="is_completed" id="is_completed" />
                <label for="is_completed">Terminé</label>
            </div>
            <label for="rating">Note /5</label>
            <input type="number" name="rating" id="rating" placeholder="Note /5" min="0" max="5" step="0.5" />
            <label for="purchase_date">Date d'achat :</label>
            <input type="date" name="purchase_date" id="purchase_date" placeholder="Date d'achat" />
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" placeholder="Notes..."></textarea>
            <input type="submit" value="Ajouter le jeu"/>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>