<?php
include("HandHandler.php");
class PokerJudger
{
    /**
     * The smallest hand.
     */
    protected static $SMALLEST = [0, ['5', '4', '3', '2', '1']];
    /**
     * All players hands poker.
     *
     * @var array
     */
    protected $hands;
    /**
     * All poker levels.
     *
     * @var array
     */
    protected $levels;
    /**
     * The winners description.
     *
     * @var array
     */
    protected $winHands;
    /**
     * The biggest poker level.
     *
     * @var array
     */
    protected $biggestLevel;
    /**
     * @var \Poker\HandHandler
     */
    protected $rankHandler;

    /**
     * @array for grades
     */
    protected static $GRADES = [
        'High card',
        'One pair',
        'Two pair',
        'Three of a kind',
        'Straight',
        'Flush is nice',
        'Full house!!!',
        'Four of a kind',
        'traight flush',
    ];

    /**
     * @var array
     */
    protected $players;

    /**
     * @param array $hands
     * @param array $players
     */
    public function __construct($hands, $players)
    {
        $this->hands = $hands;
        $this->players = $players;
        $this->rankHandler = HandHandler::getIns();
    }
    /**
     * Get the result to output.
     *
     * @param  string $grade
     * @param  array  $winners
     *
     * @return string
     */
    public function getResult($grade, $winners)
    {
        $results = count($winners) == 1 ? 'Winner: ' : 'Games drawn, Winners: ';
        $results .= implode(', ', $winners) . "\n:" . $grade;
        return $results;
    }

    /**
     * Get all max result.
     *
     * @return array
     */
    public function getAllMax()
    {
        $results = $this->getWinHands();
        $grade = self::$GRADES[$results[0][0]];
        $winner[] = $grade;
        foreach ($results[1] as $hand) {
            foreach ($this->players as $cards) {
                if ($hand == $cards[1]) {
                    $winner[1][] = $cards[0];
                }
            }
        }
        return $winner;
    }
    /**
     * Get thw biggest hands.
     *
     * @return array
     */
    public function getWinHands()
    {
        $this->getRanks()
            ->getAllCardLevels()
            ->handlerLevels();
        return [
            $this->biggestLevel,
            $this->winHands[$this->levelToString($this->biggestLevel)]
        ];
    }
    /**
     * Handler all levels.
     */
    protected function handlerLevels()
    {
        $this->biggestLevel = self::$SMALLEST;
        foreach ($this->levels as $hand => $level) {
            if (! $this->rankHandler->bigger($this->biggestLevel, $level)) {
                $this->winHands[$this->levelToString($level)][] = $hand;
                $this->biggestLevel = $level;
            }
        }
    }
    /**
     * Get all card levels.
     *
     * @return self
     */
    protected function getAllCardLevels()
    {
        foreach ($this->hands as $hand) {
            $this->levels[implode(' ', $hand)] = $this->rankHandler->assignCategory($hand);
        }
        return $this;
    }
    /**
     * Get all hands ranks.
     *
     * @return self
     */
    protected function getRanks()
    {
        foreach ($this->hands as $hand) {
            $this->ranks[] = $this->rankHandler->getRanksByHand($hand);
        }
        return $this;
    }
    /**
     * Transfer level to string.
     *
     * @param  array $level
     *
     * @return string
     */
    public function levelToString($level)
    {
        return $level[0] + '-' + implode('', $level[1]);
    }
}