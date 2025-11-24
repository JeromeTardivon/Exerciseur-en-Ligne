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


            <form action="section-process.php" method="post" id ="dynamic-form">

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

                </form>
            

            <aside>
               <h2>Raccourcis</h2>
               
                <form >
                    
                    <button type="button" id="add-text">Ajouter un champ de texte</button>
                    <button type="button" id="add-number">Ajouter un titre</button>
                    <button type="button" id="add-date">Ajouter (date)</button>
                </form>
            </aside>
        </main>

        
        

        <!-- footer -->
        <?php include 'modules/footer.php' ?> 



        <script>
            
            document.addEventListener('DOMContentLoaded', function(){
                const container = document.getElementById('inputs');
                
                const addTextBtn = document.getElementById('add-text');
                const addNumberBtn = document.getElementById('add-number');
                const addDateBtn = document.getElementById('add-date');

                const form = document.getElementById('dynamic-form');
                const output = document.getElementById('output');

                //curr id, +1 after element creation
                let index = 0;


                function createrWrapper(type){
                    const wrapper = document.createElement('div');
                    wrapper.className = type;
                    return wrapper;
                }

                function creatLabel(content, id){
                    const label = document.createElement('label');
                    label.textContent = content;
                    label.htmlFor = id;
                    return label;
                }

                function creatInput(type, id, placeholder, defaultv, name){
                    const input = document.createElement('input');
                    input.type = (type);
                    input.placeholder = placeholder;
                    input.defaultValue=defaultv;
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
                

                // Add new textfield and remove button
                function addTextField() {
                    const wrapper = createrWrapper('text');
                    const id = `modules_${index}_value`;
                    // name usable server side (modules[0][value], modules[1][value], ...)
                    const input = creatInput('text',id, "Entrez du texte ici","",`modules[${index}][value]`);
                    const label = creatLabel("Champ de texte : ", id);
                    const remove = createRemove(wrapper);
                    wrapper.appendChild(label);
                    wrapper.appendChild(input);
                    wrapper.appendChild(remove);
                    container.appendChild(wrapper);
                    index++;
                    saveState();
                }

                // Reindexe tous les inputs après suppression pour garder modules[0], modules[1], ...
                function renumber() {
                    const modules = container.querySelectorAll('.module');
                    modules.forEach((wrapper, i) => {
                        // visible label for the value
                        const label = wrapper.querySelector('label');
                        // the visible value input (not the hidden type input)
                        const valueInput = wrapper.querySelector('input:not([type=hidden])');
                       
                        
                        // the little visible badge that shows the type
                        const typeBadge = wrapper.querySelector('span');

                        const id = `modules_${i}_value`;
                        if (label) label.textContent = 'Champ ' + (i + 1) + ':';
                        if (label) label.htmlFor = id;

                        if (valueInput) {
                        valueInput.name = `modules[${i}][value]`;
                        valueInput.id = id;
                        }

                        
                    });
                    index = modules.length;
                }

                function saveState() {
                    const modules = container.querySelectorAll('.module');
                    const data = [];
                    modules.forEach(wrapper => {
                        const valueInput = wrapper.querySelector('input:not([type=hidden])');
                        const typeHidden = wrapper.querySelector('input[type=hidden]');
                        data.push({ type: typeHidden ? typeHidden.value : 'text', value: valueInput ? valueInput.value : '' });
                    });
                    try {
                        localStorage.setItem('dynamicModules', JSON.stringify(data));
                    } catch (e) {
                        console.warn('localStorage unavailable:', e);
                    }
                }

                function loadState() {
                    try {
                        const raw = localStorage.getItem('dynamicModules');
                        if (!raw) return;
                        const data = JSON.parse(raw);
                        if (!Array.isArray(data)) return;
                        // clear existing
                        container.innerHTML = '';
                        index = 0;
                        data.forEach(item => addField(item.type || 'text', item.value || ''));
                    }catch (e) {
                        console.warn('Failed to load saved modules:', e);
                    }
                }

                addTextBtn.addEventListener('click', ()=> addTextField());
                addNumberBtn.addEventListener('click', ()=> addTextField());
                addDateBtn.addEventListener('click', ()=> addTextField());
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