/*
 * Angular fileUpload
 */

(function (angular, $, _) {

    var resourceUrl = CRM.resourceUrls['be.ctrl.superstyler'];
    var baseUrl = CRM.config.userFramework;

    //console.log(resourceUrl);
    //console.log(baseUrl);
    //console.log(CRM.config.entityRef);

    var angMod = angular.module('uploadModule', ['ngRoute', 'crmResource']);

    angMod.config(['$routeProvider',
        function ($routeProvider) {
            $routeProvider.when('/ctrl/superstyler/upload', {
                templateUrl: '~/uploadModule/upload.html',
                controller: 'uploadModuleCtrl'
            });
        }
    ]);

    angMod.controller('uploadModuleCtrl', function ($scope) {
        // Variables
        $scope.name = 'be.ctrl.superstyler';
        $scope.url = '/civicrm/ctrl/superstyler/';

        // Log
        //console.log("hello world!");
        //console.log(angular);

        // Translation
        $scope.ts = CRM.ts('be.ctrl.superstyler');
    });

})(angular, CRM.$, CRM._);
