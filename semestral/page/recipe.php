<?php
require_once '../component/header.php';?>

<main class="main-content">
    <form id="recipe-form" action="" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Add a New Recipe</h1>
        <label for="recipe-name">Recipe Name</label>
        <input type="text" id="recipe-name" name="recipe-name" placeholder="Enter the recipe name" required>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" placeholder="Enter a brief description" required></textarea>
        <label for="howto">How to</label>
        <textarea id="howto" name="howto" rows="6" placeholder="Describe how to make the recipe" required></textarea>
        <label for="ingredients">Ingredients</label>
        <textarea id="ingredients" name="ingredients" rows="4" placeholder="List the ingredients" required></textarea>
        <label for="image">Recipe Image (optional)</label>
        <input type="file" id="image" name="image" accept="image/*">
        <button type="submit" class="btn-submit">Add Recipe</button>
        <span id="error"></span>
    </form>
</main>
<script type="module" src="../script/recipe-action.js"></script>

<?php include '../component/footer.php';?>