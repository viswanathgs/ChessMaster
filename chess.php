<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;

  /*
    W - White
    B - Black
    R - Rook
    N - Knight
    B - Bishop
    K - King
    Q - Queen
    P - Pawn
  */
  function getInitialBoard() {
    $board=array();
    $boardindex=array("A","B","C","D","E","F","G","H");

    foreach($boardindex as $i) {
      $board[$i]=array("","","","","","","","","");
    }

    $board['A'][1]="WR";
    $board['B'][1]="WN";
    $board['C'][1]="WB";
    $board['D'][1]="WQ";
    $board['E'][1]="WK";
    $board['F'][1]="WB";
    $board['G'][1]="WN";
    $board['H'][1]="WR";

    $board['A'][2]="WP";
    $board['B'][2]="WP";
    $board['C'][2]="WP";
    $board['D'][2]="WP";
    $board['E'][2]="WP";
    $board['F'][2]="WP";
    $board['G'][2]="WP";
    $board['H'][2]="WP";

    $board['A'][7]="BP";
    $board['B'][7]="BP";
    $board['C'][7]="BP";
    $board['D'][7]="BP";
    $board['E'][7]="BP";
    $board['F'][7]="BP";
    $board['G'][7]="BP";
    $board['H'][7]="BP";

    $board['A'][8]="BR";
    $board['B'][8]="BN";
    $board['C'][8]="BB";
    $board['D'][8]="BQ";
    $board['E'][8]="BK";
    $board['F'][8]="BB";
    $board['G'][8]="BN";
    $board['H'][8]="BR";

    return $board;
  }

  /*
    Inner delimiter - dot(.)
    Outerdelimieter - comma(,)
  */
  function implodeBoard($board) {
    $boardouter=array();
    $boardindex=array("A","B","C","D","E","F","G","H");

    foreach($boardindex as $i) {
      $boardouter[]=implode('.',$board[$i]);
    }

    return implode(',',$boardouter);
  }

  function explodeBoard($boardtext) {
    $boardouter=explode(',',$boardtext);
    $boardindex=array("A","B","C","D","E","F","G","H");
    
    $board=array();
    for($i=0;$i<8;$i++) {
      $board[$boardindex[$i]]=explode('.',$boardouter[$i]);
    }

    return $board;
  }
?>