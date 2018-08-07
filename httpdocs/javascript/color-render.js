(function($, window, document) {

    const ajaxUrl = document.URL.substr(0,document.URL.lastIndexOf('/')) + '/ajax.php';
    let $familyList = $('#family-list');

    $familyList.find('li').on('click', function () {
        let family = $(this).attr('data-family');
        colorFamily(family);
    });

    $familyList.find('select').on('change', function () {
        let family = $(this).find('option:selected').val();
        if (family === 'select') {
            overview(1);
        }
        colorFamily(family);
    });

    $('#random-color').on('click', function () {
        detailView('random');
    });

    $("#search").keyup(function(event) {
        if (event.keyCode === 13) {
            let string = $("#search").val().trim();
            if (/\S/.test(string)) {
                colorSearch(string, 1);
            }
        }
    });

    overview(1);

    function enableDetailView() {
        $('.swatch').on('click', function () {
            let hex = $(this).attr('data-hex');
            detailView(hex);
        });
    }

    function enablePagination(targetFunction, value) {
        $('.page-link').on('click', function () {
            let page = $(this).attr('data-page');
            if (value) {
                targetFunction(value, page);
            } else {
                targetFunction(page);
            }
        });
    }

    function colorSearch(string, page) {
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                template: 'color-search',
                searchString: string,
                page: page
            }
        }).done(function(result) {
            renderPane(result);
            enableDetailView();
            enablePagination(colorSearch, string);
        });
    }

    function overview(page) {
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                template: 'all-colors',
                page: page
            }
        }).done(function(result) {
            renderPane(result);
            enableDetailView();
            enablePagination(overview);
        });
    }

    function enableClearButton() {
        $("#clear-button").on('click', function () {
            overview(1);
        });
    }

    function detailView(hex) {
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                template: 'detail-view',
                hex: hex
            }
        }).done(function(result) {
            renderPane(result);
            enableClearButton();
        });

    }

    function renderPane(result) {
        $('#color-pane').html(result);
    }

    function colorFamily(family, page) {
        $.ajax({
            type: "POST",
            url: ajaxUrl,
            data: {
                template: 'color-family',
                family: family,
                page: page
            }
        }).done(function(result) {
            renderPane(result);
            enableDetailView();
            enablePagination(colorFamily, family);
            enableClearButton();
        });
    }

}(jQuery, window, document));