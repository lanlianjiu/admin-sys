module.exports = function () {
    return {
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
        server_web: "www.lanlianjiu.online", 
        server_api: 'www.lanlianjiu.online',
        port: 3000, //端口号
    }
}();