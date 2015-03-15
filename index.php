<html>
	<body>
		<script type="text/javascript">
			var seasons = <?php 
				require_once "scrapeSimpsons.php";
			?>;

			var randSeason = getRandElem(seasons);
			var randEpisode = getRandElem(randSeason["episodes"]);
			window.location.href = randEpisode["link"];

			function getRandElem(items){
				return items[Math.floor(Math.random()*items.length)];
			}
		</script>
		Sorry, something went wrong.
	</body>
</html>