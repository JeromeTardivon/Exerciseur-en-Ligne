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

            // adds symbol inside the button
            btn.appendChild(document.createTextNode("\\(\\".concat(symbolsArray[i], "\\)")));

            // adds symbol to clipboard when btn is clicked
            btn.addEventListener("click", ()=>navigator.clipboard.writeText("\\(\\".concat(symbolsArray[i], "\\)")));
            div.appendChild(btn);

            // forces jax to render the symbols inside the div
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