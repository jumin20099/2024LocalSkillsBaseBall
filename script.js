// 방문자 데이터를 가져오는 함수
async function fetchVisitor() {
  // 방문자 데이터를 가져오는 API 호출
  const fetchData = await fetch("./선수제공파일/B_Module/visitors.json");
  // JSON 형식으로 데이터 파싱
  const parseData = await fetchData.json();
  // 파싱된 데이터 중 실제 데이터 반환
  return parseData["data"];
}

// 차트와 표를 업데이트하는 함수
function updateChartAndTable(visitorsData, leagueName, day, orientation) {
  // 선택한 리그 데이터 가져오기
  const league = visitorsData.find((l) => l.name === leagueName);
  // 선택한 요일의 방문자 데이터 가져오기
  const dayData = league.visitors.find((d) => d.day === day);
  const visitorData = dayData.visitor;

  // 표 업데이트
  $("#visitorTable").empty();
  $("#visitorTable").append(
    `<thead><tr><th>시간대</th><th>방문자 수</th></tr></thead>`
  );
  const tbody = $("<tbody></tbody>");
  for (const [time, count] of Object.entries(visitorData)) {
    tbody.append(`<tr><td>${time}</td><td>${count}</td></tr>`);
  }
  $("#visitorTable").append(tbody);

  // 차트 업데이트
  $("#chartArea").empty();
  if (orientation === "horizontal") {
    // 수평 차트 생성
    const chartContainer = $("<div></div>");
    Object.entries(visitorData).forEach(([time, count]) => {
      // 시간당 방문자 수를 기준으로 수평 막대 차트 생성
      const percentage = (count / 500) * 100;
      const bar = $(`
      <div class="d-flex align-items-center" style="margin-top: 50px;">
          <div style="width: ${percentage}%; min-width: 20px; height: 20px; background-color: #007bff; color: white;">${count}</div>
          <span class="ml-2">${time}</span>
      </div>
  `);
      chartContainer.append(bar);
    });
    $("#chartArea").css({
      display: "block",
    });
    $("#chartArea").append(chartContainer);
  } else {
    // 수직 차트 생성
    const chartContainer = $(
      "<div class='d-flex align-items-end' style='height: 200px;'></div>"
    );
    Object.entries(visitorData).forEach(([time, count]) => {
      // 시간당 방문자 수를 기준으로 수직 막대 차트 생성
      const barHeight = (count / 500) * 200;
      const bar = $(`
      <div class="d-flex flex-column align-items-center" style="margin: 0px 25px 0px 25px;">
      <div class="bar" style="width: 50px; height: ${barHeight}px; background-color: #007bff; color: white; display: flex; align-items: flex-end; justify-content: center;">${count}</div>
      <span>${time}</span>
      </div>
  `);
      chartContainer.append(bar);
    });
    $("#chartArea").css({
      display: "flex",
      "justify-content": "center",
      "text-align": "center",
    });
    $("#chartArea").append(chartContainer);
  }
}

// 야구장 차트 초기화 함수
async function initBaseballParkChart() {
  // 방문자 데이터 가져오기
  const visitorsData = await fetchVisitor();

  // 리그 선택 옵션 추가
  visitorsData.forEach((league) => {
    $("#leagueSelect").append(new Option(league.name, league.name));
  });

  // 요일 선택 옵션 추가
  const days = ["월", "화", "수", "목", "금", "토", "일"];
  days.forEach((day) => {
    $("#daySelect").append(new Option(day, day));
  });

  // 선택한 리그, 요일, 방향 변경 시 차트 및 표 업데이트
  $("#leagueSelect, #daySelect, #chartOrientation")
    .change(function () {
      const selectedLeague = $("#leagueSelect").val();
      const selectedDay = $("#daySelect").val();
      const orientation = $("#chartOrientation").val();
      updateChartAndTable(
        visitorsData,
        selectedLeague,
        selectedDay,
        orientation
      );
    })
    .change();
}

// 상품 데이터를 가져오는 함수
async function getGoodsJson() {
  // 상품 데이터 가져오기
  const a = await fetch("./선수제공파일/B_Module/goods.json");
  const b = await a.json();
  return b["data"];
}

// 페이지 로드 시 상품 초기화
async function goodsInit() {
  console.log("Initializing goods...");
  const goods = await getGoodsJson();
  const viewOptionsElem = document.querySelector("#viewOptions");
  const groups = [];
  // 그룹 데이터 출력
  goods.forEach((data) => {
    if (!groups.includes(data.group)) {
      groups.push(data.group);
    }
  });
  groups.forEach((data) => {
    viewOptionsElem.innerHTML += `<label><input type="checkbox" name="${data}" onclick="updateGoodsList()" checked> ${data}<label>`;
  });
  updateGoodsList(); // 페이지 로드 시 최초 업데이트 1회 실행
}

async function updateGoodsList() {
  // 그룹 데이터 출력
  const groups = [];
  const goods = await getGoodsJson();
  goods.forEach((data) => {
    if (!groups.includes(data.group)) {
      groups.push(data.group);
    }
  });

  // 정렬 기준에 따라 데이터 정렬
  const sortFilter = document.querySelector("#sortFilter").value;
  switch (sortFilter) {
    case "priceDesc":
      goods.sort(
        (a, b) =>
          Number(b.price.replace(",", "")) - Number(a.price.replace(",", ""))
      ); // 가격 내림차순
      break;
    case "priceAsc":
      goods.sort(
        (a, b) =>
          Number(a.price.replace(",", "")) - Number(b.price.replace(",", ""))
      ); // 가격 오름차순
      break;
    case "sortDesc":
      goods.sort((a, b) => b.sale - a.sale); // 판매량 내림차순
      break;
    case "sortAsc":
      goods.sort((a, b) => a.sale - b.sale); // 판매량 오름차순
      break;
    default:
      break;
  }

  // 상품 목록을 HTML에 반영
  const goodsListElem = document.querySelector(`#goodsList`); // HTML 요소 가져오기
  const bestGoodsListElem = document.querySelector(`#bestGoodsList`); // HTML 요소 가져오기
  goodsListElem.innerHTML = ""; // 기존 리스트 초기화
  bestGoodsListElem.innerHTML = ""; // 기존 리스트 초기화
  for (let i = 0; i < goods.length; i++) {
    // 상위 3개 상품은 BEST로 표시
    if (i < 3) {
      bestGoodsListElem.innerHTML += `<div id="goods${
        goods[i].idx
      }" class="card" style="width: 18rem;">
        <img src="./선수제공파일/B_Module/${
          goods[i].img
        }" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">[ BEST ] ${goods[i].title}</h5>
          <p class="card-text">가격 : ${goods[i].price}원</p>
          <p class="card-text">분류 : ${goods[i].group}</p>
          <p class="card-text">판매량 : ${goods[i].sale.toLocaleString()}</p>
          <button class="btn btn-primary" onclick="goodsEdit(this)">수정제안</button>
        </div>
      </div>`;
    } else {
      // 나머지 상품은 일반적으로 표시
      goodsListElem.innerHTML += `
        <div id="goods${goods[i].idx}" class="card" style="width: 18rem;">
        <img src="./선수제공파일/B_Module/${
          goods[i].img
        }" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">${goods[i].title}</h5>
          <p class="card-text">가격 : ${goods[i].price}원</p>
          <p class="card-text">분류 : ${goods[i].group}</p>
          <p class="card-text">판매량 : ${goods[i].sale.toLocaleString()}</p>
          <button class="btn btn-primary" onclick="goodsEdit(this)">수정제안</button>
        </div>
      </div>
      `;
    }
  }
}

$(document).ready(function () {
  let selectedTextBox = null;

  // 이미지 추가 기능
  $("#add-image-button").click(function () {
    $("#image-input").click();
  });

  $("#image-input").change(function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        // 배경 이미지 설정
        $("#edit-area").css({
          "background-image": `url(${e.target.result})`,
          "background-size": "contain",
          "background-repeat": "no-repeat",
          "background-position": "center center",
          width: "100%",
          height: "400px", // 높이 조정 가능
        });
        adjustModalForContent(); // 모달 크기 조정
      };
      reader.readAsDataURL(file);
    }
  });

  // 글상자 추가 및 이동 기능
  $("#text-box-button").click(function () {
    const textBox = $('<div contenteditable="true">텍스트</div>') // 텍스트 상자 생성
      .addClass("text-box")
      .css({
        position: "absolute",
        top: "10%",
        left: "10%",
        border: "1px solid #000",
        padding: "5px",
        cursor: "move",
        background: "rgba(255, 255, 255, 0.8)",
        minWidth: "50px",
        minHeight: "20px",
      })
      .draggable({
        // 드래그 기능 추가
        containment: "#edit-area",
      })
      .on("click", function (e) {
        // 클릭 이벤트 핸들러
        e.stopPropagation();
        $(".text-box").removeClass("selected-text-box");
        $(this).addClass("selected-text-box");
        selectedTextBox = this;
      });

    $("#edit-area").append(textBox); // 생성된 텍스트 상자 추가
  });

  // 글상자 회전 기능
  $(document).keydown(function (e) {
    if (selectedTextBox && e.ctrlKey && e.keyCode === 39) {
      // Ctrl + 오른쪽 화살표
      let currentRotation = $(selectedTextBox).data("rotation") || 0; // 현재 회전 값 가져오기
      let newRotation = currentRotation + 90; // 90도 회전
      $(selectedTextBox)
        .css({
          transform: `rotate(${newRotation}deg)`, // 회전 적용
        })
        .data("rotation", newRotation); // 회전값 저장
    }
  });

  // 모달 크기 조정 함수
  function adjustModalForContent() {
    const maxHeight = $(window).height() * 0.8; // 화면 높이의 80%로 최대 높이 설정
    $(".modal-body").css({
      "max-height": maxHeight + "px",
      "overflow-y": "auto",
    });
  }

  // 모달 외부 클릭 시 선택 해제
  $(document).click(function () {
    $(".text-box").removeClass("selected-text-box");
    selectedTextBox = null;
  });
});

// 모달 열기 함수
function goodsEdit(elem) {
  const goodsTitle = elem.parentElement.querySelector(".card-title").innerText;
  const modalElem = document.querySelector("#exampleModal");
  const modalTitleElem = modalElem.querySelector("h1#exampleModalLabel");

  modalTitleElem.innerText = `${goodsTitle} 수정제안`;

  $("#exampleModal").modal("show");
  adjustModalForContent(); // 모달 크기 조정
}

function reservationModal(e) {
  let selectedDate = e.innerText;
  document.getElementById("selectedDate").innerText = "선택하신 날짜 : " + selectedDate + "일";
  console.log(document.getElementById("selectedDateInput").value);
  $(".modal").modal("show");
  totalPrice = 50000;

  document.getElementById("totalPriceInput").value = totalPrice;

  document.getElementById("feeCalculateResult").innerText =
    "사용료 : " + totalPrice + "원";
}

let price = 0;

function feeCalculator(leagueElement, minPlayersElement) {
  const people = minPlayersElement.value;
  const league = leagueElement.value;
  const firstGame = document.getElementById("firstGame");
  const secondGame = document.getElementById("secondGame");
  const thirdGame = document.getElementById("thirdGame");

  let price = 0;

  switch (league) {
    case "나이트리그":
      price = 50000;
      firstGame.innerText = "19시";
      secondGame.innerText = "23시";
      thirdGame.style.display = "none";
      break;

    case "주말리그":
      price = 100000;
      firstGame.innerText = "09시";
      secondGame.innerText = "13시";
      thirdGame.style.display = "block";
      break;

    case "새벽리그":
      price = 30000;
      firstGame.innerText = "04시";
      secondGame.innerText = "07시";
      thirdGame.style.display = "none";
      break;

  }

  totalPrice = price + (people - 19) * 1000;
  console.log(totalPrice);

  totalPrice = totalPrice - 1000;
  console.log(totalPrice);

  document.getElementById("totalPriceInput").value = totalPrice;

  document.getElementById("feeCalculateResult").innerText =
    "사용료 : " + totalPrice + "원";
}
