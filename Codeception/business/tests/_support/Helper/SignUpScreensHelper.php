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
# Namespace                                                                    #
################################################################################

namespace Helper;

################################################################################
# Use(s)                                                                       #
################################################################################

use Codeception\Configuration;
use Codeception\Module;
use Codeception\Module\WebDriver;
use Codeception\Util\Locator;
use Exception;
use Helper\ConfigHelper;
use Helper\TranslationHelper;

################################################################################
# Class(es)                                                                    #
################################################################################

class SignUpScreensHelper extends Module
{

    private $actor;
    private $href;
    private $data;

    function __construct($actor, $data)
    {
        $this->actor = $actor;
        $this->data = $data;
    }

    /**
     * @prepare useChrome
     */
    public function chromeSpecificTest()
    {
        $this->useChrome($this->getModule('WebDriver'));
    }

    protected function useChrome(WebDriver $webdriver)
    {
        $idbconfig = Configuration::config()['config']['idbconfig'];
        $webdriver->_reconfigure(
            [
                'browser' => 'chrome',
                'url' => $idbconfig['url']
            ]
        );
    }

    public function welcomeScreen()
    {
        try {
            $this->actor->amOnPage('/signup');
            $this->actor->makeScreenshot('1001 - Welcome Screen');
            $url = $this->actor->grabFromCurrentUrl();
            $html = $this->actor->grabPageSource();
            TranslationHelper::screen('business', '1001 - Welcome Screen', $url, $html);
            $this->actor->click(['name' => 'next-button']);
        } catch (Exception $e) {
            codecept_debug($e->getMessage());
        }
    }

    public function beforeStartScreen()
    {
        $this->actor->seeCurrentUrlMatches('~^/signup/before-we-start~');
        $this->actor->click(
            '/html/body/div[1]/div/section[3]/div/div/div[2]/div/div/div/div/div[2]/div[1]/div/div[1]/a/h2/b'
        ); //Create a new email address
        sleep(1);
        $this->actor->click(
            '/html/body/div[1]/div/section[3]/div/div/div[2]/div/div/div/div/div[2]/div[2]/div/div[1]/a/h2/b'
        ); //Use secure passwords
        sleep(1);
        $this->actor->makeScreenshot('1002 - Before we start Screen');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1002 - Before we start Screen', $url, $html);
        $this->actor->click(['name' => 'next-button']);
    }

    public function businessDetailsScreen()
    {
        $this->actor->seeCurrentUrlMatches('~^/signup/business-details~');
        $this->actor->makeScreenshot('1011 - Business details');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1011 - Business details', $url, $html);
        $this->actor->fillField('IdbBusinessSignUpForm[name]', $this->data->name);
        $this->actor->fillField('IdbBusinessSignUpForm[VAT]', $this->data->vat);
        $this->actor->fillField('IdbBusinessSignUpForm[registrationNumber]', $this->data->registrationNumber);
        $this->actor->fillField('IdbBusinessSignUpForm[addressLine1]', $this->data->addressLine1);
        $this->actor->fillField('IdbBusinessSignUpForm[addressLine2]', $this->data->addressLine2);
        $this->actor->fillField('IdbBusinessSignUpForm[city]', $this->data->city);
        $this->actor->fillField('IdbBusinessSignUpForm[region]', $this->data->region);
        $this->actor->fillField('IdbBusinessSignUpForm[postcode]', $this->data->postcode);
        $this->actor->fillField('IdbBusinessSignUpForm[country]', $this->data->country);
        $this->actor->scrollTo(['css' => '#sp-menu'], 0, 500);
        $this->actor->click('next-button');
    }

    public function primaryAccountContactScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/primary-contact~');
        $this->actor->makeScreenshot('1011 - Primary contact details');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1011 - Primary contact details', $url, $html);
        $this->actor->fillField('IdbBusinessSignUpForm[firstname]', $this->data->firstname);
        $this->actor->fillField('IdbBusinessSignUpForm[lastname]', $this->data->lastname);
        $this->actor->fillField('IdbBusinessSignUpForm[initials]', $this->data->initials);
        $this->actor->fillField('IdbBusinessSignUpForm[email]', $this->data->email);
        $this->actor->fillField('IdbBusinessSignUpForm[mobile]', $this->data->mobile);
        $this->actor->fillField('IdbBusinessSignUpForm[password]', $this->data->password);
        $this->actor->fillField('IdbBusinessSignUpForm[repeatPassword]', $this->data->password);
        $this->actor->click('next-button');
    }

    public function emailVerificationScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/email-verification~');
        $this->actor->makeScreenshot('1021 - Account verification: email code');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1021 - Account verification: email code', $url, $html);
        $this->actor->openNewTab();
        $this->actor->amOnUrl('https://messenger.idbank.eu/login');
        $this->actor->see('Please fill out the following fields to login to the Messenger');
        $this->actor->fillField('MessengerLoginForm[username]', $this->data->messengerLogin);
        $this->actor->fillField('MessengerLoginForm[password]', $this->data->password);
        $this->actor->click(['name' => 'login-button']);
        sleep(1);
        $this->actor->amOnPage('/messages');
        $code = $this->actor->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[4]/td/div/div[2]/header/div[2]/div'
        );
        $this->actor->makeScreenshot('1022 - Account verification: Received email');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1022 - Account verification: Received email', $url, $html);
        $this->actor->switchToPreviousTab();
        $this->actor->fillField(Locator::tabIndex(10), $code[4]);
        $this->actor->fillField(Locator::tabIndex(11), $code[5]);
        $this->actor->fillField(Locator::tabIndex(12), $code[6]);
        $this->actor->fillField(Locator::tabIndex(13), $code[12]);
        $this->actor->fillField(Locator::tabIndex(14), $code[13]);
        $this->actor->fillField(Locator::tabIndex(15), $code[14]);
        $this->actor->click('next-button');
    }

    public function smsVerificationScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/sms-verification~');
        $this->actor->makeScreenshot('1031 - Account verification: SMS code');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1031 - Account verification: SMS code', $url, $html);
        $this->actor->openNewTab();
        $this->actor->amOnUrl('https://messenger.idbank.eu/login');
        sleep(1);
        $this->actor->amOnPage('/messages');
        $string = $this->actor->grabTextFrom(
            '/html/body/div[1]/div/div/div/div/table/tbody/tr[1]/td[2]/div/table/tbody/tr[3]/td/div/div'
        );
        $arrayFromString = explode(' ', $string);
        $code = end($arrayFromString);
        $this->actor->makeScreenshot('1032 - Account verification: Received SMS');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', 'Account verification: Received SMS ', $url, $html);
        $this->actor->click('/html/body/nav/div/div[2]/ul/li[2]/a');
        $this->actor->switchToPreviousTab();
        $this->actor->fillField(Locator::tabIndex(10), $code[4]);
        $this->actor->fillField(Locator::tabIndex(11), $code[5]);
        $this->actor->fillField(Locator::tabIndex(12), $code[6]);
        $this->actor->fillField(Locator::tabIndex(13), $code[12]);
        $this->actor->fillField(Locator::tabIndex(14), $code[13]);
        $this->actor->fillField(Locator::tabIndex(15), $code[14]);
        $this->actor->click('next-button');
    }

    public function acceptTacScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/tac~');
        $this->actor->makeScreenshot('1041 - Terms and Conditions');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1041 - Terms and Conditions ', $url, $html);
        $this->actor->executeJS(
            '    $(\'#tac-actions\').show();
                                     $(\'#tac-scroll-info\').hide();'
        );
        $this->actor->checkOption('.iCheck-helper');
        $this->actor->executeJS('$(\'#tac-buttons-next\').attr("disabled", false);');
        $this->actor->click('next-button');
    }

    public function choosePackageScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/package~');
        $this->actor->makeScreenshot('1051 - Service Plans');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1051 - Service Plans ', $url, $html);
        $this->actor->click(
            '/html/body/div[1]/div/section[3]/div/div/form/div[1]/div/div/div/div/div/div[1]/h2[2]/label/button'
        );
        $this->actor->click('next-button');
    }

    public function payAuthScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/billing~');
        $this->actor->makeScreenshot('1052 - Payment Authorization');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1052 - Payment Authorization', $url, $html);
        $this->actor->click('#next');
    }

    public function paySepaScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/billing~');
        $this->actor->click('SEPA');
        sleep(5);
        $this->actor->makeScreenshot('1062 - Subscription Payment - SEPA');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1062 - Subscription Payment - SEPA', $url, $html);
        $this->actor->fillField('sepa.ownerName', $this->data->sepa_name);
        $this->actor->fillField('sepa.ibanNumber', $this->data->sepa_number);
        $this->actor->click('#sepa-button');
    }

    public function successScreen()
    {
        sleep(1);
        $this->actor->seeCurrentUrlMatches('~^/signup/success~');
        $this->actor->makeScreenshot('1067 - Payment successful - when authorized payer makes payment');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1067 - Payment successful - when authorized payer makes payment', $url, $html);
        $this->href = $this->actor->grabAttributeFrom('//*[@id="id-button-recovery-token"]', 'href');
        $this->actor->checkOption('.iCheck-helper');
        $this->actor->click('#login-portal-button');
    }

    public function finishSignup()
    {
        $this->actor->seeCurrentUrlMatches('~^/login~');
        $this->actor->makeScreenshot('1080 - Login Screen');
        $url = $this->actor->grabFromCurrentUrl();
        $html = $this->actor->grabPageSource();
        TranslationHelper::screen('business', '1080 - Login Screen', $url, $html);
        $this->actor->comment('this is the url for your password recovery token:');
        $this->actor->comment($this->href);
    }

}

################################################################################
#                                End of file                                   #
################################################################################
