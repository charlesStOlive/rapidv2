var navMenuDiv = document.getElementById("nav-content");
var navMenu = document.getElementById("nav-toggle");
//
var navNeedDiv = document.getElementById("nav-need-content");
var needMenu = document.getElementById("nav-need");

var navSolutionDiv = document.getElementById("nav-solution-content");
var solutionMenu = document.getElementById("nav-solution");

function checkMenu(e) {

    var target = (e && e.target) || (event && event.srcElement);
    //Nav Menu
    if (!checkParent(target, navMenuDiv)) {
        // click NOT on the menu
        if (checkParent(target, navMenu)) {
            // click on the link
            if (navMenuDiv.classList.contains("hidden")) {
                navMenuDiv.classList.remove("hidden");
            } else { navMenuDiv.classList.add("hidden"); }
        } else {
            // click both outside link and outside menu, hide menu
            navMenuDiv.classList.add("hidden");
            navNeedDiv.classList.add("hidden");
            navSolutionDiv.classList.add("hidden");
        }
    } else {
        if (checkParent(target, needMenu)) {
            if (navNeedDiv.classList.contains("hidden")) {
                navNeedDiv.classList.remove("hidden");
                navSolutionDiv.classList.add("hidden");
            } else {
                navNeedDiv.classList.add("hidden");
            }
        }
        if (checkParent(target, solutionMenu)) {
            if (navSolutionDiv.classList.contains("hidden")) {
                navSolutionDiv.classList.remove("hidden");
                navNeedDiv.classList.add("hidden");
            } else {
                navSolutionDiv.classList.add("hidden");
            }
        }
    }

}
function checkParent(t, elm) {
    while (t.parentNode) {
        if (t == elm) { return true; }
        t = t.parentNode;
    }
    return false;
}

export { checkMenu }
