function area_menu(index){
for(var i=1;i<=2;i++)
{
	if( document.getElementById("menu"+i.toString()) != null )
	{
		document.getElementById("menu"+i.toString()).style.display = 'none';	
	}
}
	document.getElementById("menu"+index.toString()).style.display = 'block';
}



