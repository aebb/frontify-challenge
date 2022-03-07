<?php

namespace Frontify\Tests\Unit\Utils;

use Frontify\ColorApi\Request\Color\GetRequest;
use Frontify\ColorApi\Utils\Logger;
use Frontify\ColorApi\Utils\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Frontify\ColorApi\Utils\Logger
 */
class LoggerTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::log
     */
    public function testValidate()
    {
        $input = 'foobar';
        $expected = Logger::LOGGER_INFO . $input;
        $sut = new Logger();
        $this->assertEquals($expected, $sut->log(Logger::LOGGER_INFO, $input));
    }
}
