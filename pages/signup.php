<?php
session_start();
if (isset($_SESSION['user_idx'])) {
    echo "
    <script>
    alert('로그인한 회원은 접근할 수 없습니다.');
    </script>";
    exit; // 이후 코드 실행을 막기 위해 종료
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 아이디
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    // 이름
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    // 비밀번호
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    // 캡차
    $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';

    // 데이터베이스에서 아이디 중복 검사 (고쳐야함)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "
        <script>
        alert('이미 사용중인 아이디입니다.');
        </script>";
    } else {
        if ($captcha == '1QS35') {
            $sql = "INSERT INTO user (username, name, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $name, $password]);
            echo "
            <script>
            alert('관리자 승인 대기중입니다.');
            location.href = 'signin';
            </script>";
        } else {
            echo "
               <script>
               alert('캡차를 다시 확인해주세요');
               </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - SignUp</title>
    <link rel="stylesheet" href="./선수제공파일/bootstrap-5.2.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body style="padding-top: 680px">
    <?php include("./components/header.php") ?>
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">회원가입</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="signupForm" action="" method="post">
                        <h1>회원가입</h1>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">아이디</span>
                            <input required oninput="idAndPwRegex(this)" type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="username">
                            <button class="btn btn-outline-secondary check-username" type="submit" id="button-addon1">아이디 중복 검사</button>
                        </div>
                        <div id="responseMessage"></div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">이름</span>
                            <input required oninput="nameRegex(this)" type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="name">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">비밀번호</span>
                            <input required oninput="idAndPwRegex(this)" type="password" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1" name="password">
                        </div>
                        <img src="./images/캡차.JPG" alt="">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">캡차</span>
                            <input required type="text" class="form-control" placeholder="" aria-label="Example text with button addon" maxlength="5" aria-describedby="button-addon1" name="captcha">
                        </div>
                        <button type="submit" class="btn btn-primary">회원가입</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <?php include("./components/footer.php") ?>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
</body>

</html>