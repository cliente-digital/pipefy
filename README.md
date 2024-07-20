# pipefy
A Pipefy API wrapper that uplift productivity of newcomers to graphQL tech.

This package is a tool to improve your knowledge about your Pipefy Organization, 
being able to share this knowledge with your coworkers and accomplish maintanance 
tasks. It also intent to help you handle graphQl technology that can overwhelming
at first glance.

## FAQ

this is the primary set of questions you'll find the answer using this package.

1. what's my organization schema?
2. How can I know the id of this [pipe,phase,card, field]?
3. How can I search for [card, field, phase]?
4. Can I search cards by this field value?
5. How can I update this field value?
6. How can I move this card between phases?

To answer this questions this package provides some resources:

### CLI tools

-  **_composer pipefy:gql_** 

     that contain graphql code used by the package that can help 
your use cases. 

- **_composer pipefy:report_** 

     use to know things about you schema and data.

exemplo:
```bash
    ; extraia um relatório do seu schema de dados.
    composer pipefy:report schema > relatorio.md
    ; converta para pdf.
    pandoc relatorio.md -o relatorio.pdf
```

### How to start
As soon you require the package the first action is configure it to access you organization.
You gonna need an [Personal Access Token](https://app.pipefy.com/tokens/) and then execute the 
command bellow:

```
composer pipefy:config APIKEY 'seu token aqui'
```
your APIKEY was set.

Next step is build your organization schema so you can operate over this using this package.

```
composer pipefy:schema build 
```
your organization schema was build.


Pipefy Limites

Pipefy GraphiQL API limits are: 

 
### Pipefy Limits:
- number of subsequent queries allowed per time unit: our rate limit is 500 requests for each 30 seconds;
- number of webhooks allowed: the number of webhooks is based in the process size and it depends on the organization subscription as well. We’d recommend to not have more than 30 webhooks for each pipe, but it is customizable. 
- size of inputs/outputs: the inputs and outputs are based mainly in your process size, using the pre-built queries and mutations. But in a response payload, for example, each request only returns 50 records, requiring then using pagination. 
- size of attachment files: limit of 512MB for each file.

[info reference](https://community.pipefy.com/customs-apps-integrations-75/what-are-the-graphql-api-limits-958)
