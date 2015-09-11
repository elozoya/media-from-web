var gulp = require('gulp'),
 notify  = require('gulp-notify'),
 phpunit = require('gulp-phpunit'),
 phpcs = require('gulp-phpcs'),
 shell = require('gulp-shell');

gulp.task('default', ['watch']);

gulp.task('watch', function() {
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], { debounceDelay: 2000 }, ['phpunit', 'phpcs']);
});

/*
 * PHPUnit
 * =======
 */
gulp.task('phpunit', function() {
    var options = {debug: false, notify: true}
    gulp.src('phpunit.xml')
        .pipe(phpunit('', options))
          .on('error', notify.onError({
              title: 'Tests Failed',
              message: 'One or more tests failed, see the cli for details.',
              icon:    __dirname + '/node_modules/gulp-phpunit/assets/test-fail.png'
          }))
        .pipe(notify({
            title: 'PHPUnit Passed',
            message: 'All tests passed!',
            icon:    __dirname + '/node_modules/gulp-phpunit/assets/test-pass.png'
        }));
});

/*
 * PHP CodeSniffer
 * ===============
 */
gulp.task('phpcs', function () {
    return gulp.src(['src/**/*.php', 'tests/**/*.php'])
        .pipe(phpcs({
            bin: 'vendor/bin/phpcs',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        .pipe(phpcs.reporter('log'))
        .pipe(phpcs.reporter('fail'))
          .on('error', notify.onError({
              title: 'Code style failed',
              message: 'PHP CodeSniffer failed',
              icon:    __dirname + '/node_modules/gulp-phpunit/assets/test-fail.png'
          }));
        //.pipe(notify({
        //    title: 'Code style passed!',
        //    message: '',
        //    icon:    __dirname + '/node_modules/gulp-phpunit/assets/test-pass.png'
        //}));
});

gulp.task('phpcbf', shell.task(['vendor/bin/phpcbf --standard=PSR2 --ignore=vendor/ src/ tests/ server.php']));

