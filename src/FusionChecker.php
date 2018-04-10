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
 * The fusion checker will check your composer dependencies and trigger warnings on composer
 * packages that are not trusted.
 *
 * @class FusionChecker.
 */
class FusionChecker extends TrustedPackages
{

    /**
     * @var array $packages The list of composer packages to check.
     */
    private $packages = [];
    
    /**
     * @var array $excludedPackages The list of composer packages to exclude from checking.
     */
    private $excludedPackages = [];

    /**
     * Construct a new fusion checker.
     *
     * @param string $composerJsonPath         The path to your composer json file. 
     * @param array  $excludedComposerPackages A list of excluded composer packages.
     *
     * @throws Exception\UnderflowException If the file requested does not exist.
     *
     * @return void Return nothing.
     */
    public function __construct(string $composerJsonPath, array $excludedComposerPackages = [])
    {
        $this->excludedPackages = $excludedComposerPackages;
        $composerJsonPath = \str_replace([ '\\', '/' ], \DIRECTORY_SEPARATOR, $composerJsonPath);
        if (!\file_exists($composerJsonPath)) {
            throw new Exception\UnderflowException('The file requested does not exist.');
        }
        $jsonContents = \file_get_contents($composerJsonPath);
        $jsonDecoded = \json_decode($jsonContents);
        if (!empty($jsonDecoded) && isset($jsonDecoded['require'])) {
            if (!isset($jsonDecoded['require-dev']) || !array_key_exists('roave/security-advisories')) {
                trigger_error(
                    'It is strongly recommended to add `roave/security-advisories` to your require dev.',
                    E_USER_WARNING
                );
            }
            $this->packages = $jsonDecoded['require'];
        }
    }
    
    /**
     * Validate the composer packages.
     * This is very useful to warn the user of unknown packages before they start using them.
     *
     * @return void Return nothing.
     */
    public function check(): void
    {
        foreach ($this->packages as $package) {
            if (!\array_key_exists($package, self::trustedPackages) && !\array_key_exists($package, $this->excludedPackages)) {
                \trigger_error(\sprintf(
                    'The composer package `%s` is not trusted. If you trust this package you can exclude it.',
                    \htmlspecialchars($package, \ENT_QUOTES);
                ), \E_USER_WARNING);
            }
        }
    }
}
