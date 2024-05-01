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

const sassPathsFoundation = [
  'node_modules',
  'node_modules/foundation-sites/scss',
  'node_modules/motion-ui/src'
];
// Task for compiling your main Sass files
gulp.task('styles', function() {
  return gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: sassPaths
      }).on('error', sass.logError))
      .pipe(rename({dirname: ''}))
      .pipe(cleanCSS({removeDuplicateRules: 'true', format: 'beautify'}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});

// Task for compiling Foundation Sass files
gulp.task('foundation', function () {
  return gulp.src('zurb-foundation/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: sassPaths
      }).on('error', sass.logError))
      .pipe(rename({dirname: ''}))
      .pipe(cleanCSS({removeDuplicateRules: 'true', format: 'beautify'}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});

// Task for concatenating and optionally minifying JavaScript files
gulp.task('scripts', function() {
  return gulp.src('js/**/*.js') // Adjust this to your JS source files directory
      .pipe(sourcemaps.init())
      .pipe(concat('app.js')) // This will concatenate all js files into a single file named 'app.js'
      .pipe(terser()) // Uncomment this line if you want to minify your JavaScript files
      .pipe(cleanCSS({removeDuplicateRules: 'true', format: 'beautify'}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('dist/js')); // Adjust the destination to where you want your compiled JS to go
});

gulp.task('ckeditor', function() {
  return gulp.src('sass/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(sass({
        includePaths: sassPaths
      }).on('error', sass.logError))
      .pipe(postcss([
        prefixSelector({
          prefix: 'div.ck.ck-editor__main',
          // Exclude selectors you don't want to prefix here
          exclude: [':root', '.ck-editor__main', /.*ckeditor.*/]
        })
      ]))
      .pipe(concat('ckeditor5_styles.css')) // Combine all CSS into a single file
      .pipe(cleanCSS({removeDuplicateRules: 'true', format: 'beautify'}))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('css'));
});

/**
 * Generate Foundation CSS for CKEditor5.
 *
 * This generates the foundation css wrapped in a prefix so it only affects
 * Ckeditor5 fields. It's then used in the sand.info.yml file for the ckeditor5.
 * The code was copied from the foundation task and then the prefix portion of
 * the ckeditor task.
 */
gulp.task('ckeditor5_foundation', function () {
  return gulp.src('zurb-foundation/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: sassPathsFoundation
    }).on('error', sass.logError))
    .pipe(postcss([
      prefixSelector({
        prefix: 'div.ck.ck-editor__main',
        // Exclude selectors you don't want to prefix here
        exclude: [':root', '.ck-editor__main', /.*ckeditor.*/]
      })
    ]))
    .pipe(rename({dirname: ''}))
    .pipe(concat('ckeditor5_foundation.css')) // Combine all CSS into a single file
<<<<<<< HEAD
      .pipe(cleanCSS({removeDuplicateRules: 'true', format: 'beautify'}))
=======
>>>>>>> 5ec747fe11478f0cca54e7026ad12911e39ea31f
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
gulp.task('default', gulp.parallel('styles', 'ckeditor', 'ckeditor5_foundation')); // , 'foundation', 'scripts', 'watch'
