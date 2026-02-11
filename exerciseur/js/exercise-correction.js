document.addEventListener('DOMContentLoaded', function(){
    exerciseContainer = document.getElementById('exercise-container');

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

    function createLabel(content, id){
        const label = document.createElement('label');
        label.textContent = content;
        label.htmlFor = id;
        return label;
    }

    function saveModulesInForm(formId) {
        const input = document.getElementById(formId);

        try {
            const raw = localStorage.getItem('dynamicModules');
            if (!raw) return;
            const data = JSON.parse(raw);
            if (!Array.isArray(data)) return;

            input.value = raw;
        } catch {
            console.warn('JSON could not be loaded in the form');
        }
    }

    function loadExercise(){
        //try{ saveState(false); }catch(e){console.warn('Could not save state before preview load :', e);}
        
        exerciseContainer.innerHTML = '';
        const wrapper = document.createElement('div');
        const sectionTitle = document.createElement('h1');
        sectionTitle.textContent = 'Placeholder Title';
        //sectionTitle.textContent = document.getElementById('section-title').value || 'Titre de la section';
        sectionTitle.className = 'section-title';
        reloadMathJax(sectionTitle);
        wrapper.appendChild(sectionTitle);
        
        try {
            const raw = localStorage.getItem('dynamicModules');
            if (!raw) return;
            const data = JSON.parse(raw);
            if (!Array.isArray(data)) return;
            
            data.forEach(item => {
                if (item.type === 'openquestion') {
                    const container = document.createElement('div');

                    const openElem = document.createElement('p');
                    openElem.innerHTML = "Question : ".concat(item.value || '');
                    reloadMathJax(openElem);
                    const answer = document.createElement('p');
                    answer.innerHTML = "Réponse : ".concat(item.answer || "empty answer");

                    const label = createLabel('Note : ', `grade-field-${item}`);
                    const gradeField = createSpinner(`grade-field-${item}`, `grade-field-${item}`, -67000, 67000, 0.01);

                    gradeField.addEventListener('change', saveModulesInForm("dynamic-modules"));

                    container.appendChild(openElem);
                    container.appendChild(answer);
                    container.appendChild(label);
                    container.appendChild(gradeField);

                    wrapper.appendChild(container);
                } else {
                    console.warn('Unsupported module type during load:', item.type);
                }
            }
        );
            exerciseContainer.appendChild(wrapper);

        }catch (e) {
            console.warn('Failed to load saved modules:', e);
        }
    }
    loadExercise();

});