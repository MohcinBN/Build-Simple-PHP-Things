<?php 

include 'error_log.php';

/* There are two object types in software in general
1- Service Objects: Objects that provide functionality to other objects ==> Coordinate actions (e.g., creating, saving, sending)
2- Value/Domain/Entity objects: Represent (data and rules)
*/



// in simple words: 
// User → what it is this entity about
// UserService → what the system does with it


// example of Domain object
final class User
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        $this->name = $name;
        $this->email = $email;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}

// example of Service object
class UserService
{
    public function createUser(string $name, string $email): User
    {
        $user = new User($name, $email);

        // persist user (repository, DB,...)

        return $user;
    }

    public function updateUser(User $user, string $name, string $email): User
    {
        $userToUpdate = new User($name, $email);

        return $userToUpdate;
    }
}


$user = new User("Mohcin Bounouara", "m.bounouara@m.com");
//var_dump($user);

$userService = new UserService();
$updatedUser = $userService->updateUser($user, "Mohcin Bounouara UPDATED", "m.bounouara_updated@m.com");
var_dump($updatedUser);

