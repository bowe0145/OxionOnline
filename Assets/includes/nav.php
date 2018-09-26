<?php
$nav_items = array
  (
    array("../game_info/", "ginfo_Nav"),
    array("http://evictionstudios.org/forums/index.php", "forum_Nav"),
    array("../DaShop/", "iMall_Nav"),
    array("../download/", "download_Nav"),
    array("../UserCP/", "UCP_Nav"),
    array("../faq/index.php", "faq_Nav"),
    array("http://evictionstudios.org/forums/index.php?app=forums&module=extras&section=stats&do=leaders", "sTeam_Nav")
  );
?>

<div id="navbar-wrapper">
    <div class="navbar navbar-fixed-top" role="navigation">
      <div class="container" id="centered">
        <div class="navBar-background">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

<?php
foreach ($nav_items as $items)
{
  echo "\t    <li><a href='". $items[0] ."' class='". $items[1] ."'></a></li>\n";
}
?>

          </ul>
        </div>
      </div>
    </div>
    </div>
</div>	