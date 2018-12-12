+ function ($) {
    var app = angular.module('Index', []);
    app.controller('indexController', ['$scope', '$http', function ($scope, $http) {

        $scope.menuList = {};
        $scope.userInfo = {};

        // if (!($.u.user.result)) {
        //     window.location.href = 'login.html';
        // };
        // $scope.userInfo.username = $.u.user.result.username;

        $scope.loadNode = function (data, pid) {

            var result = [],
                temp;

            for (var i = 0; i < data.length; i++) {
                if (data[i].pId == pid) {

                    result.push(data[i]);

                    temp = $scope.loadNode(data, data[i].id);
                    if (temp.length > 0) data[i].children = temp;
                    if (data[i].pId != 0) data[i].targetType = "iframe-tab";
                    if (data[i].url) data[i].url = data[i].url;
                }
            }

            return result;
        };

        //获取菜单
        $scope.getMenus = function () {

            var menudata = [{
                id: 1001,
                tabs: 1001,
                pId: 0,
                text: "组织管理",
                title: "组织管理",
                icon: "fa-sitemap",
                url: "",
                newWindowOpened: 0,
            }, {
                id: 1008,
                tabs: 1008,
                pId: 1001,
                text: "用户列表",
                url: "UM/adminUser.html",
                title: "用户列表",
                newWindowOpened: 0,
            }, {
                id: 1002,
                tabs: 1002,
                pId: 1001,
                text: "分配管理",
                title: "分配管理",
                icon: "",
                url: "",
                newWindowOpened: 0,
            }, {
                id: 1003,
                tabs: 1003,
                pId: 1001,
                text: "角色列表",
                title: "角色列表",
                icon: "",
                url: "UM/adminRole.html",
                newWindowOpened: 0,
            }, {
                id: 1004,
                tabs: 1004,
                pId: 1001,
                text: "权限列表",
                title: "权限列表",
                icon: "",
                url: "",
                newWindowOpened: 0,
            }, {
                id: 1005,
                tabs: 1005,
                pId: 1001,
                text: "路由列表",
                title: "路由列表",
                icon: "",
                url: "UM/adminRoute.html",
                newWindowOpened: 0,
            }, {
                id: 1006,
                tabs: 1006,
                pId: 1001,
                text: "规则列表",
                title: "规则列表",
                icon: "",
                url: "",
                newWindowOpened: 0,
            }, {
                id: 1007,
                tabs: 1007,
                pId: 1001,
                text: "菜单列表",
                title: "菜单列表",
                icon: "",
                url: "UM/adminMenu.html?ter=1",
                newWindowOpened: 0,
            }];

            $scope.menuList = $scope.loadNode(menudata, 0);

            setTimeout(function () {

                $("#side-menu").metisMenu({
                    toggle: true
                });

            }, 1000);

            $scope.$apply();

            $.ajax({
                type: 'GET',
                url: $.cfg.server_api + "admin/menu/index",
                dataType: 'json',
                data: {},
                success: function (res) {
                    if (res.status) {
                        console.log(res)
                        //$scope.menuList = $scope.loadNode(res.data, 0);
                    };
                    $scope.$apply();
                },
                error: function (e) {

                }
            }).then(function () {
                $("#side-menu").metisMenu({
                    toggle: true
                });
            });
        };


        //退出登录
        $scope.loginOut = function () {
            $.post("CRUD-InterfaceRequest.php?r=site/logout", {},
                function (result) {
                    if (result) {
                        $.localCache.remove($.cfg.user);
                        $.localCache.remove($.cfg.access_tokone);
                        window.location.href = "login.html";
                    } else {
                        $.localCache.remove($.cfg.user);
                        $.localCache.remove($.cfg.access_tokone);
                        window.location.href = 'login.html';
                    };
                }, 'json');
        };



        $(document).ready(function () {
            $scope.getMenus();
        });

    }])

}(jQuery);

$(document).on('click', '[data-tabs="open"]', function (e) {
    var options = $(this).data('options');
    if (options.nodes && options.nodes.length > 0) return;
    $(this).tabs('open', options);
})