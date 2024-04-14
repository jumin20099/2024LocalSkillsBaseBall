<?php
$resSql = "SELECT *
FROM reservation
INNER JOIN user
ON reservation.user_idx = user.user_idx
ORDER BY reservation_idx DESC";

$userSql = "SELECT *
FROM user
WHERE user_idx = :user_idx";

$stmt = $pdo->prepare($resSql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"] ?? null; // action 값 확인

    // 승인 기능
    if ($action === "approve") {
        if (isset($_POST["approve_reservation_idx"])) {
            echo "삭제2";
            $reservation_id = $_POST["approve_reservation_idx"];
            $approveSql = "UPDATE reservation SET reservation_status = '승인완료' WHERE reservation_idx = :reservation_id";
            $approveStmt = $pdo->prepare($approveSql);
            $approveStmt->bindParam(':reservation_id', $reservation_id);
            $approveStmt->execute();
            header("Location: /sub03_manager");
            exit();
        }
    }

    // 삭제 기능
    if ($action === "delete") {
        if (isset($_POST["delete_reservation_idx"])) {
            // 삭제할 예약의 reservation_idx 가져오기
            $reservationIdx = $_POST["delete_reservation_idx"];

            // is_reservated가 "승인 불가"인 모든 예약의 reservation_idx 가져오기
            $deleteAllSql = "SELECT reservation_idx FROM reservation WHERE is_reservated = '승인 불가' AND is_deleted = 0";
            $stmtDeleteAll = $pdo->prepare($deleteAllSql);
            $stmtDeleteAll->execute();
            $deleteReservationIdxList = $stmtDeleteAll->fetchAll(PDO::FETCH_COLUMN);

            // 가져온 reservation_idx를 이용하여 삭제 쿼리 실행
            foreach ($deleteReservationIdxList as $deleteReservationIdx) {
                $deleteSql = "UPDATE reservation SET is_deleted = 1,
                              reservation_status = '승인거부',
                              is_reservated = '승인 불가'
                              WHERE reservation_idx = :reservation_id";
                $stmt = $pdo->prepare($deleteSql);
                $stmt->bindParam(":reservation_id", $deleteReservationIdx);
                $stmt->execute();
            }

            // 삭제 후 리다이렉트
            header("Location: /sub03_manager");
            exit();
        }
    }
}
?>

<table id="reservationTable">
    <h1 id="reservationList">예약 목록</h1>
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

            $checkDuplicateSql = "SELECT reservation_idx FROM reservation WHERE user_idx = :user_idx AND league = :league AND reservated_date = :reservated_date AND is_deleted = 0";
            $stmtCheckDuplicate = $pdo->prepare($checkDuplicateSql);
            $stmtCheckDuplicate->bindParam(":user_idx", $reservation["user_idx"]);
            $stmtCheckDuplicate->bindParam(":league", $reservation["league"]);
            $stmtCheckDuplicate->bindParam(":reservated_date", $reservation["reservated_date"]);
            $stmtCheckDuplicate->execute();
            $duplicateReservations = $stmtCheckDuplicate->fetchAll(PDO::FETCH_ASSOC);



            // 예약 목록 출력
            echo "<tr>";
            echo "<td><form id='deleteForm' action='' method='post'><input type='hidden' name='action' value='deleteAll'><input type='checkbox' class='delete_checkbox' name='delete_checkboxes[]' value='" . $reservation['reservation_idx'] . "'></form></td>";
            echo "<td>" . $user["username"] . "</td>";
            echo "<td>" . $user["name"] . "</td>";
            echo "<td>" . $reservation["league"] . "</td>";
            echo "<td>" . $reservation["reservated_date"] . "</td>";
            echo "<td>" . $reservation["game_time"] . "</td>";
            echo "<td>" . $reservation["min_user"] . "명" . "</td>";
            echo "<td>" . $reservation["price"] . "원" . "</td>";
            if ($reservation["is_reservated"] == "예약 가능" && $reservation["reservation_status"] != "승인완료") {
                echo '<td>';
                echo $reservation["is_reservated"];
                echo '</td>';
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='action' value='approve'>";
                echo "<td><button type='submit' name='approve_reservation_idx' value='" . $reservation['reservation_idx'] . "'>승인</button></td>";
                if ($reservation["is_reservated"] == '예약 가능') {
                    echo '<td>';
                    echo $reservation["is_reservated"];
                    echo '</td>';
                }
                echo "</form>";
            }
            if ($reservation["reservation_status"] == "승인완료") {
                echo "<td>승인 완료</td>";
                echo "<td>승인 완료</td>";
                echo "<td>승인 완료</td>";
            }
            if ($reservation["reservation_status"] == "승인거부") {
                echo "<td>승인 불가</td>";
                echo "<td>승인 불가</td>";
            }
            if ($reservation["is_reservated"] == "승인 불가") {
                // echo '<td>';
                // echo $reservation["is_reservated"];
                // echo '</td>';
                // echo '<td>';
                // echo $reservation["is_reservated"];
                // echo '</td>';
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='action' value='delete'>";
                echo "<td><button id='deleteBtn' type='submit' name='delete_reservation_idx' value='" . $reservation['reservation_idx'] . "'>삭제</button></td>";
                echo "</form>";
            }
            if (!empty($duplicateReservations)) {
                // 가장 마지막 예약을 제외한 나머지 예약 삭제
                $lastReservationIdx = $duplicateReservations[0]["reservation_idx"];
                foreach ($duplicateReservations as $duplicate) {
                    if ($duplicate["reservation_idx"] != $lastReservationIdx) {
                        $deleteSql = "UPDATE reservation SET is_deleted = 1, reservation_status = '승인거부', is_reservated = '승인 불가' WHERE reservation_idx = :reservation_idx";
                        $stmtDelete = $pdo->prepare($deleteSql);
                        $stmtDelete->bindParam(":reservation_idx", $duplicate["reservation_idx"]);
                        $stmtDelete->execute();
                    }
                }
            }
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