module.exports = function () {
    return {
        enabled_cssmin: false, //css压缩
        enabled_jsmin: false,
        html: {
            collapseWhitespace: false, //压缩html
            collapseBooleanAttributes: false, //省略布尔属性的值
            removeComments: false, //清除html注释
            removeEmptyAttributes: false, //删除所有空格作为属性值
            removeScriptTypeAttributes: false, //删除type=text/javascript
            removeStyleLinkTypeAttributes: false, //删除type=text/css
            minifyJS: false, //压缩页面js
            minifyCSS: false //压缩页面css
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
        server_web: "www.adminwebapp.top", //本地域名
        server_api: "http://www.adminapi.com", //本地api域名
        port: 3000, //端口号
    }
}();