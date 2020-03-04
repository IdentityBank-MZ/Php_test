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

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class GenerateScreensPeopleCest
 */
class GenerateScreensPeopleCest
{

    /**
     * @param \AcceptanceTester $I
     */
    public function people(AcceptanceTester $I)
    {
        $I->amOnUrl('');
        $I->see('Login Page');
        $I->fillField('IdbPeopleLoginForm[userId]', '');
        $I->fillField('IdbPeopleLoginForm[accountNumber]', '');
        $I->fillField('IdbPeopleLoginForm[accountPassword]', '');
        $I->click('Login');
        sleep(1);
        $I->see('Who uses my data?');
        $this->generateScreen($I, '4006 - Dashboard');
        $I->click('.kt-pulse__ring'); //Bell
        $I->click('Notifications'); //Notifications
        $this->generateScreen($I, '4017 - User notifications - notifications');
        $I->click('What\'s my data being used for?');
        $I->see('Your data has been used for the following reasons:');
        $this->generateScreen($I, '4040 - Whats my data being used for');
        $I->click('Back');
        $I->click('See all my data');
        $this->generateScreen($I, '4030 - See all my data');
        $I->click('1'); //1 on top
        $I->see('Data required by business');
        $this->generateScreen($I, '4031: See all my data > Manage permissions to use my data');
        $I->click('.kt-header__brand-logo'); //Back to dashboard
        $I->click('Who uses my data?');
        $this->generateScreen($I, '4020 - Who uses my data');
        $I->click('/html/body/div[2]/div/div/div[2]/div/div[2]/div/a/div/div/div/div[2]/h3'); //go to business
        sleep(5);
        $I->see('Delete all data');
        $this->generateScreen($I, '4021 - Who uses my data - Edit data for < bus name >');
        $I->click('/html/body/div[2]/div/div/div[2]/div/div[3]/div/div/div/div/div[2]/div/div/table/tbody/tr[1]/td[8]/a[1]/i'); //Edit data
        $I->see('Edit data value');
        $I->see('Back');
        $I->see('Save');
        $this->generateScreen($I, '4023 - Who uses my data - Edit data for < bus name > Edit data value');
        $I->click('.kt-header__brand-logo'); //Back to dashboard
        $I->click('.flaticon2-user-outline-symbol');
        sleep(2);
        $I->see('Login Name');
        $I->see('Account Number');
        $this->generateScreen($I, '4111 - My account > My profile modal');
        $I->click('/html/body/div[2]/div/div/div[1]/div/div[3]/div[3]/div[2]/div[2]/a/div[2]/div'); //Go to profile
        $I->see('Change Password');
        $this->generateScreen($I, '4011 - My account > My profile');
        $I->click('Change password');
        $I->see('Account password setup');
        $this->generateScreen($I, '4013 - My account - my profile - change password');
        $I->fillField('ChangePasswordForm[oldPassword]', '');
        $I->fillField('ChangePasswordForm[password]', '');
        $I->fillField('ChangePasswordForm[repeatPassword]', '');
        $I->click('Save');
        sleep(10);
        $I->see('Password successfully changed.');
        $this->generateScreen($I, '4014 - My account - my profile - password changed');
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
