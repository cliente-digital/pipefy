# Cliente Digital - Pipefy Tools

As soon you require the package the first action is configure it to access you organization.
You gonna need an [Personal Access Token](https://app.pipefy.com/tokens/) and then execute the 
command bellow:


1. clientedigital:pipefy:config
2. clientedigital:pipefy:report
3. clientedigital:pipefy:schema



### 1. clientedigital:pipefy:config

Configure the package to get up and run.

example: 

```bash
composer clientedigital:pipefy:config APIKEY 'seu token aqui'
```
your APIKEY was set.


### 2. clientedigital:pipefy:report

Generate markdown output about your Pipefy account schema.

example:

```bash
composer clientedigital:pipefy:report schema > myschema.md

# create a pdf report about your schema
pandoc myschema.md -o myschema.pdf
```

### 3. clientedigital:pipefy:schema
Read the Pipefy schema your APIKEY has access to read and
retrieve informations about your schema.

The package save it at .pipefy/cache directory.


```bash
composer clientedigital:pipefy:schema build 
```
your organization schema was build.

