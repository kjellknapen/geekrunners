$(document).ready(function() {
    $('.tooltip').tooltipster({
        theme: 'tooltipster-noir'
    });
});

var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";

$(document).keydown(function(e) {

    kkeys.push( e.keyCode );

    if ( kkeys.toString().indexOf( konami ) >= 0 ) {

        $(document).unbind('keydown',arguments.callee);

        alert("Greetings from Joris, Kjell & Lino");
        $("body").addClass("konami");

    }

});