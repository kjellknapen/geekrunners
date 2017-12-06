/**
 * Created by kjell on 05.12.17.
 */
$(document).ready(function(){
    $('#cb1').on("change", function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
            }
        });
        if($('#cb1:checked').length > 0){
            $.post( "/enablemail", "pls").done(function (data) {
                console.log(data);
                $(".info-text").text("Disable email notifications");
            });
        }else{
            $.post( "/disablemail", "pls").done(function (data) {
                console.log(data);
                $(".info-text").text("Enable email notifications");
            });
        }
    });
});