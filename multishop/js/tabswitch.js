
function area_update(index){
for(var i=1;i<=2;i++)
{
	if( document.getElementById("update"+i.toString()) != null )
	{
		document.getElementById("update"+i.toString()).style.display = 'none';	
	}
}
	document.getElementById("update"+index.toString()).style.display = 'block';
}
function area_menuitem(index){
for(var i=1;i<=3;i++)
{
	if( document.getElementById("menuitem"+i.toString()) != null )
	{
		document.getElementById("menuitem"+i.toString()).style.display = 'none';	
	}
}
	document.getElementById("menuitem"+index.toString()).style.display = 'block';
}


