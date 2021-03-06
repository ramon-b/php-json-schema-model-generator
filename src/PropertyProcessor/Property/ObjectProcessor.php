<?php

declare(strict_types = 1);

namespace PHPModelGenerator\PropertyProcessor\Property;

use PHPModelGenerator\Exception\SchemaException;
use PHPModelGenerator\Model\Property\PropertyInterface;
use PHPModelGenerator\PropertyProcessor\Decorator\Property\ObjectInstantiationDecorator;
use PHPModelGenerator\PropertyProcessor\Decorator\SchemaNamespaceTransferDecorator;

/**
 * Class ObjectProcessor
 *
 * @package PHPModelGenerator\PropertyProcessor\Property
 */
class ObjectProcessor extends AbstractTypedValueProcessor
{
    protected const TYPE = 'object';

    /**
     * @inheritdoc
     *
     * @throws SchemaException
     */
    public function process(string $propertyName, array $propertyData): PropertyInterface
    {
        $property = parent::process($propertyName, $propertyData);

        $className = $this->schemaProcessor->getGeneratorConfiguration()->getClassNameGenerator()->getClassName(
            $propertyName,
            $propertyData,
            false,
            $this->schemaProcessor->getCurrentClassName()
        );

        $schema = $this->schemaProcessor->processSchema(
            $propertyData,
            $this->schemaProcessor->getCurrentClassPath(),
            $className,
            $this->schema->getSchemaDictionary()
        );

        if ($schema === null) {
            throw new SchemaException("Failed to process schema for object property $propertyName");
        }

        // if the generated schema is located in a different namespace (the schema for the given structure in
        // $propertyData is duplicated) add used classes to the current schema. By importing the class which is
        // represented by $schema and by transferring all imports of $schema as well as imports for all properties
        // of $schema to $this->schema the already generated schema can be used
        if ($schema->getClassPath() !== $this->schema->getClassPath() ||
            $schema->getClassName() !== $this->schema->getClassName()
        ) {
            $this->schema->addUsedClass("{$schema->getClassPath()}\\{$schema->getClassName()}");
            $this->schema->addNamespaceTransferDecorator(new SchemaNamespaceTransferDecorator($schema));
        }

        $property
            ->addDecorator(
                new ObjectInstantiationDecorator(
                    $schema->getClassName(),
                    $this->schemaProcessor->getGeneratorConfiguration()
                )
            )
            ->setType($schema->getClassName())
            ->setNestedSchema($schema);

        return $property;
    }
}
