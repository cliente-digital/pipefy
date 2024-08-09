# Search Beyond the Basics. (part 2)
### How can you improve the search and find what you want.

---
   Este artigo faz parte de uma série sobre recursos da plataforma Pipefy e como integrar o Pipefy em sua aplicação utilizando o pacote [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy)

tags: #pipefy #integração #php #clientedigital #workflow #bpm #search

---

Na [primeira parte](./2-Search-beyond-the-basics-part-1.md) deste artigo apresentamos a busca do app pipefy, sua relação com a query cards e como esse conexão impacta a experiencia de busca no app reforçando o uso de uma taxinomia de tags efetiva.

Nesse artigo vou cobrir como utilizar o pacote [clientedigital/pipefy](https://github.com/cliente-digital/pipefy/tree/main) para implementar pesquisas em todos os campos.

Primeiro vamos instalar e configurar o pacote. No momento que esse artigo esta sendo escrito ele esta na [versão 0.1.0](https://packagist.org/packages/clientedigital/pipefy). Vamos lá:

- instalar o pacote.
- informar sua chave de api do pipefy.
- gerar o build do seu schema.

```bash
# instalacao
composer require clientedigital/pipefy

# configuração.
./vendor/bin/cd.pipefy --config APIKEY '[sua api key aqui]'

# build do schema.
./vendor/bin/cd.pipefy --config build-schema

```

Agora estamos prontos para programar nossa primeira requisição de cards. Vamos iniciar requisitando todos os cards de um pipe.

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

A proxima pesquisa é suportada pela api do pipefy. Como vimos na parte 1 desse artigo a query graphql cards permite alguns parametros de pesquisa. Vamos utilizar um Filter especializado em card que suporta esse método de pesquisa.

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

E agora vamos **adicionar novos recursos de pesquisa** e filtrar campos criados pelo usuário em _formularios iniciais_ e _formularios de fase_.

Os filtros suportam pesquisas em campos criados pelo usuário atraǘes do método **by**(_$campo, $operador, $valor_).

```php

$cardFilter = new Clientedigital\Pipefy\Filter\Cards();

// vamos pesquisar pelo campo sobrenome do formulário inicial.
$cardFilter->by('sobrenome', '=', 'Silva');


$Cards = new Clientedigital\Pipefy\Cards(999999999);

$entities = $Cards->get($cardFilter);

foreach($entities as $card){
    print_r($card);
};
```
A execução da pesquisa acima segue o seguinte plano:
- Execução da query cards e retorno dos cards.
- sec scan pelos resultado( cada entidate passa pelo filtro e é checada para ser retornada ou não).
- o filtro realiza uma checagem **BY** o campo sobrenome para ver se é Equal('=') ao valor 'Silva'. Se for então yield o item.

Em um outro artigo iremos falar de [seq scan](https://en.wikipedia.org/wiki/Full_table_scan) e do **uso de cache**. Sem esse recurso o tempo de pesquisa depende da API e do rate limit e isso prejudicaria a performance, porém, o próximo artigo vai tratar dos Filtros e Operadores.
