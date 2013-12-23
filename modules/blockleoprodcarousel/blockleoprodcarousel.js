function showAll(){
	var categoriesprodtabs = document.getElementById('categoriesprodtabs');
	var clipart = document.getElementById('clipart');
	clipart.style.display = 'none';
	categoriesprodtabs.removeClass('span9');
	categoriesprodtabs.addClass('span12');
}
(function closeHideClipart(){
	alert('here');
	document.getElementById('hideclipart').addEventListener('click',showAll);
})();
