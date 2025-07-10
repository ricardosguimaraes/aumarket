import {Selector} from './utils';

export type ItemTargetType = 'menu' | 'page' | 'tab' | 'filter' | 'section' | 'group' | 'control';

export type ItemLocation = string[];
export type RequestNavigation = (url: string, targetSelector: ItemSelector) => void;

export type ItemSelector = Selector;

let itemInstanceCounter = 0;

export abstract class SearchableItem {
	private readonly instanceId: number;

	public readonly label: string;
	protected readonly location: ItemLocation = [];

	public lastUsedAt: number = -1;
	public lastVisitedAt: number = -1;

	protected constructor(props: BaseItemProps) {
		this.instanceId = itemInstanceCounter++;

		this.label = props.label;
		if (props.location) {
			this.location = props.location;
		}
	}

	getUniqueId(): string {
		return this.constructor.name + '-' + this.instanceId;
	}

	getSearchableText(): string {
		return this.label;
	}

	performAction(requestNavigation: RequestNavigation): boolean {
		console.log('Action performed for item:', this);
		return true;
	}

	getMetaLabel(): string {
		return '';
	}

	getLocation(): ItemLocation {
		return this.location;
	}

	getStatusBarText(urlFormatter: (url: string) => string): string  {
		return '';
	}

	toJs(): UnknownSerializedItem {
		return {
			type: this.getSerializedType(),
			label: this.label,
			location: this.location,
		};
	}

	protected abstract getSerializedType(): SerializedItemType;
}

export class DashboardItem extends SearchableItem {
	private readonly origin: DashboardItemProps['origin'];
	private readonly relativeId: string;
	private readonly target: DashboardItemProps['target'];
	public readonly ownLabel: string | null;

	constructor(props: DashboardItemProps) {
		super(props);

		this.origin = props.origin;
		this.relativeId = props.relativeId;
		this.target = props.target;
		this.ownLabel = props.ownLabel || null;
	}

	protected getSerializedType(): SerializedItemType {
		return 'dashboardItem';
	}

	getUniqueId(): string {
		const originUrl = this.origin.menuUrl;
		/* ^ pageUrl may seem more appropriate here, but then we run into problems with items
		 * that appear on multiple sub-pages of the same menu item, like post type filters.
		 * Each filter has its own URL, and when you go to that URL, the page shows all the filters
		 * again. So by using the page URL in the ID, you would end up with duplicate items.
		 *
		 * Instead, we use the menu URL, which is the same for all the filters (etc) on the same
		 * page. The downside is that genuinely different sub-pages (e.g. tabs) could have different
		 * items that have the same ID. Hopefully, that will be rare.
		 *
		 * If that becomes an issue, maybe the ID registry could be managed at the menu item level,
		 * not the page level. That way similar IDs on different pages under the same menu item
		 * would get deduplicated.
		 */
		return 'p:' + originUrl + ':' + this.relativeId;
	}

	performAction(requestNavigation: RequestNavigation): boolean {
		console.log('Navigating to dashboard item:', this.origin, this.target);

		const targetUrl = this.getEffectiveTargetUrl();
		requestNavigation(targetUrl, this.target.selector || '');
		return true;
	}

	getEffectiveTargetUrl(): string {
		return this.target.url || this.origin.pageUrl || this.origin.menuUrl;
	}

	getMenuUrl(): string | null {
		return this.origin.menuUrl;
	}

	getStatusBarText(urlFormatter: (url: string) => string): string {
		const targetUrl = this.getEffectiveTargetUrl();
		if (targetUrl) {
			return urlFormatter(targetUrl);
		}
		return '';
	}

	getSelector(): ItemSelector | null {
		return this.target.selector || null;
	}

	getTargetType(): ItemTargetType {
		return this.target.type;
	}

	getRelativeId(): string {
		return this.relativeId;
	}

	toJs(): UnknownSerializedItem {
		const result = super.toJs();

		//Serialize the origin and target properties. Filter out redundant URL properties.
		const origin: DashboardItemProps['origin'] = {
			menuUrl: this.origin.menuUrl
		};
		if (this.origin.pageUrl && (this.origin.pageUrl !== this.origin.menuUrl)) {
			origin.pageUrl = this.origin.pageUrl;
		}
		const originUrl = origin.pageUrl || origin.menuUrl;

		const target: DashboardItemProps['target'] = {
			type: this.target.type
		};
		if (this.target.url && (this.target.url !== originUrl)) {
			target.url = this.target.url;
		}
		if (this.target.selector) {
			target.selector = this.target.selector;
		}

		result.origin = origin;
		result.target = target;
		result.relativeId = this.relativeId;

		return result;
	}
}

export class AdminMenuItem extends SearchableItem {
	private readonly menuItemId: string | null = null;
	private readonly url: string;

	constructor(
		props: AdminMenuItemProps,
		private readonly titleParts: string[],
		public readonly targetElement: JQuery | null = null,
		private readonly relativeUrl: string | null = null,
		relativeParentUrl: string | null = null
	) {
		super(props);

		this.url = props.url;
		if (this.relativeUrl) {
			let id = this.relativeUrl;
			if (relativeParentUrl) {
				id = relativeParentUrl + '>' + id;
			}
			this.menuItemId = 'adminMenu/' + id;
		}
	}

	performAction(requestNavigation: RequestNavigation): boolean {
		if (this.targetElement && this.targetElement.is('a')) {
			//Follow the link. Counterintuitively, triggering a "click" event in jQuery doesn't
			//actually do this. We need to get the DOM element and call click() on it.
			const link = this.targetElement.get(0);
			console.log('Clicking target link:', link);
			link.click();
		}

		if (this.url) {
			console.log('Navigating to URL:', this.url);
			window.location.href = this.url;
			return true;
		}

		return super.performAction(requestNavigation);
	}

	getMetaLabel(): string {
		return 'Admin Menu';
	}

	getUniqueId(): string {
		if (this.menuItemId) {
			return this.menuItemId;
		}
		return super.getUniqueId();
	}

	getTitleParts(): string[] {
		return this.titleParts;
	}

	getUrl(): string {
		return this.url;
	}

	getRelativeMenuUrl(): string {
		return this.relativeUrl || '';
	}

	getStatusBarText(urlFormatter: (url: string) => string): string {
		if (this.relativeUrl) {
			return urlFormatter(this.relativeUrl);
		}
		return '';
	}

	protected getSerializedType(): SerializedItemType {
		return 'adminMenuItem';
	}
}

export class LoadingPlaceholderItem extends SearchableItem {
	constructor() {
		super({
			label: 'Loading...',
		});
	}

	performAction(_: RequestNavigation): boolean {
		return false; //Do nothing and don't close the search box.
	}

	protected getSerializedType(): SerializedItemType {
		throw new Error('Placeholder items cannot be serialized');
	}
}

export type SerializedItemType = 'link' | 'element' | 'command' | 'adminMenuItem' | 'dashboardItem';

interface BaseItemProps {
	label: string;
	location?: string[];
}

/**
 * Properties for an item found in the WordPress Dashboard, such as a form field,
 * a button, a link, and so on.
 *
 * This *does not* include admin menu items. Those are parsed on the fly and don't
 * need to be serialized.
 */
export interface DashboardItemProps extends BaseItemProps {
	origin: {
		/**
		 * Admin menu URL that the item is associated with. Relative to the wp-admin URL.
		 */
		menuUrl: string;
		/**
		 * URL of the page that the item is on, if different from the menu URL.
		 */
		pageUrl?: string | null;
	};
	relativeId: string;

	target: {
		/**
		 * Link URL for items that link to a different page, like filters and admin page tabs.
		 */
		url?: string | null;
		/**
		 * CSS selector for items that target an element on the page, like form fields and buttons.
		 */
		selector?: ItemSelector;
		type: ItemTargetType;
	};

	/**
	 * Label of just the item itself, not including its parent section, container, etc.
	 *
	 * In some cases, the general "label" property can include the parent's label, e.g. to help
	 * make it unique. The "ownLabel" property is useful for items like tabs and navigation links
	 * that might be added ot the "location" array.
	 */
	ownLabel?: string;
}

interface PageChildItemProps extends BaseItemProps {
	pageUrl?: string; //Can be omitted if menuUrl is provided and matches the page URL.
	relativeId: string;
}

interface OnPageLinkItemProps extends PageChildItemProps {
	targetUrl: string;
}

interface ElementItemProps extends PageChildItemProps {
	selector: ItemSelector;
}

interface LinkItemProps extends BaseItemProps {
	url?: string; //The URL can be omitted if the menuUrl is provided.
}

interface AdminMenuItemProps extends BaseItemProps {
	url: string;
}

interface SerializedDashboardItem extends DashboardItemProps {
	type: 'dashboardItem';
}

interface SerializedLinkItem extends LinkItemProps {
	type: 'link';
}

interface SerializedElementItem extends LinkItemProps {
	type: 'element';
	selector: ItemSelector;
	clickSelectors?: string[];
}

interface SerializedCommandItem extends BaseItemProps {
	type: 'command';
}

interface SerializedAdminMenuItem extends LinkItemProps {
	type: 'adminMenuItem';
}

export type SerializedItem =
	SerializedDashboardItem
	| SerializedLinkItem
	| SerializedElementItem
	| SerializedCommandItem
	| SerializedAdminMenuItem;

export interface UnknownSerializedItem extends BaseItemProps, Record<string, unknown> {
	type: SerializedItemType;
}

export function unserializeItem(data: SerializedItem): SearchableItem {
	switch (data.type) {
		case 'dashboardItem':
			return new DashboardItem(data);
		default:
			const invalidType = data.type;
			throw new Error(`Unsupported item type: ${invalidType}`);
	}
}