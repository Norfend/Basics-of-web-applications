document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.recipe-edit-button');
    const deleteButtons = document.querySelectorAll('.recipe-delete-button');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = button.getAttribute('data-id');
            window.location.href = `page/recipe-edit.php?id=${recipeId}`;
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = button.getAttribute('data-id');
            const jsonObject = {};
            jsonObject['username'] = document.getElementById('username').innerText;
            jsonObject['recipe_id'] = recipeId;

            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', 'function/recipe-action.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText.trim();
                    if (response === 'Success') {
                        alert('Recipe was successfully deleted');
                        document.querySelector(`.account-recipe-item[data-id="${recipeId}"]`).remove();
                    } else {
                        alert(response);
                    }
                }
            };
            xhr.send(JSON.stringify(jsonObject));
        });
    });
});