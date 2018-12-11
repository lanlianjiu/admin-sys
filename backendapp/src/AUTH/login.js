+ function ($) {
    var app = angular.module('login', []);
    app.controller('loginController', ['$scope', '$http', function ($scope, $http) {

        $scope.model = {};

        $scope.login = function () {
            var data = {
                username: $scope.model.username,
                password: $scope.model.password,
                rememberMe: 1
            };

            $.ajax({
                url: $.cfg.server_api + "/admin/user/login",
                data: data,
                beforeSend: function (request) {
                    request.setRequestHeader("Authorization", "Basic og==");
                },
                dataType: 'JSON',
                async: false, //请求是否异步，默认为异步
                type: 'POST',
                success: function (res) {
                    if (res.status == 200) {

                        $.localCache.remove($.cfg.access_tokone);
                        $.localCache.set($.cfg.access_tokone, res.Authorization);
                        $.localCache.remove($.cfg.user);
                        $.localCache.set($.cfg.user, res.username);
                        window.location.href = 'index.html';
                    }
                },
                error: function () {

                }

            });
        };

    }])

}(jQuery);