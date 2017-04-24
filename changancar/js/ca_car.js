/**
 * Created by Administrator on 2017/4/6.
 */
var app = angular.module('carApp',['ng','ngRoute']);
app.config(function($routeProvider){
    $routeProvider
        .when('/carStart',{
            templateUrl:'tpl/start.html',
            controller:'startCtrl'
        })
        .when('/carMain',{
            templateUrl:'tpl/main.html',
            controller:'mainCtrl'
        })
        .when('/carDetail/:id',{
            templateUrl:'tpl/detail.html',
            controller:'detailCtrl'
        })
        .when('/carOrder/:did',{
            templateUrl:'tpl/order.html',
            controller:'orderCtrl'
        })
        .when('/carMyOrder',{
            templateUrl:'tpl/myorder.html',
            controller:'myorderCtrl'
        })
        .otherwise({redirectTo:'/carStart'})
});
app.controller('carCtrl',['$scope','$location',function($scope,$location){
    $scope.jump=function(desPath){
        $location.path(desPath);
    }
}]);
app.controller('startCtrl',['$scope','$http',function($scope,$http){

}]);
app.controller('mainCtrl',['$scope','$http',function($scope, $http){
    $scope.hasMore = true;
    $scope.regShow = false;
    $http
        .get('data/car_getbypage.php')
        .success(function (data) {
            //console.log(data);
            $scope.carList = data[0];

        });
    $scope.loadMore = function () {
        $http
            .get('data/car_getbypage.php?start='
            + $scope.carList.length)
            .success(function (data) {
                if (data.length < 5) {
                    $scope.hasMore = false;
                }
                $scope.carList = $scope.carList.concat(data[0]);
            })
    };
}]);
app.controller('detailCtrl',['$scope','$http','$routeParams',function($scope,$http,$routeParams){
    $http
        .get('data/car_getbyid.php?id='
    +$routeParams.id)
        .success(function (data) {
            //console.log(data);
            $scope.dtlList = data[0][0];
            //console.log($scope.dtlList);
            $scope.sfList=data[1];
            //console.log($scope.sfList);
            $scope.trList=data[2];
            //console.log($scope.trList);

        });
}]);
app.controller('orderCtrl',['$scope','$http','$routeParams', '$httpParamSerializerJQLike',function($scope,$http,$routeParams,$httpParamSerializerJQLike){
    $scope.order = {did: $routeParams.did};
console.log($routeParams.did);
    $scope.submitOrder = function () {
        var result = $httpParamSerializerJQLike($scope.order)
        $http
            .get('data/order_add.php?' + result)
            .success(function (data) {
                console.log(data);
                if (data.length > 0) {
                    if (data[0].msg == 'succ') {
                        $scope.succMsg = "下单成功，订单编号为:" + data[0].oid;
                    }else if(data[0].tip='exist'){
                        $scope.tipMsg="预约订单已添加";
                    }
                    else {
                        $scope.errMsg = "下单失败";
                    }
                }

            })
    }
}]);
app.controller('myorderCtrl',['$scope','$http',function($scope,$http){
    $http
        .get('data/order_getbyphone.php')
        .success(function (data) {
            console.log(data);
            $scope.orderList = data;

        });
}]);