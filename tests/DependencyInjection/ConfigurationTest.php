<?php

namespace Codatte\Bundle\PayumMoneticoBundle\DependencyInjection;

use Ekyna\Component\Payum\Monetico\Api\Api;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class ConfigurationTest
 * @package Codatte\Bundle\PayumMoneticoBundle
 * @author  Etienne Dauvergne <contact@ekyna.com> and Codatte <devteam@codatte.fr>
 */
class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    protected function tearDown(): void
    {
        $this->configuration = null;
        $this->processor = null;
    }

    /**
     * @param array $config
     *
     * @dataProvider provideValidConfigs
     */
    public function testValidApiConfig(array $config)
    {
        $this->processor->processConfiguration($this->configuration, [
            'payum_monetico' => [
                'api' => [$config,],
            ],
        ]);
    }

    /**
     * @param array $config
     *
     * @dataProvider provideInvalidConfigs
     */
    public function testInvalidApiConfig(array $config)
    {
        $this->expectException(Exception::class);

        $this->processor->processConfiguration($this->configuration, [
            'payum_monetico' => [
                'api' => [$config,],
            ],
        ]);
    }

    public function provideValidConfigs()
    {
        return [
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'mode'    => Api::MODE_TEST,
                'tpe'     => 'abc_def_ghi',
                'key'     => '1234567890',
                'company' => 'Ekyna',
                'debug'   => false,
            ]],
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1234567890',
                'key'     => 'abc_def_ghi',
                'company' => 'Monetico',
            ]],
        ];
    }

    public function provideInvalidConfigs()
    {
        return [
            [[
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'debug'   => true,
            ]],
            [[
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'bank'    => 'foo',
                'mode'    => Api::MODE_PRODUCTION,
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
            [[
                'mode'    => 'bar',
                'tpe'     => '1324567890',
                'key'     => '1234567890',
                'company' => 'foobar',
                'debug'   => true,
            ]],
        ];
    }
}
