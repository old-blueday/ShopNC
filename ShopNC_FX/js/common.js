function ReSizeImg(Img,width,height)
{
	var image=new Image();
	image.src=Img.src;
	if(image.width>width||image.height>height)
	{
		w=image.width/width;
		h=image.height/height;
		if(w>h)
		{
			Img.width=width;
			Img.height=image.height/w;
		}
		else
		{
			Img.height=height;
			Img.width=image.width/h;
		}
	}
}

