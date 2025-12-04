<!DOCTYPE html>

<html lang="fr">
 <?php include 'modules/include.php' ?>

    <body>
        <!-- nav -->
        <?php include 'modules/header.php' ?>

        <main id="chapter-creation">     
            <aside>
                <h2>Outils</h2>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div>
                <div>
                    <ul>      
                        <li>Outil1</li>
                        <li>Outil2</li>
                    </ul>
                </div> 
            </aside>


            <form action="processing-form-section.php" method="post" id ="dynamic-form">

                <fieldset>
                    <legend>Paramètres de la section</legend>   

                    <ul>   
                        <li><h3>Options de notation</h3></li>
                        <li>
                            <span> 
                                <label for="weight">Coefficient (nécéssaire même si non notée, pour les statistiques):</label>
                                <input id="weight" name="weight" type="number" min="0" max="100" step="1" default="0">
                            </span>
                        </li>

                        <li><h3>Options de temps</h3></li>

                        <li>
                            <span> 
                                <label for="time">Limite de temps (en minutes, 0 pour illimité):</label>
                                <input id="time" name="time" type="number" min="0" max="2048" step="1" default="0">
                            </span>
                        </li>

                        <li><h3>Options d'essais</h3></li>

                        <li> <input id="tries" type="checkbox" name="tries"><label for="tries">Limiter le nombre d'essais ? </label>
                            <span> <!-- only show this span if 'tries' checkbox checked -->
                                <label for="tries-number">Nombre d'essais autorisés:</label>
                                <input id="tries-number" name="tries_number" type="number" min="1" max="100" step="1" default="1">
                            </span>
                    
                        </li>

                        <li><h3>Options de réponses</h3></li>

                        <li> 
                            <input id="ansdef" type="checkbox" name="ansdef"><label for="ansdef">Réponses définitives? (pas de modification possible après avoir quité la page ou validé la réponse)</label>
                             <!-- only show this input if 'ansdef' checkbox checked -->
                            <input id="showans" type="checkbox" name="showans"><label for="showans">Montrer la réponse après la validation</label>
                        </li>

                        
                    
                    </ul>

                </fieldset>

                <fieldset>
                    <legend>Création de la section</legend>

                    <ul>

                    
                        

                        <li><h3>Modules par défaut</h3></li>
                        <li>
                            <label for="section-title">Titre de la section</label>
                            <input id="section-title" type="text" name="section-title">
                        </li>


                        <li><h3>Modules dynamiques</h3></li>
                        

                        <li>
                            <div id="inputs"></div>
                        </li>

                        

                    </ul>   
                    
                </fieldset>

                <button type="submit">Enregistrer la section</button>


                </form>
            

            <aside>
               <h2>Raccourcis</h2>
               
                <form >
                    
                    <button type="button" id="add-text">Ajouter un champ de texte</button>
                    <span>Titres</span> <img src="Arrow-down.svg" alt="arrow" width="5px" height="5px">
                    <!-- show buttons if the span is clicked (and change image)-->
                    <button type="button" id="add-title-1">Ajouter un titre 1</button>
                    <button type="button" id="add-title-2">Ajouter un titre 2</button>
                    <button type="button" id="add-title-3">Ajouter un titre 3</button>
                    <button type="button" id="add-title-4">Ajouter un titre 4</button>
                    <button type="button" id="add-title-5">Ajouter un titre 5</button>
                    <button type="button" id="add-hint">Ajouter un indice</button>
                </form>
            </aside>
        </main>

        
        

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 



        <script>
            
            document.addEventListener('DOMContentLoaded', function(){
                const container = document.getElementById('inputs');
                
                const addTextBtn = document.getElementById('add-text');
                const addTitle1Btn = document.getElementById('add-title-1');
                const addTitle2Btn = document.getElementById('add-title-2');
                const addTitle3Btn = document.getElementById('add-title-3');
                const addTitle4Btn = document.getElementById('add-title-4');
                const addTitle5Btn = document.getElementById('add-title-5');
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
                    input.type = (type);
                    input.placeholder = placeholder;
                    // set current value (use value so it's readable via .value)
                    input.value = defaultv || '';
                    input.id = id;
                    input.name = name;
                    return input;
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
                    textarea.placeholder = placeholder;
                    // set current value (use value so it's readable via .value)
                    textarea.value = defaultv || '';
                    textarea.id = id;
                    textarea.name = name;
                    textarea.rows = 4;
                    textarea.cols = 50;
                    return textarea;
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
                addHintBtn.addEventListener('click', ()=> addHintField());
                loadState();

                // // Exemple de traitement léger côté client pour voir les données envoyées
                // form.addEventListener('submit', function(e){
                // e.preventDefault();
                // const fd = new FormData(form);
                // // Convertit FormData en objet lisible
                // const obj = {};
                // for (const [k, v] of fd.entries()) {
                //     obj[k] = v;
                // }
                // output.textContent = JSON.stringify(obj, null, 2);
                // });
            });
        </script>
    </body>
</html>