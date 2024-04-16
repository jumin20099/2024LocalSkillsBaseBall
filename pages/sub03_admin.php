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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["holyday_idx"])) {
        $league = $_POST['league']; 
        $game_date = $_POST['selectedDate']; 
        $game_time = $_POST['time']; 

        // 데이터베이스에 저장
        $insertSql = "INSERT INTO holyday (league, game_time, game_date) VALUES (:league, :game_time, :game_date)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':league', $league);
        $insertStmt->bindParam(':game_time', $game_time);
        $insertStmt->bindParam(':game_date', $game_date);
        $insertStmt->execute(); // 저장 실행
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
                if ($reservation["is_payment"] == "결제요청") {
                    echo "<form action='' method='post'>";
                    echo "<td><button type='submit' name='approve_reservation_idx' value='" . $reservation['reservation_idx'] . "'>결제승인</button></td>";
                    echo "</form>";
                }
            }
            if ($reservation["is_payment"] == "결제완료") {
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

    <article id="gameTable">
        <table id="resTable">
            <tr>
                <th>일</th>
                <th>월</th>
                <th>화</th>
                <th>수</th>
                <th>목</th>
                <th>금</th>
                <th>토</th>
            </tr>
            <tr>
                <td></td>
                <td onclick="reservationModal(this)">1</td>
                <td onclick="reservationModal(this)">2</td>
                <td onclick="reservationModal(this)">3</td>
                <td onclick="reservationModal(this)">4</td>
                <td onclick="reservationModal(this)">5</td>
                <td onclick="reservationModal(this)">6</td>
            </tr>
            <tr>
                <td onclick="reservationModal(this)">7</td>
                <td onclick="reservationModal(this)">8</td>
                <td onclick="reservationModal(this)">9</td>
                <td onclick="reservationModal(this)">10</td>
                <td onclick="reservationModal(this)">11</td>
                <td onclick="reservationModal(this)">12</td>
                <td onclick="reservationModal(this)">13</td>
            </tr>
            <tr>
                <td onclick="reservationModal(this)">14</td>
                <td onclick="reservationModal(this)">15</td>
                <td onclick="reservationModal(this)">16</td>
                <td onclick="reservationModal(this)">17</td>
                <td onclick="reservationModal(this)">18</td>
                <td onclick="reservationModal(this)">19</td>
                <td onclick="reservationModal(this)">20</td>
            </tr>
            <tr>
                <td onclick="reservationModal(this)">21</td>
                <td onclick="reservationModal(this)">22</td>
                <td onclick="reservationModal(this)">23</td>
                <td onclick="reservationModal(this)">24</td>
                <td onclick="reservationModal(this)">25</td>
                <td onclick="reservationModal(this)">26</td>
                <td onclick="reservationModal(this)">27</td>
            </tr>
            <tr>
                <td onclick="reservationModal(this)">28</td>
                <td onclick="reservationModal(this)">29</td>
                <td onclick="reservationModal(this)">30</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </article>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reservationForm" action="" method="POST">
                        <label for="league">리그 선택 : </label>
                        <select id="league" name="league" onchange="feeCalculator(this, document.getElementById('minPlayers'))">
                            <option value="나이트리그">나이트리그</option>
                            <option value="주말리그">주말리그</option>
                            <option value="새벽리그">새벽리그</option>
                        </select><br>
                        <div id="selectedDate">

                        </div>
                        <label for="time">시간 : </label>
                        <select id="reservationTime" name="time">
                            <option id="firstGame" name="time">19시</option>
                            <option id="secondGame" name="time">23시</option>
                            <option id="thirdGame" name="time">15시</option>
                        </select><br>
                        <label style="display:none;" for="players">최소인원 : </label>
                        <input style="display:none;" onchange="feeCalculator(document.getElementById('league'), this)" type="number" id="minPlayers" name="minPlayers" value="20" min="20"><br>
                        <input type="hidden" id="selectedDateInput" name="selectedDate" value="" />
                        <input type="hidden" id="totalPriceInput" name="totalPrice" value="" />
                        <div style="display:none;" id="feeCalculateResult">

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <?php
                    if (isset($_SESSION["user_idx"])) {
                        echo "<button type='submit' name='holyday_idx' class='btn btn-primary'>휴일지정</button>";
                    } else {
                        echo "<button type='submit' disabled class='btn btn-primary'>로그인 후 예약 가능합니다</button>";
                    }
                    ?>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("./components/footer.php") ?>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>