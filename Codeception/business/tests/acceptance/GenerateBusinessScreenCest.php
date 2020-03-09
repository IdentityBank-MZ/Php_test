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
use MongoDB\Driver\Exception\ExecutionTimeoutException;

################################################################################
# Class(es)                                                                    #
################################################################################

class GenerateBusinessScreenCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->comment('Login Page');
        $I->amOnPage('~^/login~');
        $I->fillField('IdbBusinessLoginForm[userId]', '');
        $I->fillField('IdbBusinessLoginForm[accountNumber]', '');
        $I->fillField('IdbBusinessLoginForm[accountPassword]', '');
        $I->click('/html/body/div[1]/form/button'); //Login
        sleep(3);
    }

    public function dashboardExs(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->makeScreenshot('2105 - Dashboard - existing bus acc');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2105 - Dashboard - existing bus acc', $url, $html);
    }

    public function dataGrid(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->makeScreenshot('2514 - Access Data - data grid');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2514 - Access Data - data grid', $url, $html);
    }

    public function dataGridSendUsedFor(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->click('/html/body/div[1]/div[1]/section[2]/div/div/div/div[3]/div[2]/div/div[2]/div/div/div[2]/div/div/div[2]/table/tbody/tr/td[6]/a[1]/span'); //Send Used For
        sleep(1);
        $I->makeScreenshot('2514 -Access Data - Manage my data - Use data button');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2514 -Access Data - Manage my data - Use data button', $url, $html);
    }

    public function dataGridOptions(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->click('Options');
        sleep(1);
        $I->makeScreenshot('2513 - Access Data - Manage my data - Data Grid Setting button');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2513 - Access Data - Manage my data - Data Grid Setting button', $url, $html);
    }

    public function dataGridAddNewPerson(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->click('/html/body/div[1]/div[1]/section[2]/div/div/div/div[2]/a[1]'); //Add new Person
        $I->see('Add new person');
        $I->waitForElement('#idb-data-create', 30);
        $I->see('Send invitation to the person you are adding to the vault.');
        $I->makeScreenshot('2512 - Access Data - Manage my data - Add new customer');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2512 - Access Data - Manage my data - Add new customer', $url, $html);
    }

    public function dataGridEditSafes(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->click('Edit safes');
        $I->see('Edit safes');
        sleep(10);
        $I->see('Add Type');
        $I->makeScreenshot('2505 - Access Data - Edit safes');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2505 - Access Data - Edit safes', $url, $html);
    }

    public function export(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Access vault');
        $I->see('Access vault');
        $I->click('Export');
        $I->see('Manage exports');
        $I->makeScreenshot('2502 - Menu option - Manage exports');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2502 - Menu option - Manage exports', $url, $html);
    }

    public function auditLog(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('View audit log'); //Audit log
        $I->see('Audit log');
        $I->see('Used By');
        $I->makeScreenshot('2530 - Audit log');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2530 - Audit log', $url, $html);
    }

    public function messageToPeople(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(1);
        $I->click('Send messages'); //Message to people
        $I->see('Write a message');
        $I->makeScreenshot('2560 - Message to people');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2560 - Message to people', $url, $html);
        try {
            $I->fillField('.select2-search__field', '');
            $I->pressKey('.select2-search__field', \Facebook\WebDriver\WebDriverKeys::ENTER);
            $I->fillField('Business2PeopleFormModel[subject]', 'Testowy Temat');
            $I->fillField('Business2PeopleFormModel[message]', 'testowa wiadomość.');
            $I->click('Send');
            sleep(2);
            $I->see('Message sent');
            $I->makeScreenshot('2561 - Message to people - message sent');
            $url = $I->grabFromCurrentUrl();
            $html = $I->grabPageSource();
            TranslationHelper::screen('business', '2561 - Message to people - message sent', $url, $html);
        } catch (Exception $e) {
            $I->comment('no people connecting whit People');
        }
    }

    public function accountAdminIndexCreate(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('Manage users');
        $I->see('Manage users');
        $I->see('Account Users');
        $I->makeScreenshot('2580 - Account administration - user manager');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2580 - Account administration - user manager', $url, $html);
        $I->click('Create');
        $I->see('Create new user');
        $I->makeScreenshot('2581 - Account administration - Create new user');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2581 - Account administration - Create new user', $url, $html);
    }

    public function accountAdminAssignVault(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('Manage users');
        $I->see('Manage users');
        $I->see('Account Users');
        $I->click('/html/body/div[1]/div[1]/section[2]/div/div/div/div/div[3]/div/div/div/div[1]/div/table/tbody/tr[1]/td[6]/a[1]/span'); //Assign vault
        $I->see('Select vaults');
        $I->see('can access');
        $I->see('Select vault');
        $I->makeScreenshot('2580 - Account administration - assign vault');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2580 - Account administration - assign vault', $url, $html);
    }

    public function accountAdminRoles(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('Manage users');
        $I->see('Manage users');
        $I->see('Account Users');
        $I->click('/html/body/div[1]/div[1]/section[2]/div/div/div/div/div[3]/div/div/div/div[1]/div/table/tbody/tr[1]/td[6]/a[2]/span'); //Menager Roles
        $I->see('Manage Roles');
        $I->see('Role');
        $I->see('Description');
        $I->see('Status');
        $I->makeScreenshot('2580 - Account administration - manager roles');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2580 - Account administration - manager roles', $url, $html);
    }

    public function billing(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('Billing');
        $I->see('Billing details');
        $I->see('Subscription details');
        $I->see('Credits');
        $I->makeScreenshot('2601 - Account administration - Billing');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2601 - Account administration - Billing', $url, $html);
    }

    public function payments(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('Payments');
        $I->see('Payments');
        $I->see('Payment Method');
        $I->see('Downloads');
        $I->makeScreenshot('2595 - Account administration - payments');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2595 - Account administration - payments', $url, $html);
    }

    public function activityLog(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->makeScreenshot('debug');
        try{
            $I->click('Service Usage');
        } catch (Exception $e){
            $I->click('/html/body/div[1]/aside[1]/section/ul/li[7]/ul/li[4]/a');
        }
        $I->see('User activity logs');
        $I->see('Action Type');
        $I->see('Action Name');
        $I->see('Action Date');
        $I->makeScreenshot('2600 - Account administration - Activity log');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2600 - Account administration - Activity log', $url, $html);
    }

    public function accountDetailsChangePassword(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('/html/body/div[1]/aside[1]/section/ul/li[7]/ul/li[5]/a/span');
        $I->see('Account details');
        $I->makeScreenshot('2603 - Account administration - account details 1');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2603 - Account administration - account details 1', $url, $html);
        $I->click('Business Information');
        sleep(2);
        $I->see('Billing information');
        $I->see('Address');
        $I->makeScreenshot('2603 - Account administration - account details 2');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2603 - Account administration - account details 2', $url, $html);
        $I->click('Business Contact');
        sleep(2);
        $I->see('Contact details');
        $I->makeScreenshot('2603 - Account administration - account details 3');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2603 - Account administration - account details 3', $url, $html);

        //delete account
        $I->click('Delete Account');
        sleep(2);
        $I->see('Delete account');
        $I->makeScreenshot('2603 - Account administration - delete account 1');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2603 - Account administration - delete account 1', $url, $html);
        $I->click('Continue to delete my account');
        sleep(2);
        $I->see('You have decided to close your Identity Bank account.');
        $I->checkOption('#continue-delete');
        $I->makeScreenshot('2603 - Account administration - delete account 2');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2603 - Account administration - delete account 2', $url, $html);
        sleep(1);
        $I->click('Keep my account');
        sleep(1);

        //delete account

        $I->click('Change Password');
        sleep(2);
        $I->see('Change Password');
        $I->see('Account password setup');
        $I->fillField('ChangePasswordForm[oldPassword]', '');
        $I->fillField('ChangePasswordForm[password]', '');
        $I->fillField('ChangePasswordForm[repeatPassword]', '');
        $I->makeScreenshot('2122 - User Profile - change password');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2122 - User Profile - change password', $url, $html);
        $I->click('Save');
        sleep(10);
        $I->see('Password Changed');
        $I->see('Password changed.');
        $I->makeScreenshot('2123 - User Profile - Password changed');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2123 - User Profile - Password changed', $url, $html);
    }

    public function cancelPassword(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Account Administration');
        sleep(5);
        $I->click('/html/body/div[1]/aside[1]/section/ul/li[7]/ul/li[5]/a/span');
        $I->see('Account details');
        $I->click('Change Password');
        $I->see('Change Password');
        $I->see('Account password setup');
        $I->click('Cancel');
        sleep(5);
        $I->see('Stop changing password');
        $I->makeScreenshot('2122 - User Profile - Cancel password');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2122 - User Profile - Cancel password', $url, $html);
    }

    public function createSafe(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Create new vault');
        $I->see('Create or select a vault for your data');
        $I->see('Select an existing vault or create a new one.');
        $I->fillField('dbname', 'people_inv');
        $I->click('Continue');
        $I->click('Access vault');
        $I->see('Edit safes');
        $I->waitForElement('.set-header', 30);
        $I->see('ERROR');
        $I->makeScreenshot('2505 - Access Data - Create client set - warning given if no spreadsheet information has been imported');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2505 - Access Data - Create client set - warning given if no spreadsheet information has been imported', $url, $html);
        $I->click('Manage vault');
        $I->see('Manage vault');
        $I->see('people_inv');
        $I->makeScreenshot('2515 - Access Data - manage vault');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2515 - Access Data - manage vault', $url, $html);
        $I->click('Delete vault');
        sleep(5);
        $I->click('Continue and delete this vault');
        sleep(10);
    }

    public function accountPopup(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('/html/body/div[1]/header/nav/div/ul/li[3]/a/span');
        $I->makeScreenshot('2110 - Account popup');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2110 - Account popup', $url, $html);
        $I->click('/html/body/div[1]/header/nav/div/ul/li[3]/ul/li[2]/div[2]/button');
        sleep(5);
        $I->makeScreenshot('2110 - Account popup - overlay');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2110 - Account popup - overlay', $url, $html);
    }

    public function sendInv(AcceptanceTester $I){
        $I->amOnPage('~^/~');
        $I->click('');
        sleep(2);
        try {
            $I->click('Connect with people');
        } catch (Exception $e){
            $I->click('/html/body/div[1]/aside[1]/section/ul/li[3]/ul/li[5]/a/span');
        }
        $I->makeScreenshot('2540 - Connect with people');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2540 - Connect with people', $url, $html);
        $I->checkOption('selection_all');
        $I->click('Invite selected people');
        $I->makeScreenshot('2542 - Connect to people - Summary');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2542 - Connect to people - Summary', $url, $html);
    }

    public function import(AcceptanceTester $I)
    {
        $I->amOnPage('~^/~');
        $I->click('Create new vault');
        $I->see('Create or select a vault for your data');
        $I->makeScreenshot('2210 - Import from file: Step 1');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2210 - Import from file: Step 1', $url, $html);
        $I->fillField('dbname', 'import');
        $I->click('Continue');
        $I->see('SUCCESS');
        $I->click('Manage vault');
        $I->click('Reset vault');
        sleep(5);
        $I->click('Continue and reset my vault');
        $I->see('import');
        $I->click('Add More Data');
        $I->see('import - Select a file to import');
        $I->see('Or use a previously imported file');
        $I->makeScreenshot('2220 - Import from file: Step 2');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2220 - Import from file: Step 2', $url, $html);
        $I->attachFile('input.dz-hidden-input', 'test_import.csv');
        sleep(30);
        $I->see('Connect with people');
        $I->makeScreenshot('2250 - Import from file: Step 5');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2250 - Import from file: Step 5', $url, $html);
        sleep(30);
        $I->selectOption('DynamicModel[email_no]', 'Mail');
        $I->selectOption('DynamicModel[mobile_no]', 'Mobile');
        $I->selectOption('DynamicModel[phone_code]', '+48');
        $I->selectOption('DynamicModel[name_no]', 'Name');
        $I->selectOption('DynamicModel[surname_no]', 'Lastname');
        $I->uncheckOption('DynamicModel[send_email]');
        $I->uncheckOption('DynamicModel[valid_both]');
        $I->click('Continue');
        sleep(20);
        $I->see('That’s all!');
        $I->see('Current status:');
        $I->makeScreenshot('2260 - Import from file: Step 6');
        $url = $I->grabFromCurrentUrl();
        $html = $I->grabPageSource();
        TranslationHelper::screen('business', '2260 - Import from file: Step 6', $url, $html);
        sleep(10);
        $I->click('Manage vault');
        $I->see('Manage vault');
        $I->see('import');
        $I->click('Delete vault');
        sleep(5);
        $I->click('Continue and delete this vault');
        sleep(10);
    }
}

################################################################################
#                                End of file                                   #
################################################################################
