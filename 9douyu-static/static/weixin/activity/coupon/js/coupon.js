/**
 * Created by scofie on 8/14/17.
 */
angular.module('activityApp',['ngRoute'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
}).controller('dataPacketCtrl',function ($scope,$http,$timeout,$filter) {
    $scope.method   =   'GET' ;
    $scope.methodUrl=   '/activity/coupon/packet' ;
    $timeout(function () {
        $scope.code         =   null ;
        $scope.data         =   null ;
        $scope.lottery      =   {} ;
        $scope.recordList   =   {} ;
        $scope.projectList  =   {} ;
        $scope.lotteryInfo  =   {} ;
        $scope.couponBonus  =   {} ;
        $scope.userStatus   =   false;
        $http({method: $scope.method, url: $scope.methodUrl,cache: false}).
        then(function successCallback(response) {
            $scope.status   = response.status;
            $scope.data     = response.data
            if( $scope.status ==200 && $scope.data.projectList ) {
                $scope.projectList  =   $scope.data.projectList;
            }
            if( $scope.status ==200 && $scope.data.lotteryInfo ) {
                $scope.lotteryInfo  =   $scope.data.lotteryInfo;
                if($scope.lotteryInfo.lottery) {
                    $scope.lottery= {id:$scope.lotteryInfo.lottery.order_num ,name:$scope.lotteryInfo.lottery.name}
                }else {
                    $scope.lottery= {id:1 ,name:'LANEIGE水库套装'}
                }
                if ( $scope.lotteryInfo.record.list.length > 0 ) {
                    $scope.recordList   =  $scope.lotteryInfo.record.list;
                } else {
                    var nowDay = $filter('date')(new Date(), "MM月dd日");
                    $scope.recordList   =  [{lottery_time:nowDay,hide_phone:'暂无获奖者',award_name:'LANEIGE水库套装'}];
                }
            }
            if( $scope.status ==200 && $scope.data.couponBonus ) {
                $scope.couponBonus  =   $scope.data.couponBonus;
            }
            if( $scope.status ==200 && $scope.data.userStatus ) {
                $scope.userStatus  =   $scope.data.userStatus;
            }
            console.log($scope.userStatus)
        }, function errorCallback(response) {
            $scope.data     = response.data || 'Request failed';
            $scope.status   = response.status;
        })
    } ,1000)

});
