<?php
// starting controller 
include("pokerDeck.php");
include("PokerJudger.php");
//Get player number
$playnum = intval($_POST['number']);
//Check player numbers
if ($playnum > 4 || $playnum < 2) {
    echo "PLAYER NUMBER MUST BE BETWEEN 2 AND 4!";
    print"<p>\n</p>";
}   else {
//Create deck
$texasDeck = Deck::getInstance();
//Set players
$texasDeck->setPlayers($playnum);
//Shuffles and deals new game
$texasDeck->firstDeal();
//Get all hands 
$hands = Deck::$allhands;
//Save the information to the session
session_start();
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

// Create Judger
$judger = new PokerJudger($hands, $rows);
// Get winners
list($grade, $winners) = $judger->getAllMax();
echo "The results were as follows: ";
print "<p>\n</p>";
echo $judger->getResult($grade, $winners);

// Generate form that used to get requirement 
echo "<form action=\"ContinuePoker.php\" method=\"post\">
	<fieldset><legend>Do you want to continue: </legend>
	<select name=\"Continue\">
		<option value=\"1\">Yes</option>
		<option value=\"0\">No</option>
	</select>
	</fieldset>	
	<div align=\"center\"><input type=\"submit\" name=\"Yes\" value=\"Submit\"/></div>
    </form>";
}
?>