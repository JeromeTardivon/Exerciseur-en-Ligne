let addElementsBtn = document.getElementById("add-symbol");
let aside = document.getElementById("chapter-creation-aside-2");
let addElementsBtnActivated = false;

addElementsBtn.addEventListener("click", addMathsElements);

function addMathsElements() {
    MathJax.startup.document.render();
    if (!addElementsBtnActivated) {
        let div = document.createElement("div");
        div.setAttribute("id", "add-elements-div");
        div.style.display = "flex";
        div.style.flexDirection = "row";
        div.style.flexWrap = "wrap";

        let symbolsArray = [];
        symbolsArray.push("lt", "gt", "le", "leq", "ge", "geq", "neq", "forall", "exists", "nexists", "simeq", "times", "div", "cup", "cap",
                          "setminus", "subset", "subseteq", "subsetneq", "supset", "in", "notin", "notin", "emptyset", "varnothing", "Rightarrow", 
                          "Leftarrow", "Leftrightarrow", "mapsto", "infty");

        for (let i = 0; i < symbolsArray.length; i++) {
            let btn = document.createElement("button");

            btn.appendChild(document.createTextNode("\\(\\".concat(symbolsArray[i], "\\)")));
            btn.addEventListener("click", insertElement);
            div.appendChild(btn);

            MathJax.typeset([div]);
            MathJax.startup.document.render(div);
        }
        aside.appendChild(div);

        addElementsBtnActivated = true;
        // reload();
    } else {
        let div = document.getElementById("add-elements-div");
        div.remove();

        addElementsBtnActivated = false;
    }
}

function insertElement() {

}