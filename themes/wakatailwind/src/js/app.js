import $ from 'jquery/dist/jquery.min';
window.jQuery = $;
window.$ = $;

var Flickity = require('flickity');

import { changeMenuOnScroll } from './modules/mobile_behavior.js';
import { launchAnimeOnScroll, animeClass } from './modules/animations_behavior.js';
import { checkMenu } from './modules/menu_behavior.js';
import { launchIntro } from './modules/introAnimations.js';
import './modules/modal_behavior.js';
//import Plyr from 'plyr';

// import cloudinary from "cloudinary-core";
//import videoPlayer from "cloudinary-video-player";
//import 'myComp/dist/style.css';
//var cl = new cloudinary.Cloudinary({ cloud_name: "charles-saint-olive", secure: true });
/*
* Application
*/

//launchIntro();
//changeMenuOnScroll();
//launchAnimeOnScroll();
//document.onclick = checkMenu;