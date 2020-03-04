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
# Include(s)                                                                   #
################################################################################

include_once 'simplelog.inc';
include_once 'jsonsimpleconfig.inc';
include_once 'idbyii2/helpers/IdbYii2Config.php';

################################################################################
# Use(s)                                                                       #
################################################################################

use idbyii2\helpers\IdbYii2Config;
use function xmz\simplelog\logLevel;
use function xmz\simplelog\registerLogger;

################################################################################
# Local Config                                                                 #
################################################################################

const codeceptionConfigFile = '/etc/p57b/codeception.jsc';

################################################################################
# Class(es)                                                                    #
################################################################################

class CodeceptionConfig extends IdbYii2Config
{

    private static $instance;

    /**
     * CodeceptionConfig constructor.
     */
    final protected function __construct()
    {
        parent::__construct();
        $this->mergeJscFile(codeceptionConfigFile);
        registerLogger($this->getLogName(), $this->getLogPath());
        logLevel($this->getLogLevel());
    }

    /**
     * @return \CodeceptionConfig
     */
    public static function get()
    {
        if (!isset(self::$instance) || !self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public static function getConfig($section)
    {
        $configData = self::get();
        $config = $configData->getSection($section);

        return $config;
    }

    function getLogLevel()
    {
        return $this->getValue("Log", "logLevel", 5);
    }

    function getLogName()
    {
        return $this->getValue("Log", "logName", "codeception.log");
    }

    function getLogPath()
    {
        return $this->getValue("Log", "logPath", "/var/log/p57b/");
    }
}

################################################################################
#                                End of file                                   #
################################################################################
