<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>skills baseball park</title>
  <link rel="stylesheet" href="./style.css">
</head>

<body>

  <?php include("./components/header.php")?>

  <section id="container">
    <div class="slidebox">
      <input type="radio" name="slide" id="slide01" checked />
      <input type="radio" name="slide" id="slide02" />
      <input type="radio" name="slide" id="slide03" />
      <input type="radio" name="slide" id="slide04" />
      <ul class="slidelist">
        <li class="slideitem">
          <div>
            <a><img src="./images/slide1.png" /></a>
          </div>
        </li>
        <li class="slideitem">
          <div>
            <a><img src="./images/slide2.png" /></a>
          </div>
        </li>
        <li class="slideitem">
          <div>
            <a><img src="./images/slide3.png" /></a>
          </div>
        </li>
        <li class="slideitem">
          <div>
            <a><img src="./images/slide4.png" /></a>
          </div>
        </li>
      </ul>
    </div>

    <section id="infomation">
      <article id="info1">
        <img src="./선수제공파일/images/16.jpg" alt="">
        <p>Skills baseball park는 시민들의 복리증진을 위하여 설치되었으며,<br>시민들의 건강 및 복지향상과 시민들에게 편리한 시설물 이용을 위한 야구장입니다.</p>
      </article>

      <article id="info2">
        <img src="./선수제공파일/images/20.jpg" alt="">
        <p>야구를 사랑하며 즐기는 생활체육인들이 모이는 곳<br>다양한 즐거움과 감동을 선사하는 곳</p>
      </article>

    </section>

    <article id="infoTitle">
      <p>Skills baseball park</p>
      <a href="infomation">Infomation</a>
    </article>

    <hr style="margin: 150px 0px 150px 0px;">

    <section id="gameSchedule">
      <article id="todayGame">
        <h1>금일 게임 현황</h1>
        <article id="gamePoint">
          <div id="todayGame1">
            <img src="./선수제공파일/images/01.jpg" alt="">
            <p>5</p>
          </div>
          <div id="todayGame2">
            <p>:</p>
          </div>
          <div id="todayGame3">
            <img src="./선수제공파일/images/01.jpg" alt="">
            <p>4</p>
          </div>
        </article>
      </article>

      <hr>

      <article id="gameTable">
        <table id="scheduleTable">
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
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
          </tr>
          <tr>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td class="today">10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
          </tr>
          <tr>
            <td>14</td>
            <td>15</td>
            <td>16</td>
            <td>17</td>
            <td>18</td>
            <td>19</td>
            <td class="game"><a href="#modal">20</a></td>
          </tr>
          <tr>
            <td>21</td>
            <td>22</td>
            <td>23</td>
            <td>24</td>
            <td>25</td>
            <td>26</td>
            <td>27</td>
          </tr>
          <tr>
            <td>28</td>
            <td>29</td>
            <td>30</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </article>

      <div id="modal">
        <div id="modal_container">
          <img src="./images/야구장픽토그램.JPG" alt="">
          <div id="modal_header">
            <h1>4월 20일</h1>
          </div>
          <hr>
          <div id="modal_body">
            <p>아직 게임이 없습니다.</p>
          </div>
          <a href="#game_schedule_table"><button id="modal_close">닫기</button></a>
        </div>
      </div>
    </section>

    <hr>

    <section id="ranking">
      <div id="ranking_menu">
        <a href="#night_league">나이트리그</a>
        <div id="night_league">
          <ul>
            <li><a href="#night_league_pitcher">나이트리그 투수순위</a></li>
            <li><a href="#night_league_hitter">나이트리그 타자순위</a></li>
            <hr>
          </ul>
        </div>
        <a href="#weekend_league">주말리그</a>
        <div id="weekend_league">
          <ul>
            <li><a href="#weekend_league_pitcher">주말리그 투수순위</a></li>
            <li><a href="#weekend_league_hitter">주말리그 타자순위</a></li>
            <hr>
          </ul>
        </div>
        <a href="#dawn_league">새벽리그</a>
        <div id="dawn_league">
          <ul>
            <li><a href="#dawn_league_pitcher">새벽리그 투수순위</a></li>
            <li><a href="#dawn_league_hitter">새벽리그 타자순위</a></li>
            <hr>
          </ul>
        </div>
      </div>
      </div>
      <div id="league_details">
        <div id="night_league_pitcher">
          <p>나이트리그 - 투수 순위</p>
          <ul>
            <li>1. 나일투</li>
            <li>2. 나이투</li>
            <li>3. 나삼투</li>
            <li>4. 나사투</li>
            <li>5. 나오투</li>
            <li>6. 나육투</li>
            <li>7. 나칠투</li>
          </ul>
        </div>
        <div id="night_league_hitter">
          <p>나이트리그 - 타자 순위</p>
          <ul>
            <li>1. 나일타</li>
            <li>2. 나이타</li>
            <li>3. 나삼타</li>
            <li>4. 나사타</li>
            <li>5. 나오타</li>
            <li>6. 나육타</li>
            <li>7. 나칠타</li>
          </ul>
        </div>

        <div id="weekend_league_pitcher">
          <p>주말리그 - 투수 순위</p>
          <ul>
            <li>1. 주일투</li>
            <li>2. 주이투</li>
            <li>3. 주삼투</li>
            <li>4. 주사투</li>
            <li>5. 주오투</li>
            <li>6. 주육투</li>
            <li>7. 주칠투</li>
          </ul>
        </div>
        <div id="weekend_league_hitter">
          <p>주말리그 - 타자 순위</p>
          <ul>
            <li>1. 주일타</li>
            <li>2. 주이타</li>
            <li>3. 주삼타</li>
            <li>4. 주사타</li>
            <li>5. 주오타</li>
            <li>6. 주육타</li>
            <li>7. 주칠타</li>
          </ul>
        </div>

        <div id="dawn_league_pitcher">
          <p>새벽리그 - 투수 순위</p>
          <ul>
            <li>1. 새일투</li>
            <li>2. 새이투</li>
            <li>3. 새삼투</li>
            <li>4. 새사투</li>
            <li>5. 새오투</li>
            <li>6. 새육투</li>
            <li>7. 새칠투</li>
          </ul>
        </div>
        <div id="dawn_league_hitter">
          <p>새벽리그 - 타자 순위</p>
          <ul>
            <li>1. 새일타</li>
            <li>2. 새이타</li>
            <li>3. 새삼타</li>
            <li>4. 새사타</li>
            <li>5. 새오타</li>
            <li>6. 새육타</li>
            <li>7. 새칠타</li>
          </ul>
        </div>
      </div>
      <div id="league_top">
        <div id="batting">
          <p><a href="#batting">타율 Top 5</a></p>
          <ul>
            <li>1. 일타율</li>
            <li>2. 이타율</li>
            <li>3. 삼타율</li>
            <li>4. 사타율</li>
            <li>5. 오타율</li>
          </ul>
        </div>

        <div id="homer">
          <p><a href="#homer">홈런 Top 5</a></p>
          <ul>
            <li>1. 일홈런</li>
            <li>2. 이홈런</li>
            <li>3. 삼홈런</li>
            <li>4. 사홈런</li>
            <li>5. 오홈런</li>
          </ul>
        </div>
        <div id="multiple_win">
          <p><a href="#multiple_win">다승 Top 5</a></p>
          <ul>
            <li>1. 일다승</li>
            <li>2. 이다승</li>
            <li>3. 삼다승</li>
            <li>4. 사다승</li>
            <li>5. 오다승</li>
          </ul>
        </div>
        <div id="earned_run_average">
          <p><a href="#earned_run_average">평균자책 Top 5</a></p>
          <ul>
            <li>1. 일평자</li>
            <li>2. 이평자</li>
            <li>3. 삼평자</li>
            <li>4. 사평자</li>
            <li>5. 오평자</li>
          </ul>
        </div>
        <div id="strikeout">
          <p><a href="#strikeout">탈삼진 Top 5</a></p>
          <ul>
            <li>1. 일삼진</li>
            <li>2. 이삼진</li>
            <li>3. 삼삼진</li>
            <li>4. 사삼진</li>
            <li>5. 오삼진</li>
          </ul>
        </div>
        <div id="save">
          <p><a href="#save">세이브 Top 5</a></p>
          <ul>
            <li>1. 일세이</li>
            <li>2. 이세이</li>
            <li>3. 삼세이</li>
            <li>4. 사세이</li>
            <li>5. 오세이</li>
          </ul>
        </div>
    </section>

    <hr>

    <section id="gallery">
      <article id="slide1">

        <a href="#slide1">이전</a>

        <article class="slideImgs" id="slideImg1">
          <img class="leftImg" src="./images/slide.JPG" alt="">
        </article>

        <article class="slideImgs" id="slideImg2">
          <img class="centerImg" src="./선수제공파일/images/34.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>1번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg3">
          <img class="rightImg" src="./선수제공파일/images/35.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>2번째 이미지</p>
          </article>
        </article>

        <a href="#slide2">다음</a>

      </article>

      <article class="slides" id="slide2">

        <a href="#slide1">이전</a>

        <article class="slideImgs" id="slideImg4">
          <img class="leftImg" src="./선수제공파일/images/34.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>1번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg5">
          <img class="centerImg" src="./선수제공파일/images/35.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>2번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg6">
          <img class="rightImg" src="./선수제공파일/images/36.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>3번째 이미지</p>
          </article>
        </article>

        <a href="#slide3">다음</a>

      </article>

      <article class="slides" id="slide3">

        <a href="#slide2">이전</a>

        <article class="slideImgs" id="slideImg7">
          <img class="leftImg" src="./선수제공파일/images/35.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>2번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg8">
          <img class="centerImg" src="./선수제공파일/images/36.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>3번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg9">
          <img class="rightImg" src="./선수제공파일/images/37.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>4번째 이미지</p>
          </article>
        </article>

        <a href="#slide4">다음</a>

      </article>

      <article class="slides" id="slide4">

        <a href="#slide3">이전</a>

        <article class="slideImgs" id="slideImg10">
          <img class="leftImg" src="./선수제공파일/images/36.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>3번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg11">
          <img class="centerImg" src="./선수제공파일/images/37.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>4번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg12">
          <img class="rightImg" src="./선수제공파일/images/38.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>5번째 이미지</p>
          </article>
        </article>

        <a href="#slide5">다음</a>

      </article>

      <article class="slides" id="slide5">

        <a href="#slide4">이전</a>

        <article class="slideImgs" id="slideImg13">
          <img class="leftImg" src="./선수제공파일/images/37.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>4번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg14">
          <img class="centerImg" src="./선수제공파일/images/38.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>5번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg15">
          <img class="rightImg" src="./선수제공파일/images/39.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>6번째 이미지</p>
          </article>
        </article>

        <a href="#slide6">다음</a>

      </article>

      <article class="slides" id="slide6">

        <a href="#slide5">이전</a>

        <article class="slideImgs" id="slideImg16">
          <img class="leftImg" src="./선수제공파일/images/38.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>5번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg17">
          <img class="centerImg" src="./선수제공파일/images/39.jpg" alt="">
          <article class="more">
            <button>more</button>
            <p>6번째 이미지</p>
          </article>
        </article>

        <article class="slideImgs" id="slideImg18">
          <img class="rightImg" src="./선수제공파일/images/34.jpg" alt="">
        </article>

        <a href="#slide1">다음</a>

      </article>
    </section>

    <hr>

    <section id="mainGoods">
      <img id="goodsImage" src="./선수제공파일/images/42.jpg" alt="">
      <img src="./선수제공파일/images/43.jpg" alt=""><br>
      <img src="./선수제공파일/images/40.jpg" alt="">
      <img src="./선수제공파일/images/44.jpg" alt="">
    </section>
  </section>

  <?php include("./components/footer.php")?>

</body>

</html>