function Delete(id){
    itemId = id;
    $.ajax({  
        url: ('/deleteSkill'),
        data: {'id':itemId},
        method: 'post',
        success: function (data) {
            if (data == "skill"){
                $(" #skills").load(" #skills");
            } else {
                alert(data);
            };
        },
        error: function () {
            alert("la compétence n'a pas pu être identifiée");
        },
    }); 
};

function Update(id){
    itemId = id;
    var modal = $('#skillModal');
    modal.modal('show');
    $.ajax({  
        url: ('/updateSkill'),
        data: {'id':itemId},
        method: 'post',
        success: function(data) {
            modal.find('.modal-body').html(data);
        },
        error: function () {
            alert("la compétence n'a pas pu être identifiée");
        },
    }); 

};
  
    



    $(document).on("submit", "#form_skill_update" , function(e){
        

        e.preventDefault();
        $form = $(e.target);
        modal = $('#skillModal');
        var $submitButton = $form.find(':submit');
        $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
        $submitButton.prop('disabled', true);
        $form.ajaxSubmit({
            type: 'post',
            success: function(data) {
                if (data == "skill"){
                    alert('hi');
                    modal.modal('toggle');
                    $(" #skills").load(" #skills");
                } else {
                    alert('ho');
                    modal.modal('toggle');
                    $(" #project").load(" #project");
                };
            },
            error: function(jqXHR, status, error) {
                  $submitButton.html(button.data('label'));
                  $submitButton.prop('disabled', false);
            }
        });
    }) ;
