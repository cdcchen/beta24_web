var gulp = require('gulp'),
    less = require('gulp-less'),
    stylus = require('gulp-stylus'),
    path = require('path'),
    del = require('del'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify');


gulp.task('stylus', function () {
    return gulp.src('./static/css/site.styl')
        .pipe(stylus())
        .pipe(gulp.dest('./static/css'));
});

gulp.task('watch', function() {

    // 看守所有.styl
    gulp.watch('static/css/**/*.styl', ['stylus']);
});