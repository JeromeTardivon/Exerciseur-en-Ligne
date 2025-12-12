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

let addElementsBtnArray = [];


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
            div.setAttribute("id", "add-elements-".concat(this.btn.id));
            div.style.display = "flex";
            div.style.flexDirection = "row";
            div.style.flexWrap = "wrap";
            
            addSymbolSection(div, this.dataArray, this.prefix, this.suffix);
            
            reloadMathJax(div);
            
            this.displayDiv.appendChild(div);
            
            this.addElementsBtnActivated = true;
        } else {
            let div = document.getElementById("add-elements-".concat(this.btn.id));
            div.remove();
            
            this.addElementsBtnActivated = false;
        }
    }
}

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

function addElementsBtn(id, btnDiv, symbolsDiv, symbolsArray, innerHtml) {
    let newBtn = document.createElement("button");
    newBtn.setAttribute("id", id);
    newBtn.innerHTML = innerHtml;
    
    let div = document.getElementById(btnDiv);
    div.appendChild(newBtn);
    addElementsBtnArray.push(new ElementsBtn(id, symbolsDiv, symbolsArray));
}

let comparisonArray = ["lt", "gt", "le", "leq", "ge", "geq", "neq", "simeq", "equiv"];

let lettersArray = ["alpha", "beta", "chi", "delta", "epsilon", "eta", "gamma", "iota", "kappa", "lambda", "mu", "nu", "omega", "phi", "pi",
                    "psi", "rho", "sigma", "tau", "theta", "upsilon", "xi", "zeta"];

let latexArray = ["\(", "\)"];

addElementsBtn("add-comparison", "add-symbols-btn", "symbols", comparisonArray, "Symbole de comparaison");
addElementsBtn("add-letter", "add-symbols-btn", "symbols", lettersArray, "Lettre greque");
addElementsBtn("add-latex", "add-symbols-btn", "symbols", latexArray, "Élément laTeX");