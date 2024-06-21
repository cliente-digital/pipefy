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

### How to start
As soon you require the package the first action is configure it to access you organization.
You gonna need an [Personal Access Token(https://app.pipefy.com/tokens/) and then execute the 
command bellow:

```
composer pipefy:config APIKEY 'seu token aqui'
```
your APIKEY was set.
