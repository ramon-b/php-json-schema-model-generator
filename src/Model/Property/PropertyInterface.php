<?php

declare(strict_types=1);

namespace PHPModelGenerator\Model\Property;

use PHPModelGenerator\Model\Schema;
use PHPModelGenerator\Model\Validator;
use PHPModelGenerator\Model\Validator\PropertyValidatorInterface;
use PHPModelGenerator\PropertyProcessor\Decorator\Property\PropertyDecoratorInterface;
use PHPModelGenerator\PropertyProcessor\Decorator\TypeHint\TypeHintDecoratorInterface;

/**
 * Interface PropertyInterface
 *
 * @package PHPModelGenerator\Model
 */
interface PropertyInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getAttribute(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return PropertyInterface
     */
    public function setType(string $type): PropertyInterface;

    /**
     * @return string
     */
    public function getTypeHint(): string;

    /**
     * @param TypeHintDecoratorInterface $typeHintDecorator
     *
     * @return PropertyInterface
     */
    public function addTypeHintDecorator(TypeHintDecoratorInterface $typeHintDecorator): PropertyInterface;

    /**
     * Get a description for the property. If no description is available an empty string will be returned
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Set a description for the property
     *
     * @param string $description
     *
     * @return PropertyInterface
     */
    public function setDescription(string $description): PropertyInterface;

    /**
     * Add a validator for the property
     *
     * @param PropertyValidatorInterface $validator
     * @param int $priority
     *
     * @return PropertyInterface
     */
    public function addValidator(PropertyValidatorInterface $validator, int $priority = 99): PropertyInterface;

    /**
     * @return Validator[]
     */
    public function getValidators(): array;

    /**
     * Filter the assigned validators
     *
     * @param callable $filter
     *
     * @return PropertyInterface
     */
    public function filterValidators(callable $filter): PropertyInterface;

    /**
     * Retrieve all added validators ordered by priority
     *
     * @return PropertyValidatorInterface[]
     */
    public function getOrderedValidators(): array;

    /**
     * Add a decorator to the property
     *
     * @param PropertyDecoratorInterface $decorator
     *
     * @return PropertyInterface
     */
    public function addDecorator(PropertyDecoratorInterface $decorator): PropertyInterface;

    /**
     * Resolve all decorators of the property
     *
     * @param string $input
     *
     * @return string
     */
    public function resolveDecorator(string $input): string;

    /**
     * @return bool
     */
    public function hasDecorators(): bool;

    /**
     * @param bool $isPropertyRequired
     *
     * @return PropertyInterface
     */
    public function setRequired(bool $isPropertyRequired): PropertyInterface;

    /**
     * @param bool $isPropertyReadOnly
     *
     * @return PropertyInterface
     */
    public function setReadOnly(bool $isPropertyReadOnly): PropertyInterface;

    /**
     * @param mixed $defaultValue
     *
     * @return PropertyInterface
     */
    public function setDefaultValue($defaultValue): PropertyInterface;

    /**
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @return bool
     */
    public function isReadOnly(): bool;

    /**
     * Set a nested schema
     *
     * @param Schema $schema
     *
     * @return PropertyInterface
     */
    public function setNestedSchema(Schema $schema);

    /**
     * Get a nested schema if a schema was appended to the property
     *
     * @return null|Schema
     */
    public function getNestedSchema(): ?Schema;
}
