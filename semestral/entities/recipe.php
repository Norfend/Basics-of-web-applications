<?php
declare(strict_types=1);

namespace entities;
class recipe
{
    private string $recipeName;
    private string $description;
    private string $howto;
    private string $ingredients;
    private string $image;

    function __construct(string $image, string $ingredients, string $howto, string $description, string $recipeName)
    {
        $this->image = $image;
        $this->ingredients = $ingredients;
        $this->howto = $howto;
        $this->description = $description;
        $this->recipeName = $recipeName;
    }

    public function getRecipeName(): string
    {
        return $this->recipeName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHowto(): string
    {
        return $this->howto;
    }

    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}