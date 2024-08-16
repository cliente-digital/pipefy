# Beyond Basic Search (Part 2)
### How to Find What You Need with an Enhanced Search.

---
   This article is part of a series about the features of the [Pipefy](https://www.pipefy.com/) platform and the integration with applications using the [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy) package

---

tags: #pipefy #integração #php #clientedigital #workflow #bpm #search #graphql

In the [first part](./2-Search-beyond-the-basics-part-1.md) of this article, we introduced Pipefy's search functionality, its relation to the cards query, and how this connection impacts the search experience in the app, reinforcing the importance of an effective tag taxonomy.

In this article, I’ll cover how to use the [clientedigital/pipefy](https://github.com/cliente-digital/pipefy/tree/main) package to implement searches across all fields.

First, let’s install and configure the package. At the time of writing, it’s at [versão 0.1.0](https://packagist.org/packages/clientedigital/pipefy). Let’s go:

- Install the package.
- Enter your Pipefy API key.
- Generate your schema build.

```bash
# Installation
composer require clientedigital/pipefy

# Configuration.
./vendor/bin/cd.pipefy --config APIKEY '[sua api key aqui]'

# Schema build.
./vendor/bin/cd.pipefy --config build-schema

```

Now we’re ready to code our first card request. Let’s start by requesting all cards from a pipe.

```php
//
$Cards = new Clientedigital\Pipefy\Cards([pipeId]);

// busca todos os cards e retonar um generator para iterar por eles.
$entities = $Cards->get();

// iterate over all cards in the pipe(pipeId)
foreach($entities as $card){
    print_r($card);
};
```

The next search is supported by Pipefy’s API. As we saw in part 1 of this article, the GraphQL cards query allows some search parameters. We’ll use a specialized card filter that supports this search method.

```php

// cria um filtro do tipo card.
$cardFilter = new Clientedigital\Pipefy\Filter\Cards();

// pesquisa exata pelo titulo.
$cardFilter->titled("Card 3");

// inclui cards done.
$cardFilter->includeDone(true);

// criar um Handler de Cards.
$Cards = new Clientedigital\Pipefy\Cards(999999999);

// executa a graphql cards com parametros de search e
// retorna um generator.
$entities = $Cards->get($cardFilter);

// iterate over all cards in the pipe(pipeId)
foreach($entities as $card){
  print_r($card);
};
```

Now, let's **add new search features** and filter fields created by the user in _initial forms_ and _phase forms_.

The filters support searches in user-created fields through the  method **by**(_$campo, $operador, $valor_).

```php

$cardFilter = new Clientedigital\Pipefy\Filter\Cards();

//  Let's search by the last name field in the initial form.
$cardFilter->by('sobrenome', '=', 'Silva');


$Cards = new Clientedigital\Pipefy\Cards(999999999);

$entities = $Cards->get($cardFilter);

foreach($entities as $card){
    print_r($card);
};
```
The execution of the above search follows this plan:

- Execution of the cards query and return of the cards.
- Seq scan of the results (each entity passes through the filter and is checked whether to be returned or not).
- The filter performs a **BY** check on the last name field to see if it is Equal ('=') to the value 'Silva'. If it is, then the item is yielded.

In another article, we will discuss [seq scan](https://en.wikipedia.org/wiki/Full_table_scan) anf **cache**. Without this feature, search time depends on the API and the rate limit, which could impact performance. However, the next article will cover Filters and Operators.
