<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Formatter;

use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;

class TimestampFormatter implements HolidayFormatterInterface
{
    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = [])
    {
        return $holiday->getTimestamp();
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $holiday->getTimestamp();
        }

        return $result;
    }
}
