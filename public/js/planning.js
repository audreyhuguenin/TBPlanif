
var taskElement = $('.task').clone();
var maxField = 100; //Input fields increment limitation
var addButton = $('.add_task'); //Add button selector
var wrapper = $('#tasks'); //Input field wrapper
var fieldHTML ='<div class="task">'
                    +'<div class="row">'
                    +'<button class="remove_button btn btn-danger col-1"><i class="fas fa-trash-alt"></i></button>'
                    +'<div class="row col-11">'
                    +'<div class="col-9">'
                    +'<input autocomplete="off" class="" placeholder="Nom de la tâche" name="task_name[]" type="text" value="">'
                    +'</div>'
                    +'<div class="col-3">'
                    +'<input class="comment" autocomplete="off" placeholder="comment" name="comment[]" type="text" value="">'
                    +'</div>'
                    +'<input class="usertypeahead" autocomplete="off" placeholder="Qui qui doit faire?" name="user_typeahead[]" type="text" value="">'
                    +'<input class="user_id" name="user[]" type="hidden" value="">'
                    +'</div>'
                    +'</div></div>'
//'<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button"><i class="fas fa-trash-alt"></i></a></div>'; //New input field html
var x = 1; //Initial field counter is 1

$(addButton).click(function(e){
    e.preventDefault();
    if(x < maxField){ 
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
    }
    
    console.log(taskElement);
    return false;
});
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e)
    {        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
        return false;
    });
