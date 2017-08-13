<?php
	require_once("../php/config/session.php");

	if (!isset($_SESSION['id'])) {
		header("Location: ../../email/resources/login.html");
	}
?>

	<!DOCTYPE html>
	<html lang="en" data-ng-app="email">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Email Service</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/animate.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/responsive.css" rel="stylesheet">
		<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
		<link rel="shortcut icon" href="images/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

		<!--<style>
			.myfade{
				transition: all linear 500ms;
				opacity: 1;
			}

			.myfade.ng-hide{
				opacity:0;
			}
		</style>-->
	</head>
	<!--/head-->

	<body data-ng-controller="EmailController" data-ng-init="initialize()">

		<section id="cart_items">
			<div class="container">
				<div class="clearfix">
				</div>
				<div class="row">
					<br />
				</div>
				<div class="row">
					<button type="submit" data-ng-click="showComposer()" class="btn btn-default" data-ng-show="currentPage == 'mail-stats'">Compose mail</button>
					<button type="submit" data-ng-click="backToMails()" class="btn btn-default" data-ng-show="currentPage == 'composer'">Back</button>
					<button type="submit" data-ng-click="backToMails()" class="btn btn-default" data-ng-show="currentPage == 'mail-list'">Back</button>
					<button type="submit" data-ng-click="currentPage = 'mail-list'" class="btn btn-default" data-ng-show="currentPage == 'mail-display'">Back</button>
					<!--<button type="submit" data-ng-click="logout()" class="btn btn-default pull-right">Logout <i class="fa fa-angle-down"></i></button>-->
					<ul class="nav navbar-nav pull-right">
                        <li class="dropdown pull-right"><button type="submit" class="btn btn-default pull-right"><i class="fa fa-user"></i> <span data-ng-bind="username"></span> <i class="fa fa-angle-down"></i></button>
                        <ul role="menu" class ="sub-menu">
                        <li><a href="javascript:void(0)" data-ng-click="logout()" style="background-color: inherit!important;"><i class="fa fa-sign-out"></i> Logout</a></li>
                    	</ul>
                        </li>
					</ul>
				</div>
				<div class="row">
					<br />
				</div>
				<div id="contact-page" class="container" data-ng-show="currentPage == 'composer'">
					<div class="bg">
						<div class="row">
							<div class="col-sm-12">
								<h2 class="title text-center">Compose <strong>Mail</strong></h2>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-8">
								<div class="contact-form">
									<div id="fade1" class="status alert alert-success myfade" data-ng-show="sent == 1">The email has been sent successfully</div>
									<div id="fade2" class="status alert alert-danger myfade" data-ng-show="sent == 0">The email was not sent. Invalid recipient</div>
									<form id="main-contact-form" class="contact-form row" name="contact-form">
										<div class="form-group col-md-6">
											<input type="text" name="username" class="form-control" required="required" placeholder="Recipient Username" data-ng-model="email.recipient">
											<!--<input type="text" name="username" class="form-control" required="required" placeholder="Recipient Username" data-ng-model="email.recipient" data-ng-hide="reply" data-ng-disabled="reply">-->
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="subject" class="form-control" required="required" placeholder="Subject" data-ng-model="email.subject">
										</div>
										<div class="form-group col-md-12">
											<textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here" data-ng-model="email.message"></textarea>
										</div>
										<div class="form-group col-md-12">
											<input type="submit" name="submit" class="btn btn-primary pull-right" value="SEND" data-ng-click="sendEmail()">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/#contact-page-->
				<div class="table-responsive cart_info">
					<table class="table table-condensed table-hover" data-ng-show="currentPage == 'mail-stats'">
						<thead>
							<tr class="cart_menu">
								<td class="image">MAILS</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="cart_description">
									<a href="javascript:void(0)" data-ng-click="getEmails()">
										<h4>ALL MAILS</h4>
										<p><span data-ng-bind="mailCount.allMails"></span> total</p>
									</a>
								</td>
							</tr>
							<tr>
								<td class="cart_description">
									<a href="javascript:void(0)" data-ng-click="getSentMails()">
										<h4>SENT MAILS</h4>
										<p><span data-ng-bind="mailCount.sentMails"></span> total</p>
									</a>
								</td>
							</tr>
							<tr>
								<td class="cart_description">
									<a href="javascript:void(0)" data-ng-click="getReceivedMails()">
										<h4>RECEIVED MAILS</h4>
										<p><span data-ng-bind="mailCount.receivedMails"></span> total</p>
									</a>
									<!--<p>0 unread</p>-->
								</td>
							</tr>
							<tr>
								<td class="cart_description">
									<a href="javascript:void(0)" data-ng-click="getSpamMails()">
										<h4>SPAM MAILS</h4>
										<p><span data-ng-bind="mailCount.spamMails"></span> total</p>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
					<!-- list of emails -->
					<table class="table table-condensed table-hover" data-ng-show="currentPage == 'mail-list'">
						<thead>
							<tr class="cart_menu">
								<td class="image"><span data-ng-bind="mailType"></span> MAILS</td>
							</tr>
						</thead>
						<tbody>
							<tr data-ng-repeat="mail in mails track by mail.id">
								<td class="cart_description">
									<a href="javascript:void(0)" data-ng-click="readMail(mail)">
										<h4><span data-ng-bind="mail.subject"></span></h4>
										<h6><span class="pull-right" data-ng-bind="mail.dateSent"></span></h6>
									</a>
								</td>
							</tr>
							<tr data-ng-show="mails.length <= 0 && currentPage == 'mail-list'">
								<td class="cart_description">
								<div class="status alert alert-danger text-center">You currently do not have any messages</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div id="contact-page" class="container" data-ng-show="currentPage == 'mail-display'">
				<div class="bg">
					<div class="row">
						<div class="col-sm-12">
							<h2 class="title text-center">Current <strong>Mail</strong></h2>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<div class="contact-form">
								<div class="status alert"><span data-ng-bind="email.dateSent"></span></div>
								<div class="status alert alert-danger"><span data-ng-bind="email.subject"></span></div>
								<div class="status alert alert-success"><span data-ng-bind="email.message"></span></div>
								<button type="submit" data-ng-click="reply(email.senderId)" class="btn btn-default pull-right" data-ng-hide="email.mailType == 'SENT'"
									data-ng-disabled="email.mailType == 'SENT'">Reply</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/#cart_items-->

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
		<script type="text/javascript" src="../app/angular.js"></script>
		<script type="text/javascript" src="../app/config/config.js"></script>
		<script type="text/javascript" src="../app/service/api-service.js"></script>
		<script type="text/javascript" src="../app/modules/email/email.js"></script>
	</body>

	</html>