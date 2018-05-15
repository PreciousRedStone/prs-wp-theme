const gulp = require('gulp');
const gulpSass = require('gulp-sass');
const cleanCss = require('gulp-clean-css');
const imagemin = require('gulp-imagemin');
const gulpClean = require('gulp-clean');
const gulpConcat = require('gulp-concat');
const uglify = require('gulp-uglify');
const runSequence = require('run-sequence');
const postCss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

const config = {
  app: {
    src: './theme',
    assets: './theme/assets',
    vendor: './node_modules'
  },
  build: {
    dest: './prs-wp-theme-dist',
    assets: './prs-wp-theme-dist/assets'
  },
  prefixer: {
    browsers: ['last 2 versions']
  }
};

gulp.task('sass', () => {
  return gulp.src(`${config.app.assets}/scss/**/*.scss`)
      .pipe(gulpSass())
      .on('error', gulpSass.logError)
      .pipe(postCss([
        autoprefixer({
          browsers: config.prefixer.browsers,
          cascade: false
        })
      ]))
      .pipe(gulp.dest(`${config.app.src}`));
});

gulp.task('minify-css', ['sass'], () => {
  return gulp.src(`${config.app.src}/style.css`)
      .pipe(postCss([
        autoprefixer({
          browsers: config.prefixer.browsers,
          cascade: false
        })
      ]))
      .pipe(cleanCss({
        debug: true
      }, (details) => {
        let percentage = (details.stats.minifiedSize / details.stats.originalSize) * 100;
        console.log(`${config.build.dest}/${details.name}: ${details.stats.originalSize} -> ${details.stats.minifiedSize} - ${(100 - percentage).toFixed(2)}%`);
      }))
      .pipe(gulp.dest(`${config.build.dest}`));
});

gulp.task('minify-vendor-js', ['copy-vendor-js'], () => {
  return gulp.src([
    `${config.app.assets}/js/lib/vendor.js`
  ]).pipe(uglify())
      .pipe(gulp.dest(`${config.build.assets}/js/lib/`));
});


gulp.task('minify-custom-js', () => {
  return gulp.src([
    `${config.app.assets}/js/main.js`
  ]).pipe(uglify())
      .pipe(gulp.dest(`${config.build.assets}/js/`));
});

gulp.task('minify-js', () => {
  let tasks = ['minify-vendor-js', 'minify-custom-js'];
  return runSequence.apply(null, tasks, () => {
    console.log('- Minification for JavaScript completed.');
  });
});

gulp.task('optimize-images', () => {
  return gulp.src(`${config.app.assets}/images/**/*`)
      .pipe(imagemin({
        verbose: true
      }))
      .pipe(gulp.dest(`${config.build.assets}/images`));
});

gulp.task('copy-vendor-js', () => {
  return gulp.src([
    `${config.app.vendor}/jquery/dist/jquery.slim.js`,
  ]).pipe(gulpConcat('vendor.js'))
      .pipe(gulp.dest(`${config.app.assets}/js/lib/`));
});

gulp.task('copy-files', () => {
  return gulp.src([
    `${config.app.src}/**/*`,
    `!${config.app.src}/assets/**`,
    `!${config.app.src}/js/**`,
    `!${config.app.src}/*.css`
  ]).pipe(gulp.dest(`${config.build.dest}/`));
});

gulp.task('clean', () => {
  console.log('- Cleaning...');
  return gulp.src([
    `${config.build.dest}`,
    `${config.app.src}/style.css`,
    `${config.app.assets}/js/lib/*`
  ]).pipe(gulpClean());
});

gulp.task('default', ['copy-vendor-js', 'sass'], () => {
  gulp.watch(`${config.app.assets}/scss/**/*.scss`, ['sass']);
});

gulp.task('build', () => {
  let tasks = ['clean', 'minify-css', 'minify-js', 'optimize-images', 'copy-files'];
  return runSequence.apply(null, tasks, function() {
    console.log('- Build task completed successfully.')
  });
});
