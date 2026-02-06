document.addEventListener('DOMContentLoaded', function(){
    exerciseContainer = document.getElementById('exercise-container');

    


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

                if(item.type === 'text'){
                    wrapper.appendChild(document.createElement('div')).innerHTML = item.value || '';
                    reloadMathJax(wrapper);

                } else if (typeof item.type === 'string' && item.type.startsWith('title')) {
                    const size = parseInt(item.type.slice(5)) || 5;
                    const titleElem = document.createElement('h' + size);
                    titleElem.innerHTML = item.value || '';
                    titleElem.dataset.type = item.type || 'title'.concat(size);
                    reloadMathJax(titleElem);
                    wrapper.appendChild(titleElem);

                } else if (item.type === 'mcq') {
                    const mcqElem = document.createElement('div');
                    mcqElem.innerHTML = item.question || '';
                    reloadMathJax(mcqElem);
                    let iterator = '0';
                    for (const choice of item.choices || []) {
                        const choiceDiv = document.createElement('div');
                        const cb = document.createElement('input');
                        cb.type = 'checkbox';
                        cb.setAttribute('id', 'mcqpreview_'.concat(iterator));
                        iterator++;

                        const label = document.createElement('label');
                        label.textContent = choice.text || '';
                        label.setAttribute('for', cb.id);
                        
                        choiceDiv.appendChild(cb);
                        choiceDiv.appendChild(label);
                        mcqElem.appendChild(choiceDiv);
                    }
                    wrapper.appendChild(mcqElem);

                } else if (item.type === 'truefalse') {
                    const trueFalseElem = document.createElement('div');
                    const q = document.createElement('p');
                    q.innerHTML = item.value || '';
                    reloadMathJax(q);
                    trueFalseElem.appendChild(q);

                    const trueradio = document.createElement('input');
                    trueradio.type = 'radio';
                    trueradio.name = 'truefalseanswer';

                    const trueLabel = document.createElement('label');
                    trueLabel.setAttribute('for', 'trueradio');
                    trueLabel.textContent = 'Vrai';
                
                    trueFalseElem.appendChild(trueradio);
                    trueFalseElem.appendChild(trueLabel);

                    const falseradio = document.createElement('input');
                    falseradio.type = 'radio';
                    falseradio.name = 'truefalseanswer';
                    
                    const falseLabel = document.createElement('label');
                    falseLabel.setAttribute('for', 'falseradio');
                    falseLabel.textContent = 'Faux';

                    trueFalseElem.appendChild(falseradio);
                    trueFalseElem.appendChild(falseLabel);

                    wrapper.appendChild(trueFalseElem);

                } else if (item.type === 'openquestion') {
                    const openElem = document.createElement('div');
                    openElem.innerHTML = item.value || '';
                    reloadMathJax(openElem);
                    const answerInput = document.createElement('textarea');
                    answerInput.setAttribute('name', 'openanswerpreview');
                    answerInput.setAttribute('placeholder', 'Votre réponse ici');
                    answerInput.setAttribute('id', 'openanswerpreview');
                    wrapper.appendChild(openElem);
                    wrapper.appendChild(answerInput);

                } else if (item.type === 'numericalquestion') {
                    numericalElem = document.createElement('div');
                    numericalElem.innerHTML = item.value || '';
                    reloadMathJax(numericalElem);
                    const justifinput = document.createElement('textarea');
                    justifinput.setAttribute('name', 'justifpreview');
                    justifinput.setAttribute('placeholder', 'Justification (si demandée)');
                    justifinput.setAttribute('id', 'justifpreview');
                    const answerInput = document.createElement('input');
                    answerInput.type = 'number';
                    answerInput.setAttribute('name', 'numericalanswerpreview');
                    answerInput.setAttribute('placeholder', 'Votre réponse ici');
                    answerInput.setAttribute('id', 'numericalanswerpreview');
                    answerInput.setAttribute('step', '0.001');
                    wrapper.appendChild(numericalElem);
                    wrapper.appendChild(justifinput);
                    wrapper.appendChild(answerInput);

                } else if(item.type === 'hint'){
                    // hints are not shown in preview
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