"use strict"

jQuery(window).on('elementor:init', function () {
    var TdfSelectRemote = elementor.modules.controls.BaseData.extend({
        onReady: function () {
            var tdfSelect = this.ui.select;
            var dataSource = tdfSelect.data('source');

            tdfSelect.select2({
                allowClear: true,
                placeholder: {
                    id: '0',
                    text: tdfSelect.data('placeholder')
                },
                ajax: {
                    url: dataSource,
                    dataType: 'json',
                    type: 'GET',
                    data: function (params) {
                        var query = {
                            search: params.term,
                        };
                        var selected = tdfSelect.val();

                        if (jQuery.isArray(selected) && tdfSelect.length > 0) {
                            query['exclude'] = selected.join(',');
                        }

                        return query;
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', window.wpApiSettings.nonce);
                    },
                    processResults: function (data) {
                        return {
                            results: jQuery.map(data, function (item) {
                                var name
                                if (typeof item.title !== 'undefined' && typeof item.title.rendered !== 'undefined') {
                                    name = item.title.rendered;
                                } else if (typeof item.name !== 'undefined') {
                                    name = item.name;
                                } else {
                                    name = '(no name)';
                                }

                                if (name === '') {
                                    name = '(no name)'
                                }

                                return {
                                    text: name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            var selected = tdfSelect.data('selected');
            if (selected !== '') {
                jQuery.ajax({
                    type: 'GET',
                    url: dataSource + (dataSource.indexOf('?') === -1 ? '?' : '&') + 'include=' + selected,
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', window.wpApiSettings.nonce);
                    },
                }).then(function (items) {
                    jQuery.each(items, function (index, item) {
                        if (typeof item.title !== 'undefined' && typeof item.title.rendered !== 'undefined') {
                            var name = item.title.rendered;
                        } else if (typeof item.name !== 'undefined') {
                            var name = item.name;
                        } else {
                            var name = 'test';
                        }
                        var option = new Option(name, item.id, true, true);
                        tdfSelect.append(option);
                    });
                    tdfSelect.trigger('change');
                });
            }
        },
        onBeforeDestroy: function () {
            if (this.ui.select.data('select2')) {
                this.ui.select.select2('destroy');
            }
        },
    });
    elementor.addControlView('tdf_select_remote', TdfSelectRemote);
});