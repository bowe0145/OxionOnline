<?php
$Slider_Images = array();

$Slider_Images[0] = "Slide6";
$Slider_Images[1] = "Slide7";
$Slider_Images[2] = "Slide8";
$Slider_Images[3] = "Slide9";
$Slider_Images[4] = "Slide10";

for ($i = 0; $i < count($Slider_Images); $i++)
{
  $Slider_Images[$i] = "../Assets/img/Slideshow/" . $Slider_Images[$i] . ".png";
}
?>

<div id="carousel">
  <ul>
    <?php
    for ($i = 0; $i < count($Slider_Images); $i++)
    {
      if ($i == 0)
      {
        echo "\t<li class='slide active-slide'><img class='slideImg' src='".$Slider_Images[$i]."'></img></li>\n";
      }
      else
      {
        echo "\t<li class='slide'><img class='slideImg' src='".$Slider_Images[$i]."'></img></li>\n";
      }
    }
    ?>
  </ul>
  <div id="carousel-bottom">
    <div class="bottom_buttons">
      <img class="arrow-prev" src="../Assets/img/Slideshow/previous.png"></img>
      <div class="dotHolder">
      </div>
      <img class="arrow-next" src="../Assets/img/Slideshow/next.png"></img>
    </div>
  </div>
</div>