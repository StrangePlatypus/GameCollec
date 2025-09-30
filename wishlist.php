<?php

require_once 'config.php';

// Récupération de la wishlist
$sql_wishlist = "SELECT * FROM wishlist";
$stmt_wishlist = $pdo->query($sql_wishlist);
$wishlist = $stmt_wishlist->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['buy_id'])){
    // Ajout d'un jeu à la wishlist
    try {
        $params = [
            'title' => $_POST['title'],
            'platform' => $_POST['platform'],
            'expected_price' => $_POST['expected_price'],
            'priority' => $_POST['priority'],
            'notes'  => $_POST['notes']
        ];

        $sql_add = "INSERT INTO wishlist (title, platform, expected_price, priority, notes)
        VALUES (:title, :platform, :expected_price, :priority, :notes)";
        $stmt_add = $pdo->prepare($sql_add);
        $stmt_add->execute($params);

        echo '<script>alert("Le jeu a été ajouté à la wishlist");window.location="dashboard.php"</script>';
    } catch(Exception $e){
        echo 'ERR : '.$e->getMessage();
    }
};

// Gestion du contenu suivant que la wishlist soit vide ou non
$content = empty($wishlist) ? '<p style="width: 100%; text-align: center">Aucun jeu dans la wishlist</p>' : '<table><thead><tr>
        <th scope="col">Titre</th>
        <th scope="col">Plateforme</th>
        <th scope="col">Prix estimé</th>
        <th scope="col">Priorité</th>
        <th scope="col">Notes</th>
        <th scope="col"></th>
        </tr></thead><tbody>';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_id'])){
    // Récupération du jeu concerné
    $id = $_POST['buy_id'];
    $stmt_find_game = $pdo->prepare("SELECT * FROM wishlist WHERE id = :id");
    $stmt_find_game->execute(["id" => $id]);
    $find_game = $stmt_find_game->fetch(PDO::FETCH_ASSOC);

    if($find_game){
        // Ajout du jeu à la collection
        try{

            $params_buy = [
                'title' => $find_game['title'],
                'platform' => $find_game['platform'],
                'genre' => "",
                'release' => date('Y'),
                'price' => $find_game['expected_price'],
                'completed' => null,
                'rating' => null,
                'purchase' => date('Y-m-d'),
                'notes' => $find_game['notes'],
                'created' => date('Y-m-d H:i:s')
            ];
            
            $sql_buy = "INSERT INTO games (title, platform, genre, release_year, price, is_completed, rating, purchase_date, notes, created_at)
            VALUES (:title, :platform, :genre, :release, :price, :completed, :rating, :purchase, :notes, :created)";

            $stmt_buy = $pdo->prepare($sql_buy);
            $stmt_buy->execute($params_buy);
    
            // Après l'ajout du jeu à la collection, il est supprimé de la wishlist
            $stmt_delete = $pdo->prepare("DELETE FROM wishlist WHERE id = :id");
            $stmt_delete->execute(["id" => $id]);

            echo '<script>alert("Le jeu a été ajouté à la collection");window.location="dashboard.php"</script>';
        } catch(Exception $e){
            echo 'ERR : '.$e->getMessage();
        }
    }
};
?>

<h3>Ma wishlist</h3>
<div id="wishlist" style="display: flex; flex-direction: column; gap: 20px; width: 100%">
       <?php echo $content;
        if (!empty($wishlist)){
            foreach ($wishlist as $game) {
                $emoji_platform = "";
                if($game['platform'] == "PC"){
                    $emoji_platform = "💻​";
                } elseif($game['platform'] == "Mobile"){
                    $emoji_platform = "📲​";
                }

                $priority = "";
                switch ($game['priority']) {
                    case '1':
                        $priority = "Pas prioritaire";
                        break;
                    case '2':
                        $priority = "Peut attendre";
                        break;
                    case '3':
                        $priority = "Priorité moyenne";
                        break;
                    case '4':
                        $priority = "Priorité élevée";
                        break;
                    case '5':
                        $priority = "Achat urgent";
                        break;
                    
                    default:
                        $priority = "Priorité non définie";
                        break;
                }
                
                echo '<tr>
                <th>'.$game['title'].'</th>
                <td>'.$game['platform']." ".$emoji_platform.'</td>
                <td>'.$game['expected_price'].'€</td>
                <td>'.$priority.'</td>
                <td>'.$game['notes'].'</td>
                <td><form id="buy_form" method="post" action="">
                <input type="hidden" name="buy_id" id="buy_id" value="'.$game['id'].'"/>
                <input type="submit" name="buy" id="buy" value="Acheter"/>
                </form></td>
                </tr>';
            }
            echo "</tbody></table>";
        }
       ?>

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
        <label for="expected_price">Prix estimé</label>
        <input type="number" name="expected_price" id="expected_price" placeholder="Prix estimé..." min="0" step="0.01"/>
        <label for="priority">Priorité</label>
        <select name="priority" id="priority">
            <option value="">Priorité</option>
            <option value="1">Pas prioritaire</option>
            <option value="2">Peut attendre</option>
            <option value="3">Priorité moyenne</option>
            <option value="4">Priorité élevée</option>
            <option value="5">Achat urgent</option>
        </select>
        <label for="notes">Notes</label>
        <textarea name="notes" id="notes" placeholder="Notes..."></textarea>
        <input type="submit" value="Ajouter à la wishlist">
    </form>
</div>

<script>
    function buyGame(game){
        // code
    }
</script>