# I need know my Organization Schema.
### How to know your schema and control changes can help you not lose efficiency.

---
   Este artigo faz parte de uma série sobre recursos da plataforma Pipefy e como integrar o Pipefy em sua aplicação utilizando o pacote [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy)

tags:   #pipefy #integração #php #clientedigital #workflow #bpm

---

As ferramentas de low code estão ai para facilitar o trabalho de profissionais que querem automatizar rotinas e facilitar sua vida e da sua empresa e se você é uma dessas pessoas que conseguem utilizar esse tipo de ferramenta, você é um  [Citzen Developer](https://www.pipefy.com/blog/what-is-a-citizen-developer/).

A persona principal de qualquer produto low code é o citzen developer. É ele que faz uso das features básicas e avançadas e é para ele que a experiencia é desenhada. Com todos aqueles recursos ele consegue colocar uma empresa no mundo digital e gerir os negócios sem papel e caneta e sem perder informação, mas não se engane, o sucesso do low code pode complicar as coisas.

Tudo começa com um pipe(um workflow) e poucos campos e repente são 10 pipes, muitas fases, formulários públicos e privados e conexão entre os pipes.

É nesse ponto(melhor se antes dele) que você deve começar a gerenciar não só os processos, mas a sua organização como um todo. Aqui surgem os desafios de manter a ordem na casa.

Esse momento é quando a empresa se vê deixando de ser **light user** para se tornar um **heavy user**.

E perguntas como estas se tornam comuns:

- Quantos status nós temos para a venda?
- O que significa essa tag/label?
- esse card esta no campo correto?
- onde esta o documento que deveria estar anexo?
- ...

Como não deixar sua organização se perder na crescente quantidade de pipes, fases, campos e registros e acabar perdendo eficiencia que foi ganha no início?

1. Mapeie o que já existe.
  Para mapear o schema de dados da sua organização você pode utilizar a ferramenta de cli **cd.pipefy**.

  ```bash
# esse comando irá imprimir o relatório em markdown
# direto para stdout.
./vendor/bin/cd.pipefy --config build-schema

# você pode direcionar o stdout para um arquivo de extensão .md

./vendor/bin/cd.pipefy --config build-schema > org-schema.md

# agora você tem um arquivo em markdown com as informações do schema.
# e se você for compartilhar esse arquivo com stakeholder é melhor
# converter para pdf.(no linux eu utilizo o pandoc)

pandoc org-schema.md -o org-schema.pdf

  ```
Quando você **executa o build-schema** um arquivo .json é gerado e gravado no seu cache (diretório _.pipefy/.cache/schema.build-***.json_). Recomendo que você guarde e versione  esse arquivo para revisitar quando necessário.

Você também pode editar o seu relatório e adicionar explicações na estrutura do schema.

2. Controle a mudança.

Você pode definir quais usuários podem realizar mudanças nos recursos da sua organização utilizando a configuração de permissão, porém isso resolve somente uma parte do problema que é **limitar quem pode fazer mudança**.

O próximo passo é criar um anbiente de discussão sobre as mudanças em que os participantes tomam conhecimento e validam as novas ideias antes da execução.

E depois de definir as permissões e criar a cultura de compartilhamento e discussão de mudança você ainda pode utilizar os arquivos json de schema e os relatórios para comparar e descobrir mudanças efetuadas.
