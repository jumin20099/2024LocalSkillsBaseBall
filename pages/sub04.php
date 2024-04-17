<?php
$resSql = "SELECT *
FROM reservation
INNER JOIN user
ON reservation.user_idx = user.user_idx
WHERE user.user_idx = :session_user_idx
ORDER BY reservation_idx DESC";

$stmt = $pdo->prepare($resSql);
$stmt->bindParam(":session_user_idx", $_SESSION['user_idx']);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$goodsSql = "SELECT * FROM goods";

$goodsStmt = $pdo->prepare($goodsSql);
$goodsStmt->execute();
$goods = $goodsStmt->fetchAll(PDO::FETCH_ASSOC);

echo ($_SESSION['user_idx']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        // 액션에 따라 분기 처리
        $action = $_POST["action"];
        
        switch ($action) {
            case 'interestGoods':
                echo("관심");
                break;
            case 'basket':
                echo("장바구니");
                break;
            case 'buyNow':
                echo("바로구매");
                break;
            default:
                echo("이게뭐노");
                break;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ko">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - goods</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
<?php include("./components/header.php") ?>
    <h1>Goods</h1>
    <div class="goodsContainer">
    <div class="row">
        <?php foreach ($goods as $good): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="<?php echo $good['goods_image']; ?>" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $good['goods_name']; ?></h5>
                        <p class="card-text"><?php echo $good['description']; ?></p>
                        <p class="card-text">Price: <?php echo isset($good['goods_price']) ? $good['goods_price'] : 'N/A'; ?></p>
                    <div>
                        <form class='goodsForm' action='' method='post'>
                            <input type='hidden' name='action' value='interestGoods'>
                            <input type='hidden' name='goods_id' value='<?php echo $user['user_idx']; ?>'>
                            <button id='interestBtn' type='submit' name='interest_goods_idx'>관심goods등록</button>
                        </form>
                        <form class='goodsForm' action='' method='post'>
                            <input type='hidden' name='action' value='basket'>
                            <input type='hidden' name='goods_id' value='<?php echo $user['user_idx']; ?>'>
                            <button id='basketBtn' type='submit' name='shopping_basket_idx'>장바구니</button>
                        </form>
                        <form class='goodsForm' action='' method='post'>
                            <input type='hidden' name='action' value='buyNow'>
                            <input type='hidden' name='goods_id' value='<?php echo $user['user_idx']; ?>'>
                            <button id='buyNowBtn' type='submit' name='buy_now_idx'>바로구매</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
    <?php include("./components/footer.php") ?>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>
