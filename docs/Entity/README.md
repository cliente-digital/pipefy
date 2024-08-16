# Entities

Entities are the objects you have when load informations from Pipefy.

All Entity support this common methods:

- ```php found(): bool ```
  Give you information about Entities results from a search.
  : true - it is a valid Entity(loaded with data from the resource you search for).
  : false - it is Empty

- ```php __get($dataId):mixed```
  Access to the resource data. For instance, if you have a field named 'numero_cpf':

  ```php
  echo $card->numero_cpf; // return the field value.
  ```

  This implementation is usefull to handle all different fields each Organization pipes can have to reach your goal with Pipefy.

  - Other Methods
    Aside the methods above,  entities support methods to change data related to [graphql mutations](https://api-docs.pipefy.com/reference/mutations/overview/).

Supported Entities

- [Org](https://cliente-digital.github.io/pipefy/Entity/Org)
- [Pipe](https://cliente-digital.github.io/pipefy/Entity/Pipe)
- [Card](https://cliente-digital.github.io/pipefy/Entity/Card)
