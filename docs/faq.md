# Cliente Digital - Pipefy FAQ

1. **what's my organization schema?**

    You can Have a markdown report about your organization schema using the pipefy composer scripts.

```bash
composer pipefy:report schema
```
This scripts output a markdown report of your schema and you can save it to a file 
```bash
composer pipefy:report schema > myschema.md
```
After that you can use this file to create a pdf version using you preferend tool. I use pandoc here as example
```bash
pandoc myschema.md -o myschema.pdf
```


2. **How can I know the id of this [pipe,phase,card, field]?**

Check the report for the Orgs, Pipes, Phases and fields id and if you need the cards id you
can use the Pipefy\Cards to retrieve it.
```php
require __DIR__ . "/../autoload.php";

$cards = (new Clientedigital\Pipefy\Cards($pipeid));
foreach($cards as $card){
    echo $card->id.PHP_EOL;
}
```

3. **How can I search for [card, field, phase]?**


4. **Can I search cards by this field value?**
5. **How can I update this field value?**
6. **How can I move this card between phases?**
7. **what are the limits for using the Pipefy GraphiQL API?**
- number of subsequent queries allowed per time unit: our rate limit is 500 requests for each 30 seconds;
- number of webhooks allowed: the number of webhooks is based in the process size and it depends on the organization subscription as well. We’d recommend to not have more than 30 webhooks for each pipe, but it is customizable. 
- size of inputs/outputs: the inputs and outputs are based mainly in your process size, using the pre-built queries and mutations. But in a response payload, for example, each request only returns 50 records, requiring then using pagination. 
- size of attachment files: limit of 512MB for each file.

_[reference link](https://community.pipefy.com/customs-apps-integrations-75/what-are-the-graphql-api-limits-958)_
