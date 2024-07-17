<?php
//include_once("database/db-creation.php");
include_once("database/db.php");
include_once("models/post.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="images/blog-icon.png" />
    <title>X7 Blog App</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h3 class="text-center mt-3">Добавление нового поста</h3>

        <div class="row">
            <form action="post-controller.php" method="POST" class="col-sm-12 col-md-12 col-lg-12">
                <div class="mb-3">
                    <label for="titleInput" class="form-label">Заголовок</label>
                    <input type="text" class="form-control" id="titleInput" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="contentInput" class="form-label">Содержание</label>
                    <textarea class="form-control" id="contentInput" rows="6" name="content" required></textarea>
                </div>
                <input type="submit" class="btn btn-outline-primary" value="Добавить" />
            </form>

        </div>

        <div class="row mt-3">
            <h3 class="text-center mt-3">Мои посты</h3>
            <div class="overflow-auto" style="height: 50vh;">
                <table class="table table-success table-striped">
                    <thead class="sticky-top">
                        <td>ID</td>
                        <td>Заголовок</td>
                        <td>Содержание</td>
                        <td>Добавлен</td>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = db::connect();
                        $ps = $pdo->prepare('select * from posts');
                        $ps->execute();
                        if ($ps) {
                            foreach ($ps as $row) {
                                echo ('<tr onclick="onRowClickHandler(' . $row['id'] . ')">');
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['title'] . '</td>';
                                echo '<td>' . substr($row['content'], 0, 50) . '...' . '</td>';
                                echo '<td>' . $row['created_at'] . '</td>';
                                echo ('</tr>');
                            }
                        }
                        $ps = null;
                        $pdo = null;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="postAddedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="images/blog-icon.png" class="rounded me-2" alt="logo" style="height: 20px">
                <strong class="me-auto">X7 Blog App</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Пост успешно добавлен!
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        $pdo = db::connect();
        $ps = $pdo->prepare("select * from posts where id=:id");
        $ps->execute(array("id" => $id));
        $row = $ps->fetch();
        $post = new Post();
        $post->fromArray($row);
        $ps = null;
        $pdo = null;
    }
    ?>

    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel"><?php echo($post->title.' от '.$post->created_at);?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo($post->content);?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function onRowClickHandler(id) {
            window.location.replace(`index.php?post=${id}`);
        }

        function showModal() {
            var myModal = new bootstrap.Modal(document.getElementById("postModal"), {
                keyboard: false,
            });
            myModal.show();
        }
    </script>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</body>

</html>

<?php
if (isset($_GET['status'])) {
    echo ('<script>');
    echo ('$(document).ready(function() {var postAddedToast = document.getElementById("postAddedToast");');
    echo ('if (postAddedToast) {var toastBootstrap=bootstrap.Toast.getOrCreateInstance(postAddedToast);toastBootstrap.show();}});');
    echo ('</script>');
}
if (isset($_GET['post'])) {
    echo ('<script>');
    echo ('showModal();');
    echo ('</script>');
}
?>