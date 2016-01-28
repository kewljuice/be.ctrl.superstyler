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

    angMod.directive('fileInput', ['$parse', function ($parse) {
        "use strict";
        return {
            restrict: 'A',
            link: function (scope, elm, attrs) {
                elm.bind('change', function () {
                    // file input
                    $parse(attrs.fileInput).assign(scope, elm[0].files);
                    scope.$apply();
                    // file validation
                });
            }
        };
    }]);

    angMod.controller('uploadModuleCtrl', function ($scope, $http) {
        // Variables
        $scope.name = 'be.ctrl.superstyler';
        $scope.url = '';

        // Log
        //console.log("hello world!");
        //console.log(angular);

        // Functions
        $scope.uploadFile = function ($files, $object) {
            // Function upload!!
            console.log("uploadFile function called" + $files);

            if ($files) {
                // default settings
                $object.error = $object.url = $object.name = '';
                $object.loader = true;
                // html file object
                var fd = new FormData();
                angular.forEach($files, function (file) {
                    fd.append('fileToUpload', file);
                });
                $http.post("/civicrm/ctrl/superstyler/upload", fd, {transformRequest:angular.identity, headers:{'Content-Type':undefined}})
                    .success(function (response) {
                        if (response.is_error === 0) {
                            // save Activity
                            $object.error = "UploadFile succes";
                            $object.loader = true;
                        } else {
                            // error
                            $object.error = response.status;
                            $object.loader = false;
                        }
                    });
            }
            // apply changes to scope
            $scope.$apply;
        };

        // renderHtml
        $scope.renderHtml = function (html_code) {
            return $sce.trustAsHtml(html_code);
        };

        // Translation
        $scope.ts = CRM.ts('be.ctrl.superstyler');
    });

})(angular, CRM.$, CRM._);
