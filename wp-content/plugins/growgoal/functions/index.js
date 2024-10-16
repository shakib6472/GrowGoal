
jQuery(document).ready(function($){
    
    $('.answer.submit.retry').click(function (e) { 
        e.preventDefault();
        window.reload();
        $(selector).removeClass(className);
        $(selector).attr('type', 'button');
    });

});
