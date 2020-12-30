$(function () {
    const input = $('#search-input');
    const createInputAutocomplete = (data) => {
        input.autocomplete({
            source: data,
            minLength: 0,
            select: function (event, ui) {
                window.location.href = ui.item.url;
            }
        }).focus(function () {
            $(this).autocomplete("search");
        });
    }
    input.keyup(() => {
        if (input.val() !== '') $.getJSON('http://recetteboisson/api/quick_search/' + input.val(), (data) => {
            createInputAutocomplete(data);
        });
    });
    createInputAutocomplete([]);
});