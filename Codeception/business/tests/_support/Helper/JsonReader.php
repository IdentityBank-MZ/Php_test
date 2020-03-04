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

use Helper\ConfigHelper;

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class JsonReader
 *
 * @package Helper
 */
class JsonReader
{

    private $json = null;

    public function __construct($path)
    {
        $this->json = file_get_contents($path);
        $this->json = json_decode($this->json, true);

        foreach ($this->json as $key => $value) {
            $this->{$key} = $value;
        }
    }
}

################################################################################
#                                End of file                                   #
################################################################################
