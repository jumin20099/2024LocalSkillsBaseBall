<header>
    <article id="leftArticle">
        <ul>
            <li><a href="/"><img src="./logo.PNG"></a></li>
            <li><a href="information">Information</a></li>
            <li><a href="statistics">Statistics</a></li>
            <li><a href="reservation">Reservation</a></li>
            <li><a href="goods">Goods</a></li>
        </ul>
    </article>
    <article id="rightArticle">
        <ul>
            <?php
            if (isset ($_SESSION["user_idx"])) {
                echo "<li class='logout'><a id='logout' href='logout'>로그아웃</a></li>";
                echo "<li><a href='signup'>회원가입</a></li>";
            } else {
                echo "
                <li><a href='signin'>로그인</a></li>
                <li><a href='signup'>회원가입</a></li>";
            }
            ?>
        </ul>
    </article>
</header>