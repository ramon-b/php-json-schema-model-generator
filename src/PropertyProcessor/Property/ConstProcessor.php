<?php

declare(strict_types = 1);

namespace PHPModelGenerator\PropertyProcessor\Property;

use PHPModelGenerator\Model\Property\Property;
use PHPModelGenerator\Model\Property\PropertyInterface;
use PHPModelGenerator\Model\Validator\PropertyValidator;
use PHPModelGenerator\PropertyProcessor\PropertyProcessorInterface;

/**
 * Class ConstProcessor
 *
 * @package PHPModelGenerator\PropertyProcessor\Property
 */
class ConstProcessor implements PropertyProcessorInterface
{
    /**
     * @inheritdoc
     */
    public function process(string $propertyName, array $propertyData): PropertyInterface
    {
        return (new Property($propertyName, gettype($propertyData['const'])))
            ->setRequired(true)
            ->setDescription($propertyData['description'] ?? '')
            ->addValidator(new PropertyValidator(
                '$value !== ' . var_export($propertyData['const'], true),
                "Invalid value for $propertyName declined by const constraint"
            ));
    }
}
