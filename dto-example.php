<?php 

declare(strict_types=1);

namespace refresh\ProjectDTO

// old way to do it, lets suppos we want to create project entity
// using arrays
/* function createProject(array $data) {
    $name = $data['name']
} */

// Let's refactor this to use DTO design pattern. In modern why PHP 8 +
/* why DTOs

- Strict type Safety of data
- mmutability of its properties, so you can not changes the object/class after its creation. 
- Protect your data from an external API

*/

final readonly class ProjectDTO
{
    public function __construct(
        public string $name,
        public string $description,
    ) {
    }

    // Helper to instantiate data from its array
    public function dataFromArray(array $data) : self 
    {
        return new self(
            name: $data['name'] ?? 'Place Holder Project Name',
            description: $data['description'] ?? 'Place Holder Project Description'
        );
    }

    // Helper to export data to an array
    public function toArray(): array 
    {
        return [
            'name' => $this->name,
            'description' => $this->description
        ];
    }

}