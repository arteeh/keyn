let colorSchemeQueryList = window.matchMedia('(prefers-color-scheme: dark)');

const setColorScheme = e =>
{
	var navtexts = document.getElementsByName("navtext");
	
	if (e.matches)
	{
		console.log('Dark mode')
		document.getElementById('stylesheet').href = "css/bootstrap-dark.min.css";
		document.getElementById('logo').src = "images/logo-400-white.png";
		for (var i = 0; i<navtexts.length; i++)
		{
			navtexts[i].classList.remove("text-dark");
			navtexts[i].classList.add("text-light");
		}
	}
	else
	{
		console.log('Light mode')
		document.getElementById('stylesheet').href = "css/bootstrap.min.css";
		document.getElementById('logo').src = "images/logo-400.png";
		for (var i = 0; i<navtexts.length; i++)
		{
			navtexts[i].classList.remove("text-light");
			navtexts[i].classList.add("text-dark");
		}
	}
}

setColorScheme(colorSchemeQueryList);
colorSchemeQueryList.addListener(setColorScheme);
