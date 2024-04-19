<?php
// 세션에서 현재 사용자의 ID 가져오기
$userIdx = $_SESSION['user_idx'];

// 예약 목록 가져오는 SQL
$resSql = "SELECT * 
           FROM reservation 
           INNER JOIN user ON reservation.user_idx = user.user_idx 
           WHERE reservation.user_idx = :user_idx 
           ORDER BY reservation.reservation_idx DESC";
$stmt = $pdo->prepare($resSql);
$stmt->bindParam(":user_idx", $userIdx);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 관심 상품 목록 가져오는 SQL
$interestSql = "SELECT goods.* 
                FROM interested 
                INNER JOIN goods ON interested.goods_idx = goods.goods_idx 
                WHERE interested.user_idx = :user_idx";
$interestStmt = $pdo->prepare($interestSql);
$interestStmt->bindParam(':user_idx', $userIdx);
$interestStmt->execute();
$interestGoods = $interestStmt->fetchAll(PDO::FETCH_ASSOC);

// 장바구니 목록 가져오는 SQL
$basketSql = "SELECT goods.*, basket.*
              FROM basket
              INNER JOIN goods ON basket.goods_idx = goods.goods_idx
              WHERE basket.user_idx = :user_idx";
$basketStmt = $pdo->prepare($basketSql);
$basketStmt->bindParam(':user_idx', $userIdx);
$basketStmt->execute();
$basketItems = $basketStmt->fetchAll(PDO::FETCH_ASSOC);

// 굿즈 결제 정보 가져오는 SQL
$paymentQuery = "SELECT goodspayment.*, goods.goods_name, goods.goods_price, goods.goods_image 
                 FROM goodspayment 
                 INNER JOIN goods ON goodspayment.goods_idx = goods.goods_idx";
$paymentStatement = $pdo->prepare($paymentQuery);
$paymentStatement->execute();
$payments = $paymentStatement->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["payment_reservation_idx"])) {
        $reservation_id = $_POST["payment_reservation_idx"];
        $paymentSql = "UPDATE reservation SET is_payment = '결제요청' WHERE reservation_idx = :reservation_id";
        $paymentStmt = $pdo->prepare($paymentSql);
        $paymentStmt->bindParam(':reservation_id', $reservation_id);
        $paymentStmt->execute();
        header("Location: /mypage");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["basket_idx"])) {
        $basket_idx = $_POST["basket_idx"];
        $goods_idx = $_POST["goods_idx"];
        $user_idx = $_SESSION["user_idx"];

        // 장바구니에서 해당 상품 제거하는 SQL 실행
        $removeFromBasketSql = "DELETE FROM basket WHERE basket_idx = :basket_idx";
        $removeFromBasketStmt = $pdo->prepare($removeFromBasketSql);
        $removeFromBasketStmt->bindParam(':basket_idx', $basket_idx);
        $removeFromBasketStmt->execute();

        // 해당 상품을 구매한 것으로 `goodspayment` 테이블에 삽입
        $insertSql = "INSERT INTO goodspayment (user_idx, goods_idx, is_payment) VALUES (:user_idx, :goods_idx, 1)";
        $insertStmt = $pdo->prepare($insertSql);
        $insertStmt->bindParam(':user_idx', $user_idx);
        $insertStmt->bindParam(':goods_idx', $goods_idx);
        $insertStmt->execute();

        // 해당 상품을 결제한 정보를 goodspayment 테이블에 추가하는 SQL 실행
        // $insertPaymentSql = "INSERT INTO goodspayment (user_idx, goods_idx, is_payment) 
        //                      SELECT user_idx, goods_idx, 1 AS is_payment FROM basket WHERE basket_idx = :basket_idx";
        // $insertPaymentStmt = $pdo->prepare($insertPaymentSql);
        // $insertPaymentStmt->bindParam(':basket_idx', $basket_idx);
        // $insertPaymentStmt->execute();

        // 페이지 새로고침 방지를 위해 마이페이지로 리다이렉트
        header("Location: /mypage");
        exit();
    }
}
?>
<div id="resTableContainer">
    <h1>예약 목록</h1>
    <table id="reservationTable">
        <tr>
            <th>리그</th>
            <th>날짜</th>
            <th>시간</th>
            <th>최소인원</th>
            <th>사용료</th>
            <th>승인상태</th>
            <th>결제상태</th>
            <th>결제버튼</th>
        </tr>
        <?php
        if ($reservations) {
            foreach ($reservations as $reservation) {
                $user = isset($reservation['user']) ? $reservation['user'] : null;
                echo "<tr>";
                echo "<td>" . $reservation["league"] . "</td>";
                echo "<td>" . $reservation["reservated_date"] . "</td>";
                echo "<td>" . $reservation["game_time"] . "</td>";
                echo "<td>" . $reservation["min_user"] . "명" . "</td>";
                echo "<td>" . $reservation["price"] . "원" . "</td>";
                echo "<td>" . $reservation["reservation_status"] . "</td>";
                echo "<td>" . $reservation["is_payment"] . "</td>";
                if ($reservation["reservation_status"] == "승인거부" || $reservation["is_payment"] == "결제요청") {
                    echo "<td></td>";
                }
                if ($reservation["is_payment"] == "결제전" && $reservation["reservation_status"] != "승인거부") {
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='payment_reservation_idx' value='" . $reservation['reservation_idx'] . "'>";
                    echo "<td><button type='submit'>결제</button></td>";
                    echo "</form>";
                }
                echo "</tr>";
            }
        }
        ?>
    </table>

    <h1>관심goods영역</h1>
    <div class="row">
        <?php
        if ($interestGoods) {
            foreach ($interestGoods as $interestGood) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $interestGood['goods_image']; ?>" class="card-img-top"
                            alt="<?php echo $interestGood['goods_name']; ?>">
                        <div class="card-body">
                            <a href="goods">
                                <h5 class="card-title"><?php echo $interestGood['goods_name']; ?></h5>
                            </a>
                            <p class="card-text">가격: <?php echo $interestGood['goods_price']; ?>원</p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "관심 상품이 없습니다.";
        }
        ?>
    </div>
    <h1>장바구니영역</h1>
    <div class="row">
        <?php

        if ($basketItems) {
            foreach ($basketItems as $basketItem) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo $basketItem['goods_image']; ?>" class="card-img-top"
                            alt="<?php echo $basketItem['goods_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $basketItem['goods_name']; ?></h5>
                            <p class="card-text">가격: <?php echo $basketItem['goods_price']; ?>원</p>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="removeFromBasket">
                                <input type="hidden" name="goods_idx" value="<?php echo $basketItem['goods_idx'] ?>">
                                <input type="hidden" name="basket_idx" value="<?php echo $basketItem['basket_idx']; ?>">
                                <button type="submit">결제</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "장바구니에 상품이 없습니다.";
        }
        ?>
    </div>

    <!-- user_idx에 따라 goodspayment 테이블의 is_payment 컬럼이 동적으로 변해야함 -->
    <h1>구매리스트</h1>
    <div class=" row">
        <?php foreach ($payments as $payment): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo $payment['goods_image']; ?>" class="card-img-top"
                        alt="<?php echo $payment['goods_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $payment['goods_name']; ?></h5>
                        <p class="card-text">가격: <?php echo $payment['goods_price']; ?>원</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - mypage</title>
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