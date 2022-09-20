// Choix des déplacements
function moves() {
    let moveButton = document.getElementById("item2");
    let selectRepeat = document.createElement("select");
    let selectMove = document.createElement("select");
    selectRepeat.className="repeat";
    selectMove.className="oneMove";
    moveButton.draggable = "true";
 
    // On définit le nombre de répétitions possible
    for(i=1; i<5; i++) {
        let opt = document.createElement("option");
        opt.value = i;
        opt.text = " Répéter " + i + " fois";
        selectRepeat.append(opt);
    }

    // On définit les options de déplacement possibles
    let optList = [
        {"sens": "haut", "car": "↑"},
        {"sens": "bas", "car": "↓"},
        {"sens": "gauche", "car": "←"},
        {"sens": "droite", "car": "→"}
    ]
    
    for(let i=0; i<optList.length; i++)
    {
        let opt = document.createElement("option");
        opt.value = optList[i]["sens"];
        opt.text  = optList[i]["car"];
        selectMove.append(opt);
    }
    moveButton.appendChild(selectRepeat);
    moveButton.appendChild(selectMove);
    moveButton.title="moves"; 
}

function color() {
    let optList = ["blue", "yellow"];
    item1 = document.getElementById("item1");
    item1.draggable = "true";
    let selectColor = document.createElement("select");
    selectColor.className="colorsList";
    selectColor.style.width="100px";
    item1.appendChild(selectColor);
    for(let i=0; i<optList.length; i++) {
        let opt = document.createElement("option");
        opt.value = optList[i];
        opt.text = optList[i];
        selectColor.append(opt);
    }
    item1.title="color";
}
/* Début du drag and Drop ! */

function dragStart(event) {
    event.dataTransfer.dropEffect = "copy";
    event.dataTransfer.setData("text", event.target.id);
}

function dragover(event) {
    event.currentTarget.className = "dragBorder";
    event.preventDefault();
}

/* Déplacer l'element */
let cloneCount = 1;
function dragDrop(event) {
    event.currentTarget.className = "dragBorderDefault";
    ob = event.dataTransfer.getData("text");
    obCopy = document.getElementById(ob).cloneNode(true);
    event.currentTarget.appendChild(obCopy); /* Attention ici d'utiliser le currentTarget au lieu de Target car si on le fait sa va mettre dans l'element la possibilité de remttre un element a l'interieur a l'infinie */
    event.stopPropagation();
    event.preventDefault();
    obCopy.id = `cloneItem${cloneCount}`;
    idObCopy = document.getElementById(`cloneItem${cloneCount}`);
    idObCopy.className = "noselect";
    idObCopy.draggable = false;
    newButton = document.createElement("button");
    newButton.setAttribute("onclick", `remove("${obCopy.id}")`); /* Syntaxe pour appeler une variable dans un param string */
    newButton.textContent = "X";
    newButton.style.background = "black";
    newButton.style.color = "white";
    obCopy.appendChild(newButton);
    cloneCount += 1;
}

function remove(id) {
    document.getElementById(id).remove();
}

function dragLeave(event) {
    event.currentTarget.className = "dragBorderDefault";
}
/* Fin du Drag and Drop */


function checkDrop() {
    drop1 = document.getElementById("drop1");
    listeSaisieActions =[];
    for (i = 0; i < drop1.children.length; i++) {
        cloneItem = drop1.children[i];
        let action=cloneItem.title;
        switch(action) {
            case "color": 
                let colorsList = cloneItem.getElementsByClassName("colorsList")[0];
                let color=colorsList.options[colorsList.selectedIndex].value;
                let tableElement={'command': 'color', 'color': `${color}`};
                listeSaisieActions.push(tableElement);
                break;

            case "moves":
                let repeat = cloneItem.getElementsByClassName("repeat")[0];
                let number=repeat.options[repeat.selectedIndex].value;
                let oneMove = cloneItem.getElementsByClassName("oneMove")[0];
                let move=oneMove.options[oneMove.selectedIndex].value;
                for(let i=0; i<number; i++) {
                    let tableElement={'command' :`${move}`};
                    listeSaisieActions.push(tableElement);
                }
            break;
        }
    }
    console.log(listeSaisieActions);
}

/* Déroulement de la partie */
function gameProgress() {
    color();
    moves();
}