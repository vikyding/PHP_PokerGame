<?php
include("pokerDeck.php");
include("PokerJudger.php");

// check continue or not
$ContinueOrNot = intval($_POST['Continue']);
session_start();
if ($ContinueOrNot == "0"){
	echo "Game Over, Welcome to come again";
} else {
// get playernum
$playnum = intval($_SESSION['playnum']);
$cards = $_SESSION['cards'];
$cardcounter = $_SESSION['cardcount'];

//create deck
$texasDeck = Deck::getInstance();

// set players
$texasDeck->setPlayers($playnum);

// set cards
$texasDeck->setDeck($cards);

// set counter
$texasDeck->setCardcounter($cardcounter);

// continue game 
$texasDeck->dealTexas();
$hands = Deck::$allhands;

$_SESSION['playnum'] = $playnum;
$_SESSION['cards'] = $texasDeck->getallCards();
$_SESSION['cardcount'] = $texasDeck->getCardcounter();


//Display what card each player holds
echo "Display hands for all players: ";
for ($i = 0; $i < $playnum; $i++){
$hand = $texasDeck->getHands($i);// get hand for each player
$rows[] = [$i + 1, implode(' ', $hand)];// combine cards and player's name 
print"<p>\n</p>";
echo "Player ".($i + 1).": ";
echo $texasDeck->showHand($i);
print"<p>\n</p>";
}


// Judge hands 
$judger = new PokerJudger($hands, $rows);
list($grade, $winners) = $judger->getAllMax();
echo "The results were as follows: ";
print "<p>\n</p>";
echo $judger->getResult($grade, $winners);
print "<p>\n</p>";


echo "<form action=\"ContinuePoker.php\" method=\"post\">
	<fieldset><legend>Do you want to continue: </legend>
	<select name=\"Continue\">
		<option value=\"1\">Yes</option>
		<option value=\"0\">No</option>
	</select></p>
	</fieldset>	
	<div align=\"center\"><input type=\"submit\" name=\"Yes\" value=\"Submit\" /></div>
</form>";
}
?>