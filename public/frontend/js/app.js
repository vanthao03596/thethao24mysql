$(document).ready(function() {
    $("#pc_menu").click(function() {
        $("#topmenu").animate({
            left: "+=50",
            height: "toggle"
        }, 500, function() {
            // Animation complete.
            var status = false;
            if ($("#topmenu").css("display") == 'none')
                status = false;
            else
                status = true;
            if (status)
                $("#menu").hide();
            else
                $("#menu").show();
        });
    });
})