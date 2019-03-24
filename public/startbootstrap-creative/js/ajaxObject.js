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
    var reload_target = ' #skills';;
    updateSkill.init(eventItem, url, formId, reload_target, id);
    
};

function UpdateProject(id){
    var updateProject = Object.create(updateItem);
    var eventItem = $('#project_update_Modal');
    var url = '/updateProject';
    var formId = '#form_project_update';
    var reload_target = ' #projects';
    updateProject.init(eventItem, url, formId, reload_target, id);             
};

function previewFile(input) { 
    var changeImage = Object.create(modifyImage);  
    changeImage.init(input);  
};


$(document).ready(function(){

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

    updateHeader = Object.create(addItem);
    var eventItem = $('#header_update_Modal');
    var url = '/updateHeader';
    var formId = '#form_header';
    var reload_target = ' #header';
    updateHeader.init(eventItem, url, formId, reload_target);

    updateAbout = Object.create(addItem);
    var eventItem = $('#about_update_Modal');
    var url = '/updateAbout';
    var formId = '#form_about';
    var reload_target = ' #about';
    updateAbout.init(eventItem, url, formId, reload_target);

    sendMessage = Object.create(addItem);
    var eventItem = $('#message_Modal');
    var url = '/sendMessage';
    var formId = '#form_message';
    var reload_target = ' #message';
    sendMessage.init(eventItem, url, formId, reload_target);
    
});

var modifyImage = {
    preview : null,
    file : null,
        
    init : function(input) {
        var divParent = input.parentElement.parentElement;
        var image = $(divParent).find('img');
        this.preview = image[0];
        this.file = input.files[0];
        if (this.preview == null){
            $('.vich-image').append("<img/>");
            var image = $(divParent).find('img');
            this.preview = image[0];
        };

        objet = this;
        var reader  = new FileReader();
        reader.addEventListener("load", function () {
            objet.preview.src = reader.result;            
        }, false);
    
        if (this.file) {
         reader.readAsDataURL(this.file);
        };
    },
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




var addItem = {
    eventItem : null,
    url : null,
    formId : null,
    reload_target : null,

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

    init : function (eventItem, url, formId, reload_target, id)
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
                    objet.submitForm();          
                },
            });
            
    },

    submitForm : function () {
        var objet = this;
        $(objet.formId).on('submit', function(e){
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


    