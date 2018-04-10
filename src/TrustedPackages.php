<?php
declare(strict_types=1);
/**
 * Fusion Checker.
 *
 * @link    <https://github.com/Nenglish7/FusionChecker> Github Repository.
 * @license <https://github.com/Nenglish7/FusionChecker/master/LICENSE> MIT License.
 *
 * @copyright Copyright (C) 2018 Nicholas English <https://github.com/Nenglish7>
 */

namespace Nenglish7\FusionChecker;

/**
 * This class will contain a list of trusted composer packages.
 *
 * @class TrustedPackages.
 */
class TrustedPackages
{

    /**
     * @const array $trustedPackages The list of trusted packages.
     */
    private $packages = [
        'nenglish-security/fusion-checker'
    ];
}
