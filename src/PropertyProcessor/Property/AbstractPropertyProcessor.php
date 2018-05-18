<?php

declare(strict_types = 1);

namespace PHPModelGenerator\PropertyProcessor\Property;

use InvalidArgumentException;
use PHPModelGenerator\Model\Property;
use PHPModelGenerator\Model\PropertyValidator;
use PHPModelGenerator\PropertyProcessor\PropertyCollectionProcessor;
use PHPModelGenerator\PropertyProcessor\PropertyProcessorInterface;

/**
 * Class AbstractPropertyProcessor
 *
 * @package PHPModelGenerator\PropertyProcessor\Property
 */
abstract class AbstractPropertyProcessor implements PropertyProcessorInterface
{
    /** @var PropertyCollectionProcessor */
    protected $propertyCollectionProcessor;

    /**
     * AbstractPropertyProcessor constructor.
     *
     * @param PropertyCollectionProcessor $propertyCollectionProcessor
     */
    public function __construct(PropertyCollectionProcessor $propertyCollectionProcessor)
    {
        $this->propertyCollectionProcessor = $propertyCollectionProcessor;
    }

    /**
     * Generates the validators for the property
     *
     * @param Property $property
     * @param array    $propertyData
     */
    protected function generateValidators(Property $property, array $propertyData): void
    {
        if ($this->propertyCollectionProcessor->isAttributeRequired($property->getName())) {
            $property->addValidator(
                new PropertyValidator(
                    "!isset(\$modelData['{$property->getName()}'])",
                    InvalidArgumentException::class,
                    "missing required value for {$property->getName()}"
                )
            );
        }

        if (isset($propertyData['enum'])) {
            $this->addEnumValidator($property, $propertyData['enum']);
        }
    }

    /**
     * Add a validator to a property which validates the value against a list of allowed values
     *
     * @param Property $property
     * @param array    $allowedValues
     */
    protected function addEnumValidator(Property $property, array $allowedValues)
    {
        $property->addValidator(
            new PropertyValidator(
                '!in_array($value, ' .
                    preg_replace('(\d+\s=>)', '', var_export(array_values($allowedValues), true)) .
                    ', true)',
                InvalidArgumentException::class,
                "Invalid value for {$property->getName()}"
            )
        );
    }
}
