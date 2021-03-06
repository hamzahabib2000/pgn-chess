<?php

namespace PGNChess\Tests\Unit\PGN;

use PGNChess\PGN\Symbol;
use PGNChess\PGN\Tag;
use PGNChess\PGN\Validate as PgnValidate;
use PGNChess\PGN\File\Movetext as PgnFileMovetext;
use PGNChess\Tests\AbstractUnitTestCase;

class ValidateTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function color_green_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::color('green');
    }

    /**
     * @test
     */
    public function color_white()
    {
        $this->assertEquals(Symbol::WHITE, PgnValidate::color(Symbol::WHITE));
    }

    /**
     * @test
     */
    public function color_black()
    {
        $this->assertEquals(Symbol::BLACK, PgnValidate::color(Symbol::BLACK));
    }

    /**
     * @test
     */
    public function square_integer_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::square(9);
    }

    /**
     * @test
     */
    public function square_float_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::square(9.75);
    }

    /**
     * @test
     */
    public function square_a9_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::square('a9');
    }

    /**
     * @test
     */
    public function square_foo_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::square('foo');
    }

    /**
     * @test
     */
    public function square_e4()
    {
        $this->assertEquals(PgnValidate::square('e4'), 'e4');
    }

    /**
     * @test
     */
    public function tag_Foo_throws_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        PgnValidate::tag('Foo');
    }

    /**
     * @test
     */
    public function tag_Event_Vladimir_Dvorkovich_Cup()
    {
        $tag = PgnValidate::tag('[Event "Vladimir Dvorkovich Cup"]');

        $this->assertEquals('Event', $tag->name);
        $this->assertEquals('Vladimir Dvorkovich Cup', $tag->value);
    }

    /**
     * @test
     */
    public function tag_Site_Saint_Louis_USA()
    {
        $tag = PgnValidate::tag('[Site "Saint Louis USA"]');

        $this->assertEquals('Site', $tag->name);
        $this->assertEquals('Saint Louis USA', $tag->value);
    }

    /**
     * @test
     */
    public function tag_Date_2018_05_10()
    {
        $tag = PgnValidate::tag('[Date "2018.05.10"]');

        $this->assertEquals('Date', $tag->name);
        $this->assertEquals('2018.05.10', $tag->value);
    }

    /**
     * @test
     */
    public function tag_Round_9_6()
    {
        $tag = PgnValidate::tag('[Round "9.6"]');

        $this->assertEquals('Round', $tag->name);
        $this->assertEquals('9.6', $tag->value);
    }

    /**
     * @test
     */
    public function tag_White_Kantor_Gergely()
    {
        $tag = PgnValidate::tag('[White "Kantor, Gergely"]');

        $this->assertEquals('White', $tag->name);
        $this->assertEquals('Kantor, Gergely', $tag->value);
    }

    /**
     * @test
     */
    public function tag_Black_Gelfand_Boris()
    {
        $tag = PgnValidate::tag('[Black "Gelfand, Boris"]');

        $this->assertEquals('Black', $tag->name);
        $this->assertEquals('Gelfand, Boris', $tag->value);
    }

    /**
     * @test
     */
    public function tag_Result_12_12()
    {
        $tag = PgnValidate::tag('[Result "1/2-1/2"]');

        $this->assertEquals('Result', $tag->name);
        $this->assertEquals('1/2-1/2', $tag->value);
    }

    /**
     * @test
     */
    public function tag_WhiteElo_2579()
    {
        $tag = PgnValidate::tag('[WhiteElo "2579"]');

        $this->assertEquals('WhiteElo', $tag->name);
        $this->assertEquals('2579', $tag->value);
    }

    /**
     * @test
     */
    public function tag_BlackElo_2474()
    {
        $tag = PgnValidate::tag('[BlackElo "2474"]');

        $this->assertEquals('BlackElo', $tag->name);
        $this->assertEquals('2474', $tag->value);
    }

    /**
     * @test
     */
    public function tag_ECO_D35()
    {
        $tag = PgnValidate::tag('[ECO "D35"]');

        $this->assertEquals('ECO', $tag->name);
        $this->assertEquals('D35', $tag->value);
    }

    /**
     * @test
     */
    public function tag_EventDate_2017_12_17()
    {
        $tag = PgnValidate::tag('[EventDate "2017.12.17"]');

        $this->assertEquals('EventDate', $tag->name);
        $this->assertEquals('2017.12.17', $tag->value);
    }

    /**
     * @test
     */
    public function movetexts()
    {
        // valid movetexts
        $this->assertTrue(PgnValidate::movetext(
            '1.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.Be2 Bf5 7.c3 Nd7'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.e4 c5 2.Nf3 Nc6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3 e5 6.Ndb5 d6 7.Bg5 a6 8.Na3'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.d4 Nf6 2.c4 e6 3.Nc3 Bb4 4.e3 O-O 5.a3 Bxc3+ 6.bxc3 b6 7.Bd3 Bb7 8.f3 c5'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.Nf3 Nf6 2.c4 c5 3.g3 b6 4.Bg2 Bb7 5.O-O e6 6.Nc3 a6 7.d4 cxd4 8.Qxd4 d6'
        ));

        // too many spaces
        $this->assertTrue(PgnValidate::movetext(
            '1.d4    Nf6 2.Nf3 e6 3.c4    Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.e4 Nf6 2.   e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.   Be2 Bf5 7.c3 Nd7'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.e4  c5   2.Nf3    Nc6 3.d4     cxd4 4.Nxd4 Nf6 5.Nc3 e5 6.Ndb5 d6 7.Bg5 a6 8.Na3'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.d4 Nf6 2.c4 e6 3.Nc3 Bb4 4.e3 O-O 5.a3 Bxc3+    6.bxc3 b6   7.Bd3   Bb7   8.f3   c5'
        ));
        $this->assertTrue(PgnValidate::movetext(
            '1.Nf3   Nf6 2.c4   c5  3.g3  b6  4.Bg2  Bb7  5.O-O e6 6.Nc3 a6 7.d4  cxd4  8.Qxd4  d6'
        ));

        // invalid numbers
        $this->assertFalse(PgnValidate::movetext(
            '2.d4 Nf6 2.Nf3 e6 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.e4 Nf6 2.e5 Nd5 4.d4 d6 4.Nf3 dxe5 5.Nxe5 c6 6.Be2 Bf5 7.c3 Nd7'
        ));
        $this->assertFalse(PgnValidate::movetext(
            'e4 c5 2.Nf3 Nc6 3.d4 cxd4 4.Nxd4 Nf6 5.Nc3 e5 6.Ndb5 d6 7.Bg5 a6 8.Na3'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.d4 Nf6 2.c4 e6 3.Nc3 Bb4 23.e3 O-O 5.a3 Bxc3+ 6.bxc3 b6 7.Bd3 Bb7 8.f3 c5'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.Nf3 Nf6 2.c4 c5 3.g3 b6 4.Bg2 Bb7 5.O-O e6 6.Nc3 a6 7.d4 cxd4 10.Qxd4 d6'
        ));

        // invalid moves
        $this->assertFalse(PgnValidate::movetext(
            '1.d4 Nf6 2.Nf3 FOO 3.c4 Bb4+ 4.Nbd2 O-O 5.a3 Be7 6.e4 d6 7.Bd3 c5'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.e4 Nf6 2.e5 Nd5 3.d4 d6 4.Nf3 dxe5 5.BAR c6 6.Be2 Bf5 7.c3 Nd7'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.e4 c5 2.Nf3 Nc6 3.FOO cxd4 4.Nxd4 Nf6 5.Nc3 e5 6.Ndb5 d6 7.Bg5 a6 8.Na3'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.d4 Nf6 2.c4 e6 3.Nc3 Bb4 4.e3 O-O 5.a3 Bxc3+ 6.bxc3 b6 7.Bd3 Bb7 8.f3 BAR'
        ));
        $this->assertFalse(PgnValidate::movetext(
            '1.Nf3 Nf6 2.c4 c5 3.g3 BAR 4.Bg2 FOO 5.O-O e6 6.FOOBAR 7.d4 cxd4 8.Qxd4 d6'
        ));
    }

    /**
     * @dataProvider movetextData
     * @test
     */
    public function movetexts_data($filename)
    {
        $string = preg_replace('~[[:cntrl:]]~', '', file_get_contents(self::DATA_FOLDER."/$filename"));

        $this->assertTrue(PgnValidate::movetext($string));
    }

    public function movetextData()
    {
        return [
            ['movetext-01.txt'],
            ['movetext-02.txt'],
            ['movetext-03.txt'],
            ['movetext-04.txt'],
        ];
    }
}
