// 省市2级联动

var province;
var city = new Array();

province = new Array(
					 new Array("请选择",''),
					 new Array("北京市","01"),
					 new Array("上海市","02"),
					 new Array("天津市","03"),
					 new Array("重庆市","04"),
					 new Array("河北省","05"),
					 new Array("山西省","06"),
					 new Array("四川省","07"),
					 new Array("河南省","08"),
					 new Array("辽宁省","09"),
					 new Array("吉林省","10"),
					 new Array("黑龙江省","11"),
					 new Array("内蒙古","12"),
					 new Array("江苏省","13"),
					 new Array("山东省","14"),
					 new Array("安徽省","15"),
					 new Array("浙江省","16"),
					 new Array("福建省","17"),
					 new Array("湖北省","18"),
					 new Array("湖南省","19"),
					 new Array("海南省","20"),
					 new Array("广东省","21"),
					 new Array("江西省","22"),
					 new Array("贵州省","23"),
					 new Array("云南省","24"),
					 new Array("陕西省","25"),
					 new Array("甘肃省","26"),
					 new Array("广西","27"),
					 new Array("宁夏","28"),
					 new Array("青海省","29"),
					 new Array("新疆","30"),
					 new Array("西藏","31")
					 );

city[0] = new Array(
					 new Array("请选择",'')
					 );

city[1] = new Array(
					 new Array("昌平区","002"),
					 new Array("顺义区","003"),
					 new Array("通州区","004"),
					 new Array("密云县","005"),
					 new Array("延庆县","006"),
					 new Array("平谷区","007"),
					 new Array("大兴区","008"),
					 new Array("怀柔区","009"),
					 new Array("东城区","010"),
					 new Array("西城区","011"),
					 new Array("崇文区","012"),
					 new Array("宣武区","013"),
					 new Array("朝阳区","014"),
					 new Array("丰台区","015"),
					 new Array("石景山区","016"),
					 new Array("海淀区","017"),
					 new Array("门头沟区","018"),
					 new Array("房山区","019")
					 );

city[2] = new Array(
					 new Array("南汇区","002"),
					 new Array("奉贤区","003"),
					 new Array("青浦区","004"),
					 new Array("崇明县","005"),
					 new Array("黄浦区","006"),
					 new Array("南市区","007"),
					 new Array("卢湾区","008"),
					 new Array("徐汇区","009"),
					 new Array("长宁区","010"),
					 new Array("静安区","011"),
					 new Array("普陀区","012"),
					 new Array("虹口区","013"),
					 new Array("杨浦区","014"),
					 new Array("闵行区","015"),
					 new Array("宝山区","016"),
					 new Array("嘉定区","017"),
					 new Array("浦东新区","018"),
					 new Array("金山区","019"),
					 new Array("松江区","020"),
					 new Array("闸北区","021")
					 );
city[3] = new Array(
					 new Array("宁河县","002"),
					 new Array("武清区","003"),
					 new Array("静海县","004"),
					 new Array("宝坻区","005"),
					 new Array("蓟县","006"),
					 new Array("塘沽区","007"),
					 new Array("和平区","008"),
					 new Array("河东区","009"),
					 new Array("河西区","010"),
					 new Array("南开区","011"),
					 new Array("河北区","012"),
					 new Array("红桥区","013"),
					 new Array("汉沽区","014"),
					 new Array("大港区","015"),
					 new Array("东丽区","016"),
					 new Array("西青区","017"),
					 new Array("津南区","018"),
					 new Array("北辰区","019")
					 );
city[4] = new Array(
					 new Array("渝中区","002"),
					 new Array("大渡口区","003"),
					 new Array("江北区","004"),
					 new Array("沙坪坝区","005"),
					 new Array("九龙坡区","006"),
					 new Array("南岸区","007"),
					 new Array("北碚区","008"),
					 new Array("万盛区","009"),
					 new Array("双桥区","010"),
					 new Array("渝北区","011"),
					 new Array("巴南区","012"),
					 new Array("万州区","013"),
					 new Array("涪陵区","014"),
					 new Array("黔江区","015"),
					 new Array("长寿区","016"),
					 new Array("江津区","017"),
					 new Array("合川区","018"),
					 new Array("永川区","019"),
					 new Array("南川区","020"),
					 new Array("綦江县","021"),
					 new Array("潼南县","022"),
					 new Array("铜梁县","023"),
					 new Array("大足县","024"),
					 new Array("荣昌县","025"),
					 new Array("璧山县","026"),
					 new Array("梁平县","027"),
					 new Array("大度口区","028"),
					 new Array("城口县","029"),
					 new Array("丰都县","030"),
					 new Array("垫江县","031"),
					 new Array("武隆县","032"),
					 new Array("北碚区","033"),
					 new Array("忠　县","034"),
					 new Array("双桥区","035"),
					 new Array("开　县","036"),
					 new Array("巴南区","037"),
					 new Array("云阳县","038"),
					 new Array("石柱土家族自治县","039"),
					 new Array("彭水苗族土家族自治县","040"),
					 new Array("酉阳土家族苗族自治县","041"),
					 new Array("秀山土家族苗族自治县","042"),
					 new Array("奉节县","043"),
					 new Array("巫山县","044"),
					 new Array("巫溪县","045")
					 );
city[5] = new Array(
					 new Array("石家庄市","001"),
					 new Array("保定市","002"),
					 new Array("张家口市","003"),
					 new Array("承德市","004"),
					 new Array("唐山市","005"),
					 new Array("廊坊市","006"),
					 new Array("沧州市","007"),
					 new Array("衡水市","008"),
					 new Array("邢台市","009"),
					 new Array("邯郸市","010"),
					 new Array("秦皇岛市","011")				
					 );
city[6] = new Array(
					 new Array("太原市","001"),
					 new Array("大同市","002"),
					 new Array("阳泉市","003"),
					 new Array("吕梁地区","004"),					 
					 new Array("长治市","005"),
					 new Array("晋城市","006"),
					 new Array("朔州市","007"),
					 new Array("晋中市","008"),
					 new Array("运城市","009"),
					 new Array("忻州市","010"),
					 new Array("临汾市","011"),
					 new Array("吕梁市","012")
					 );
city[7] = new Array(
					 new Array("成都市","001"),
					 new Array("自贡市","002"),
					 new Array("攀枝花市","003"),
					 new Array("泸州市","004"),
					 new Array("德阳市","005"),
					 new Array("绵阳市","006"),
					 new Array("广元市","007"),
					 new Array("遂宁市","008"),
					 new Array("内江市","009"),
					 new Array("乐山市","010"),
					 new Array("南充市","011"),
					 new Array("宜宾市","012"),
					 new Array("广安市","013"),
					 new Array("达州市","014"),
					 new Array("眉山市","015"),
					 new Array("雅安市","016"),
					 new Array("巴中市","017"),
					 new Array("资阳市","018"),
					 new Array("阿坝州","019"),
					 new Array("甘孜州","020"),
					 new Array("凉山州","021")
					 );
city[8] = new Array(
					 new Array("郑州市","001"),
					 new Array("开封市","002"),
					 new Array("洛阳市","003"),
					 new Array("平顶山市","004"),
					 new Array("焦作市","005"),
					 new Array("鹤壁市","006"),
					 new Array("新乡市","007"),
					 new Array("安阳市","008"),
					 new Array("濮阳市","009"),
					 new Array("许昌市","010"),
					 new Array("漯河市","011"),
					 new Array("三门峡市","012"),
					 new Array("南阳市","013"),
					 new Array("商丘市","014"),
					 new Array("信阳市","015"),
					 new Array("周口市","016"),
					 new Array("驻马店市","017")					 
					 );
city[9] = new Array(
					 new Array("沈阳市","001"),
					 new Array("大连市","002"),
					 new Array("葫芦岛市","003"),
					 new Array("鞍山市","004"),
					 new Array("抚顺市","005"),
					 new Array("本溪市","006"),
					 new Array("丹东市","007"),
					 new Array("锦州市","008"),
					 new Array("营口市","009"),
					 new Array("阜新市","010"),
					 new Array("辽阳市","011"),
					 new Array("铁岭市","012"),
					 new Array("盘锦市","013"),
					 new Array("朝阳市","014")					 
					 );
city[10] = new Array(
					  new Array("长春市","001"),
					  new Array("吉林市","002"),
					  new Array("延边州","003"),
					  new Array("四平市","004"),
					  new Array("通化市","005"),
					  new Array("白城市","006"),
					  new Array("辽源市","007"),
					  new Array("白山市","008"),
					  new Array("延边朝鲜族自治州","009")
					  );
city[11] = new Array(
					  new Array("哈尔滨市","001"),
					  new Array("齐齐哈尔","002"),
					  new Array("牡丹江市","003"),
					  new Array("佳木斯市","004"),
					  new Array("黑河市","005"),
					  new Array("鹤岗市","006"),
					  new Array("伊春市","007"),
					  new Array("鸡西市","008"),
					  new Array("大庆市","009"),
					  new Array("双鸭山市","010"),
					  new Array("七台河市","011"),
					  new Array("绥化市","012"),
					  new Array("大兴安岭地区","013")
					  );
city[12] = new Array(
					  new Array("呼和浩特市","001"),
					  new Array("乌海市","002"),
					  new Array("通辽市","003"),
					  new Array("赤峰市","004"),
					  new Array("包头市","005"),
					  new Array("鄂尔多斯市　","006"),
					  new Array("呼伦贝尔市 ","007"),
					  new Array("巴彦淖尔市","008"),
					  new Array("乌兰察布市","009"),
					  new Array("兴　安　盟","010"),
					  new Array("锡林郭勒盟","011"),
					  new Array("阿拉善盟","012")
					 );
city[13] = new Array(
					  new Array("南京市","001"),
					  new Array("无锡市","002"),
					  new Array("徐州市","003"),
					  new Array("常州市","004"),
					  new Array("苏州市","005"),
					  new Array("南通市","006"),
					  new Array("连云港","007"),
					  new Array("淮安市","008"),
					  new Array("盐城市","009"),
					  new Array("扬州市","010"),
					  new Array("镇江市","011"),
					  new Array("宿迁市","012"),
					  new Array("泰州市","013")
					  );
city[14] = new Array(
					  new Array("济南市","001"),
					  new Array("青岛市","002"),
					  new Array("淄博市","003"),
					  new Array("枣庄市","004"),
					  new Array("东营市","005"),
					  new Array("烟台市","006"),
					  new Array("潍坊市","007"),
					  new Array("威海市","008"),
					  new Array("济宁市","009"),
					  new Array("泰安市","010"),
					  new Array("日照市","011"),
					  new Array("莱芜市","012"),
					  new Array("临沂市","013"),
					  new Array("德州市","014"),
					  new Array("聊城市","015"),
					  new Array("滨州市","016"),
					  new Array("荷泽市","017")
					  );
city[15] = new Array(
					  new Array("合肥市","001"),
					  new Array("蚌埠市","002"),
					  new Array("芜湖市","003"),
					  new Array("淮南市","004"),
					  new Array("马鞍山市","005"),
					  new Array("淮北市","006"),
					  new Array("铜陵市","007"),
					  new Array("安庆市","008"),
					  new Array("黄山市","009"),
					  new Array("滁州市","010"),
					  new Array("阜阳市","011"),
					  new Array("宿州市","012"),
					  new Array("巢湖市","013"),
					  new Array("六安市","014"),
					  new Array("亳州市","015"),
					  new Array("池州市","016"),
					  new Array("宣城市","017")
					  );
city[16] = new Array(
					  new Array("杭州市","001"),
					  new Array("湖州市","002"),
					  new Array("嘉兴市","003"),
					  new Array("宁波市","004"),
					  new Array("绍兴市","005"),
					  new Array("温州市","006"),
					  new Array("丽水市","007"),
					  new Array("金华市","008"),
					  new Array("衢州市","009"),
					  new Array("舟山市","010"),
					  new Array("台州市","011")
					  );
city[17] = new Array(
					  new Array("福州市","001"),
					  new Array("厦门市","002"),
					  new Array("三明市","003"),
					  new Array("莆田市","004"),
					  new Array("泉州市","005"),
					  new Array("漳州市","006"),
					  new Array("龙岩市","007"),
					  new Array("宁德市","008"),
					  new Array("南平市","009")
					  );
city[18] = new Array(
					  new Array("武汉市","001"),
					  new Array("襄樊市","002"),
					  new Array("黄石市","003"),
					  new Array("十堰市","004"),
					  new Array("荆州市","005"),
					  new Array("宜昌市","006"),
					  new Array("荆门市","007"),
					  new Array("鄂州市","008"),
					  new Array("孝感市","009"),
					  new Array("黄冈市","010"),
					  new Array("咸宁市","011"),
					  new Array("随州市","012"),
					  new Array("恩施州","013")
					  );
city[19] = new Array(
					  new Array("长沙市","001"),
					  new Array("湘潭市","002"),
					  new Array("邵阳市","003"),
					  new Array("衡阳市","004"),
					  new Array("郴州市","005"),
					  new Array("岳阳市","006"),
					  new Array("常德市","007"),
					  new Array("张家界市","008"),
					  new Array("益阳市","009"),
					  new Array("郴州市","010"),
					  new Array("永州市","011"),
					  new Array("怀化市","012"),
					  new Array("娄底市","013"),
					  new Array("湘西州","014")
					  );
city[20] = new Array(
					  new Array("海口市","001"),
					  new Array("三亚市","002")
					  );
city[21] = new Array(
					  new Array("广州市","001"),
					  new Array("深圳市","002"),
					  new Array("珠海市","003"),
					  new Array("汕头市","004"),
					  new Array("韶关市","005"),
					  new Array("佛山市","006"),
					  new Array("江门市","007"),
					  new Array("湛江市","008"),
					  new Array("茂名市","009"),
					  new Array("肇庆市","010"),
					  new Array("惠州市","011"),
					  new Array("梅州市","012"),
					  new Array("汕尾市","013"),
					  new Array("河源市","014"),
					  new Array("阳江市","015"),
					  new Array("清远市","016"),
					  new Array("东莞市","017"),
					  new Array("中山市","018"),
					  new Array("潮州市","019"),
					  new Array("揭阳市","020"),
					  new Array("云浮市","021")
					  );
city[22] = new Array(
					  new Array("南昌市","001"),
					  new Array("景德镇市","002"),
					  new Array("萍乡市","003"),
					  new Array("九江市","004"),
					  new Array("新余市","005"),
					  new Array("鹰潭市","006"),
					  new Array("赣州市","007"),
					  new Array("吉安市","008"),
					  new Array("宜春市","009"),
					  new Array("抚州市","010"),
					  new Array("上饶市","011")
					  );
city[23] = new Array(
					  new Array("贵阳市","001"),
					  new Array("遵义市","002"),
					  new Array("安顺市","003"),
					  new Array("铜仁市","004"),
					  new Array("六盘水市","005"),
					  new Array("黔西南布依族","006"),
					  new Array("黔东南布依族","007"),
					  new Array("黔南布依族","008"),
					  new Array("毕节市","009")
					  );
city[24] = new Array(
					  new Array("昆明市","001"),
					  new Array("曲靖市","002"),
					  new Array("玉溪市","003"),
					  new Array("保山市","004"),
					  new Array("昭通市","005"),
					  new Array("丽江市","006"),
					  new Array("普洱市","007"),
					  new Array("临沧市","008"),
					  new Array("文山州","009"),
					  new Array("红河州","010"),
					  new Array("西双版纳州","011"),
					  new Array("楚　雄　州","012"),
					  new Array("大　理　州","013"),
					  new Array("德　宏　州","014"),
					  new Array("怒　江　州","015"),
					  new Array("迪　庆　州","016")
					  );
city[25] = new Array(
					  new Array("西安市","001"),
					  new Array("铜川市","002"),
					  new Array("宝鸡市","003"),
					  new Array("咸阳市","004"),
					  new Array("渭南市","005"),
					  new Array("延安市","006"),
					  new Array("汉中市","007"),
					  new Array("安康市","008"),
					  new Array("商洛市","009"),
					  new Array("榆林市","010")
					  );
city[26] = new Array(
					  new Array("兰州市","001"),
					  new Array("嘉峪关市","002"),
					  new Array("金昌市","003"),
					  new Array("白银市","004"),
					  new Array("天水市","005"),
					  new Array("武威市","006"),
					  new Array("张掖市","007"),
					  new Array("平凉市","008"),
					  new Array("酒泉市","009"),
					  new Array("庆阳市","010"),
					  new Array("定西市","011"),
					  new Array("陇南市","012"),
					  new Array("临夏州","013"),
					  new Array("甘南州","014")
					  );
city[27] = new Array(
					  new Array("南宁市","001"),
					  new Array("北海市","002"),
					  new Array("柳州市","003"),
					  new Array("桂林市","004"),
					  new Array("梧州市","005"),
					  new Array("防城港市","006"),
					  new Array("钦州市","007"),
					  new Array("贵港市","008"),
					  new Array("玉林市","009"),
					  new Array("百色市","010"),
					  new Array("贺州市","011"),
					  new Array("来宾市","012"),
					  new Array("河池市","013"),
					  new Array("崇左市","014")
					  );
city[28] = new Array(
					  new Array("银川市","001"),
					  new Array("石嘴山市","002"),
					  new Array("吴忠市","003"),
					  new Array("固原市","004"),
					  new Array("青铜峡市","005"),
					  new Array("灵武市","006"),
					  new Array("中宁市","007"),
					  new Array("盐池市","008"),
					  new Array("中卫市","009"),
					  new Array("贺兰市","010")
					  );
city[29] = new Array(
					  new Array("西宁市","001"),
					  new Array("海东地区","002"),
					  new Array("海东藏族自治区","003"),
					  new Array("黄南藏族自治区","004"),
					  new Array("海南藏族自治区","005"),
					  new Array("果洛藏族自治区","006"),
					  new Array("玉树藏族自治区","007"),
					  new Array("海西蒙古藏","008"),
					  new Array("平安县","009"),
					  new Array("同仁县","010"),
					  new Array("共和县","011"),
					  new Array("玛沁县","012"),
					  new Array("格尔木市","013"),
					  new Array("德令哈市","014"),
					  new Array("贵德市","015"),
					  new Array("茫崖市","016")
					  );
city[30] = new Array(
					  new Array("乌鲁木齐市","001"),
					  new Array("克拉玛依市","002"),
					  new Array("吐鲁番地区","003"),
					  new Array("哈密地区","004"),
					  new Array("和田地区","005"),
					  new Array("阿克苏地区","006"),
					  new Array("喀什地区","007"),
					  new Array("克孜勒苏柯尔克孜自治州","008"),
					  new Array("巴音郭楞蒙古自治州","009"),
					  new Array("昌吉回族自治州","010"),
					  new Array("博尔塔拉蒙古自治州","011"),
					  new Array("伊犁哈萨克自治州","012"),
					  new Array("塔城地区","013"),
					  new Array("阿勒泰地区","014")
					  );
city[31] = new Array(
					  new Array("拉萨市","001"),
					  new Array("昌都地区","002"),
					  new Array("山南地区","003"),
					  new Array("日喀则地区","004"),
					  new Array("那曲地区","005"),
					  new Array("阿里地区","006"),
					  new Array("林芝地区","007"),
					  new Array("日喀则市","008")
					  );	

var ifshowcode = 0;
var selectprovince = "";
var selectcity = "";

function iniProvince(ProvinceObj){
	ProvinceObj.length = province.length;
	for (i = 0; i < province.length; i++) {
		if (i==0)
			ProvinceObj.options[i].value = '';
		else
			ProvinceObj.options[i].value = province[i][0];
		ProvinceObj.options[i].text  = province[i][0];
		if (selectprovince==province[i][0]){
			ProvinceObj.selectedIndex = i;
		}
	}
	//ProvinceObj.selectedIndex = 0;
	

}

function iniCity(ProvinceObj,CityObj){
	var a = new Array();
	a = city[ProvinceObj.selectedIndex];
	CityObj.length = a.length;
	CityObj.selectedIndex = 0;
	for (i = 0; i < a.length; i++) {
		//if (i==0)
			//CityObj.options[i].value = '';
		//else
			CityObj.options[i].value = a[i][0];
		CityObj.options[i].text  = a[i][0];
		if (selectcity==a[i][0]){
			CityObj.selectedIndex = i;
		}
	}

}

