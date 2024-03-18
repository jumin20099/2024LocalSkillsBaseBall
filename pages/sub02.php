<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style.css">
    <title>skills baseball park</title>
</head>

<body>
    <?php include("./components/header.php") ?>

    <div id="statisticsContainer" class="container mt-5">
        <div id="controls" class="mb-3">
            <select id="leagueSelect" class="custom-select mr-2">
                <!-- JavaScript를 통해 채워질 예정 -->
            </select>
            <select id="daySelect" class="custom-select mr-2">
                <!-- 요일 선택 -->
            </select>
            <select id="chartOrientation" class="custom-select mr-2">
                <option value="vertical">세로로 보기</option>
                <option value="horizontal">가로로 보기</option>
            </select>
        </div>
        <div id="chartArea">
            <!-- 차트 영역 -->
        </div>
        <table id="visitorTable" class="table">
            <!-- JavaScript를 통해 채워질 예정 -->
        </table>
    </div>

    <div id="goods">
        <h1>GOODS 판매</h1>
        <div id="viewOptions">
            <select name="sortFilter" id="sortFilter" class="custom-select mr-1" onchange="updateGoodsList(this)">
                <option value="priceDesc">가격 내림차순</option>
                <option value="priceAsc">가격 오름차순</option>
                <option value="sortDesc">판매량 내림차순</option>
                <option value="sortAsc">판매량 오름차순</option>
            </select>
        </div>
        <div id="bestGoodsList"></div>
        <div id="goodsList"></div>
    </div>

    <?php include("./components/footer.php") ?>

    <!-- 사진 편집 영역 -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 편집 영역 -->
                    <div id="edit-area" class="edit-area"></div>
                    <!-- 편집 도구 -->
                    <div class="edit-tools">
                        <button id="reset-button" class="btn btn-secondary">원래대로</button>
                        <button id="add-image-button" class="btn btn-primary">사진 추가</button>
                        <input type="file" id="image-input" hidden />
                        <button id="delete-button" class="btn btn-danger">삭제</button>
                        <button id="download-button" class="btn btn-success">다운로드</button>
                        <button id="text-box-button" class="btn btn-info">글상자</button>
                        <button id="move-rotate-text-box-button" class="btn btn-warning">글상자 이동/회전</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="./선수제공파일/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
    <script src="./script.js"></script>
    <script>
        $(document).ready(function() {
            initBaseballParkChart();
            goodsInit();
        });
    </script>

</body>

</html>