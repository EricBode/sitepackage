<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;


defined('TYPO3') or die();

(static function () {
    /**
     * Adding the default Page TSconfig
     */
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    if ($versionInformation->getMajorVersion() < 12) {
        ExtensionManagementUtility::addPageTSConfig('@import "EXT:sitepackage/Configuration/page.tsconfig"');
    }

    /**
     * Adding the default User TSconfig
     */
    ExtensionManagementUtility::addUserTSConfig('@import "EXT:sitepackage/Configuration/TsConfig/user.tsconfig"');

    /**
     * Register custom EXT:form configuration
     */
    if (ExtensionManagementUtility::isLoaded('form')) {
        ExtensionManagementUtility::addTypoScriptSetup(trim('
        module.tx_form {
            settings {
                yamlConfigurations {
                    110 = EXT:sitepackage/Configuration/Form/CustomFormSetup.yaml
                }
            }
        }
        plugin.tx_form {
            settings {
                yamlConfigurations {
                    110 = EXT:sitepackage/Configuration/Form/CustomFormSetup.yaml
                }
            }
        }
    '));
    }
})();