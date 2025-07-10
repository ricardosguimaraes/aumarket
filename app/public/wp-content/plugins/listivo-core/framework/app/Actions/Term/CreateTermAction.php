<?php


namespace Tangibledesign\Framework\Actions\Term;


use Tangibledesign\Framework\Models\Term\Term;
use Tangibledesign\Framework\Factories\TermFactory;

/**
 * Class CreateTermAction
 */
class CreateTermAction
{
    /**
     * @var TermFactory
     */
    protected $termFactory;

    /**
     * CreateTermAction constructor.
     * @param TermFactory $termFactory
     */
    public function __construct(TermFactory $termFactory)
    {
        $this->termFactory = $termFactory;
    }

    /**
     * @param string $term
     * @param string $taxonomy
     * @return Term|false
     */
    public function create(string $term, string $taxonomy)
    {
        $id = wp_insert_term($term, $taxonomy);

        if (is_wp_error($id)) {
            return false;
        }

        return $this->termFactory->create($id);
    }

}