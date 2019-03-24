window.previewFile = function (input) { 
    var changeImage = Object.create(modifyImage);  
    changeImage.init(input);  
};

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