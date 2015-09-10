var gulp = require('gulp'),
 notify  = require('gulp-notify'),
 phpunit = require('gulp-phpunit');

gulp.task('default', ['watch']);

gulp.task('watch', function() {
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], { debounceDelay: 2000 }, ['phpunit']);
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

