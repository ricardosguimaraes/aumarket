<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PopularSearchesWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <div class="listivo-searches-list">
        <div class="listivo-searches-list__inner">
            <div class="listivo-searches-list__column">
                <h3 class="listivo-searches-list__title">
                    <?php echo esc_html(tdf_string('popular_searches')); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 913.000000 42.000000"
                         preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M7962 404 c-11 -12 -33 -14 -100 -12 -48 1 -240 -1 -427 -5 -187 -4 -506 -10 -710 -13 -354 -5 -415 -7 -603 -19 -185 -11 -867 -23 -1392 -25 -124 -1 -360 -6 -525 -11 -385 -14 -451 -15 -1170 -23 -411 -5 -646 -12 -745 -22 -86 -9 -301 -17 -530 -20 -244 -3 -422 -10 -485 -19 -90 -13 -202 -18 -640 -30 -77 -2 -189 -11 -250 -19 -60 -9 -151 -16 -202 -16 -50 0 -103 -4 -116 -9 -33 -13 -40 -47 -21 -109 l17 -52 193 0 c123 0 194 4 194 10 0 6 14 10 30 10 17 0 30 -4 30 -10 0 -15 107 -13 112 2 5 13 100 18 562 32 115 4 263 11 330 16 67 5 312 14 546 20 234 5 529 14 655 20 234 10 529 16 1255 25 637 8 931 14 1270 25 173 5 506 15 740 21 675 17 689 17 820 28 69 5 217 10 330 11 271 1 727 18 815 30 39 5 254 9 478 10 452 0 580 9 635 46 l32 22 -32 23 c-20 14 -50 24 -77 26 -26 1 -111 7 -191 13 -80 5 -187 10 -238 11 -65 0 -96 5 -106 15 -17 16 -106 19 -106 4 0 -5 -9 -10 -20 -10 -11 0 -20 5 -20 10 0 6 -61 10 -162 10 -133 -1 -165 -4 -176 -16z"></path>
                        </g>
                    </svg>
                </h3>

                <ul class="listivo-links-vertical">
                    <?php foreach ($lstCurrentWidget->getPopularSearches() as $lstSearch) : ?>
                        <li>
                            <a href="<?php echo esc_url($lstSearch->getUrl()); ?>">
                                <?php echo esc_html($lstSearch->getKeyword()); ?>

                                <?php if ($lstSearch->getTerm()) : ?>
                                    <?php echo esc_html(tdf_string('in') . ' ' . $lstSearch->getTerm()->getName()); ?>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="listivo-searches-list__column">
                <h3 class="listivo-searches-list__title">
                    <?php echo esc_html(tdf_string('recent_searches')); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 913.000000 42.000000"
                         preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)" stroke="none">
                            <path d="M7962 404 c-11 -12 -33 -14 -100 -12 -48 1 -240 -1 -427 -5 -187 -4 -506 -10 -710 -13 -354 -5 -415 -7 -603 -19 -185 -11 -867 -23 -1392 -25 -124 -1 -360 -6 -525 -11 -385 -14 -451 -15 -1170 -23 -411 -5 -646 -12 -745 -22 -86 -9 -301 -17 -530 -20 -244 -3 -422 -10 -485 -19 -90 -13 -202 -18 -640 -30 -77 -2 -189 -11 -250 -19 -60 -9 -151 -16 -202 -16 -50 0 -103 -4 -116 -9 -33 -13 -40 -47 -21 -109 l17 -52 193 0 c123 0 194 4 194 10 0 6 14 10 30 10 17 0 30 -4 30 -10 0 -15 107 -13 112 2 5 13 100 18 562 32 115 4 263 11 330 16 67 5 312 14 546 20 234 5 529 14 655 20 234 10 529 16 1255 25 637 8 931 14 1270 25 173 5 506 15 740 21 675 17 689 17 820 28 69 5 217 10 330 11 271 1 727 18 815 30 39 5 254 9 478 10 452 0 580 9 635 46 l32 22 -32 23 c-20 14 -50 24 -77 26 -26 1 -111 7 -191 13 -80 5 -187 10 -238 11 -65 0 -96 5 -106 15 -17 16 -106 19 -106 4 0 -5 -9 -10 -20 -10 -11 0 -20 5 -20 10 0 6 -61 10 -162 10 -133 -1 -165 -4 -176 -16z"></path>
                        </g>
                    </svg>
                </h3>

                <ul class="listivo-links-vertical">
                    <?php foreach ($lstCurrentWidget->getRecentSearches() as $lstSearch) : ?>
                        <li>
                            <a href="<?php echo esc_url($lstSearch->getUrl()); ?>">
                                <?php echo esc_html($lstSearch->getKeyword()); ?>

                                <?php if ($lstSearch->getTerm()) : ?>
                                    <?php echo esc_html(tdf_string('in') . ' ' . $lstSearch->getTerm()->getName()); ?>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <template>
                <lst-related-searches :limit="<?php echo esc_attr($lstCurrentWidget->getNumber()); ?>">
                    <div slot-scope="props" class="listivo-searches-list__column">
                        <div v-if="props.searches.length <= -2">
                            <lst-search-categories
                                    :terms="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getTerms())); ?>"
                            >
                                <div slot-scope="props">
                                    <h3 class="listivo-searches-list__title">
                                        <?php echo esc_html(tdf_string('categories')); ?>

                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 913.000000 42.000000"
                                             preserveAspectRatio="xMidYMid meet">
                                            <g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)"
                                               stroke="none">
                                                <path d="M7962 404 c-11 -12 -33 -14 -100 -12 -48 1 -240 -1 -427 -5 -187 -4 -506 -10 -710 -13 -354 -5 -415 -7 -603 -19 -185 -11 -867 -23 -1392 -25 -124 -1 -360 -6 -525 -11 -385 -14 -451 -15 -1170 -23 -411 -5 -646 -12 -745 -22 -86 -9 -301 -17 -530 -20 -244 -3 -422 -10 -485 -19 -90 -13 -202 -18 -640 -30 -77 -2 -189 -11 -250 -19 -60 -9 -151 -16 -202 -16 -50 0 -103 -4 -116 -9 -33 -13 -40 -47 -21 -109 l17 -52 193 0 c123 0 194 4 194 10 0 6 14 10 30 10 17 0 30 -4 30 -10 0 -15 107 -13 112 2 5 13 100 18 562 32 115 4 263 11 330 16 67 5 312 14 546 20 234 5 529 14 655 20 234 10 529 16 1255 25 637 8 931 14 1270 25 173 5 506 15 740 21 675 17 689 17 820 28 69 5 217 10 330 11 271 1 727 18 815 30 39 5 254 9 478 10 452 0 580 9 635 46 l32 22 -32 23 c-20 14 -50 24 -77 26 -26 1 -111 7 -191 13 -80 5 -187 10 -238 11 -65 0 -96 5 -106 15 -17 16 -106 19 -106 4 0 -5 -9 -10 -20 -10 -11 0 -20 5 -20 10 0 6 -61 10 -162 10 -133 -1 -165 -4 -176 -16z"></path>
                                            </g>
                                        </svg>
                                    </h3>

                                    <ul class="listivo-links-vertical">
                                        <li v-for="term in props.terms">
                                            <a :href="term.url">
                                                {{ term.name }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </lst-search-categories>
                        </div>

                        <div v-if="props.searches.length > 0">
                            <h3 class="listivo-searches-list__title">
                                <?php echo esc_html(tdf_string('related_searches')); ?>

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 913.000000 42.000000"
                                     preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)"
                                       stroke="none">
                                        <path d="M7962 404 c-11 -12 -33 -14 -100 -12 -48 1 -240 -1 -427 -5 -187 -4 -506 -10 -710 -13 -354 -5 -415 -7 -603 -19 -185 -11 -867 -23 -1392 -25 -124 -1 -360 -6 -525 -11 -385 -14 -451 -15 -1170 -23 -411 -5 -646 -12 -745 -22 -86 -9 -301 -17 -530 -20 -244 -3 -422 -10 -485 -19 -90 -13 -202 -18 -640 -30 -77 -2 -189 -11 -250 -19 -60 -9 -151 -16 -202 -16 -50 0 -103 -4 -116 -9 -33 -13 -40 -47 -21 -109 l17 -52 193 0 c123 0 194 4 194 10 0 6 14 10 30 10 17 0 30 -4 30 -10 0 -15 107 -13 112 2 5 13 100 18 562 32 115 4 263 11 330 16 67 5 312 14 546 20 234 5 529 14 655 20 234 10 529 16 1255 25 637 8 931 14 1270 25 173 5 506 15 740 21 675 17 689 17 820 28 69 5 217 10 330 11 271 1 727 18 815 30 39 5 254 9 478 10 452 0 580 9 635 46 l32 22 -32 23 c-20 14 -50 24 -77 26 -26 1 -111 7 -191 13 -80 5 -187 10 -238 11 -65 0 -96 5 -106 15 -17 16 -106 19 -106 4 0 -5 -9 -10 -20 -10 -11 0 -20 5 -20 10 0 6 -61 10 -162 10 -133 -1 -165 -4 -176 -16z"></path>
                                    </g>
                                </svg>
                            </h3>

                            <ul class="listivo-links-vertical">
                                <li v-for="search in props.searches">
                                    <a :href="search.url">
                                        {{ search.keyword }}

                                        <template v-if="search.term !== ''"> <?php echo esc_html(tdf_string('in')); ?>
                                            <span v-html="search.term"></span>
                                        </template>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </lst-related-searches>
            </template>
        </div>
    </div>
</div>