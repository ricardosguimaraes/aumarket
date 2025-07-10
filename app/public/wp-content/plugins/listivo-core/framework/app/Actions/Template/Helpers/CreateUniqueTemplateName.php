<?php

namespace Tangibledesign\Framework\Actions\Template;

/**
 * Trait CreateUniqueTemplateName
 * @package Tangibledesign\Framework\Actions\Template
 */
trait CreateUniqueTemplateName
{
    /**
     * @param  string  $baseName
     * @param  string  $type
     * @return string
     */
    protected function getName(string $baseName, string $type): string
    {
        $name = $baseName;
        $counter = 1;

        while (tdf_query_templates()->setType($type)->setTitle($name)->get()->isNotEmpty()) {
            ++$counter;

            $name = $baseName.' #'.$counter;
        }

        return $name;
    }

}