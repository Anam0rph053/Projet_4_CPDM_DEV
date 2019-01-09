function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}

function openNav(){
    document.getElementById("myNav").style.width = "100%";
}

$(function () {

    $('#openNav').click(openNav);
    $('#closeNav').click(closeNav);
});