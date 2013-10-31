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

namespace HumusPHPUnitModuleTest;

use HumusPHPUnitModule\Version;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests that version_compare() and its "proxy"
     * HumusPHPUnitModule\Version::compareVersion() work as expected.
     */
    public function testVersionCompare()
    {
        $prefixes =  array(
            'dev', 'pr', 'PR', 'alpha', 'a1', 'a2', 'beta', 'b1', 'b2', 'RC', 'RC1', 'RC2', 'RC3', '', 'pl1', 'PL1'
        );
        $expect = -1;
        for ($i=0; $i < 2; $i++) {
            for ($j=0; $j < 12; $j++) {
                for ($k=0; $k < 20; $k++) {
                    foreach ($prefixes as $rel) {
                        $ver = "$i.$j.$k$rel";
                        $normalizedVersion = strtolower(Version::VERSION);
                        if (strtolower($ver) === $normalizedVersion
                            || strtolower("$i.$j.$k-$rel") === $normalizedVersion
                            || strtolower("$i.$j.$k.$rel") === $normalizedVersion
                            || strtolower("$i.$j.$k $rel") === $normalizedVersion
                        ) {
                            if ($expect == -1) {
                                $expect = 1;
                            }
                        } else {
                            $this->assertSame(
                                Version::compareVersion($ver),
                                $expect,
                                "For version '$ver' and HumusPHPUnitModule\\Version::VERSION = '"
                                . Version::VERSION . "': result=" . (Version::compareVersion($ver))
                                . ', but expected ' . $expect
                            );
                        }
                    }
                }
            }
        };
    }

    /**
     * Run in separate process to avoid Version::$latestParameter caching
     *
     * @runInSeparateProcess
     */
    public function testFetchLatestVersion()
    {
        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('This test requires openssl extension to be enabled in PHP');
        }

        $actual = Version::getLatest();
        $this->assertRegExp('/^[1-2](\.[0-9]+){2}/', $actual);
    }

    /**
     * Run in separate process to avoid Version::$latestParameter caching
     *
     * @runInSeparateProcess
     */
    public function testIsLatest()
    {
        if (!extension_loaded('openssl')) {
            $this->markTestSkipped('This test requires openssl extension to be enabled in PHP');
        }

        $latest = Version::isLatest();
        $this->assertInternalType('bool', $latest);
    }
}
