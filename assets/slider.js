!function o(l,s,c){function u(r,e){if(!s[r]){if(!l[r]){var t="function"==typeof require&&require;if(!e&&t)return t(r,!0);if(a)return a(r,!0);var i=new Error("Cannot find module '"+r+"'");throw i.code="MODULE_NOT_FOUND",i}var n=s[r]={exports:{}};l[r][0].call(n.exports,function(e){return u(l[r][1][e]||e)},n,n.exports,o,l,s,c)}return s[r].exports}for(var a="function"==typeof require&&require,e=0;e<c.length;e++)u(c[e]);return u}({1:[function(e,r,t){"use strict";document.addEventListener("DOMContentLoaded",function(){var e=document.querySelectorAll(".slider--wrapper");[].concat(function(e){if(Array.isArray(e)){for(var r=0,t=Array(e.length);r<e.length;r++)t[r]=e[r];return t}return Array.from(e)}(e)).forEach(function(o){var l=o.querySelector(".slider--view > ul"),s=o.querySelectorAll(".slider--view__slides"),e=o.querySelector(".slider--arrows__left"),r=o.querySelector(".slider--arrows__right"),c=s.length;console.log(o);function t(e){var r,t=o.querySelector(".slider--view__slides.is-active"),i=Array.from(s).indexOf(t)+e+e,n=o.querySelector(".slider--view__slides:nth-child("+i+")");c<i&&(n=o.querySelector(".slider--view__slides:nth-child(1)")),0==i&&(n=o.querySelector(".slider--view__slides:nth-child("+c+")")),r=n,t.classList.remove("is-active"),r.classList.add("is-active"),l.setAttribute("style","transform:translateX("+-1*r.offsetLeft+"px)")}r.addEventListener("click",function(){return t(0)}),e.addEventListener("click",function(){return t(1)})})})},{}]},{},[1]);
//# sourceMappingURL=slider.js.map