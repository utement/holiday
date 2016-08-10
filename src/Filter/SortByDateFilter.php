<?php

namespace umulmrum\Holiday\Filter;

use umulmrum\Holiday\Model\HolidayList;

class SortByDateFilter implements HolidayFilterInterface
{
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
        $flatList = $holidayList->getFlatArray();
        usort($flatList, function ($o1, $o2) {
            return $o1->getTimestamp() > $o2->getTimestamp();
        });
        $newList = new HolidayList();
        foreach ($flatList as $holiday) {
            $newList->add($holiday);
        }

        return $newList;
    }
}