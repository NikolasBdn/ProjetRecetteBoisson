function showRecipe(id) {
    __buildUrl(id, 0);
}

function showIngredient(id) {
    __buildUrl(id, 1);
}

function __buildUrl(id, type) {
    if (window.location.href.includes('search')) {
        switch (type) {
            case 0:
                window.location.href = window.location.href.replace('search', 'recipe') + '/' + id;
                break;
            case 1:
                window.location.href = window.location.href.replace('search', 'ingredient') + '/' + id;
                break;
        }
    } else if (window.location.href.includes('cart')) {
        switch (type) {
            case 0:
                window.location.href = window.location.href.replace('cart', 'recipe') + '/' + id;
                break;
            case 1:
                window.location.href = window.location.href.replace('cart', 'ingredient') + '/' + id;
                break;
        }
    } else {
        window.location.href = window.location.href + '/' + id;
    }
}