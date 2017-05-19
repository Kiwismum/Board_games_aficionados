//BIT695 Web Technologies 
function tuesday() {
    "use strict";
    var day = document.getElementById("tgame_date").innerHTML,
        time = document.getElementById("tgame_time").innerHTML,
        room = document.getElementById("tgame_room").innerHTML,
        y = document.getElementById("game_day_input");
    y.setAttribute("value", day + " " + time + " " + room);
}

function friday() {
    "use strict";
    var day = document.getElementById("fgame_date").innerHTML,
        time = document.getElementById("fgame_time").innerHTML,
        room = document.getElementById("fgame_room").innerHTML,
        y = document.getElementById("game_day_input");
    y.setAttribute("value", day + " " + time + " " + room);
}


function myFunction() {
    var x = window.scrollY;
    if (x > 460) {
        document.getElementById("follow_me").style.position = "fixed";
        document.getElementById("follow_me").style.marginLeft = "auto";
        document.getElementById("follow_me").style.marginRight = "auto";
        document.getElementById("follow_me").style.width = "600";
        document.getElementById("follow_me").style.top = "0px";
        document.getElementById("follow_me").style.left = "374px";
        document.getElementById("follow_me").style.backgroundColor = "RGBA(13, 83, 117, 1)";
    } else {
        document.getElementById("follow_me").style.position = "relative";
        document.getElementById("follow_me").style.marginLeft = "auto";
        document.getElementById("follow_me").style.marginRight = "auto";
        document.getElementById("follow_me").style.width = "600px";
        document.getElementById("follow_me").style.top = "283px";
        document.getElementById("follow_me").style.left = "0px";
        document.getElementById("follow_me").style.zIndex = "1";
        document.getElementById("follow_me").style.backgroundColor = "inherit";
    }
}

window.addEventListener("scroll", myFunction);