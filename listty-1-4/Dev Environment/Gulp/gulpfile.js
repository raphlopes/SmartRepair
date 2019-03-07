'use strict';

var gulp				= require('gulp'),
		browserSync = require('browser-sync').create(),
		sass 				= require('gulp-sass'),
		watch 			= require('gulp-watch');

// Sass to css conversion
gulp.task('sass', function() {
	return gulp.src('src/assets/scss/*.scss')
		.pipe(sass({
          outputStyle: 'expanded'
        }).on('error', sass.logError))
		.pipe(gulp.dest('src/assets/css'))
		.pipe(browserSync.stream());
});

// Static Server + hot reload + watching scss/js/html files
gulp.task('serve', ['sass'], function() {
    browserSync.init({
        server: {
            baseDir: "src/"
        }
    });

    gulp.watch("src/assets/scss/*.scss", ['sass']).on('change', browserSync.reload);
		gulp.watch("src/assets/js/*.js").on('change', browserSync.reload);
    gulp.watch("src/*.html").on('change', browserSync.reload);
});

gulp.task('default', ['serve']);
