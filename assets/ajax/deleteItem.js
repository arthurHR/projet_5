require('jquery-form');


window.DeleteSkill = function(id){
    deleteSkill = Object.create(deleteItem);
    var url = ('/deleteSkill');
    var reload_target = ' #skills';
    deleteSkill.init(id, url, reload_target);
};

window.DeleteProject = function(id){
    deleteProject = Object.create(deleteItem);
    var url = ('/deleteProject');
    var reload_target = ' #projects';
    deleteProject.init(id, url, reload_target);
}; 


var deleteItem =  { 
    id : null,
    url : null, 
    reload_target : null,

    init : function (id, url, reload_target) 
    {
        this.id = id;
        this.url = url;
        this.reload_target = reload_target;
        this.ajax(); 
    },

    ajax : function () 
    {
        var objet = this;
        $.ajax({  
            url: (this.url),
            data: {'id': this.id},
            method: 'post',
            success: function (data) {
                if (data == objet.reload_target){
                    $(objet.reload_target).load(objet.reload_target);
                } else {
                    alert('Un problème est survenu durant le chargement');
                };
            },
            error: function () {
                alert("la compétence n'a pas pu être identifiée");
            },
        });
    },
};