    var gulp = require('gulp');

    var path = require('path');
    var fs = require('fs');

    var $ = require('gulp-load-plugins')(); //自动加载插件
    var open = require('gulp-open'); //自动打开
    var connect = require("gulp-connect"); //文件合并
    var proxy = require('http-proxy-middleware'); //代理插件
    var minify = require('gulp-cssmin'); //css压缩
    // var babel = require('gulp-babel'); //js编译
    var uglify = require('gulp-uglify'); //js压缩
    var flatten = require('gulp-flatten'); //json文件路径问题
    var rename = require('gulp-rename'); //文件重命名
    var imagemin = require('gulp-imagemin'); //压缩图片
    var cleanfile = require('gulp-clean'); //清空文件夹
    var htmlmin = require('gulp-htmlmin'); //html压缩
    var rev = require('gulp-rev'); //更改版本号
    var notify = require('gulp-notify'); //提示信息
    var gutil = require('gulp-util'); //日志
    var revCollector = require('gulp-rev-collector'); //gulp-rev插件，用于html模板更改引用路径
    var browsersync = require('browser-sync').create(); //获取browsersync
    var runSequence = require('run-sequence'); //同步任务

    var e_cfg = "";
    var p_cfg = gulp.env;

    if (p_cfg._ && p_cfg._.length > 0 && p_cfg._[0] == 'serve') {


        if (p_cfg.d) {

            e_cfg = "lock"
        } else if (p_cfg.o) {

            e_cfg = "line"
        } else {

            exit;
        }

    }


    var iovCfg = require('./confg/iov.config.js')(e_cfg); //获取配置文件

    //代理配置
    var proxyMiddleware = proxy(['/admin'], {
        target: iovCfg.server_api,
        changeOrigin: true,
        logLevel: 'debug',
        onProxyRes: function (proxyRes) {

            const setCookieHeaders = proxyRes.headers['set-cookie'] || []

            Object.keys(setCookieHeaders).forEach(function (key) {
                setCookieHeaders[key] = setCookieHeaders[key].replace(/Path=(.*?);/, 'Path=/;')
            });

            if (setCookieHeaders) {
                proxyRes.headers['set-cookie'] = setCookieHeaders
            }
        }
    });

    //定义目录路径
    var app = {
        //源代码，文件目录
        srcPath: 'src/',
        //文件整合之后的目录
        devPath: 'build/',
        //项目，发布目录上产部署
        prdPath: 'dist/',
        revPath: 'rev/'
    };

    // 监听 css/html/js文件任务
    var watchPath = [app.srcPath + '**/*.html', app.srcPath + '**/*.js', app.srcPath + '**/*.css', !app.srcPath + 'assets/lib/**']
    gulp.task('watchJHC', function () {

        gulp.watch(watchPath).on('change', browsersync.reload);
    });

    //公用库
    gulp.task('libs', function () {
        //   /**/* 读取这个文件夹下边的所有的文件或者文件夹
        return gulp.src('src/assets/**/*')
            .pipe(gulp.dest('dist/src/assets'));
    });

    //压缩css
    gulp.task('minifyCss', function () {
        return gulp.src(['src/**/*.css', '!src/assets/**/*.css'])
            // .pipe(rename({
            //     suffix: '.min'
            // }))
            .pipe(rev())
            .pipe(minify())
            .pipe(gulp.dest('dist/src'))
            .pipe(flatten())
            .pipe(rev.manifest('rev-css-manifest.json')) //生成一个rev-manifest.json
            .pipe(gulp.dest('rev'));
    });

    //压缩js
    gulp.task('minifyJs', function () {
        return gulp.src(['src/**/*.js', '!src/assets/**/*.js'])
            // .pipe(babel())
            // .pipe(rename({
            //     suffix: '.min'
            // }))

            .pipe(uglify())
            // .on('error', function (err) {
            //     gutil.log(gutil.colors.red('[Error]'), err.toString());
            // })
            .pipe(rev())
            .pipe(gulp.dest('dist/src'))
            .pipe(flatten())
            .pipe(rev.manifest('rev-js-manifest.json')) //生成一个rev-manifest.json
            .pipe(gulp.dest('rev'));
    });

    //压缩图片
    gulp.task('minifyImg', function () {
        return gulp.src('src/assets/images/*')
            .pipe(imagemin())
            .pipe(gulp.dest('dist/src/assets/image'));
    });

    //html压缩
    gulp.task('minifyHtml', function () {
        var htmlOptions = {
            removeComments: true, //清除HTML注释
            collapseWhitespace: true, //压缩HTML
            collapseBooleanAttributes: true, //省略布尔属性的值 <input checked="true"/> ==> <input />
            removeEmptyAttributes: true, //删除所有空格作属性值 <input id="" /> ==> <input />
            removeScriptTypeAttributes: true, //删除<script>的type="text/javascript"
            removeStyleLinkTypeAttributes: true, //删除<style>和<link>的type="text/css"
            minifyJS: true, //压缩页面JS
            minifyCSS: true //压缩页面CSS
        };
        return gulp.src(['rev/*.json', 'src/**/*.html', '!src/assets/**/*.html'])
            //.pipe(rev())
            .pipe(revCollector())
            .pipe(htmlmin(htmlOptions))
            .pipe(gulp.dest('dist/src'));
    });

    //清除旧文件，每次更新的时候
    gulp.task('clean', function () {
        gulp.src([app.devPath, app.revPath])
            .pipe($.clean());
    })

    //总的方法、任务
    gulp.task('openWeb', ['watchJHC']);

    //生成配置文件
    function buildcfg(jsName) {
        var envFile = path.join('.', 'env', jsName);

        if (!fs.existsSync(envFile)) {

            process.exit(1);
        }
        var destFile = path.join('config.js')
        if (fs.existsSync(destFile)) {

            fs.unlinkSync(destFile);
        }

        return gulp.src(envFile)
            .pipe(rename(function (path) {
                path.basename = 'iov.cfg';
                path.extname = ".js";
            }))
            .pipe(gulp.dest(path.join('.', 'src/assets/js/cfg')))
    }

    //生成配置任务
    gulp.task('onlineCfg', function () {
        var envFile = 'env-online.js';
        return buildcfg(envFile)
    });

    gulp.task('devCfg', function () {
        var envFile = 'env-dev.js';
        return buildcfg(envFile)
    });

    //本地打开服务
    gulp.task('serve', ['devCfg', 'openWeb'], function (cb) {

        browsersync.init({
            host: iovCfg.server_web,
            port: iovCfg.port,
            server: {
                baseDir: "./src",
                middleware: [proxyMiddleware],
            },
            open: "external",
        });

    });

    //生成线上压缩任务
    gulp.task('build', function (cb) {
        runSequence(
            'clean', // 第一步：清理目标目录，
            'onlineCfg',
            ['libs', 'minifyCss', 'minifyJs'], // 第二步：打包
            'minifyHtml', // 压缩替换
            cb
        );
    });

    //默认执行的任务，直接 执行 gulp 变行了。都编写完成后再终端 执行 gulp 便可以了。
    gulp.task('default', ['serve']);