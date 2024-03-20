const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const terser = require('gulp-terser');

// Task for compiling your main Sass files
gulp.task('styles', function() {
  return gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: ['node_modules/susy/sass']
      }).on('error', sass.logError))
      .pipe(rename({dirname: ''}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});

// Task for compiling Foundation Sass files
gulp.task('foundation', function() {
  return gulp.src('zurb-foundation/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: [
          'node_modules/foundation-sites/scss',
          'node_modules/motion-ui/src'
        ]
      }).on('error', sass.logError))
      .pipe(rename({dirname: ''}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});

// Task for concatenating and optionally minifying JavaScript files
gulp.task('scripts', function() {
  return gulp.src('js/**/*.js') // Adjust this to your JS source files directory
      .pipe(sourcemaps.init())
      .pipe(concat('app.js')) // This will concatenate all js files into a single file named 'app.js'
      .pipe(terser()) // Uncomment this line if you want to minify your JavaScript files
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('dist/js')); // Adjust the destination to where you want your compiled JS to go
});

// Watch task to watch for file changes and run appropriate tasks
gulp.task('watch', function() {
  gulp.watch('sass/**/*.scss', gulp.series('styles'));
  // gulp.watch('zurb-foundation/*.scss', gulp.series('foundation'));
  // gulp.watch('js/**/*.js', gulp.series('scripts')); // Watch for changes in JS files
});

// Default task to run when you just type `gulp` in the terminal
gulp.task('default', gulp.parallel('styles')); // , 'foundation', 'scripts', 'watch'
