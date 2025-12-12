// disables annoying box around maths formulas, but only in the section creation page
// so it doesn't get in the way of creation, but it stills show up when doing the exercises

window.MathJax = {
    options: {
        menuOptions: {
            settings: {
                enrich: false
            }
        }
    }
};

let symbolsArray = ["lt", "gt", "le", "leq", "ge", "geq", "neq", "forall", "exists", "nexists", "simeq", "times", "div", "cup", "cap",
                    "setminus", "subset", "subseteq", "subsetneq", "supset", "in", "notin", "notin", "emptyset", "varnothing", "Rightarrow", 
                    "Leftarrow", "Leftrightarrow", "mapsto", "infty"];

let lettersArray = ["alpha", "beta", "chi", "delta", "epsilon", "eta", "gamma", "iota", "kappa", "lambda", "mu", "nu", "omega", "phi", "pi",
                    "psi", "rho", "sigma", "tau", "theta", "upsilon", "xi", "zeta"];

let latexArray = ["\(", "\)"];


class ElementsBtn {
    constructor(btnId, displayDiv, dataArray, prefix="\\", suffix="") {
        this.btn = document.getElementById(btnId);
        this.displayDiv = document.getElementById(displayDiv);
        this.addElementsBtnActivated = false;
        this.dataArray = dataArray;
        this.prefix = prefix;
        this.suffix = suffix;

        this.btn.addEventListener("click", ()=>this.addElements());
    }

    addElements() {
        if (this.addElementsBtnActivated == false) {
            let div = document.createElement("div");
            div.setAttribute("id", "add-elements-div");
            div.style.display = "flex";
            div.style.flexDirection = "row";
            div.style.flexWrap = "wrap";

            addSymbolSection(div, this.dataArray, this.prefix, this.suffix);
            
            reloadMathJax(div);

            this.displayDiv.appendChild(div);

            this.addElementsBtnActivated = true;
        } else {
            let div = document.getElementById("add-elements-div");
            div.remove();

            this.addElementsBtnActivated = false;
        }
    }
}


addSymbolsElementsBtn = new ElementsBtn("add-symbol", "chapter-creation-aside-2", symbolsArray);
addLettersElementsBtn = new ElementsBtn("add-letter", "chapter-creation-aside-2", lettersArray);
addLatexElementsBtn = new ElementsBtn("add-latex", "chapter-creation-aside-2", latexArray);

function reloadMathJax(elem) {
    MathJax.typeset([elem]);
    MathJax.startup.document.render(elem);
}

function addSymbolSection(div, array, prefix="", suffix="") {
    for (let i = 0; i < array.length; i++) {
        let btn = document.createElement("button");
        
        // adds symbol inside the button
        btn.appendChild(document.createTextNode("\\(\\".concat(array[i], "\\)")));
        
        // adds symbol to clipboard when btn is clicked
        btn.addEventListener("click", ()=>navigator.clipboard.writeText(prefix.concat(array[i], suffix)));
        div.appendChild(btn);
    }
}