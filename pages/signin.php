<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $userRank = $_POST["userRank"];

    $sql = "SELECT user_idx, password, username, user_rank FROM user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $username);

    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && ($password == $user['password']) && ($userRank == $user['user_rank'])) {
        $_SESSION["user_idx"] = $user["user_idx"];
        $_SESSION["username"] = $user["username"];
        header("Location: /");
        exit;
    } else {
        echo "
        <script>
        alert('회원구분, 아이디 또는 비밀번호를 확인해주세요.');
        </script>";
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
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <!-- <?php include ("./components/header.php") ?> -->


    <section id="signupContainer">
        <form id="signupForm" action="" method="post">
            <h1>로그인</h1>
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping">아이디</span>
                <input required oninput="idAndPwRegex(this)" type="text" class="form-control" placeholder=""
                    aria-label="Example text with button addon" aria-describedby="button-addon1" name="username">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping">비밀번호</span>
                <input required oninput="idAndPwRegex(this)" type="password" class="form-control" placeholder=""
                    aria-label="Example text with button addon" aria-describedby="button-addon1" name="password">
            </div>
            <div id="userRank">
                <span>회원구분</span>
                <br>
                <input name="userRank" value="관리자" type="radio">관리자
                <br>
                <input name="userRank" value="담당자" type="radio">담당자
                <br>
                <input name="userRank" value="일반회원" type="radio">일반회원
            </div>
            <button type="submit" class="btn btn-primary">로그인</button>
        </form>
    </section>

    <?php include ("./components/footer.php") ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
</body>

</html>