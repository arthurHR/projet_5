require('jquery-form');

$(document).ready(function(){

    sendMessage = Object.create(messageObject);
    var eventItem = $('#message_Modal');
    var url = '/sendMessage';
    var formId = '#form_message';
    var reload_target = ' #message';
    sendMessage.init(eventItem, url, formId, reload_target);

});

var messageObject = {
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