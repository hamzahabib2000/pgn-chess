<?php
namespace PGNChess\Piece;

use PGNChess\Piece\Piece;
use PGNChess\PGN;

/**
 * Class that represents a bishop, a rook or a queen. Think a bit about it and
 * you'll find that those three pieces are quite similar. They can slide on the board,
 * so to speak, which means that their legal moves can be computed in the exact same way.
 *
 * @author Jordi Bassagañas <info@programarivm.com>
 * @link https://programarivm.com
 * @license MIT
 */
abstract class Slider extends AbstractPiece
{
    /**
     * Constructor.
     *
     * @param $color
     * @param $square
     * @param $identity
     */
    public function __construct($color, $square, $identity)
    {
        parent::__construct($color, $square, $identity);
    }

    /**
     * Gets the legal moves that can be performed on the board by slider pieces.
     *
     * @return array The legal moves that the slider piece (BRQ) can perform.
     */
    public function getLegalMoves()
    {
        $moves = [];
        foreach ($this->getPosition()->scope as $direction)
        {
            foreach ($direction as $square)
            {
                if (
                    !in_array($square, $this->squares->used->{$this->getColor()}) &&
                    !in_array($square, $this->squares->used->{$this->getOppositeColor()})
                )
                {
                    $moves[] = $square;
                }
                elseif (in_array($square, $this->squares->used->{$this->getOppositeColor()}))
                {
                    $moves[] = $square;
                    break 1;
                }
                elseif (in_array($square, $this->squares->used->{$this->getColor()}))
                {
                    break 1;
                }
            }
        }
        return $moves;
    }
}