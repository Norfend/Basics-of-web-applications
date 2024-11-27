<?php
$recipes = [
    [
        'name' => 'Spaghetti Carbonara',
        'description' => 'A classic Italian pasta dish with creamy sauce.',
        'image' => 'images/carbonara.jpg'
    ],
    [
        'name' => 'Chicken Curry',
        'description' => 'Rich and flavorful curry with tender chicken pieces.',
        'image' => 'images/chicken-curry.jpg'
    ],
    [
        'name' => 'Vegetable Stir Fry',
        'description' => 'Healthy and colorful veggies stir-fried to perfection.',
        'image' => 'images/stir-fry.jpg'
    ]
];

return json_encode($recipes);