
var maxField = 100; //Input fields increment limitation
var x = 1; //Compteur de tâches ajoutées
var y = 1; //Initial field counter is 1
var z = 1;


//Action du clique sur le bouton d'ajout de tâche. Cela a comme effet d'ajouter un bloc complet de tâche comprenant nom de la tâche, commentaire et user.

$('body').on('click', '.add_task', function(e){
    e.preventDefault();
    if(x < maxField){ 
        x++; 
        var subtaskName = $(this).parent().parent().find('.subtask_id').attr('name');
        var projectNumber = subtaskName.substring(8, subtaskName.indexOf(']'));
        var nameCut = subtaskName.substring([subtaskName.indexOf('subtask')+9]);
        var subtaskNumber =nameCut.substring(0, nameCut.indexOf(']'));

        var fieldHTML ='<div class="task">'
                    +'<div class="row">'
                    +'<button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>'
                    +'<div class="row col-11">'
                    +'<input autocomplete="off" class="" placeholder="Nom de la tâche" name="project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+ x +'][task_name]" type="text" value="">'
                    +'<div class="comment"><button class="toggle_comment_box"><i class="far fa-comment"></i></button>'
                    +'<div class="comment_box">'
                    +'<textarea maxlength="250" class="comment_text comment" autocomplete="off" placeholder="Ton commentaire (facultatif)" name="project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+x+'][comment]"></textarea>'
                    +'<button class="validate btn btn-outline-dark">Ok</button>'
                    +'</div></div>'
                    +'<input class="usertypeahead" autocomplete="off" placeholder="Qui qui doit faire?" name="user_typeahead[]" type="text" value="">'
                    +'<input class="user_id" name="project['+projectNumber+'][subtask]['+subtaskNumber+'][task]['+x+'][user]" type="hidden" value="">'
                    +'</div>'
                    +'</div></div>';

                    
          var blocTask = $(this).parent().children(0)[0];   
          
        $(blocTask).append(fieldHTML); //Add field html

    $('input.usertypeahead').each(function( index ) {
    $(this).typeahead({
    source:  function (query, process) {
    return $.get('/userautocomplete', { query: query }, function (data) {
            return process(data);
            });      
    },
    updater: function(obj){  
      $('.user_id').val(obj.id);
      return obj ;
    },   
});
});

    }
    return false;
});
    
//Quand le bouton de suppression de la tâche est cliqué, supprime l'élément lié. 
$('body').on('click', '.remove_button',  function(e){
    e.preventDefault();
    //console.log($(this).parent().parent().parent('div'));
    $(this).parent().parent('div').remove(); //Remove field html
    x--; //Decrement field counter
    console.log(x);
    console.log($(this).parent().parent());
    if(x==0)
    {  
    console.log('supprimer sous tâche');  
    }
    return false;
});

//Au click du bouton d'ajout de sous-tâche
$('body').on('click', '.add_subtask', function(e){
    e.preventDefault();
    if(y < maxField){ 
        y++; 

        var subtaskName = $(this).parent().find('.project_id').attr('name');
        var projectNumber = subtaskName.substring(8, subtaskName.indexOf(']'));
              
        var fieldHTML =
                    '<div class="subtask"><div class="row"><a class="remove_sub" style="margin-top:10px;"><i class="fas fa-times"></i></a><div class="col-3">'
                    +'<select name="project['+projectNumber+'][subtask]['+y+'][subtask_id]" class="subtask_id"><option value="placeholder">Sous-tâche</option></select></div>'
                    +'<div class="col-8"><div class="tasks">'
                    +'<div class="task">'
                    +'<div class="row">'
                    +'<button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>'
                    +'<div class="row col-11">'
                    +'<input autocomplete="off" class="" placeholder="Nom de la tâche" name="project['+projectNumber+'][subtask]['+y+'][task]['+x+'][task_name]" type="text" value="">'
                    +'<div class="comment"><button class="toggle_comment_box"><i class="far fa-comment"></i></button>'
                    +'<div class="comment_box">'
                    +'<textarea maxlength="250" class="comment_text comment" autocomplete="off" placeholder="Ton commentaire (facultatif)" name="project['+projectNumber+'][subtask]['+y+'][task]['+x+'][comment]"></textarea>'
                    +'<button class="validate btn btn-outline-dark">Ok</button>'
                    +'</div></div>'
                    +'<input class="usertypeahead" autocomplete="off" placeholder="Qui qui doit faire?" name="user_typeahead[]" type="text" value="">'
                    +'<input class="user_id" name="project['+projectNumber+'][subtask]['+y+'][task]['+x+'][user]" type="hidden" value="">'
                    +'</div>'
                    +'</div></div>'
                    +'</div><button class="add_task btn btn-danger">+ Add new task</button></div></div></div>'
        
        var blocTask = $(this).parent().find('.subtasks');  
        $(blocTask).append(fieldHTML); //Add field html
        //Increment field counter
        var selectToFill= $(this).parent().find('select.subtask_id').last();
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


    $('input.usertypeahead').each(function( index ) {
    $(this).typeahead({
    source:  function (query, process) {
    return $.get('/userautocomplete', { query: query }, function (data) {
            return process(data);
            });      
    },
    updater: function(obj){  
      $('.user_id').val(obj.id);
      return obj ;
    },   
});
});

    }
    return false;
});
    
//Quand le bouton de suppression de la sous-tâche est cliqué, supprime l'élément lié. 
 $('body').on('click', '.remove_sub ', function(e)
{       e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        y--; //Decrement field counter
        console.log(y);
        return false;
});



//Au click du bouton d'ajout de projet
$('body').on('click', '.add_project', function(e){
    e.preventDefault();
    console.log("hola");
     if(z < maxField){ 
        z++; 
        var fieldHTML =
                    '<div class="project" style="border-bottom: 1px lightgray solid;">'
                    +'<div class="row"><a class="remove_project" style="margin-top:10px;"><i class="fas fa-times"></i></a>'
                    +'<div class="col-11">'  
                    +'<input class="projecttypeahead" autocomplete="off" placeholder="Choisis le projet" name="project_typeahead" type="text" value=""></input>'  
                    +'<input class="project_id" name="project['+z+']" type="hidden" value="9990">'
                    +'</div></div>'
                    +'<div class="subtasks"></div>'
                    +'<button class="add_subtask btn btn-danger">+ Add subtask</button></div></div>';
        
    console.log($(this).parent().children(3).children()[2]);          
        var blocTask = $(this).parent().children(3).children()[2];  
        $(blocTask).append(fieldHTML); //Add field html
        //Increment field counter

    $('input.projecttypeahead').each(function( index ) {
        var $this = $(this);  
    $(this).typeahead({
    source:  function (query, process) {
    return $.get('/projectautocomplete', { query: query }, function (data) {
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
$('body').on('click', '.remove_project ', function(e)
{      
        e.preventDefault();
        $(this).parent().parent('div').remove(); //Remove field html
        y--; //Decrement field counter
        console.log(y);
        return false;
});


$('body').on('click', '.toggle_comment_box', function(e)
{
    e.preventDefault();
    $(this).next().show();
});


$('body').on('click', '.validate', function(e)
{
    e.preventDefault();
    $(this).parent().hide();
});

$('body').on('click', '.assignation_button', function(e)
{
    e.preventDefault();
    $(this).next().show();
});