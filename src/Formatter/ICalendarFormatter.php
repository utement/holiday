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

use DateTimeZone;
use umulmrum\Holiday\Helper\DateHelper;
use umulmrum\Holiday\Model\Holiday;
use umulmrum\Holiday\Model\HolidayList;
use umulmrum\Holiday\Translator\NullTranslator;
use umulmrum\Holiday\Translator\TranslatorInterface;

class ICalendarFormatter implements HolidayFormatterInterface
{
    const LINE_ENDING = "\r\n";
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var DateHelper
     */
    private $dateHelper;

    /**
     * @param TranslatorInterface|null $translator
     * @param DateHelper               $dateHelper
     */
    public function __construct(TranslatorInterface $translator = null, DateHelper $dateHelper = null)
    {
        if (null === $translator) {
            $this->translator = new NullTranslator();
        } else {
            $this->translator = $translator;
        }
        if (null === $dateHelper) {
            $this->dateHelper = new DateHelper();
        } else {
            $this->dateHelper = $dateHelper;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function format(Holiday $holiday, array $options = [])
    {
        return $this->getEvent($holiday);
    }

    /**
     * {@inheritdoc}
     */
    public function formatList(HolidayList $holidayList, array $options = [])
    {
        $result = [];

        foreach ($holidayList->getList() as $holiday) {
            $result[] = $this->getEvent($holiday);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return implode(self::LINE_ENDING, [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:umulmrum/holiday',
            'CALSCALE:GREGORIAN',
        ]);
    }

    /**
     * @param Holiday $holiday
     *
     * @return array
     */
    private function getEvent(Holiday $holiday)
    {
        $dtstamp = $this->dateHelper->getCurrentDate(new DateTimeZone('UTC'));

        return implode(self::LINE_ENDING, [
            'BEGIN:VEVENT',
            sprintf('UID:%s-%s', $holiday->getName(), $holiday->getFormattedDate('Y-m-d')),
            sprintf('DTSTAMP:%s', $dtstamp->format('Ymd\THis\ZO')),
            sprintf('CREATED:%s', $dtstamp->format('Ymd\THis\ZO')),
            'SUMMARY:'.$this->translator->translateName($holiday),
            'DTSTART;VALUE=DATE:'.$holiday->getFormattedDate('Ymd'),
            'END:VEVENT',
        ]);
    }

    /**
     * @return string
     */
    public function getFooter()
    {
        return 'END:VCALENDAR';
    }
}
