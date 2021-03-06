<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\HolidayList;

class IncludeTypeFilter implements HolidayFilterInterface
{
    const PARAM_HOLIDAY_TYPE = 'include_type_filter.holiday_type';

    /**
     * @var HolidayFilterInterface
     */
    private $chainedFilter;

    /**
     * @param HolidayFilterInterface $chainedFilter
     */
    public function __construct(HolidayFilterInterface $chainedFilter = null)
    {
        $this->chainedFilter = $chainedFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function filter(HolidayList $holidayList, array $options = [])
    {
        if (null !== $this->chainedFilter) {
            $holidayList = $this->chainedFilter->filter($holidayList, $options);
        }
        $holidayType = $options[self::PARAM_HOLIDAY_TYPE];
        $tempList = $holidayList->getList();
        $newList = new HolidayList();

        foreach ($tempList as $holiday) {
            if (($holiday->getType() & $holidayType) !== 0) {
                $newList->add($holiday);
            }
        }

        return $newList;
    }
}
