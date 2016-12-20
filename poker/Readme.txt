Poker Card Game
Requirements :
A sample game play scenario
 0. How many players will be participating this game? (2-4)
 1. Game starts with (number of players entered) players
 2. Create a new deck of cards
 3. Shuffle the deck
 4. Deal one card to each player in turns until every player has 5 cards in hand
 5. Display what card each player holds
 6. Declares the winner
 7. Continue? (Y/N)
 8. In case the game continues, use the undealt cards to play the next game. When all cards are dealt, reshuffle the whole deck.

 This program is a php web program. When users open the index.php file, it will start the game. Then users can enter the number of players. Then the page will jump to the result page which shows the pocket of each player and the winner.
 The result page also include a select choice for user to choose continue game or not. 

 The index.php : beginning page
 TexasPoker.php : First controller recives the request from index.php and then to start the game.
 pokerDeck.php : Poker class offers operations on cards including shuffle, deal, and count.
 pokerJudger.php: PokerJudger class offers operations to compare cards and declare winner.
 helper.php : file offers helper functions
 Handhandler.php : Handhandler class offers operations to get hands rank and level.
 Transfer.php : Transfer class offers funcitons to transfer cards' strings.