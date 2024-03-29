<?php
if ($_SESSION["username"] == "admin"){
    echo "
    <script>
    location.href='sub03_admin'
    </script>";
}

if ($_SESSION["username"] == "manager"){
    echo "
    <script>
    location.href='sub03_manager'
    </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $league = $_POST['league'];
    $game_time = $_POST['time'];
    $min_user = $_POST['minPlayers'];
    $price = $_POST['totalPrice'];
    $user_idx = $_SESSION["user_idx"];
    $now = date("Y-m-d");

    // reservation 테이블에 데이터 삽입
    $sql = "INSERT INTO reservation (league, game_time, min_user, price, user_idx) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$league, $game_time, $min_user, $price, $user_idx]);
    
    // 예약된 정보 업데이트
    $update_sql = "UPDATE reservation SET reservated_date = :reservated_date WHERE user_idx = :user_idx";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(":reservated_date", $now);
    $update_stmt->bindParam(":user_idx", $user_idx);
    $update_stmt->execute();

}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - Reservation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <?php include ("./components/header.php") ?>

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
                        <select id="league" name="league"
                            onchange="feeCalculator(this, document.getElementById('minPlayers'))">
                            <option value="나이트리그">나이트리그</option>
                            <option value="주말리그">주말리그</option>
                            <option value="새벽리그">새벽리그</option>
                        </select><br>
                        <div id="selectedDate">

                        </div>
                        <label for="time">시간 : </label>
                        <select id="reservationTime" name="time">
                            <option name="time" value="12">12</option>
                            <option name="time" value="13">13</option>
                            <option name="time" value="14">14</option>
                        </select><br>
                        <label for="players">최소인원 : </label>
                        <input onchange="feeCalculator(document.getElementById('league'), this)" type="number"
                            id="minPlayers" name="minPlayers" value="20" min="20"><br>
                        <input type="hidden" id="selectedDateInput" name="selectedDate" value="" />
                        <input type="hidden" id="totalPriceInput" name="totalPrice" value="" />
                        <div id="feeCalculateResult">

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <?php
                    if (isset ($_SESSION["user_idx"])) {
                        echo "<button type='submit' class='btn btn-primary'>예약하기</button>";
                    } else {
                        echo "<button type='submit' disabled class='btn btn-primary'>로그인 후 예약 가능합니다</button>";
                    }
                    ?>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php include ("./components/footer.php") ?>

    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>