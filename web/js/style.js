function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}


$(function () {

    $('#openNav').click(function () {
        document.getElementById("myNav").style.width = "100%";
    });
    $('#closeNav').click(closeNav);
});