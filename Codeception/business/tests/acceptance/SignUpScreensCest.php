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
use Helper\SignUpScreensHelper;
use Helper\JsonReader;
use Helper\TranslationHelper;

################################################################################
# Class(es)                                                                    #
################################################################################

class SignUpScreensCest
{

    /**
     * @param \AcceptanceTester $I
     */
    public function testSignUp(AcceptanceTester $I)
    {
        try {
            if(TranslationHelper::$enabled) {
                TranslationHelper::truncate();
            }
            $data = new JsonReader(CodeceptionConfig::getConfig('Business')['jsonPath']);
            $helper = new SignUpScreensHelper($I, $data);
            $helper->welcomeScreen();
            $helper->beforeStartScreen();
            $helper->businessDetailsScreen();
            $helper->primaryAccountContactScreen();
            $helper->emailVerificationScreen();
            $helper->smsVerificationScreen();
            $helper->acceptTacScreen();
            $helper->choosePackageScreen();
            $helper->payAuthScreen();
            $helper->paySepaScreen();
            $helper->successScreen();
            $helper->finishSignup();

        } catch(\Exception $e) {
            codecept_debug($e->getMessage());
        }
    }
}

################################################################################
#                                End of file                                   #
################################################################################
