<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    try {
        $sql = "INSERT INTO user (username, name, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $name, $password]);
        echo "
        <script>
        alert('회원가입 완료');
        </script>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park</title>
    <link rel="stylesheet" href="./선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style.css" >
</head>
<body>
    <!-- <?php include("./components/header.php") ?> -->

    
    <section id="signupContainer">
        <form id="signupForm" action="" method="post">
            <h1>회원가입</h1>
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping">아이디</span>
                <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="username">
                <button class="btn btn-outline-secondary" type="button" id="button-addon1">아이디 중복 검사</button>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping">이름</span>
                <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="name">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping">비밀번호</span>
                <input type="password" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="password">
            </div>
            <button type="submit" class="btn btn-primary">회원가입</button>
        </form>
    </section>

    <?php include("./components/footer.php") ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
</body>

</html>