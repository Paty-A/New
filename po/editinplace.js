Event.observe(window, 'load', init, false);

function init(){
//	makeEditable('item_comment');
}

function makeEditable(id, url, params){
	Event.observe(id, 'click', function(){edit($(id), url, params)}, false);
	Event.observe(id, 'mouseover', function(){showAsEditable($(id))}, false);
	Event.observe(id, 'mouseout', function(){showAsEditable($(id), true)}, false);
}

function edit(obj, url, params){
	Element.hide(obj);
	
	var textarea = '<div id="'+obj.id+'_editor"><input id="'+obj.id+'_edit" name="'+obj.id+'" value="'+obj.firstChild.nodeValue.strip()+'">';
	var button = '';
	new Insertion.After(obj, textarea+button);	
		
	$(obj.id+'_edit').focus();
	$(obj.id+'_edit').onblur = function() { saveChanges(obj, url, params) }
	$(obj.id+'_edit').onkeypress = function(e) { 
		var e = e || window.event; 
		if(e.keyCode == Event.KEY_RETURN) saveChanges(obj, url, params);
	}
}

function showAsEditable(obj, clear){
	if (!clear){
		Element.addClassName(obj, 'editable');
	}else{
		Element.removeClassName(obj, 'editable');
	}
}

function saveChanges(obj, url, params){
	
	var new_content	=  $F(obj.id+'_edit');

	obj.innerHTML	= "Saving...";
	cleanUp(obj, true);

	var success	= function(t){editComplete(t, obj);}
	var failure	= function(t){editFailed(t, obj);}

	params.content = new_content;
	params.id = obj.id;
	var myAjax = new Ajax.Request(url, {method:'post', parameters:params, onSuccess:success, onFailure:failure});

}

function cleanUp(obj, keepEditable){
	Element.remove(obj.id+'_editor');
	Element.show(obj);
	if (!keepEditable) showAsEditable(obj, true);
}

function editComplete(t, obj){
	var content = t.responseText.strip();
	if(content.length == 0) content = "&nbsp;";
	obj.innerHTML	= content;
	showAsEditable(obj, true);
}

function editFailed(t, obj){
	obj.innerHTML	= 'Sorry, the update failed.';
	cleanUp(obj);
}


