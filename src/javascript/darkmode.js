let colorSchemeQueryList = window.matchMedia('(prefers-color-scheme: dark)');

const setColorScheme = e =>
{
	var dmTextArray = document.getElementsByName("dmText");
	
	if (e.matches)
	{
		console.log('Dark mode')
		
		document.getElementById('dmStylesheet').href =
			"css/bootstrap-dark.min.css";
		document.getElementById('dmLogo').src =
			"images/logo-100-white.webp";
		
		for (var i = 0; i < dmTextArray.length; i++)
		{
			dmTextArray[i].classList.remove("text-dark");
			dmTextArray[i].classList.add("text-light");
		}
	}
	else
	{
		console.log('Light mode')
		
		document.getElementById('dmStylesheet').href = "css/bootstrap.min.css";
		document.getElementById('dmLogo').src = "images/logo-100-black.webp";
		
		for (var i = 0; i < dmTextArray.length; i++)
		{
			dmTextArray[i].classList.remove("text-light");
			dmTextArray[i].classList.add("text-dark");
		}
	}
}

setColorScheme(colorSchemeQueryList);
colorSchemeQueryList.addListener(setColorScheme);
