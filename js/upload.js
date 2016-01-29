/*
 * Angular fileUpload
 */

(function (angular, $, _) {

    // Resource url
    var resourceUrl = CRM.resourceUrls['be.ctrl.superstyler'];

    // Custom extension urls
    /* http://wiki.civicrm.org/confluence/display/CRMDOC/Cheatsheet */
    var returnUrl = CRM.url('civicrm/ctrl/superstyler');
    var uploadUrl = CRM.url('civicrm/ctrl/superstyler/upload');

    // Angular module
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
                });
            }
        };
    }]);

    angMod.controller('uploadModuleCtrl', function ($scope, $http) {

        // Variabels
        $scope.url = returnUrl;

        // Functions
        $scope.uploadFile = function ($files, $object) {
            if ($files) {
                // Log: Function upload!!
                console.log("uploadFile: " + $files);
                // default settings
                $object.error = $object.url = $object.name = '';
                $object.loader = true;
                // html file object
                var fd = new FormData();
                angular.forEach($files, function (file) {
                    fd.append('fileToUpload', file);
                });
                $http.post(uploadUrl, fd, {transformRequest: angular.identity, headers: {'Content-Type': undefined}})
                    .success(function (response) {
                        if (response.is_error === 0) {
                            // save Activity
                            $object.error = "UploadFile succes";
                            $object.loader = true;
                        } else {
                            // error
                            $object.error = "UploadFile error: " + response.status;
                            $object.loader = false;
                        }
                    });
            }
            // apply changes to scope
            $scope.$apply;
        };

        // Translation
        $scope.ts = CRM.ts('be.ctrl.superstyler');
    });

})(angular, CRM.$, CRM._);
