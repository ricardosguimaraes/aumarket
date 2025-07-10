<?php
/* @var \Tangibledesign\Listivo\Widgets\General\BreadcrumbsWidget $lstCurrentWidget */
global $lstCurrentWidget, $lstBreadcrumbs;

$lstBreadcrumbs = $lstCurrentWidget->getBreadcrumbs();
if (empty($lstBreadcrumbs)) {
    return;
}

$lstBreadcrumbsNumber = count($lstBreadcrumbs) - 1;
?>
<div class="listivo-app">
    <lst-breadcrumbs>
        <div
                slot-scope="props"
                class="listivo-breadcrumbs-wrapper"
        >
            <div v-if="!props.breadcrumbs" class="listivo-breadcrumbs">
                <?php foreach ($lstBreadcrumbs as $lstIndex => $lstBreadcrumb) : ?>
                    <?php if ($lstIndex < $lstBreadcrumbsNumber) : ?>
                        <div class="listivo-breadcrumbs__single">
                            <a
                                    class="listivo-breadcrumbs__link"
                                    href="<?php echo esc_url($lstBreadcrumb['url']); ?>"
                                    title="<?php echo esc_attr($lstBreadcrumb['name']); ?>"
                            >
                                <?php echo esc_html($lstBreadcrumb['name']); ?>
                            </a>

                            <span class="listivo-breadcrumbs__separator">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                     viewBox="0 0 11 11">
                                    <g>
                                        <g>
                                            <path
                                                    d="M4.974.635c-.119.12-.119.246 0 .38l3.987 3.973H.587c-.178 0-.267.09-.267.268v.223c0 .179.089.268.267.268H8.96L4.974 9.721c-.119.133-.119.26 0 .379l.156.178c.134.119.26.119.379 0l4.7-4.732c.133-.119.133-.238 0-.357L5.508.457c-.119-.12-.245-.12-.379 0z"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="listivo-breadcrumbs__last">
                            <?php echo esc_html($lstBreadcrumb['name']); ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <template v-if="props.breadcrumbs">
                <div class="listivo-breadcrumbs">
                    <div
                            v-for="(breadcrumb, index) in props.breadcrumbs"
                            :key="breadcrumb.key + '-' + index"
                            class="listivo-breadcrumbs__single"
                    >
                        <template v-if="index < props.breadcrumbs.length - 1">
                            <a
                                    class="listivo-breadcrumbs__link"
                                    :href="breadcrumb.url"
                                    v-html="breadcrumb.name"
                            ></a>

                            <span class="listivo-breadcrumbs__separator">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11">
                                    <g>
                                        <g>
                                            <path
                                                    d="M4.974.635c-.119.12-.119.246 0 .38l3.987 3.973H.587c-.178 0-.267.09-.267.268v.223c0 .179.089.268.267.268H8.96L4.974 9.721c-.119.133-.119.26 0 .379l.156.178c.134.119.26.119.379 0l4.7-4.732c.133-.119.133-.238 0-.357L5.508.457c-.119-.12-.245-.12-.379 0z"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </template>

                        <span v-if="index === props.breadcrumbs.length - 1" v-html="breadcrumb.name"></span>
                    </div>
                </div>
            </template>
        </div>
    </lst-breadcrumbs>
</div>