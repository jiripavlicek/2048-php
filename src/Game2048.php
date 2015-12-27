<?php

class Game2048
{
    const EMPTYCELL = 0;

    private $numberOfRows;
    private $numberOfCols;
    private $board = array();

    /**
     * Game2048 constructor.
     * @param int $rows
     * @param int $cols
     */
    public function __construct($rows = 4, $cols = 4)
    {
        $this->setNumberOfRows($rows);
        $this->setNumberOfCols($cols);
        $board = array();
        for ($row = 0; $row < $this->getNumberOfRows(); $row++) {
            for ($col = 0; $col < $this->getNumberOfCols(); $col++) {
                $board[$row][$col] = Game2048::EMPTYCELL;
            }
        }
        $this->setBoard($board);
    }

    /**
     *
     */
    public function generateNewNumber()
    {
        $newNumber = 2 * rand(1, 2);
        $newNumberInserted = false;
        $board = $this->getBoard();
        while (!$newNumberInserted) {
            $row = rand(0, $this->getNumberOfRows() - 1);
            $col = rand(0, $this->getNumberOfCols() - 1);
            if ($board[$row][$col] == Game2048::EMPTYCELL) {
                $board[$row][$col] = $newNumber;
                $newNumberInserted = true;
                $this->setBoard($board);
            }
        }
    }

    /**
     *
     */
    public function shiftBoardLeft()
    {
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            for ($col = 0; $col < count($this->board[$row]); $col++) {
                $newBoard[$row][$col] = Game2048::EMPTYCELL;
                $col2 = $col;
                while ($col2 < count($this->board[$row]) && $this->board[$row][$col2] == Game2048::EMPTYCELL) {
                    $col2++;
                }
                if ($col2 < count($this->board[$row])) {
                    if ($col == $col2) {
                        $newBoard[$row][$col] = $this->board[$row][$col];
                    } else {
                        $newBoard[$row][$col] = $this->board[$row][$col2];
                        $this->board[$row][$col2] = Game2048::EMPTYCELL;
                    }
                }
            }
        }
        $this->setBoard($newBoard);
    }

    /**
     *
     */
    public function shiftBoardLeftMergeDuplicates()
    {
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            $val = $this->board[$row][0];
            $newBoard[$row][0] = $this->board[$row][0];
            for ($col = 1; $col < count($this->board[$row]); $col++) {
                $newBoard[$row][$col] = $this->board[$row][$col];
                if ($val == $this->board[$row][$col]) {
                    $newBoard[$row][$col - 1] = 2 * $val;
                    $newBoard[$row][$col] = Game2048::EMPTYCELL;
                    $this->board[$row][$col] = Game2048::EMPTYCELL;
                }
                $val = $this->board[$row][$col];
            }
        }
        $this->setBoard($newBoard);
    }

    /**
     *
     */
    public function shiftBoardLeftComplete()
    {
        $this->shiftBoardLeft();
        $this->shiftBoardLeftMergeDuplicates();
        $this->shiftBoardLeft();
    }

    /**
     *
     */
    public function shiftBoardRightComplete()
    {
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            $newBoard[$row] = array_reverse($this->board[$row]);
        }
        $this->setBoard($newBoard);
        $this->shiftBoardLeftComplete();
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            $newBoard[$row] = array_reverse($this->board[$row]);
        }
        $this->setBoard($newBoard);
    }

    /**
     *
     */
    public function shiftBoardUpComplete()
    {
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            for ($col = 0; $col < count($this->board[$row]); $col++) {
                $newBoard[$col][$row] = $this->board[$row][$col];
            }
        }
        $this->setBoard($newBoard);
        $this->shiftBoardLeftComplete();
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            for ($col = 0; $col < count($this->board[$row]); $col++) {
                $newBoard[$col][$row] = $this->board[$row][$col];
            }
        }
        $this->setBoard($newBoard);
    }

    /**
     *
     */
    public function shiftBoardDownComplete()
    {
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            for ($col = 0; $col < count($this->board[$row]); $col++) {
                $newBoard[$col][$row] = $this->board[$row][$col];
            }
        }
        for ($row = 0; $row < count($newBoard); $row++) {
            $newBoard[$row] = array_reverse($newBoard[$row]);
        }
        $this->setBoard($newBoard);
        $this->shiftBoardLeftComplete();
        $newBoard = array();
        for ($row = 0; $row < count($this->board); $row++) {
            $newBoard[$row] = array_reverse($this->board[$row]);
        }
        $newBoard2 = array();
        for ($row = 0; $row < count($newBoard); $row++) {
            for ($col = 0; $col < count($newBoard[$row]); $col++) {
                $newBoard2[$col][$row] = $newBoard[$row][$col];
            }
        }
        $this->setBoard($newBoard2);
    }

    /**
     * @throws CantTurnException
     */
    public function turnLeft()
    {
        $oldBoard = $this->getBoard();
        $this->shiftBoardLeftComplete();
        $newBoard = $this->getBoard();
        if ($oldBoard == $newBoard) {
            throw new Exception('Cant Turn Left');
        }
        $this->generateNewNumber();
    }

    /**
     * @throws CantTurnException
     */
    public function turnRight()
    {
        $oldBoard = $this->getBoard();
        $this->shiftBoardRightComplete();
        $newBoard = $this->getBoard();
        if ($oldBoard == $newBoard) {
            throw new Exception('Cant Turn Right');
        }
        $this->generateNewNumber();
    }

    /**
     * @throws CantTurnException
     */
    public function turnUp()
    {
        $oldBoard = $this->getBoard();
        $this->shiftBoardUpComplete();
        $newBoard = $this->getBoard();
        if ($oldBoard == $newBoard) {
            throw new Exception('Cant Turn Up');
        }
        $this->generateNewNumber();
    }

    /**
     * @throws CantTurnException
     */
    public function turnDown()
    {
        $oldBoard = $this->getBoard();
        $this->shiftBoardDownComplete();
        $newBoard = $this->getBoard();
        if ($oldBoard == $newBoard) {
            throw new Exception('Cant Turn Down');
        }
        $this->generateNewNumber();
    }

    /**
     * @return bool
     */
    public function playerWon()
    {
        $playerWon = false;
        for ($row = 0; $row < $this->getNumberOfRows(); $row++) {
            for ($col = 0; $col < $this->getNumberOfCols(); $col++) {
                $playerWon = $playerWon || ($this->board[$row][$col] >= 2048);
            }
        }
        return $playerWon;
    }

    /**
     * @return bool
     */
    public function playerLose()
    {
        $playerLose = true;
        for ($row = 0; $row < $this->getNumberOfRows(); $row++) {
            for ($col = 0; $col < $this->getNumberOfCols(); $col++) {
                $playerLose = $playerLose && ($this->board[$row][$col] != Game2048::EMPTYCELL);
            }
        }
        return $playerLose;
    }

    public function getNumberOfRows()
    {
        return $this->numberOfRows;
    }

    /**
     * @param $numberOfRows
     * @return mixed
     * @throws Exception
     */
    public function setNumberOfRows($numberOfRows)
    {
        if ($numberOfRows <= 0) {
            throw new Exception('Number Of Rows Must Be Greater Than Zero');
        }
        return $this->numberOfRows = $numberOfRows;
    }

    /**
     * @return int
     */
    public function getNumberOfCols()
    {
        return $this->numberOfCols;
    }

    /**
     * @param $numberOfCols
     * @return mixed
     * @throws Exception
     */
    public function setNumberOfCols($numberOfCols)
    {
        if ($numberOfCols <= 0) {
            throw new Exception('Number Of Cols Must Be Greater Than Zero');
        }
        return $this->numberOfCols = $numberOfCols;
    }

    /**
     * @return array
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param $board
     * @throws Exception
     */
    public function setBoard($board)
    {
        if (count($board) != $this->getNumberOfRows()) {
            throw new Exception('Bad Board Dimension - Rows');
        }
        if (count($board[0]) != $this->getNumberOfCols()) {
            throw new Exception('Bad Board Dimension - Cols');
        }
        $this->board = $board;
    }

}
