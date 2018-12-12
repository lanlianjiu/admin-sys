(function ($) {
    var config = {
        js: [
            "/lib/bootstrap/bootstrap.min.js",
            "/lib/angular/angular-1.4.8.min.js",
            "/lib/bootstrap/bootstrap-table/bootstrap-table.min.js",
            "/lib/bootstrap/bootstrap-table/locale/bootstrap-table-zh-CN.min.js",
            "/lib/bootstrap/bootstrap-extensions/tableExport.min.js",
            "/lib/bootstrap/bootstrap-extensions/bootstrap-table-export/bootstrap-table-export.js",
            "/lib/bootstrap/bootstrap-extensions/toolbar/bootstrap-table-toolbar.js",

            "/js/cfg/iov.cfg.js",
            "/js/public.web.js",
        ],
        css: [
            "/lib/bootstrap/bootstrap.min.css",
            "/lib/bootstrap/bootstrap-table/bootstrap-table.min.css",
            "/css/font-awesome.min.css",
            "/css/animate.min.css",
            "/css/style.min.css",
            "/css/web-style.css",
        ],
    };

    var JSLoader = {
        load: (function () {

            var baseUrl = getJSPath();

            function getJSPath() {
                var js = document.scripts;
                var src = js[js.length - 1].src;
                var thisPath = src.substring(0, src.lastIndexOf("/") - 3);
                return thisPath.substring(0, thisPath.length);
            }

            function scriptsLoad(scripts) {
                if (scripts.length == 0) {
                    return;
                }
                var head = document.getElementsByTagName('head')[0] || document.documentElement;
                for (var i = 0; i < scripts.length; i++) {
                    document.write('<script type="text/javascript" src="' + baseUrl + scripts[i] + '" ><\/script>');
                }
            }

            function cssLoad(csses) {
                if (csses.length == 0) {
                    return;
                }
                var head = document.getElementsByTagName('head')[0] || document.documentElement;
                var s = new Array();
                for (var i = 0; i < csses.length; i++) {
                    s[i] = document.createElement("link");
                    s[i].setAttribute("type", "text/css");
                    s[i].setAttribute('rel', 'stylesheet');
                    s[i].setAttribute('href', baseUrl + csses[i]);
                    var reg = new RegExp("skin.css");
                    if (reg.test(csses[i])) {
                        s[i].setAttribute('id', "skin");
                    };
                    head.appendChild(s[i]);
                }
            }
            return {
                js: scriptsLoad,
                css: cssLoad
            };
        })()
    };
    JSLoader.load.js(config.js);
    JSLoader.load.css(config.css);
})(jQuery);