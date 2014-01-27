var http_request = getHTTPObject();

function cleantext(text) 
{
	var spl = text.split(/[\s~!@#&$%^*()\[\]{}:\"<>?`=;\',\.\/\\|\-]+/i);
	var words = [];
	for (var i=0; i < spl.length; i++) 
	{
		if (!spl[i].match(/^[a-z\x80-\xFF_0-9]{0,2}$/)) 
		{
			words[words.length] = spl[i].toLowerCase();
		}
	}
	return words.join(" ");
}

function getHTTPObject()
{
	var xr = null;
	if(window.XMLHttpRequest)
	{
		try
		{
			xr = new XMLHttpRequest();
		}
		catch(e) {}
	}
	else
	{
		if(window.ActiveXObject)
		{
			try
			{
				xr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e) {}
			if(!xr)
			{
				try
				{
					xr = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e) {}
			}
		}
	}
	if(!xr)
	{
		alert('Cound not create XmlHttpRequest Object. Consider upgrading your browser.');
	}
	return xr;
}

//**
//** This code is ported from dklab.ru
//**

// Cross-browser addEventListener()/attachEvent() replacement.
function addEvent(elt, name, handler, atEnd) 
{
	name = name.replace(/^(on)?/, 'on'); 
	var prev = elt[name];
	var tmp = '__tmp';
	elt[name] = function(e) 
	{
		if (!e) e = window.event;
		var result;
		if (!atEnd) 
		{
			elt[tmp] = handler; 
			result = elt[tmp](e); 
			elt[tmp] = null; // delete() does not work in IE 5.0 (???!!!)
			if (result === false) return result;
		}
		if (prev) 
		{
			elt[tmp] = prev; result = elt[tmp](e); elt[tmp] = null;
		}
		if (atEnd && result !== false) 
		{
			elt[tmp] = handler; 
			result = elt[tmp](e); 
			elt[tmp] = null;
		}
		return result;
	}
 	return handler;
}


function LiveSearch(field, div, row) 
{ 
	this.construct(field, div, row);
}

LiveSearch.prototype = 
{
	url:     '',
	field:   null,
	div:     null,
	row:     null,
	prevQ:   '',
	prevT:   null,
	timeout: null,
  
	construct: function(field, div, row) 
	{
		this.field = field;
		this.div = div;
		this.row = row;
		if (this.row == null)
		{
			this.row = this.div;
		}
		this.prevT = new Date();
		this.url = u_similar_search;
		th = this;

		addEvent(field, 'onblur', function() 
		{
			th.onchangeControl(field.value, 0);
			th.focused = false;
			return true;
		});
		addEvent(field, 'onkeyup', function() 
		{
			th.onchangeControl(field.value, 3500);
			th.focused = true;
			return true;
		})
	},

	topics_search: function(text)
	{
		th = this;
		if (http_request != null)
		{
			text = cleantext(text);
			if ((this.url != '') && (text != ''))
			{
				param = 'topic_title=' + text;	
				http_request.open("POST", this.url, true);
				http_request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				http_request.onreadystatechange = function() 
				{
					if (http_request.readyState == 4)
					{
						if (http_request.status == 200)
						{
							result = http_request.responseText;
							th.row.style.display = 'none';
							if (cleantext(result) != '')
							{
								th.row.style.display = '';
								th.div.innerHTML = result;
							}
						}
						else
						{
							alert('There was a problem with the request. Status: ' + http_request.status);
						}
					}
				}
				http_request.send(param);
			}
		}
	},

	onchangeControl: function(text, dt) 
	{
		var t = new Date();
		var wait = 0;
		if (dt == null) dt = 500;
    
		if (t.getTime() - this.prevT.getTime() < dt) 
		{
			this.prevT = t;
			wait = dt;
		}
    
		th = this;
		if (this.timeout) 
		{ 
			clearTimeout(this.timeout); this.timeout=null; 
		}
		this.timeout = setTimeout(function() { th.prevT = t; th.timeout=null; th.onchange(text) }, wait);
	},
  
	onchange: function(text, force) 
	{
		if (text != this.prevQ && text != "") 
		{
			this.prevQ = text;
			this.topics_search(text);
		}
	}
};