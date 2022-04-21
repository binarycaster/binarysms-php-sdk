<?php

namespace Binarycaster\Binarysms\Tests;

use Binarycaster\Binarysms\Config;
use Binarycaster\Binarysms\Sample;

/**
 * Class SampleTest
 *
 * @category Test
 * @package  Binarycaster\Binarysms\Tests
 * @author   Mahmoud Zalt <mahmoud@zalt.me>
 */
class SampleTest extends TestCase
{

    public function testSayHello()
    {
        $config = new Config();
        $sample = new Sample($config);

        $name = 'Mahmoud Zalt';

        $result = $sample->sayHello($name);

        $expected = $config->get('greeting') . ' ' . $name;

        $this->assertEquals($result, $expected);

    }

}
