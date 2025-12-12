<?php
$host = "localhost";
$user = "Saida";
$pass = "1234";
$db = "Student_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
<?php
include('db_connect.php');
include('student_functions.php');

$error_message = $success_message = "";
$email_search = isset($_GET['email_search']) ? $_GET['email_search'] : "";
$edit_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : null;
$edit_full_name = "";
$edit_email = "";
$edit_group_name = "";

// Если редактируем студента
if ($edit_id) {
    // Получаем данные студента для редактирования
    $sql = "SELECT full_name, email, group_name FROM students WHERE id = $edit_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $edit_full_name = $student['full_name'];
        $edit_email = $student['email'];
        $edit_group_name = $student['group_name'];
    } else {
        $error_message = "Студент не найден.";
    }
}

// Обработка добавления нового студента
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_student'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $group_name = $_POST['group_name'];
    $success_message = add_student($conn, $full_name, $email, $group_name);
}

// Обработка редактирования студента
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_student'])) {
    $edit_id = $_POST['edit_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $group_name = $_POST['group_name'];
    $success_message = edit_student($conn, $edit_id, $full_name, $email, $group_name);
}

// Обработка удаления студента
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_student_id'])) {
    $delete_id = $_POST['delete_student_id'];
    $success_message = delete_student($conn, $delete_id);
}

// Получение списка студентов
$students_result = search_students($conn, $email_search);

// Подключаем шаблон HTML
include('template.php');
?>
<?php
// Функция для добавления студента
function add_student($conn, $full_name, $email, $group_name) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неправильный формат email.";
    }
    $check_sql = "SELECT id FROM students WHERE email='$email'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        return "Студент с таким email уже существует.";
    }
    $sql = "INSERT INTO students (full_name, email, group_name) VALUES ('$full_name', '$email', '$group_name')";
    return $conn->query($sql) === TRUE ? "Новая запись успешно добавлена!" : "Ошибка: " . $conn->error;
}

// Функция для редактирования студента
function edit_student($conn, $edit_id, $full_name, $email, $group_name) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Неправильный формат email.";
    }
    $check_sql = "SELECT id FROM students WHERE email='$email' AND id <> $edit_id";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        return "Email принадлежит другому студенту.";
    }
    $sql = "UPDATE students SET full_name='$full_name', email='$email', group_name='$group_name' WHERE id=$edit_id";
    return $conn->query($sql) === TRUE ? "Запись успешно обновлена!" : "Ошибка: " . $conn->error;
}

// Функция для удаления студента
function delete_student($conn, $delete_id) {
    $sql = "DELETE FROM students WHERE id = $delete_id";
    return $conn->query($sql) === TRUE ? "Запись успешно удалена." : "Ошибка: " . $conn->error;
}

// Функция для поиска студентов по email
function search_students($conn, $email_search) {
    $sql = "SELECT * FROM students WHERE email LIKE '%$email_search%' ORDER BY full_name ASC";
    return $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление студентами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-3"><?= isset($edit_id) ? 'Редактировать студента' : 'Добавить студента'; ?></h1>
    
    <!-- Форма добавления/редактирования -->
    <form action="" method="POST" class="mb-4">
        <input type="hidden" name="edit_id" value="<?= isset($edit_id) ? $edit_id : ''; ?>"> <!-- Скрытое поле для edit_id -->
        
        <div class="mb-3">
            <label for="full_name" class="form-label">ФИО:</label>
            <input type="text" id="full_name" name="full_name" class="form-control" required 
                value="<?= isset($edit_full_name) ? $edit_full_name : ''; ?>"> <!-- Заполняем старое значение ФИО -->
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required 
                value="<?= isset($edit_email) ? $edit_email : ''; ?>"> <!-- Заполняем старое значение email -->
        </div>
        
        <div class="mb-3">
            <label for="group_name" class="form-label">Группа:</label>
            <input type="text" id="group_name" name="group_name" class="form-control" required 
                value="<?= isset($edit_group_name) ? $edit_group_name : ''; ?>"> <!-- Заполняем старое значение группы -->
        </div>
        
        <button type="submit" name="<?= isset($edit_id) ? 'edit_student' : 'add_student'; ?>" class="btn btn-primary">
            <?= isset($edit_id) ? 'Сохранить изменения' : 'Добавить'; ?>
        </button>
    </form>

    <!-- Кнопка для перехода к добавлению студента -->
    <?php if (isset($edit_id)): ?>
        <a href="index.php" class="btn btn-secondary">Вернуться на главное</a>
    <?php endif; ?>

    <!-- Форма поиска студентов -->
    <h1 class="mb-3">Поиск студента по Email</h1>
    <form action="" method="GET" class="mb-4">
        <div class="mb-3">
            <label for="email_search" class="form-label">Введите Email:</label>
            <input type="email" id="email_search" name="email_search" value="<?= htmlspecialchars($email_search); ?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-secondary">Поиск</button>
    </form>

    <!-- Вывод сообщений об ошибках и успехе -->
    <?php if ($error_message) { echo "<p class='text-danger'>$error_message</p>"; } ?>
    <?php if ($success_message) { echo "<p class='text-success'>$success_message</p>"; } ?>

    <!-- Список студентов -->
    <h1 class="mb-3">Список студентов</h1>
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
        <tr>
            <th>ФИО</th>
            <th>Email</th>
            <th>Группа</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($students_result->num_rows > 0) {
            while ($row = $students_result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['full_name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['group_name']}</td>
                        <td>
                            <a href='?edit_id={$row['id']}' class='btn btn-warning btn-sm'>Редактировать</a>
                            <form action='' method='POST' style='display:inline-block;' onsubmit='return confirm(\"Вы уверены, что хотите удалить этого студента?\");'>
                                <input type='hidden' name='delete_student_id' value='{$row['id']}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Удалить</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Нет записей.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>