
$(document).ready(function () {
   $('#db-check-button').on('click', function () {
       var formData = $('#connection-form').serializeArray();
       $.post(
           "importdata/import-db/db-connection-check",
           formData,
           onAjaxSuccess
       );
   });
   console.log('data');
});


function onAjaxSuccess(data)
{
    // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
    $('.notify').html(data);
}