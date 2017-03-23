function time(){
	var nowTime = new Date(); // 現在日時を得る
	var nowHour = nowTime.getHours(); // 時を抜き出す
	var nowMin = nowTime.getMinutes(); // 分を抜き出す
	var nowSec = nowTime.getSeconds(); // 秒を抜き出す
	var msg = "現在時刻:"+f(nowHour) + ":" + f(nowMin) + ":" + f(nowSec);

	document.getElementById("clocktime").innerHTML = msg;
	 //console.log(msg);
}

function f(s){
	s=String(s);
	if(s.length==1) return "0"+s;
	else return s;
}

function check(){
	if(window.confirm('送信してよろしいですか？')){ // 確認ダイアログを表示
		return true; // 「OK」時は送信を実行
	}
	else{ // 「キャンセル」時の処理
		window.alert('キャンセルされました'); // 警告ダイアログを表示
		return false; // 送信を中止
	}
}


function judgeState(state){
	$('#btn'+1).attr('disabled', true);
	$('#btn'+2).attr('disabled', true);
	$('#btn'+3).attr('disabled', true);
	$('#btn'+4).attr('disabled', true);
	$('#btn'+state).attr('disabled', false);


}