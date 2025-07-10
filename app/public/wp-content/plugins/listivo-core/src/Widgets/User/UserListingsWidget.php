<?php


namespace Tangibledesign\Listivo\Widgets\User;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use JasonGrimes\Paginator;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingGridControls;

/**
 * Class UserListingsWidget
 * @package Tangibledesign\Listivo\Widgets\User
 */
class UserListingsWidget extends BaseUserWidget
{
    use LimitControl;
    use ListingGridControls;
    use HighlightFeaturedListingsControl;
    use CardTypeControls;

    /**
     * @var Collection|false
     */
    protected $listings = false;

    /**
     * @var int|false
     */
    protected $resultsNumber = false;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_listings';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Listings', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControls();

        $this->addLimitControl();

        $this->addCardTypeControls();

        $this->addGridControls();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTitleStyleControls();

        $this->addCountStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function prepareListings(): void
    {

        $user = $this->getUser();

        if (!$user) {
            $this->listings = tdf_collect();
            $this->resultsNumber = 0;
            return;
        }

        $query = tdf_query_models()
            ->userIn($user->getId())
            ->take($this->getLimit())
            ->setPage($this->getCurrentPage());

        $this->listings = $query->get();
        $this->resultsNumber = $query->getResultsNumber();
    }

    /**
     * @return Collection|Model[]
     */
    public function getListings(): Collection
    {
        if ($this->listings === false) {
            $this->prepareListings();
        }

        return $this->listings;
    }

    protected function addLabelControls(): void
    {
        $this->add_control(
            'show_label',
            [
                'label' => tdf_admin_string('show_label'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('user_listings'),
                'condition' => [
                    'show_label' => '1',
                ]
            ]
        );
    }

    /**
     * @return bool
     */
    public function showLabel(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_label'));
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = (string)$this->get_settings_for_display('label');

        if (empty($label)) {
            return tdf_string('user_listings');
        }

        return $label;
    }

    /**
     * @param int $maxPages
     * @return Paginator|false
     */
    public function getPaginator(int $maxPages = 5)
    {
        if (!$this->resultsNumber) {
            return false;
        }

        $paginator = new Paginator(
            $this->getResultsNumber(),
            $this->getLimit(),
            $this->getCurrentPage(),
            $this->getUrlPattern()
        );

        $paginator->setMaxPagesToShow($maxPages);

        return $paginator;
    }

    /**
     * @return int
     */
    private function getCurrentPage(): int
    {
        if (empty($_GET[tdf_slug('pagination')])) {
            return 1;
        }

        $page = (int)$_GET[tdf_slug('pagination')];
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

    /**
     * @return string
     */
    private function getUrlPattern(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '#';
        }

        return $user->getUrl() . '/?' . tdf_slug('pagination') . '=(:num)';
    }

    /**
     * @return int
     */
    private function getResultsNumber(): int
    {
        if ($this->listings === false) {
            $this->prepareListings();
        }

        return $this->resultsNumber;
    }

    private function addTitleStyleControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-listings__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-user-listings__label',
            ]
        );
    }

    private function addCountStyleControls(): void
    {
        $this->add_control(
            'count_heading',
            [
                'label' => esc_html__('Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-listings__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'count_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-listings__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'count_typography',
                'selector' => '{{WRAPPER}} .listivo-user-listings__count',
            ]
        );
    }

}