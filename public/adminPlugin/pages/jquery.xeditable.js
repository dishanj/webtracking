
/**
* Demo: Editable (Inline editing)
* 
*/

$(function(){

  //modify buttons style
  $.fn.editableform.buttons = 
    '<button type="submit" class="btn btn-primary btn-sm editable-submit waves-effect waves-light"><i class="zmdi zmdi-check"></i></button>' +
    '<button type="button" class="btn editable-cancel btn-sm btn-secondary waves-effect"><i class="zmdi zmdi-close"></i></button>';

  //Inline editables
  $('#inline-duty-amount').editable({
      type: 'text',
      pk: 1,
      name: 'username',
      title: 'Enter username',
      mode: 'inline',
      inputclass: 'form-control-sm'
  });

});