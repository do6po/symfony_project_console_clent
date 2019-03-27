<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.03.19
 * Time: 13:01
 */

namespace Tests\Helpers;


use Helpers\ValidationErrorConverter;
use Tests\KernelTestCase;

class ValidationErrorConverterTest extends KernelTestCase
{
    /**
     * @var ValidationErrorConverter
     */
    private $helper;

    public function setUp()
    {
        parent::setUp();

        $this->helper = new ValidationErrorConverter();
    }

    /**
     * @param $errors
     * @param $expected
     * @dataProvider convertDataProvider
     */
    public function testConvert($errors, $expected)
    {
        $this->assertEquals($expected, $this->helper->convert($errors));
    }

    public function convertDataProvider()
    {
        return [
            [
                [
                    'name' => ['This value is already used.',],
                    'email' => ['This value is already used.',],
                ],
                [
                    ['This value is already used.', 'This value is already used.']
                ],
            ],
            [
                [
                    'name' => ['This value is already used.', 'Validation error 1'],
                    'email' => ['This value is already used.',],
                ],
                [
                    ['This value is already used.', 'This value is already used.'],
                ],
            ],
            [
                [
                    'name' => ['This value is already used.',],
                    'email' => ['This value is already used.', 'Validation error 1'],
                ],
                [
                    ['This value is already used.', 'This value is already used.'],
                ],
            ],
        ];
    }
}