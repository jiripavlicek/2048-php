<?php

class Game2048Test extends PHPUnit_Framework_TestCase
{

    private $emptyBoard = array(
        array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
        array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
        array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
        array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
    );

    /**
     * @test
     */
    public function instanceOfTest()
    {
        $game2048 = New Game2048(4, 4);
        $this->assertInstanceOf('Game2048', $game2048);
    }

    /**
     * @test
     */
    public function setAndGetNumberOfRowsTest()
    {
        $game2048 = New Game2048(2, 4);
        $this->assertEquals(2, $game2048->getNumberOfRows());
    }

    /**
     * @test
     */
    public function setAndGetNumberOfColsTest()
    {
        $game2048 = New Game2048(2, 4);
        $this->assertEquals(4, $game2048->getNumberOfCols());
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Of Rows Must Be Greater Than Zero
     */
    public function setNumberOfRowsThrowsExceptionTest()
    {
        $game2048 = New Game2048(0, 4);
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Of Cols Must Be Greater Than Zero
     */
    public function setNumberOfColsThrowsExceptionTest()
    {
        $game2048 = New Game2048(4, 0);
    }

    /**
     * @test
     */
    public function emptyBoardTest()
    {
        $game2048 = New Game2048(4, 4);
        $this->assertEquals($this->emptyBoard, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function generateNewNumberChangedOneCellTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard = $game2048->getBoard();
        $game2048->generateNewNumber();
        $newBoard = $game2048->getBoard();
        $countDifferences = 0;
        for ($i = 0; $i < $game2048->getNumberOfRows(); $i++) {
            for ($j = 0; $j < $game2048->getNumberOfCols(); $j++) {
                if ($oldBoard[$i][$j] != $newBoard[$i][$j]) {
                    $countDifferences++;
                }
            }
        }
        $this->assertEquals(1, $countDifferences);
    }

    /**
     * @test
     */
    public function generateNewNumberOldCellValueWasEmptyTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard = $game2048->getBoard();
        $game2048->generateNewNumber();
        $newBoard = $game2048->getBoard();
        $countDifferences = 0;
        for ($i = 0; $i < $game2048->getNumberOfRows(); $i++) {
            for ($j = 0; $j < $game2048->getNumberOfCols(); $j++) {
                if ($oldBoard[$i][$j] != $newBoard[$i][$j]) {
                    $this->assertEquals(Game2048::EMPTYCELL, $oldBoard[$i][$j]);
                    $countDifferences++;
                }
            }
        }
    }

    /**
     * @test
     */
    public function generateNewNumberNewCellValue2Or4Test()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard = $game2048->getBoard();
        $game2048->generateNewNumber();
        $newBoard = $game2048->getBoard();
        $countDifferences = 0;
        for ($i = 0; $i < $game2048->getNumberOfRows(); $i++) {
            for ($j = 0; $j < $game2048->getNumberOfCols(); $j++) {
                if ($oldBoard[$i][$j] != $newBoard[$i][$j]) {
                    $this->assertTrue($newBoard[$i][$j] == 2 || $newBoard[$i][$j] == 4);
                    $countDifferences++;
                }
            }
        }
    }

    /**
     * @test
     */
    public function setGetBoardTest()
    {
        $game2048 = New Game2048(4, 4);
        $game2048->setBoard($this->emptyBoard);
        $this->assertEquals($this->emptyBoard, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardLeft1Test()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, 8, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 16)
        );
        $newBoard1 = array(
            array(2, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(16, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardLeft();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }


    /**
     * @test
     */
    public function shiftBoardLeft2Test()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 8),
            array(Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL, 8)
        );
        $oldBoard2 = array(
            array(2, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 8),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, 4, 8)
        );
        $newBoard1 = array(
            array(2, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 8, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 8, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $newBoard2 = array(
            array(2, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 8, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 8, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardLeft();
        $this->assertEquals($newBoard1, $game2048->getBoard());

        $game2048->setBoard($oldBoard2);
        $game2048->shiftBoardLeft();
        $this->assertEquals($newBoard2, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardLeft3Test()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 4, 8, Game2048::EMPTYCELL),
            array(8, 2, Game2048::EMPTYCELL, 4),
            array(4, Game2048::EMPTYCELL, 16, 8),
            array(Game2048::EMPTYCELL, 4, 2, 8)
        );
        $newBoard1 = array(
            array(2, 4, 8, Game2048::EMPTYCELL),
            array(8, 2, 4, Game2048::EMPTYCELL),
            array(4, 16, 8, Game2048::EMPTYCELL),
            array(4, 2, 8, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardLeft();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardLeftMergeDuplicatesTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(2, 2, 2, 2),
            array(2, 2, 2, 2)
        );
        $newBoard1 = array(
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, 4, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardLeftMergeDuplicates();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardLeftCompleteTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(2, 2, 2, 2),
            array(4, 4, 8, 8)
        );
        $newBoard1 = array(
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 4, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(8, 16, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardLeftComplete();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardRightCompleteTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 4, 4, Game2048::EMPTYCELL),
            array(2, 2, 2, 2)
        );
        $newBoard1 = array(
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 4),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 4),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, 8),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, 4, 4)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardRightComplete();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardUpCompleteTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(2, 2, 2, 2)
        );
        $newBoard1 = array(
            array(4, 4, 4, 2),
            array(Game2048::EMPTYCELL, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardUpComplete();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function shiftBoardDownCompleteTest()
    {
        $game2048 = New Game2048(4, 4);
        $oldBoard1 = array(
            array(2, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(2, 2, 2, 2),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL)
        );
        $newBoard1 = array(
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(4, 4, 4, 2)
        );
        $game2048->setBoard($oldBoard1);
        $game2048->shiftBoardDownComplete();
        $this->assertEquals($newBoard1, $game2048->getBoard());
    }

    /**
     * @test
     */
    public function playerWonTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(16, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(2, 2, 2, 2)
        );
        $board2 = array(
            array(2048, 2, Game2048::EMPTYCELL, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(Game2048::EMPTYCELL, 2, 2, Game2048::EMPTYCELL),
            array(2, 2, 2, 2)
        );
        $game2048->setBoard($board1);
        $this->assertFalse($game2048->playerWon());
        $game2048->setBoard($board2);
        $this->assertTrue($game2048->playerWon());
    }

    /**
     * @test
     */
    public function playerLoseTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(8, 16, 32, 64)
        );
        $board2 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(8, 16, 32, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($board1);
        $this->assertTrue($game2048->playerLose());
        $game2048->setBoard($board2);
        $this->assertFalse($game2048->playerLose());
    }

    /**
     * @test
     */
    public function turnLeftTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(Game2048::EMPTYCELL, 16, 32, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($board1);
        $game2048->turnLeft();
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Cant Turn Left
     */
    public function cantTurnLeftExceptionTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(8, 16, 32, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($board1);
        $game2048->turnLeft();
    }

    /**
     * @test
     */
    public function turnRightTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(Game2048::EMPTYCELL, 16, 32, Game2048::EMPTYCELL)
        );
        $game2048->setBoard($board1);
        $game2048->turnRight();
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Cant Turn Right
     */
    public function cantTurnRightExceptionTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(Game2048::EMPTYCELL, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(2, 8, 16, 32)
        );
        $game2048->turnRight($board1);
    }

    /**
     * @test
     */
    public function turnUpTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(Game2048::EMPTYCELL, 16, 32, Game2048::EMPTYCELL),
            array(2, 4, 8, 16)
        );
        $game2048->setBoard($board1);
        $game2048->turnUp();
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Cant Turn Up
     */
    public function cantTurnUpExceptionTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(2, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(8, 16, 32, Game2048::EMPTYCELL)
        );
        $game2048->turnUp($board1);
    }

    /**
     * @test
     */
    public function turnDownTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(Game2048::EMPTYCELL, 16, 32, Game2048::EMPTYCELL),
            array(2, 4, 8, 16)
        );
        $game2048->setBoard($board1);
        $game2048->turnDown();
    }

    /**
     * @test
     * @expectedException Exception
     * @expectedExceptionMessage Cant Turn Down
     */
    public function cantTurnDownExceptionTest()
    {
        $game2048 = New Game2048(4, 4);
        $board1 = array(
            array(Game2048::EMPTYCELL, 4, 8, 16),
            array(32, 64, 128, 256),
            array(512, 1024, 2, 4),
            array(2, 8, 16, 32)
        );
        $game2048->turnDown($board1);
    }

}
