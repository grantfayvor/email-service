app.controller("EmailController", ['$scope', '$rootScope', 'EmailService', function ($scope, $rootScope, EmailService) {

	$scope.mails = [];
	/*$scope.all_mails = [];
	$scope.sent_mails = [];
	$scope.received_mails = [];*/
	$scope.email = {};
	$scope.currentPage = "mail-stats";
	$scope.sendError = false;
	$scope.mailType = "ALL";
	// $scope.reply = false;
	// $scope.sent = {};

	$scope.initialize = function () {
		$scope.getMailCount();
		$scope.getCurrentUsername();
	};

	$scope.showComposer = function () {
		$scope.email = {};
		$scope.currentPage = "composer";
	};

	$scope.reply = function (recipient) {
		$scope.email = {};
		$scope.getUser(recipient);
		// $scope.reply = true;
		$scope.currentPage = "composer";
	};

	$scope.backToMails = function () {
		$scope.currentPage = "mail-stats";
	};

	$scope.readMail = function (mail) {
		$scope.email = mail;
		if ($scope.mailType == 'SENT') {
			$scope.email.mailType = $scope.mailType;
		}
		$scope.currentPage = "mail-display";
	}

	$scope.getAllEmails = function () {
		$scope.mailType = "SYSTEM";
		$scope.currentPage = "mail-list";
		EmailService.getSystemMails(function (response) {
			$scope.mails = response.data;
		}, function (response, status) {
			console.log("error in getting the emails");
		});
	}

	$scope.getEmails = function () {
		$scope.mailType = "ALL";
		$scope.currentPage = "mail-list";
		EmailService.getUserMails(function (response) {
			$scope.mails = response.data;
		}, function (response, status) {
			console.log("error in getting the emails");
		});
	};

	$scope.getSentMails = function () {
		$scope.mailType = "SENT";
		$scope.currentPage = "mail-list";
		EmailService.getSentMails(function (response) {
			$scope.mails = response.data;
		}, function (response, status) {
			console.log("error in getting the emails");
		});
	};

	$scope.getReceivedMails = function () {
		$scope.mailType = "RECEIVED";
		$scope.currentPage = "mail-list";
		EmailService.getReceivedMails(function (response) {
			$scope.mails = response.data;
		}, function (response, status) {
			console.log("error in getting the emails");
		});
	};

	$scope.getSpamMails = function () {
		$scope.mailType = "SPAM";
		$scope.currentPage = "mail-list";
		EmailService.getSpamMails(function (response) {
			$scope.mails = response.data;
		}, function (response, status) {
			console.log("error in getting the emails");
		});
	};

	$scope.sendEmail = function () {
		$scope.email.sendMail = 1;
		EmailService.sendEmail($scope.email, function (response) {
			if (response.data.result === true) {
				$scope.mailCount.allMails += 1;
				$scope.mailCount.sentMails += 1;
				$scope.mailCount.systemMails += 1;
				$scope.sent = 1;
				$scope.email = {};
				setTimeout(function () {
					$("#fade1").fadeOut(5000);
					$scope.sent = 2;
				}, 1000);
			} else {
				$scope.sent = 0;
				setTimeout(function () {
					$("#fade2").fadeOut(5000);
					$scope.sent = 2;
				}, 1000);
			}
		}, function (response, status) {
			$scope.sendError = true;
			console.log("error in sending the email");
		});
	};

	$scope.getMailCount = function () {
		EmailService.getMailCount(function (response) {
			$scope.mailCount = response.data;
		}, function (response, status) {
			console.log("error in getting mail count");
		});
	};

	$scope.getUser = function (userId) {
		EmailService.getUser(userId, function (response) {
			$scope.email.recipient = response.data.username;
		}, function (response, status) {
			console.log("error in fetching user details");
		});
	};

	$scope.getCurrentUsername = function () {
		EmailService.getUsername(function (response) {
			$scope.username = response.data.replace(/"/g, "");
		}, function (response, status) {
			console.log("error in getting username");
		});
	};

	$scope.flagAsSpam = function (emailId) {
		EmailService.flagAsSpam(emailId, function (response) {
			if (response.data.result === true) {
				$scope.email.spam = 1;
				$scope.mailCount.spamMails += 1;
				$scope.mailCount.allMails -= 1;
				if ($scope.mailType == "SENT") {
					$scope.mailCount.sentMails -= 1;
				} else if ($scope.mailType == "RECEIVED") {
					$scope.mailCount.receivedMails -= 1;
				}
				console.log("email successfully flagged");
			} else {
				console.log("error in flagging mail");
			}
		}, function (response, status) {
			console.log("error in flagging mail");
		});
	};

	$scope.flagAsHam = function (emailId) {
		EmailService.flagAsHam(emailId, function (response) {
			if (response.data.result === true) {
				$scope.email.spam = 0;
				$scope.mailCount.spamMails -= 1;
				$scope.mailCount.allMails += 1;
				if ($scope.mailType == "SENT") {
					$scope.mailCount.sentMails += 1;
				} else if ($scope.mailType == "RECEIVED") {
					$scope.mailCount.receivedMails += 1;
				}
				console.log("email successfully flagged");
			} else {
				console.log("error in flagging mail");
			}
		}, function (response, status) {
			console.log("error in flagging mail");
		});
	};

	$scope.logout = function () {
		EmailService.logout(function (response) {
			console.log(response.data);
			if (response.data) {
				window.location.href = "../../email/resources/login.html";
			}
		}, function (response, status) {
			console.log("error in loggin out");
		});
	};

}]);

app.service("EmailService", ['APIService', function (APIService) {

	this.getSystemMails = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?system=1", successHandler, errorHandler);
	};

	this.getUserMails = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?all=1", successHandler, errorHandler);
	};

	this.flagAsSpam = function (emailId, successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?emailId=" +emailId+"&isspam=1", successHandler, errorHandler);
	};

	this.flagAsHam = function (emailId, successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?emailId=" +emailId+"&isham=1", successHandler, errorHandler);
	};

	this.getSentMails = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?sent=1", successHandler, errorHandler);
	};

	this.getReceivedMails = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?received=1", successHandler, errorHandler);
	};

	this.getSpamMails = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?spam=1", successHandler, errorHandler);
	};

	this.sendEmail = function (emailDetails, successHandler, errorHandler) {
		APIService.post("../../email/php/controller/email-controller.php", emailDetails, successHandler, errorHandler);
	};

	this.getMailCount = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/email-controller.php?count=1", successHandler, errorHandler);
	};

	this.logout = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/login-controller.php?logout=1", successHandler, errorHandler);
	};

	this.getUser = function (userId, successHandler, errorHandler) {
		APIService.get("../../email/php/controller/user-controller.php?id=" + userId, successHandler, errorHandler);
	};

	this.getUsername = function (successHandler, errorHandler) {
		APIService.get("../../email/php/controller/user-controller.php?user=1", successHandler, errorHandler);
	};
}]);