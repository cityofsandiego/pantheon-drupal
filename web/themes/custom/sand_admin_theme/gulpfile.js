const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const through2 = require('through2');
const cleanCSS = require('gulp-clean-css');
var postcss = require('gulp-postcss');
var prefixSelector = require('postcss-prefix-selector');

const sassPaths = [
  'node_modules'
];

// Task for compiling your main Sass files
gulp.task('styles', function() {
  return gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: sassPaths
      }).on('error', sass.logError))
      .pipe(rename({dirname: ''}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});


// Watch task to watch for file changes and run appropriate tasks
gulp.task('watch', function() {
  gulp.watch('sass/**/*.scss', gulp.series('styles'));
  // gulp.watch('zurb-foundation/*.scss', gulp.series('foundation'));
  // gulp.watch('js/**/*.js', gulp.series('scripts')); // Watch for changes in JS files
});

// Default task to run when you just type `gulp` in the terminal
gulp.task('default', gulp.parallel('styles')); // , 'foundation', 'scripts', 'watch'
