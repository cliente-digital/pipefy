# Cache de Consulta(Query)
### Acelerando o resultado.

---
Este artigo é parte de uma série sobre recursos da plataforma [Pipefy](https://www.pipefy.com/) e a integração com aplicativos utilizando o pacote [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy)

tags: #pipefy #integração #php #clientedigital #workflow #bpm #search

---

Quando realizamos uma consulta (query) fazemos requisições na API graphql da Pipefy. Essa API tem uma ótima performance mas o tipo de requisição e tamanho do payload de retorno interfere na performance e pode resultar numa sensação de lentidão. Nesse artigo explico as limitações sugeridas pela Pipefy e como o pacote Clientedigital\Pipefy implementa essas questões.

Limitações e recomendações da Pipefy:
1. Máximo de 50 itens por página.
2. rate limit de 500 requisições a cada 30 segundos.
3. manter até 30 webhooks por pipe.
4. anexos de máximo 512Mb.

Vamos focar nas limitações 1 e 2, que estão relacionadas a consultas(query).

## 1. Máximo de 50 itens por página.

Consultas como allCards e Cards podem retornar um número muito grande de Itens. O tamanho máximo da página é de 50 itens e a API implementa paginação baseada em cursores para lidar com isso.

Vejamos como utilizar a paginação com cursores.

```graphql
  cards(pipe_id: _PIPEID_, first:50 _SEARCH_) {
    edges {
      node {
        id
        title
        }
    }
} pageInfo {
      endCursor
      hasNextPage
    }
  }
}
```

o retorno dessa requisição sera parecido com o apresentado abaixo:

```
{
"data": {
  "cards": {
      "edges": [
          "node": {
              "id": "968095887",
              "title": "texto simples"
              }
            ]
        }
    },
      {
      "pageInfo": {
          "endCursor": "WyIyMDI0LTA4LTA0IDIwOjUzOjM3LjEyODEyNDAwMCBVVEMiLCIxLjAiLDk2OTUzNTA4Ml0",
          "hasNextPage": false
      }
    }

```

endCursor e hasNextPage são os dados que voce precisa para fazer a consulta paginada.

se hasNextPage for False, então voce nao precisar fazer uma próxima requisição, porém se for true voce utiliza o endCursor como ponto de partida para a requisição da próxima página.

```graphql
  cards(
  pipe_id: _PIPEID_,
  first:50,
  after: "WyIyMDI0LTA4LTA0IDIwOjUzOjM3LjEyODEyNDAwMCBVVEMiLCIxLjAiLDk2OTUzNTA4Ml0") {
    edges {
      node {
        id
        title
        }
    }
} pageInfo {
      endCursor
      hasNextPage
    }
  }
}
```
Dessa maneira voce consegue paginar o resultado da sua consulta.

Agora que temos um contexto sobre como realizar consultas com resultados grandes através de paginação e que sabemos que o tamanho do payload de resposta pode gerar lentidão, vamos olhar para como lidamos com isso no pacote Clientedigital\Pipefy.


#### Cache de dados.

Todas as queries escrevem um arquivo de cache no formato json no diretório .pipefy/.cache. O nome do arquivo é composto por informações da GQL executada.

[nome da gql executada] + hash md5 [parametros da consulta].json

por exemplo, uma consulta de cards com duas páginas terá dois arquivos como os abaixo, variando o hash.

- card-all_firstpage-49e26e5ba260673bb6d764ba41fd2b40.json
- card-all_nextpage-0a03c6d59c1d92a52788bf16462fbfb7.json

O tempo de vida de cada arquivo é definido em segundos pela configuração no arquivo .ini

```
PIPEFY_CACHE_TTL_DEFAULT = 1000;
PIPEFY_CACHE_TTL.card-all_firstpage = 600
PIPEFY_CACHE_TTL.card.all_nextpage = 600
```

Existem dois valores especiais de TTL:
0 : nunca utilizar cache.
-1: o cache nunca vence.

O valor padrão do parametro PIPEFY_CACHE_TTL_DEFAULT é 0 se não especificado e para utilizar o cache você precisa informar ao pacote que deve passar a utiliza-lo.


```php
// informa que deve utilizar o cache com TTL valida.
Clientedigital\Pipefy\Pipefy::useCache(true);

// informa que não deve utilizar cache para as consultas.
Clientedigital\Pipefy\Pipefy::useCache(false);

// o valor padrão de useCache é false.

```
Utilizar o cache vai acelerar em muito a resposta das suas consultas e garantir a performance do seu sistema e pode implicar na utilização de dados ultrapassados.


## 2. rate limit de 500 requisições a cada 30 segundos.

A informação desse rate limit é uma recomendação apresentada por uma pessoa na comunidade pipefy. A questão aqui é abusar da quantidade de queries e correr o risco de ser bloqueado devido ao _abuso_.

para evitar ser qualificado como alguem que esta abusando do número de requisicões será implementado um algoritmo de proteção que limite as requisições sem prejudicar performance de operações com requisições abaixo do limite que pode ser pensado como de maneira ingenua como 16req/sec.
