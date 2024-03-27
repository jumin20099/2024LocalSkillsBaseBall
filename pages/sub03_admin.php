<?php
$userSql = "SELECT * FROM reservation WHERE is_deleted = 0 ORDER BY reservated_date DESC";
$resSql = "SELECT * FROM user";

$stmt = $pdo->prepare($userSql);
$stmt = $pdo->prepare($resSql);
$stmt->execute();

$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="reservationContainer">
    <?php
    if ($reservations) {
        foreach ($reservations as $reservation) {
            $userSql = "SELECT * FROM user WHERE user_idx = :user_idx";
            $stmt = $pdo->prepare($userSql);
            $stmt->bindParam(":user_idx", $reservation["user_idx"]);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $reservationUser_idx = isset ($reservation["user_idx"]) ? $reservation["user_idx"] : '';

            // 예약 목록은 체크박스, 예약자ID, 예약자 이름, 리그, 날짜, 시간, 최소인원, 사용료, 예약가능여부, 예약승인버튼, 삭제버튼이 있다
            // 이즈 레저베이티드 = 불리언 말고 이넘 3가지
            // 결제 상태도 추가 , 이넘3
            $divInnerText = "";
            $divInnerText .= "<div class='post'>";
            $divInnerText .= "<p class='id'> 예약자 ID : " . $user["username"] . "</p>";
            $divInnerText .= "<p class='id'> 예약자 이름 : " . $user["name"] . "</p>";
            $divInnerText .= "<p class='id'> 리그 : " . $reservation["league"] . "</p>";
            $divInnerText .= "<p class='id'> 날짜 : " . $reservation["reservated_date"] . "</p>";
            $divInnerText .= "<p class='id'> 시간 : " . $reservation["game_time"] . "</p>";
            $divInnerText .= "<p class='id'> 최소인원 : " . $reservation["min_user"] . "</p>";
            $divInnerText .= "<p class='id'> 사용료 : " . $reservation["price"] . "</p>";
            $divInnerText .= "<p class='id'> 예약가능여부 : " . $reservation["is_reservated"] . "</p>";
            $divInnerText .= "</div>";
            $divInnerText .= "<br>";
            echo $divInnerText;
        }
    }
    ?>
</div>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - Reservation for admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <?php include ("./components/header.php") ?>

    <?php include ("./components/footer.php") ?>

    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>