<?php

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
        $expect = -1;
        for ($i=0; $i < 2; $i++) {
            for ($j=0; $j < 12; $j++) {
                for ($k=0; $k < 20; $k++) {
                    foreach (array('dev', 'pr', 'PR', 'alpha', 'a1', 'a2', 'beta', 'b1', 'b2', 'RC', 'RC1', 'RC2', 'RC3', '', 'pl1', 'PL1') as $rel) {
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
                                . ', but expected ' . $expect);
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
}
