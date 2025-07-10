<?php


namespace Tangibledesign\Framework\Search\Helpers;


use JsonSerializable;
use Tangibledesign\Framework\Models\Term\CustomTerm;

/**
 * Class Search
 * @package Tangibledesign\Framework\Search\Helpers
 */
class Search implements JsonSerializable
{
    /**
     * @var string
     */
    private $keyword;

    /**
     * @var CustomTerm|false
     */
    private $term;

    /**
     * Search constructor.
     * @param string $keyword
     * @param int|null $termId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __construct(string $keyword, $termId = null)
    {
        $this->keyword = $keyword;

        /** @noinspection IsEmptyFunctionUsageInspection */
        if (!empty($termId)) {
            $this->term = tdf_term_factory()->create((int)$termId);
        }
    }

    /**
     * @param array $search
     * @return Search
     */
    public static function create(array $search): Search
    {
        return new self($search['keyword'], $search['term_id']);
    }

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $term = $this->getTerm();
        if (!$term instanceof CustomTerm) {
            return get_post_type_archive_link(tdf_model_post_type()) . '?' . $this->getKeywordUrlPartial();
        }

        $url = $term->getUrl();
        if (strpos($url, '?') === false) {
            return $url . '?' . $this->getKeywordUrlPartial();
        }

        return $url . '&' . $this->getKeywordUrlPartial();
    }

    /**
     * @return string
     */
    private function getKeywordUrlPartial(): string
    {
        return tdf_slug('keyword') . '=' . urlencode($this->getKeyword());
    }

    /**
     * @return CustomTerm|false
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'keyword' => $this->getKeyword(),
            'url' => $this->getUrl(),
            'term' => $this->getTerm() ? $this->getTerm()->getName() : '',
        ];
    }

}