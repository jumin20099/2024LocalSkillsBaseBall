<header>
    <article id="leftArticle">
        <ul>
            <li><a href="/"><img src="./logo.PNG"></a></li>
            <li><a style="color: #FCF6F5;" href="information">Information</a></li>
            <li><a style="color: #FCF6F5;" href="statistics">Statistics</a></li>
            <li><a style="color: #FCF6F5;" href="reservation">Reservation</a></li>
            <li><a style="color: #FCF6F5;" href="goods">Goods</a></li>
        </ul>
    </article>
    <article id="rightArticle">
        <ul>
            <?php
            if (isset ($_SESSION["user_idx"])) {
                echo "<li class='logout'><a style='color: #FCF6F5;' id='logout' href='logout'>로그아웃</a></li>";
                echo "<li><a style='color: #FCF6F5;' href='mypage'>마이페이지</a></li>";
            } else {
                echo "
                <li><a style='color: #FCF6F5;' href='signin'>로그인</a></li>
                <li><a style='color: #FCF6F5;' href='signup'>회원가입</a></li>";
            }
            ?>
        </ul>
    </article>
</header>