var mobile;
var scrollpos = window.scrollY;
var header = document.getElementById("header");
var navcontent = document.getElementById("nav-content");
var btnMobile = document.getElementById("btn_mobile");


var navaction = document.getElementById("navAction");
var brandname = document.getElementById("brandname");
var toToggle = document.querySelectorAll(".toggleColour");

//var menuLogo = document.getElementById("logo_menu");
//var logoToToggle = menuLogo.querySelectorAll(".toggleLogo");

function changeMenuOnScroll() {
    $(window).resize(function () {
        mobile = window.matchMedia("(max-width: 1024px)").matches;
    }).resize();
    changeAppparences(0);

    document.addEventListener('scroll', function () {
        /*Apply classes for slide in bar*/
        scrollpos = window.scrollY || document.documentElement.scrollTop;
        console.log(scrollpos);
        changeAppparences(scrollpos);
    });
}

function changeAppparences(scroll) {
    if (scrollpos > 10 || mobile) {
        header.classList.add("bg-white");
        navaction.classList.remove("bg-secondary");
        navaction.classList.add("bg-primary");
        //Use to switch toggleColour colours
        for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-gray-800");
            toToggle[i].classList.remove("text-white");
        }
        // for (var i = 0; i < logoToToggle.length; i++) {
        //     logoToToggle[i].classList.remove("fill-secondary");
        //     logoToToggle[i].classList.remove("stroke-secondary");
        //     logoToToggle[i].classList.add("fill-primary");
        //     logoToToggle[i].classList.add("stroke-primary");
        // }
        header.classList.add("shadow");
        navcontent.classList.remove("bg-gray-100");
        navcontent.classList.add("bg-white");
    }
    else {
        header.classList.remove("bg-white");
        navaction.classList.remove("bg-primary");
        navaction.classList.add("bg-secondary");
        //
        for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-white");
            toToggle[i].classList.remove("text-gray-800");
        }
        // for (var i = 0; i < logoToToggle.length; i++) {
        //     logoToToggle[i].classList.add("fill-secondary");
        //     logoToToggle[i].classList.add("stroke-secondary");
        //     logoToToggle[i].classList.remove("fill-primary");
        //     logoToToggle[i].classList.remove("stroke-primary");
        // }
        //
        header.classList.remove("shadow");
        navcontent.classList.remove("bg-white");
        navcontent.classList.add("bg-gray-100");

    }
}
export { changeMenuOnScroll };