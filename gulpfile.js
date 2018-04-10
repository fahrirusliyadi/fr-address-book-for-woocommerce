"use strict";

var gulp            = require('gulp');
var plumber         = require('gulp-plumber');
var sourcemaps      = require('gulp-sourcemaps');
var rename          = require("gulp-rename");
var sass            = require('gulp-sass');
var autoprefixer    = require('gulp-autoprefixer');
var cleanCss        = require('gulp-clean-css');
var uglify          = require('gulp-uglify');

function css() {
    return gulp.src('./assets/src/scss/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'expanded'
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions']
        }))
        .pipe(gulp.dest('./assets/css/'))
        .pipe(cleanCss())
        .pipe(rename({ 
            suffix: '.min' 
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./assets/css/'));
}

function js() {
    return gulp.src(['./assets/js/*.js', '!./assets/js/*.min.js'])
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename({ 
            suffix: '.min' 
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./assets/js/'));
}

function watch() {
    gulp.watch(['./assets/src/scss/*.scss'], css);
    gulp.watch(['./assets/js/*.js', '!./assets/js/*.min.js'], js);
}
 
gulp.task('css', css);
gulp.task('js', js);
gulp.task('default', watch);