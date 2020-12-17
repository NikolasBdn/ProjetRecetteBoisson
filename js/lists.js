function showRecipe(id) {
    __buildUrl(id);
}

function showIngredient(id) {
    __buildUrl(id);
}

function __buildUrl(id) {
    window.location.href = window.location.href + '/' + id;
}