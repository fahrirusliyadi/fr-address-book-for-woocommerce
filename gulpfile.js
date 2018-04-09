"use strict";

var gulp        = require('gulp');
var sourcemaps  = require('gulp-sourcemaps');
var uglify      = require('gulp-uglify');
var rename      = require("gulp-rename");
 
function js() {
    return gulp.src(['./assets/js/*.js', '!./assets/js/*.min.js'])
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename({ 
            suffix: '.min' 
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./assets/js/'));
}

function watch() {
    gulp.watch(['./assets/js/*.js', '!./assets/js/*.min.js'], js);
}
 
gulp.task('js', js);
gulp.task('default', watch);