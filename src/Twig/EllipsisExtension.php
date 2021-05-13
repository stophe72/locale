<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EllipsisExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('ellipsis', [$this, 'ellipsisFilter'])];
    }

    public function ellipsisFilter(
        string $text,
        int $maxLength = 50,
        string $ellipsis = '...'
    ) {
        if (strlen($text) <= $maxLength) {
            return $text;
        }
        $ellipsisLenght = strlen($ellipsis);

        return $ellipsisLenght > $maxLength
            ? $ellipsis
            : substr($text, 0, $maxLength - $ellipsisLenght) . $ellipsis;
    }
}
