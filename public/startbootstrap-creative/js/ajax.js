$(document).ready(function(){
    $('.deleteBtn').click(function (e) {
        e.preventDefault();
    
        itemId = $(this).attr('id');
    
        $.ajax({  
            url: ('/deleteSkill'),
            data: {'id':itemId},
            method: 'post',
            success: function () {
                $("#skills").load( "/refreshSkills" );
            },
            error: function () {
                alert("la compétence n'a pas pu être identifiée");
            },
        });
    });    
});