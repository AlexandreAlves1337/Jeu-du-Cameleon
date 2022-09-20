<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/script.php"></script>
    <title>Document</title>
</head>
<body onload="init()">
    <div id="contenant"></div>
    <img id="personnage" src="img/cameleonModifier.png">
    <img id="mouche" src="img/mouche.png">
    <div id="control">
        <button onclick="droite();" id="droite"> Droite</button>
        <button onclick="gauche();" id="gauche"> Gauche</button>
        <button onclick="haut();" id="avancer"> Haut</button>
        <button onclick="bas();" id="reculer">Bas</button>
    </div>
    <button id="submit">Soumettre</button>
    <section id="medailles">
        <div>Médailles d'Or =<span id="or"></span></div>
        <div>Médailles d'Argent =<span id="argent"></span> </div>
        <div>Médailles de Bronze =<span id="bronze"></span></div>
    </section>
<div id="commandes">
    <div id="moveButton"></div>
    <div class="dragAndDrop">
        <div id="drag1" class="dragBorderDefault" class="selectOption" ondragstart="dragStart(event)"  ondragleave="dragLeave(event)">
            <div id="item1"></div>
            <div id="item2"></div>
        </div> 
        <div id="drop1" class="dragBorderDefault" class="selectOption" ondragstart="dragStart(event)" ondragover="dragover(event)" ondrop="dragDrop(event)" ondragleave="dragLeave(event)">
            
        </div>
        <button class="valide" onclick="checkDrop()">VALIDER</button>
        </div>
    </div>
    <ul id="mapGrid"></ul>
</div>
    <script src="./js/milwork.js"></script>
</body>
</html>