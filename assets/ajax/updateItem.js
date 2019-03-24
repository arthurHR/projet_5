require('jquery-form');


window.UpdateSkill = function(id){
    var updateSkill = Object.create(updateItem);
    var eventItem = $('#skill_update_Modal');
    var url = '/updateSkill';
    var formId = '#form_skill_update';
    var reload_target = ' #skills';;
    updateSkill.init(eventItem, url, formId, reload_target, id);
    
};

window.UpdateProject = function(id){
    var updateProject = Object.create(updateItem);
    var eventItem = $('#project_update_Modal');
    var url = '/updateProject';
    var formId = '#form_project_update';
    var reload_target = ' #projects';
    updateProject.init(eventItem, url, formId, reload_target, id);             
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

