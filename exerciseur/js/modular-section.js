

document.addEventListener('DOMContentLoaded', function(){
    const container = document.getElementById('inputs');
    
    const addTextBtn = document.getElementById('add-text');
    const addTitle1Btn = document.getElementById('add-title-1');
    const addTitle2Btn = document.getElementById('add-title-2');
    const addTitle3Btn = document.getElementById('add-title-3');
    const addTitle4Btn = document.getElementById('add-title-4');
    const addTitle5Btn = document.getElementById('add-title-5');
    const addTrueFalseBtn = document.getElementById('add-true-false');
    const addOpenQuestionBtn = document.getElementById('add-open-question');
    const addNumericalQuestionBtn = document.getElementById('add-numerical-question');
    const addMultipleChoiceBtn = document.getElementById('add-multiple-choice');
    const addHintBtn = document.getElementById('add-hint');
    const saveBtn = document.getElementById('save-section');
    const saveEndBtn = document.getElementById('save-section-end');

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
        input.addEventListener("click", function(){
            p.innerHTML = input.value;
            reloadMathJax(p)
        });
        
        p.innerHTML = input.value;
        reloadMathJax(p);

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
            reloadMathJax(p);
        });

        textarea.addEventListener("click", function(){
            p.innerHTML = textarea.value;
            reloadMathJax(p);
        });

        textarea.placeholder = placeholder;
        // set current value (use value so it's readable via .value)
        textarea.value = defaultv || '';
        textarea.id = id;
        textarea.name = name;
        textarea.rows = 4;
        textarea.cols = 50;
        p.innerHTML = textarea.value;
        reloadMathJax(p);
        
        const spinner = createSpinner(`modules_${index}_hint_num`, `modules[${index}][hint_num]`, 0, 67000, 0.01);
        const label = createLabel("Nombre de points de la question : ", `modules_${index}_hint_num`);
        
        const wrapper = document.createElement('div');
        wrapper.className = 'preview';
        wrapper.appendChild(textarea);
        wrapper.appendChild(p);
        wrapper.appendChild(label);
        wrapper.appendChild(spinner);
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

    function createCheckbox(id, name, defaultv = false){
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = id;
        checkbox.name = name;
        checkbox.checked = defaultv;
        
        return checkbox;
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

    
    function createMCQChoice(defaultText = '', checked = false) {
        const choice = document.createElement('div');
        choice.className = 'mcq-choice';

        const cb = document.createElement('input');
        cb.type = 'checkbox';
        cb.className = 'mcq-choice-checked';
        cb.checked = !!checked;

        const text = document.createElement('input');
        text.type = 'text';
        text.className = 'mcq-choice-text';
        text.placeholder = 'Choix';
        text.value = defaultText || '';

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.textContent = 'Supprimer le choix';
        remove.addEventListener('click', () => {
            choice.remove();
            // bubble up renumber/save
            renumber();
            if (!suspendSave) saveState();
        });

        choice.appendChild(cb);
        choice.appendChild(text);
        choice.appendChild(remove);
        return choice;
    }

    function addMultipleChoiceField(data = null) {
        const wrapper = createWrapper('mcq');
        const id = `modules_${index}_value`;

        const label = createLabel('Question : ', id);
        const question = createTextarea(id, 'Entrez la question ici', (data && data.question) ? data.question : '', `modules[${index}][question]`);

        const choicesContainer = document.createElement('div');
        choicesContainer.className = 'mcq-choices';

        
        const choices = (data && Array.isArray(data.choices)) ? data.choices : [{text:'', checked:false},{text:'', checked:false}];
        choices.forEach(c => {
            const ch = createMCQChoice(c.text || '', !!c.checked);
            choicesContainer.appendChild(ch);
        });

        const addChoiceBtn = document.createElement('button');
        addChoiceBtn.type = 'button';
        addChoiceBtn.textContent = 'Ajouter un choix';
        addChoiceBtn.addEventListener('click', () => {
            const ch = createMCQChoice();
            choicesContainer.appendChild(ch);
            renumber();
            if (!suspendSave) saveState();
        });

        const remove = createRemove(wrapper);
        wrapper.appendChild(label);
        wrapper.appendChild(question);
        wrapper.appendChild(choicesContainer);
        wrapper.appendChild(addChoiceBtn);
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

    

    function addOpenQuestionField(defaultv = "") {
        const wrapper = createWrapper('openquestion');
        const id = `modules_${index}_value`;
        //name usable server side (modules[0][value], modules[1][value], ...)
        const input = createTextarea(id, "Entrez la question/consigne ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Question à réponse ouverte : ", id);
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

    function addNumericalQuestionField(defaultv = "") {
        const wrapper = createWrapper('numericalquestion');
        const id = `modules_${index}_value`;
        //name usable server side (modules[0][value], modules[1][value], ...)
        const input = createTextarea(id, "Entrez la question numérique ici", defaultv,`modules[${index}][value]`);
        const label = createLabel("Question numérique : ", id);
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

    //Redo the id of inputs to keep modules[0], modules[1], ...
    function renumber() {
        const modules = container.querySelectorAll('.module');
        modules.forEach((wrapper, i) => {
            const label = wrapper.querySelector('label');
            const id = `modules_${i}_value`;
            const type = wrapper.dataset.type || '';
            if (label){ 
                // prefer to update label target where appropriate
                if (type === 'mcq') {
                    label.htmlFor = `modules_${i}_question`;
                } else {
                    label.htmlFor = id;
                }
            }

            if (type === 'hint') {
                // textarea for hint and a spinner for tries
                const textarea = wrapper.querySelector('textarea');
                if (textarea) {
                    textarea.name = `modules[${i}][value]`;
                    textarea.id = `modules_${i}_value`;
                }
                const spinner = wrapper.querySelector('input[type=number]');
                if (spinner) {
                    spinner.name = `modules[${i}][hint_num]`;
                    spinner.id = `modules_${i}_hint_num`;
                }
            } else if (type && type.startsWith('title') || type === 'text' || type === 'div') {
                const valueInput = wrapper.querySelector('input, textarea');
                if (valueInput) {
                    valueInput.name = `modules[${i}][value]`;
                    valueInput.id = `modules_${i}_value`;
                }
            } else if (type === 'mcq') {
                // question textarea
                const questionTa = wrapper.querySelector('textarea');
                if (questionTa) {
                    questionTa.name = `modules[${i}][question]`;
                    questionTa.id = `modules_${i}_question`;
                }
                // choices
                const choices = wrapper.querySelectorAll('.mcq-choice');
                choices.forEach((choice, j) => {
                    const txt = choice.querySelector('.mcq-choice-text');
                    const cb = choice.querySelector('.mcq-choice-checked');
                    if (txt) txt.name = `modules[${i}][choices][${j}][text]`;
                    if (cb) cb.name = `modules[${i}][choices][${j}][checked]`;
                });
            } else {
                // generic fallback: rename first input/textarea as value
                const v = wrapper.querySelector('input, textarea');
                if (v) {
                    v.name = `modules[${i}][value]`;
                    v.id = `modules_${i}_value`;
                }
            }
        });
        index = modules.length;
    }
    //saves the state of modules to keep them after page refresh
    function saveState(fullSave=true) {
        
        const modules = container.querySelectorAll('.module');
        const data = [];
        modules.forEach(wrapper => {
            const type = wrapper.dataset.type || 'text';
            if (type === 'hint') {
                const ta = wrapper.querySelector('textarea');
                const spinner = wrapper.querySelector('input[type=number]');
                data.push({ type: 'hint', value: ta ? ta.value : '', hint_num: spinner ? Number(spinner.value) : 0 });
            } else if (type === 'mcq') {
                const questionTa = wrapper.querySelector('textarea');
                const question = questionTa ? questionTa.value : '';
                const choices = [];
                wrapper.querySelectorAll('.mcq-choice').forEach(ch => {
                    const txt = ch.querySelector('.mcq-choice-text');
                    const cb = ch.querySelector('.mcq-choice-checked');
                    choices.push({ text: txt ? txt.value : '', checked: !!(cb && cb.checked) });
                });
                data.push({ type: 'mcq', question: question, choices: choices });
            } else if (type.startsWith('title') || type === 'text' || type === 'truefalse' || type === 'openquestion' || type === 'numericalquestion') {
                const valueInput = wrapper.querySelector('input, textarea');
                data.push({ type: type, value: valueInput ? valueInput.value : '' });
            } else {
                // fallback: try to grab a value
                const valueInput = wrapper.querySelector('input, textarea');
                data.push({ type: type, value: valueInput ? valueInput.value : '' });
            }
        });

        
        try {
            localStorage.setItem('dynamicModules', JSON.stringify(data));
            if(fullSave){   
                //creates hidden input to send data from localstorage to server
                let payload = null;
                try { payload = localStorage.getItem('dynamicModules'); } catch(e) { payload = null; }
                if (!payload) payload = JSON.stringify(data);

                if (form) {
                    let hidden = form.querySelector('input[name="content"]');
                    if (!hidden) {
                        hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'content';
                        hidden.id = 'content';
                        form.appendChild(hidden);
                    }
                    hidden.value = payload;
                    
                    
                } else {
                    console.warn('saveState(true) called but form element not found; cannot attach content input');
                }
            }
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
                
                } else if (item.type === 'hint') {
                    addHintField(item.value || '', item.hint_num || 0);

                } else if (item.type === 'mcq') {
                    addMultipleChoiceField(item);

                } else if (item.type === 'truefalse') {
                    addTrueFalseField(item.value || '');

                } else if (item.type === 'openquestion') {
                    addOpenQuestionField(item.value || '');

                } else if (item.type === 'numericalquestion') {
                    addNumericalQuestionField(item.value || '');

                } else if (item.type === 'div') {
                    // ignore placeholder divs

                } else {
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
    addOpenQuestionBtn.addEventListener('click', ()=> addOpenQuestionField());
    addNumericalQuestionBtn.addEventListener('click', ()=> addNumericalQuestionField());
    addMultipleChoiceBtn.addEventListener('click', ()=> addMultipleChoiceField());
    addHintBtn.addEventListener('click', ()=> addHintField());
    saveBtn.addEventListener('click', (e)=> {
        // ensure no redirect flag is submitted for the normal save (continue on section)
        if (form) {
            const r = form.querySelector('input[name="redirect"]');
            if (r) r.parentNode.removeChild(r);
        }
        saveState(true);
    });

    saveEndBtn.addEventListener('click', (e)=> {
        // set a hidden redirect flag so server will redirect to index after saving
        if (form) {
            let r = form.querySelector('input[name="redirect"]');
            if (!r) {
                r = document.createElement('input');
                r.type = 'hidden';
                r.name = 'redirect';
                form.appendChild(r);
            }
            r.value = 'index';
        }
        saveState(true);
    });
    loadState();
});