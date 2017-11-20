/**
 * Created by kjell on 20.11.17.
 */
$(document).ready(function(){
    $(".role-form").on("change", function(){
        console.log("change");
        if($("#teacher").is(":checked")){
            $(".password-field").slideDown();
        }else{
            $(".password-field").slideUp();
        }
    });
});