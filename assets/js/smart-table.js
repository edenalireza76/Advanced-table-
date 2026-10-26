(function () {
    'use strict';

    function initMoghimSmartTable(scope) {
        var wrappers = (scope || document).querySelectorAll('.mwp-table-wrapper');

        wrappers.forEach(function (wrapper) {
            // جلوگیری از اجرای چندباره روی یک جدول
            if (wrapper.dataset.mwpInitialized === 'true') return;
            wrapper.dataset.mwpInitialized = 'true';

            var tabs = wrapper.querySelectorAll('.mwp-tab');
            var rows = wrapper.querySelectorAll('.mwp-table tbody tr');

            if (!tabs.length || !rows.length) return;

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    // تغییر وضعیت انتخاب تب‌ها
                    tabs.forEach(function (t) {
                        t.setAttribute('aria-selected', 'false');
                    });
                    tab.setAttribute('aria-selected', 'true');

                    var filterVal = (tab.dataset.filter || 'all').trim();

                    // فیلتر کردن ردیف‌های جدول
                    rows.forEach(function (row) {
                        if (filterVal === 'all') {
                            row.hidden = false;
                        } else {
                            var rowCats = (row.dataset.categories || '').split(/[\s,]+/);
                            row.hidden = rowCats.indexOf(filterVal) === -1;
                        }
                    });
                });
            });
        });
    }

    // اجرا در فرانت‌اند سایت
    document.addEventListener('DOMContentLoaded', function () {
        initMoghimSmartTable(document);
    });

    // اجرا در محیط ویرایشگر زنده المنتور
    window.addEventListener('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/moghimwp_smart_table.default',
                function ($scope) {
                    if ($scope && $scope[0]) {
                        $scope[0].querySelectorAll('.mwp-table-wrapper').forEach(function (el) {
                            el.dataset.mwpInitialized = 'false';
                        });
                        initMoghimSmartTable($scope[0]);
                    }
                }
            );
        }
    });
})();