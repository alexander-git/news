// FileControl нужно создавать после загрузки DOM(в $(document).ready() ).
var FileControl = function(ID) {
    
    var FILE_NOT_SELECTED_STATE = 0;
    var FILE_SELECTED_STATE = 1;
    var FILE_UPLOADED_STATE = 2;
    
 
    var _state = null;
    var _isFileExist = null; // Есть ли на сервере файл изначально.
    var _initialFileName = null;
    var Sel = new FileControlSelectors(ID);
    init();
    
    function init() {
        determineState();
        _isFileExist = (_state === FILE_UPLOADED_STATE);
        if (_isFileExist) {
            _initialFileName = $(Sel.FILE_NAME).val(); // Запомним имя файла, которое было изначально.
        }
        updateView();
        updateChangedHiddenField();
    }
    
    $(Sel.DELETE_BUTTON).click(function(e) { 
        determineState();
        if (_state === FILE_SELECTED_STATE) {
            _state === FILE_NOT_SELECTED_STATE;
        } else if (_state === FILE_UPLOADED_STATE) {
            _state === FILE_NOT_SELECTED_STATE;
        }
        updateView();
        updateChangedHiddenField();
    });  
    
    function determineState() {
        if ($(Sel.FILE_NAME).val() !== '') {
            _state = FILE_UPLOADED_STATE;
        } else if ($(Sel.FILE).val() !== '') {
            _state = FILE_SELECTED_STATE;
        } else {
            _state = FILE_NOT_SELECTED_STATE;
        }
    }
    
    function updateView() {
        if (_state === FILE_NOT_SELECTED_STATE) {
            $(Sel.FILE_NAME).val('');
            $(Sel.FILE).val('');
            $(Sel.FILE_NAME).hide();
            $(Sel.FILE).show();
        } else if (_state === FILE_SELECTED_STATE) {
            $(Sel.FILE_NAME).val('');
            $(Sel.FILE_NAME).hide();
            $(Sel.FILE).show();
        } else if (_state === FILE_UPLOADED_STATE) {
            $(Sel.FILE_NAME).show();
            $(Sel.FILE).hide();
        } else {
            throw new Error();
        }
    }
    
    function updateChangedHiddenField() {
        if (_state === FILE_NOT_SELECTED_STATE) {
            if (_isFileExist) {
                $(Sel.IS_CHANGED).val(1);
            } else {
                $(Sel.IS_CHANGED).val(0);
            }
        } else if (_state === FILE_SELECTED_STATE) {
            $(Sel.IS_CHANGED).val(1);
        } else if (_state === FILE_UPLOADED_STATE) {
            if (_isFileExist) {
                $(Sel.IS_CHANGED).val(0);
            } else {
                $(Sel.IS_CHANGED).val(1);
            }
        }
    }
       
};
