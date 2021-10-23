<?php

use tests\backend\_pages\LoginPage;
use tests\backend\FunctionalTester;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure login page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('submit login form with no data');
$loginPage->login('', '');
$I->expectTo('see validations errors');
$I->see('Username cannot be blank.', '.alert.alert-danger');
$I->see('Password cannot be blank.', '.alert.alert-danger');

$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('admin', 'wrong');
$I->expectTo('see validations errors');
$I->see('Incorrect username or password.', '.alert.alert-danger');

$I->amGoingTo('try to login with "user" account');
$loginPage->login('user', 'user');
$I->expectTo('see that user is logged, and gets an unauthorized error');
$I->canSeeResponseCodeIs(403);

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('webmaster', 'webmaster');
$I->expectTo('see that user is logged');
$I->seeLink('Logout');
