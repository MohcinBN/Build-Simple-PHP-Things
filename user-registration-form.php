<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const USERS_FILE = 'users.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user = validateAndCreateUser($_POST);

        $users = loadUsers();

        if (emailExists($users, $user['email'])) {
            throw new Exception('Email already exists.');
        }

        $users[] = $user;

        saveUsers($users);

        $success = "User registered successfully.";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

function validateAndCreateUser(array $data): array
{
    $name = trim($data['name'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    if ($name === '') {
        throw new Exception('Name is required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address.');
    }

    if (strlen($password) < 6) {
        throw new Exception('Password must be at least 6 characters.');
    }

    return [
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];
}

function loadUsers(): array
{
    if (!file_exists(USERS_FILE)) {
        return [];
    }

    $json = file_get_contents(USERS_FILE);

    if (empty($json)) {
        return [];
    }

    $users = json_decode($json, true);

    if (!is_array($users)) {
        return [];
    }

    return $users;
}

function saveUsers(array $users): void
{
    file_put_contents(
        USERS_FILE,
        json_encode($users, JSON_PRETTY_PRINT)
    );
}

function emailExists(array $users, string $email): bool
{
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }

    return false;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mini Registration</title>
</head>

<body>

    <h2>Register</h2>

    <?php if (!empty($error)): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p style="color: green;">
            <?= htmlspecialchars($success) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label>Name:</label><br>
            <input type="text" name="name" required>
        </div>
        <br>

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </div>
        <br>

        <div>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        <br>

        <button type="submit">Register</button>
    </form>

</body>

</html>