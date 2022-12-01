<link rel="stylesheet" href="/css/top_user.css"/>
<nav>
    <div class="inner">
      <div class="nav-container">
        <h1 class="nav-title">
          <form method="post" action="/" class="nav-item">
            <input type = "submit" value = "home" class="nav-item" name = "" style="background-color:#aad7f5"/>
          </form>
        </h1>
        <li><a class="nav-item" href="v_user_main.php?id=ebook" >도서검색</a></li>
        <li><a class="nav-item" href="v_user_main.php?id=rent_list">대출목록조회</a></li>
        <li><a class="nav-item" href="v_user_main.php?id=reserve_list">예약목록조회</a></li>
        <form></form>
        <form></form>
        <?php echo "Name: {$_SESSION['user_name']}"; ?>
        <!--<?php echo "Name: dlwnsgml"; ?>-->
        <input type="button" name="logout_bt" value="로그아웃"
          onclick="location.href='v_login.php'">

      </div>
    </div>
  </nav>

