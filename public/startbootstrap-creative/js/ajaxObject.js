function DeleteSkill(id){
    deleteSkill = Object.create(deleteItem);
    var url = ('/deleteSkill');
    var reload_target = ' #skills';
    deleteSkill.init(id, url, reload_target);
};

function DeleteProject(id){
    deleteProject = Object.create(deleteItem);
    var url = ('/deleteProject');
    var reload_target = ' #projects';
    deleteProject.init(id, url, reload_target);
}; 


function UpdateSkill(id){
    var updateSkill = Object.create(updateItem);
    var eventItem = $('#skill_update_Modal');
    var url = '/updateSkill';
    var formId = '#form_skill_update';
    var reload_target = ' #skills';
  
    updateSkill.init(eventItem, url, formId, id, reload_target); 
    
    $(document).on('submit', formId , function(e){
        updateSkill.submitForm(e); 
        delete updateSkill.submitForm();
    });             
};

function UpdateProject(id){
    var updateProject = Object.create(updateItem);
    var eventItem = $('#project_update_Modal');
    var url = '/updateProject';
    var formId = '#form_project_update';
    var reload_target = ' #projects';
  
    updateProject.init(eventItem, url, formId, id, reload_target); 
    
    $(document).on('submit', formId , function(e){
        updateProject.submitForm(e); 
        delete updateProject.submitForm();
    });             
};

function previewFile() {
    
    changeImage.init();
    delete changeImage.init();
};
 
var modifyImage = {
        init : function () {
            var preview = document.querySelector('.form-group img');
            var file    = document.querySelector('.custom-file input[type=file]').files[0];
            alert('hi');
            console.log(preview);
            console.log(file);
            var reader  = new FileReader();
            console.log(reader);
            reader.addEventListener("load", function () {
            preview.src = reader.result;
            });
        
            if (file) {
            reader.readAsDataURL(file);
            console.log(file);
            };
        },
};


$(document).ready(function(){
    changeImage = Object.create(modifyImage);

    addSkill = Object.create(addItem);
    var eventItem = $('#skill_add_Modal');
    var url = '/addSkill';
    var formId = '#form_skill';
    var reload_target = ' #skills';
    addSkill.init(eventItem, url, formId, reload_target);

    addProject = Object.create(addItem);
    var eventItem = $('#project_add_Modal');
    var url = '/addProject';
    var formId = '#form_project';
    var reload_target = ' #projects';
    addProject.init(eventItem, url, formId, reload_target); 

    updateAbout = Object.create(addItem);
    var eventItem = $('#about_update_Modal');
    var url = '/updateAbout';
    var formId = '#form_about';
    var reload_target = ' #about';
    updateAbout.init(eventItem, url, formId, reload_target);
    
});


var deleteItem =  { 
    id : null,
    url : null, 
    reload_target : null,

    /* --------------------------------------------*/
    /* Méthode d'initialisation                    */
    /*---------------------------------------------*/
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

//////////////////////////////////////////////////////////////////////////////////////////////



var addItem = {
    eventItem : null,
    url : null,
    formId : null,
    reload_target : null,

    /* --------------------------------------------*/
    /* Méthode d'initialisation                    */
    /*---------------------------------------------*/
    init : function (eventItem, url, formId, reload_target) 
    {
        this.eventItem = eventItem;
        this.url = url;
        this.formId = formId;
        this.reload_target = reload_target;
        this.getForm();
        this.submitForm();   
    },

    getForm : function () 
    {
        var objet = this;
        this.eventItem.on('shown.bs.modal', function () {
            var modal = $(this);  
            $.ajax({
                url : objet.url,
                method: 'post',
                success: function(data) {
                    modal.find('.modal-body').html(data);          
                },
            });
        });
    },

    submitForm : function () {
        var objet = this;
        $(document).on('submit', objet.formId , function(e){
            e.preventDefault();
            $form = $(e.target);
            modal = objet.eventItem;
            var $submitButton = $form.find(':submit');
            $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
            $submitButton.prop('disabled', true);
            $form.ajaxSubmit({
                type: 'post',
                success: function(data) {
                    if (data == objet.reload_target){
                        modal.modal('toggle');
                        $(objet.reload_target).load(objet.reload_target);
                    } else {
                        alert('Un problème est survenu durant le chargement');
                    };
                },
                error: function(jqXHR, status, error) {
                      $submitButton.html(button.data('label'));
                      $submitButton.prop('disabled', false);
                }
            });
        });
    }
};

var updateItem = {
    eventItem : null,
    url : null,
    formId : null,
    id : null,
    reload_target : null,

    /* --------------------------------------------*/
    /* Méthode d'initialisation                    */
    /*---------------------------------------------*/
    init : function (eventItem, url, formId, id, reload_target) 
    {
        this.eventItem = eventItem;
        this.url = url;
        this.formId = formId;
        this.id = id;
        this.reload_target = reload_target;
        this.getForm();
    },

    getForm : function () 
    {
        var objet = this;
        var modal = objet.eventItem;
            modal.modal('show'); 
            $.ajax({
                url : objet.url,
                method: 'post',
                data: {'id': objet.id},
                success: function(data) {
                    modal.find('.modal-body').html(data);          
                },
            });
        
    },

    submitForm : function (e) {
        var objet = this;
        
            e.preventDefault();
            $form = $(e.target);
            modal = objet.eventItem;
            var $submitButton = $form.find(':submit');
            $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
            $submitButton.prop('disabled', true);
            $form.ajaxSubmit({
                type: 'post',
                success: function(data) {
                    if (data == objet.reload_target){
                        modal.modal('toggle');
                        $(objet.reload_target).load(objet.reload_target);
                    } else {
                        alert('Un problème est survenu durant le chargement');
                    };
                },
                error: function(jqXHR, status, error) {
                      $submitButton.html(button.data('label'));
                      $submitButton.prop('disabled', false);
                }
            });
    }

   
};


    