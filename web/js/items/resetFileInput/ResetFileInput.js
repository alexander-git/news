var ResetFileInput = function(fileInputSelector, resetButtonSelector) {
    
    $(resetButtonSelector).click(function(e) {
        $(fileInputSelector).val('');
    });

};