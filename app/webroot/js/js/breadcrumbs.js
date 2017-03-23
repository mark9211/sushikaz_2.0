window.onload = function(){
	var url = location.href;
	if (url == 'http://marksato.sakura.ne.jp/sushikaz/daily_report.php') {
		document.getElementById("b1").style.background = '#fff';
	}
	else if(url == 'http://marksato.sakura.ne.jp/sushikaz/sub.php'){
		document.getElementById("b2").style.background = '#fff';
	}
	else if(url == 'http://marksato.sakura.ne.jp/sushikaz/info.php'){
		document.getElementById("b3").style.background = '#fff';
	}
	else if(url == 'http://marksato.sakura.ne.jp/sushikaz/confirm.php'){
		document.getElementById("b4").style.background = '#fff';
	}
}
