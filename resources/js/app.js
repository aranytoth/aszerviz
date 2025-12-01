import './bootstrap';
import './gallery';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    $('.lang-selector label').each(function(){
        $(this).click(function(){
            $('.lang-selector label.selected').removeClass('selected');
            $(this).addClass('selected');
        })
    })
});