References
==========

References can be used to re-use parts/objects of JSON-Schema definitions.

Supported reference types
-------------------------

* internal (in a single file) reference by id (example: `"$ref": "#IdOfMyObject"`)
* internal (in a single file) reference by path (example: `"$ref": "#/definitions/myObject"`)
* relative reference based on the location on the file system to a complete file (example: `"$ref": "./../modules/myObject.json"`)
* relative reference based on the location on the file system to an object by id (example: `"$ref": "./../modules/myObject.json#IdOfMyObject"`)
* relative reference based on the location on the file system to an object by path (example: `"$ref": "./../modules/myObject.json#/definitions/myObject"`)
* network reference to a complete file (example: `"$ref": "https://my.domain.com/schema/modules/myObject.json"`)
* network reference to an object by id (example: `"$ref": "https://my.domain.com/schema/modules/myObject.json#IdOfMyObject"`)
* network reference to an object by path (example: `"$ref": "https://my.domain.com/schema/modules/myObject.json#/definitions/myObject"`)

Object reference
----------------

An example for properties referring to a definition inside the same schema:

.. code-block:: json

    {
        "definitions": {
            "person": {
                "$id": "#person",
                "type": "object",
                "properties": {
                    "name": {
                        "type": "string"
                    }
                }
            }
        },
        "$id": "team",
        "type": "object",
        "properties": {
            "leader": {
                "$ref": "#person"
            }
            "members": {
                "type": "array",
                "items": {
                    "$ref": "#/definitions/person"
                }
            }
        }
    }
