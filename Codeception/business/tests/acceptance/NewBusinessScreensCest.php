<?php
# * ********************************************************************* *
# *                                                                       *
# *   Tests for IDB projects                                              *
# *   This file is part of test. This project may be found at:            *
# *   https://github.com/IdentityBank/Php_test.                           *
# *                                                                       *
# *   Copyright (C) 2020 by Identity Bank. All Rights Reserved.           *
# *   https://www.identitybank.eu - You belong to you                     *
# *                                                                       *
# *   This program is free software: you can redistribute it and/or       *
# *   modify it under the terms of the GNU Affero General Public          *
# *   License as published by the Free Software Foundation, either        *
# *   version 3 of the License, or (at your option) any later version.    *
# *                                                                       *
# *   This program is distributed in the hope that it will be useful,     *
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of      *
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the        *
# *   GNU Affero General Public License for more details.                 *
# *                                                                       *
# *   You should have received a copy of the GNU Affero General Public    *
# *   License along with this program. If not, see                        *
# *   https://www.gnu.org/licenses/.                                      *
# *                                                                       *
# * ********************************************************************* *

################################################################################
# Use(s)                                                                       #
################################################################################

use Helper\ConfigHelper;
use Helper\TranslationHelper;
use Codeception\Util\Locator;

################################################################################
# Class(es)                                                                    #
################################################################################

class NewBusinessScreensCest
{
    /**
     * @var string
     */
    private $token = '';
    private $login = '';
    private $accNum = '';
    private $pass = '';

    /**
     * @param \AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        $I->comment('Login Page');
        $I->amOnPage('~^/login~');
        $I->fillField('IdbBusinessLoginForm[userId]', $this->login);
        $I->fillField('IdbBusinessLoginForm[accountNumber]', $this->accNum);
        $I->fillField('IdbBusinessLoginForm[accountPassword]', $this->pass);
        $I->click('/html/body/div[1]/form/button'); //Login
        sleep(3);
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function deleteAccount(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('/html/body/div[1]/aside[1]/section/ul/li[7]/ul/li[5]/a/span');
        $I->see('Account details');
        $I->click('Delete Account');
        sleep(2);
        $I->see('Delete account');
        $I->click('Continue to delete my account');
        sleep(2);
        $I->see('You have decided to close your Identity Bank account.');
        $I->checkOption('#continue-delete');
        $I->click('#btn-delete');
        sleep(10);
        $I->see('Email verification');
        $I->see('You have been sent a code to the email address you provided.');
        $this->generateScreen($I, '2603 - Account administration - delete account 3');
        $I->openNewTab();
        $I->amOnUrl('https://messenger.idbank.eu/login');
        $I->see('Please fill out the following fields to login to the Messenger');
        $I->fillField('MessengerLoginForm[username]', '');
        $I->fillField('MessengerLoginForm[password]', '');
        $I->click(['name' => 'login-button']);
        sleep(1);
        $string = $I->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[4]/td/div/div[2]/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $I->switchToPreviousTab();
        $I->fillField(Locator::tabIndex(10), $code[4]);
        $I->fillField(Locator::tabIndex(11), $code[5]);
        $I->fillField(Locator::tabIndex(12), $code[6]);
        $I->fillField(Locator::tabIndex(13), $code[12]);
        $I->fillField(Locator::tabIndex(14), $code[13]);
        $I->fillField(Locator::tabIndex(15), $code[14]);
        $I->click('Next');
        sleep(10);
        $I->see('You have been sent an SMS code to the mobile phone number you provided.');
        $I->see('Enter the missing digits from the SMS code');
        $this->generateScreen($I, '2603 - Account administration - delete account 4');
        $I->switchToNextTab();
        sleep(1);
        $I->click('/html/body/nav/div/div[2]/ul/li[1]/a'); //Refresh
        sleep(2);
        $string = $I->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[3]/td/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $I->switchToPreviousTab();
        $I->fillField(Locator::tabIndex(10), $code[4]);
        $I->fillField(Locator::tabIndex(11), $code[5]);
        $I->fillField(Locator::tabIndex(12), $code[6]);
        $I->fillField(Locator::tabIndex(13), $code[12]);
        $I->fillField(Locator::tabIndex(14), $code[13]);
        $I->fillField(Locator::tabIndex(15), $code[14]);
        $I->click('Next');
        sleep(15);
        $I->see('Delete account has been started.');
        $this->generateScreen($I, '2603 - Account administration - delete account 5');
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function restore(AcceptanceTester $I)
    {
        $I->see('Delete account has been started.');
        $I->click('#btn-overlay');
        sleep(15);
        $I->see('Email verification');
        $I->see('You have been sent a code to the email address you provided.');
        $I->openNewTab();
        $I->amOnUrl('https://messenger.idbank.eu/login');
        try {
            $I->see('Please fill out the following fields to login to the Messenger');
            $I->fillField('MessengerLoginForm[username]', '');
            $I->fillField('MessengerLoginForm[password]', '');
            $I->click(['name' => 'login-button']);
        } catch (Exception $e){
            sleep(1);
        }
        sleep(1);
        $string = $I->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[4]/td/div/div[2]/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $I->switchToPreviousTab();
        $I->fillField(Locator::tabIndex(10), $code[4]);
        $I->fillField(Locator::tabIndex(11), $code[5]);
        $I->fillField(Locator::tabIndex(12), $code[6]);
        $I->fillField(Locator::tabIndex(13), $code[12]);
        $I->fillField(Locator::tabIndex(14), $code[13]);
        $I->fillField(Locator::tabIndex(15), $code[14]);
        $I->click('Next');
        sleep(10);
        $I->see('You have been sent an SMS code to the mobile phone number you provided.');
        $I->see('Enter the missing digits from the SMS code');
        $I->switchToNextTab();
        sleep(1);
        $I->click('/html/body/nav/div/div[2]/ul/li[1]/a'); //Refresh
        sleep(2);
        $string = $I->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[3]/td/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $I->switchToPreviousTab();
        $I->fillField(Locator::tabIndex(10), $code[4]);
        $I->fillField(Locator::tabIndex(11), $code[5]);
        $I->fillField(Locator::tabIndex(12), $code[6]);
        $I->fillField(Locator::tabIndex(13), $code[12]);
        $I->fillField(Locator::tabIndex(14), $code[13]);
        $I->fillField(Locator::tabIndex(15), $code[14]);
        $I->click('Next');
        sleep(15);
        $this->generateScreen($I, '2603 - Account administration - delete account 6');
    }

    /**
     * @param $actor
     * @param $screenName
     */
    private function generateScreen($actor, $screenName)
    {
        $actor->makeScreenshot($screenName);
        $url = $actor->grabFromCurrentUrl();
        $html = $actor->grabPageSource();
        TranslationHelper::screen('people', $screenName, $url, $html);
    }
}

################################################################################
#                                End of file                                   #
################################################################################
