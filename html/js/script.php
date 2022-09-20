<?php include "../../init.php"; ?>
let caseDeLaTabletab = [];
let largeurCase;
let largeurGrille;
let hauteurGrille;
let listeSaisieActions = [];
let deplacementPossible;
let posX;
let posY;
let mouX;
let mouY;
let obstacles;
let route;

// Redimensionnement de la page
function tailleTable(x, y) {
    // On récupère la largeur et la hauteur de l'écran
    let width = $(window).width();
    let height = $(window).height();
    height -= 200;

    // On calcul la largeur et la hauteur maxi d'une case
    let maxCaseHeight = height / x;
    let maxCaseWidth = width / y;

    // la hauteur et la largeur doivent être identiques, donc on récupère le minimum -2 
    let maxCaseSize = Math.ceil(Math.min(maxCaseHeight, maxCaseWidth)) - 2;
    largeurCase = maxCaseSize;

    // La hauteur maximum de du contenant est le
    // produit du nombre de cases en hauteur et de la taille des cases
    height = x * maxCaseSize;

    // La largeur maximum de lu contenant est le
    // produit du nombre de cases en largeur et de la taille des cases
    width = y * maxCaseSize;
    largeurGrille = width;
    hauteurGrille = height;
    $("#contenant").css("width", width);
    $("#contenant").css("height", height);
    $("#personnage").css("width", largeurCase);
    $("#personnage").css("left", posX * maxCaseSize);
    $("#personnage").css("top", posY * maxCaseSize);
    $("#mouche").css("left", mouX * maxCaseSize);
    $("#mouche").css("top", mouY * maxCaseSize);
    $("#mouche").css("width", largeurCase);
}

function genereTable(x, y) {
    tailleTable(x, y);
    let contenant = $("#contenant"); // Version JQuery et inutile de le faire à chaque boucle
    let caseDeLaTable; // On crée la variable qui contiendra chaque case
    for (let i = 0; i < x; i++) {
        for (let j = 0; j < y; j++) {
            caseDeLaTable = $("<div></div>"); // Version JQuery
            contenant.append(caseDeLaTable);
            caseDeLaTable.attr("id", `case_${i}_${j}`); // Version JQuery, attibution de l'id
            caseDeLaTable.attr("grid-area", `gri_${i}_${j}`); // Version JQuery
            caseDeLaTable.attr("class", "caseColored"); // Version JQuery
            caseDeLaTabletab.push(caseDeLaTable);
        }
    }

    contenant.css("background", "#3b7a19"); // Version JQuery
    contenant.css("display", "grid"); //Version JQuery
    contenant.css("gridTemplateRows", `repeat(${x}, 0.5fr)`); // Version JQuery
    contenant.css("gridTemplateColumns", `repeat(${y}, 0.5fr)`); // Version JQuery

    // Simplifions le code et rendons le plus paramétrable
    let gridTemplateareas = "";
    let nbrCells = x * y;

    for (let i = 0; i <= nbrCells; i++) {
        gridTemplateareas += `gri${i} `;
    }
    contenant.css("gridTemplateareas", gridTemplateareas); // Version JQuery

    // Simplifions le code pour définir le chemin
    <?php
        echo "route=" . json_encode($route) . ";";
    ?>

    // Simplifions le code pour placer les obstacles
    obstacles = <?php echo json_encode($obstacles); ?>;
    tracerRoute(route);
    placerObstacles(obstacles);
}

function tracerRoute(casesRoute) {
    casesRoute.forEach(function(cell) {
        $(`#case_${cell.x}_${cell.y}`).css("background", "grey");
        $(`#case_${cell.x}_${cell.y}`).css("visibility", "visible");
        $(`#case_${cell.x}_${cell.y}`).attr("class", "caseColored route");
    });
}

function placerObstacles(listeObstacles) {
    listeObstacles.forEach(function(cell) {
        $(`#case_${cell.x}_${cell.y}`).css("background", cell.color);
        $(`#case_${cell.x}_${cell.y}`).css("visibility", "visible");
        $(`#case_${cell.x}_${cell.y}`).attr("class", "caseColored obstacle");
    });
}

function changeColor(color, x, y) {
    $(".route").css("background", color);
    let positionX = parseInt($("#personnage").css("left"));
    let positionY = parseInt($("#personnage").css("top"));
    posX = positionX / largeurCase;
    posY = positionY / largeurCase;
    $(`#case_${posX}_${posX}`).css("background", color);
}

$(window).resize(function() {
    tailleTable(8, 5); // On ne code pas ici le redimensionnement pour éviter la redondance 
    //(appel aussi au chargement de la page)
});


function posDepart(x, y) { // KK Positionne le Cameleon au debut du jeu
    posX = x;
    posY = y;
    $("#personnage").css("left", x * largeurCase);
    $("#personnage").css("top", y * largeurCase);
    $(`#case_${y}_${x}`).css("background", "grey");
    $(`#case_${y}_${x}`).css("visibility", "visible");
    $(`#case_${y}_${x}`).attr("class", "caseColored route");

};

function posArrivee(x, y) { // KK Positionne le Cameleon au debut du jeu
    mouX = x;
    mouY = y;
    $("#mouche").css("left", x * largeurCase);
    $("#mouche").css("top", y * largeurCase);
    $(`#case_${y}_${x}`).css("background", "grey");
    $(`#case_${y}_${x}`).css("visibility", "visible");
    $(`#case_${y}_${x}`).attr("class", "caseColored route");

};


function droite() {
    let positionX = parseInt($("#personnage").css("left"));
    let positionY = parseInt($("#personnage").css("top"));
    posX = positionX / largeurCase;
    posY = positionY / largeurCase;
    deplacementPossible = false;
    if (positionX + largeurCase < largeurGrille) {
        if ($(`#case_${posY}_${posX}`).css("background-color") == $(`#case_${posY}_${posX+1}`).css("background-color")) {
            deplacementPossible = true;
            $("#personnage").css("left", "+=" + largeurCase);
            posX++;
            $("#personnage").css("transform", "rotate(0deg)");
        }
    }
}

function gauche() {
    let positionX = parseInt($("#personnage").css("left"));
    let positionY = parseInt($("#personnage").css("top"));
    posX = positionX / largeurCase;
    posY = positionY / largeurCase;
    deplacementPossible = false;
    if (positionX > 0) {
        if ($(`#case_${posY}_${posX}`).css("background-color") == $(`#case_${posY}_${posX-1}`).css("background-color")) {
            $("#personnage").css("left", "-=" + largeurCase);
            deplacementPossible = true;
            posX--;
            $("#personnage").css("transform", "scaleX(-1)");
        }
    }
}

function haut() {
    let positionX = parseInt($("#personnage").css("left"));
    let positionY = parseInt($("#personnage").css("top"));
    posX = positionX / largeurCase;
    posY = positionY / largeurCase;
    deplacementPossible = false;
    if (positionY > 0) {
        if ($(`#case_${posY-1}_${posX}`).css("background-color") == $(`#case_${posY}_${posX}`).css("background-color")) {
            $("#personnage").css("top", "-=" + largeurCase);
            deplacementPossible = true;
            posY--;
            $("#personnage").css("transform", "rotate(-90deg)");
        }
    }
    // listeSaisieActions.push("Haut"); // KK ajout ds la liste ds le tableau de deplacement
}

function bas() {
    let positionX = parseInt($("#personnage").css("left"));
    let positionY = parseInt($("#personnage").css("top"));
    posX = positionX / largeurCase;
    posY = positionY / largeurCase;
    $("#personnage").css("transform", "scaleX(-1)");
    deplacementPossible = false;
    if (positionY + largeurCase < hauteurGrille) {
        if ($(`#case_${posY+1}_${posX}`).css("background-color") == $(`#case_${posY}_${posX}`).css("background-color")) {
            $("#personnage").css("top", "+=" + largeurCase);
            deplacementPossible = true;
            posY++;
            $("#personnage").css("transform", "rotate(90deg)");
        }
    }
}

listeSaisieActions = [{ command: 'gauche' }, { command: 'color', color: 'blue' },
    { command: 'haut' }, { command: 'haut' }, { command: 'haut' }, { command: 'gauche' },
    { command: 'color', color: 'yellow' }, { command: 'haut' }, { command: 'gauche' }, { command: 'haut' },
    { command: 'haut' }, 
    { command: 'droite' },   
    { command: 'color', color: 'blue' }, 
    { command: 'droite' }, 
    { command: 'color', color: 'blue' },
    { command: 'bas' },
    { command: 'color', color: 'yellow' }, 
    { command: 'droite' }, { command: 'droite' }, { command: 'haut' }, { command: 'color', color: 'blue' },
    { command: 'haut' }, { command: 'gauche' }, { command: 'fin' }
];

function collision() {
    $("#contenant").css("animation", "shake 0.5s");
    setTimeout("collision2()", 1100);
}

function collision2() {
    placerObstacles(obstacles);
    $("#personnage").css("transform", "rotate(0deg)");
    $("#personnage").attr("src", "img/bang.png");
}


function init() {
    genereTable(8, 5);
    posDepart(3, 7); // Appel fonction qui positionne le Cameleon (abscise, ordonnée) au debut du jeu 
    posArrivee(3, 0);
    test = document.getElementById("submit");
    test.addEventListener("click", lancer);  
    gameProgress();
}

function lancer() {
    avancer(0);
}

function avancer(step) {
    // tailleTable(8, 5);
    
    console.log(listeSaisieActions[step]);
    if (step < listeSaisieActions.length) {
        switch (listeSaisieActions[step].command) {
            case 'gauche':
                gauche();
                placerObstacles(obstacles);
                break;
            case 'droite':
                droite();
                placerObstacles(obstacles);
                break;
            case 'haut':
                haut();
                placerObstacles(obstacles);
                break;
            case 'bas':
                bas();
                placerObstacles(obstacles);
                break;
            case 'color':
                changeColor(listeSaisieActions[step].color);
                break;
            case 'fin':
                result();
                break;
        }
        if (deplacementPossible || step == 0) {
            if (posX === mouX && posY === mouY) {
                $("#mouche").css({ 'transform': 'rotate(' + -90 + 'deg)' });
                $("#mouche").css("left", "-100px");
                $("#mouche").css("top", "300px");
            }
            setTimeout(`avancer(${(step+1)})`, 1000);
        } else {
            collision();
        }
    }
}

deplacementPossible = true;

let bestMap = [16];
let rangOr = bestMap[0];
let rangArgent = bestMap[0] + 1;
let rangBronze = bestMap[0] + 2;
let medals = ["Or", 0, "Argent", 0, "Bronze", 0];
let action = listeSaisieActions.length;


// fonction de départ de la comparaison
function result() {
    if (posX === mouX && posY === mouY) {
        compare();
    } else {
        alert('DEBOUT!!!');
    }
}

// comparaison des tableaux
function compare() {
    switch (action) {
        case rangOr:
            medals[1]++;
            alert("Médaille d'or!!!");
            break;
        case rangArgent:
            medals[3]++;
            alert("Médaille d'argent!!");
            break;
        case rangBronze:
            medals[5]++;
            alert("Médaille de bronze!");
            break;
    }
    affiche();
}

function affiche() {
    $('#or').text(" " + medals[1]);
    $('#argent').text(" " + medals[3]);
    $('#bronze').text(" " + medals[5]);
}