"use strict";

const gulp          = require('gulp');
const plumber       = require('gulp-plumber');
const sourcemaps    = require('gulp-sourcemaps');
const rename        = require("gulp-rename");
const sass          = require('gulp-sass');
const autoprefixer  = require('gulp-autoprefixer');
const cleanCss      = require('gulp-clean-css');
const uglify        = require('gulp-uglify');
const zip           = require('gulp-zip');

function buildCss() {
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

function buildJs() {
    return gulp.src([
            './assets/js/*.js', 
            '!./assets/js/*.min.js'
        ])
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename({ 
            suffix: '.min' 
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./assets/js/'));
}

function watchCss() {
    return gulp.watch(['./assets/src/scss/*.scss'], buildCss);
}

function watchJs() {   
    return gulp.watch([
        './assets/js/*.js', 
        '!./assets/js/*.min.js'
    ], buildJs);
}

function makeZip() {
    return gulp.src([
        '**',
        '!.*',
        '!assets/src/**',
        '!node_modules/**',
        '!gulpfile.js',
        '!package.json',
        '!yarn.lock'
    ], {
        base: '../'
    })
        .pipe(zip('fr-address-book-for-woocommerce.zip'))
        .pipe(gulp.dest('../'));
}
 
gulp.task('build:css', buildCss);
gulp.task('build:js', buildJs);
gulp.task('watch:css', watchCss);
gulp.task('watch:js', watchJs);
gulp.task('watch', gulp.parallel('watch:css', 'watch:js'));
gulp.task('zip', makeZip);