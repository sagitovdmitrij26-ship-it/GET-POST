<?php

$categories = json_decode(file_get_contents('categories.json'), true);
$postsFile = 'posts.json';
$posts = [];
if (file_exists($postsFile)) {
    $postsData = file_get_contents($postsFile);
    $posts = json_decode($postsData, true) ?? [];
}

if (!empty($_POST)) {
    //добавляете пост в файл
    $title = $_POST['title'];
    $category = $_POST['category'];
    $text = $_POST['text'];

    //проверим заполненность всех полей
    if (!empty($title) && !empty($category) && !empty($text)) {      

        // Генерируем ID для нового поста
        $id = 1;
        if (!empty($posts)) {
            $ids = array_keys($posts);
            $id = max($ids) + 1;
        }

        // Создаем новый пост
        $newPost = [
            'id' => $id,
            'title' => $title,
            'category' => $category,
            'text' => $text,
        ];

        // Добавляем пост в массив
        $posts[$id] = $newPost;

        // Сохраняем в JSON файл
        file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Редирект методом GET
        header('Location: /?page=post&id=' . $id);
        die();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Document</title>
</head>

<body>
    <h2>Создать пост</h2>
    <form action="" method="post">
        Заголовок поста:<br>
        <input type="text" name="title"><br><br>
        Категория:<br>
        <select name="category">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select><br><br>
        Текст поста:<br>
        <textarea name="text" cols="30" rows="3"></textarea><br>
        <input type="submit" value="Добавить"><br>
        Список постов: <br> <br>
        <?php foreach ($posts as $post): ?>
            <div>
                <?= htmlspecialchars((string) $post['title']) ?>
                <?= htmlspecialchars((string) $post['category']) ?>
            </div>
        <?php endforeach; ?>

    </form>
</body>

</html>