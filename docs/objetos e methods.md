bin
    cd.pipefy
        --config
        --report

namespace Clientedigital\Pipefy 

Command
    Config
        exec($args)
        help()
        
    Report
        exec($args)
        help()
        
Pipefy
    request(string gqlscrit): StdClass // refactoring... deixa de existir em prol de graphql method.
    getConfig
    Orgs(): Pipefy\Orgs
    -- graphql // entrega um Graphl que recebe um GQLInterface e exec.
    -- bulkStart
    -- bulkFlush

Cache
    -- get // refactoring from GraphQL
    -- info // refactoring from GraphQL
    -- clear // refactoring from GraphQL
    -- set // refactoring from GraphQL

Orgs
    All
    One
    -- pipes
    -- tables

Pipes
    contruct(orgid)
    All
    One(pipeId)
    -- pipe

Cards
    construct(pipeid)
    get: entraga colecao de card do pipeid (ja usa filtro)
    filter: adiciona um filtro que vai ser utilizado no get.
    -- card

Org
    construct(id)
    get: entreva um Entity\Org
    update(Entity\Org): atualiza uma org
    --pipes()

Pipe
    construct(id)
    get: entrega um Entity\Pipe
    update(Entity\Pipe): atualiza um Pipe
    labels() : Entrega Entities\Label
    -- cards

Card
    contruct(id)
    get: entrega um CardEntity
    Labels: labelEntities do CardId
    comments"ComentEntities do CardId
    comment: comenta no cardId
    modifyLabels: Modifica um Label "do CardId"
    -- fields

Label
    update(Entity\label)
    create (Entity\Label)


schema
    build
    report

Table
    construct(id)
    Labels()


namespace Clientedigital\Pipefy\Entity
    AbstractModel
    Card
    Comment
        text
    
    EntityInterface
    Label
        name
        color
        tableId
        pipeId
    Org
        OnlyeAdminCanCreatePipes
        OnlyAdminCanInviteUsers
        name

    Pipe
        name
        anyoneCanCreateCard
        expirationTimeByUnit
        expirationUnit
        icon
        onlyAssigneesCanEditCards
        onlyAdminCanRemoveCards
        isPublic
        activePublicForm
        titleFieldId
        color
        noum

namespace Clientedigital\Pipefy\Filter
    Operator
        contain
            evaluate
        Equal
            evaluate
        OperatorInterface
            evaluate
            
    Cards
        by
        script
        check
        filterStrategy
        assigneeTo
        IgnoreCard
        labeledWith
        titled
        includeDone
        
    FilterInterface
        by
        script
        check
    
namespace Clientedigital\Pipefy\Graphql
Card
    All
        get
    One
        get
        updateComment
        removeComment
        comment
        comments
        addLabel
        removeLabel

Label
    All
        fromPipe
        fromTable
        fromCard
    One
        get
        update
        create
Org
    All
        get
    One
        get
        updateOrganizationInput
GQL
    construct(scriptname)
    script
    set
    rawScript
    --check : lanca exception

GraphQL
    getCache // refactoring to Cache : get
    infoCache // refactoring to Cache : info
    clearCache // refactoring to Cache: clear
    setCache // refactoring to Cache : set
    -- exec // refactoring de Pipefy request (GQL) :: retonar Result // como validar a execucao ja que CLientId nao funciona(null)

-- Bulk // um tipo de GQL // pode ser passado para GraphQL ->Exec(GQLInterface) Somente mutations ocorrem em Bulk.
    -- add(GQL): int (id do item no bulk) // ao add faz um check e se faltar required lanca exception.
    -- remove
    -- list
    -- paginate() // retonar um generator dos scripts em paginas que obedecem CLIENTE_DIGITAL_BULK_PAGE_SIZE
    -- capacity // informa o numero de scripts e a capacidate(CLIENTE_DIGITAL_BULK_PAGE_SIZE = 30) exemplo 20/30.
    -- script()


