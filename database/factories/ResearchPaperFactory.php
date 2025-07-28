<?php

namespace Database\Factories;

use App\Models\ResearchPaper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResearchPaper>
 */
class ResearchPaperFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(8, true),
            'authors' => fake()->name() . ', ' . fake()->name() . ', ' . fake()->name(),
            'editors' => fake()->optional(0.7)->name() . ', ' . fake()->optional(0.5)->name(),
            'tm' => fake()->randomElement(['P', 'NP']),
            'type' => fake()->randomElement(['Journal', 'Conference', 'Book', 'Thesis', 'Report', 'Research', 'Article']),
            'publisher' => fake()->company(),
            'isbn' => fake()->optional(0.6)->isbn13(),
            'abstract' => fake()->paragraphs(3, true),
            'year' => fake()->numberBetween(1990, 2024),
            'department' => fake()->randomElement(['Computer Science', 'Engineering', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'Economics', 'Psychology']),
            'pdf_path' => fake()->optional(0.8)->filePath(),
            'external_link' => fake()->optional(0.6)->url(),
            'citation' => fake()->optional(0.7)->sentence(),
            'keyword' => fake()->words(5, true),
            'status' => fake()->boolean(80), // 80% chance of being true
            'restricted' => fake()->boolean(20), // 20% chance of being true
        ];
    }

    /**
     * Indicate that the research paper is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'tm' => 'P',
        ]);
    }

    /**
     * Indicate that the research paper is not published.
     */
    public function notPublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'tm' => 'NP',
        ]);
    }

    /**
     * Indicate that the research paper is a journal article.
     */
    public function journal(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Journal',
        ]);
    }

    /**
     * Indicate that the research paper is a conference paper.
     */
    public function conference(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Conference',
        ]);
    }

    /**
     * Indicate that the research paper is a thesis.
     */
    public function thesis(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'Thesis',
        ]);
    }

    /**
     * Indicate that the research paper is featured in the collection.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Indicate that the research paper is restricted.
     */
    public function restricted(): static
    {
        return $this->state(fn (array $attributes) => [
            'restricted' => true,
        ]);
    }

    /**
     * Indicate that the research paper has a PDF file.
     */
    public function withPdf(): static
    {
        return $this->state(fn (array $attributes) => [
            'pdf_path' => 'research_papers/' . fake()->uuid() . '.pdf',
        ]);
    }

    /**
     * Indicate that the research paper has an external link.
     */
    public function withExternalLink(): static
    {
        return $this->state(fn (array $attributes) => [
            'external_link' => fake()->url(),
        ]);
    }

    /**
     * Indicate that the research paper has an ISBN.
     */
    public function withIsbn(): static
    {
        return $this->state(fn (array $attributes) => [
            'isbn' => fake()->isbn13(),
        ]);
    }

    /**
     * Indicate that the research paper has editors.
     */
    public function withEditors(): static
    {
        return $this->state(fn (array $attributes) => [
            'editors' => fake()->name() . ', ' . fake()->name(),
        ]);
    }

    /**
     * Indicate that the research paper has a citation.
     */
    public function withCitation(): static
    {
        return $this->state(fn (array $attributes) => [
            'citation' => fake()->sentence(15, true),
        ]);
    }

    /**
     * Indicate that the research paper has keywords.
     */
    public function withKeywords(): static
    {
        return $this->state(fn (array $attributes) => [
            'keyword' => fake()->words(8, true),
        ]);
    }
} 