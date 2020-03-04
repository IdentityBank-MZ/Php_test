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

namespace models;

################################################################################
# Use(s)                                                                       #
################################################################################

require_once(dirname(__FILE__).'/../config.php');
require_once(YII_PATH . 'vendor/autoload.php');
require_once(YII_PATH . 'vendor/yiisoft/yii2/Yii.php');

use yii\db\ActiveRecord;
use yii\db\Connection;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * @property int    $id
 * @property string $translation
 * @property string $timestamp
 * @property string $portal_name
 * @property string $screen_name
 * @property string $screen_url
 * @property string $portal_url
 */
class ScreenTranslate extends ActiveRecord
{
    static $connection = null;

    public static function getDb()
    {
        if(self::$connection == null) {
            self::$connection = new Connection(
                [
                    'dsn' => '',
                    'username' => '',
                    'password' => '',
                    'charset' => 'utf8',
                    'schemaMap' => [
                        'pgsql' => [
                            'class' => 'yii\db\pgsql\Schema',
                            'defaultSchema' => "p57b_translation"
                        ]
                    ],
                    'on afterOpen' => function ($event) {
                        $dbSchema = 'p57b_translation';
                        $event->sender->createCommand("SET search_path TO $dbSchema;")->execute();
                    },
                ]
            );
        }

        return self::$connection;
    }

    public static function tableName()
    {
        return '{{idb_screen_translation}}';
    }
}

################################################################################
#                                End of file                                   #
################################################################################
