window._ = require('lodash');
window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

$('#apple, #google').mouseover(function() {
    $('#apple, #google').toggleClass('active');
});

$('#apple').mouseover(function() {
    if (!$('#apple').hasClass('active')) {
        $('#apple').addClass('active');
        $('#google').removeClass('active');
    }
});

$('#google').mouseover(function() {
    if (!$('#google').hasClass('active')) {
        $('#google').addClass('active');
        $('#apple').removeClass('active');
    }
});