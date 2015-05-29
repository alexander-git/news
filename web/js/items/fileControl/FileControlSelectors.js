var FileControlSelectors = function(ID) {
    this.FILE_CONTROL = '#' + ID;
    this.FILE_NAME = this.FILE_CONTROL + ' .fileControl__fileName';
    this.FILE = this.FILE_CONTROL + ' .fileControl__file';
    this.DELETE_BUTTON = this.FILE_CONTROL + ' .fileControl__deleteButton';
};