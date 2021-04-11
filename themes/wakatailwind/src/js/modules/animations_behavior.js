var mobile;
var scrollpos;


var toAnimate = document.querySelectorAll(".toAnimate");
//var aleatDelay = ['delay-1', 'delay-2', 'delay-3', 'delay-4', 'delay-5']

function launchAnimeOnScroll() {
    for (var i = 0; i < toAnimate.length; i++) {
        if (toAnimate[i].classList) {
            //toAnimate[i].classList.add('hidden');
        }

    }
    document.addEventListener('scroll', function () {
        /*Apply classes for slide in bar*/
        scrollpos = window.scrollY;
        launchAnime(scrollpos);
    });

}

function launchAnime(scroll) {
    for (var i = 0; i < toAnimate.length; i++) {
        var anime = isAnyPartOfElementInViewport(toAnimate[i]);
        if (anime && toAnimate[i].classList) {

            // toAnimate[i].classList.remove('hidden');
            // toAnimate[i].classList.add('animated');
            // toAnimate[i].classList.add('bounceIn');
        }
    }
}

function isAnyPartOfElementInViewport(el, marge) {
    if (!marge) marge = 150

    const rect = el.getBoundingClientRect();
    const windowHeight = (window.innerHeight - marge || document.documentElement.clientHeight - marge);
    const windowWidth = (window.innerWidth || document.documentElement.clientWidth);

    // http://stackoverflow.com/questions/325933/determine-whether-two-date-ranges-overlap
    const vertInView = (rect.top <= windowHeight) && ((rect.top + rect.height) >= 0);
    const horInView = (rect.left <= windowWidth) && ((rect.left + rect.width) >= 0);

    return (vertInView && horInView);
}

// function animeClass() {
//     $(".animate_icon")
//         .mouseover(function () {
//             //$(this).find("img").addClass("animated pulse slow");
//         })
//         .mouseout(function () {
//             //$(this).find("img").removeClass("animated pulse slow");
//         })
// }
//export { launchAnimeOnScroll, animeClass };
export { launchAnimeOnScroll };