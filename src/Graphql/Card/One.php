<?php
namespace Clientedigital\Pipefy\Graphql\Card;

use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;

class One 
{
    use GraphQL;

    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function get(){
        $gql = $this->getGQL("card-one");
        $gql->set("CARDID", $this->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
        return new Entity\Card($gqlResult->data->card);
    }

    public function updateComment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment.update");
        $gql->set("COMMENTID", $comment->id);
        $gql->set("TEXT", $comment->__newData()['TEXT']);
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
        return $gqlResult;
    }

    public function removeComment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment.remove");
        $gql->set("COMMENTID", $comment->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
        return $gqlResult;
    }

    public function comment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment");
        $gql->set("CARDID", $this->id);
        $gql->set("TEXT", $comment->__newData()['TEXT']);
        $gqlscript = $gql->script();
        $gqlResult = $this->request($gqlscript);
        return $gqlResult;
    }



    public function comments(){
        $comments = [];
        $gql = $this->getGQL("card-comments");
        $gql->set("CARDID", $this->id);
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);
        foreach( $gqlResult->data->card->comments as $comment){
            $comment->parentId = $this->id;
            $comments[] = new Entity\Comment($comment);
        }

        return $comments;
    }


    public function addLabel(Entity\Label $label, array $actualLabels)
    {
        $newLabels = [];
        $newLabels[] = $label->id;
        foreach($actualLabels as $alabel){
            $newLabels[] = $alabel->id;
        }
        $newLabels = array_unique($newLabels);
        if(count($actualLabels) == count($newLabels))
            return false;

        $gql = $this->getGQL("card-update");
        $gql->set("CARDID", $this->id);
        $gql->set("LABELIDS", "[".implode(", ", $newLabels)."]");
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);

        return $gqlResult;
 
    }

    public function removeLabel(Entity\Label $label, array $actualLabels)
    {
        $newLabels = [];
        $exist = false;
        foreach($actualLabels as $alabel){
            if($alabel->id == $label->id){
                $exist = true;
                continue;
            }

            $newLabels[] = $alabel->id;
        }
        if(!$exist)
            return false;

        $gql = $this->getGQL("card-update");
        $gql->set("CARDID", $this->id);
        $gql->set("LABELIDS", "[".implode(", ", $newLabels)."]");
        $gqlscript = $gql->script();
        $gqlResult = $this->client->request($gqlscript);

        return $gqlResult;
    }

} 
