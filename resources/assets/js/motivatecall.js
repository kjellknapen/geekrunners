/**
 * Created by kjell on 15.12.17.
 */
$(document).ready(function(){

    function getMotivation(){
        $.ajax({
            method: "GET",
            url: "/api/motivate"
        }).done(function( msg ) {
            console.log( msg );
            $("#distance").text("Reach "+ msg.distance_goal +" km in 1 session");
            $("#fequency").text("Run "+ msg.frequency_goal +" times this week");
            $("#amount-completed").text(msg.users_completed.length + " completed this");

            $(".ul-users").empty();
            $.each(msg.users_completed, function(index, items){
               $(".ul-users").append('<a href="/user/' + items.id + '"><li class="img-completed" title="' + items.firstname + ' ' + items.lastname + '"><img src="' + items.avatar + '" alt="' + items.firstname + ' ' + items.lastname + '"></li></a>');
            });
        });

        $('.tooltip').tooltipster({
            theme: 'tooltipster-noir'
        });
        setTimeout(getMotivation, 300000);
    }

    setTimeout(getMotivation, 300000);
});