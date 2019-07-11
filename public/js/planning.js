$(document).ready(function () {
    var maxField = 100; //Input fields increment limitation
    var x = 1; //Compteur de tâches ajoutées
    var y = 1; //Initial field counter is 1
    var z = 1;
    var taskClone = $('.task').first().clone();
    var subtaskClone = $('.subtask').first().clone();
    var projectClone = $('.project').first().clone();
    var assignationClone = $('.assignation_form').first().clone();
    fillAssignations($('.task').first(), z, y, x);

    //Action du clique sur le bouton d'ajout de tâche. Cela a comme effet d'ajouter un bloc complet de tâche comprenant nom de la tâche, commentaire et user.

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

    //Quand le bouton de suppression de la tâche est cliqué, supprime l'élément lié. 
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



    //Au click du bouton d'ajout de sous-tâche
    $('body').on('click', '.add_subtask', function (e) {
        e.preventDefault();
        if (y < maxField) {
            y++;
            var subtaskName = $(this).parent().find('.project_id').attr('name');
            var projectNumber = subtaskName.substring(8, subtaskName.indexOf(']'));

            var subtask = subtaskClone.clone();
            subtask.find('.subtask_id').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][subtask_id]');
            subtask.find('.task').not(':first').remove();
            fillAssignations(subtask.find('.task'));
            subtask.find('.task_name').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][task_name]');
            subtask.find('.comment_text.comment').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][comment]');
            subtask.find('.user_id').attr('name', 'project[' + projectNumber + '][subtask][' + y + '][task][' + x + '][user]');
            console.log(subtask.find('.task_name').attr('name'));

            var blocTask = $(this).parent().find('.subtasks');
            $(blocTask).append(subtask); //Add field html
            //Increment field counter
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

    //Quand le bouton de suppression de la sous-tâche est cliqué, supprime l'élément lié. 
    $('body').on('click', '.remove_sub ', function (e) {
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        y--; //Decrement field counter
        console.log(y);
        return false;
    });

    //Au click du bouton d'ajout de projet
    $('body').on('click', '.add_project', function (e) {
        e.preventDefault();
        console.log("hola");
        if (z < maxField) {
            z++;
            var project = projectClone.clone();
            project.find('.project_id').attr('name', 'project[' + z + ']');
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
                            console.log(data);
                            $this.parent().parent().parent().find('select[name=subtask]').find('option')
                                .remove()
                                .end();
                            data.forEach(function (e, i) {
                                $this.parent().parent().parent().find('select[name=subtask]').append($('<option></option>')
                                    .val(e.id)
                                    .text(e.name));
                            });
                        });
                        $('.project_id').val(obj.id);
                        return obj;
                    }
                });
            });

        }
        return false;
    });
    //Quand le bouton de suppression de la sous-tâche est cliqué, supprime l'élément lié. 
    $('body').on('click', '.remove_project ', function (e) {
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        y--; //Decrement field counter
        console.log(y);
        return false;
    });


    $('body').on('click', '.toggle_comment_box', function (e) {
        e.preventDefault();
        $(this).next().show();
    });


    $('body').on('click', '.validate', function (e) {
        e.preventDefault();
        $(this).parent().hide();
    });

    $('body').on('click', '.assignation_button', function (e) {
        e.preventDefault();
        $(this).next().show();
    });



/*  Fonction permettant de remplir le petit calendrier des assignations de chaque tâche,
    avec le noms corrects pour la structure de données envoyée en POST par le formulaire*/
    function fillAssignations(thisTask, projectNumber, subtaskNumber, taskNumber) {
        thisTask.find('.assignations tr td').each(function (index, e) {
            console.log(e);

            
            //0=lundi, 1=mardi, ...
            var assignation_form = assignationClone.clone();
            /*suiviDA increment*/
            assignation_form.find('.suiviDA').attr('name', 'project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+taskNumber+'][assignations]['+index+'][suiviDA]');
            /*duration increment*/
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

});
