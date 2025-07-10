<?php

use Tangibledesign\Framework\Models\Field\LocationField;

/* @var LocationField $field */
global $field;
?>
<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(LocationField::MAP_TYPE); ?>">
            <?php esc_html_e('Map Type', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(LocationField::MAP_TYPE); ?>"
                id="<?php echo esc_attr(LocationField::MAP_TYPE); ?>"
        >
            <option
                    value="<?php echo esc_attr(LocationField::MAP_TYPE_ROADMAP); ?>"
                <?php if ($field->getMapType() === LocationField::MAP_TYPE_ROADMAP) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Roadmap', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::MAP_TYPE_SATELLITE); ?>"
                <?php if ($field->getMapType() === LocationField::MAP_TYPE_SATELLITE) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Satellite', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::MAP_TYPE_HYBRID); ?>"
                <?php if ($field->getMapType() === LocationField::MAP_TYPE_HYBRID) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Hybrid', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::MAP_TYPE_TERRAIN); ?>"
                <?php if ($field->getMapType() === LocationField::MAP_TYPE_TERRAIN) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Terrain', 'listivo-core'); ?>
            </option>
        </select>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(LocationField::SEARCH_TYPE); ?>">
            <?php esc_html_e('Search Type', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(LocationField::SEARCH_TYPE); ?>"
                id="<?php echo esc_attr(LocationField::SEARCH_TYPE); ?>"
        >
            <option
                    value="<?php echo esc_attr(LocationField::SEARCH_TYPE_ALL); ?>"
                <?php if ($field->getSearchType() === LocationField::SEARCH_TYPE_ALL) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('All', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::SEARCH_TYPE_CITIES); ?>"
                <?php if ($field->getSearchType() === LocationField::SEARCH_TYPE_CITIES) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Cities', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::SEARCH_TYPE_REGIONS); ?>"
                <?php if ($field->getSearchType() === LocationField::SEARCH_TYPE_REGIONS) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Regions', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::SEARCH_TYPE_ADDRESS); ?>"
                <?php if ($field->getSearchType() === LocationField::SEARCH_TYPE_ADDRESS) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Address', 'listivo-core'); ?>
            </option>
        </select>
    </td>
</tr>


<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(LocationField::INPUT_TYPE); ?>">
            <?php esc_html_e('Input Type', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(LocationField::INPUT_TYPE); ?>"
                id="<?php echo esc_attr(LocationField::INPUT_TYPE); ?>"
        >
            <option
                    value="<?php echo esc_attr(LocationField::INPUT_TYPE_GEOCODE); ?>"
                <?php if ($field->getInputType() === LocationField::INPUT_TYPE_GEOCODE) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Geocode', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::INPUT_TYPE_ESTABLISHMENT); ?>"
                <?php if ($field->getInputType() === LocationField::INPUT_TYPE_ESTABLISHMENT) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Establishment', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::INPUT_TYPE_CITIES); ?>"
                <?php if ($field->getInputType() === LocationField::INPUT_TYPE_CITIES) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Cities', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::INPUT_TYPE_REGIONS); ?>"
                <?php if ($field->getInputType() === LocationField::INPUT_TYPE_REGIONS) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Regions', 'listivo-core'); ?>
            </option>

            <option
                    value="<?php echo esc_attr(LocationField::INPUT_TYPE_ADDRESS); ?>"
                <?php if ($field->getInputType() === LocationField::INPUT_TYPE_ADDRESS) : ?>
                    selected
                <?php endif; ?>
            >
                <?php esc_html_e('Address', 'listivo-core'); ?>
            </option>
        </select>
    </td>
</tr>

<tr>
    <th scope="row">
        <label for="<?php echo esc_attr(LocationField::COUNTRY_RESTRICTIONS); ?>">
            <?php esc_html_e('Country Restrictions (Max 5)', 'listivo-core'); ?>
        </label>
    </th>

    <td>
        <select
                name="<?php echo esc_attr(LocationField::COUNTRY_RESTRICTIONS); ?>[]"
                id="<?php echo esc_attr(LocationField::COUNTRY_RESTRICTIONS); ?>"
                class="tdf-selectize-init"
                placeholder="<?php esc_attr_e('No Restrictions', 'listivo-core'); ?>"
                multiple
        >
            <?php foreach (LocationField::getCountries() as $country) : ?>
                <option
                        value="<?php echo esc_attr($country['alpha-2']); ?>"
                    <?php if ($field->isCountryRestricted($country['alpha-2'])) : ?>
                        selected
                    <?php endif; ?>
                >
                    <?php echo esc_html($country['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
</tr>