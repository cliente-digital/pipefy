<?php
require __DIR__ . "/../vendor/autoload.php";

use Clientedigital\Pipefy;

Pipefy\Pipefy::useCache(true);
function getAllCards(){
    $pipefy = new Pipefy\Pipefy();
    $org = $pipefy->Orgs()->All()[0];
    $orgData = $org->get();
    var_dump($org->pipes());
    $pipes = new Pipefy\Pipes($org->get()->id);
    var_dump($pipes);
    $cards = $pipes->All()[0]->cards()->get();
    foreach($cards as $card){
        var_dump($card);
    }
}
//Orgs = 301345588
getAllCards();

function comment(){
    $comment = new Clientedigital\Pipefy\Entity\Comment();
    $comment->text("Primeiro Comentario feito utilizando o clientedigita\Pipefy"); 
    $card = new Clientedigital\Pipefy\Card(518966639);
    $result = $card->comment($comment);
    return $result;
}
//var_dump(comment());
function removeComment(){
    $card = new Clientedigital\Pipefy\Card(518966639);
    $comments = $card->comments();
    var_dump($comments); 
    return $card->comment($comments[1], 0);
}
//var_dump(removeComment());

function updateComment(){
    $card = new Clientedigital\Pipefy\Card(518966639);
    $comments = $card->comments();
    var_dump($comments); 
    $comment = $comments[0];
    $comment->text("Atualizando Novamente");
    return $card->comment($comment, 2);
}
//var_dump(updateComment());
