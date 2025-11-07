<?php

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/app.php';

$page = $_GET['page'] ?? 'index';

switch ($page) {
    case 'index':
        echo render('index');
        break;

    case 'calc':
        $result = 0;
        $arg1 = 0;
        $arg2 = 0;

        function add($a, $b)
        {
            return $a + $b;
        }
        function sub($a, $b)
        {
            return $a - $b;
        }
        function mul($a, $b)
        {
            return $a * $b;
        }
        function div($a, $b)
        {
            //проверим деление на 0
            if ($b == 0) {
                return 'ошибка';
            }
            return $a / $b;
        }
        function calculate($arg1, $arg2, $operation)
        {
            switch ($operation) {
                case "+":
                    return add($arg1, $arg2);
                case '-':
                    return sub($arg1, $arg2);
                case '*':
                    return mul($arg1, $arg2);
                case '/':
                    return div($arg1, $arg2);
                default:
                    return 0;
            }
        }
        if (!empty($_POST)) {
            $arg1 = (float) ($_POST['arg1'] ?? 0);
            $arg2 = (float) ($_POST['arg2'] ?? 0);


            if (isset($_POST['operation'])) {
                $operation = $_POST['operation'];
                $result = calculate($arg1, $arg2, $operation);
            }
        }
        echo render('calc', [
            'arg1' => $arg1,
            'arg2' => $arg2,
            'result' => $result,
        ]);
        break;

    case 'categories':
        $categories = getCategories();

        include VIEWS_PATH . '/categories/index.phtml';
        break;

    case 'posts-by-category':
        $id = (int) ($_GET['id'] ?? 0);

        $posts = getPostsByCategoryId($id);
        $categoryName = getCategoryName($id);

        echo render('categories/show', [
            'posts' => $posts,
            'categoryName' => $categoryName,
        ]);
        break;

    case 'posts':
        $posts = getPosts();

        echo render('posts/index', [
            'posts' => $posts,
        ]);

        break;

    case 'add-post':
        $categories = json_decode(file_get_contents(ROOT_PATH . '/categories.json'), true);
        $postsFile = ROOT_PATH . '/posts.json';
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
                    'category_id' => (int) $category,
                    'text' => $text,
                ];

                // Добавляем пост в массив
                $posts[$id] = $newPost;

                // Сохраняем в JSON файл
                file_put_contents($postsFile, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                // Редирект методом GET
                header('Location: ' . BASE_URL . '?page=posts');
                die();
            }
        }
        echo render('posts/addPost', [
            'categories' => $categories,
            'posts' => $posts,
        ]);
        break;

    case 'post':
        $id = (int) ($_GET['id'] ?? 0);
        $post = getPost($id);

        echo render('posts/show', [
            'post' => $post,
        ]);
        break;

    case 'about':
        echo render('about');

        break;

    default:
        die("Нет такой страницы");
}




