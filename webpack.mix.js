const mix = require('laravel-mix');

mix
.postCss("public/css/src/tailwind/tailwind.css","public/css/dist/tailwind/tailwind.css", [
    require("tailwindcss"),
]);
