One Of
======

The `oneOf` keyword can be used to combine multiple subschemas. The provided value must be valid against exactly one of the subschemas.

.. code-block:: json

    {
        "$id": "example",
        "type": "object",
        "properties": {
            "example": {
                "oneOf": [
                    {
                        "type": "number",
                        "multipleOf": 5
                    },
                    {
                        "type": "number",
                        "multipleOf": 3
                    }
                ]
            }
        }
    }

Valid values are eg. 3, 5, 6, 9, 10, 12. Invalid values are eg. 1, 2, 4, 7, 8, 11 or any non numeric values.

Generated interface:

.. code-block:: php

    public function setExample(float $example): self;
    public function getExample(): float;


Possible exception (if a string is provided):

.. code-block:: none

    Invalid value for example declined by composition constraint.
      Requires to match one composition element but matched 0 elements.
      - Composition element #1: Failed
        * Invalid type for example. Requires float, got string
      - Composition element #2: Failed
        * Invalid type for example. Requires float, got string


Possible exception (if eg. 15 is provided, which matches both subschemas):

.. code-block:: none

    Invalid value for example declined by composition constraint.
      Requires to match one composition element but matched 2 elements.
      - Composition element #1: Valid
      - Composition element #2: Valid

.. hint::

    When combining multiple nested objects with an `oneOf` composition a `merged property <mergedProperty.html>`__ will be generated
