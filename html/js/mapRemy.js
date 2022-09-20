let caseDeLaTabletab = [];
let largeurCase;
let largeurGrille;
let hauteurGrille;
let deplacementPossible;
let posX;
let posY;
let mouX;
let mouY;

// Redimensionnement de la page
function tailleTable(x,y) {
  // On récupère la largeur et la hauteur de l'écran
  let width = $(window).width();
  let height = $(window).height();
  height -= 200;

  // On calcul la largeur et la hauteur maxi d'une case
  let maxCaseHeight = height / x;
  let maxCaseWidth = width / y;

  // la hauteur et la largeur doivent être identiques, donc on récupère le minimum -2 
  let maxCaseSize = Math.ceil(Math.min(maxCaseHeight, maxCaseWidth)) - 2;
  largeurCase= maxCaseSize;

  // La hauteur maximum de du contenant est le
  // produit du nombre de cases en hauteur et de la taille des cases
  height = x * maxCaseSize;

  // La largeur maximum de lu contenant est le
  // produit du nombre de cases en largeur et de la taille des cases
  width = y * maxCaseSize;
  largeurGrille=width;
  hauteurGrille=height;
  $("#contenant").css("width", width);
  $("#contenant").css("height", height);
  $("#personnage").css("width", largeurCase);
  $("#mouche").css("width", largeurCase);
  $("#personnage").css("left", posX*maxCaseSize);
  $("#personnage").css("top", posY*maxCaseSize);
  $("#mouche").css("left", mouX*maxCaseSize);
  $("#mouche").css("top", mouY*maxCaseSize);
}

function genereTable(x, y) {
  tailleTable(x,y);
  let contenant = $("#contenant"); // Version JQuery et inutile de le faire à chaque boucle
  let caseDeLaTable; // On crée la variable qui contiendra chaque case
  for (let i = 0; i < x; i++) {
    for (let j = 0; j < y; j++) {
      //tableMap.push([i, j]);
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

  // on indique la route à suivre pour arriver à la fin
  let route = [{x:0,y:4},{x:1,y:0},{x:1,y:1},{x:1,y:2},{x:1,y:4},{x:2,y:0},{x:2,y:2},{x:2,y:3},{x:2,y:4},
    {x:3,y:0},{x:3,y:1},{x:4,y:1},{x:4,y:2},{x:5,y:2},{x:5,y:3},{x:6,y:2},{x:7,y:2}];

tracerRoute(route);

// on indique les obstacles et on les place dans la map

let obstacles = [
  {x:6,y:3,color:"yellow"},
  {x:3,y:1,color:"yellow"},
  {x:2,y:2,color:"yellow"},
  {x:1,y:1,color:"yellow"},
  {x:6,y:2,color:"blue"},
  {x:5,y:2,color:"blue"},
  {x:2,y:1,color:"blue"},
  {x:1,y:3,color:"blue"},
  {x:0,y:4,color:"blue"},
];

placerObstacles(obstacles);
}

$(window).resize(function () {
  tailleTable(8,5); // On ne code pas ici le redimensionnement pour éviter la redondance (appel aussi au chargement de la page)
});

genereTable(8, 5);
posDepart(3, 7);
posArrivee(0, 3);

function posDepart(n, m) { // KK Positionne le Cameleon au debut du jeu
  posX=n;
  posY=m;
  let imageStart = "./img/start.png"
    $("#personnage").css("left", n * largeurCase);
    $("#personnage").css("top", m * largeurCase);
    $(`#case_${m}_${n}`).css("background", "grey");
    $(`#case_${m}_${n}`).css("background-image", "url(" + imageStart + ")");
    $(`#case_${m}_${n}`).css("background-size", "contain");
    $(`#case_${m}_${n}`).css("visibility", "visible");
    $(`#case_${m}_${n}`).attr("class", "caseColored route");
};

function posArrivee(z, w) {
  mouX=w;
  mouY=z;
  $("#mouche").css("left", w * largeurCase);
  $("#mouche").css("top", z * largeurCase);
  $(`#case_${z}_${w}`).css("background", "grey");
  $(`#case_${z}_${w}`).css("visibility", "visible");
  $(`#case_${z}_${w}`).attr("class", "caseColored route");
};

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

function droite() {
  let positionX = parseInt($("#personnage").css("left"));
  let positionY = parseInt($("#personnage").css("top"));
  let x = positionX / largeurCase;
  let y = positionY / largeurCase;
  deplacementPossible=false;
  if (positionX + largeurCase < largeurGrille) {
      if ($(`#case_${y}_${x}`).css("background-color") == $(`#case_${y}_${x+1}`).css("background-color")) {
          deplacementPossible=true;
          $("#personnage").css("left", "+=" + largeurCase);
          posX++;
      }
  }
//  listeSaisieAction.push("Droite"); // KK ajout ds la liste ds le tableau de deplacement
}

function gauche() {
  let positionX = parseInt($("#personnage").css("left"));
  let positionY = parseInt($("#personnage").css("top"));
  let x = positionX / largeurCase;
  let y = positionY / largeurCase;
  deplacementPossible=false;
  if (positionX > 0) {
      if ($(`#case_${y}_${x}`).css("background-color") == $(`#case_${y}_${x-1}`).css("background-color")) {
          $("#personnage").css("left", "-=" + largeurCase);
          deplacementPossible=true;
          posX--;
      }
  }
 // listeSaisieAction.push("Gauche"); // KK ajout ds la liste ds le tableau de deplacement
}

function haut() {
  let positionX = parseInt($("#personnage").css("left"));
  let positionY = parseInt($("#personnage").css("top"));
  let x = positionX / largeurCase;
  let y = positionY / largeurCase;
  deplacementPossible=false;
  if (positionY > 0) {
      if ($(`#case_${y-1}_${x}`).css("background-color") == $(`#case_${y}_${x}`).css("background-color")) {
          $("#personnage").css("top", "-=" + largeurCase);
          deplacementPossible=true;
          posY--;
      }
  }
 // listeSaisieAction.push("Haut"); // KK ajout ds la liste ds le tableau de deplacement
}

function bas() {
  let positionX = parseInt($("#personnage").css("left"));
  let positionY = parseInt($("#personnage").css("top"));
  let x = positionX / largeurCase;
  let y = positionY / largeurCase;
  deplacementPossible=false;

  if (positionY + largeurCase < hauteurGrille) {
      if ($(`#case_${y+1}_${x}`).css("background-color") == $(`#case_${y}_${x}`).css("background-color")) {
          $("#personnage").css("top", "+=" + largeurCase);
          deplacementPossible=true;
          posY++;
      }
  }
 // listeSaisieAction.push("Bas"); // KK ajout ds la liste ds le tableau de deplacement
}


function changeColor(color) {
  $(".route").css("background", color);
}

function collision() {
  $("#contenant").css("animation", "shake 1s");
setTimeout(collision2, 1100);
}

function collision2() {
 $("#personnage").attr("src", "img/bang.png");	
}

let listeSaisieAction = [{ command: 'gauche' }, { command: 'color', color: 'blue' },
{ command: 'haut' }, { command: 'haut' }, { command: 'haut' }, { command: 'gauche' },
{ command: 'color', color: 'yellow' }, { command: 'haut' }, { command: 'gauche' }, { command: 'haut' },
{ command: 'haut' }, { command: 'droite' }, { command: 'droite' }, { command: 'bas' },
{ command: 'droite' }, { command: 'droite' }, { command: 'haut' }, { command: 'color', color: 'blue' },
{ command: 'haut' }, { command: 'gauche' }, { command: 'fin' }
];

function tester(step){
    console.log(listeSaisieAction[step]);
    if(step<listeSaisieAction.length) {
        switch(listeSaisieAction[step].command) {
            case 'gauche': 
                gauche();
                break;
            case 'droite': 
                droite();
                break;
            case 'haut': 
                haut();
                break;
            case 'bas': 
                bas();
                break;
            case 'color':
                changeColor(listeSaisieAction[step].color);
                break;
        }
        if(deplacementPossible || step==0) {
          if (posX === mouX && posY === mouY) {
            $("#mouche").css({'transform' : 'rotate('+ -90 +'deg)'});
            $("#mouche").css("left", "-100px");
            $("#mouche").css("top", "300px");
        }
        setTimeout(`tester(${(step+1)})`, 1000);
        }
        else {
            collision();
        }
    }
}

deplacementPossible=true;

// définitions des variables
let bestMap = [16];
let rangOr = bestMap[0];
let rangArgent = bestMap[0] + 2;
let rangBronze = bestMap[0] + 4;
let medals = ["Or", 0, "Argent", 0, "Bronze", 0];

let action = listeSaisieAction.length;
// console.log(medals);
test = document.getElementById("submit");
test.addEventListener('click', result);

// fonction de départ de la comparaison
function result() {
    if (posX === mouX && posY === mouY) {
        compare();
    } else {
        // alert('DEBOUT!!!');
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

    // console.log(medals);
    affiche();
}

function affiche() {
    $('#or').text(" " + medals[1]);
    $('#argent').text(" " + medals[3]);
    $('#bronze').text(" " + medals[5]);
}