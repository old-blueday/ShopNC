function isEmpty(obj) {
    result = false;
    switch (typeof obj) {
    case "number":
        if (0 == obj) {
            result = true;
        }
        break;
    case "string":
        if (0 == obj.length) {
            result = true;
        }
        break;
    case "undefined":
        result = true;
        break;
    default:
        if (isArray(obj) && 0 == obj.length) {
            result = true;
        }
        break;
    }
    return result;
}
function isArray(obj) {
    try {
        if ( - 1 == obj.constructor.toString().indexOf("function Array")) {
            return false;
        } else {
            return true;
        }
    } catch(e) {
        return false;
    }
}
function isObject(obj) {
    try {
        if ( - 1 == obj.constructor.toString().indexOf("function Object")) {
            return false;
        } else {
            return true;
        }
    } catch(e) {
        return false;
    }
}
function getWindowInfo() {
    var _h = parseInt(document.documentElement.clientHeight);
    var _w = parseInt(document.documentElement.clientWidth);
    var _sL = parseInt(document.documentElement.scrollLeft);
    var _sT = parseInt(document.documentElement.scrollTop);
    var _mH = parseInt(document.body.clientHeight);
    var _mW = parseInt(document.body.clientWidth);
    return {
        height: _h,
        width: _w,
        maxHeight: _mH,
        maxWidth: _mW,
        scrollLeft: _sL,
        scrollTop: _sT
    };
}
function getStyle(elem, style) {
    if (elem.currentStyle) {
        style = style.replace(/-([a-z])/g, 
        function($0, $1) {
            return $1.toUpperCase();
        });
        value = elem.currentStyle[style];
    } else if (window.getComputedStyle) {
        var css = document.defaultView.getComputedStyle(elem, null);
        value = css ? css.getPropertyValue(style) : null;
    }
    return value == "auto" ? null: value;
}
function rgb(r, g, b, includeHash) {
    if (includeHash == undefined) {
        includeHash = true;
    }
    r = r.toString(16);
    if (r.length == 1) {
        r = "0" + r;
    }
    g = g.toString(16);
    if (g.length == 1) {
        g = "0" + g;
    }
    b = b.toString(16);
    if (b.length == 1) {
        b = "0" + b;
    }
    return ((includeHash ? "#": "") + r + g + b).toUpperCase();
}
function T(tagName, targetElement) {
    if ("object" != typeof targetElement) {
        targetElement = document;
    }
    return targetElement.getElementsByTagName(tagName);
}
function P(prototype, value, targetElement) {
    if ("object" != typeof targetElement) {
        targetElement = document;
    }
    var children = targetElement.getElementsByTagName("*");
    var elements = [];
    var Len = children.length;
    var pv = "";
    for (var i = 0; i < Len; i++) {
        pv = children[i][prototype] || children[i].getAttribute(prototype);
        if ( - 1 != (" " + pv + " ").indexOf(" " + value + " ")) {
            elements.push(children[i]);
        }
    }
    return elements;
}
function getTarget(event) {
    event = doane(event);
    return event.srcElement || event.target;
}
function keyCode(event) {
    event = doane(event);
    return event.charCode || event.keyCode;
}
function getEvent() {
    if (document.all) {
        return window.event;
    }
    func = getEvent.caller;
    while (null != func) {
        var argF = func.arguments[0];
        if (argF && argF.constructor == MouseEvent) {
            return argF;
        }
        func = func.caller;
    }
    return null;
}
function fireEvent(id, e) {
    var element = $(id);
    if (!element) {
        return false;
    }
    if (document.createEvent) {
        var evObj = document.createEvent("MouseEvents");
        evObj.initEvent(e, true, true);
        element.dispatchEvent(evObj);
        return true;
    } else if (document.createEventObject) {
        element.fireEvent("on" + e);
        return true;
    }
    return false;
}
function arrayUnset(arr, key) {
    if (typeof arr[key] == "undefined") {
        return false;
    }
    var tmp = [];
    for (var i in arr) {
        if (i == key) {
            continue;
        }
        tmp[i] = arr[i];
    }
    return tmp;
}
function setSelected(selectId, value) {
    var obj = $(selectId);
    if (obj == null || obj == "undefined") {
        alert(spaceTips.noSelectBox);
    }
    for (var i = 0; i < obj.options.length; i++) {
        if (obj.options[i].value == value) {
            obj.selectedIndex = i;
        }
    }
}
function changeAlbum(obj) {
    albumId = obj.value;
    if (!isEmpty(albumId)) {
        getpage(1, "space.php?do=selectBg&albumId=" + albumId + "&inajax=1");
    }
}
function getpage(page, myurl) {
    var getAlbum = new Ajax;
    $(contentDiv).innerHTML = "<img src=\"../templates/store/store_drag/images/loading.gif\" class=\"imgloading\" />";
    getAlbum.get(myurl, 
    function(s) {
        $(contentDiv).innerHTML = s;
    });
}
function getStyleList(myurl) {
    var getStyle = new Ajax;
    getStyle.get(myurl, 
    function(s) {
        $("myStyleList").innerHTML = s;
    });
}
function shareMyStyle(styleId, styleName) {
    if (confirm(spaceTips.shareCheck) == true) {
        $("styleName").value = styleName;
        $("styleId").value = styleId;
        fireEvent("shareStyleList", "mousedown");
    }
}
function delMyStyle(styleId) {
    if (confirm(spaceTips.deleteCheck) == true) {
        getStyleList("control.php?do=myStyle&op=del&styleId=" + styleId);
    }
}
function spaceCategory(url, dos) {
    var appendParent = $("append_parent");
    appendParent.innerHTML = "";
    try {
        clearInterval(MyMar);
    } catch(e) {}
    ajaxTip(spaceTips.loading);
    var aj = new Ajax;
    aj.get(url, 
    function(data) {
        var footer = $("footer");
        var tmpDiv = document.createElement("div");
        var reScript = new RegExp("<script([\\s\\S]*?)>([\\s\\S]*?)<\\/script>", "ig");
        var scripts = [];
        data = data.replace(reScript, 
        function($0, $1, $2) {
            scripts.push($0);
            return "";
        });
        tmpDiv.innerHTML = data;
        tmpDiv.style.display = "none";
        appendParent.appendChild(tmpDiv);
        var newLCR = getChildNodeOfAjax(tmpDiv);
        var tmpFrame = [];
        tmpDiv.parentNode.removeChild(tmpDiv);
        if (isEmpty(newLCR)) {
            spaceJsMsg(data);
            return;
        }
        for (var i in newLCR) {
            tmpFrame[i] = [];
            tmpFrame[i].id = newLCR[i].id;
            tmpFrame[i].className = newLCR[i].className;
            tmpFrame[i].html = newLCR[i].innerHTML;
        }
        delNodeMenuBetweenFooter();
        for (var i in tmpFrame) {
            tmpDiv = document.createElement("div");
            tmpDiv.id = tmpFrame[i].id;
            tmpDiv.className = tmpFrame[i].className;
            tmpDiv.innerHTML = tmpFrame[i].html;
            footer.parentNode.insertBefore(tmpDiv, footer);
        }
        try {
            evalscript(scripts.join(""));
        } catch(e) {}
        ajaxComplete();
    });
}
function spaceJsMsg(msg) {
    var reMsg = new RegExp("<(\\w+)([\\s\\S]*?)>([\\s\\S]*?)<\\/\\1>", "i");
    var reEmpty = new RegExp("(\\s*)", "i");
    var msgR = msg.replace(reMsg, 
    function($0, $1, $2, $3) {
        return $3;
    });
    msgR = msgR.replace(reEmpty, "");
    alert(msgR);
    ajaxComplete();
}
function delNodeMenuBetweenFooter() {
    var menuBody = P("className", "menubody").pop();
    while (1) {
        var currentNode = menuBody.nextSibling;
        if ("footer" == currentNode.id) {
            break;
        }
        currentNode.parentNode.removeChild(currentNode);
    }
}
function getChildNodeOfAjax(obj) {
    var arr = [];
    if (obj.hasChildNodes) {
        var nodeList = obj.childNodes;
        for (var i in nodeList) {
            if (1 == nodeList[i].nodeType && "DIV" == nodeList[i].nodeName.toUpperCase()) {
                arr.push(nodeList[i]);
            }
        }
    }
    return arr;
}
function spaceView(url, dos) {
    spaceCategory(url, dos);
}
function ajaxIframe() {
    if (!$("zhuxunIframe")) {
        var iframe = document.createElement("div");
        iframe.id = "zhuxunIframe";
        iframe.style.zIndex = 998;
        iframe.style.display = "none";
        iframe.style.backgroundColor = "#FFF";
        iframe.style.opacity = "0";
        iframe.style.position = "absolute";
        iframe.style.filter = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)";
        $("append_parent") ? $("append_parent").appendChild(iframe) : document.body.appendChild(iframe);
    }
    var zhuxunIframe = $("zhuxunIframe");
    zhuxunIframe.style.top = 0;
    zhuxunIframe.style.left = 0;
    zhuxunIframe.style.width = document.body.clientWidth + "px";
    zhuxunIframe.style.height = document.body.clientHeight + 70 + "px";
    zhuxunIframe.style.display = "block";
}
function ajaxTip(str) {
    ajaxIframe();
    if (!$("zhuxunTip")) {
        var div = document.createElement("div");
        div.id = "zhuxunTip";
        div.style.zIndex = 9999;
        div.style.display = "none";
        div.style.position = "absolute";
        $("append_parent") ? $("append_parent").appendChild(div) : document.body.appendChild(div);
    }
    var zhuxunTip = $("zhuxunTip");
    zhuxunTip.className = "popupmenu_centerbox";
    zhuxunTip.style.top = document.documentElement.scrollTop + (document.documentElement.clientHeight - 80) / 2 + "px";
    zhuxunTip.style.right = (document.documentElement.clientWidth - 300) / 2 + "px";
    zhuxunTip.style.width = "300px";
    zhuxunTip.style.height = "80px";
    zhuxunTip.style.lineHeight = "80px";
    zhuxunTip.style.display = "block";
    zhuxunTip.style.textAlign = "center";
    if (isEmpty(str)) {
        str = spaceTips.loading;
    }
    zhuxunTip.innerHTML = "<div style=\"width:300px;background-color:#FFF;\">" + str + "</div>";
}
function ajaxComplete() {
    $("zhuxunTip").style.display = "none";
    $("zhuxunIframe").style.display = "none";
}
function PHP_Serializer(stype) {
    function serialize(v) {
        var s;
        switch (v) {
        case null:
            s = "N;";
            break;
        default:
            s = this[this.__sc2s(v)] ? this[this.__sc2s(v)](v) : this[this.__sc2s(__o)](v);
            break;
        }
        return s;
    }
    function unserialize(s) {
        __c = 0;
        __s = s;
        return this[__s.substr(__c, 1)]();
    }
    function stringBytes(s) {
        return s.length;
    }
    function stringBytesUTF8(s) {
        var c,
        b = 0,
        l = s.length;
        while (l) {
            c = s.charCodeAt(--l);
            b += c < 128 ? 1: c < 2048 ? 2: c < 65536 ? 3: 4;
        }
        return b;
    }
    function stringBytesGBK(s) {
        var c,
        b = 0,
        l = s.length;
        while (l) {
            c = s.charCodeAt(--l);
            b += c < 128 ? 1: c < 2048 ? 2: c < 65536 ? 2: 4;
        }
        return b;
    }
    function stringBytesGBK(s) {
        var c,
        b = 0,
        l = s.length;
        while (l) {
            c = s.charCodeAt(--l);
            b += c < 128 ? 1: c < 2048 ? 2: c < 65536 ? 2: 4;
        }
        return b;
    }
    function __sc2s(v) {
        return v.constructor.toString();
    }
    function __sc2sKonqueror(v) {
        var f;
        switch (typeof v) {
        case "string" || v instanceof String: f = "__sString";
            break;
        case "number" || v instanceof Number: f = "__sNumber";
            break;
        case "boolean" || v instanceof Boolean: f = "__sBoolean";
            break;
        case "function" || v instanceof Function: f = "__sFunction";
            break;
        default:
            f = v instanceof Array ? "__sArray": "__sObject";
            break;
        }
        return f;
    }
    function __sNConstructor(c) {
        return c === "[function]" || c === "(Internal Function)";
    }
    function __sCommonAO(v) {
        var b,
        n,
        a = 0,
        s = [];
        for (b in v) {
            n = v[b] == null;
            if (n || v[b].constructor != Function) {
                s[a] = [!isNaN(b) && parseInt(b).toString() === b ? this.__sNumber(b) : this.__sString(b), n ? "N;": this[this.__sc2s(v[b])] ? this[this.__sc2s(v[b])](v[b]) : this[this.__sc2s(__o)](v[b])].join(""); ++a;
            }
        }
        return [a, s.join("")];
    }
    function __sBoolean(v) {
        return ["b:", v ? "1": "0", ";"].join("");
    }
    function __sNumber(v) {
        var s = v.toString();
        return (s.indexOf(".") < 0 ? ["i:", s, ";"] : ["d:", s, ";"]).join("");
    }
    function __sString(v) {
        return ["s:", v.length, ":\"", v, "\";"].join("");
    }
    function __sStringUTF8(v) {
        return ["s:", this.stringBytes(v), ":\"", v, "\";"].join("");
    }
    function __sStringGBK(v) {
        return ["s:", this.stringBytes(v), ":\"", v, "\";"].join("");
    }
    function __sArray(v) {
        var s = this.__sCommonAO(v);
        return ["a:", s[0], ":{", s[1], "}"].join("");
    }
    function __sObject(v) {
        var o = this.__sc2s(v),
        n = o.substr(__n, o.indexOf("(") - __n),
        s = this.__sCommonAO(v);
        return ["O:", this.stringBytes(n), ":\"", n, "\":", s[0], ":{", s[1], "}"].join("");
    }
    function __sObjectIE7(v) {
        var o = this.__sc2s(v),
        n = o.substr(__n, o.indexOf("(") - __n),
        s = this.__sCommonAO(v);
        if (n.charAt(0) === " ") {
            n = n.substring(1);
        }
        return ["O:", this.stringBytes(n), ":\"", n, "\":", s[0], ":{", s[1], "}"].join("");
    }
    function __sObjectKonqueror(v) {
        var o = v.constructor.toString(),
        n = this.__sNConstructor(o) ? "Object": o.substr(__n, o.indexOf("(") - __n),
        s = this.__sCommonAO(v);
        return ["O:", this.stringBytes(n), ":\"", n, "\":", s[0], ":{", s[1], "}"].join("");
    }
    function __sFunction(v) {
        return "";
    }
    function __uCommonAO(tmp) {
        var a,
        k; ++__c;
        a = __s.indexOf(":", ++__c);
        k = parseInt(__s.substr(__c, a - __c)) + 1;
        __c = a + 2;
        while (--k) {
            tmp[this[__s.substr(__c, 1)]()] = this[__s.substr(__c, 1)]();
        }
        return tmp;
    }
    function __uBoolean() {
        var b = __s.substr(__c + 2, 1) === "1" ? true: false;
        __c += 4;
        return b;
    }
    function __uNumber() {
        var sli = __s.indexOf(";", __c + 1) - 2,
        n = Number(__s.substr(__c + 2, sli - __c));
        __c = sli + 3;
        return n;
    }
    function __uStringUTF8() {
        var c,
        sls,
        sli,
        vls,
        pos = 0;
        __c += 2;
        sls = __s.substr(__c, __s.indexOf(":", __c) - __c);
        sli = parseInt(sls);
        vls = sls = __c + sls.length + 2;
        while (sli) {
            c = __s.charCodeAt(vls);
            pos += c < 128 ? 1: c < 2048 ? 2: c < 65536 ? 3: 4; ++vls;
            if (pos === sli) {
                sli = 0;
            }
        }
        pos = vls - sls;
        __c = sls + pos + 2;
        return __s.substr(sls, pos);
    }
    function __uStringGBK() {
        var c,
        sls,
        sli,
        vls,
        pos = 0;
        __c += 2;
        sls = __s.substr(__c, __s.indexOf(":", __c) - __c);
        sli = parseInt(sls);
        vls = sls = __c + sls.length + 2;
        while (sli) {
            c = __s.charCodeAt(vls);
            pos += c < 128 ? 1: c < 2048 ? 2: c < 65536 ? 2: 4; ++vls;
            if (pos === sli) {
                sli = 0;
            }
        }
        pos = vls - sls;
        __c = sls + pos + 2;
        return __s.substr(sls, pos);
    }
    function __uString() {
        var sls,
        sli;
        __c += 2;
        sls = __s.substr(__c, __s.indexOf(":", __c) - __c);
        sli = parseInt(sls);
        sls = __c + sls.length + 2;
        __c = sls + sli + 2;
        return __s.substr(sls, sli);
    }
    function __uArray() {
        var a = this.__uCommonAO([]); ++__c;
        return a;
    }
    function __uObject() {
        var tmp = ["s", __s.substr(++__c, __s.indexOf(":", __c + 3) - __c)].join(""),
        a = tmp.indexOf("\""),
        l = tmp.length - 2,
        o = tmp.substr(a + 1, l - a);
        if (eval(["typeof(", o, ") === 'undefined'"].join(""))) {
            eval(["function ", o, "(){};"].join(""));
        }
        __c += l;
        eval(["tmp = this.__uCommonAO(new ", o, "());"].join("")); ++__c;
        return tmp;
    }
    function __uNull() {
        __c += 2;
        return null;
    }
    function __constructorCutLength() {
        function ie7bugCheck() {}
        var o1 = new ie7bugCheck,
        o2 = new Object,
        c1 = __sc2s(o1),
        c2 = __sc2s(o2);
        if (c1.charAt(0) !== c2.charAt(0)) {
            __ie7 = true;
        }
        return __ie7 || c2.indexOf("(") !== 16 ? 9: 10;
    }
    var __c = 0,
    __ie7 = false,
    __b = __sNConstructor(__c.constructor.toString()),
    __n = __b ? 9: __constructorCutLength(),
    __s = "",
    __a = [],
    __o = {},
    __f = function() {};
    PHP_Serializer.prototype.serialize = serialize;
    PHP_Serializer.prototype.unserialize = unserialize;
    PHP_Serializer.prototype.stringBytes = stype == "utf8" ? stringBytesUTF8: stype == "gbk" ? stringBytesGBK: stringBytes;
    if (__b) {
        PHP_Serializer.prototype.__sc2s = __sc2sKonqueror;
        PHP_Serializer.prototype.__sNConstructor = __sNConstructor;
        PHP_Serializer.prototype.__sCommonAO = __sCommonAO;
        PHP_Serializer.prototype[__sc2sKonqueror(__b)] = __sBoolean;
        PHP_Serializer.prototype.__sNumber = PHP_Serializer.prototype[__sc2sKonqueror(__n)] = __sNumber;
        PHP_Serializer.prototype.__sString = PHP_Serializer.prototype[__sc2sKonqueror(__s)] = stype == "utf8" ? __sStringUTF8: stype == "gbk" ? __sStringGBK: __sString;
        PHP_Serializer.prototype[__sc2sKonqueror(__a)] = __sArray;
        PHP_Serializer.prototype[__sc2sKonqueror(__o)] = __sObjectKonqueror;
        PHP_Serializer.prototype[__sc2sKonqueror(__f)] = __sFunction;
    } else {
        PHP_Serializer.prototype.__sc2s = __sc2s;
        PHP_Serializer.prototype.__sCommonAO = __sCommonAO;
        PHP_Serializer.prototype[__sc2s(__b)] = __sBoolean;
        PHP_Serializer.prototype.__sNumber = PHP_Serializer.prototype[__sc2s(__n)] = __sNumber;
        PHP_Serializer.prototype.__sString = PHP_Serializer.prototype[__sc2s(__s)] = stype == "utf8" ? __sStringUTF8: stype == "gbk" ? __sStringGBK: __sString;
        PHP_Serializer.prototype[__sc2s(__a)] = __sArray;
        PHP_Serializer.prototype[__sc2s(__o)] = __ie7 ? __sObjectIE7: __sObject;
        PHP_Serializer.prototype[__sc2s(__f)] = __sFunction;
    }
    PHP_Serializer.prototype.__uCommonAO = __uCommonAO;
    PHP_Serializer.prototype.b = __uBoolean;
    PHP_Serializer.prototype.i = PHP_Serializer.prototype.d = __uNumber;
    PHP_Serializer.prototype.s = stype == "utf8" ? __uStringUTF8: stype == "gbk" ? __uStringGBK: __uString;
    PHP_Serializer.prototype.a = __uArray;
    PHP_Serializer.prototype.O = __uObject;
    PHP_Serializer.prototype.N = __uNull;
}
Function.prototype.bindAsEventListener = function() {
    var __method = this;
    var args = Array.prototype.slice.call(arguments);
    var object = args.shift();
    return function(event) {
        var e = event || window.event;
        __method.apply(object, (new Array(e)).concat(args));
    };
};
Function.prototype.bind = function() {
    var __method = this;
    var args = Array.prototype.slice.call(arguments);
    var object = args.shift();
    return function() {
        return __method.apply(object, args.concat());
    };
};
function drag(body, head, range, direction, callback, click) {
    if (isEmpty(body)) {
        return false;
    }
    if (isEmpty(head)) {
        head = body;
    }
    if (isEmpty(range)) {
        range = null;
    }
    if (isEmpty(direction)) {
        direction = null;
    }
    if (isEmpty(callback)) {
        callback = null;
    }
    if (isEmpty(click)) {
        click = null;
    }
    this.click = click;
    this.callback = callback;
    this.direction = null == direction ? "": direction.substr(0, 1).toUpperCase();
    this.range = null == range ? null: this.$(range);
    this.head = this.$(head);
    this.body = this.$(body);
    this.element = false;
    this.cursor = "move";
    this.head.onmousedown = this.ready.bindAsEventListener(this);
    this.head.onmouseover = this.over.bindAsEventListener(this);
    if (this.range && this.click) {
        this.range.onmousedown = this.rangeClick.bindAsEventListener(this);
    }
}
drag.prototype.$ = function(id) {
    if ("object" == typeof id) {
        return id;
    }
    return document.getElementById(id);
};
drag.prototype.rangeClick = function(event) {
    event = event || window.event;
    var _LT = fetchOffset(this.range);
    var x = parseInt(event.clientX) + document.documentElement.scrollLeft - _LT.left - this.body.offsetWidth / 2;
    var y = parseInt(event.clientY) + document.documentElement.scrollTop - _LT.top - this.body.offsetHeight / 2;
    this.setLeftTop(this.body, x, y);
    this.ready(event);
    this.move(event);
};
drag.prototype.setLeftTop = function(obj, x, y, L, T) {
    if ("V" != this.direction) {
        obj.style.left = x + "px";
    }
    if ("H" != this.direction) {
        obj.style.top = y + "px";
    }
    if ("undefined" != typeof L && null != L) {
        document.documentElement.scrollLeft = L;
    }
    if ("undefined" != typeof T && null != T) {
        document.documentElement.scrollTop = T;
    }
};
drag.prototype.ready = function(event) {
    var __method = this;
    event = event || window.event;
    this.element = this.body;
    this.preMouseX = this.curMouseX = this.mouseX = parseInt(event.clientX);
    this.preMouseY = this.curMouseY = this.mouseY = parseInt(event.clientY);
    this.leftTop = fetchOffset(this.element);
    this.windowInfo = getWindowInfo();
    var _BL = parseInt(getStyle(this.element, "border-left-width"));
    var _BR = parseInt(getStyle(this.element, "border-right-width"));
    _BL = isNaN(_BL) ? 0: _BL;
    _BR = isNaN(_BR) ? 0: _BR;
    this.element.style.width = this.element.offsetWidth - _BL - _BR + "px";
    this.element.style.position = "absolute";
    if (this.range) {
        this.rangeLT = fetchOffset(this.range);
        this.rangeLT.width = this.range.offsetWidth;
        this.rangeLT.height = this.range.offsetHeight;
    }
    document.onmousemove = this.move.bindAsEventListener(this);
    document.onmouseup = this.stop.bindAsEventListener(this);
    this.setCapture(event);
    doane(event);
    if (this.callback) {
        this.callback(__method);
    }
};
drag.prototype.setCapture = function(event) {
    event = event || window.event;
    if (is_ie) {
        document.documentElement.setCapture();
    } else if (window.captureEvents) {
        window.captureEvents(event.MOUSEMOVE | event.MOUSEUP);
    }
};
drag.prototype.releaseCapture = function(event) {
    if (is_ie) {
        document.documentElement.releaseCapture();
    } else if (window.captureEvents) {
        window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP);
    }
};
drag.prototype.scrollMove = function(event, x, y) {
    var _T = null,
    _L = null;
    if (this.range) {
        if (x < this.rangeLT.left) {
            x = 0;
        } else if (x > this.rangeLT.left + this.rangeLT.width - this.element.offsetWidth) {
            x = this.rangeLT.width - this.element.offsetWidth;
        } else {
            x = parseInt(event.clientX) + document.documentElement.scrollLeft - this.rangeLT.left - this.element.offsetWidth / 2;
        }
        if (y < this.rangeLT.top) {
            y = 0;
        } else if (y > this.rangeLT.top + this.rangeLT.height - this.element.offsetHeight) {
            y = this.rangeLT.height - this.element.offsetHeight;
        } else {
            y = parseInt(event.clientY) + document.documentElement.scrollTop - this.rangeLT.top - this.element.offsetHeight / 2;
        }
        return {
            x: x,
            y: y
        };
    }
    if (document.body.clientHeight > y + parseInt(this.element.offsetHeight)) {
        if (y < this.windowInfo.scrollTop && 0 <= y && this.curMouseY < this.preMouseY) {
            _sT = this.windowInfo.scrollTop - y;
            _T = this.windowInfo.scrollTop = y;
            if (0 < _sT) {
                this.leftTop.top -= _sT;
                y -= _sT;
            } else {
                _T = this.windowInfo.scrollTop = 0;
            }
        } else if (this.windowInfo.height + this.windowInfo.scrollTop < y + parseInt(this.element.offsetHeight) && this.windowInfo.maxHeight >= y + parseInt(this.element.offsetHeight) && this.curMouseY > this.preMouseY) {
            _sT = y + parseInt(this.element.offsetHeight) - this.windowInfo.height - this.windowInfo.scrollTop;
            _T = this.windowInfo.scrollTop += _sT;
            if (this.windowInfo.maxHeight >= y + parseInt(this.element.offsetHeight)) {
                this.leftTop.top += _sT;
                y += _sT;
            } else {
                _T = this.windowInfo.scrollTop = this.windowInfo.maxHeight - this.windowInfo.height;
            }
        }
    }
    return {
        x: x,
        y: y,
        L: _L,
        T: _T
    };
};
drag.prototype.move = function(event) {
    var __method = this;
    event = event || window.event;
    if (this.element) {
        var x,
        y;
        this.preMouseX = this.curMouseX;
        this.preMouseY = this.curMouseY;
        this.curMouseX = parseInt(event.clientX);
        this.curMouseY = parseInt(event.clientY);
        x = this.curMouseX - this.mouseX + this.leftTop.left;
        y = this.curMouseY - this.mouseY + this.leftTop.top;
        xyLT = this.scrollMove(event, x, y);
        this.setLeftTop(this.element, xyLT.x, xyLT.y, xyLT.L, xyLT.T);
        document.onmousemove = null;
        setTimeout(function() {
            document.onmousemove = __method.move.bindAsEventListener(__method);
        },
        20);
        if (is_ie) {
            document.selection.empty();
        } else {
            window.getSelection().removeAllRanges();
        }
        if (this.callback) {
            this.callback(__method);
        }
    }
};
drag.prototype.stop = function(event) {
    var __method = this;
    if (false == this.element) {
        return true;
    }
    if (!this.range) {
        var LT = fetchOffset(this.element);
        if (0 > LT.left) {
            this.element.style.left = "0px";
        }
        if (0 > LT.top) {
            this.element.style.top = "0px";
        }
        if (LT.left + parseInt(this.element.offsetWidth) > this.windowInfo.maxWidth) {
            this.element.style.left = this.windowInfo.maxWidth - this.element.offsetWidth + "px";
        }
    }
    this.element = false;
    this.releaseCapture();
    if (this.callback) {
        this.callback(__method);
    }
};
drag.prototype.over = function(event) {
    this.head.style.cursor = this.cursor;
};
function transfer(sourceId, closeId, dstId, dstSuffix, callback, dstDragHead) {
    if (isEmpty(sourceId) || isEmpty(dstId)) {
        return false;
    }
    if (isEmpty(closeId)) {
        closeId = null;
    }
    if (isEmpty(dstSuffix)) {
        dstSuffix = "_div";
    }
    if (isEmpty(dstId)) {
        dstId = sourceId + dstSuffix;
    }
    if (isEmpty(callback)) {
        callback = null;
    }
    if (isEmpty(dstDragHead)) {
        dstDragHead = null;
    }
    this.timer = 20;
    this.steps = 20;
    this.dstObj = $(dstId);
    this.sourceObj = $(sourceId);
    this.closeObj = $(closeId);
    this.dstDragHead = $(dstDragHead);
    this.callback = callback;
    this.dstObj.style.display = "";
    this.dstHeight = parseInt(this.dstObj.offsetHeight);
    this.dstWidth = parseInt(this.dstObj.offsetWidth);
    this.dstObj.style.display = "none";
    if (this.sourceObj && this.dstObj) {
        this.sourceObj.onmousedown = this.maxEffect.bindAsEventListener(this);
        if (!this.closeObj) {
            this.closeObj = P("className", closeId, this.dstObj).pop();
        }
        if (this.closeObj) {
            this.closeObj.onclick = this.minEffect.bindAsEventListener(this);
        }
    }
}
transfer.prototype.getDistance = function() {
    var y = (this.windowInfo.height - this.dstHeight) / 2;
    var x = (this.windowInfo.width - this.dstWidth) / 2;
    if (0 > y) {
        y = 0;
    }
    if (0 > x) {
        x = 0;
    }
    var distancex = x - this.mouseX;
    var distancey = y - this.mouseY;
    x += this.scrollLeft;
    y += this.scrollTop;
    return {
        x: x,
        y: y,
        distancex: distancex,
        distancey: distancey
    };
};
transfer.prototype.maxEffect = function(event) {
    if ("none" != this.dstObj.style.display) {
        return false;
    }
    var __method = this;
    try {
        if (false == this.callback.prototype.ready(__method)) {
            return;
        }
    } catch(e) {}
    event = event || window.event || getEvent();
    this.curstep = 0;
    this.scrollTop = document.documentElement.scrollTop;
    this.scrollLeft = document.documentElement.scrollLeft;
    this.windowInfo = getWindowInfo();
    this.mouseX = parseInt(event.clientX);
    this.mouseY = parseInt(event.clientY);
    if (isNaN(this.mouseX)) {
        this.mouseX = 0;
    }
    if (isNaN(this.mouseY)) {
        this.mouseY = 0;
    }
    this.distance = this.getDistance();
    this.stepX = this.distance.distancex / this.steps;
    this.stepY = this.distance.distancey / this.steps;
    this.stepDivX = this.dstWidth / this.steps;
    this.stepDivY = this.dstHeight / this.steps;
    this.divObj = document.createElement("div");
    this.divObj.className = "transfer";
    this.divObj.style.display = "";
    this.divObj.style.position = "absolute";
    document.body.appendChild(this.divObj);
    if (!$("qwert")) {
        var iframe = document.createElement("div");
        iframe.id = "qwert";
        iframe.style.zIndex = 998;
        iframe.style.display = "none";
        iframe.style.backgroundColor = "#FFF";
        iframe.style.opacity = "0";
        iframe.style.position = "absolute";
        iframe.style.filter = "progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)";
        $("append_parent") ? $("append_parent").appendChild(iframe) : menuObj.parentNode.appendChild(iframe);
    }
    var qwert = $("qwert");
    qwert.style.top = 0;
    qwert.style.left = 0;
    qwert.style.width = document.body.clientWidth + "px";
    qwert.style.height = document.body.clientHeight + 70 + "px";
    qwert.style.display = "block";
    this.interval = setInterval(function() {
        __method.showDiv();
    },
    this.timer);
    try {
        doane(event);
    } catch(e) {}
};
transfer.prototype.showDiv = function() {
    __method = this;
    this.curstep += 1;
    var _T = this.curstep * this.stepY;
    var _L = this.curstep * this.stepX;
    var _W = this.stepDivX * this.curstep;
    var _H = this.stepDivY * this.curstep;
    this.divObj.style.left = this.scrollLeft + this.mouseX + _L + "px";
    this.divObj.style.top = this.scrollTop + this.mouseY + _T + "px";
    this.divObj.style.width = _W + "px";
    this.divObj.style.height = _H + "px";
    this.divObj.style.zIndex = 2008;
    if (this.steps <= this.curstep) {
        this.dstObj.style.display = "";
        this.dstObj.style.position = "absolute";
        this.dstObj.style.left = this.distance.x + "px";
        this.dstObj.style.top = this.distance.y + "px";
        clearInterval(this.interval);
        document.body.removeChild(this.divObj);
        try {
            this.callback.prototype.complete(__method);
        } catch(e) {}
    }
};
transfer.prototype.minEffect = function(event) {
    __method = this;
    this.dstObj.style.display = "none";
    try {
        this.callback.prototype.close(__method);
    } catch(e) {}
};
function selectColor(callback) {
    var __method = this;
    if (isEmpty(callback)) {
        callback = null;
    }
    this.imageDir = "../templates/store/store_drag/images/";
    this.callback = callback;
    this.crossHairObj = $("clrCrosshairs");
    this.rangeArrowObj = $("clrRangeArrows");
    this.previewObj = $("clrPreview");
    this.saturationObj = $("clrColor");
    this.iptObj = $("clrColorValue");
    this.hueObj = $("clrHue");
    this.hueColorObj = $("clrBGColor");
    this.rgb = {};
    this.hsv = {};
    this.iptObj.onchange = this.init.bindAsEventListener(this);
    this.rangeArrowDrag = new drag("clrRangeArrows", "", "clrHue", "vertical", 
    function(obj) {
        __method.hsv.h = Math.abs(parseInt(obj.body.style.top)) / 199;
        __method.hsvChange();
    },
    1);
    this.rangeArrowDrag.cursor = "default";
    this.crossHairDrag = new drag("clrCrosshairs", "", "clrColor", "", 
    function(obj) {
        __method.hsv.s = 1 - Math.abs(parseInt(obj.body.style.top)) / 199;
        __method.hsv.v = Math.abs(parseInt(obj.body.style.left)) / 199;
        __method.hsvChange();
    },
    1);
    this.crossHairDrag.cursor = "default";
    this.init();
}
selectColor.prototype.hsvChange = function() {
    this.rgb = rgbHexHsv.prototype.hsv2rgb(this.hsv.h, this.hsv.s, this.hsv.v);
    this.colorChanged();
};
selectColor.prototype.init = function() {
    this.fixPNG(this.imageDir + "sv.png", "clrSv", this.hueColorObj);
    this.fixPNG(this.imageDir + "h.png", "clrH", this.hueObj);
    this.color = this.iptObj.value;
    if ("" == this.color) {
        this.color = "#FFFF00";
        this.iptObj.value = "#FFFF00";
    }
    this.rgb = rgbHexHsv.prototype.hex2rgb(this.color, {
        r: 0,
        g: 0,
        b: 0
    });
    this.rgbChanged();
};
selectColor.prototype.fixPNG = function(imgsrc, curid, parentObj) {
    if ($(curid)) {
        return false;
    }
    if (is_ie && 7 > is_ie && document.body.filters) {
        var tmpDiv = document.createElement("div");
        tmpDiv.id = curid;
        tmpDiv.style.setAttribute("filter", "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + imgsrc + "', sizingMethod='scale')");
        parentObj.appendChild(tmpDiv);
    } else {
        var tmpImg = document.createElement("img");
        tmpImg.id = curid;
        tmpImg.galleryimg = "false";
        tmpImg.src = imgsrc;
        parentObj.appendChild(tmpImg);
    }
};
selectColor.prototype.rgbChanged = function() {
    this.hsv = rgbHexHsv.prototype.rgb2hsv(this.rgb.r, this.rgb.g, this.rgb.b);
    this.colorChanged();
};
selectColor.prototype.colorChanged = function() {
    var __method = this;
    var hex = rgbHexHsv.prototype.rgb2hex(this.rgb.r, this.rgb.g, this.rgb.b);
    var hueRgb = rgbHexHsv.prototype.hsv2rgb(this.hsv.h, 1, 1);
    var hueHex = rgbHexHsv.prototype.rgb2hex(hueRgb.r, hueRgb.g, hueRgb.b);
    this.previewObj.style.background = hex;
    this.iptObj.value = hex;
    this.hueColorObj.style.background = hueHex;
    this.crossHairObj.style.left = (this.hsv.v * 199).toString() + "px";
    this.crossHairObj.style.top = ((1 - this.hsv.s) * 199).toString() + "px";
    this.rangeArrowObj.style.left = "-8px";
    this.rangeArrowObj.style.top = (this.hsv.h * 199).toString() + "px";
    if ("none" == this.crossHairObj.style.display) {
        this.crossHairObj.style.display = "";
    }
    if ("none" == this.rangeArrowObj.style.display) {
        this.rangeArrowObj.style.display = "";
    }
    if (this.callback) {
        this.callback(__method);
    }
};
function rgbHexHsv() {}
rgbHexHsv.prototype.hex2rgb = function(hex_string, default_) {
    if (default_ == undefined) {
        default_ = null;
    }
    if (hex_string.substr(0, 1) == "#") {
        hex_string = hex_string.substr(1);
    }
    var r,
    g,
    b;
    if (hex_string.length == 3) {
        r = hex_string.substr(0, 1);
        r += r;
        g = hex_string.substr(1, 1);
        g += g;
        b = hex_string.substr(2, 1);
        b += b;
    } else if (hex_string.length == 6) {
        r = hex_string.substr(0, 2);
        g = hex_string.substr(2, 2);
        b = hex_string.substr(4, 2);
    } else {
        return default_;
    }
    r = parseInt(r, 16);
    g = parseInt(g, 16);
    b = parseInt(b, 16);
    if (isNaN(r) || isNaN(g) || isNaN(b)) {
        return default_;
    } else {
        return {
            r: r / 255,
            g: g / 255,
            b: b / 255
        };
    }
};
rgbHexHsv.prototype.rgb2hex = function(r, g, b, includeHash) {
    r = Math.round(r * 255);
    g = Math.round(g * 255);
    b = Math.round(b * 255);
    if (includeHash == undefined) {
        includeHash = true;
    }
    r = r.toString(16);
    if (r.length == 1) {
        r = "0" + r;
    }
    g = g.toString(16);
    if (g.length == 1) {
        g = "0" + g;
    }
    b = b.toString(16);
    if (b.length == 1) {
        b = "0" + b;
    }
    return ((includeHash ? "#": "") + r + g + b).toUpperCase();
};
rgbHexHsv.prototype.hsv2rgb = function(hue, saturation, value) {
    var red,
    green,
    blue;
    if (value == 0) {
        red = 0;
        green = 0;
        blue = 0;
    } else {
        var i = Math.floor(hue * 6);
        var f = hue * 6 - i;
        var p = value * (1 - saturation);
        var q = value * (1 - saturation * f);
        var t = value * (1 - saturation * (1 - f));
        switch (i) {
        case 1:
            red = q;
            green = value;
            blue = p;
            break;
        case 2:
            red = p;
            green = value;
            blue = t;
            break;
        case 3:
            red = p;
            green = q;
            blue = value;
            break;
        case 4:
            red = t;
            green = p;
            blue = value;
            break;
        case 5:
            red = value;
            green = p;
            blue = q;
            break;
        case 0:
        case 6:
            red = value;
            green = t;
            blue = p;
            break;
        default:
            ;
        }
    }
    return {
        r:
        red,
        g: green,
        b: blue
    };
};
rgbHexHsv.prototype.rgb2hsv = function(red, green, blue) {
    var max = Math.max(Math.max(red, green), blue);
    var min = Math.min(Math.min(red, green), blue);
    var hue;
    var saturation;
    var value = max;
    if (min == max) {
        hue = 0;
        saturation = 0;
    } else {
        var delta = max - min;
        saturation = delta / max;
        if (red == max) {
            hue = (green - blue) / delta;
        } else if (green == max) {
            hue = 2 + (blue - red) / delta;
        } else {
            hue = 4 + (red - green) / delta;
        }
        hue /= 6;
        if (hue < 0) {
            hue += 1;
        }
        if (hue > 1) {
            hue -= 1;
        }
    }
    return {
        h: hue,
        s: saturation,
        v: value
    };
};
function sortDrag(div, head, body, mask) {
    var __method = this;
    if (isEmpty(div)) {
        return false;
    }
    if (isEmpty(head)) {
        head = div;
    }
    if (isEmpty(body)) {
        body = null;
    }
    if (isEmpty(mask)) {
        this.mask = $("transferReady");
    }
    this.div = div;
    this.head = head;
    this.body = body;
    this.objs = {};
    this.objs[div] = P("className", div, document.body);
    this.objs[head] = P("className", head, document.body);
    this.isDrag = false;
    this.goDiv = false;
    var actionDiv = [div, head];
    if (body) {
        this.objs[body] = P("className", body, document.body);
    }
    this.drags = [];
    this.tdObjs = [];
    this.LCR = [];
    this.key2mod = [];
    this.curLCR = null;
    this.smallMax = "max";
    for (var i in this.objs[div]) {
        this.drags[i] = new drag(this.objs[div][i], "", "", "", 
        function(dragObj) {
            if (false == dragObj.element) {
                __method.isDrag = false;
                __method.back(dragObj);
                return false;
            }
            if ("none" != __method.mask.style.display) {}
            __method.isDrag = true;
            __method.move(dragObj);
        });
       this.objs[body][i].onmouseover = this.maskReady.bindAsEventListener(this, this.drags[i]);
    }
}
sortDrag.prototype.getLCR = function() {
    if (0 < this.LCR.length || 0 < this.tdObjs.length) {
        return true;
    }
    var _tds = P("className", "wowoFrameTd", document.body);
    for (var i in _tds) {
        this.tdObjs[_tds[i].id] = new Array;
        this.LCR[_tds[i].id] = _tds[i];
    }
    for (var i in this.objs[this.div]) {
        _pObj = this.objs[this.div][i].parentNode;
        this.key2mod[i] = _pObj.id;
        this.tdObjs[_pObj.id][i] = this.objs[this.div][i];
    }
};
sortDrag.prototype.insertAfter = function(newNode, targetNode) {
    var parentNode = targetNode.parentNode;
    if (targetNode.lastChild == parentNode) {
        parentNode.appendChild(newNode);
    } else {
        parentNode.insertBefore(newNode, targetNode.nextSibling);
    }
};
sortDrag.prototype.changeSize = function(smallMax, dragObj) {
    if ("max" == this.smallMax && "max" == smallMax) {
        return false;
    }
    if ("small" == this.smallMax && "small" == smallMax) {
        return false;
    }
    for (var i in this.objs[this.body]) {
        this.objs[this.body][i].style.display = "";
    }
    this.smallMax = "small";
    this.mask.style.display = "none";
    dragObj.windowInfo.scrollTop = document.documentElement.scrollTop;
    dragObj.windowInfo.scrollLeft = document.documentElement.scrollLeft;
    dragObj.leftTop.left = dragObj.mouseX + dragObj.windowInfo.scrollLeft - dragObj.body.offsetWidth / 2;
    dragObj.leftTop.top = dragObj.mouseY + dragObj.windowInfo.scrollTop - dragObj.body.offsetHeight / 2;
    dragObj.body.style.left = dragObj.leftTop.left + "px";
    dragObj.body.style.top = dragObj.leftTop.top + "px";
};
sortDrag.prototype.move = function(dragObj) {
    var sortId = null;
    var curFirst = null;
    var targetId = null;
    var LT = null;
    var scrollTop = document.documentElement.scrollTop;
    this.changeSize("small", dragObj);
    this.getLCR();
    if (null == this.curLCR) {
        for (var i in this.objs[this.div]) {
            if (dragObj.body == this.objs[this.div][i]) {
                this.curLCR = this.key2mod[i];
            }
        }
    }
    for (var i in this.LCR) {
        LT = fetchOffset(this.LCR[i]);
        if (null == curFirst || curFirst > LT.left) {
            curFirst = i;
        }
        if (dragObj.curMouseX > LT.left) {
            sortId = i;
        }
    }
    if (null == sortId) {
        sortId = curFirst;
    }
    var curTop = 0;
    var tmpTop = 0;
    for (var i in this.tdObjs[sortId]) {
        LT = fetchOffset(this.tdObjs[sortId][i]);
        tmpTop = parseInt(LT.top + this.tdObjs[sortId][i].offsetHeight / 2);
        tmpTop = isNaN(tmpTop) ? 0: tmpTop;
        if (dragObj.body != this.tdObjs[sortId][i] && dragObj.curMouseY + scrollTop < tmpTop && (curTop > tmpTop || 0 == curTop)) {
            targetId = i;
            curTop = tmpTop;
        }
    }
    if (false == this.goDiv) {
        this.goDiv = document.createElement("div");
        this.goDiv.className = "transfer";
        this.goDiv.style.display = "";
        this.goDiv.style.height = dragObj.body.clientHeight + "px";
    }
    if (null == targetId) {
        this.LCR[sortId].appendChild(this.goDiv);
        this.goDiv.style.width = "auto";
    } else {
        this.objs[this.div][targetId].parentNode.insertBefore(this.goDiv, this.objs[this.div][targetId]);
        this.goDiv.style.width = "auto";
    }
};
sortDrag.prototype.remove = function(arr, key) {
    if (isNaN(key) || "undefined" == typeof key) {
        return arr;
    }
    var tmpArr = [];
    for (var i in arr) {
        if (key != i) {
            tmpArr[i] = arr[i];
        }
    }
    return tmpArr;
};
sortDrag.prototype.back = function(dragObj) {
    this.mask.style.display = "none";
    this.goDiv.parentNode.insertBefore(dragObj.body, this.goDiv);
    this.goDiv.parentNode.removeChild(this.goDiv);
    dragObj.body.style.position = "static";
    dragObj.body.style.width = "auto";
    dragObj.body.style.height = "auto";
    _pObj = dragObj.body.parentNode;
    _pLT = fetchOffset(_pObj);
    var key = null;
    for (var i in this.objs[this.div]) {
        if (dragObj.body == this.objs[this.div][i]) {
            key = i;
        }
    }
    this.tdObjs[this.curLCR] = this.remove(this.tdObjs[this.curLCR], key);
    this.key2mod = this.remove(this.key2mod, key);
    this.key2mod[key] = _pObj.id;
    this.tdObjs[_pObj.id][key] = dragObj.body;
    this.curLCR = null;
    this.smallMax = "max";
    for (var i in this.objs[this.body]) {
        this.objs[this.body][i].style.display = "";
    }
    objLT = fetchOffset(dragObj.body);
    if (dragObj.body.clientHeight > document.documentElement.clientHeight) {
        document.documentElement.scrollTop = objLT.top - 10;
    } else {
        document.documentElement.scrollTop = objLT.top - (document.documentElement.clientHeight - dragObj.body.clientHeight) / 2;
    }
};
sortDrag.prototype.maskEnd = function(event, dragObj) {
    var scrollTop = document.documentElement.scrollTop;
    var scrollLeft = document.documentElement.scrollLeft;
    var x = parseInt(event.clientX) + scrollLeft;
    var y = parseInt(event.clientY) + scrollTop;
    var LT = fetchOffset(dragObj.body);
    if (LT.left >= x || LT.top >= y || LT.left + dragObj.body.offsetWidth <= x || LT.top + dragObj.body.offsetHeight <= y) {
        this.mask.style.display = "none";
    }
};
sortDrag.prototype.maskReady = function(event, dragObj) {
    currentBlock = dragObj.body.id;
    if (in_array(currentBlock, ["profile", "applist"])) {
        $("delblock").style.display = "none";
    } else {
        $("delblock").style.display = "";
    }
    if (true == this.isDrag) {
        return false;
    }
    this.mask.style.display = "";
    this.mask.style.position = "absolute";
    var LT = fetchOffset(dragObj.body);
    this.mask.style.left = LT.left + "px";
    this.mask.style.top = LT.top + "px";
    var _BL = parseInt(getStyle(dragObj.body, "border-left-width"));
    var _BR = parseInt(getStyle(dragObj.body, "border-right-width"));
    var _BT = parseInt(getStyle(dragObj.body, "border-top-width"));
    var _BB = parseInt(getStyle(dragObj.body, "border-bottom-width"));
    _BL = isNaN(_BL) ? 0: _BL;
    _BR = isNaN(_BR) ? 0: _BR;
    _BT = isNaN(_BT) ? 0: _BT;
    _BB = isNaN(_BB) ? 0: _BB;
    this.mask.style.width = dragObj.body.offsetWidth - _BL - _BR + "px";
    this.mask.style.height = dragObj.body.offsetHeight - _BT - _BB + "px";
    this.mask.onmouseout = this.maskEnd.bindAsEventListener(this, dragObj);
    this.mask.onmousedown = dragObj.head.onmousedown;
};
function sliderEffect(slide, direction, callback) {
    if ("undefined" == typeof slide || "" == slide) {
        return false;
    }
    if ("undefined" == typeof direction || "" == direction) {
        direction = null;
    }
    if ("undefined" == typeof callback || "" == callback) {
        callback = null;
    }
    this.callback = callback;
    this.slide = $(slide);
    this.direction = direction;
    var __method = this;
    this.timer = 7;
    this.steps = 20;
    this.curstep = 0;
    this.stepY = 0;
    this.pNode = null;
    this.interval = null;
    this.curstep = 0;
    this.pNode = this.slide.parentNode;
    if ("in" == this.direction) {
        this.stepY = this.slide.offsetHeight / this.steps;
    } else {
        this.stepY = this.pNode.offsetHeight / this.steps;
    }
    this.interval = setInterval(function() {
        __method.curstep++;
        if ("in" == __method.direction) {
            __method.pNode.style.height = __method.curstep * __method.stepY + "px";
        } else {
            __method.pNode.style.height = (this.steps - this.curstep) * __method.stepY + "px";
        }
        if (__method.curstep >= __method.steps) {
            __method.pNode = null;
            __method.curstep = 0;
            __method.stepY = 0;
            if ("out" == __method.direction) {
                __method.slide.style.display = "none";
            }
            clearInterval(__method.interval);
            if (__method.callback) {
                __method.callback();
            }
        }
    },
    this.timer);
}
function slider(slideOut, slideIn) {
    if ("undefined" == typeof slideIn || "" == slideIn) {
        slideIn = null;
    }
    if ("undefined" == typeof slideOut || "" == slideOut) {
        slideOut = null;
    }
    var __method = this;
    this.slideIn = slideIn;
    this.slideOut = slideOut;
    if (this.slideOut) {
        sliderEffect(this.slideOut, "out", 
        function() {
            if (__method.slideIn) {
                $(__method.slideIn).style.display = "";
                sliderEffect(__method.slideIn, "in");
            }
        });
    } else if (this.slideOut) {
        sliderEffect(this.slideOut, "out");
    }
}
function styleCss(n) {
    var _s;
    if (typeof n == "number") {
        _s = document.styleSheets[n];
    }
    this.sheet = _s;
    this.rules = _s.cssRules ? _s.cssRules: _s.rules;
}
styleCss.prototype.indexOf = function(selector) {
    for (i = 0; i < this.rules.length; i++) {
        if (this.rules[i].selectorText.toLowerCase() == selector.toLowerCase()) {
            return i;
        }
    }
    return - 1;
};
styleCss.prototype.removeRule = function(n) {
    if (typeof n == "number") {
        if (n < this.rules.length) {
            this.sheet.removeRule ? this.sheet.removeRule(n) : this.sheet.deleteRule(n);
        }
    } else {
        var i = this.indexOf(n);
        this.sheet.removeRule ? this.sheet.removeRule(i) : this.sheet.deleteRule(i);
    }
};
styleCss.prototype.addRule = function(selector, styles, n) {
    if (typeof n == "undefined") {
        n = this.rules.length;
    }
    this.sheet.insertRule ? this.sheet.insertRule(selector + "{" + styles + "}", n) : this.sheet.addRule(selector, styles, n);
};
styleCss.prototype.setRule = function(selector, attribute, value) {
    var i = this.indexOf(selector);
    if ( - 1 == i) {
        return false;
    }
    this.rules[i].style[attribute] = value;
};
styleCss.prototype.getRule = function(selector, attribute) {
    var i = this.indexOf(selector);
    if ( - 1 == i) {
        return false;
    }
    return this.rules[i].style[attribute];
};
styleCss.prototype.removeAllRule = function(noSearch) {
    var num = this.rules.length;
    var j = 0;
    for (i = 0; i < num; i++) {
        var selector = this.rules[this.rules.length - 1 - j].selectorText.toLowerCase();
        if (noSearch == 1 || selector.search(/^(body|#banner|#title|#menu|#footer)+?/) == -1) {
            this.sheet.removeRule ? this.sheet.removeRule(this.rules.length - 1 - j) : this.sheet.deleteRule(this.rules.length - 1 - j);
        } else {
            j++;
        }
    }
};