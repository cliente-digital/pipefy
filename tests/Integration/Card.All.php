<?php
require __DIR__ . "/../vendor/autoload.php";
/*
 echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
$cards = new Clientedigital\Pipefy\Cards(302358339);
$myCards = $cards->get();
foreach($myCards as $card){
    var_dump($card);
}
$card = new Clientedigital\Pipefy\Card(518966639);
var_dump($card->labels());


*/

/*
$filter= new Clientedigital\Pipefy\Filter\Cards();
$filter->titled('Key Imóveis');
$cards->filter($filter);
$filter->by('qual_o_meio_de_contato', '=', 'E-mail');
$filter->by('nome_da_empresa', '<-', 'Key');
//var_dump($cards);
$cards = $cards->get();
foreach($cards as $card){
$a = $card;
    var_dump($a);
 echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
}

exit();
$card = new Clientedigital\Pipefy\Card(518966642);
var_dump($card->get()); 
var_dump($card->get()); 
var_dump($card->get()); 
$card = $card->get();
var_dump($card->id);
var_dump($card->found());
var_dump($card->title);
var_dump($card->se_n_o_por_qu);
 echo round(memory_get_usage() / 1024 / 1024, 2) . ' MB' . PHP_EOL;
*/

function addLabel(){
$pipeLabels = (new Clientedigital\Pipefy\Pipe(304547300))->labels();
$newLabel = $pipeLabels[1];
var_dump($pipeLabels);
$card = new Clientedigital\Pipefy\Card(968122385);
$card->modifylabels($newLabel, 1);
}
//addLabel();

function getComments(){
    $card = new Clientedigital\Pipefy\Card(518966639);
    $comments = $card->comments();
    return $comments;
}
//var_dump(getComments());

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
function oneCard(){
$cards = new Clientedigital\Pipefy\Pipe(304547300);
$myCard = $cards->cards()->get()->current();
var_dump($myCard);

//    $card = new Clientedigital\Pipefy\Card(518966639);
//    $entity= $card->get();
//    var_dump($entity); 
}
//oneCard();

function update(){
    $Card = new Clientedigital\Pipefy\Card();
}
