import { gsap } from "gsap";
import { MotionPathPlugin } from "gsap/MotionPathPlugin";

gsap.registerPlugin(MotionPathPlugin);

function launchIntro() {
    gsap.set("#obj1", { xpercent: -50, yPercent: -50, transformOrigin: "50% 50%" });
    gsap.set("#obj2", { xpercent: -50, yPercent: -50, transformOrigin: "50% 50%" });

    gsap.from("#obj1", {
        duration: 5,
        scale: 0,
        delay: 2,
        ease: "power1.inOut",
        immediateRender: true,
        motionPath: {
            path: "#spiral",
            align: "#spiral",
            start: 0.50,
            end: 0.88,
        }
    });
    gsap.from("#obj2", {
        duration: 5,
        scale: 0,
        delay: 1,
        ease: "power1.inOut",
        immediateRender: true,
        motionPath: {
            path: "#spiral",
            align: "#spiral",
            start: 0.30,
            end: 0.88,
        }
    });
}

export { launchIntro }