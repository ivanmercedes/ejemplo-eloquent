const mix = require("laravel-mix");

mix
  .js("resources/app.js", "assets/js")
  .react()
  .postCss("resources/app.css", "assets/css", [require("tailwindcss")]);

mix.browserSync({
  proxy: "127.0.0.1:8000",
  files: [
    `src/**/*.php`,
    `resources/**/*.js`,
    `resources/**/*.css`,
    `resources/**/*.twig`,
  ],
});
