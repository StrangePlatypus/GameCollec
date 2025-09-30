<?php

require_once 'config.php';

// Récupération du nombre de jeux par plateforme
$sql_platforms = "SELECT platform, count(*) AS count FROM games GROUP BY platform";
$stmt_platforms = $pdo->query($sql_platforms);
$platforms = $stmt_platforms->fetchAll(PDO::FETCH_ASSOC);

// Calcul du prix total de la collection
$sql_price = "SELECT SUM(price) AS total_price FROM games";
$stmt_price = $pdo->query($sql_price);
$price_result = $stmt_price->fetch(PDO::FETCH_ASSOC);
$total_price = (float) $price_result['total_price'];


// Calcul du pourcentage de jeux terminés
$sql_percentage = "SELECT AVG(is_completed) * 100 AS percent_completed FROM games";
$stmt_percentage = $pdo->query($sql_percentage);
$percentage_result = $stmt_percentage->fetch(PDO::FETCH_ASSOC);

// Calcul du top 3 des genres les plus représentés
$sql_genre = "SELECT genre, count(*) AS nb FROM games GROUP BY genre ORDER BY nb DESC LIMIT 3";
$stmt_genre = $pdo->query($sql_genre);
$genre = $stmt_genre->fetchAll(PDO::FETCH_ASSOC);

// Jeu le moins cher et le plus cher
$sql_min = "SELECT title, price FROM games WHERE Price = (SELECT MIN(price) FROM games)";
$stmt_min = $pdo->query($sql_min);
$cheapest = $stmt_min->fetch(PDO::FETCH_ASSOC);

$sql_max = "SELECT title, price FROM games WHERE Price = (SELECT MAX(price) FROM games)";
$stmt_max = $pdo->query($sql_max);
$expensive = $stmt_max->fetch(PDO::FETCH_ASSOC);

// Calcul de la moyenne des notes attribuées
$sql_avg = "SELECT AVG(rating) AS average_rating FROM games";
$stmt_avg = $pdo->query($sql_avg);
$avg = $stmt_avg->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php require_once 'header.php'; ?>
    <main>
        <h2>Quelques chiffres</h2>
        <p>Nombre de jeux par plateforme</p>
        <table id="per_platform">
            <thead><tr><th>Plateforme</th><th>Nombre de jeux</th></tr></thead>
            <?php foreach ($platforms as $row) {
                echo "<tr><td>".$row['platform']."</td><td>".$row['count']."</td></tr>";
            } ?>
        </table>
        <div style="width: 100%">
            <p>Au total, votre collection coûte <?php echo $total_price ?>€.</p>
            <p>Vous avez terminé <?php echo round($percentage_result['percent_completed'], 2) ?>% des jeux.</p>
            <p>Top 3 des genres auxquels vous jouez le plus :</p>
            <ul><?php foreach ($genre as $row) {
                echo"<li>".$row['genre']."</li>";
            } ?></ul>
            <p>Votre jeu le plus cher est <?php echo $expensive['title']." (".$expensive['price']."€)." ?></p>
            <p>Votre jeu le moins cher est <?php echo $cheapest['title']." (".$cheapest['price']."€)." ?></p>
            <p>Vos jeux ont en moyenne une note de <?php echo round($avg['average_rating'], 2)."/5." ?></p>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
