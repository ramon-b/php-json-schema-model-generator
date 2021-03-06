<?php

namespace PHPModelGenerator\PropertyProcessor\ComposedValue;

/**
 * Class AnyOfProcessor
 *
 * @package PHPModelGenerator\PropertyProcessor\ComposedValue
 */
class AnyOfProcessor
    extends AbstractComposedValueProcessor
    implements ComposedPropertiesInterface, MergedComposedPropertiesInterface
{
    /**
     * @inheritdoc
     */
    protected function getComposedValueValidation(int $composedElements): string
    {
        return "\$succeededCompositionElements > 0";
    }

    /**
     * @inheritdoc
     */
    protected function getComposedValueValidationErrorLabel(int $composedElements): string
    {
        return "Requires to match at least one composition element.";
    }
}
