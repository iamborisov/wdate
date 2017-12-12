<?php

namespace App\Tests;

use App\WDate;
use PHPUnit\Framework\TestCase;

/**
 * Class WDateTest
 * @package App\Tests
 */
class WDateTest extends TestCase
{

    /**
     * WDate constructor test cases
     *
     * @return array
     */
    public function dataConstruct() {
        return [
            'H:i:s d.m.Y' => [
                '01:00:05 21.07.2017',
                [2017, 7, 21, 1, 0, 5]
            ],
            'H:i d.m.Y' => [
                '01:00 21.07.2017',
                [2017, 7, 21, 1, 0, null]
            ],
            'H: d.m.Y' => [
                '01: 21.07.2017',
                [2017, 7, 21, 1, null, null]
            ],
            'd.m.Y' => [
                '21.07.2017',
                [2017, 7, 21, null, null, null]
            ],
            'm.Y' => [
                '07.2017',
                [2017, 7, null, null, null, null]
            ],
            'Y' => [
                '2017',
                [2017, null, null, null, null, null]
            ],
            'H:' => [
                '01:',
                [null, null, null, 1, null, null]
            ],
            'H:i' => [
                '01:00',
                [null, null, null, 1, 0, null]
            ],
            'H:i:s' => [
                '01:00:05',
                [null, null, null, 1, 0, 5]
            ],
        ];
    }

    /**
     * WDate constructor test
     *
     * @dataProvider dataConstruct
     */
    public function testConstruct($date, $expected) {
        $wdate = new WDate($date);

        $this->assertEquals(
            $expected,
            $wdate->toArray(),
            "Unexpected date value"
        );
    }

    /**
     * WDate comparison test cases
     *
     * @return array
     */
    public function dataComparison() {
        return [
            // EQUAL

            'H:i:s d.m.Y == H:i:s d.m.Y' => [
                '01:00:05 21.07.2017',
                '01:00:05 21.07.2017',
                0
            ],
            'H:i:s d.m.Y == d.m.Y' => [
                '01:00:05 21.07.2017',
                '21.07.2017',
                0
            ],
            'd.m.Y == d.m.Y' => [
                '21.07.2017',
                '21.07.2017',
                0
            ],
            'H:i:s == H:i:s' => [
                '01:00:05',
                '01:00:05',
                0
            ],
            'H: == H:' => [
                '01:',
                '01:',
                0
            ],

            // NOT EQUAL

            'H:i:s d.m.Y < H:i:s d.m.Y' => [
                '01:00:05 21.07.2017',
                '01:00:06 21.07.2017',
                -1
            ],
            'd.m.Y < d.m.Y' => [
                '21.07.2017',
                '21.08.2017',
                -1
            ],
            'H:i:s < H:i:s' => [
                '01:00:05',
                '01:00:06',
                -1
            ],
            'H:i:s < H:' => [
                '01:00:05',
                '02:',
                -1
            ],
            'H: < H:' => [
                '01:',
                '02:',
                -1
            ],

            // CAN NOT BE COMPARED

            'H:i:s == d.m.Y' => [
                '01:00:05',
                '21.08.2017',
                false
            ],
            'H: == Y' => [
                '01:',
                '2017',
                false
            ],
        ];
    }

    /**
     * WDate comparison test
     *
     * @dataProvider dataComparison
     */
    public function testComparison($date1, $date2, $result) {
        $wdate1 = new WDate($date1);
        $wdate2 = new WDate($date2);

        $this->assertSame(
            $wdate1->compare($wdate2),
            $result,
            "Unexpected comparison result"
        );
    }

}
