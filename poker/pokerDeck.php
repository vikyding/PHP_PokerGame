<?php
//CREATE deck class with card methods
class Deck {

	/**
     * array with all pockets for all players
     */
	public static $allhands; 
	/**
     * int value for record the cards 
     */
    private $cardcounter = 0;  
    /**
     * the number of players
     */
    private $playnum; 
    /**
     * array with all players'information
     */
    private $players; 
	/**
     * array with all cards
     */
	private $deck = array();
	/**
     * pokerDeck singleton
     *
     * @var self
     */
	private static $instance = null;

	private function __construct() {
    }
    /**
     * Get the handhandle instance.
     *
     * @return self
     */
	public static function getInstance(){
		    if (self::$instance == null) {
               self::$instance = new Deck();
            }
            return self::$instance;
	}
	/*
*********************************************|
THESE FUNCTIONS USED TO SET AND GET VARIABLES|                                         
*********************************************|
*/
    /**
     * set player number.
     *
     * @param  int $playnum
     *
     */
	public function setPlayers($playnum){
		   $this->playnum = $playnum;
	}
    /**
     * get player number.
     *
     * @return int $playnum
     *
     */
	public function getPlayers(){
		   return $this->playnum;
	}
    /**
     * set card counter.
     *
     * @param  int $counter
     *
     */
	public function setCardcounter($counter){
		   $this->cardcounter = $counter;
	}
    /**
     * get card counter.
     *
     * @return int $cardcounter
     *
     */
	public function getCardcounter(){
		   return $this->cardcounter;
	}
	/**
     * set deck.
     *
     * @param string $cards
     *
     */
	public function setDeck($cards){
		   $this->deck = explode("#", $cards);
	}
    /**
     * get hand for one player.
     *
     * @param int $player
     * @return array $hand
     *
     */
    public function getHands($player){
           return self::$allhands[$player];
    }
    /**
     * get deck in ont string.
     *
     * @return string $deck
     *
     */
	public function getallCards()
	{
		return implode("#", $this->deck);
	}

	//declare the functions - this one shuffles the deck and populates it with cards
	//mt_rand is a better random algorithim than shuffle()
	public function mixThem()
		{//start MixThem bracket
			//these are the cards that will be shuffled and put into the deck
			$startingDeck=array("2H","3H","4H","5H","6H","7H","8H","9H","TH","JH","QH","KH","AH","2C","3C","4C","5C","6C","7C","8C","9C","10C","JC","QC","KC","AC","2D","3D","4D","5D","6D","7D","8D","9D","TD","JD","QD","KD","AD","2S","3S","4S","5S","6S","7S","8S","9S","TS","JS","QS","KS","AS");
			//this outer loop says that while the deck has < 52 items in it do the following...
			while ((count($this->deck))<52) 
			{//start outer while loop
					//a piece of data here is a random value/card from $startingDeck
					$data = $startingDeck{mt_rand(0,51)};
					//to ensure that you don't put the same value in twice we have the inner loop
					while (!in_array($data, $this->deck)){//start inner while loop
					array_push($this->deck, $data);
					}//end inner while loop
			}//end out while loop
		}//end mixThem
/*
***************************************************************************|
declare functions to deal for texas holdem|	
***************************************************************************|
*/
// First Deal at the beginning of the Game
	public function firstDeal (){
			//shuffle deck
			self::$instance->mixThem($this);
            //master array holding all hands
			self::$allhands = array();
		
			//Init all hands
			for ($player = 0; $player < $this->playnum; $player++){
			    	 $hand= array();
                     array_push(self::$allhands, $hand);
			}
            
			//loop that sets values of cards and pushes them into master array
			for ($round = 0; $round < 5; $round++){
			    	 for ($player = 0; $player < $this->playnum; $player++){
			    	 	  $c = $this->deck[$this->cardcounter];// get cards from the deck
			    	 	  array_push(self::$allhands[$player], $c);// push the cards to each player in turn
			    	 	  $this->cardcounter++;
			    	 }
			}		
	}
// Repeat Deal 
	public function dealTexas ()
		{
			// Check whethe there are enough cards for current game
            if ($this->playnum * 5 > 51 - $this->cardcounter){
            	echo "There are no more unused cards, shuffle again";
            	print"<p>\n</p>";
            	$this->deck = array();
			    self::$instance->mixThem($this);
			    $this->cardcounter = 0;
            }
			
			self::$allhands = array();
		
			//Init all hands
			for ($player = 0; $player < $this->playnum; $player++){
			    	 $hand= array();
                     array_push(self::$allhands, $hand);
			}  
			//loop that sets values of cards and pushes them into master array

			for ($round = 0; $round < 5; $round++){
			    	 for ($player = 0; $player < $this->playnum; $player++){
			    	 	  $c = $this->deck[$this->cardcounter];// get cards from the deck
			    	 	  array_push(self::$allhands[$player], $c);// push the cards to each player in turn
			    	 	  $this->cardcounter++;
			    	 }
			}	
			
		}//end dealTexas function	
 
/*
***************************************************************************|
DECLARE FUNCTIONS TO SHOW THE POCKETS                                      |	
***************************************************************************|
*/
    public function showHand($playernum){
	       $transfer = Transfer::getIns();
           return implode(" ",$transfer->toFlowers(self::$allhands[$playernum]));
    }
}//end class
?>