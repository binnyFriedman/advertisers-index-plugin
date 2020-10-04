// Load Gulp...of course
var gulp         = require( 'gulp' );

// CSS related plugins
var sass         = require( 'gulp-sass' );
var autoprefixer = require( 'gulp-autoprefixer' );
var minifycss    = require( 'gulp-uglifycss' );

// JS related plugins
var concat       = require( 'gulp-concat' );
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var plumber      = require( 'gulp-plumber' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();
var reload       = browserSync.reload;

// Project related variables
var projectURL   = 'http://localhost:8000';

var styleSRC     = './src/scss/style.scss';
var styleSlider    = 'src/scss/slider.scss';
var styleGallery    = 'src/scss/gallery.scss';
var styleContactForm    = 'src/scss/contact_form.scss';
var styleURL     = './assets/';
var mapURL       = './';

var jsSRC        = './src/js/';
var jsURL        = './assets/';
var jsAdmin      = 'app.js';
var jsSlider     = 'slider.js';
var jsGallery     = 'gallery.js';
var jsContactForm     = 'contact_form.js';
var jsFiles      = [jsAdmin,  jsSlider,jsGallery,jsContactForm];

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';

// Tasks
// gulp.task( 'browser-sync', function(done) {
//     browserSync.init({
//         proxy: projectURL,
//         https: {
//             key: '/Users/binny/.valet/Certificates/test.dev.key',
//             cert: '/Users/binny/.valet/Certificates/test.dev.crt'
//         },
//         injectChanges: true,
//         open: false
//     });
//     done();
// });

gulp.task( 'styles', function(done) {
    gulp.src( [styleSRC,styleSlider,styleGallery,styleContactForm] )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }) )
        .on( 'error', console.error.bind( console ) )
        .pipe( sourcemaps.write( mapURL ) )
        .pipe( gulp.dest( styleURL ) )
        .pipe( browserSync.stream() );
    done();
});

gulp.task( 'js', function(done) {
    jsFiles.map(entry=>{
    return browserify({
        entries: [jsSRC+entry]
    })
        .transform( babelify, { presets: [ 'env' ] } )
        .bundle()
        .pipe( source( entry ) )
        .pipe( buffer() )
        .pipe( gulpif( options.has( 'production' ), stripDebug() ) )
        .pipe( sourcemaps.init({ loadMaps: true }) )
        .pipe( uglify() )
        .pipe( sourcemaps.write( '.' ) )
        .pipe( gulp.dest( jsURL ) )
        .pipe( browserSync.stream() );
    })
    done();
});

function triggerPlumber( src, url ) {
    return gulp.src( src )
        .pipe( plumber() )
        .pipe( gulp.dest( url ) );
}

gulp.task( 'default', gulp.series('styles', 'js', function(done) {
    gulp.src( jsURL + 'main-backend.min.js',{allowEmpty:true} )
        .pipe( notify({ message: 'Assets Compiled!' }) );
    done();
}));

gulp.task( 'watch', gulp.series('default', function(done) {
    gulp.watch( phpWatch, reload );
    gulp.watch( styleWatch, gulp.series( 'styles' ) );
    gulp.watch( jsWatch, gulp.series ('js', reload ) );
    gulp.src( jsURL + 'main-backend.min.js' ,{allowEmpty:true})
        .pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
    done();
}));