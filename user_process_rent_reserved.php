<?php
  session_start();
  include_once('sessionChk.php');

  // DB 연동
  require_once('../scure/db.php');
  $conn = db_get_pdo();

  // 현재 대출도서 수 확인
  $stmt = $conn -> prepare("SELECT COUNT(CNO) RENT_COUNT FROM EBOOK WHERE CNO = {$_SESSION['user_id']}");
  $stmt -> execute();
  $row = $stmt -> fetch(PDO::FETCH_ASSOC);
  echo $row['RENT_COUNT'];

  // 이미 대출중인 도서인지 확인
  $stmt0 = $conn -> prepare("SELECT CNO FROM EBOOK WHERE ISBN = {$_GET['isbn']}");
  $stmt0 -> execute();
  $row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);
  if (isset($row0['CNO'])){
    echo "<script>alert('이미 대출중인 도서입니다.');";
    echo "window.location.replace('v_user_main.php?id=ebook');</script>";
    exit;
  }
  
  if($row['RENT_COUNT'] >= 3) {  // 이미 3권이상 대출중인 경우
    echo "<script>alert('대출 가능한 최대 도서 수(3)를 초과하였습니다. 도서 반납 후 진행해주세요.');";
    echo "window.location.replace('v_user_main.php?id=ebook');</script>";
    exit;
  } else {
    // 대출 처리 - EBOOK 테이블 업데이트
    $stmt2 = $conn -> prepare("UPDATE EBOOK
      SET CNO = {$_SESSION['user_id']}, EXTTIMES = 0, DATERENTED = SYSDATE, DATEDUE = SYSDATE+11
      WHERE ISBN = {$_GET['isbn']}");
    $stmt2 -> execute();

    // 예약내역에서 삭제
    $stmt3 = $conn -> prepare("DELETE FROM RESERVE
      WHERE ISBN = {$_GET['isbn']} AND CNO = {$_SESSION['user_id']}");
    $stmt3 -> execute();

    // 대출 처리 - PREVIOUSRENTAL 테이블 업데이트
    // (isbn, 대출일, 반납일, cno)
    $stmt4 = $conn -> prepare("INSERT INTO PREVIOUSRENTAL
    VALUES ({$_GET['isbn']}, SYSDATE, '', {$_SESSION['user_id']})");
    $stmt4 -> execute();

    echo "<script>alert('대출되었습니다.');";
    echo "window.location.replace('v_user_main.php?id=rent_list');</script>";
  }
?>
