<?php

namespace Tangibledesign\Framework\Models;

use DateTime;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Interfaces\HasReviewsInterface;
use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use Tangibledesign\Framework\Models\Helpers\CanBeBumped;
use Tangibledesign\Framework\Models\Helpers\HasFavoriteCounter;
use Tangibledesign\Framework\Models\Helpers\HasRevealPhoneCounter;
use Tangibledesign\Framework\Models\Helpers\HasViews;
use Tangibledesign\Framework\Models\Helpers\HasViewsInterface;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackageInterface;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Template\Templatable;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Traits\HasReviewsTrait;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class Model extends PostModel implements Fieldable, Templatable, HasViewsInterface, HasReviewsInterface
{
    use HasViews;
    use HasFavoriteCounter;
    use HasRevealPhoneCounter;
    use CanBeBumped;
    use HasReviewsTrait;

    public const VIEWS = 'views';
    public const PHONE_REVEALS = 'phone_reveals';
    public const FAVORITE_COUNT = 'favorite_count';
    public const FEATURED = 'featured';
    public const EXPIRE = 'expire';
    public const FEATURED_EXPIRE = 'featured_expire';
    public const PENDING_PACKAGE = 'pending_package';
    public const ASSIGNED_PACKAGE = 'assigned_package';
    public const APPROVED = 'approved';
    public const EXPIRE_NOTIFICATIONS = 'expire_notifications';
    public const UPDATE_PUBLISH_DATE = 'update_publish_date';

    public function getName(): string
    {
        return apply_filters(tdf_prefix() . '/model/name', parent::getName(), $this);
    }

    public function isFeatured(): bool
    {
        return !empty($this->getMeta(self::FEATURED));
    }

    public function setFeatured($isFeatured): void
    {
        $this->setMeta(self::FEATURED, (int)$isFeatured);
    }

    public function getEditUrl(string $type = 'normal'): string
    {
        $url = site_url() . '/' . tdf_slug('panel') . '/' . tdf_slug(PanelWidget::ACTION_EDIT) . '/?id=' . $this->getId();
        if ($type === 'moderation') {
            $url .= '&type=moderation';
        }

        return $url;
    }

    public function getExpireDate(): string
    {
        return (string)$this->getMeta(self::EXPIRE);
    }

    private function sanitizeDate(string $date): string
    {
        if ($date === 'unlimited') {
            return $date;
        }

        $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        if (!$dateObj) {
            return '';
        }

        $formattedDate = $dateObj->format('Y-m-d H:i:s');

        if (!preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $formattedDate, $matches)) {
            return '';
        }

        if (!checkdate($matches[2], $matches[3], $matches[1])) {
            return '';
        }

        return $formattedDate;
    }

    public function setExpireDate(string $date): void
    {
        $this->setMeta(self::EXPIRE, $this->sanitizeDate($date));
    }

    public function setExpireDateFromDays(int $days): void
    {
        $date = date('Y-m-d H:i:s', strtotime('+' . $days . ' days'));

        $this->setExpireDate($date);
    }

    public function hasExpireDate(): bool
    {
        return !empty($this->getExpireDate()) && $this->getExpireDate() !== 'unlimited';
    }

    private function getExpireText($date): string
    {
        try {
            $nowDate = new DateTime();
            $finalDate = new DateTime($date);
        } catch (Exception $e) {
            return '';
        }

        $difference = $nowDate->diff($finalDate);

        if (!$difference) {
            return '';
        }

        if ($difference->days === 1) {
            $daysString = mb_strtolower(tdf_string('day'), 'UTF-8');
        } else {
            $daysString = mb_strtolower(tdf_string('days'), 'UTF-8');
        }

        if ($difference->h === 1) {
            $hoursString = mb_strtolower(tdf_string('hour'), 'UTF-8');
        } else {
            $hoursString = mb_strtolower(tdf_string('hours'), 'UTF-8');
        }

        if ($difference->i === 1) {
            $minutesString = mb_strtolower(tdf_string('minute'), 'UTF-8');
        } else {
            $minutesString = mb_strtolower(tdf_string('minutes'), 'UTF-8');
        }

        if (empty($difference->days) && !empty($difference->h)) {
            return $difference->h . ' ' . $hoursString . ', ' . $difference->i . ' ' . $minutesString;
        }

        if (empty($difference->days)) {
            return $difference->i . ' ' . $minutesString;
        }

        return $difference->days . ' ' . $daysString . ', ' . $difference->h . ' ' . $hoursString;
    }

    public function getFeaturedExpireDateText(): string
    {
        return $this->getExpireText($this->getFeaturedExpireDate());
    }

    public function getExpireDateText(): string
    {
        $expireDate = $this->getExpireDate();
        if (empty($expireDate)) {
            return tdf_string('never');
        }

        return $this->getExpireText($expireDate);
    }

    public function setFeaturedExpireDate(string $date): void
    {
        $date = $this->sanitizeDate($date);

        $this->setMeta(self::FEATURED_EXPIRE, $date);

        if (!empty($date)) {
            $this->setFeatured(1);
        }
    }

    public function getFeaturedExpireDate(): string
    {
        return (string)$this->getMeta(self::FEATURED_EXPIRE);
    }

    public function hasFeaturedExpireDate(): bool
    {
        return !empty($this->getFeaturedExpireDate());
    }

    public function clearFeaturedExpireDate(): void
    {
        $this->setMeta(self::FEATURED_EXPIRE, '0');
    }

    public function isFeaturedExpired(): bool
    {
        $expireDate = $this->getFeaturedExpireDate();

        if (empty($expireDate)) {
            return false;
        }

        return date("Y-m-d H:i:s") > $expireDate;
    }

    public function isExpired(): bool
    {
        $expireDate = $this->getExpireDate();

        if (empty($expireDate) || $expireDate === 'unlimited') {
            return false;
        }

        return date("Y-m-d H:i:s") > $expireDate;
    }

    public function clearExpireDate(): void
    {
        $this->setMeta(self::EXPIRE, '0');
    }

    public function setPendingPackage($userPaymentPackageId): void
    {
        $this->setMeta(self::PENDING_PACKAGE, $userPaymentPackageId);
    }

    /**
     * @return RegularUserPaymentPackageInterface|false
     */
    public function getPendingPackage()
    {
        $pendingPackageId = $this->getMeta(self::PENDING_PACKAGE);
        if (empty($pendingPackageId)) {
            return false;
        }

        if ($pendingPackageId === 'free') {
            return tdf_app('free_package');
        }

        $user = $this->getUser();
        if (!$user) {
            return false;
        }

        return $user->getPaymentPackage($pendingPackageId);
    }

    public function removePendingPackage(): void
    {
        $this->setMeta(self::PENDING_PACKAGE, '0');
    }

    public function hasPendingPackage(): bool
    {
        return $this->getPendingPackage() !== false;
    }

    public function assignPackage(int $packageId): void
    {
        $this->setMeta(self::ASSIGNED_PACKAGE, $packageId);
    }

    public function getAssignedPackageId(): int
    {
        return (int)$this->getMeta(self::ASSIGNED_PACKAGE);
    }

    /**
     * @return RegularUserPaymentPackageInterface|false
     */
    public function getAssignedPackage()
    {
        $user = $this->getUser();
        if (!$user) {
            return false;
        }

        $packageId = $this->getAssignedPackageId();
        if (empty($packageId)) {
            return false;
        }

        return $user->getPaymentPackage($packageId);
    }

    public function hasAssignedPackage(): bool
    {
        return $this->getAssignedPackage() !== false;
    }

    public function removeAssignedPackage(): void
    {
        $this->setMeta(self::ASSIGNED_PACKAGE, '0');
    }

    public function setApproved(int $approved): void
    {
        $this->setMeta(self::APPROVED, $approved);
    }

    public function isApproved(): bool
    {
        return !empty((int)$this->getMeta(self::APPROVED));
    }

    public function getAddress(): string
    {
        $address = [];

        $locationFields = tdf_app('card_location_field');
        if (empty($locationFields)) {
            return '';
        }

        foreach ($locationFields as $field) {
            if ($field === 'user_location') {
                $address[] = apply_filters(tdf_prefix() . '/listing/address', $this->getUserLocation(), $this);
            } elseif ($field instanceof TextField) {
                $address[] = apply_filters(tdf_prefix() . '/listing/address', $field->getValue($this), $this);
            } elseif ($field instanceof LocationField) {
                $address[] = apply_filters(tdf_prefix() . '/listing/address', $field->getAddress($this), $this);
            } elseif ($field instanceof TaxonomyField) {
                $address[] = $field->getMultilevelValue($this)->map(static function ($term) {
                    /* @var CustomTerm $term */
                    return $term->getName();
                })->implode(' ');
            }
        }

        return trim(implode(' ', $address));
    }

    private function getUserLocation(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        return $user->getAddress();
    }

    public function getPrice(): string
    {
        foreach (tdf_settings()->getCardMainValueFields() as $mainValueField) {
            if (!$mainValueField instanceof PriceField && !$mainValueField instanceof SalaryField) {
                continue;
            }

            $value = $mainValueField->getValueByCurrency($this);
            if (!empty($value)) {
                return $value;
            }
        }

        return '';
    }

    public function hasMainImage(): bool
    {
        return $this->getMainImage() instanceof Image;
    }

    /**
     * @return Image|false
     */
    public function getMainImage()
    {
        $galleryField = tdf_settings()->getCardGalleryField();
        if (!$galleryField instanceof GalleryField) {
            return false;
        }

        return apply_filters(tdf_prefix() . '/model/mainImage', $galleryField->getImage($this), $this);
    }

    public function getMainImageUrl(string $size = 'full'): string
    {
        $image = $this->getMainImage();
        if (!$image) {
            return '';
        }

        return $image->getImageUrl($size);
    }

    /**
     * @param int $limit
     * @return Collection|Image[]
     */
    public function getImages(int $limit = 0): Collection
    {
        $galleryField = tdf_settings()->getCardGalleryField();
        if (!$galleryField instanceof GalleryField) {
            return tdf_collect();
        }

        return apply_filters(tdf_prefix() . '/model/images', $galleryField->getImages($this, $limit), $this);
    }

    public function setPublish(): void
    {
        $time = current_time('mysql');

        wp_update_post([
            'ID' => $this->getId(),
            'post_status' => PostStatus::PUBLISH,
            'post_date' => $time,
            'post_date_gmt' => get_gmt_from_date($time)
        ]);
    }

    private function getExpireNotificationIds(): array
    {
        $notificationIds = $this->getMeta(self::EXPIRE_NOTIFICATIONS);
        if (!is_array($notificationIds) || empty($notificationIds)) {
            return [];
        }

        return tdf_collect($notificationIds)
            ->map(static function ($notificationId) {
                return (int)$notificationId;
            })
            ->filter(static function ($notificationId) {
                return !empty($notificationId);
            })
            ->values();
    }

    public function addExpireNotification(int $notificationId): void
    {
        $notificationIds = $this->getExpireNotificationIds();
        $notificationIds[] = $notificationId;

        $this->setMeta(self::EXPIRE_NOTIFICATIONS, $notificationIds);
    }

    public function hasExpireNotification(int $notificationId): bool
    {
        return in_array($notificationId, $this->getExpireNotificationIds(), true);
    }

    public function clearExpireNotifications(): void
    {
        $this->setMeta(self::EXPIRE_NOTIFICATIONS, '0');
    }

    public function getReviewType(): string
    {
        return tdf_model_post_type();
    }

    public function setDraft(): void
    {
        parent::setDraft();

        $this->setMeta(self::UPDATE_PUBLISH_DATE, 1);
    }

    public function shouldUpdatePublishDate(): bool
    {
        return !empty((int)$this->getMeta(self::UPDATE_PUBLISH_DATE));
    }
}