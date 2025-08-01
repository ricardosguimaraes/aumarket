"use strict";
/// <reference path="../../../js/knockout.d.ts" />
/// <reference path="../../../js/jquery.d.ts" />
/// <reference types="@types/lodash" />
/// <reference path="../../../modules/actor-selector/actor-selector.ts" />
/// <reference path="../../../js/jquery.biscuit.d.ts" />
/// <reference path="../../ko-extensions.ts" />
let ameTweakManager;
class AmeNamedNode {
    constructor(properties) {
        this.htmlId = '';
        this.id = properties.id;
        this.label = properties.label;
    }
}
function isAmeSettingsGroupProperties(thing) {
    const group = thing;
    return (typeof group.children !== 'undefined');
}
function isAmeSettingProperties(thing) {
    return (typeof thing.dataType === 'string');
}
class AmeSetting extends AmeNamedNode {
    constructor(properties, store, path = []) {
        super(properties);
        // noinspection JSUnusedGlobalSymbols Used in Knockout templates.
        this.templateName = '';
        let defaultValue = null;
        if (typeof properties.defaultValue !== 'undefined') {
            defaultValue = properties.defaultValue;
        }
        this.inputValue = store.getObservableProperty(properties.id, defaultValue, path);
        AmeSetting.idCounter++;
        this.uniqueInputId = 'ws-ame-gen-setting-' + AmeSetting.idCounter;
    }
}
AmeSetting.idCounter = 0;
class AmeStringSetting extends AmeSetting {
    constructor(properties, module, store, path = []) {
        super(properties, store, path);
        this.syntaxHighlightingOptions = null;
        this.templateName = 'ame-tweak-textarea-input-template';
        if (properties.syntaxHighlighting && module) {
            this.syntaxHighlightingOptions = module.getCodeMirrorOptions(properties.syntaxHighlighting);
        }
    }
}
class AmeColorSetting extends AmeSetting {
    constructor(properties, store, path = []) {
        super(properties, store, path);
        this.templateName = 'ame-tweak-color-input-template';
    }
}
class AmeBooleanSetting extends AmeSetting {
    constructor(properties, store, path = []) {
        super(properties, store, path);
        this.templateName = 'ame-tweak-boolean-input-template';
        //Ensure that the value is always a boolean.
        let _internalValue = this.inputValue;
        if (typeof _internalValue() !== 'boolean') {
            _internalValue(!!_internalValue());
        }
        this.inputValue = ko.computed({
            read: function () {
                return _internalValue();
            },
            write: function (newValue) {
                if (typeof newValue !== 'boolean') {
                    newValue = !!newValue;
                }
                _internalValue(newValue);
            },
            owner: this
        });
    }
}
function isAmeActorFeatureProperties(thing) {
    return (typeof thing.hasAccessMap === 'boolean');
}
class AmeSettingStore {
    constructor(initialProperties = {}) {
        this.observableProperties = {};
        this.accessMaps = {};
        this.initialProperties = initialProperties;
    }
    getObservableProperty(name, defaultValue, path = []) {
        path = this.getFullPath(name, path);
        if (this.observableProperties.hasOwnProperty(path)) {
            return this.observableProperties[path];
        }
        const _ = AmeTweakManagerModule._;
        const value = _.get(this.initialProperties, path, defaultValue);
        const observable = ko.observable(value);
        this.observableProperties[path] = observable;
        return observable;
    }
    getFullPath(name, path) {
        if (typeof path !== 'string') {
            path = path.join('.');
        }
        if (path === '') {
            path = name;
        }
        else {
            path = path + '.' + name;
        }
        return path;
    }
    propertiesToJs() {
        const _ = AmeTweakManagerModule._;
        let newProps = {};
        _.forOwn(this.observableProperties, function (observable, path) {
            if (typeof path === 'undefined') {
                return;
            }
            _.set(newProps, path, observable());
        });
        _.forOwn(this.accessMaps, function (map, path) {
            if (typeof path === 'undefined') {
                return;
            }
            //Since all tweaks are disabled by default, having a tweak disabled for a role is the same
            //as not having a setting, so we can save some space by removing it. This does not always
            //apply to users/Super Admins because they can have precedence over roles.
            let temp = map.getAll();
            let enabled = {};
            let areAllFalse = true;
            for (let actorId in temp) {
                if (!temp.hasOwnProperty(actorId)) {
                    continue;
                }
                areAllFalse = areAllFalse && (!temp[actorId]);
                if (!temp[actorId]) {
                    const actor = AmeActors.getActor(actorId);
                    if (actor instanceof AmeRole) {
                        continue;
                    }
                }
                enabled[actorId] = temp[actorId];
            }
            if (areAllFalse) {
                enabled = {};
            }
            _.set(newProps, path, enabled);
        });
        return newProps;
    }
    getAccessMap(name, path = [], defaultAccessMap = null) {
        path = this.getFullPath(name, path);
        const _ = AmeTweakManagerModule._;
        const value = _.get(this.initialProperties, path, defaultAccessMap);
        if (!this.accessMaps.hasOwnProperty(path)) {
            this.accessMaps[path] = new AmeObservableActorFeatureMap(value);
        }
        return this.accessMaps[path];
    }
}
function isSettingStore(thing) {
    const maybe = thing;
    return (typeof maybe.getObservableProperty !== 'undefined') && (typeof maybe.propertiesToJs !== 'undefined');
}
class AmeCompositeNode extends AmeNamedNode {
    constructor(properties, module, store, path = []) {
        super(properties);
        this.propertyPath = [];
        this.actorAccess = null;
        this.properties = null;
        this.id = properties.id;
        this.label = properties.label;
        if (store === 'self') {
            if (!this.properties) {
                this.properties = new AmeSettingStore(properties);
            }
            store = this.properties;
        }
        if (isAmeSettingsGroupProperties(properties)) {
            if ((typeof properties.propertyPath === 'string') && (properties.propertyPath !== '')) {
                this.propertyPath = properties.propertyPath.split('.');
            }
            else {
                this.propertyPath = [];
            }
            if (path.length > 0) {
                this.propertyPath = path.concat(this.propertyPath);
            }
            let children = [];
            if (properties.children && (properties.children.length > 0)) {
                for (let i = 0; i < properties.children.length; i++) {
                    const props = properties.children[i];
                    let child;
                    if (isAmeSettingProperties(props)) {
                        child = AmeCompositeNode.createSetting(props, module, store, this.propertyPath);
                    }
                    else {
                        child = new AmeCompositeNode(props, module, store, this.propertyPath);
                    }
                    if (child) {
                        children.push(child);
                    }
                }
            }
            this.children = ko.observableArray(children);
        }
        else {
            this.children = ko.observableArray([]);
        }
        if (isAmeActorFeatureProperties(properties)) {
            let name = (store === this.properties) ? 'enabledForActor' : this.id;
            const defaultAccess = (typeof properties.defaultAccessMap !== 'undefined') ? properties.defaultAccessMap : null;
            this.actorAccess = new AmeActorAccess(store.getAccessMap(name, path, defaultAccess), module, this.children);
        }
    }
    static createSetting(properties, module, store, path = []) {
        const inputType = properties.inputType ? properties.inputType : properties.dataType;
        switch (inputType) {
            case 'text':
            case 'textarea':
            case 'string':
                return new AmeStringSetting(properties, module, store, path);
            case 'color':
                return new AmeColorSetting(properties, store, path);
            case 'boolean':
                return new AmeBooleanSetting(properties, store, path);
            default:
                if (console && console.error) {
                    console.error('Unknown setting input type "%s"', inputType);
                }
                return null;
        }
    }
}
class AmeActorAccess {
    constructor(actorSettings, module, children = null) {
        this.module = module;
        this.enabledForActor = actorSettings;
        let _isIndeterminate = ko.observable(false);
        this.isIndeterminate = ko.computed(() => {
            if (module.selectedActor() !== null) {
                return false;
            }
            return _isIndeterminate();
        });
        this.isChecked = ko.computed({
            read: () => {
                const selectedActor = this.module.selectedActor();
                if (selectedActor === null) {
                    //All: Checked only if it's checked for all actors.
                    const allActors = this.module.actorSelector.getVisibleActors();
                    let isEnabledForAll = true, isEnabledForAny = false;
                    for (let index = 0; index < allActors.length; index++) {
                        if (this.enabledForActor.get(allActors[index].getId(), false)) {
                            isEnabledForAny = true;
                        }
                        else {
                            isEnabledForAll = false;
                        }
                    }
                    _isIndeterminate(isEnabledForAny && !isEnabledForAll);
                    return isEnabledForAll;
                }
                //Is there an explicit setting for this actor?
                let ownSetting = this.enabledForActor.get(selectedActor.getId(), null);
                if (ownSetting !== null) {
                    return ownSetting;
                }
                if (selectedActor instanceof AmeUser) {
                    //The "Super Admin" setting takes precedence over regular roles.
                    if (selectedActor.isSuperAdmin) {
                        let superAdminSetting = this.enabledForActor.get(AmeSuperAdmin.permanentActorId, null);
                        if (superAdminSetting !== null) {
                            return superAdminSetting;
                        }
                    }
                    //Is it enabled for any of the user's roles?
                    for (let i = 0; i < selectedActor.roles.length; i++) {
                        let groupSetting = this.enabledForActor.get('role:' + selectedActor.roles[i], null);
                        if (groupSetting === true) {
                            return true;
                        }
                    }
                }
                //All tweaks are unchecked by default.
                return false;
            },
            write: (checked) => {
                const selectedActor = this.module.selectedActor();
                if (selectedActor === null) {
                    //Enable/disable this tweak for all actors.
                    if (checked === false) {
                        //Since false is the default, this is the same as removing/resetting all values.
                        this.enabledForActor.resetAll();
                    }
                    else {
                        const allActors = this.module.actorSelector.getVisibleActors();
                        for (let i = 0; i < allActors.length; i++) {
                            this.enabledForActor.set(allActors[i].getId(), checked);
                        }
                    }
                }
                else {
                    this.enabledForActor.set(selectedActor.getId(), checked);
                }
                //Apply the same setting to all children.
                if (children) {
                    const childrenArray = children();
                    for (let i = 0; i < childrenArray.length; i++) {
                        const child = childrenArray[i];
                        if (((child instanceof AmeCompositeNode) || (child instanceof AmeTweakAlias))
                            && child.actorAccess) {
                            child.actorAccess.isChecked(checked);
                        }
                    }
                }
            }
        });
    }
}
class AmeAliasActorAccess {
    constructor(target) {
        this.isChecked = ko.computed({
            read: () => {
                return target.isChecked();
            },
            write: (checked) => {
                target.isChecked(checked);
            }
        });
        this.isIndeterminate = ko.computed(() => {
            return target.isIndeterminate();
        });
    }
}
class AmeTweakItem extends AmeCompositeNode {
    constructor(properties, module) {
        super(properties, module, 'self');
        this.description = '';
        this.initialProperties = null;
        this.section = null;
        this.parent = null;
        if (properties.description) {
            this.description = properties.description;
        }
        this.isUserDefined = properties.isUserDefined ? properties.isUserDefined : false;
        if (this.isUserDefined) {
            this.initialProperties = properties;
        }
        if (this.isUserDefined) {
            this.label = ko.observable(properties.label);
        }
        else {
            this.label = ko.pureComputed(function () {
                return properties.label;
            });
        }
        this.htmlId = 'ame-tweak-' + AmeTweakManagerModule.slugify(this.id);
    }
    toJs() {
        let result = {
            id: this.id
        };
        const _ = AmeTweakManagerModule._;
        if (this.properties) {
            result = _.defaults(result, this.properties.propertiesToJs());
        }
        if (!this.isUserDefined) {
            return result;
        }
        else {
            let props = result;
            props.isUserDefined = this.isUserDefined;
            props.label = this.label();
            props.sectionId = this.section ? this.section.id : null;
            props.parentId = this.parent ? this.parent.id : null;
            if (this.initialProperties !== null) {
                props = _.defaults(props, _.omit(this.initialProperties, 'userInputValue', 'enabledForActor'));
            }
            return props;
        }
    }
    setSection(section) {
        this.section = section;
        return this;
    }
    setParent(tweak) {
        this.parent = tweak;
        return this;
    }
    getSection() {
        return this.section;
    }
    getParent() {
        return this.parent;
    }
    addChild(tweak) {
        this.children.push(tweak);
        tweak.setParent(this);
        return this;
    }
    removeChild(tweak) {
        this.children.remove(tweak);
    }
    getEditableProperty(key) {
        if (this.properties) {
            return this.properties.getObservableProperty(key, '');
        }
        return null;
    }
    getTypeId() {
        if (!this.isUserDefined || !this.initialProperties) {
            return null;
        }
        const tweakProps = this.initialProperties;
        if ((typeof tweakProps.typeId === 'string') && (tweakProps.typeId !== '')) {
            return tweakProps.typeId;
        }
        return null;
    }
}
class AmeTweakAlias {
    constructor(target, label) {
        this.isUserDefined = false;
        this.description = ''; //Aliases don't have descriptions, even if the target tweak does.
        this.parent = null;
        this.section = null;
        this.label = label;
        AmeTweakAlias.idCounter++;
        this.id = 'alias-' + AmeTweakAlias.idCounter;
        this.htmlId = 'ame-tweak_' + AmeTweakManagerModule.slugify(this.id);
        if (target.actorAccess) {
            this.actorAccess = new AmeAliasActorAccess(target.actorAccess);
        }
        else {
            this.actorAccess = null;
        }
        this.tooltip = 'This is an alias for: "' + target.label() + '"';
        const targetSection = target.getSection();
        if (targetSection) {
            this.tooltip += ' in the section "' + targetSection.label + '"';
        }
    }
    addChild(_) {
        //No children allowed.
        throw new Error('Aliases cannot have children.');
    }
    removeChild(_) {
        //No children allowed = nothing to remove.
    }
    getParent() {
        return this.parent;
    }
    setParent(tweak) {
        this.parent = tweak;
        return this;
    }
    setSection(section) {
        this.section = section;
        return this;
    }
    getSection() {
        return this.section;
    }
}
AmeTweakAlias.idCounter = 0;
class AmeTweakSection {
    constructor(properties) {
        this.description = '';
        this.footerTemplateName = null;
        this.id = properties.id;
        this.label = properties.label;
        this.isOpen = ko.observable(true);
        this.tweaks = ko.observableArray([]);
        if (properties.description) {
            this.description = properties.description;
            //Add <br> tags to line breaks. This will look better in the tooltip.
            this.descriptionHtml = properties.description.replace(/\n/g, '<br>\n');
        }
        else {
            this.descriptionHtml = '';
        }
        if (this.id.length > 0) {
            this.htmlId = 'twm-section_' + this.id;
        }
        else {
            this.htmlId = '';
        }
    }
    addTweakNode(tweak) {
        this.tweaks.push(tweak);
        tweak.setSection(this);
    }
    removeTweakNode(tweak) {
        this.tweaks.remove(tweak);
    }
    hasContent() {
        return this.tweaks().length > 0;
    }
    toggle() {
        this.isOpen(!this.isOpen());
    }
}
class AmeTweakManagerModule {
    constructor(scriptData) {
        this.tweaksById = {};
        this.sectionsById = {};
        this.sections = [];
        this.lastUserTweakSuffix = 0;
        const _ = AmeTweakManagerModule._;
        this.actorSelector = new AmeActorSelector(AmeActors, scriptData.isProVersion);
        this.selectedActorId = this.actorSelector.createKnockoutObservable(ko);
        this.selectedActor = ko.computed(() => {
            const id = this.selectedActorId();
            if (id === null) {
                return null;
            }
            return AmeActors.getActor(id);
        });
        //Reselect the previously selected actor.
        this.selectedActorId(scriptData.selectedActor);
        //Set syntax highlighting options.
        this.cssHighlightingOptions = _.merge({}, scriptData.defaultCodeEditorSettings, {
            'codemirror': {
                'mode': 'css',
                'lint': true,
                'autoCloseBrackets': true,
                'matchBrackets': true
            }
        });
        //Sort sections by priority, then by label.
        let sectionData = _.sortBy(scriptData.sections, ['priority', 'label']);
        //Register sections.
        _.forEach(sectionData, (properties) => {
            let section = new AmeTweakSection(properties);
            this.sectionsById[section.id] = section;
            this.sections.push(section);
        });
        const firstSection = this.sections[0];
        const addNodeToParent = (node, properties) => {
            if (properties.parentId && this.tweaksById.hasOwnProperty(properties.parentId)) {
                this.tweaksById[properties.parentId].addChild(node);
            }
            else {
                let ownerSection = firstSection;
                if (properties.sectionId && this.sectionsById.hasOwnProperty(properties.sectionId)) {
                    ownerSection = this.sectionsById[properties.sectionId];
                }
                ownerSection.addTweakNode(node);
            }
        };
        _.forEach(scriptData.tweaks, (properties) => {
            const tweak = new AmeTweakItem(properties, this);
            this.tweaksById[tweak.id] = tweak;
            addNodeToParent(tweak, properties);
        });
        _.forEach(scriptData.aliases, (properties) => {
            //Does the target tweak exist?
            if (!this.tweaksById.hasOwnProperty(properties.tweakId)) {
                return;
            }
            const target = this.tweaksById[properties.tweakId];
            const alias = new AmeTweakAlias(target, properties.label);
            addNodeToParent(alias, properties);
        });
        //Remove empty sections.
        this.sections = _.filter(this.sections, function (section) {
            return section.hasContent();
        });
        //Add the tweak creation button to the Admin CSS section.
        if (this.sectionsById.hasOwnProperty('admin-css')) {
            this.sectionsById['admin-css'].footerTemplateName = 'ame-admin-css-section-footer';
        }
        //By default, all sections except the first one are closed.
        //The user can open/close sections, and we automatically remember their state.
        this.openSectionIds = ko.computed({
            read: () => {
                let result = [];
                _.forEach(this.sections, section => {
                    if (section.isOpen()) {
                        result.push(section.id);
                    }
                });
                return result;
            },
            write: (sectionIds) => {
                const openSections = _.keyBy(sectionIds);
                _.forEach(this.sections, section => {
                    section.isOpen(openSections.hasOwnProperty(section.id));
                });
            }
        });
        this.openSectionIds.extend({ rateLimit: { timeout: 1000, method: 'notifyWhenChangesStop' } });
        let initialState = null;
        let cookieValue = jQuery.cookie(AmeTweakManagerModule.openSectionCookieName);
        if ((typeof cookieValue === 'string') && JSON && JSON.parse) {
            let storedState = JSON.parse(cookieValue);
            if (_.isArray(storedState)) {
                initialState = _.intersection(_.keys(this.sectionsById), storedState);
            }
        }
        if (initialState !== null) {
            this.openSectionIds(initialState);
        }
        else {
            const firstSection = _.head(this.sections);
            if (firstSection) {
                this.openSectionIds([firstSection.id]);
            }
            else {
                this.openSectionIds([]);
            }
        }
        this.openSectionIds.subscribe((sectionIds) => {
            jQuery.cookie(AmeTweakManagerModule.openSectionCookieName, ko.toJSON(sectionIds), { expires: 90 });
        });
        if (scriptData.lastUserTweakSuffix) {
            this.lastUserTweakSuffix = scriptData.lastUserTweakSuffix;
        }
        this.adminCssEditorDialog = new AmeEditAdminCssDialog(this);
        this.settingsData = ko.observable('');
        this.isSaving = ko.observable(false);
    }
    saveChanges() {
        this.isSaving(true);
        const _ = wsAmeLodash;
        let data = {
            'tweaks': _.keyBy(_.invokeMap(this.tweaksById, 'toJs'), 'id'),
            'lastUserTweakSuffix': this.lastUserTweakSuffix
        };
        this.settingsData(ko.toJSON(data));
        return true;
    }
    addAdminCssTweak(label, css) {
        this.lastUserTweakSuffix++;
        let slug = AmeTweakManagerModule.slugify(label);
        if (slug !== '') {
            slug = '-' + slug;
        }
        let props = {
            label: label,
            id: 'utw-' + this.lastUserTweakSuffix + slug,
            isUserDefined: true,
            sectionId: 'admin-css',
            typeId: 'admin-css',
            children: [],
            hasAccessMap: true
        };
        props['css'] = css;
        const cssInput = {
            id: 'css',
            label: '',
            dataType: 'string',
            inputType: 'textarea',
            syntaxHighlighting: 'css'
        };
        props.children.push(cssInput);
        const newTweak = new AmeTweakItem(props, this);
        this.tweaksById[newTweak.id] = newTweak;
        this.sectionsById['admin-css'].addTweakNode(newTweak);
    }
    static slugify(input) {
        const _ = AmeTweakManagerModule._;
        let output = _.deburr(input);
        output = output.replace(/[^a-zA-Z0-9 _\-]/g, '');
        return _.kebabCase(output);
    }
    launchTweakEditor(tweak) {
        // noinspection JSRedundantSwitchStatement
        switch (tweak.getTypeId()) {
            case 'admin-css':
                this.adminCssEditorDialog.selectedTweak = tweak;
                this.adminCssEditorDialog.open();
                break;
            default:
                alert('Error: Editor not implemented! This is probably a bug.');
        }
    }
    confirmDeleteTweak(tweak) {
        if (!tweak.isUserDefined || !confirm('Delete this tweak?')) {
            return;
        }
        this.deleteTweak(tweak);
    }
    deleteTweak(tweak) {
        const section = tweak.getSection();
        if (section) {
            section.removeTweakNode(tweak);
        }
        const parent = tweak.getParent();
        if (parent) {
            parent.removeChild(tweak);
        }
        delete this.tweaksById[tweak.id];
    }
    getCodeMirrorOptions(mode) {
        if (mode === 'css') {
            return this.cssHighlightingOptions;
        }
        return null;
    }
}
AmeTweakManagerModule._ = wsAmeLodash;
AmeTweakManagerModule.openSectionCookieName = 'ame_tmce_open_sections';
class AmeEditAdminCssDialog {
    constructor(manager) {
        this.jQueryWidget = null;
        this.autoCancelButton = false;
        this.options = {
            minWidth: 400
        };
        this.selectedTweak = null;
        const _ = AmeTweakManagerModule._;
        this.manager = manager;
        this.tweakLabel = ko.observable('');
        this.cssCode = ko.observable('');
        this.confirmButtonText = ko.observable('Add Snippet');
        this.title = ko.observable(null);
        this.isAddButtonEnabled = ko.computed(() => {
            return !((_.trim(this.tweakLabel()) === '') || (_.trim(this.cssCode()) === ''));
        });
        this.isOpen = ko.observable(false);
    }
    onOpen(event, ui) {
        if (this.selectedTweak) {
            this.tweakLabel(this.selectedTweak.label());
            this.title('Edit admin CSS snippet');
            this.confirmButtonText('Save Changes');
            const cssProperty = this.selectedTweak.getEditableProperty('css');
            this.cssCode(cssProperty ? cssProperty() : '');
        }
        else {
            this.tweakLabel('');
            this.cssCode('');
            this.title('Add admin CSS snippet');
            this.confirmButtonText('Add Snippet');
        }
    }
    onConfirm() {
        if (this.selectedTweak) {
            //Update the existing tweak.
            this.selectedTweak.label(this.tweakLabel());
            const propertyObservable = this.selectedTweak.getEditableProperty('css');
            if (propertyObservable !== null) {
                propertyObservable(this.cssCode());
            }
        }
        else {
            //Create a new tweak.
            this.manager.addAdminCssTweak(this.tweakLabel(), this.cssCode());
        }
        this.close();
    }
    onClose() {
        this.selectedTweak = null;
    }
    close() {
        this.isOpen(false);
    }
    open() {
        this.isOpen(true);
    }
}
{
    let isTwmInitialized = false;
    function wsAmeInitTweakManager() {
        if (isTwmInitialized) {
            return;
        }
        const rootNode = document.getElementById('ame-tweak-manager');
        if (!rootNode) {
            return;
        }
        ameTweakManager = new AmeTweakManagerModule(wsTweakManagerData);
        ko.applyBindings(ameTweakManager, rootNode);
        isTwmInitialized = true;
    }
    //Try to initialize the tweak manager as soon as possible so that tweak sections
    //can be targeted by #hash links.
    wsAmeInitTweakManager();
    jQuery(function () {
        //Alternatively, we can wait until the document is ready.
        wsAmeInitTweakManager();
        //Init tooltips.
        if (typeof jQuery['qtip'] !== 'undefined') {
            jQuery('#ame-tweak-manager .ws_tooltip_trigger').qtip({
                style: {
                    classes: 'qtip qtip-rounded ws_tooltip_node'
                }
            });
        }
    });
}
//# sourceMappingURL=tweak-manager.js.map