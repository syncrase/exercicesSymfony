// assets/js/theme1.js
/* 
    Created on : 5 avr. 2018, 18:33:39
    Author     : Pierre
*/
require('./theme1.scss');

// loads the jquery package from node_modules
var $ = require('jquery');

//require('bootstrap-sass');
require('popper.js');
require('bootstrap/dist/js/bootstrap');///dist/js/bootstrap
//require('bootstrap/scss/bootstrap.scss');
//C:\Users\Pierre\dev\perso\exercicesSymfony\templates\node_modules\bootstrap\scss\bootstrap.scss

// or you can include specific pieces
// require('bootstrap-sass/javascripts/bootstrap/tooltip');
// 
// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var front = require('./js/front.js');