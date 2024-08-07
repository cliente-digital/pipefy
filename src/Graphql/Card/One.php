<?php
namespace Clientedigital\Pipefy\Graphql\Card;

use Clientedigital\Pipefy\Graphql\GraphQL;
use Clientedigital\Pipefy\Entity;
use Clientedigital\Pipefy\GraphQL\Label;


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
        $gqlResult = $this->request($gql);
        return new Entity\Card($gqlResult->data->card);
    }

    public function updateComment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment.update");
        $gql->set("COMMENTID", $comment->id);
        $gql->set("TEXT", $comment->__newData()['TEXT']);
        $gqlResult = $this->request($gql);
        return $gqlResult;
    }

    public function updateFields(Entity\Card $card){
        $data = $card->__newData(['FIELDS']);
        $gql = $this->getGQL("card-fields.update");
        $gql->set("CARDID", $card->id);
        $gql->set("FIELDS", $data['FIELDS']->script());
        $gqlResult = $this->request($gql);
        return $gqlResult->data->updateFieldsValues->success;
    }


    public function removeComment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment.remove");
        $gql->set("COMMENTID", $comment->id);
        $gqlResult = $this->request($gql);
        return $gqlResult;
    }

    public function comment(Entity\Comment $comment){
        $gql = $this->getGQL("card-comment");
        $gql->set("CARDID", $this->id);
        $gql->set("TEXT", $comment->__newData()['TEXT']);
        $gqlResult = $this->request($gql);
        return $gqlResult;
    }



    public function comments(){
        $comments = [];
        $gql = $this->getGQL("card-comments");
        $gql->set("CARDID", $this->id);
        $gqlResult = $this->request($gql);
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
        $gqlResult = $this->request($gql);

        return $gqlResult;
 
    }

    public function removeLabel(Entity\Label $label)
    {
        $actualLabels = (new Label\All())->fromCard($this->id); 

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
        $gqlResult = $this->request($gql);

        return $gqlResult;
    }
} 
