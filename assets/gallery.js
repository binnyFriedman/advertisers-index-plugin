!function o(i,u,c){function f(e,r){if(!u[e]){if(!i[e]){var t="function"==typeof require&&require;if(!r&&t)return t(e,!0);if(d)return d(e,!0);var n=new Error("Cannot find module '"+e+"'");throw n.code="MODULE_NOT_FOUND",n}var a=u[e]={exports:{}};i[e][0].call(a.exports,function(r){return f(i[e][1][r]||r)},a,a.exports,o,i,u,c)}return u[e].exports}for(var d="function"==typeof require&&require,r=0;r<c.length;r++)f(c[r]);return f}({1:[function(r,e,t){"use strict";var n=document.querySelector(".gallery-show-more");n.addEventListener("click",function(r){r.preventDefault();var e=r.target.dataset.expanded,t=[].concat(function(r){if(Array.isArray(r)){for(var e=0,t=Array(r.length);e<r.length;e++)t[e]=r[e];return t}return Array.from(r)}(document.querySelectorAll(".ad-gallery--img")));"true"===e?(t.forEach(function(r,e){5<e&&r.classList.add("hidden")}),n.dataset.expanded="false",n.innerHTML="תמונות נוספות"):(t.forEach(function(r){r.classList.remove("hidden")}),n.dataset.expanded="true",n.innerHTML="הצג פחות תמונות")})},{}]},{},[1]);
//# sourceMappingURL=gallery.js.map