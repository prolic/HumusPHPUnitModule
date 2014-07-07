<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace HumusPHPUnitModule;

use Zend\Json\Json;

/**
 * Class to store and retrieve the version of Humus PHPUnit Module.
 */
final class Version
{
    /**
     * version identification
     */
    const VERSION = '1.1.3';

    /**
     * The latest stable version available
     *
     * @var string
     */
    protected static $latestVersion;

    /**
     * Compare the specified version string $version
     * with the current HumusPHPUnitModule\Version::VERSION.
     *
     * @param  string  $version  A version string (e.g. "0.7.1").
     * @return int           -1 if the $version is older,
     *                           0 if they are the same,
     *                           and +1 if $version is newer.
     *
     */
    public static function compareVersion($version)
    {
        $version = strtolower($version);
        $version = preg_replace('/(\d)pr(\d?)/', '$1a$2', $version);
        return version_compare($version, strtolower(self::VERSION));
    }

    /**
     * Fetches the version of the latest stable release.
     *
     * It will use the GitHub API (v3) and only returns refs that begin with 'tags/'.
     * Because GitHub returns the refs in alphabetical order, we need to reduce
     * the array to a single value, comparing the version numbers with
     * version_compare().
     *
     * @see http://developer.github.com/v3/git/refs/#get-all-references
     * @link https://api.github.com/repos/prolic/HumusPHPUnitModule/git/refs/tags/
     * @return string
     */
    public static function getLatest()
    {
        if (null === static::$latestVersion) {
            static::$latestVersion = 'not available';
            $url  = 'https://api.github.com/repos/prolic/HumusPHPUnitModule/git/refs/tags/';

            $apiResponse = Json::decode(file_get_contents($url), Json::TYPE_ARRAY);

            // Simplify the API response into a simple array of version numbers
            $tags = array_map(function ($tag) {
                return substr($tag['ref'], 10); // Reliable because we're filtering on 'refs/tags/'
            }, $apiResponse);

            // Fetch the latest version number from the array
            static::$latestVersion = array_reduce($tags, function ($a, $b) {
                return version_compare($a, $b, '>') ? $a : $b;
            });
        }

        return static::$latestVersion;
    }

    /**
     * Returns true if the running version of Humus PHPUnit Module is
     * the latest (or newer??) than the latest tag on GitHub,
     * which is returned by static::getLatest().
     *
     * @return bool
     */
    public static function isLatest()
    {
        return static::compareVersion(static::getLatest()) < 1;
    }
}
