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

foreach ($goods as $good) :
endforeach;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼에서 전송된 데이터 가져오기
    $goods_name = $_POST["goods_name"];
    $description = $_POST["description"];
    $goods_price = $_POST["goods_price"];
    $goods_image = $_POST["goods_image"];

    // 데이터베이스에 새로운 굿즈를 추가하는 SQL 실행
    $insertGoodsSql = "INSERT INTO goods (goods_name, description, goods_price, goods_image) 
                       VALUES (:goods_name, :description, :goods_price, :goods_image)";
    $insertGoodsStmt = $pdo->prepare($insertGoodsSql);
    $insertGoodsStmt->bindParam(':goods_name', $goods_name);
    $insertGoodsStmt->bindParam(':description', $description);
    $insertGoodsStmt->bindParam(':goods_price', $goods_price);
    $insertGoodsStmt->bindParam(':goods_image', $goods_image);

    // 실행 결과 확인
    if ($insertGoodsStmt->execute()) {
        echo "
        <script>
        alert('굿즈 등록 완료');
        location.href = '/sub04_manager';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - goods for manager</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <?php include("./components/header.php") ?>
    <div class="container mt-5">
        <h1>굿즈 등록</h1>
        <form method="post">
            <div class="form-group">
                <label for="goods_name">굿즈 이름</label>
                <input type="text" class="form-control" id="goods_name" name="goods_name" required>
            </div>
            <div class="form-group">
                <label for="description">굿즈 설명</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="goods_price">가격</label>
                <input type="number" class="form-control" id="goods_price" name="goods_price" required>
            </div>
            <div class="form-group">
                <label for="goods_image">이미지 URL</label>
                <input type="text" class="form-control" id="goods_image" name="goods_image" required>
            </div>
            <button type="submit" class="btn btn-primary">등록</button>
        </form>
    </div>
    <h1>Goods</h1>
    <div id="goodsContainer">
        <?php foreach ($goods as $good) : ?>
            <img onclick="showGoodsModal('<?php echo $good['goods_idx']; ?>');" style="width: 300px; height: 400px;" src="<?php echo $good['goods_image']; ?>">
        <?php endforeach; ?>
        <?php foreach ($goods as $good) : ?>
            <!-- Modal -->
            <div class="modal fade" id="goodsModal<?php echo $good['goods_idx']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $good['goods_name']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo $good['goods_image']; ?>">
                            <p>
                                <?php echo $good['description']; ?>
                                <br>
                                <?php echo $good['goods_price']; ?>원
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include("./components/footer.php") ?>

    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>