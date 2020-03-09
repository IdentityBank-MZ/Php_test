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

use Codeception\Util\ActionSequence;
use Helper\ConfigHelper;
use Helper\TranslationHelper;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class RevertScreensCest
 */
class RevertScreensCest
{

    /**
     * @param \AcceptanceTester $I
     */
    public function revert(AcceptanceTester $I)
    {
        $I->amOnPage('~^/login~');
        $I->fillField('IdbBusinessLoginForm[userId]', '');
        $I->fillField('IdbBusinessLoginForm[accountNumber]', '');
        $I->fillField('IdbBusinessLoginForm[accountPassword]', '');
        $I->click('/html/body/div[1]/form/button'); //Login
        sleep(5);

        $I->amOnPage('~^/~');
        $I->see('disconnected');
        $I->see('revert_business');
        $I->see('revert_people');

        $I->click('disconnected');
        sleep(5);
        $I->click('Review change requests');
        $this->generateScreen($I, '2550 - People change requests - disconnect');

        $I->click('revert_business');
        sleep(5);
        $I->click('/html/body/div[1]/aside[1]/section/ul/li[4]/ul/li[5]/a/span'); //Review change requests
        $this->generateScreen($I, '2550 - People change requests - revert business');

        $I->click('revert_people');
        sleep(5);
        $I->click('/html/body/div[1]/aside[1]/section/ul/li[5]/ul/li[5]/a/span'); //Review change requests
        $this->generateScreen($I, '2550 - People change requests - revert people');

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
