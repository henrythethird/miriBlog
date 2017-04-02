function initializeScrollSpy(url) {
    var batchContainer = $('#batchContainer');
    var loadMore = $('#loadMore');

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() < $(document).height() - 100) return;

        var lock = batchContainer.attr('data-lock');
        var count = batchContainer.attr('data-count');

        if (lock) return;

        loadMore.button('loading');

        batchContainer.attr('data-lock', true);

        var index = batchContainer.attr('data-index');

        if (parseInt(index) >= parseInt(count)) {
            loadMore.hide();
            return;
        }

        $.get(url + (index++), null, function(response) {
            batchContainer.html(batchContainer.html() + response.view);

            batchContainer.attr('data-index', index);
            batchContainer.attr('data-lock', '');
            batchContainer.attr('data-count', response.count);

            loadMore.button('reset');
        });
    });
}