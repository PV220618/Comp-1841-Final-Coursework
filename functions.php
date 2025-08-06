<?php
function insertquestions ($pdo, $title, $content, $image, $postdate, $user_id, $module_id){
    $sql = 'INSERT INTO questions (title, content, image, postdate, user_id, module_id) 
            VALUES (:title, :content, :image, NOW(), :user_id, :module_id)';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt->bindValue(':content', $_POST['content'], PDO::PARAM_STR);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); 
    $stmt->bindValue(':module_id', $_POST['module_id'], PDO::PARAM_INT);
    $stmt->execute();
}

function deletequestions ($pdo, $questions_id){
    $sql = 'DELETE FROM questions WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();
}

function getQuestions($pdo): mixed {
    try {
        $sql = 'SELECT questions.id, questions.user_id, questions.title, questions.content, questions.postdate, questions.image,
                      users.username, users.email, modules.module_name
                FROM questions
                INNER JOIN users ON questions.user_id = users.id
                INNER JOIN modules ON questions.module_id = modules.id';
        
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Database error in getQuestions: ' . $e->getMessage());
    }
}

function login($pdo, $username, $password) {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 
        return $user;
    } else {
        return null;
    }
}


function registeruser($pdo, $email, $username, $password){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', $hashedPassword);
            $stmt->execute();
}

function getQuestionById($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllModules() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, module_name AS name FROM modules");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMessages($pdo) {
    $stmt = $pdo->query("SELECT messages.id, users.username, messages.message, messages.reply, messages.created_at
                         FROM messages
                         JOIN users ON messages.user_id = users.id
                         ORDER BY messages.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sendMessage($pdo, $userId, $message) {
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->execute([$userId, $message]);
}

function replyMessage($pdo, $id, $reply) {
    $stmt = $pdo->prepare("UPDATE messages SET reply = ? WHERE id = ?");
    $stmt->execute([$reply, $id]);
}


function addModule(PDO $pdo, string $name): string {
    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO modules (module_name) VALUES (:name)");
        $stmt->execute(['name' => ($name)]);
        return " Module added.";
    }
    return " Please enter a module name.";
}

function deleteModule(PDO $pdo, int $id): string {
    $stmt = $pdo->prepare("DELETE FROM modules WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return " Module deleted.";
}

function getAllUsers(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM users ORDER BY username ASC");
    return $stmt->fetchAll();
}

function deleteUser(PDO $pdo, int $id): string {
    if ($id === $_SESSION['user_id']) {
        return " You can't delete yourself.";
    }
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return " User deleted.";
}

function updateModule(PDO $pdo, int $id, string $name): bool {
    $stmt = $pdo->prepare("UPDATE modules SET module_name = :name WHERE id = :id");
    return $stmt->execute([
        'name' => $name,
        'id' => $id
    ]);
}

function deleteMessage(PDO $pdo, int $id): void {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
}


?>