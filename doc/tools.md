# Cliente Digital - Pipefy Tools

As soon you require the package the first action is configure it to access you organization.
You gonna need an [Personal Access Token](https://app.pipefy.com/tokens/) and then execute the
command bellow:

use the bin:
```bash
cd.pipefy
```

Options:
1. --config
2. --report



### 1. --config

Configure the package to get up and run.


example:

```bash
./vendor/bin/cd.pipefy --config APIKEY 'ypur apikey here'
```

your apikey is set.


```bash
./vendor/bin/cd.pipefy --config build-schema
```
Organization Schema was build.

**IMPORTANT: You need to set the APIKEY before use any command.**


### 2. --report

Generate markdown output about your Pipefy account schema.

example:

```bash
./vendor/bin/cd.pipefy --report schema > myschema.md

# create a pdf report about your schema
pandoc myschema.md -o myschema.pdf
```
