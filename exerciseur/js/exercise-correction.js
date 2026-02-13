document.addEventListener('DOMContentLoaded', function(){
    exerciseContainer = document.getElementById('exercise-container');
    const form = document.getElementById('dynamic-form');

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


    function loadExercise(){
        exerciseContainer.innerHTML = '';
        const wrapper = document.createElement('div');
        const sectionTitle = document.createElement('h1');
        sectionTitle.textContent = 'Placeholder Title';
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
                    container.className = "module";
                    container.dataset.type = item.type;
                    const grade = parseFloat(item.grade);

                    const openElem = document.createElement('p');
                    openElem.innerHTML = "Question : ".concat(item.value || '');
                    reloadMathJax(openElem);
                    const answer = document.createElement('p');
                    answer.innerHTML = "Réponse : ".concat(item.answer || "empty answer");

                    const noteLabel = createLabel('Note : ', `grade-field-${item.index}}`);
                    const gradeField = createSpinner(`grade-field-${item.index}`, `grade-field-${item.index}}`, -67000, grade, 0.01);

                    const maxGradeLabel = createLabel(`(max : ${grade})`, `max-grade-field-${item.index}}`);

                    gradeField.addEventListener('change', saveExercise);

                    container.appendChild(openElem);
                    container.appendChild(answer);
                    container.appendChild(noteLabel);
                    container.appendChild(gradeField);
                    container.appendChild(maxGradeLabel);

                    wrapper.appendChild(container);
                } else {
                    const container = document.createElement('div');
                    container.className = "module";
                    container.dataset.type = item.type;

                    container.style.display = 'none';

                    wrapper.appendChild(container);
                    console.warn('Unsupported module type during load:', item.type);
                }
            }
        );
            exerciseContainer.appendChild(wrapper);

        }catch (e) {
            console.warn('Failed to load saved modules:', e);
        }
    }

    function saveExercise(){
        const modules = document.querySelectorAll('.module');
        const data = [];

        modules.forEach(wrapper => {
            const type = wrapper.dataset.type || 'text';
            if (type === 'openquestion') {
                const valueInput = wrapper.querySelector('input, textarea');
                const answer = wrapper.querySelector(`input[type="text"][name$="[answer]"]`);
                const grade = wrapper.querySelector(`input[type="number"]`);
                data.push({ type: type, value: valueInput ? valueInput.value : '', answer: answer ? answer.value : "", grade: parseFloat(grade.value) || 0 });
            } else {
                data.push({ type: type});
            }
        });


        try {
            const raw = localStorage.getItem('dynamicModules');
            if (!raw) return;
            const data2 = JSON.parse(raw);
            if (!Array.isArray(data2)) return;
            // clear existing
            index = 0;
            suspendSave = true;
            
            for (let i = 0; i < data2.length; i++) {
                if (data2[i].type === 'openquestion' || data2[i].type === 'text' || data2[i].type === 'truefalse') {
                    data[i].value = data2[i].value;
                } else if (data2[i].type === 'mcq') {
                    data[i].question = data2[i].question;
                    data[i].choices = data2[i].choices;
                } else if (data2[i].type === 'numericalquestion') {
                    data[i].value = data2[i].value;
                    data[i].answer = data2[i].answer;
                    data[i].answernumber = data2[i].answernumber;
                } else {
                    console.warn('Unkown module type during save:', data2[i].type);
                }
            }

            console.log('data', data);
        } catch (e) {
            console.warn('Failed to reload modules during save:', e);
        }

        try {
            localStorage.setItem('graded-answers', JSON.stringify(data));

            //creates hidden input to send data from localstorage to server
            let payload = null;
            try { payload = localStorage.getItem('azd'); } catch(e) { payload = null; }
            if (!payload) payload = JSON.stringify(data);

            if (form) {
                let hidden = form.querySelector('#graded-answers');

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
        } catch (e) {
            console.warn('localStorage unavailable:', e);
        }
    }

    loadExercise();
    saveExercise();
});