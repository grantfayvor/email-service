var app = angular.module('email', []);

app.config(['$httpProvider', function ($httpProvider) {

    $httpProvider.defaults.headers.common['Accept'] = "application/json";
    $httpProvider.defaults.headers.common['Content-Type'] = "application/json";
    $httpProvider.defaults.useXDomain = true;

}]);