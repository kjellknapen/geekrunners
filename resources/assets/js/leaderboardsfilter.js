$(document).ready(function(){
    // Hide leaderboards but show active!
    $('.leaderboard').hide();
    var show = $('#filter').val();
    $('#' + show).show();

    // Change leaderboard
    $("#filter").on('change', function(){
        var value = $(this).val();
        $('.leaderboard').hide();
        $("#" + value).show();
    });
});