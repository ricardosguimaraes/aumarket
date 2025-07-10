<?php

namespace Tangibledesign\Framework\Models\Helpers;

trait CanBeBumped
{
    use HasId;
    use HasMeta;
    use HasPost;

    /**
     * @param string $date
     * @return void
     */
    public function setNextBumpDate(string $date): void
    {
        $this->setMeta('next_bump_date', $date);
    }

    /**
     * @return string
     */
    public function getNextBumpDate(): string
    {
        return (string)$this->getMeta('next_bump_date');
    }

    /**
     * @return bool
     */
    public function hasNextBumpDate(): bool
    {
        return !empty($this->getNextBumpDate());
    }

    /**
     * @return string
     */
    public function getNextBumpDateFormatted(): string
    {
        return tdf_date_diff($this->getNextBumpDate());
    }

    /**
     * @param array $dates
     * @return void
     */
    public function setBumpDates(array $dates): void
    {
        if (empty($dates)) {
            $this->setMeta('bump_dates', '0');
            return;
        }

        $this->setMeta('bump_dates', $dates);
    }

    /**
     * @return array
     */
    public function getBumpDates(): array
    {
        $dates = $this->getMeta('bump_dates');
        if (!is_array($dates)) {
            return [];
        }

        return $dates;
    }

    /**
     * @return string
     */
    public function shiftBumpDates(): string
    {
        $dates = $this->getBumpDates();
        if (empty($dates)) {
            return '';
        }

        $date = array_shift($dates);

        $this->setBumpDates($dates);

        return $date;
    }

    /**
     * @return bool
     */
    public function shouldBeBumped(): bool
    {
        $nextBumpUpdate = $this->getNextBumpDate();
        if (empty($nextBumpUpdate)) {
            return false;
        }

        return date("Y-m-d H:i:s") > $nextBumpUpdate;
    }

    public function bump(): void
    {
        $time = current_time('mysql');

        if (!$this->wasBumped()) {
            $this->setRealPublishDate($this->post->post_date);
        }

        wp_update_post(
            [
                'ID' => $this->getId(),
                'post_date' => $time,
                'post_date_gmt' => get_gmt_from_date($time)
            ]
        );
    }

    /**
     * @return bool
     */
    public function wasBumped(): bool
    {
        return !empty($this->getRealPublishDate());
    }

    /**
     * @param string $date
     * @return void
     */
    public function setRealPublishDate(string $date): void
    {
        $this->setMeta('publish_date', $date);
    }

    /**
     * @return string
     */
    public function getRealPublishDate(): string
    {
        return (string)$this->getMeta('publish_date');
    }

    /**
     * @return string
     */
    public function getPublishDate(): string
    {
        if (empty($this->getRealPublishDate())) {
            return (string)get_the_date(get_option('date_format'), $this->getPost());
        }

        return get_date_from_gmt($this->getRealPublishDate(), get_option('date_format'));
    }

}