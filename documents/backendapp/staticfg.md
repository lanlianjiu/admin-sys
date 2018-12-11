### 静态数据配置说明

一、环境切换
    1.用命令行工具（或编辑器命令输入工具）切换到D:\xampp\htdocs\admin_system\backendapp下，（也就是前端域名所指路径）

    2.在(...admin_system\backendapp下)运行cnpm install或npm install(推荐用cnpm install)


二、配置

    1.本地启动gulp服务调试配置
        (1).在backendapp/confg/env/gulpfile.lock.js文件，把自己本地的配置填入

        (2).本地的配置内容,主要是配置server_web、server_api这两项

        ```js
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
        ```

    5.本地与线上项目请求url等静态参数配置
      (1)admin_system/backendapp/env/env-dev.js 开发环境
       ```js
        $.cfg_line = {
            server_api: "",
            ....
            ....
            ....
            ....
        }
        ````
      (2)admin_system/backendapp/env/env-online.js 生产环境
        ```js
        $.cfg_line = {
            server_api: "",
            ....
            ....
            ....
            ....
        }
        ````

    3.安装和配置之后，
        (1).在admin_system\backendapp（前端域名所指路径）的命令工具输入gulp serve --d  或者点击编辑器(Visual Studio Code)上方的【终端(M)】
            选择【npm:admin_system_web-backendapp】任务，再出现多个中文选项，选择【继续而不扫描任务输出】(Continue without...)项.
        (2).完成后，服务自动运行自动打开浏览器

    4.(用npm install安装后，运行如果发现报错，无法自动打开网站，把backendapp下的node_modules删掉，重新用cnpm install安装)

    5.以上配置，基于php后台系统环境配置完成之后，运行才能打开网站


    三、线上发布
    
    1.在admin_system\backendapp（前端域名所指路径）的命令工具输入gulp build  或者点击编辑器(Visual Studio Code)上方的【终端(M)】
            选择【npm:admin_system_build-backendapp】任务，再出现多个中文选项，选择【继续而不扫描任务输出】(Continue without...)项.
    2.打包压缩后的文件则在src同级目录下的dist下的src为压缩后的项目文件

    3.。。。。。