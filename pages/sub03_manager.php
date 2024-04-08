<?php
$resSql = "SELECT *
FROM reservation
INNER JOIN user
ON reservation.user_idx = user.user_idx
WHERE is_deleted = 0
AND reservation_status = '승인대기'
ORDER BY reservation_idx DESC";

$userSql = "SELECT *
FROM user
WHERE user_idx = :user_idx";

$stmt = $pdo->prepare($resSql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($reservation["is_reservated"] == '승인 불가') {
        $deleteSql2 = "UPDATE reservation SET is_deleted = 1 WHERE is_reservated = '승인불가'";
        $stmt2 = $pdo->prepare($deleteSql2);
        $stmt2->execute();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = $_POST["reservation_idx"];

    $deleteSql = "UPDATE reservation SET is_deleted = 1 WHERE reservation_idx = :reservation_id";
    $stmt = $pdo->prepare($deleteSql);
    $stmt->bindParam(":reservation_id", $reservationId);
    $stmt->execute();
    
    echo "
    <script>
    location.href='sub03_manager';
    </script>
    ";
}

?>

<table id="reservationTable">
    <tr>
        <th>체크박스</th>
        <th>예약자ID</th>
        <th>예약자 이름</th>
        <th>리그</th>
        <th>날짜</th>
        <th>시간</th>
        <th>최소인원</th>
        <th>사용료</th>
        <th>예약가능여부</th>
        <th>예약승인버튼</th>
        <th>삭제버튼</th>
    </tr>
    <?php
    if ($reservations) {
        foreach ($reservations as $reservation) {
            $league = $reservation['league'];
            $reservated_date = $reservation['reservated_date'];
            $game_time = $reservation['game_time'];

            $approvedReservationSql = "SELECT *
            FROM reservation
            WHERE league = :league
            AND reservated_date = :reservated_date
            AND game_time = :game_time
            AND is_deleted = '0'";

            $stmtApprovedReservations = $pdo->prepare($approvedReservationSql);
            $stmtApprovedReservations->bindParam(":league", $league);
            $stmtApprovedReservations->bindParam(":reservated_date", $reservated_date);
            $stmtApprovedReservations->bindParam(":game_time", $game_time);
            $stmtApprovedReservations->execute();
            $row = $stmtApprovedReservations->fetch(PDO::FETCH_ASSOC);

            $stmtUser = $pdo->prepare($userSql);
            $stmtUser->bindParam(":user_idx", $reservation["user_idx"]);
            $stmtUser->execute();
            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            $reservationUser_idx = isset($reservation["user_idx"]) ? $reservation["user_idx"] : '';

            // 예약 목록 출력
            echo "<tr>";
            echo "<td><input type='checkbox' id='reservationCheckBox'></td>";
            echo "<td>" . $user["username"] . "</td>";
            echo "<td>" . $user["name"] . "</td>";
            echo "<td>" . $reservation["league"] . "</td>";
            echo "<td>" . $reservation["reservated_date"] . "</td>";
            echo "<td>" . $reservation["game_time"] . "시" . "</td>";
            echo "<td>" . $reservation["min_user"] . "명" . "</td>";
            echo "<td>" . $reservation["price"] . "원" . "</td>";
            if ($reservation["is_reservated"] == "예약 가능") {
                echo "<td>예약 가능</td>";
                echo "<form action='' method='post'>";
                echo "<td><button>승인</button></td>";
                echo "</form>";
            } else {
                echo "<td>승인 불가</td>";
                echo "<td>승인 불가</td>";
            }
            echo "<form action='' method='post'>";
            echo "<td><button type='submit' name='reservation_idx' value='".$reservation['reservation_idx']."'>삭제</button></td>";
            echo "</form>";
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
    <!-- <?php include("./components/header.php") ?> -->

    <?php include("./components/footer.php") ?>

    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
