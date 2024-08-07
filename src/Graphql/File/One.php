<?php
namespace Clientedigital\Pipefy\Graphql\File;

use Clientedigital\Pipefy\Graphql\GraphQL;


class One 
{
    use GraphQL;

    /**
    * return createPresignedUrl object with 3 properties:
    * downloadUrl: this url is the one used to direct download.
    * clientMutationId: null
    * url : HTTP PUT the file to this URL and attachment field content
    **/
    public function createUploadLink(int $orgId,  string $fileAlias){
        $gql = $this->getGQL("file-createpresignedurl");
        $gql->set("ORGID", $orgId);
        $gql->set("FILENAME", $fileAlias);
        $gqlResult = $this->request($gql);
        return $gqlResult->data->createPresignedUrl;
}
} 
