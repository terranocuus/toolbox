$(document).ready( function() {
	//reset
	//sessionStorage.open = '';
	
	//DEPREC //$('li.dir').live( 'click', function() {
	$(document).on('click', 'li.dir span', function(){
		var context = $(this);
		var parent = context.parent();
		var data = parent.data(); //console.log(data);
		var index = $('li.dir[data-dir="'+data.dir+'"]').index(parent);
		
		var temp = (sessionStorage.open) ? sessionStorage.open.split(',') : [];
		var check = [];
		for (var x in temp) { if (temp[x] !== '') { check.push(temp[x]); } }
		temp = check;
		
		if (context.hasClass('icon-folder-close')) {
			context.removeClass('icon-folder-close').addClass('icon-folder-open');
		} else {
			context.removeClass('icon-folder-open').addClass('icon-folder-close');
			}
		
		if (parent.hasClass('closed')) {
			parent.removeClass('closed').addClass('open').children('ul.list').slideDown();
			
			temp.push(data.dir).toString();
				
		} else if (parent.hasClass('open')) {
			parent.removeClass('open').addClass('closed').children('ul.list').slideUp(100);
			
			temp = temp.toString().replace(data.dir, '');
				console.log(temp);
			
		} else { //(!parent.hasClass('open') && !parent.hasClass('closed')) {
			$.get('?dir=' + data.dir, function(resp) {
				parent.append(resp).addClass('open');
				$('ul[data-src="'+data.dir+'"]').slideDown();
				});
				
			temp.push(data.dir).toString();
			}
			
		sessionStorage.open = temp;
			
		return true;
		});
		
	if (sessionStorage.open) {
		var opened = sessionStorage.open.split(',');
		$.each(opened, function(i, e) {
			$.get('?dir=' + e, function(resp) {
				$('li.dir[data-dir="'+e+'"]').append(resp).addClass('open');
				$('li.dir[data-dir="'+e+'"] > span').removeClass('icon-folder-close').addClass('icon-folder-open');
				$('ul[data-src="'+e+'"]').slideDown();
				});
			});
		}
		
	$(document).on('click', 'li.dir a.refresh', function(e) {
		e.preventDefault();
		
		var context = $(this);
		var parent = context.parent();
		var data = parent.data(); //console.log(data);
		var index = $('li.dir[data-dir="'+data.dir+'"]').index(parent);
		
		parent.removeClass('open').addClass('closed').children('ul.list').slideUp(100, function() {
			$(this).remove();
			
			$.get('?dir=' + data.dir, function(resp) {
				parent.append(resp).addClass('open');
				$('ul[data-src="'+data.dir+'"]').slideDown();
				});
			});
			
		return true;
		});
	});
	
	
	//end