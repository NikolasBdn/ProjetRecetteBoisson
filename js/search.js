$(function () {
    const input = $('#search-input');
    const createInputAutocomplete = (data) => {
        input.autocomplete({
            source: data,
            minLength: 0,
            select: function (event, ui) {
                switch (ui.item.type) {
                    case 'ingredient':
                        showIngredient(ui.item.id);
                        return false;
                    case 'recipe':
                        showRecipe(ui.item.id);
                        return false;
                    default:
                        return false;
                }
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