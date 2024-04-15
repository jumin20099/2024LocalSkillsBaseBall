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

        }
    }

    // 삭제 기능
    if ($action === "delete") {
        if (isset($_POST["delete_reservation_idx"])) {

        }
    }
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>skills baseball park - Goods</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
    <!-- <?php include("./components/header.php") ?> -->

    <h1 id="goodsH1">Goods</h1>
    <div id="goodsContainer">
        <div class="goods" id="goods1">
            <h2>먹다 남긴 와플</h2>
            <img src="./images/먹다남긴와플.jpg" alt="" onclick="$('#modal1').modal('show');">
        </div>

        <div class="goods" id="goods2">
            <h2>애플컴</h2>
            <img src="./images/애플컴.jpg" alt="" onclick="$('#modal2').modal('show');">
        </div>

        <div class="goods" id="goods3">
            <h2>누가 그린지 모를 그림</h2>
            <img src="./images/누가그린지모를그림.jpg" alt="" onclick="$('#modal3').modal('show');">
        </div>

        <div class="goods" id="goods4">
            <h2>용접킹의 용접모</h2>
            <img src="./images/용접킹의용접모.jpg" alt="" onclick="$('#modal4').modal('show');">
        </div>
    </div>

    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">먹다 남긴 와플</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <img src="./images/먹다남긴와플.jpg">
                    <p>지방기능경기대회 당일날 늦잠 잔 누군가가 먹던것으로 추정되는 눈물 젖은 와플.<br>온기가 남아있다..</p>
                    
                    <?php
                    echo "
                    <div>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='interestGoods'>
                            <button id='interestBtn' type='submit' name='interest_goods_idx'>관심goods등록</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='basket'>
                            <button id='basketBtn' type='submit' name='shopping_basket_idx'>장바구니</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='buyNow'>
                            <button id='buyNowBtn' type='submit' name='buy_now_idx'>바로구매</button>
                        </form>
                    </div>
                    "
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">애플컴</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <img src="./images/애플컴.jpg">
                    <p>누군가 새벽 늦게까지 과제를 위해 사용했다고 전해지는 오래된 짭퉁 iMac.<br>온기가 남아있다..</p>
                    <?php
                    echo "
                    <div>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='interestGoods'>
                            <button id='interestBtn' type='submit' name='interest_goods_idx'>관심goods등록</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='basket'>
                            <button id='basketBtn' type='submit' name='shopping_basket_idx'>장바구니</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='buyNow'>
                            <button id='buyNowBtn' type='submit' name='buy_now_idx'>바로구매</button>
                        </form>
                    </div>
                    "
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">누가 그린지 모를 그림</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <img src="./images/누가그린지모를그림.jpg">
                    <p>누군가의 아버지가 화가친구에게 선물 받은 과감한 붓터치가 인상적인 화폭 한점.<br>온기가 남아있다..</p>
                    <?php
                    echo "
                    <div>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='interestGoods'>
                            <button id='interestBtn' type='submit' name='interest_goods_idx'>관심goods등록</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='basket'>
                            <button id='basketBtn' type='submit' name='shopping_basket_idx'>장바구니</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='buyNow'>
                            <button id='buyNowBtn' type='submit' name='buy_now_idx'>바로구매</button>
                        </form>
                    </div>
                    "
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">용접킹의 용접모</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <img src="./images/용접킹의용접모.jpg">
                    <p>누군가의 형이 고등학교 시절 사용하던 낡고 더러운 용접모.<br>온기가 남아있다..</p>
                    <?php
                    echo "
                    <div>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='interestGoods'>
                            <button id='interestBtn' type='submit' name='interest_goods_idx'>관심goods등록</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='basket'>
                            <button id='basketBtn' type='submit' name='shopping_basket_idx'>장바구니</button>
                        </form>
                        <form class='goodsForm' action=''>
                            <input type='hidden' name='action' value='buyNow'>
                            <button id='buyNowBtn' type='submit' name='buy_now_idx'>바로구매</button>
                        </form>
                    </div>
                    "
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php include("./components/footer.php") ?>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
</body>

</html>