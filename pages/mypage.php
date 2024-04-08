<?php
$resSql = "SELECT * 
           FROM reservation 
           INNER JOIN user ON reservation.user_idx = user.user_idx 
           WHERE reservation.user_idx = :session_user_idx 
           AND reservation.is_deleted = 0 
           ORDER BY reservation.reservation_idx DESC";

$stmt = $pdo->prepare($resSql);
$stmt->bindParam(":session_user_idx", $_SESSION['user_idx']);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table id="reservationTable">
    <tr>
        <th>리그</th>
        <th>날짜</th>
        <th>시간</th>
        <th>최소인원</th>
        <th>사용료</th>
        <th>승인상태</th>
    </tr>
    <?php
    if ($reservations) {
        foreach ($reservations as $reservation) {
            // 'user' 키의 존재 여부 확인
            $user = isset($reservation['user']) ? $reservation['user'] : null;
            
            // 예약 목록 출력
            echo "<tr>";
            echo "<td>" . $reservation["league"] . "</td>";
            echo "<td>" . $reservation["reservated_date"] . "</td>";
            echo "<td>" . $reservation["game_time"] . "</td>";
            echo "<td>" . $reservation["min_user"] . "명" . "</td>";
            echo "<td>" . $reservation["price"] . "원" . "</td>";
            echo "<td>" . $reservation["reservation_status"] . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
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
    <?php include("./components/header.php") ?>

    <?php include("./components/footer.php") ?>

    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
