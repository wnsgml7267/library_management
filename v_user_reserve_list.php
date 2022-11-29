<?php
  include_once('sessionChk.php')
?>
<?php
// DB 연동
require_once('../scure/db.php');
$conn = db_get_pdo();

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <!--Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
    crossorigin="anonymous">
    <title></title>
  </head>
  <body>
    <div class="container">
      <h2 class="text-center">예약도서목록</h2>
      <table class="table table-bordered text-center">
        <thead>
          <th>ISBN</th>
          <th>제목</th>
          <th>저자</th>
          <th>출판사</th>
          <th>출판년도</th>
          <th>예약일</th>
          <th>대기순번</th>
          <th>예약취소</th>
          <th>대출하기</th>
        </thead>
        <tbody>
          <?php
            // 회원의 예약도서목록을 출력하는 쿼리
            $stmt = $conn -> prepare("SELECT R.ISBN ISBN, E.CNO CNO, E.TITLE TITLE, LISTAGG(A.AUTHOR, ',') WITHIN GROUP(ORDER BY A.AUTHOR) AS AUTHORS,
E.PUBLISHER PUBLISHER, EXTRACT(YEAR FROM E.YEAR) YEAR, R.DATETIME
FROM RESERVE R, EBOOK E, AUTHORS A
WHERE R.CNO = {$_SESSION['user_id']} AND R.ISBN = E.ISBN AND R.ISBN = A.ISBN
group by R.ISBN, E.TITLE, E.CNO, E.PUBLISHER, EXTRACT(YEAR FROM E.YEAR), E.YEAR, R.ISBN, R.DATETIME");
            $stmt -> execute();
            while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
          ?>
              <tr>
                <td><?=$row['ISBN']?></td>
                <td><?=$row['TITLE']?></td>
                <td><?=$row['AUTHORS']?></td>
                <td><?=$row['PUBLISHER']?></td>
                <td><?=$row['YEAR']?></td>
                <td><?=$row['DATETIME']?></td>
                <!--대기순번 가져오기-->
                <?php
                  $stmt2 = $conn -> prepare("SELECT RANK
FROM (SELECT CNO, RANK() OVER (ORDER BY DATETIME) RANK FROM RESERVE WHERE ISBN = {$row['ISBN']})
WHERE CNO = {$_SESSION['user_id']}");
                  $stmt2 -> execute();
                  $row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
                ?>
                <td><?=$row2['RANK']?></td>
                <!--예약취소버튼-->
                <?php echo "<td><a href=\"user_process_reserve_cancel.php?isbn={$row['ISBN']}\">취소</a></td>";
                // 대기순번이 1이고 대출자가 없는 상태이면 대출버튼 활성화
                if ($row2['RANK'] == 1 && is_null($row['CNO'])) {
                  echo "<td><a href=\"user_process_rent_reserved.php?isbn={$row['ISBN']}\">대출</a></td>";
                }else{
                  echo "<td></td>";
                }
                ?>
              </tr>
          <?php
            }
          ?>
        </tbody>
      </table>
  </body>
</html>
