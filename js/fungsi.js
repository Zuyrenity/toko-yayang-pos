


//--------------fungsi validasi angka/huruf
function getkey(e)
{
	if (window.event)
   		return window.event.keyCode;
	else if (e)
   		return e.which;
	else
   return null;
}
function goodchars(e, goods, field)
{
	var key, keychar;
	key = getkey(e);
	if (key == null) return true;
 
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	goods = goods.toLowerCase();
	 
	if (goods.indexOf(keychar) != -1)
		return true;
	if ( key==null || key==0 || key==8 || key==9 || key==27 )
	   return true;
		
	if (key == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
		};
	return false;
}

/*---------------------*/
var xmlHttp = objekXmlHttp();

function objekXmlHttp()
{
	var obj = null;
	if (window.AciveXObject)
	obj = new ActiveXObject("Microsoft.XMLHTTP");
	else
		if(window.XMLHttpRequest)
			obj = new XMLHttpRequest();
		
		if(obj == null)
			document.write("Browser tidak mendukung XMLHttpRequest");
		return obj;		
}

function data(sumber, id, objXMLHttp)
{
	if(objXMLHttp != null)
	{
		var elemen = document.getElementById(id);
		objXMLHttp.open("GET",sumber);
		
		objXMLHttp.onreadystatechange = function()
		{
			if(objXMLHttp.readyState == 4 && objXMLHttp.status == 200)
			{
				elemen.innerHTML = objXMLHttp.responseText;
			}
		}
		
		objXMLHttp.send(null);
	}
}
/*----------------------*/

/*-------------------deklarasi xmlhttp------------------*/
function createRequestObject() {
    var ro;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
        ro = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        ro = new XMLHttpRequest();
    }
    return ro;
}

var xmlhttp = createRequestObject();


//-----------------------fungsi cetak 
function printDiv(elementId) {
    var a = document.getElementById('printing-css').value;
    var b = document.getElementById(elementId).innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}


function cetak(ids)
{
	var DocumentContainer = document.getElementById(ids);
        var WindowObject = window.open('', 'PrintWindow', 'width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes');

        WindowObject.document.writeln('<!DOCTYPE html>');
        WindowObject.document.writeln('<html><head><title></title>');
       //WindowObject.document.writeln('<link rel="stylesheet" type="text/css" href="css/print.css" media="print">');
		
		
		 WindowObject.document.writeln('<link rel="stylesheet" type="text/css" href="assets/css/main.css?t='+Date.now()+'" media="print">');
        WindowObject.document.writeln('</head><body>');
        WindowObject.document.writeln(DocumentContainer.innerHTML);
        WindowObject.document.writeln('</body></html>');

        WindowObject.document.close();
        WindowObject.focus();
        WindowObject.print();
        WindowObject.close();
}