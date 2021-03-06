<?php

namespace PHPModelGenerator\Tests\Objects;

use PHPModelGenerator\Exception\FileSystemException;
use PHPModelGenerator\Exception\RenderException;
use PHPModelGenerator\Exception\SchemaException;
use PHPModelGenerator\Tests\AbstractPHPModelGeneratorTest;
use PHPModelGeneratorException\ValidationException;
use stdClass;

/**
 * Class MultiTypePropertyTest
 *
 * @package PHPModelGenerator\Tests\Objects
 */
class MultiTypePropertyTest extends AbstractPHPModelGeneratorTest
{
    /**
     * @throws FileSystemException
     * @throws RenderException
     * @throws SchemaException
     */
    public function testNotProvidedOptionalMultiTypePropertyIsValid(): void
    {
        $className = $this->generateClassFromFile('MultiTypeProperty.json');

        $object = new $className([]);
        $this->assertNull($object->getProperty());
    }

    /**
     * @dataProvider validValueDataProvider
     *
     * @param $propertyValue
     */
    public function testValidProvidedValuePassesValidation($propertyValue): void
    {
        $className = $this->generateClassFromFile('MultiTypeProperty.json');

        $object = new $className(['property' => $propertyValue]);
        $this->assertEquals($propertyValue, $object->getProperty());
    }

    public function validValueDataProvider(): array
    {
        return [
            'Null' => [null],
            'Int lower limit' => [10],
            'Float' => [10.5],
            'String lower length limit' => ['ABCD'],
            'Array with valid items' => [['Hello', 'World']],
        ];
    }

    /**
     * @dataProvider invalidValueDataProvider
     *
     * @param $propertyValue
     * @param string $exceptionMessage
     */
    public function testInvalidProvidedValueThrowsAnException($propertyValue, string $exceptionMessage): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $className = $this->generateClassFromFile('MultiTypeProperty.json');

        new $className(['property' => $propertyValue]);
    }

    public function invalidValueDataProvider()
    {
        return [
            'Bool' => [true, 'Invalid type for property. Requires [float, string, array], got boolean'],
            'Object' => [new stdClass(), 'Invalid type for property. Requires [float, string, array], got object'],
            'Invalid int' => [9, 'Value for property must not be smaller than 10'],
            'zero' => [0, 'Value for property must not be smaller than 10'],
            'Invalid float' => [9.9, 'Value for property must not be smaller than 10'],
            'Invalid string' => ['ABC', 'Value for property must not be shorter than 4'],
            'Array with too few items' => [['Hello'], 'Array property must not contain less than 2 items'],
            'Array with invalid items' => [
                ['Hello', 123],
                <<<ERROR
Invalid item in array property:
  - invalid item #1
    * Invalid type for item of array property. Requires string, got integer
ERROR
            ]
        ];
    }
}
