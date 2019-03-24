require('jquery-form');

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

});

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