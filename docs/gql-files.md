# Cliente Digital  - gql files

Gql files ( .gql is an acronym for graphql files) are files with a query or a mutation that you use to interact with the Pipefy GraphQL. You can learn more about pipefy graphql on its [documentation](https://api-docs.pipefy.com/reference/overview/Card/) and [pratice/test here](https://api.pipefy.com/graphiql).

This package offer gql's you may know at [graphql directory](https://github.com/cliente-digital/pipefy/tree/main/.pipefy/graphql). You dont need to know this files to use the package but read them are a good way to learn more about pipefy graphql api and also improve your know to implements your own gql's.

Let's check how this package use gql's. For instance, take a look into the
the [pipe/all.gql](https://github.com/cliente-digital/pipefy/blob/main/.pipefy/graphql/pipe/all.gql) used to retrieve all Pipes from a specific organization:

```graphql
{
  organization(id:_R.ORGID_){
    pipes{
      id
    }
  }
}
```

This file contain a graphql query and use only one variable ```ORGID``` to receive the organization id you gonna query.

The syntax are ```_R.ORGID_```. All variables are defined in uppercase,  between underscore ```_[VARIABLE]_```  and the prefix ```R``` is used to set a variable as **Required**. If you try to run this script without set ORGID you receive an Exception.

You dont't use this gql directly. They are used by the Pipefy\Graphql implementations. At this case [Pipefy\Graphql\Pipe\All](https://github.com/cliente-digital/pipefy/blob/main/src/Graphql/Pipe/All.php).



Ok, let's check another example. The gql file [label/create](https://github.com/cliente-digital/pipefy/blob/main/.pipefy/graphql/label/create.gql):

```graphQL
mutation{
createLabel(
  input: {
  color: "_COLOR_"
  name: "_NAME_"
  pipe_id: _PIPEID_
  table_id: _TABLEID_
  }
) {
  clientMutationId
}
}
```

from this gql we can understand:

- its is a mutation.

variables are:
- COLOR (optional)
- NAME (optional)
- PIPEID (optional)
- TABLEID (optional)

But now let's talk about the type of variables. It can be only **with** **quotation mark** or **without** quotation mark. By without quotation mark you have boolean as the field [done at mutation updateCard](https://api-docs.pipefy.com/reference/objects/Card/), Int like the field [current_phase_age at updateCard](https://api-docs.pipefy.com/reference/objects/Card/) or any other type you need set without Quotation mark  and be quoted are String and Datetime (check pipefy graphql [objects documentation](https://api-docs.pipefy.com/reference/objects/AppAttachment/)).

### Field Types

- Int : Represents a unique identifier that is Base64 obfuscated. It is often used to refetch an object or as key for a cache. The ID type appears in a JSON response as a String; however, it is not intended to be human-readable. When expected as an input type, any string (such as `"VXNlci0xMA=="`) or integer (such as `4`) input value will be accepted as an ID.
- String : Represents textual data as UTF-8 character sequences. This type is most often used by GraphQL to represent free-form human-readable text.
- DateTime : An ISO‐8601 encoded UTC date time string (YYYY-MM-DD HH:MM:SS).
**Most important:** YOU **MUST** add quotation mark directly into you gql variables. The type system  don't handle this until this implement a type check and I don't know yet if we are going this way.
