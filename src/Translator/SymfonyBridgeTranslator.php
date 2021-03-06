<?php

/*
 * This file is part of the umulmrum/holiday package.
 *
 * (c) 2016 Stefan Kruppa
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace umulmrum\Holiday\Translator;

use Symfony\Component\Translation\TranslatorInterface as SymfonyTranslatorInterface;
use umulmrum\Holiday\Model\Holiday;

class SymfonyBridgeTranslator implements TranslatorInterface
{
    /**
     * @var SymfonyTranslatorInterface
     */
    private $translator;

    /**
     * @param SymfonyTranslatorInterface $translator
     */
    public function __construct(SymfonyTranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function translateName(Holiday $holiday)
    {
        return $this->translator->trans($holiday->getName(), [], 'umulmrum_holiday');
    }

    /**
     * {@inheritdoc}
     */
    public function translate($string)
    {
        return $this->translator->trans($string, [], 'umulmrum_holiday');
    }
}
