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
                $(".maillabel").text("Disable Email");
                $(".info-text").text("If you don't want to get email notifications about your goals, turn them off right here!");
            });
        }else{
            $.post( "/disablemail", "pls").done(function (data) {
                console.log(data);
                $(".maillabel").text("Enable Email");
                $(".info-text").text("If you want to get email notifications about your goals, turn them on right here!");
            });
        }
    });
});