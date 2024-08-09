# Search Beyond the Basics. (part 3)
### How can you improve the search and find what you want.

---
   Este artigo faz parte de uma série sobre recursos da plataforma Pipefy e como integrar o Pipefy em sua aplicação utilizando o pacote [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy)

tags: #pipefy #integração #php #clientedigital #workflow #bpm #search

---

Esta é a terceira parte do artigo sobre busca nos cards do seu pipe. Na [primeira parte](./2-Search-beyond-the-basics-part-1.md) tratamos sobre a busca do app pipefy, sua relação com a query cards e como esse conexão impacta a experiencia de busca no app reforçando o uso de uma taxinomia de tags efetiva. Na [segunda parte](./3-Search-beyond-the-basics-part-2.md) tratamos do uso do Handler Cards e do Filter/Card para filtrar cards que permite filtrar a coleção pelos campos criados pelos usuários.

Nesse artigo vou falar um pouco mais sobre os Filtros e operadores de filtro.


No artigo anterior você conheceu o recurso de filtro. Um filtro é utilizado em dois momentos.

1. Antes da execução da Query(pré).
2. Depois da execução da Query(pós).



#### 1. Antes da Execução da Query

Quando a query graphql executada suportar parametros de pesquisa ela verifica se foi informado um filtro e utiliza os valores na graphql.

Os parametros de busca suportados pela graphql são expostos pelo Filtro através de métodos especificos para cada parametro. Dessa maneira você consegue saber automaticamente se é um parametro de filtro pré ou pós.

No [Filter\Card](https://github.com/cliente-digital/pipefy/blob/main/src/Filter/Cards.php) temos os seguintes métodos:

- public function filterStrategy(string $strategy)
- assigneeTo(int $assigneeId)
- IgnoreCard(int $cardId)
- labeledWith(int $labelId)
- titled(string $title)
-  includeDone(bool $include)

Que são traduzidos em um input [CardSearch](https://api-docs.pipefy.com/reference/inputObjects/CardSearch/) utilizado na query [cards](https://api-docs.pipefy.com/reference/queries/cards/#cards).

#### 2. Depois da Execução da Query

Depois que a query é executada na API da PIPEFY, as entidades podem ser filtradas de acordo com seus dados. Esse tipo de filtro é um filtro sequencial que passa por cada um dos items e verifica se ele atende as regras definidas pelo método **by**.


**by**(_$campo, $operador, $valor_)


para utilizar o filtro pós você precisa ter conhecimento sobre o seu esquema de dados.

O id de um campo utilizado como primeiro parametro, por exemplo, é algo relacioando ao label do campo, mas que sofre algumas mudanças como:
- pontuações são extraidas.
- são mantidos somente os caracteres ascii.
- o que não e ascii é trocado por _.
- ao editar o label o id do campo não é atualizado.

Como exemplo podemos olhar um campo com o label "Número de telefone". Ele terá o id "n_mero_de_telefone".

Para ter certeza do id de um campo utilize o relatório de schema explicado no **primeiro artigo** dessa série [1 I need know my schema](./1-I-need-know-my-schema.md).

##### Operadores.

Os operadores são estratégias de comparação entre o conteudo do ```$campo``` e o ```$valor``` pesquisado.

Nesse momento temos somente dois:

- Equal **'='**
  compara valores(**'=='** e não tipo **'==='**).

- Contain **'<-'**.
  verifica se o conteudo do campo contem $valor. Em strings o **$valor** é tratado como substring e em array é verifica se o **$valor** esta in_array.

Outros operadores estão em desenvolvimento e em breve serão entregues.

  - Not Equal **'=!'**
  - Not Contain **'<-!'**
  - greater than **'>'**
  - greater than or equal **'>='**
  - less than **'<'**
  - less than or equal **'<='**

Assim como a definição de constantes para representar esses operadores.

- EQ    '='
- NEQ   '=!'
- IN    '<-'
- NIN   '<-!'
- GT    '>'
- GTE   '>='
- LT    '<'
- LTE   '<='

No momento os **operadores são naive** mas irão evoluir para operar de acordo com o Schema\Data\Type do dado.
