<?php

namespace Tangibledesign\Framework\Traits\Payments;

use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasRegularPackageAttributes
{
    use HasMeta;

    public function setBumpsNumber(int $number): void
    {
        $this->setMeta('bumps_number', $number);
    }

    public function getBumpsNumber(): int
    {
        return (int)$this->getMeta('bumps_number');
    }

    public function setBumpsInterval($days): void
    {
        $this->setMeta('bumps_interval', (int)$days);
    }

    public function getBumpsInterval(): int
    {
        return (int)$this->getMeta('bumps_interval');
    }

    public function setNumber($number): void
    {
        $this->setMeta('number', (int)$number);
    }

    public function getNumber(): int
    {
        return (int)$this->getMeta('number');
    }

    public function setExpire($expire): void
    {
        $this->setMeta('expire', (int)$expire);
    }

    public function getExpire(): int
    {
        return (int)$this->getMeta('expire');
    }

    public function setFeaturedExpire($featuredExpire): void
    {
        $this->setMeta('featured_expire', (int)$featuredExpire);
    }

    public function getFeaturedExpire(): int
    {
        return (int)$this->getMeta('featured_expire');
    }

}