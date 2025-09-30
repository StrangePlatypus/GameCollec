<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercices base de données</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <?php require_once "header.php"; ?>
    <main>
        <h1>
            Bienvenue sur GameCollec
        </h1>
        <a href="list_games.php">Accédez à votre liste de jeux</a>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

<style>
    main{
        display: flex;
        flex-direction: column;
        width: fit-content;
        margin: auto;
        align-items: center;
    }

    h1{
        color: #4CAF50;
    }

    a{
        text-decoration: none;
        color: #4CAF50;
    }

    a:hover{
        color: #226624ff;
    }
</style>
