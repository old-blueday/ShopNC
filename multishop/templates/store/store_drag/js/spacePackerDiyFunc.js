var phpserialize = new PHP_Serializer(charSet);
var ss = new styleCss(0);
var dss = new styleCss(2);
var place = ["left top", "center top", "right top", "left center", "center center", "right center", "left bottom", "center bottom", "right bottom"];
var diyStyle = [];
var tmpStyle = [];
var threeMod = ["LCR", "LRC", "CLR"];
var twoMod = ["LC", "CL"];
var currentTransferDiv = "";
var currentBlock = "";
var currentBlockClass = ".blocktitle";
var shareselected = false;
var clr,
currentColorInput,
currentColorTag,
currentColorProperty;
var tdClass = [];
var musicIptCreate = false;
var contentDiv = "sysPicList";
var backgroundType = "1";
var tplColorId = "";
function transferDrag(obj) {
    if (obj.drag) {
        return true;
    }
    obj.drag = new drag(obj.dstObj, obj.dstDragHead);
    obj.drag.cursor = "move";
}
function getBlockStyle(selector, property) {
    var propertyForJs = property.replace(/-([a-z])/g, 
    function($0, $1) {
        return $1.toUpperCase();
    });
    var _style = dss.getRule(getBlockSelector(selector, true), propertyForJs);
    if (false == _style || typeof _style == "undefined") {
        _style = dss.getRule(getBlockSelector(selector, "", "menu" == currentBlock ? ".menu": ".block"), propertyForJs);
    }
    if (false == _style || typeof _style == "undefined") {
        _style = ss.getRule(getBlockSelector(selector, true), propertyForJs);
    }
    if (false == _style || typeof _style == "undefined") {
        _style = ss.getRule(getBlockSelector(selector, "", in_array(currentBlock, ["menu", "banner", "footer"]) ? "." + currentBlock: ".block"), propertyForJs);
    }
    if (in_array(_style, ["transparent", "undefined"]) || false == _style) {
        _style = "";
    }
    if (!isEmpty(_style)) {
        var reUrl = new RegExp("URL\\((.*?)\\)", "i");
        var reColor = new RegExp("color", "i");
        var rePx = new RegExp("(\\d+?)px", "i");
        var reRGB = new RegExp("rgb\\((.*?)\\)", "i");
        if (_style.search(reUrl) > -1) {
            _style = _style.slice(4, -1);
        } else if (property.search(reColor) > -1) {
            if (_style.slice(0, 3) == "rgb") {
                var matches = _style.match(reRGB);
                _style = matches[0];
                _style = eval(_style);
            } else if (_style.slice(0, 1) != "#") {
                _style = "";
            }
        } else if (_style.search(rePx) > -1) {
            _style = parseInt(_style);
        }
    }
    return _style;
}
function getBlockSelector(tag, id, block) {
    var selector = "";
    if (!isEmpty(block)) {
        selector = block;
    } else {
        if (in_array(currentBlock, ["body"])) {
            selector = currentBlock;
        } else {
            selector = "#" + currentBlock;
        }
    }
    if (isEmpty(selector)) {
        alert(spaceTips.diyError);
    }
    if (!isEmpty(tag)) {
        selector = selector + " " + tag;
    }
    return selector;
}
function changeCtrlColor(color) {
    var controlColor = color + "Ctrl";
    if ($(color).value == "") {
        $(controlColor).className = "control_nocolor";
    } else {
        $(controlColor).className = "control_color";
        $(controlColor).style.backgroundColor = $(color).value;
    }
}
function delBlockStyle(property, value, tag) {
    var selector = getBlockSelector(tag, true);
    var n = dss.indexOf(selector);
    dss.removeRule(n);
    diyStyle.block[currentBlock][tag] = arrayUnset(diyStyle.block[currentBlock][tag], property);
}
function cancelStyle() {
    for (var i in tmpStyle) {
        var _style = tmpStyle[i].split("|");
        var _block = _style[0];
        var _tag = _style[1];
        var _property = _style[2];
        var _value = _style[3];
        var _status = _style[4];
        currentBlock = _block;
        if ("N" == _status) {
            delBlockStyle(_property, _value, _tag);
        } else {
            setBlockStyle(_property, _value, _tag);
        }
    }
    tmpStyle = [];
    currentBlock = "";
}
function closeDiy(id) {
    cancelStyle();
    $(id).style.display = "none";
    $("qwert").style.display = "none";
    currentTransferDiv = "";
}
function closeDiyBackground(id) {
    if (in_array(currentBlock, ["body", "banner", "footer"])) {
        cancelStyle();
        closeSingleBackground();
    }
    $(id).style.display = "none";
    if (!isEmpty(currentTransferDiv)) {
        $(currentTransferDiv).style.display = "";
    }
}
function readyChangeColor(ipt, tag, property) {
    currentColorInput = ipt;
    currentColorTag = tag;
    currentColorProperty = property;
    $("clrMain").style.display = "";
    sourceObj = $(ipt);
    sourceObj.pos = fetchOffset(sourceObj);
    sourceObj.X = sourceObj.pos.left;
    sourceObj.Y = sourceObj.pos.top;
    sourceObj.w = sourceObj.offsetWidth;
    sourceObj.h = sourceObj.offsetHeight;
    $("clrMain").style.left = sourceObj.X + "px";
    $("clrMain").style.top = sourceObj.Y - $("clrMain").offsetHeight + "px";
    $("clrColorValue").value = $(ipt).value;
    var menuTitlecolor = new selectColor(getColor);
}
function getColor(obj) {
    if (typeof obj == "object") {
        var value = obj.iptObj.value;
    } else {
        var value = obj;
    }
    $(currentColorInput).value = value;
    if (value == "transparent") {
        $(currentColorInput).value = "";
        $("clrColorValue").value = "";
    }
    changeCtrlColor(currentColorInput);
    setBlockStyle(currentColorProperty, value, currentColorTag);
}
function setBlockStyle(property, value, tag) {
    var propertyForJs = property.replace(/-([a-z])/g, 
    function($0, $1) {
        return $1.toUpperCase();
    });
    var p2v = property + ":" + value;
    var oldValue = getBlockStyle(tag, propertyForJs);
    if ("undefined" == typeof diyStyle.block) {
        diyStyle.block = [];
    }
    if ("undefined" == typeof diyStyle.block[currentBlock]) {
        diyStyle.block[currentBlock] = [];
    }
    if ("undefined" == typeof diyStyle.block[currentBlock][tag]) {
        diyStyle.block[currentBlock][tag] = [];
    }
    if ("backgroundImage" == propertyForJs) {
        value = "url(" + value + ")";
        p2v = property + ":" + value;
    } else if (propertyForJs.search(/(width|height|top|right|bottom|left|size|topWidth|rightWidth|bottomWidth|leftWidth)$/i) > -1) {
        value = parseInt(value) + "px";
        p2v = property + ":" + value;
    }
    selector = getBlockSelector(tag, true);
    var _new = false;
    var styleKey = currentBlock + "|" + tag + "|" + property;
    if (false == dss.setRule(selector, propertyForJs, value)) {
        dss.addRule(selector, p2v);
        _new = true;
    }
    if ("undefined" == typeof tmpStyle[styleKey]) {
        tmpStyle[styleKey] = styleKey + "|" + oldValue + "|" + (true == _new ? "N": "O");
    }
    diyStyle.block[currentBlock][tag][property] = p2v;
}
function callbackTitle() {}
callbackTitle.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackTitle.prototype.complete = function(obj) {
    currentBlock = "banner";
    var titleColor = getBlockStyle(".title h1", "color");
    $("titleColor").value = titleColor;
    changeCtrlColor("titleColor");
    $("titleColorCtrl").style.cursor = "pointer";
    $("titleColorCtrl").onclick = readyChangeColor.bind(this, "titleColor", ".title h1", "color");
    var titleSigColor = getBlockStyle(".title p", "color");
    $("titleSigColor").value = titleSigColor;
    changeCtrlColor("titleSigColor");
    $("titleSigColorCtrl").style.cursor = "pointer";
    $("titleSigColorCtrl").onclick = readyChangeColor.bind(this, "titleSigColor", ".title p", "color");
};
callbackTitle.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function changeBold(obj, selector) {
    var value = "normal";
    if (obj.checked == true) {
        value = "bold";
    }
    setBlockStyle("font-weight", value, selector);
}
function changeMenuHeight(obj) {
    var newATop,
    aTop = getBlockStyle("ul", "marginTop");
    var oldHeight = getBlockStyle("", "height");
    var minL = 31;
    var maxL = 200;
    var value = parseInt(obj.body.style.left);
    value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    if ($("navHeight")) {
        $("navHeight").value = value;
    }
    setBlockStyle("height", value, "");
    newATop = aTop + value - oldHeight;
    setBlockStyle("margin-top", newATop > 0 ? newATop: 0, "ul");
}
function changeMenuMarginTop(obj) {
    var maxL = getBlockStyle("", "height");
    if (maxL < 30) {
        maxL = 30;
    } else {
        maxL = maxL - 30;
    }
    var value = parseInt(obj.body.style.left);
    value = parseInt(maxL * (100 - value) / 100);
    setBlockStyle("margin-top", value, "ul");
}
function changeMenuPaddingLeft(obj) {
    var minL = 20;
    var maxL = 60;
    var value = parseInt(obj.body.style.left);
    value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    if ($("navLeft")) {
        $("navLeft").value = value;
    }
    setBlockStyle("padding-left", value, "ul");
}
function setBackgroundPosition(placePid, selectId) {
    tdClass = P("className", "wcc0 iw0", $(placePid));
    var reId = new RegExp("^" + placePid + "_", "i");
    var orderId = selectId.toString().replace(reId, "");
    for (var i in tdClass) {
        initBackgroundPlace(placePid, i);
        if (i == orderId) {
            tdClass[i].className = "wcc0 iw0 selected";
            setBlockStyle("background-position", place[i], currentBlockClass);
        }
    }
}
function initBackgroundPlace(placePid, orderId) {
    tdClass[orderId].className = "wcc0 iw0";
    if ($(placePid + "_" + orderId)) {
        return;
    }
    tdClass[orderId].id = placePid + "_" + orderId;
    tdClass[orderId].onclick = function() {
        setBackgroundPosition(placePid, this.id);
    };
}
function callbackMenu(obj) {}
callbackMenu.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackMenu.prototype.complete = function() {
    currentBlock = "menu";
    currentBlockClass = "";
    var menuSize = getBlockStyle("a", "fontSize");
    setSelected("menuSize", menuSize);
    $("menuSize").onchange = function() {
        setBlockStyle("font-size", this.value, "a");
    };
    var menuWeight = getBlockStyle("a", "fontWeight");
    $("menuWeight").checked = "bold" == menuWeight ? true: false;
    $("menuWeight").onclick = changeBold.bind(this, $("menuWeight"), "a");
    var menuHrefColor = getBlockStyle("a", "color");
    $("menuHrefColor").value = menuHrefColor;
    changeCtrlColor("menuHrefColor");
    $("menuHrefColorCtrl").style.cursor = "pointer";
    $("menuHrefColorCtrl").onclick = readyChangeColor.bind(this, "menuHrefColor", "a", "color");
    var menuHoverColor = getBlockStyle("a:hover", "color");
    $("menuHoverColor").value = menuHoverColor;
    changeCtrlColor("menuHoverColor");
    $("menuHoverColorCtrl").style.cursor = "pointer";
    $("menuHoverColorCtrl").onclick = readyChangeColor.bind(this, "menuHoverColor", "a:hover", "color");
    var menuAActiveColor = getBlockStyle(".active a", "color");
    $("menuAActiveColor").value = menuAActiveColor;
    changeCtrlColor("menuAActiveColor");
    $("menuAActiveColorCtrl").style.cursor = "pointer";
    $("menuAActiveColorCtrl").onclick = readyChangeColor.bind(this, "menuAActiveColor", ".active a", "color");
    var sliderHNav = new drag("sliderHNav", "", "hxMoveRangeNav", "horizontal", changeMenuHeight, 1);
    sliderHNav.cursor = "default";
    var navHeightOld = getBlockStyle("", "height");
    if ($("navHeight")) {
        $("navHeight").value = navHeightOld;
    }
    var navHeight = parseInt((navHeightOld - 31) / 170 * 100);
    $("sliderHNav").style.left = navHeight + "px";
    $("navHeight").onkeyup = function() {
        if (parseInt(this.value) >= 31) {
            changeMenuHeight(this.value);
        }
    };
    var sliderHA = new drag("sliderHA", "", "hxMoveRangeA", "horizontal", changeMenuMarginTop, 1);
    sliderHA.cursor = "default";
    var navA = getBlockStyle("ul", "marginTop");
    navA = 100 - parseInt(navA / (navHeightOld - 31) * 100);
    $("sliderHA").style.left = navA + "px";
    var sliderHNavLeft = new drag("sliderHNavLeft", "", "hxMoveRangeNavLeft", "horizontal", changeMenuPaddingLeft, 1);
    sliderHNavLeft.cursor = "default";
    var navLeft = getBlockStyle("ul", "paddingLeft");
    if ($("navLeft")) {
        $("navLeft").value = navLeft;
    }
    navLeft = (navLeft - 20) / 40 * 100;
    $("sliderHNavLeft").style.left = navLeft + "px";
    $("navLeft").onkeyup = function() {
        if (parseInt(this.value) >= 20) {
            changeMenuPaddingLeft(this.value);
        }
    };
    var menuBorderStyle = getBlockStyle("", "borderTopStyle");
    setSelected("menuBorderStyle", menuBorderStyle);
    $("menuBorderStyle").onchange = function() {
        setBlockStyle("border-style", this.value, "");
    };
    var menuBorderWidth = getBlockStyle("", "borderTopWidth");
    setSelected("menuBorderWidth", menuBorderWidth);
    $("menuBorderWidth").onchange = function() {
        setBlockStyle("border-width", this.value, "");
    };
    var menuBorderColor = getBlockStyle("", "borderTopColor");
    $("menuBorderColor").value = menuBorderColor;
    changeCtrlColor("menuBorderColor");
    $("menuBorderColorCtrl").style.cursor = "pointer";
    $("menuBorderColorCtrl").onclick = readyChangeColor.bind(this, "menuBorderColor", "", "border-top-color");
    var menuBgImg = getBlockStyle("", "backgroundImage");
    $("menuOldBgImg").value = menuBgImg;
    $("setMenuBgTransparent").onclick = function() {
        setBlockStyle("background-image", "", "");
    };
    var menuBgrepeat = getBlockStyle("", "backgroundRepeat");
    setSelected("menuBgRepeat", menuBgrepeat);
    $("menuBgRepeat").onchange = function() {
        setBlockStyle("background-repeat", this.value, "");
    };
    var menuBgPosition = getBlockStyle("", "backgroundPosition");
    var selectp = 0;
    for (var p in place) {
        if (place[p] == menuBgPosition) {
            selectp = p;
        }
    }
    setBackgroundPosition("setMenuPlace", selectp);
    var menuBgColor = getBlockStyle("", "backgroundColor");
    $("menuBgColor").value = menuBgColor;
    changeCtrlColor("menuBgColor");
    $("menuBgColorCtrl").style.cursor = "pointer";
    $("menuBgColorCtrl").onclick = readyChangeColor.bind(this, "menuBgColor", "", "background-color");
};
callbackMenu.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function initBackgroundImage() {
    $("sysPicLi").onclick = showBackgroundDiv.bind(this, "sysPic", "sysPicLi");
    $("albumPicLi").onclick = showBackgroundDiv.bind(this, "albumPic", "albumPicLi");
    $("uploadPicLi").onclick = showBackgroundDiv.bind(this, "uploadPic", "uploadPicLi");
    $("urlPicLi").onclick = showBackgroundDiv.bind(this, "urlPic", "urlPicLi");
    $("albumLists").onchange = changeAlbum.bind(this, $("albumLists"));
    $("urlPicPath").onclick = function() {
        setBlockStyle("background-image", $("urlPicPath").value, "");
    };
    $("btnUrlPicPath").onclick = function() {
        setBlockStyle("background-image", $("urlPicPath").value, "");
    };
    showBackgroundDiv("sysPic", "sysPicLi");
    getpage(1, "control.php?action=getSysPic&type=" + backgroundType + "&inajax=1");
}
function uploadLocalImg() {
    $("attach").value = "";
    var imgSrc = $("newbg").src;
    var reThumb = new RegExp("(\\.thumb\\.(.){3,4})$", "i");
    imgSrc = imgSrc.replace(reThumb, "");
    setBlockStyle("background-image", imgSrc, "");
}
function callbackMenuBgImg() {}
callbackMenuBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    $(currentTransferDiv).style.display = "none";
};
callbackMenuBgImg.prototype.complete = function(obj) {
    backgroundType = "3";
    $("selectBgTitle").innerHTML = spaceLangs.menuPic;
    initBackgroundImage();
};
callbackMenuBgImg.prototype.close = function(obj) {
    $(currentTransferDiv).style.display = "";
};
function initBackground(obj) {
    initBackgroundImage();
    $("selectBgSub").style.display = "";
    $("cancelBg").style.display = "";
    var bgImg = getBlockStyle("", "backgroundImage");
    $("otherOldBgImg").value = bgImg;
    var bgRepeat = getBlockStyle("", "backgroundRepeat");
    setSelected("otherBgRepeat", bgRepeat);
    $("otherBgRepeat").onchange = function() {
        setBlockStyle("background-repeat", this.value, "");
    };
    var bgPosition = getBlockStyle("", "backgroundPosition");
    var selectp = 0;
    for (var p in place) {
        if (place[p] == bgPosition) {
            selectp = p;
        }
    }
    setBackgroundPosition(obj.dstObj.id, selectp);
    var otherBgColor = getBlockStyle("", "backgroundColor");
    $("otherBgColor").value = otherBgColor;
    changeCtrlColor("otherBgColor");
    $("otherBgColorCtrl").style.cursor = "pointer";
    $("otherBgColorCtrl").onclick = readyChangeColor.bind(this, "otherBgColor", "", "background-color");
}
function callbackFooterBgImg() {}
callbackFooterBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
    window.scrollTo(0, document.body.offsetHeight);
};
callbackFooterBgImg.prototype.complete = function(obj) {
    currentBlock = "footer";
    currentBlockClass = "";
    backgroundType = "4";
    $("selectBgTitle").innerHTML = spaceLangs.footerPic;
    initBackground(obj);
    $("setBgPlace").style.display = "";
    $("setFooter").style.display = "";
    var vMoveFooter = new drag("sliderHFooter", "", "hxMoveRangeFooter", "horizontalFooter", changeFooterHeight, 1);
    vMoveFooter.cursor = "default";
    $("footerHeight").onkeyup = function() {
        if (parseInt(this.value) >= 30) {
            changeFooterHeight(this.value);
        }
    };
    var footerFontColor = getBlockStyle(".copyright p", "color");
    $("footerFontColor").value = footerFontColor;
    changeCtrlColor("footerFontColor");
    $("footerFontColorCtrl").style.cursor = "pointer";
    $("footerFontColorCtrl").onclick = readyChangeColor.bind(this, "footerFontColor", ".copyright p", "color");
};
callbackFooterBgImg.prototype.close = function(obj) {
    closeSingleBackground();
};
function callbackBannerBgImg() {}
callbackBannerBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
    window.scrollTo(0, 0);
};
callbackBannerBgImg.prototype.complete = function(obj) {
    currentBlock = "banner";
    currentBlockClass = "";
    backgroundType = "2";
    $("selectBgTitle").innerHTML = spaceLangs.bannerPic;
    initBackground(obj);
    $("setBgPlace").style.display = "";
    $("setBannerHeight").style.display = "";
    var vMoveBanner = new drag("sliderHBanner", "", "hxMoveRangeBanner", "horizontalBanner", changeBannerHeight, 1);
    vMoveBanner.cursor = "default";
    $("bannerHeight").onkeyup = function() {
        if (parseInt(this.value) >= 70) {
            changeBannerHeight(this.value);
        }
    };
    var bannerHeight = getBlockStyle("", "height");
    if ($("bannerHeight")) {
        $("bannerHeight").value = bannerHeight;
    }
    bannerHeight = (bannerHeight - 70) / 430 * 100;
    $("sliderHBanner").style.left = bannerHeight + "px";
};
callbackBannerBgImg.prototype.close = function(obj) {
    closeSingleBackground();
};
function callbackBodyBgImg() {}
callbackBodyBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackBodyBgImg.prototype.complete = function(obj) {
    currentBlock = "body";
    currentBlockClass = "";
    backgroundType = "1";
    $("selectBgTitle").innerHTML = spaceLangs.bodyBackgroundPic;
    initBackground(obj);
    $("setBodyBgState").style.display = "";
    $("setBgPlace").style.display = "";
    var bodyBgState = getBlockStyle("", "backgroundAttachment");
    setSelected("bodyBgState", bodyBgState);
    $("bodyBgState").onchange = function() {
        setBlockStyle("background-attachment", this.value, "");
    };
};
callbackBodyBgImg.prototype.close = function(obj) {
    closeSingleBackground();
};
function closeSingleBackground() {
    tmpStyle = [];
    $("qwert").style.display = "none";
    currentTransferDiv = "";
    var hideDivs = ["selectBgSub", "cancelBg", "setBodyBgState", "setBannerHeight", "setFooter", "setBgPlace"];
    for (var i in hideDivs) {
        $(hideDivs[i]).style.display = "none";
    }
}
function changeBannerHeight(obj) {
    var oldValue = getBlockStyle("", "height");
    currentBlock = "title";
    var titleTop = getBlockStyle("", "top");
    currentBlock = "banner";
    var minL = 70;
    var maxL = 500;
    if (typeof obj == "object") {
        var value = parseInt(obj.body.style.left);
        value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    } else {
        var value = parseInt(obj);
        value = value < minL ? minL: value;
        value = value > maxL ? maxL: value;
        if ($("sliderHBanner")) {
            $("sliderHBanner").style.left = (value - minL) / (maxL - minL) * 100 + "px";
        }
    }
    if ($("bannerHeight")) {
        $("bannerHeight").value = value;
    }
    titleTop = titleTop + value - oldValue;
    if (titleTop < 1) {
        titleTop = 1;
    }
    if (titleTop > value - 70) {
        titleTop = value - 70;
    }
    setBlockStyle("height", value, "");
    currentBlock = "title";
    $("title").style.top = titleTop + "px";
    setBlockStyle("top", titleTop, "");
    currentBlock = "banner";
}
function changeFooterHeight(obj) {
    var minL = 30;
    var maxL = 400;
    if (typeof obj == "object") {
        var value = parseInt(obj.body.style.left);
        value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    } else {
        var value = parseInt(obj);
        value = value < minL ? minL: value;
        value = value > maxL ? maxL: value;
        if ($("sliderHBanner")) {
            $("sliderHBanner").style.left = (value - minL) / (maxL - minL) * 100 + "px";
        }
    }
    if ($("footerHeight")) {
        $("footerHeight").value = value;
    }
    setBlockStyle("height", value, "");
}
function showBackgroundDiv(divId, navId) {
    if (in_array(navId, ["albumPicLi", "sysPicLi"])) {
        contentDiv = navId.replace("Li", "List");
    }
    var allNav = ["sysPicLi", "uploadPicLi", "urlPicLi", "albumPicLi"];
    for (var i in allNav) {
        if (allNav[i] == navId) {
            $(navId).className = "on";
            $(navId.replace("Li", "")).style.display = "";
        } else {
            $(allNav[i]).className = "";
            $(allNav[i].replace("Li", "")).style.display = "none";
        }
    }
}
function changeBackground(obj, type, noBg) {
    var imgSrc = "";
    if (!isEmpty(obj) && !isEmpty(obj.src) && 1 != noBg) {
        imgSrc = obj.src;
        if ("album" == type) {
            var reAlbum = new RegExp("(\\.thumb\\.(.){3,4})$", "i");
            imgSrc = imgSrc.replace(reAlbum, "");
        } else if ("system" == type) {
            var reSystem = new RegExp("\\/thumb\\/([a-f0-9]+?)\\.(.*?)", "ig");
            imgSrc = imgSrc.replace(reSystem, 
            function($0, $1) {
                $0 = "";
                $1 = "/" + $1 + "_b.";
                return $1;
            });
        }
    }
    divClass = P("className", "on", $(contentDiv));
    for (i in divClass) {
        divClass[i].className = "";
    }
    showOkDiv(obj);
    obj.className = "on";
    if ("cursorList" == contentDiv) {
        setCursor(obj, imgSrc);
        return true;
    }
    if (!isEmpty(imgSrc)) {
        if ("fastHeaderBg" == contentDiv) {
            $("fastBg").value = imgSrc;
            if (!is_ie) {
                dss = new styleCss(document.styleSheets.length - 1);
            }
            currentBlock = "banner";
            currentBlockClass = "";
            getImgHeight(imgSrc, 70, 500, changeBannerHeight, 1);
            return true;
        }
        if (isEmpty(currentBlock)) {
            alert("currentBlock is null!");
            return false;
        }
        if (currentBlock == "menu") {
            setBlockStyle("background-image", "", ".active");
        }
        if (currentBlock == "body") {
            getImgHeight(imgSrc, 70, 500);
            return;
        }
        if (currentBlock == "banner") {
            getImgHeight(imgSrc, 70, 500, changeBannerHeight);
            return;
        }
        if (currentBlock == "footer") {
            getImgHeight(imgSrc, 30, 150, changeFooterHeight);
            return;
        }
    }
    setBlockStyle("background-image", imgSrc, currentBlockClass);
}
function showOkDiv(obj) {
    if ($("okDiv")) {
        $("okDiv").parentNode.removeChild($("okDiv"));
    }
    var okDiv = document.createElement("div");
    okDiv.id = "okDiv";
    okDiv.className = "onthis";
    okDiv.innerHTML = "";
    obj.parentNode.appendChild(okDiv);
}
function setCursor(obj, cursorPath) {
    cursorPath = cursorPath.replace(".gif", ".ani");
    var cursorReg = new RegExp(".ani$");
    var httpReg = new RegExp("^http://");
    if (cursorReg.test(cursorPath)) {
        if (!httpReg.test(cursorPath)) {
            cursorPath = cursorHost + cursorPath;
        }
    } else {
        cursorPath = "auto";
    }
    if ("auto" != cursorPath) {
        cursorPath = "url(" + cursorPath + "), url(" + cursorPath + "), auto;";
    }
    diyStyle.cursor = "auto" == cursorPath ? "auto": cursorPath;
    dss.addRule("body", "cursor:" + cursorPath);
}
function getImgHeight(src, minH, maxH, func, getValue) {
    var newImage = new Image;
    var imgH = 0;
    newImage.src = src;
    if (newImage.complete) {
        imageLoaded(newImage, minH, maxH, func, getValue);
        false;
        return;
    }
    newImage.onload = function() {
        imageLoaded(newImage, minH, maxH, func, getValue);
        newImage.onload = null;
    };
    false;
    return;
}
function imageLoaded(newImage, minH, maxH, func, getValue) {
    imgH = newImage.height;
    if (!isEmpty(imgH)) {
        imgH = imgH < minH ? minH: imgH;
        imgH = imgH > maxH ? maxH: imgH;
        if (!isEmpty(func)) {
            func(imgH);
        }
    }
    if (getValue == 1) {
        $("fastBgHeight").value = imgH;
    }
    setBlockStyle("background-image", newImage.src, currentBlockClass);
}
function callbackPlayer() {}
callbackPlayer.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackPlayer.prototype.complete = function(obj) {
    var i = 1;
    var uL = $("musicUL");
    if (false == musicIptCreate) {
        for (i = 1; i < 11; i++) {
            var Li = document.createElement("LI");
            var strong = document.createElement("STRONG");
            var txt = document.createTextNode(spaceLangs.musicList + i);
            strong.appendChild(txt);
            Li.appendChild(strong);
            var ipt = document.createElement("INPUT");
            ipt.setAttribute("type", "text");
            ipt.setAttribute("id", "music_" + i);
            ipt.className = "txt";
            ipt.onblur = function() {
                setMusic(this);
            };
            Li.appendChild(ipt);
            var em = document.createElement("EM");
            var a = document.createElement("A");
            a.setAttribute("href", "javascript:;"); (function(href, obj) {
                href.onclick = function() {
                    setMusic(obj, 1);
                };
            })(a, ipt);
            txt = document.createTextNode(spaceLangs.clear);
            a.appendChild(txt);
            em.appendChild(a);
            Li.appendChild(em);
            uL.appendChild(Li);
        }
        musicIptCreate = true;
    }
    for (var i in diyStyle.music) {
        $(i).value = diyStyle.music[i];
    }
};
callbackPlayer.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function setMusic(obj, del) {
    if (!isEmpty(diyStyle.music) || "string" == typeof diyStyle.music) {
        diyStyle.music = [];
    }
    if (del == 1) {
        obj.value = "";
        diyStyle.music[obj.id] = "";
        return;
    }
    diyStyle.music[obj.id] = obj.value;
}
function callbackCursor() {}
callbackCursor.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackCursor.prototype.complete = function(obj) {
    backgroundType = 6;
    contentDiv = "cursorList";
    getpage(1, "control.php?action=getSysPic&type=" + backgroundType + "&inajax=1");
};
callbackCursor.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function changeSysBackground(obj, param, picNav) {
    var colorParam = "";
    if (isEmpty(picNav)) {
        picNav = "sysPicNav";
    }
    if ("undefined" == typeof param) {
        param = "";
    }
    if (picNav == "fastPicNav") {
        colorParam = "&colorId=" + tplColorId;
    }
    getpage(1, "control.php?action=getSysPic&type=" + backgroundType + colorParam + "&inajax=1" + param);
    divClass = P("className", "on", $(picNav));
    for (i in divClass) {
        divClass[i].className = "";
    }
    obj.className = "on";
}
function callbackFastDiy() {}
callbackFastDiy.prototype.ready = function(obj) {
    if (styleNum > 19) {
        alert(spaceLangs.tplNumMaxLimit);
        fireEvent("showMyStyles", "mousedown");
        return false;
    }
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackFastDiy.prototype.complete = function(obj) {
    contentDiv = "fastHeaderBg";
    backgroundType = "2";
    $("fastDiySub").style.display = "none";
    $("fastStyle").value = "";
};
callbackFastDiy.prototype.close = function(obj) {
    if ($("fastStyle").value == "") {
        alert(spaceLangs.selectColor);
        return false;
    }
    $("fastDiyForm").submit();
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function closeFastDiy() {
    switchStyle("", "myStyle");
    $("fastHeaderBg").innerHTML = "";
    $("fastStyle").value = "";
    $("fastBg").value = "";
    $("fastDiy").style.display = "none";
    $("qwert").style.display = "none";
    currentTransferDiv = "";
}
function fastChangeHeadBackground(obj, colorId) {
    $("fastDiySub").style.display = "";
    var colors = ["black", "white", "pink", "yellow", "green", "blue"];
    for (var c in colors) {
        $(colors[c]).className = "webcolor_" + colors[c];
    }
    obj.className = obj.className + " on";
    tplColorId = colorId;
    changeSysBackground($("allType"), "", "fastPicNav");
    $("fastStyle").value = obj.id;
    switchStyle(obj.id);
}
function switchStyle(styleId, myType) {
    if (!$("qwertadsf")) {
        var iframe = document.createElement("div");
        iframe.id = "qwertadsf";
        iframe.style.zIndex = 99999;
        iframe.style.display = "none";
        iframe.style.backgroundColor = "#fff";
        iframe.style.opacity = "0";
        iframe.style.position = "absolute";
        iframe.style.filter = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)";
        $("append_parent") ? $("append_parent").appendChild(iframe) : menuObj.parentNode.appendChild(iframe);
    }
    var qwertasdf = $("qwertadsf");
    qwertasdf.style.top = 0;
    qwertasdf.style.left = 0;
    qwertasdf.style.width = document.body.clientWidth + "px";
    qwertasdf.style.height = document.body.clientHeight + "px";
    qwertasdf.style.display = "block";
    dss.removeAllRule(1);
    var cssText = "";
    var getCss = new Ajax;
    if (typeof myType == "undefined") {
        myType = "fastDiy";
    }
    var myurl = "control.php?action=myStyle&op=getCss&type=" + myType;
    if (myType == "fastDiy") {
        myurl = myurl + "&fastKey=" + styleId;
    } else {
        myurl = myurl + "&styleId=" + styleId;
    }
    getCss.get(myurl, 
    function(s) {
        cssText = s;
        var tempStyle = $("tempStyle");
        if (is_ie) {
            var style = document.createStyleSheet("", 2);
            style.cssText = cssText;
            dss = new styleCss(2);
        } else {
            if (tempStyle) {
                tempStyle.parentNode.removeChild(tempStyle);
            }
            var style = document.createElement("style");
            style.id = "tempStyle";
            style.type = "text/css";
            style.innerHTML = cssText;
            document.getElementsByTagName("HEAD").item(0).appendChild(style);
        }
        $("qwertadsf").style.zIndex = "998";
        $("qwertadsf").style.display = "none";
    });
}
function showChgName(obj, id, name) {
    if ($("chgName")) {
        $("chgName").parentNode.removeChild($("chgName"));
    }
    var chgName = document.createElement("div");
    chgName.id = "chgName";
    chgName.className = "chgname";
    chgName.innerHTML = $("chgNameInner").innerHTML;
    obj.parentNode.appendChild(chgName);
    $("chgStyleId").value = id;
    $("newStyleName").value = name;
}
function callbackMyStyles() {}
callbackMyStyles.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = obj.dstObj.id;
};
callbackMyStyles.prototype.complete = function(obj) {
    getStyleList("control.php?action=myStyle");
};
callbackMyStyles.prototype.close = function(obj) {
    if ($("selectMyStyle").value > 0) {
        window.location.href = "control.php?action=myStyle&op=use&styleId=" + $("selectMyStyle").value;
    } else {
        window.location.href = "control.php";
    }
};
function callbackShareStyle() {}
callbackShareStyle.prototype.ready = function(obj) {
    if (styleNum > 19) {
        alert(spaceLangs.tplNumMaxLimit);
        fireEvent("showMyStyles", "mousedown");
        return false;
    }
    transferDrag(obj);
    $(currentTransferDiv).style.display = "none";
};
callbackShareStyle.prototype.complete = function(obj) {};
callbackShareStyle.prototype.close = function(obj) {
    if ($("styleName").value == "") {
        alert(spaceLangs.inputThemeName);
        closeShareStyle();
        return false;
    }
    if ($("styleColor").value == "") {
        alert(spaceLangs.selectThemeOfColor);
        closeShareStyle();
        return false;
    }
    if ($("styleCategory").value == "") {
        alert(spaceLangs.inputThemeOfClass);
        closeShareStyle();
        return false;
    }
    ajaxpost("shareStyleForm", "myStyleList", "");
    $(currentTransferDiv).style.display = "";
};
function closeShareStyle() {
    $("shareStyle").style.display = "none";
    $(currentTransferDiv).style.display = "";
}
function previewStyle(styleId) {
    $("selectMyStyle").value = styleId;
    switchStyle(styleId, "userStyle");
}
function cancelSelected(id) {
    $("selectMyStyle").value = "";
    switchStyle("", "myStyle");
    $(id).style.display = "none";
    $("qwert").style.display = "none";
    currentTransferDiv = "";
}
function callbackSelectShare() {}
callbackSelectShare.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = "";
};
callbackSelectShare.prototype.complete = function(obj) {
    tplColorId = backgroundType = "";
    contentDiv = "shareList";
    getpage(1, "control.php?action=getShareStyle&type=" + backgroundType + "&colorId=" + tplColorId + "&inajax=1");
};
callbackSelectShare.prototype.close = function(obj) {
    if (shareselected == false) {
        alert(spaceLangs.noSelectTheme);
        return false;
    }
    $("selectShareForm").submit();
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function closeSelectShare(id) {
    shareselected = false;
    cancelSelected(id);
}
function changeSelectShare(obj, id) {
    $("shareStyleId").value = id;
    divClass = P("className", "on", $("shareList"));
    for (i in divClass) {
        divClass[i].className = "";
    }
    showOkDiv(obj);
    obj.className = "on";
    shareselected = true;
    switchStyle(id, "shareStyle");
}
function changeSelectFrame(setFrame) {
    var frameLink = $("selectFrameContent").getElementsByTagName("a");
    var reFrame = new RegExp(" onframe[\\d]+", "i");
    for (var fi in frameLink) {
        if (frameLink[fi].id != setFrame + "_F" && typeof frameLink[fi].className != "undefined") {
            frameLink[fi].className = frameLink[fi].className.replace(reFrame, "");
        }
    }
    $(setFrame + "_F").className = $(setFrame + "_F").className + " on" + $(setFrame + "_F").className;
    diyStyle.frame = setFrame;
}
function callbackSetFrame() {}
callbackSetFrame.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = "";
};
callbackSetFrame.prototype.complete = function(obj) {};
callbackSetFrame.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function changeFrame(setFrame) {
    var mainDiv = "";
    setFrame = setFrame.toUpperCase();
    defaultFrame = defaultFrame.toUpperCase();
    if (setFrame == defaultFrame) {
        return;
    }
    footerInnerhtml = $("footer").innerHTML;
    var footerDiv = document.createElement("div");
    footerDiv.innerHTML = footerInnerhtml;
    if (in_array(setFrame, threeMod)) {
        var leftInnerhtml = rightInnerhtml = contentInnerhtml = "";
        if (in_array(defaultFrame, twoMod)) {
            mainDiv = $("wraptwo");
            var divs = mainDiv.getElementsByTagName("div");
            var leftBlocks = P("className", "block", $("dleft"));
            contentInnerhtml = $("dcontent").innerHTML;
            var num = Math.round(leftBlocks.length / 2);
            var leftDiv = document.createElement("div");
            leftDiv.className = "frame_1 wowoFrameTd";
            var rightDiv = document.createElement("div");
            rightDiv.className = "frame_1 wowoFrameTd";
            var k = 0;
            for (var i in leftBlocks) {
                if (k < num) {
                    leftDiv.appendChild(leftBlocks[i]);
                } else {
                    rightDiv.appendChild(leftBlocks[i]);
                }
                k++;
            }
            mainDiv.removeChild($("dleft"));
            mainDiv.removeChild($("dcontent"));
            leftDiv.id = "dleft";
            rightDiv.id = "dright";
            var contentDiv = document.createElement("div");
            contentDiv.id = "dcontent";
            contentDiv.className = "frame_2 wowoFrameTd";
            contentDiv.innerHTML = contentInnerhtml;
        } else {
            mainDiv = $("wrap");
            leftInnerhtml = $("dleft").innerHTML;
            rightInnerhtml = $("dright").innerHTML;
            contentInnerhtml = $("dcontent").innerHTML;
            mainDiv.removeChild($("dleft"));
            mainDiv.removeChild($("dcontent"));
            mainDiv.removeChild($("dright"));
            var leftDiv = document.createElement("div");
            leftDiv.id = "dleft";
            leftDiv.className = "frame_1 wowoFrameTd";
            leftDiv.innerHTML = leftInnerhtml;
            var rightDiv = document.createElement("div");
            rightDiv.id = "dright";
            rightDiv.className = "frame_1 wowoFrameTd";
            rightDiv.innerHTML = rightInnerhtml;
            var contentDiv = document.createElement("div");
            contentDiv.id = "dcontent";
            contentDiv.className = "frame_2 wowoFrameTd";
            contentDiv.innerHTML = contentInnerhtml;
        }
        if (setFrame == "LCR") {
            mainDiv.appendChild(leftDiv);
            mainDiv.appendChild(contentDiv);
            mainDiv.appendChild(rightDiv);
        } else if (setFrame == "LRC") {
            mainDiv.appendChild(leftDiv);
            mainDiv.appendChild(rightDiv);
            mainDiv.appendChild(contentDiv);
        } else {
            mainDiv.appendChild(contentDiv);
            mainDiv.appendChild(leftDiv);
            mainDiv.appendChild(rightDiv);
        }
        mainDiv.id = "wrap";
    } else if (in_array(setFrame, twoMod)) {
        var leftInnerhtml = contentInnerhtml = "";
        if (in_array(defaultFrame, threeMod)) {
            mainDiv = $("wrap");
            leftInnerhtml = $("dleft").innerHTML + $("dright").innerHTML;
            contentInnerhtml = $("dcontent").innerHTML;
            mainDiv.removeChild($("dleft"));
            mainDiv.removeChild($("dright"));
            mainDiv.removeChild($("dcontent"));
            var leftDiv = document.createElement("div");
            leftDiv.id = "dleft";
            leftDiv.className = "frame_1 wowoFrameTd";
            leftDiv.innerHTML = leftInnerhtml;
            var contentDiv = document.createElement("div");
            contentDiv.id = "dcontent";
            contentDiv.className = "frame_3 wowoFrameTd";
            contentDiv.innerHTML = contentInnerhtml;
        } else {
            mainDiv = $("wraptwo");
            leftInnerhtml = $("dleft").innerHTML;
            contentInnerhtml = $("dcontent").innerHTML;
            var LClassName = $("dleft").className;
            var CClassName = $("dcontent").className;
            mainDiv.removeChild($("dleft"));
            mainDiv.removeChild($("dcontent"));
            var leftDiv = document.createElement("div");
            leftDiv.id = "dleft";
            leftDiv.className = LClassName;
            leftDiv.innerHTML = leftInnerhtml;
            var contentDiv = document.createElement("div");
            contentDiv.id = "dcontent";
            contentDiv.className = CClassName;
            contentDiv.innerHTML = contentInnerhtml;
        }
        if (setFrame == "CL") {
            mainDiv.appendChild(contentDiv);
            mainDiv.appendChild(leftDiv);
        } else {
            mainDiv.appendChild(leftDiv);
            mainDiv.appendChild(contentDiv);
        }
        mainDiv.id = "wraptwo";
    }
    mainDiv.removeChild($("footer"));
    footerDiv.id = "footer";
    mainDiv.appendChild(footerDiv);
    defaultFrame = setFrame;
    changeSelectFrame(setFrame);
    sort = new sortDrag("block", "blocktitle", "blockcontent");
}
function callbackContentBgImg() {}
callbackContentBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    $(currentTransferDiv).style.display = "none";
};
callbackContentBgImg.prototype.complete = function(obj) {
    backgroundType = "1";
    $("selectBgTitle").innerHTML = spaceLangs.contentBackground;
    initBackgroundImage();
};
callbackContentBgImg.prototype.close = function(obj) {
    $(currentTransferDiv).style.display = "";
};
function callbackTitleBgImg() {}
callbackTitleBgImg.prototype.ready = function(obj) {
    transferDrag(obj);
    $(currentTransferDiv).style.display = "none";
};
callbackTitleBgImg.prototype.complete = function(obj) {
    backgroundType = "3";
    $("selectBgTitle").innerHTML = spaceLangs.blockTitleBackground;
    initBackgroundImage();
};
callbackTitleBgImg.prototype.close = function(obj) {
    $(currentTransferDiv).style.display = "";
};
function callbackSelectBlock() {}
callbackSelectBlock.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = "selectBlock";
	jquery.post("control.php?action=getlistmodorder",null,backSelectBlock,"json");//ajax
};
callbackSelectBlock.prototype.complete = function(obj) {};
callbackSelectBlock.prototype.close = function(obj) {
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function diySetBlock(chkBlock, blockId) {
    if ($(blockId) == null) {
        alert(spaceLangs.blockError);
    } else {
        $(blockId).style.display = chkBlock.checked == true ? "": "none";
    }
}
function closeBlock(event) {
    $(currentBlock).style.display = "none";
    $("transferReady").style.display = "none";
    $("set" + currentBlock).checked = false;
    event = event || window.event;
    currentBlock = "";
    doane(event);
}
function showBlockTitle() {
    backgroundType = "3";
    $("setTitle").style.display = "";
    $("setContent").style.display = "none";
    $("menuTitle").className = "on";
    $("menuContent").className = "";
    currentBlockClass = ".blocktitle";
}
function showBlockContent() {
    backgroundType = "1";
    $("setTitle").style.display = "none";
    $("setContent").style.display = "";
    $("menuTitle").className = "";
    $("menuContent").className = "on";
    currentBlockClass = ".blockcontent";
}
function callbackSetBlock() {}
callbackSetBlock.prototype.ready = function(obj) {
    transferDrag(obj);
    currentTransferDiv = "setBlock";
};
callbackSetBlock.prototype.complete = function(obj) {
    backgroundType = "3";
    $("setTitle").style.display = "";
    $("setContent").style.display = "none";
    $("playerTop").style.display = "none";
    $("menuTitle").className = "on";
    $("menuContent").className = "";
    currentBlockClass = ".blocktitle";
    $("blockName").innerHTML = blockList[currentBlock];
    var titleFontsize = getBlockStyle(".blocktitle h2", "fontSize");
    setSelected("titleFontsize", titleFontsize);
    $("titleFontsize").onchange = function() {
        setBlockStyle("font-size", this.value, ".blocktitle h2");
        setBlockStyle("font-size", this.value, ".blocktitle em a");
    };
    var titleWeight = getBlockStyle(".blocktitle h2", "fontWeight");
    $("titleWeight").checked = titleWeight == "bold" ? true: false;
    $("titleWeight").onclick = changeBold.bind(this, $("titleWeight"), ".blocktitle h2");
    var titleFontcolor = getBlockStyle(".blocktitle h2", "color");
    $("titleFontcolor").value = titleFontcolor;
    changeCtrlColor("titleFontcolor");
    $("titleFontcolorCtrl").style.cursor = "pointer";
    $("titleFontcolorCtrl").onclick = readyChangeColor.bind(this, "titleFontcolor", ".blocktitle h2", "color");
    var titleHeight = getBlockStyle(".blocktitle", "height");
    if ($("titleHeight")) {
        $("titleHeight").value = titleHeight;
    }
    titleHeight = (titleHeight - 20) / 40 * 100;
    $("sliderH").style.left = titleHeight + "px";
    var vMove = new drag("sliderH", "", "hxMoveRange", "horizontal", changeTitleHeight, 1);
    vMove.cursor = "default";
    $("titleHeight").onkeyup = function() {
        if (parseInt(this.value) >= 20) {
            changeTitleHeight(this.value);
        }
    };
    var titlePaddingLeft = getBlockStyle(".blocktitle", "paddingLeft");
    if ($("titleLeft")) {
        $("titleLeft").value = titlePaddingLeft;
    }
    titlePaddingLeft = (titlePaddingLeft - 18) / 32 * 100;
    $("sliderHLeft").style.left = titlePaddingLeft + "px";
    var vmove = new drag("sliderHLeft", "", "hxMoveRangeLeft", "horizontal", changeBlockTitlePaddingLeft, 1);
    vmove.cursor = "default";
    $("titleLeft").onkeyup = function() {
        if (parseInt(this.value) >= 18) {
            changeBlockTitlePaddingLeft(this.value);
        }
    };
    var borderBottomStyle = getBlockStyle(".blocktitle", "borderBottomStyle");
    setSelected("titleBorderStyle", borderBottomStyle);
    $("titleBorderStyle").onchange = function() {
        setBlockStyle("border-bottom-style", this.value, ".blocktitle");
    };
    var borderBottomWidth = getBlockStyle(".blocktitle", "borderBottomWidth");
    setSelected("titleBorderWidth", borderBottomWidth);
    $("titleBorderWidth").onchange = function() {
        setBlockStyle("border-bottom-width", this.value, ".blocktitle");
    };
    var titleBorderColor = getBlockStyle(".blocktitle", "borderBottomColor");
    $("titleBorderColor").value = titleBorderColor;
    changeCtrlColor("titleBorderColor");
    $("titleBorderColorCtrl").style.cursor = "pointer";
    $("titleBorderColorCtrl").onclick = readyChangeColor.bind(this, "titleBorderColor", ".blocktitle", "border-bottom-color");
    var titleBgImg = getBlockStyle(".blocktitle", "backgroundImage");
    $("oldTitleBgImg").value = titleBgImg;
    var titleBgRepeat = getBlockStyle(".blocktitle", "backgroundRepeat");
    setSelected("titleBgRepeat", titleBgRepeat);
    $("titleBgRepeat").onchange = function() {
        setBlockStyle("background-repeat", this.value, ".blocktitle");
    };
    var titleBgPosition = getBlockStyle(".blocktitle", "backgroundPosition");
    var selectp = 0;
    for (var p in place) {
        if (place[p] == titleBgPosition) {
            selectp = p;
        }
    }
    setBackgroundPosition("selectTitlePlace", selectp);
    var titleBgColor = getBlockStyle(".blocktitle", "backgroundColor");
    $("titleBgColor").value = titleBgColor;
    changeCtrlColor("titleBgColor");
    $("titleBgColorCtrl").style.cursor = "pointer";
    $("titleBgColorCtrl").onclick = readyChangeColor.bind(this, "titleBgColor", ".blocktitle", "background-color");
    var blockContentSize = getBlockStyle(".blockcontent", "fontSize");
    setSelected("blockContentSize", blockContentSize);
    $("blockContentSize").onchange = function() {
        setBlockStyle("font-size", this.value, ".blockcontent");
    };
    var blockContentWeight = getBlockStyle(".blockcontent h2", "fontWeight");
    $("blockContentWeight").checked = blockContentWeight == "bold" ? true: false;
    $("blockContentWeight").onclick = changeBold.bind(this, $("blockContentWeight"), ".blockcontent");
    var blockContentColor = getBlockStyle(".blockcontent", "color");
    $("blockContentColor").value = blockContentColor;
    changeCtrlColor("blockContentColor");
    $("blockContentColorCtrl").style.cursor = "pointer";
    $("blockContentColorCtrl").onclick = readyChangeColor.bind(this, "blockContentColor", ".blockcontent", "color");
    var blockContentHrefColor = getBlockStyle(".blockcontent a", "color");
    $("blockContentHrefColor").value = blockContentHrefColor;
    changeCtrlColor("blockContentHrefColor");
    $("blockContentHrefColorCtrl").style.cursor = "pointer";
    $("blockContentHrefColorCtrl").onclick = readyChangeColor.bind(this, "blockContentHrefColor", ".blockcontent a", "color");
    var blockContentHoverColor = getBlockStyle(".blockcontent a:hover", "color");
    $("blockContentHoverColor").value = blockContentHoverColor;
    changeCtrlColor("blockContentHoverColor");
    $("blockContentHoverColorCtrl").style.cursor = "pointer";
    $("blockContentHoverColorCtrl").onclick = readyChangeColor.bind(this, "blockContentHoverColor", ".blockcontent a:hover", "color");
    var blockContentBorderStyle = getBlockStyle("", "borderTopStyle");
    setSelected("blockContentBorderStyle", blockContentBorderStyle);
    $("blockContentBorderStyle").onchange = function() {
        setBlockStyle("border-style", this.value, "");
    };
    var blockContentBorderWidth = getBlockStyle("", "borderTopWidth");
    setSelected("blockContentBorderWidth", blockContentBorderWidth);
    $("blockContentBorderWidth").onchange = function() {
        setBlockStyle("border-width", this.value, "");
    };
    var blockContentBorderColor = getBlockStyle("", "borderTopColor");
    $("blockContentBorderColor").value = blockContentBorderColor;
    changeCtrlColor("blockContentBorderColor");
    $("blockContentBorderColorCtrl").style.cursor = "pointer";
    $("blockContentBorderColorCtrl").onclick = readyChangeColor.bind(this, "blockContentBorderColor", "", "border-color");
    var blockContentBgImg = getBlockStyle(".blockcontent", "backgroundImage");
    $("oldContentBgImg").value = blockContentBgImg;
    var blockContentBgRepeat = getBlockStyle(".blockcontent", "backgroundRepeat");
    setSelected("blockContentBgRepeat", blockContentBgRepeat);
    $("blockContentBgRepeat").onchange = function() {
        setBlockStyle("background-repeat", this.value, ".blockcontent");
    };
    var blockContentBgPosition = getBlockStyle(".blockcontent", "backgroundPosition");
    var selectp = 0;
    for (var p in place) {
        if (place[p] == blockContentBgPosition) {
            selectp = p;
        }
    }
    setBackgroundPosition("selectContentPlace", selectp);
    var blockContentBgColor = getBlockStyle(".blockcontent", "background-color");
    $("blockContentBgColor").value = blockContentBgColor;
    changeCtrlColor("blockContentBgColor");
    $("blockContentBgColorCtrl").style.cursor = "pointer";
    $("blockContentBgColorCtrl").onclick = readyChangeColor.bind(this, "blockContentBgColor", ".blockcontent", "background-color");
    if (currentBlock == "player") {
        $("playerTop").style.display = "";
        var playerTop = getBlockStyle(".musicbody .music", "top");
        playerTop = playerTop / 128 * 100;
        $("sliderHPlayer").style.left = playerTop + "px";
        var playerMove = new drag("sliderHPlayer", "", "hxMoveRangePlayer", "horizontal", changePlayerHeight, 1);
        playerMove.cursor = "default";
    }
};
callbackSetBlock.prototype.close = function(obj) {
    submitCurrentBlockCss();
    tmpStyle = [];
    $("qwert").style.display = "none";
};
function changePlayerHeight(obj) {
    var maxL = 128;
    var value = parseInt(obj.body.style.left);
    value = parseInt(maxL * value / 100);
    setBlockStyle("top", value, ".musicbody .music");
}
function changeTitleHeight(obj) {
    var minL = 20;
    var maxL = 60;
    var value = parseInt(obj.body.style.left);
    value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    if ($("titleHeight")) {
        $("titleHeight").value = value;
    }
    setBlockStyle("height", value, ".blocktitle");
    setBlockStyle("line-height", value, ".blocktitle");
}
function changeBlockTitlePaddingLeft(obj) {
    var minL = 18;
    var maxL = 50;
    var value = parseInt(obj.body.style.left);
    value = parseInt(minL + (maxL - minL) * (value + 1) / 100);
    if ($("titleLeft")) {
        $("titleLeft").value = value;
    }
    setBlockStyle("padding-left", value, ".blocktitle");
}
function setEffectAll(tag, property, value) {
    var selector = ".block" + (tag == "" ? "": " " + tag);
    var setvalue = value.replace(property + ":", "");
    var property2js = property.replace(/-([a-z])/g, 
    function($0, $1) {
        return $1.toUpperCase();
    });
    if (false == dss.setRule(selector, property2js, setvalue)) {
        dss.addRule(selector, value);
    }
}
function submitCurrentBlockCss() {
    if (true == $('setAllBlock').checked) {
        $('onlyCurrentBlock').checked = true;
        if (false == confirm(spaceLangs['setAllBlockCheck'])) {
            return false
        }
        dss.removeAllRule();
        if ('undefined' == typeof(diyStyle['effectAll'])) {
            diyStyle['effectAll'] = [];
            diyStyle['effectAll'] = diyStyle['block'][currentBlock]
        } else {
            for (var blockClass in diyStyle['block'][currentBlock]) {
                if ('undefined' == typeof(diyStyle['effectAll'][blockClass])) {
                    diyStyle['effectAll'][blockClass] = []
                }
                for (var tag in diyStyle['block'][currentBlock][blockClass]) {
                    diyStyle['effectAll'][blockClass][tag] = diyStyle['block'][currentBlock][blockClass][tag]
                }
            }
        }
        for (var j in diyStyle['block']) {
            var noBlocks = ['body', 'banner', 'title', 'menu', 'footer'];
            if (in_array(j, noBlocks)) {
                continue
            } else {
                diyStyle['block'][j] = [];
            }
        }
        for (var tag in diyStyle['effectAll']) {
            for (var property in diyStyle['effectAll'][tag]) {
                setEffectAll(tag, property, diyStyle['effectAll'][tag][property])
            }
        }
			jquery.each(jquery("#dleft").children('div'),function(){
			diyStyle['block'][jquery(this).attr("id")]=diyStyle['effectAll'];
															  });
		jquery.each(jquery("#dright").children('div'),function(){
			diyStyle['block'][jquery(this).attr("id")]=diyStyle['effectAll'];
															  });
		jquery.each(jquery("#dcontent").children('div'),function(){
			diyStyle['block'][jquery(this).attr("id")]=diyStyle['effectAll'];
															  });
    }
}
function styleSave() {
    diyStyle.frame = defaultFrame;
    var leftDivs = contentDivs = [];
    diyStyle.allFrame = [];
    diyStyle.allFrame.dleft = [];
    divClass = P("className", "block", $("dleft"));
    for (var i in divClass) {
        if ("none" != divClass[i].style.display) {
            diyStyle.allFrame.dleft[i] = divClass[i].id;
        }
    }
    diyStyle.allFrame.dcontent = [];
    divClass = P("className", "block", $("dcontent"));
    for (var i in divClass) {
        if ("none" != divClass[i].style.display) {
            diyStyle.allFrame.dcontent[i] = divClass[i].id;
        }
    }
    if (in_array(defaultFrame, threeMod)) {
        diyStyle.allFrame.dright = [];
        divClass = P("className", "block", $("dright"));
        for (var i in divClass) {
            if ("none" != divClass[i].style.display) {
                diyStyle.allFrame.dright[i] = divClass[i].id;
            }
        }
    }
    $("diyStyle").value = phpserialize.serialize(diyStyle);
    $("diyForm").submit();
}
function styleBack() {
    if (confirm(spaceLangs.styleBack) == false) {
        return false;
    }
    $("getBack").value = "1";
    $("diyForm").submit();
}