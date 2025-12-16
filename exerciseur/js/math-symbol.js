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


// Track last focused editable so dynamically-created textareas keep working
let lastEditable = null;
document.addEventListener('focusin', e => {
    const t = e.target;
    if (!t) return;
    // track any text-like input, textarea or contenteditable so dynamic inserts go to the right place
    if (t.tagName === 'TEXTAREA' || t.tagName === 'INPUT' || t.isContentEditable) lastEditable = t;
});

// Prevent buttons from stealing focus when clicked — use closest so MathJax children are handled
document.addEventListener('mousedown', e => {
    const btn = e.target && e.target.closest ? e.target.closest('.math-symbol-btn') : null;
    if (btn) e.preventDefault();
});
document.addEventListener('touchstart', e => {
    const btn = e.target && e.target.closest ? e.target.closest('.math-symbol-btn') : null;
    if (btn) e.preventDefault();
});

// Insert into last focused editable when a symbol button is clicked
document.addEventListener('click', e => {
    const btn = e.target && e.target.closest ? e.target.closest('.math-symbol-btn') : null;
    if (!btn) return;
    const symbol = btn.dataset.symbol || btn.textContent;
    const fallback = document.querySelector('textarea, input[type="text"], input[type="search"], input[type="url"], input[type="tel"], input[type="email"], input[type="password"], [contenteditable="true"]');
    const el = lastEditable || ((document.activeElement && (document.activeElement.tagName === 'TEXTAREA' || document.activeElement.tagName === 'INPUT' || document.activeElement.isContentEditable)) ? document.activeElement : fallback);
    if (!el) return;
    if (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT') insertAtCursor(el, symbol);
    else if (el.isContentEditable) insertToContentEditable(symbol);
});

// Insert text into an input/textarea at the caret (preserves selection)
function insertAtCursor(el, text) {
    el.focus();
    const start = typeof el.selectionStart === 'number' ? el.selectionStart : el.value.length;
    const end = typeof el.selectionEnd === 'number' ? el.selectionEnd : el.value.length;
    el.value = el.value.slice(0, start) + text + el.value.slice(end);
    const pos = start + text.length;
    el.selectionStart = el.selectionEnd = pos;
    // notify listeners (frameworks) that the value changed
    el.dispatchEvent(new Event('input', {bubbles: true}));
    el.focus();
}

function insertToContentEditable(text) {
    const el = lastEditable && lastEditable.isContentEditable ? lastEditable : document.activeElement;
    const sel = window.getSelection();
    let range;
    if (!sel || !sel.rangeCount) {
        // place caret at end if no selection
        range = document.createRange();
        if (el && el.nodeType) range.selectNodeContents(el);
        range.collapse(false);
    } else {
        range = sel.getRangeAt(0);
    }
    range.deleteContents();
    const textNode = document.createTextNode(text);
    range.insertNode(textNode);
    // move caret after the inserted node
    range.setStartAfter(textNode);
    range.collapse(true);
    sel.removeAllRanges();
    sel.addRange(range);
    if (el && el.isContentEditable) el.dispatchEvent(new Event('input', {bubbles: true}));
}


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
        
        // mark the button and store the raw symbol for insertion
        btn.classList.add('math-symbol-btn');
        btn.dataset.symbol = prefix.concat(array[i], suffix);

        // adds symbol to clipboard when btn is clicked
        // btn.addEventListener("click", ()=>navigator.clipboard.writeText(prefix.concat(array[i], suffix)));
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

let comparisonArray = ["lt", "gt", "le", "ge", "neq", "simeq", "equiv"];

let lettersMinArray = ["alpha", "beta", "chi", "delta", "epsilon", "eta", "gamma", "iota", "kappa", "lambda", "mu", "nu", "omega", "phi", "pi",
                    "psi", "rho", "sigma", "tau", "theta", "upsilon", "xi", "zeta"];

let lettersArray = ["Delta", "Gamma", "Lambda", "Omega", "Phi", "Pi", "Psi", "Sigma", "Theta", "Upsilon", "Xi"];

let latexArray = ["\(", "\)"];

addElementsBtn("add-comparison", "add-symbols-btn", "symbols", comparisonArray, "Symboles de comparaison");
addElementsBtn("add-letter-min", "add-symbols-btn", "symbols", lettersMinArray, "Lettres greques (miniscules)");
addElementsBtn("add-letter-maj", "add-symbols-btn", "symbols", lettersArray, "Lettres greques (majuscules)");
addElementsBtn("add-latex", "add-symbols-btn", "symbols", latexArray, "Éléments laTeX");