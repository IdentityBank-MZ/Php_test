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

require_once(dirname(__FILE__).'/../config.php');
require_once(IDBYII2_PATH . 'helpers/IdbMessagesHelper.php');

use Exception;
use Helper\ConfigHelper;
use idbyii2\helpers\IdbMessagesHelper;
use models\ScreenTranslate;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class TranslationHelper
 *
 * @package Helper
 */
class TranslationHelper
{
    private static $screensUrl = SCREENS_URL;
    public static $enabled = false;

    /**
     * @param $portal
     * @param $screenName
     * @param $url
     * @param $urlBody
     */
    public static function screen($portal, $screenName, $url, $html)
    {
        if(!self::$enabled){
            return;
        }
        $test = new ScreenTranslate();

        $urlBody = $html;
        try {
            $translations = IdbMessagesHelper::getAllMessageKeys(
                '/usr/local/share/p57b/php',
                'en-GB',
                [$portal, 'idbyii2']
            );

            foreach ($translations as $translate) {
                if ($translate === '') {
                    continue;
                }
                if (strpos($urlBody, $translate) !== false) {
                    codecept_debug($translate . '=>' . $screenName);
                    try {
                        $test = new ScreenTranslate();
                        $test->screen_name = $screenName;
                        $test->translation = $translate;
                        $test->portal_name = $portal;
                        $test->screen_url = self::$screensUrl . rawurlencode($screenName . '.png');
                        $test->portal_url = $url;
                        $test->save();
                    } catch (Exception $e) {
                        codecept_debug('catch');
                        codecept_debug($e->getMessage());
                    }
                }
            }
        } catch (Exception $e) {
            codecept_debug($e->getMessage());
        }

    }

    /**
     * @throws \yii\db\Exception
     */
    public static function truncate()
    {
        ScreenTranslate::getDb()->createCommand()->truncateTable(ScreenTranslate::tableName())->execute();
    }

}

################################################################################
#                                End of file                                   #
################################################################################
