

document.addEventListener('DOMContentLoaded', function(){
    const container = document.getElementById('inputs');
    
    const addTextBtn = document.getElementById('add-text');
    const addTitle1Btn = document.getElementById('add-title-1');
    const addTitle2Btn = document.getElementById('add-title-2');
    const addTitle3Btn = document.getElementById('add-title-3');
    const addTitle4Btn = document.getElementById('add-title-4');
    const addTitle5Btn = document.getElementById('add-title-5');
    const addTrueFalseBtn = document.getElementById('add-true-false');
    const addHintBtn = document.getElementById('add-hint');

    const form = document.getElementById('dynamic-form');
    const output = document.getElementById('output');

    //curr id, +1 after element creation
    let index = 0;
    
    // when true we suspend saving to localStorage (used during restore)
    let suspendSave = false;


    function createWrapper(type){
        const wrapper = document.createElement('div');
        
        wrapper.className = 'module';
        
        wrapper.dataset.type = type;
        return wrapper;
    }

    function createLabel(content, id){
        const label = document.createElement('label');
        label.textContent = content;
        label.htmlFor = id;
        return label;
    }

    function createInput(type, id, placeholder, defaultv, name){
        const input = document.createElement('input');
        const p = document.createElement('p');
        input.type = (type);
        input.placeholder = placeholder;
        // set current value (use value so it's readable via .value)
        input.value = defaultv || '';
        input.id = id;
        input.name = name;

        input.addEventListener("keyup", function(){
            p.innerHTML = input.value;
            reloadMathJax(p)
        });

        const wrapper = document.createElement('div');
        wrapper.className = "preview";
        wrapper.appendChild(input);
        wrapper.appendChild(p);
        return wrapper;
    }

    function createRemove(wrapper){
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'remove';
        remove.textContent = "Supprimer l'élément";
        remove.addEventListener('click', function(){
            wrapper.remove();
            renumber();
            saveState();
        });

        return remove;
    }

    function createTextarea(id, placeholder, defaultv, name){
        const textarea = document.createElement('textarea');
        const p = document.createElement('p');

        textarea.addEventListener("keyup", function(){
            p.innerHTML = textarea.value;
            reloadMathJax(p)
        });
        
        textarea.placeholder = placeholder;
        // set current value (use value so it's readable via .value)
        textarea.value = defaultv || '';
        textarea.id = id;
        textarea.name = name;
        textarea.rows = 4;
        textarea.cols = 50;
        
        
        const wrapper = document.createElement('div');
        wrapper.className = 'preview';
        wrapper.appendChild(textarea);
        wrapper.appendChild(p);
        return wrapper;
    }

    function createSpinner(id, name, min, max, step,defaultv=0){
        const spinner = document.createElement('input');
        spinner.type = 'number';
        spinner.id = id;
        spinner.name = name;
        spinner.min = min;
        spinner.max = max;
        spinner.step = step;
        spinner.value = defaultv;
        
        return spinner;
    }
    

    //Add new textfield and remove button
    function addTextField(defaultv = "") {
        const wrapper = createWrapper('text');
        const id = `modules_${index}_value`;
        //name usable server side (modules[0][value], modules[1][value], ...)
        const input = createTextarea(id, "Entrez du texte ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Champ de texte : ", id);
        const remove = createRemove(wrapper);
        wrapper.appendChild(label);
        wrapper.appendChild(input);
        wrapper.appendChild(remove);
        container.appendChild(wrapper);
        index++;
        if (!suspendSave) saveState();
        wrapper.addEventListener('input', () => {
            if (!suspendSave) saveState();
        });
    }

    function addTitleField(defaultv = "", size = 5) {
        const wrapper = createWrapper('title'.concat(size));
        const id = `modules_${index}_value`;
        //name usable server side (modules[0][value], modules[1][value], ...)
        const input = createInput('text',id, "Entrez votre titre ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Titre " + size + ": ", id);
        const remove = createRemove(wrapper);
        wrapper.appendChild(label);
        wrapper.appendChild(input);
        wrapper.appendChild(remove);
        container.appendChild(wrapper);
        index++;
        if (!suspendSave) saveState();

        wrapper.addEventListener('input', () => {
            if (!suspendSave) saveState();
        });
    }

    function addHintField(defaultv = "", defaultnum = 0) {
        const wrapper =createWrapper('hint');
        const id = `modules_${index}_value`;
        const input = createTextarea(id, "Entrez L'indice ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Indice : ", id);
        const spinner = createSpinner(`modules_${index}_hint_num`, `modules[${index}][hint_num]`, 0, 100, 1, defaultnum);
        const spinnerLabel = createLabel("Nombre d'essai avant affichage de l'indice : ", `modules_${index}_hint_num`);
        const remove = createRemove(wrapper);
        wrapper.appendChild(label);
        wrapper.appendChild(input);
        wrapper.appendChild(spinnerLabel);
        wrapper.appendChild(spinner);
        wrapper.appendChild(remove);
        container.appendChild(wrapper);
        index++;
        if (!suspendSave) saveState();
        wrapper.addEventListener('input', () => {
            if (!suspendSave) saveState();
        });
    }

    function addTrueFalseField(defaultv = "") {
        const wrapper = createWrapper('truefalse');
        const id = `modules_${index}_value`;
        //name usable server side (modules[0][value], modules[1][value], ...)
        const input = createTextarea(id, "Entrez la question Vrai ou Faux ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Question Vrai ou Faux : ", id);
        const remove = createRemove(wrapper);
        wrapper.appendChild(label);
        wrapper.appendChild(input);
        wrapper.appendChild(remove);
        container.appendChild(wrapper);
        index++;
        if (!suspendSave) saveState();
        wrapper.addEventListener('input', () => {
            if (!suspendSave) saveState();
        });
    }

    //Redo the id of inputs after deletion to keep modules[0], modules[1], ...
    function renumber() {
        const modules = container.querySelectorAll('.module');
        modules.forEach((wrapper, i) => {
            const label = wrapper.querySelector('label');
            const valueInput = wrapper.querySelector('input, textarea');             
            const id = `modules_${i}_value`;
            if (label){ 
                label.htmlFor = id;
            }
            if (valueInput) {
            valueInput.name = `modules[${i}][value]`;
            valueInput.id = id;
            }
        });
        index = modules.length;
    }
    //saves the state of modules to keep them after page refresh
    function saveState() {
        const modules = container.querySelectorAll('.module');
        const data = [];
        modules.forEach(wrapper => {
            const valueInput = wrapper.querySelector('input, textarea');
            // save the semantic type (stored on the wrapper) and the current input value
            data.push({ type: wrapper.dataset.type || 'wut? gtfo', value: valueInput ? valueInput.value : '' });
        });
        try {
            localStorage.setItem('dynamicModules', JSON.stringify(data));
        } catch (e) {
            console.warn('localStorage unavailable:', e);
        }
    }
    //loads the saved state of modules including their content
    function loadState() {
        try {
            const raw = localStorage.getItem('dynamicModules');
            if (!raw) return;
            const data = JSON.parse(raw);
            if (!Array.isArray(data)) return;
            // clear existing
            container.innerHTML = '';
            index = 0;
            suspendSave = true;
            data.forEach(item => {

                if(item.type === 'text'){
                    addTextField(item.value || '');
                } else if (typeof item.type === 'string' && item.type.startsWith('title')) {
                    const size = parseInt(item.type.slice(5)) || 5;
                    addTitleField(item.value || '', size);
                
                }else if(item.type === 'hint'){
                    
                    addHintField(item.value || '',0);

                }else if(item.type === 'div'){
                    
                }else {
                    console.warn('Unsupported module type during load:', item.type);
                }
                
                
                // set the stored semantic type on the wrapper so saveState captures it
                const last = container.lastElementChild;
                if (last) last.dataset.type = item.type || 'text';
            });
            suspendSave = false;
            
            saveState();
        }catch (e) {
            console.warn('Failed to load saved modules:', e);
        }
    }

    addTextBtn.addEventListener('click', ()=> addTextField());
    addTitle5Btn.addEventListener('click', ()=> addTitleField('', 5));
    addTitle4Btn.addEventListener('click', ()=> addTitleField('', 4));
    addTitle3Btn.addEventListener('click', ()=> addTitleField('', 3));
    addTitle2Btn.addEventListener('click', ()=> addTitleField('', 2));
    addTitle1Btn.addEventListener('click', ()=> addTitleField('', 1));
    addTrueFalseBtn.addEventListener('click', ()=> addTrueFalseField());
    addHintBtn.addEventListener('click', ()=> addHintField());
    loadState();
});
