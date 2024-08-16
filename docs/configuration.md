# Cliente Digital  - Pipefy COnfiguration

This page explain how to configure Clientedigital/pipefy in your project.

## Steps

1. Copy file **cd.pipfy-sample.ini** to your configuration directory and rename as **cd.pipefy.ini**.  

2. set the env variable ```CLIENTEDIGITAL_PIPEFY_CONFIG_FILE``` with the path for this file.

```bash
export CLIENTEDIGITAL_PIPEFY_CONFIG_FILE='/myproject/config/cd.pipefy.ini'
```

## Config File Content

It is a php ini file with a section ```[CLIENTEDIGITAL]``` and you can add this section to you project config file (and setup ```CLIENTEDIGITAL_PIPEFY_CONFIG_FILE``` to its path [step 2]).

You can update the configuration using the cli command ```./vendor/bin/cd.pipefy --config [CONFIG NAME] [CONFIG VALUE]``` or edit the file directly.


```bash
[CLIENTEDIGITAL]

# this is the pipefy graphql api URI.
PIPEFY_API_URI=https://api.pipefy.com/graphql

# the package use a directory to save cache and and other resources.
# This is the root dir of this directory
PIPEFY_DIR=/myproject/.pipefy

# this is the directory used as repository for the graphql
# files(.gql files) used to
PIPEFY_GRAPHQL_DIR='/myproject/.pipefy/graphql'

# the cache dir is used to save graphql queries result and use it
# as cache to speed up the package. You can define TTL's for each
# gql in your system.
PIPEFY_CACHE_DIR='/myproject/.pipefy/cache'

# your service api key or Personal Access Token.
PIPEFY_APIKEY=


#if has default set is follow default ttl
# if not, default TTL is 0(no cache)
# if has default ttl and a gql ttl
# it follow the gql ttl.
#ttl time unit is second.

# you can set a default TTL for any query.
PIPEFY_CACHE_TTL_DEFAULT = 1000

#or define a TTL for a specific query.
PIPEFY_CACHE_TTL.label.all = 600
PIPEFY_CACHE_TTL.card.all = 86000
```

The syntax of TTL configuration is:  
```bash
PIPEFY_CACHE_TTL . [gql directory name] . [gql file name]
```

please, check [graphql directory](https://github.com/cliente-digital/pipefy/tree/main/.pipefy/graphql) to know the all queries and mutations and also [read more about gql files](https://github.com/cliente-digital/pipefy/blob/main/doc/gql-files.md) to know how to implement your own gqls.
