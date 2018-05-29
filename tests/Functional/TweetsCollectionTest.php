<?php

namespace Tests\Functional;

use Packages\Twitter\TweetsCollection;

/**
 * Class TweetsCollectionTest
 *
 * @package Tests\Functional
 */
class TweetsCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Checks Number of tweets assigned to the hour
     *
     * @param array $data Provides tweets data for tests
     *
     * @dataProvider tweetsData
     */
    public function testGetNumberOfTweetsPerDay(array $data)
    {
        $exceptedResult = [
            "00:00" => 1,
            "01:00" => 0,
            "02:00" => 0,
            "03:00" => 0,
            "04:00" => 0,
            "05:00" => 0,
            "06:00" => 0,
            "07:00" => 0,
            "08:00" => 0,
            "09:00" => 0,
            "10:00" => 0,
            "11:00" => 1,
            "12:00" => 0,
            "13:00" => 0,
            "14:00" => 0,
            "15:00" => 0,
            "16:00" => 0,
            "17:00" => 0,
            "18:00" => 0,
            "19:00" => 0,
            "20:00" => 0,
            "21:00" => 0,
            "22:00" => 2,
            "23:00" => 0,
        ];

        $tweetsCollection = new TweetsCollection($data);

        $this->assertCount(24, $tweetsCollection->getNumberOfTweetsPerDay());
        $this->assertEquals($exceptedResult, $tweetsCollection->getNumberOfTweetsPerDay());
    }

    /**
     * Checks Most Active hour
     *
     * @param array $data Provides tweets data for tests
     *
     * @dataProvider tweetsData
     */
    public function testGetMostActiveHour(array $data)
    {
        $tweetsCollection = new TweetsCollection($data);

        $this->assertEquals('22:00', $tweetsCollection->getMostActiveHour());
    }

    /**
     * Checks total number of tweets
     *
     * @param array $data Provides tweets data for tests
     *
     * @dataProvider tweetsData
     */
    public function testGetTotalNumberOfTweets(array $data)
    {
        $tweetsCollection = new TweetsCollection($data);

        $this->assertCount(5, $data);
        $this->assertEquals(4, $tweetsCollection->getTotalNumberOfTweets());
    }

    /**
     * Data Provider
     *
     * @return array
     */
    public function tweetsData(): array
    {
        $dateTime = new \DateTime('today');
        return [
            [
                [
                    [
                        'created_at' => date(
                            'D M d H:i:s O Y',
                            $dateTime->setTime(11, 30)->getTimestamp()
                        ),
                        'id'         => 87652325225,
                    ],
                    [
                        'created_at' => date(
                            'D M d H:i:s O Y',
                            $dateTime->setTime(0, 40)->getTimestamp()
                        ),
                        'id'         => 12355546456,
                    ],
                    [
                        'created_at' => date(
                            'D M d H:i:s O Y',
                            $dateTime->setTime(22, 18)->getTimestamp()
                        ),
                        'id'         => 57262243544,
                    ],
                    [
                        'created_at' => date(
                            'D M d H:i:s O Y',
                            $dateTime->setTime(22, 30)->getTimestamp()
                        ),
                        'id'         => 57262243544,
                    ],
                    [
                        'created_at' => date(
                            'D M d H:i:s O Y',
                            $dateTime->modify('+1 day')->getTimestamp()
                        ),
                        'id'         => 34534543555,
                    ]
                ]
            ]
        ];
    }
}
