<?php
$Guides = array
  (
  	/*	   file name     title */
    array("Basics", "Basics"),
    array("ClassesAndBuilds", "Classes & Builds")
  );

$count = 0;

?>

<div id="MainElement">
<p>Not finished yet</p>
<h1>Guides:</h1>

<ul id="GuideNav" class="nav nav-pills" style="margin-left: auto; margin-right: auto; margin-bottom: 20px;">

<?php
foreach ($Guides as $Guide)
{
	if ($count == 0) {
		?>
		<li onClick="loadGuide('<?php echo $Guide[0]. ".php"; ?>'); $('.active').removeClass('active'); $(this).addClass('active');" class="active"><a href="#"> <?php echo $Guide[1]; ?></a></li>
		<?php
	}
	else {
		?>
		<li onClick="loadGuide('<?php echo $Guide[0]. ".php"; ?>'); $('.active').removeClass('active'); $(this).addClass('active');"><a href="#"> <?php echo $Guide[1]; ?></a></li>
		<?php
	}
	$count++;
}
?>
</ul>

<div id="GuideContainer">

</div>

</div>

<script>
$(document).ready(function() {
	$("#GuideNav").click(function() {
		$(".active").removeClass('active');
		$(this).addClass('active');
	});
});
</script>