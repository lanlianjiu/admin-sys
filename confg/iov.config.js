module.exports = function () {

    var defOption = {
        projectName: 'ADMIN_SYSTEM',
        bSystemId: 1,
        cSystemId: 2,
        enabled_cssmin: false,
        enabled_jsmin: true,
        html: {
            collapseWhitespace: true,
            collapseBooleanAttributes: true,
            removeComments: true,
            removeEmptyAttributes: true,
            removeScriptTypeAttributes: true,
            removeStyleLinkTypeAttributes: true,
            minifyJS: true,
            minifyCSS: true
        },
        sftp: {
            host: '',
            port: 22,
            user: '',
            pass: '',
            remotePath: '',
            key: '',
            timeout: 60000
        },
        server: '',
        subproject: {

        },
        rootPath: '',
        iovwebjsPath: ''
    }

    var _ = require('lodash')

    return function (env) {
        return _.extend(defOption, require('./env/gulpfile.' + env.toLowerCase() + '.js'));
    }
}();