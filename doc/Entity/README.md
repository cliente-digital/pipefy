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
    Aside the methods above each Entity Type support methods to change data. This methods are different from each Entity to support the mutations. (to see al mutations check the [pipefy documentation](https://api-docs.pipefy.com/reference/mutations/overview/) and bellow Entity Documentations) .

Supported Entities

- [Org](https://github.com/cliente-digital/pipefy/blob/main/doc/Entity/Org.md)
- [Pipe](https://github.com/cliente-digital/pipefy/blob/main/doc/Entity/Pipe.md)
- [Card](https://github.com/cliente-digital/pipefy/blob/main/doc/Entity/Card.md)

