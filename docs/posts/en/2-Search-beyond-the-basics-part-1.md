# Beyond Basic Search (Part 1)
### How to Find What You Need with an Enhanced Search.

---
   This article is part of a series about the features of the [Pipefy](https://www.pipefy.com/) platform and the integration with applications using the [Clientedigital/Pipefy](https://github.com/cliente-digital/pipefy) package

---

tags: #pipefy #integração #php #clientedigital #workflow #bpm #search #graphql

As a [Citzen Developer](https://www.pipefy.com/blog/what-is-a-citizen-developer/) who takes pride in their work, you’ve probably noticed that Pipefy’s search feature looks through initial form fields or phase forms, but do you know which fields are searched when you type something in the "Search cards" bar?

A good first step to understanding Pipefy’s search functionality is to look at its API. Pipefy's API is based on [graphql](https://graphql.org/) and its [documentação](https://api-docs.pipefy.com/reference/inputObjects/CardSearch/#) covers all its components. The weak point, however, lies in the details. Some features should be more thoroughly detailed to cover their scope, and one of these features is card search.

Let’s look at an example, the  [query cards](https://api-docs.pipefy.com/reference/queries/cards/#cards).

```graphql
query{
  cards(pipe_id: _PIPEID_ , first:50 _SEARCH_ ) {
    edges {
      node {
        id
        title
        }
      }
    }
  }
```
This query searches for cards in a specific pipe (_PIPEID_), using search parameters (_SEARCH_) and returns the id and title fields of all cards (which are nodes) that match the search parameters.

You can execute your search in the [app de graphql](https://app.pipefy.com/graphiql)  to see the result. To find your pipe’s ID [acesse o pipe](https://app.pipefy.com/) and grab the ID that appears in the URL https://app.pipefy.com/pipes/[id].

For example, if the [id] number is 999999999:

```graphql
query{
  cards(pipe_id: 999999999 , first:50  ) {
    edges {
      node {
        id
        title
        }
      }
    }
  }
```
Don’t worry about the _SEARCH_ parameter. It is optional, and we will discuss it shortly.

The result will be:

```graphiql
{
  "data": {
    "cards": {
      "edges": [
        {
          "node": {
            "id": "968095899",
            "title": "Card 1"
          }
        },
        {
          "node": {
            "id": "968096399",
            "title": "Card 2"
          }
        },
        {
          "node": {
            "id": "968096799",
            "title": "Card 3"
          }
        }
      ]
    }
  }
}
```

Now, let’s talk about the _SEARCH_ parameter. It is of type [CardSearch](https://api-docs.pipefy.com/reference/inputObjects/CardSearch/)and has the following fields:

- assignee_ids: [ID]
- ignore_ids: [ID]
- labels_ids: [ID]
- title: String
- search_strategy: [CardSearchStrategy](https://api-docs.pipefy.com/reference/enums/CardSearchStrategy)
- include_done: Boolean
inbox_emails_read: Boolean

You don’t need to use all the fields of CardSearch. So let’s search by title:

```graphql
query{
  cards(pipe_id: 999999999 , first:50,  search: {title:"Card 3"} ) {
    edges {
      node {
        id
        title
        }
      }
    }
  }
```
Which returns:
```graphiql
{
  "data": {
    "cards": {
      "edges": [
        {
          "node": {
            "id": "968096799",
            "title": "Card 3"
          }
        }
      ]
    }
  }
}
```


It’s time to connect the dots—or rather, connect the GraphQL cards query we just explored and the search in the app.

![preview da busca no app](./app_cards_search.png "busca no app Pipefy")

When you type a value in the "Search cards" field, you are searching by the card’s title(search: ```{title:"Card 3"}```).

When you search by email status, you use ```inbox_emails_read```. For labels, it’s ```labels_ids```. For people, it's ```assignee_ids```.

The Pipefy app uses the cards query, and since this query doesn’t search by card fields, you also can’t search by card fields in the app.

I don’t see this as a problem. By limiting search resources (whether incidentally or not), the app forces users to maintain a stronger tag structure. I believe a good tagging taxonomy is the best way to find what you’re looking for.

A good article on the topic is [What we learned from creating a tagging taxonomy](https://dovetail.com/blog/what-we-learned-creating-tagging-taxonomy/) by Dovetail.
