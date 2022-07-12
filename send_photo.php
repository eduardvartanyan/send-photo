<?php

session_start();
$message = '';
$formActive = true;

if(isset($_SESSION['sentCount'])) {

    if($_SESSION['sentCount'] < 1) {

        if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {

            try{

                if(!file_exists('.\images\\')) {

                    mkdir('.\images\\');

                }

                move_uploaded_file($_FILES['photo']['tmp_name'], ".\images\\" . $_FILES['photo']['name']);
                $_SESSION['sentCount']++;

                header('Location: .\images\\' . $_FILES['photo']['name']);

            } catch (Exception $e) {

                $message = $e->getMessage();
                $formActive = false;

            }

        } elseif(isset($_POST['sentCheck'])) {

            $message = "Вы не отправили фото";

        }

    } else {

        $message = 'Вы уже отправляли фото ранее';
        $formActive = false;

    }

} else {

    $_SESSION['sentCount'] = 0;

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Отправка фото</title>
    <style>
        .message-form {
            max-width: 500px;
            margin: 0 20px;
        }
        .message-form > div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .message-form_input {
            width: 70%;
        }
    </style>
</head>
<body>
    <p><?=$message ?></p>
    <?php if($formActive) { ?>
    <form action="send_photo.php" class="message-form" method="post" enctype="multipart/form-data">
        <h1>Отправка фото</h1>
        <div>
            <label>Выберите фото:</label>
            <input type="file" name="photo" class="message-form_input">
            <input type="hidden" name="sentCheck">
        </div>
        <div>
            <input type="submit" value="Отправить фото">
        </div>
    </form>
    <?php } ?>
</body>
</html>
