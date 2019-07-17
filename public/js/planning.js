$(document).ready(function () {
    var maxField = 100; //Nombre limit de création de tâches, sous-tâches, projet.
    var x = 1; //Compteur de tâches ajoutées
    var y = 1; //Compteur des sous-tâches
    var z = 1; // Compteur des projets
    var taskClone = $('.task').first().clone(); //bloc tâche cloné
    var subtaskClone = $('.subtask').first().clone(); //bloc sous-tâche cloné
    var projectClone = $('.project').first().clone(); // bloc de projet cloné
    var assignationClone = $('.assignation_form').first().clone();//bloc de l'assignation

    fillAssignations($('.task').first(), z, y, x); //rempli dynamiquement le tableau de la semaine pour ajouter des assignations à la tâche remplie

    /** 
     * Action du clique sur le bouton d'ajout de tâche. 
     * Cela a comme effet d'ajouter un bloc complet de tâche comprenant nom de la tâche, 
     * commentaire et user.
    */
    $('body').on('click', '.add_task', function (e) {
        e.preventDefault();
        if (x < maxField) {
            x++;
            var subtaskName = $(this).parent().parent().find('.subtask_id').attr('name');
            var projectNumber = subtaskName.substring(8, subtaskName.indexOf(']'));
            var nameCut = subtaskName.substring([subtaskName.indexOf('subtask') + 9]);
            var subtaskNumber = nameCut.substring(0, nameCut.indexOf(']'));
            var task = taskClone.clone();
            task.find('.task_name').attr('name', 'project[' + projectNumber + '][subtask][' + subtaskNumber + '][task][' + x + '][task_name]');
            task.find('.task_name').val('');
            task.find('.comment_text.comment').attr('name', 'project[' + projectNumber + '][subtask][' + subtaskNumber + '][task][' + x + '][comment]');
            task.find('.comment_text.comment').val('');
            task.find('.user_id').attr('name', 'project[' + projectNumber + '][subtask][' + subtaskNumber + '][task][' + x + '][user]');
            task.find('.user_id').val('');
            task.find('.usertypeahead').val('');
            fillAssignations(task, projectNumber, subtaskNumber, x);
            var blocTask = $(this).parent().children(0)[0];
            $(blocTask).append(task); //Add field html

            $('input.usertypeahead').each(function (index) {
                $(this).typeahead({
                    source: function (query, process) {
                        return $.get('/userautocomplete', {
                            query: query
                        }, function (data) {
                            return process(data);
                        });
                    },
                    updater: function (obj) {
                        $('.user_id').val(obj.id);
                        return obj;
                    },
                });
            });

        }
        return false;
    });

    /**
     * Au clique de suppression de la tâche, supprime l'élément tâche sélectionné
     */
    $('body').on('click', '.remove_button', function (e) {
        e.preventDefault();
        //console.log($(this).parent().parent().parent('div'));
        $(this).parent().parent('div').remove(); //Remove field html
        x--; //Decrement field counter
        console.log(x);
        console.log($(this).parent().parent());
        if (x == 0) {
            console.log('supprimer sous tâche');
        }
        return false;
    });


/**
 * Au click sur le bouton d'ajout de sous-tâche
 * Rajoute un bloc de sous-tâche au projet sélectionné
 */
    $('body').on('click', '.add_subtask', function (e) {
        e.preventDefault();
        if (y < maxField) {
            y++; //Incrémente le champs du nombre de sous-tâcehs
            var subtaskName = $(this).parent().find('.project_id').attr('name');
            var projectNumber = subtaskName.substring(8, subtaskName.indexOf(']'));

            var subtask = subtaskClone.clone();
            subtask.find('.subtask_id').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][subtask_id]');
            subtask.find('.task').not(':first').remove();
            fillAssignations(subtask.find('.task'), projectNumber, y, x);
            subtask.find('.task_name').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][task_name]');
            subtask.find('.comment_text.comment').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][comment]');
            subtask.find('.user_id').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][user]');
            console.log(subtask.find('.task_name').attr('name'));

            var blocTask = $(this).parent().find('.subtasks');
            $(blocTask).append(subtask); //Ajoute le html et les noeuds du DOM à l'ensemble des sous-tâcehs du projet
            var selectToFill = $(this).parent().find('select.subtask_id').last();
            var subtasks = $.get("/subtasks", {
                "project_id": $(this).parent().find('input.projecttypeahead').val()
            }, function (data) {

                selectToFill.find('option')
                    .remove()
                    .end();
                data.forEach(function (e, i) {
                    selectToFill.append($('<option></option>')
                        .val(e.id)
                        .text(e.name));
                });
            });


            $('input.usertypeahead').each(function (index) {
                $(this).typeahead({
                    source: function (query, process) {
                        return $.get('/userautocomplete', {
                            query: query
                        }, function (data) {
                            return process(data);
                        });
                    },
                    updater: function (obj) {
                        $('.user_id').val(obj.id);
                        return obj;
                    },
                });
            });

        }
        return false;
    });

    /**
     * Au click sur le bouton de suppression de la sous-tache, supprime l'élément lié.
     */
    $('body').on('click', '.remove_sub ', function (e) {
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        y--; //Decrement field counter
        console.log(y);
        return false;
    });

   /**
    * Au click sur le bouton d'ajout de projet en bas de page. 
    * Ajoute un bloc projet.
    */
    $('body').on('click', '.add_project', function (e) {
        e.preventDefault();
        console.log("hola");
        if (z < maxField) {
            z++;
            var project = projectClone.clone();
            project.find('.project_id').attr('name', 'project[' + z + '][project_id]');
            project.find('.subtask').remove();

            var blocTask = $(this).parent().children(3).children()[2];
            $(blocTask).append(project); //Add field html
            //Increment field counter

            $('input.projecttypeahead').each(function (index) {
                var $this = $(this);
                $(this).typeahead({
                    source: function (query, process) {
                        return $.get('/projectautocomplete', {
                            query: query
                        }, function (data) {
                            return process(data);
                        });
                    },
                    updater: function (obj) {
                        var subtasks = $.get("/subtasks", {
                            "project_id": obj.name
                        }, function (data) {
                            $this.parent().parent().parent().find('select[name=subtask]').find('option')
                                .remove()
                                .end();
                            data.forEach(function (e, i) {
                                $this.parent().parent().parent().find('select[name=subtask]').append($('<option></option>')
                                    .val(e.id)
                                    .text(e.name));
                            });
                        });
                        $this.parent().find('.project_id').val(obj.id);
                        return obj;
                    }
                });
            });

        }
        return false;
    });
    
    /**
     * Bouton de suppression du bloc projet.
     * Supprime le bloc projet lié
     */
    $('body').on('click', '.remove_project ', function (e) {
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Enlève le champ html
        z--; //Décrémente le compteur du nombre de projet
        console.log(y);
        return false;
    });

    /**
     * Bouton pour ouvrir le champ commentaire
     */
    $('body').on('click', '.toggle_comment_box', function (e) {
        e.preventDefault();
        $(this).next().show();
    });

/**
 * Bouton pour valider le commentaire écrit
 */
    $('body').on('click', '.comment_box .validate', function (e) {
        e.preventDefault();
        $(this).parent().hide();
    });

/**
 * Bouton pour valider l'assignation remplie et fermer le formulaire lié. 
 */
    $('body').on('click', '.assignation_ok', function (e) {
        e.preventDefault();
        $(this).parent().parent().find('i').removeClass( "fa-plus" ).addClass( "fa-calendar-alt" );

        var hasCheckedType = false;
        $(this).parent().find('.types div label input').each(function(index, e){
            if(e.checked) hasCheckedType = true;
        });
        if(!hasCheckedType || $(this).parent().find('.duration').val()>8 || $(this).parent().find('.duration').val()<=0 || $(this).parent().find('.duration').val().length<1)
        {
                if(!hasCheckedType)
                {
                    var typeError = '<div class="col-12 typeError"><p style="font-size:11px; color:#f00;">Choisis au moins un type</p></div>';
                    if(!$(this).parent().find('.typeError')[0])$(this).parent().find('.types').append(typeError);
                }
                if($(this).parent().find('.duration').val()>8 || $(this).parent().find('.duration').val()<=0 || $(this).parent().find('.duration').val().length<1)
                {   
                    var durationError = '<div class="col-12 durationError"><p style="font-size:11px; color:#f00;">Indiquer une durée de max. 8 heures.</p></div>';
                    if(!$(this).parent().find('.durationError')[0])$(this).parent().find('.duration').after(durationError);
                }
        }
        else
        {
            if($(this).parent().find('.typeError')[0])$(this).parent().find('.typeError').remove();
            if($(this).parent().find('.durationError')[0])$(this).parent().find('.durationError').remove();
            $(this).parent().hide();
        }       
    });

    /**
     * Bouton d'annulation d'une assignation. Cela supprimetoutes les données entrées dans le formulaire
     */
    $('body').on('click', '.assignation_cancel', function (e) {
        e.preventDefault();
        $(this).parent().parent().find('i').removeClass( "fa-calendar-alt" ).addClass( "fa-plus" );
        /* ICI: delete all data*/
        $(this).parent().find('input').not(':button, :submit, :reset, :hidden').val('');
        $(this).parent().find('input[type=checkbox]').prop('checked', false);
        if($(this).parent().find('.typeError')[0])$(this).parent().find('.typeError').remove();

        $(this).parent().hide();
    });

/**
 * Au click sur le + pour ajouter une assignation
 * Ouvre le formulaire pour remmplir et ajouter une asignation
 */
    $('body').on('click', '.assignation_button', function (e) {
        e.preventDefault();
        $(this).next().show();
    });



/*  Fonction permettant de remplir le petit calendrier des assignations de chaque tâche,
    avec le noms corrects pour la structure de données envoyée en POST par le formulaire*/
    function fillAssignations(thisTask, projectNumber, subtaskNumber, taskNumber) {
        thisTask.find('.assignation_form').remove();
        thisTask.find('.assignations tr td').each(function (index, e) {
            //0=lundi, 1=mardi, ...
            var assignation_form = assignationClone.clone();
            /*suiviDA incrément*/
            assignation_form.find('.suiviDA').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][suiviDA]');
            /*duration incrément*/
            assignation_form.find('.duration').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][duration]');

            /*types increment*/
            //.typeB, .typeD, .typeRC, .typePC, .typeL, .typeRDV,.typeBO,.typeRG
            assignation_form.find('.typeB').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeB]');
            assignation_form.find('.typeD').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeD]');
            assignation_form.find('.typeRC').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeRC]');
            assignation_form.find('.typePC').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typePC]');
            assignation_form.find('.typeL').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeL]');
            assignation_form.find('.typeRDV').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeRDV]');
            assignation_form.find('.typeBO').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeBO]');
            assignation_form.find('.typeRG').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][typeRG]');

            /*unmovable increment*/
            assignation_form.find('.unmovable').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][unmovable]');

            /*set increment + date to assignation*/
            assignation_form.find('.dateAssignation').attr('name','project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][date]');

            assignation_form.find('.dateAssignation').val(setDate(index));
            //console.log(setDate());

            assignation_form.appendTo(e);


        });
    }

    /**
     * Check que chaque tâche ait au moins une assignation à la sauvegarde, sinon reste sur la page et affiche un messsage.
     */
    $('form').submit(function() {

        var allTasksHaveAssignation = true;
        $('.assignations').each(function(index, e){

            var thereisAssignation = false;
            $(this).find('td i').each( function (index, el)
            {
                if($(this).attr('class').search("fa-calendar-alt")>-1)
                {
                    thereisAssignation =true;
                }
                
            });

            if(!thereisAssignation) 
            {
                console.log($(this).parent());
                if(!$(this).parent().find('.assignationError')[0])$(this).parent().append('<p style="color:red; font-style:italic;" class="assignationError">Il faut minimum une assignation par tâche.</p>');
                allTasksHaveAssignation = false;
            }
            
        });
        return allTasksHaveAssignation; // return false to cancel form action
    });


});
