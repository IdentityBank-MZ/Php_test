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
use Codeception\Util\Locator;
use Helper\TranslationHelper;

################################################################################
# Class(es)                                                                    #
################################################################################
class SingUpPeopleScreensCest
{
    /**
     * @var
     */
    public $hrefStart;
    public $hrefToken;

    /**
     * @param \AcceptanceTester $I
     */
    public function sendInv(AcceptanceTester $I)
    {
        $I->comment('Login Page');
        $I->amOnPage('~^/login~');
        $I->fillField('IdbBusinessLoginForm[userId]', '');
        $I->fillField('IdbBusinessLoginForm[accountNumber]', '');
        $I->fillField('IdbBusinessLoginForm[accountPassword]', '');
        $I->click('/html/body/div[1]/form/button'); //Login
        sleep(3);

        $I->amOnPage('~^/~');
        $I->click('');
        sleep(2);
        try {
            $I->click('Connect with people');
        } catch (Exception $e){
            $I->click('/html/body/div[1]/aside[1]/section/ul/li[3]/ul/li[5]/a/span');
        }
        $I->checkOption('selection_all');
        $I->click('Invite selected people');
        $I->click('Accept and send invitations');
        sleep(20);
        $I->see('That’s all!');
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function startSingUp(AcceptanceTester $I)
    {
        $I->openNewTab();
        $I->amOnUrl('https://messenger.idbank.eu/login');
        $I->see('Please fill out the following fields to login to the Messenger');
        $I->fillField('MessengerLoginForm[username]', '');
        $I->fillField('MessengerLoginForm[password]', '');
        $I->click(['name' => 'login-button']);
        sleep(1);
        $I->see('Hello');
        $this->hrefStart = $I->grabAttributeFrom('/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[4]/td/div/div[2]/div/div/a', 'href');
        $I->closeTab();
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function loginToExistsAccount(AcceptanceTester $I)
    {
        $I->openNewTab();
        $I->amOnUrl($this->hrefStart);
        $I->click('/html/body/div[1]/div/section[3]/div/div/div[2]/div/div/div/div/div/div/div/div/div[2]/form/button[1]'); //Login
        sleep(20);
        $I->see('To finish making the connection to enter your password and click on ‘Complete connection’');
        $this->generateScreen($I, '3021 - Person logs into their existing account');
        $I->closeTab();
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function register(AcceptanceTester $I)
    {
        $I->openNewTab();
        $I->amOnUrl($this->hrefStart);
        $I->see('Welcome to Identity Bank');
        $this->generateScreen($I, '3020 - Step 1: business has started account creation process');
        $I->click('/html/body/div[1]/div/section[3]/div/div/div[2]/div/div/div/div/div/div/div/div/div[2]/form/button[2]'); //Create Account
        sleep(20);
        $I->see('Complete your account details');
        $this->generateScreen($I, '3030 - Step 2: Complete your account details');
        $I->fillField('IdbPeopleSignUpForm[password]', '');
        $I->fillField('IdbPeopleSignUpForm[repeatPassword]', '');
        $I->click('next-button');
        sleep(20);
        $I->see('Privacy Notice');
        $this->generateScreen($I, '3040 - Step 3: Privacy Notice');
        $I->executeJS(
            '    $(\'#tac-actions\').show();
                                     $(\'#tac-scroll-info\').hide();'
        );
        $I->checkOption('.iCheck-helper');
        $I->executeJS('$(\'#tac-buttons-next\').attr("disabled", false);');
        $I->click('next-button');
        sleep(20);
        $I->see('Check your email');
        $this->generateScreen($I, '3050 - Step 4: Check your email');
        $I->openNewTab();
        $I->amOnUrl('https://messenger.idbank.eu/login');
        sleep(1);
        $this->generateScreen($I, '3060 - Step 4: Email confirm code');
        $string = $I->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[4]/td/div/div[2]/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $I->click('/html/body/nav/div/div[2]/ul/li[2]/a');
        $I->switchToPreviousTab();
        $I->fillField(Locator::tabIndex(10), $code[4]);
        $I->fillField(Locator::tabIndex(11), $code[5]);
        $I->fillField(Locator::tabIndex(12), $code[6]);
        $I->fillField(Locator::tabIndex(13), $code[12]);
        $I->fillField(Locator::tabIndex(14), $code[13]);
        $I->fillField(Locator::tabIndex(15), $code[14]);
        $I->click('next-button');
        sleep(20);
        $I->see('Check your mobile phone');
        $this->generateScreen($I, '3070 - Step 5: Check your phone - SMS');
        $I->switchToNextTab();
        $I->amOnPage('/messages');
        $I->fillField('MessengerLoginForm[username]', '');
        $I->fillField('MessengerLoginForm[password]', '');
        $I->click(['name' => 'login-button']);
        sleep(1);
        $this->generateScreen($I, '3080 - Step 5: SMS received');
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
        $I->click('next-button');
        sleep(20);
        $I->see('Account signup complete!');
        $this->generateScreen($I, '3090 - Step 6: Complete connection to <bus name>');
        $this->hrefToken = $I->grabAttributeFrom('//*[@id="id-button-recovery-token"]', 'href');
        $I->comment('this is the url for your password recovery token:');
        $I->comment($this->hrefToken);
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
