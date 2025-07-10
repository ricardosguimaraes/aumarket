<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

trait TextControls
{
    use TextColorControl;
    use TextAlignControl;
    use TypographyControl;

    protected function addTextControls(string $selector, string $key = ''): void
    {
        if (empty($key)) {
            $this->addTextColorControl($selector);

            $this->addTextAlignControl($selector);

            $this->addTypographyControl($selector);
        } else {
            $this->addTextColorControl($selector, $key);

            $this->addTextAlignControl($selector, $key);

            $this->addTypographyControl($selector, $key);
        }
    }
}