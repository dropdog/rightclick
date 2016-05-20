"use strict";
var gulp = require("gulp");
var sass = require("gulp-sass");
var sourcemaps = require("gulp-sourcemaps");
var importer = require("node-sass-globbing");
var plumber = require("gulp-plumber");
var browserSync = require("browser-sync").create();
var sassGlob = require("gulp-sass-glob");
// var autoprefixer = require("gulp-autoprefixer");

var sass_config = {
  importer: importer,
  includePaths: [
    "node_modules/breakpoint-sass/stylesheets/",
    "node_modules/singularitygs/stylesheets/",
    "node_modules/modularscale-sass/stylesheets/",
    // We don't need compass. We copied we want in our mixin.scss partial.
    "node_modules/compass-mixins/lib/"
  ],
  /* The classic output style. */
  outputStyle: 'expanded',

  /* Each selector in one line. */
  // outputStyle: 'compact',

  /* One line, no spaces, all compressed. */
  // outputStyle: 'compressed',

  /* Enables additional debugging information in the output file as CSS comments */
  sourceComments: true
};

gulp.task("browser-sync", function() {
    browserSync.init({
        proxy: "localhost/fordev"
    });
    gulp.watch("sass/**/*.scss", ["sass"]);
    gulp.watch("css/*.css").on("change", browserSync.reload);
    gulp.watch("./js/rctheme.js"/*, ["uglify"]*/).on("change", browserSync.reload);
});

gulp.task("sass", function () {
  return gulp
    .src("sass/rctheme.scss")
    .pipe(plumber())
    //.pipe(sourcemaps.init())
    .pipe(sassGlob())
    .pipe(sass(sass_config).on("error", sass.logError))
    // .pipe(autoprefixer({
    //   browsers: ["last 2 version"]
    // }))
    //.pipe(sourcemaps.write())
    .pipe(gulp.dest("css"));
});

gulp.task("default", [ "sass","browser-sync"]);
