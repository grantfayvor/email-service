app.controller("UserController", ['$scope', '$rootScope', 'UserService', function($scope, $rootScope, UserService){

	$scope.user = {};
	$scope.credentials = {};
	$scope.new_user = {};
	$scope.loggedIn = true;

	$scope.login = function(){
		UserService.authenticateUser($scope.credentials, function (response) {
			if (response.data.role == "USER") {
				window.location.href = "../../email/resources/index.php";
			} else if (response.data.role == "ADMIN") {
				window.location.href = "../../email/resources/admin.php";
			} else {
				$scope.loggedIn = false;
			}
		}, function (response, status) {
			$scope.loggedIn = false;
			console.log(response.data);
		});
	};

	$scope.register = function(){
		UserService.registerUser($scope.new_user, function (response) {
			if (response.data.result === true) {
				console.log("the user has successfully been registered " + response.data);
				$scope.registered = 1;
				$scope.credentials.username = $scope.new_user.username;
				$scope.credentials.password = $scope.new_user.password;
				$scope.login();
			} else {
				$scope.registered = 0;
			}	
		}, function(response, status){
			console.log(response.data);
		});
	};

	$scope.registerAdmin = function(){
		UserService.registerUser($scope.new_user, function (response) {
			if (response.data.result === true) {
				console.log("the user has successfully been registered " + response.data);
				$scope.registered = 1;
				setTimeout(function () {
					$("#fade1").fadeOut(5000);
					$scope.registered = 2;
				}, 1000);
			} else {
				$scope.registered = 0;
				setTimeout(function () {
					$("#fade2").fadeOut(5000);
					$scope.registered = 2;
				}, 1000);
			}	
		}, function(response, status){
			console.log(response.data);
		});
	};

}]);

app.service("UserService", ['APIService', function(APIService){

	this.authenticateUser = function(userDetails, successHandler, errorHandler){
		APIService.post("../../email/php/controller/login-controller.php", userDetails, successHandler, errorHandler);
	};

	this.registerUser = function(userDetails, successHandler, errorHandler){
		APIService.post("../../email/php/controller/register-controller.php", userDetails, successHandler, errorHandler);
	};
	
}]);