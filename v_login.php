<!-- <?php
  session_start();
  session_destroy();
?> -->
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>로그인</title>
    <link rel="stylesheet" type="text/css" href="/css/login.css">
  </head>
  <body width="100%" height="100%">
    <!-- 로그인 입력내용 전달폼(POST 방식) -->
    <form action="loginChk.php" method="post" class="loginForm">
        <h1>LOGIN</h1>
        <div class="idForm">
          <!-- 회원번호 입력란 -->
          <input type="text" class="id" name="user_id" placeholder="회원번호" maxlength="5" style="width: 150;">
        </div>
        <div class="passForm">
          <!-- 패스워드 입력란 -->
          <input type="password" class="password" name="user_pw" placeholder="패스워드" maxlength="10" style="width: 150;">
        </div>
          <!-- 로그인 버튼 -->
        <input type="submit" value="로그인" class="btn">
        <div class="bottomText">
          <a href="#">아이디/비밀번호 찾기</a>  <a href="#">회원 가입</a>
        </div>          
    </form>
  </body>
</html>
