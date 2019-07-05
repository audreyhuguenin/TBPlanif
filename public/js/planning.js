
var maxField = 100; //Input fields increment limitation
var addButton = $('.add_task'); //Add button selector
var addButtonSubtask = $('.add_subtask');
var x = 1; //Compteur de tâches ajoutées
var y = 1; //Initial field counter is 1


//Action du clique sur le bouton d'ajout de tâche. Cela a comme effet d'ajouter un bloc complet de tâche comprenant nom de la tâche, commentaire et user.

$('body').on('click', '.add_task', function(e){
    e.preventDefault();
    if(x < maxField){ 
        x++; 
        var fieldHTML ='<div class="task">'
                    +'<div class="row">'
                    +'<button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>'
                    +'<div class="row col-11">'
                    +'<input autocomplete="off" class="" placeholder="Nom de la tâche" name="task[task'+ x +'][task_name]" type="text" value="">'
                    +'<input class="comment" autocomplete="off" placeholder="comment" name="task[task'+ x +'][comment]" type="text" value="">'
                    +'<input class="usertypeahead" autocomplete="off" placeholder="Qui qui doit faire?" name="user_typeahead[]" type="text" value="">'
                    +'<input class="user_id" name="task[task'+ x +'][user]" type="hidden" value="">'
                    +'</div>'
                    +'</div></div>'

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


$(addButtonSubtask).click(function(e){
    e.preventDefault();
    if(y < maxField){ 
        y++; 
        var fieldHTML =
                    '<div class="subtask"><div class="row"><div class="col-3">'
                    +'<select name="subtask"><option value="placeholder">Sous-tâche</option></select></div>'
                    +'<div class="col-9"><div class="tasks">'
                    +'<div class="task">'
                    +'<div class="row">'
                    +'<button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>'
                    +'<div class="row col-11">'
                    +'<input autocomplete="off" class="" placeholder="Nom de la tâche" name="task[task1][task_name]" type="text" value="">'
                    +'<input class="comment" autocomplete="off" placeholder="comment" name="task[task1][comment]" type="text" value="">'
                    +'<input class="usertypeahead" autocomplete="off" placeholder="Qui qui doit faire?" name="user_typeahead[]" type="text" value="">'
                    +'<input class="user_id" name="task[task1][user]" type="hidden" value="">'
                    +'</div>'
                    +'</div></div>'
                    +'</div><button class="add_task btn btn-danger">+ Add new task</button></div></div></div>'
        
        var blocTask = $(this).parent().children(2)[3];  
        $(blocTask).append(fieldHTML); //Add field html
        //Increment field counter

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
 $(wrapper).on('click', '.remove_button', function(e)
{        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
        return false;
});