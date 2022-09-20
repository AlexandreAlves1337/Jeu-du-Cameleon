<?php 
    header("Content-type: application/javascript"); 
    // Définition de la table des couleurs possibles
    $tabcolor=["yellow", "blue"];

    // Initialisation du tableau des obstacles
    $obstacles = [];

    // Création du tableau de la route
    $route = [
        [ "x" => 0, "y" => 4 ], [ "x" => 1, "y" => 0 ], [ "x" => 1, "y" => 1 ], 
        [ "x" => 1, "y" => 2 ], [ "x" => 1, "y" => 4 ], [ "x" => 2, "y" => 0 ], 
        [ "x" => 2, "y" => 2 ], [ "x" => 2, "y" => 3 ], [ "x" => 2, "y" => 4 ],
        [ "x" => 3, "y" => 0 ], [ "x" => 3, "y" => 1 ], [ "x" => 4, "y" => 1 ], 
        [ "x" => 4, "y" => 2 ], [ "x" => 5, "y" => 2 ], [ "x" => 5, "y" => 3 ], 
        [ "x" => 6, "y" => 2 ], [ "x" => 7, "y" => 2 ]
    ];

    // On veut ajouter 5 obstacles
    $nbrObstacles = 5;

    $numerosObstacles = array_rand($route, $nbrObstacles);
    for($i=0; $i<$nbrObstacles; $i++) {
        $obstacles[$i]=$route[$numerosObstacles[$i]];
        $obstacles[$i]["color"]=$tabcolor[random_int(0, sizeof($tabcolor)-1)];
    }

    // On veut ajouter 5 obstacles
    /*
    for ($i=0; $i<$nbrObstables; $i++) {
        // On tire au hasard la couleur de l'obstacle
        $randomcolor=random_int(0, sizeof($tabcolor)-1);
        $unObstacle["color"]=$tabcolor[$randomcolor];

        // On tire au hasard la position de l'obstacle sur la route
        $randomPosition = random_int(0, sizeof($route)-1);
        $case = $route[$randomPosition];

        // Ou récupère la position sur la route en x et y pour y placer un obstacle
        $unObstacle["x"]=$case["x"];
        $unObstacle["y"]=$case["y"];

        // On ajoute l'obstacle dans la liste
        array_push($obstacles,$unObstacle);

        // On retire l'obstacle de la route prédéfinie
        array_splice($route, $randomPosition, 1);
    }
    */
?>