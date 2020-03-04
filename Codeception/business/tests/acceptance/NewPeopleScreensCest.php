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
class NewPeopleScreensCest
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
        $I->amOnUrl('');
        $I->see('Login Page');
        $I->fillField('IdbPeopleLoginForm[userId]', $this->login);
        $I->fillField('IdbPeopleLoginForm[accountNumber]', $this->accNum);
        $I->fillField('IdbPeopleLoginForm[accountPassword]', $this->pass);
        $I->click('Login');
        sleep(1);
        $I->see('Who uses my data?');
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function deleteAccount(AcceptanceTester $I)
    {
        $I->see('Who uses my data?');
        $I->click('/html/body/div[2]/div/div/div[1]/div/div[3]/div[3]/div[1]/span/i'); //Menu
        $I->click('');
        $I->see('Dashboard');
        $I->see('My profile');
        $I->click('Delete my personal Identity Bank account');
        sleep(1);
        $I->see('You have decided to close your Identity Bank account.');
        $this->generateScreen($I,'4011 - NEW: My account > My profile - delete account 1 - profile');
        $I->click('Continue to delete my account');
        sleep(1);
        $I->acceptPopup();
        sleep(10);
        $I->see('Your account will be deleted in 30 days. You can cancel this process at any time.');
        $this->generateScreen($I,'4011 - NEW: My account > My profile - delete account 2 - confirm remove');
    }

    /**
     * @param \AcceptanceTester $I
     */
    public function restoreAccount(AcceptanceTester $I)
    {
        $I->see('Who uses my data?');
        $I->click('/html/body/div[2]/div/div/div[1]/div/div[3]/div[3]/div[1]/span/i'); //Menu
        $I->click('');
        $I->see('Click this button to keep my account and not delete it.');
        $I->see('Keep my personal Identity Bank account');
        $this->generateScreen($I,'4011 - NEW: My account > My profile - delete account 3 - start restore');
        $I->click('Keep my personal Identity Bank account');
        sleep(1);
        $I->acceptPopup();
        sleep(10);
        $I->see('You\'re data is no more in delete queue.');
        $this->generateScreen($I,'4011 - NEW: My account > My profile - delete account 4 - restore confirm');
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
