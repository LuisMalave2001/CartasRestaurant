// Sass configuration
var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(cb) {
  gulp
    .src('static/scss/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('static/css/'));
  cb();
});

gulp.task(
  'default',
  gulp.series('sass', function(cb) {
    gulp.watch('static/scss/**/*.scss', gulp.series('sass'));
    cb();
  })
);