<?php
$resSql = "SELECT *
FROM reservation
INNER JOIN user
ON reservation.user_idx = user.user_idx
WHERE is_deleted = 0
AND reservation_status = '승인완료'
ORDER BY reservation_idx DESC";

$userSql = "SELECT *
FROM user
WHERE user_idx = :user_idx";

$stmt = $pdo->prepare($resSql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["approve_reservation_idx"])) { // 승인 기능
        $reservation_id = $_POST["approve_reservation_idx"];
        $paymentSql = "UPDATE reservation SET is_payment = '결제완료' WHERE reservation_idx = :reservation_id";
        $paymentStmt = $pdo->prepare($paymentSql);
        $paymentStmt->bindParam(':reservation_id', $reservation_id);
        $paymentStmt->execute();
        header("Location: /sub03_admin");
        exit();
    }
}
?>

<table id="reservationTable">
    <tr>
        <th>예약자ID</th>
        <th>예약자 이름</th>
        <th>리그</th>
        <th>날짜</th>
        <th>시간</th>
        <th>최소인원</th>
        <th>사용료</th>
        <th>결제상태</th>
        <th>결제승인버튼</th>
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

            // 예약 목록 출력
            echo "<tr>";
            echo "<td>" . $user["username"] . "</td>";
            echo "<td>" . $user["name"] . "</td>";
            echo "<td>" . $reservation["league"] . "</td>";
            echo "<td>" . $reservation["reservated_date"] . "</td>";
            echo "<td>" . $reservation["game_time"] . "</td>";
            echo "<td>" . $reservation["min_user"] . "명" . "</td>";
            echo "<td>" . $reservation["price"] . "원" . "</td>";
            if ($reservation["is_payment"] == "결제요청" || $reservation["is_payment"] == "결제전") {
                echo "<td>";
                echo $reservation["is_payment"];
                echo "</td>";
                if ($reservation["is_payment"] == "결제요청"){
                    echo "<form action='' method='post'>";
                    echo "<td><button type='submit' name='approve_reservation_idx' value='" . $reservation['reservation_idx'] . "'>결제승인</button></td>";
                    echo "</form>";
                }
            } if($reservation["is_payment"] == "결제완료") {
                echo "<td>결제완료</td>";
                echo "<td>결제완료</td>";
            }
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