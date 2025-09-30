<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $finished = isset($_GET['finished']) ? 1 : null;

    //initialisation 
    $where = [];
    $params = [];

    //traitement de filtres:

    if(!empty($_GET["title"])){
        $where[] = "title LIKE :title";
        $params[":title"] = "%" . $_GET['title'] . "%";
    }

    if(!empty($_GET["platform"])){
        $where[] = "LOWER(platform) LIKE :platform";
        $params[":platform"] = "%" . strtolower($_GET['platform']) . "%";
    }

    if(!empty($_GET["genre"])){
        $where[] = "genre LIKE :genre";
        $params[":genre"] = "%" . $_GET['genre'] . "%";
    }

    if($finished !== null){
        $where[] = "is_completed = 1";
    }

    $sql = "SELECT * from games";

    if(!empty($where)){
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouver un jeu</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main>
        <h2>Trouver un jeu</h2>
        <form method="get">
            <input type="text" placeholder="Titre..." name="title" id="title"/>
            <select name="platform" id="platform">
                <option value="">Plateforme...</option>
                <option value="pc">PC</option>
                <option value="nintendo switch">Nintendo Switch</option>
                <option value="mobile">Mobile</option>
            </select>
            <input type="text" placeholder="Genre..." name="genre" id="genre"/>
            <div>
            <input type="checkbox" name="finished" id="finished"/>
            <label for="finished">Jeux terminés uniquement</label>
            </div>
            <!-- recherche par note minimale (select 1-5) -->
            <input type="submit" value="Rechercher"/>
        </form><br>
        <div><?php if($result){
            echo '<table><thead><tr>
            <th scope="col">Titre</th>
            <th scope="col">Plateforme</th>
            <th scope="col">Genre</th>
            <th scope="col">Note</th>
            <th scope="col">Complété</th>
            </tr></thead><tbody>';
    
            foreach ($result as $game) {
                $completed = $game['is_completed'] ? "Terminé" : "Pas terminé";
    
                $emoji = "";
                if($game['platform'] == "PC"){
                    $emoji = "💻​";
                } elseif($game['platform'] == "Mobile"){
                    $emoji = "📲​";
                }
    
                $color = "red";
                if($game['rating'] >= 4.5){
                    $color = "green";
                }elseif($game['rating'] >= 3){
                    $color = "orange";
                }
    
                $link = "manage_game.php?id=".$game['id'];
                
                echo '<tr>
                <th><a href="'.$link.'">'.$game['title'].' ✏️</a></th>
                <td>'.$game['platform']." ".$emoji.'</td>
                <td>'.$game['genre'].'</td>
                <td style="color:'.$color.'">'.$game['rating'].'/5</td>
                <td>'.$completed.'</td>
                </tr>';
            }
    
            echo "</tbody></table><br>";
        } ?></div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>