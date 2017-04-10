<?
echo $this->Html->meta(array(
	'viewport',
	'width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no'
));

#cssファイル
echo $this->Html->css('css/normalize.css');
echo $this->Html->css('css/component.css');
echo $this->Html->css('css/main.css');
echo $this->Html->css('css/responsive.css');
echo $this->Html->css('css/dark-theme.css');

echo $this->Html->css('clock/css/clock.css');

#jsファイル
echo $this->Html->script('js/vendor/modernizr-2.6.2.min.js');
echo $this->Html->script('js/vendor/min/classie.min.js');
echo $this->Html->script('js/vendor/jquery.easing.1.3.js');
echo $this->Html->script('js/vendor/jquery.cycle.min.js');
echo $this->Html->script('js/vendor/ThreeWebGL.js');
echo $this->Html->script('js/vendor/ThreeExtras.js');
echo $this->Html->script('js/plugins.js');
echo $this->Html->script('js/main.js');
echo $this->Html->script('js/kai.js');

echo $this->Html->script('clock/js/svg.min.js');
echo $this->Html->script('clock/js/svg.easing.min.js');
echo $this->Html->script('clock/js/svg.clock.min.js');
echo $this->Html->script('clock/js/jquery.timers.min.js');
echo $this->Html->script('clock/js/clock.js');

?>
<section class="mainarea">
	<section class="main-menu-container">
		<ul class="main-menu">
			<li>
				<a href="<?echo $this->Html->url(array('controller'=>'attendances', 'action'=>'index'));?>" data-page="services">従業員一覧へ</a>
			</li>
		</ul>
	</section>
	<div id="clock" class="active">
		<div class="clock-container">
			<div id="time-container-wrap" style="margin-top: 50px;">
				<div id="time-container">
					<div class="numbers-container"></div>
					<span id="ticker" class="clock-label">TIME CARD</span>
					<figure id="canvas"></figure>
				</div>
			</div>
		</div>
		<h3>
			<SCRIPT type="text/javascript">
				myWeek=new Array("日","月","火","水","木","金","土");
				function myFunc(){
					myDate=new Date();
					myMsg = myDate.getFullYear() + "年";
					myMsg += ( myDate.getMonth() + 1 ) + "月";
					myMsg += myDate.getDate() + "日";
					myMsg += "(" + myWeek[myDate.getDay()] +  "曜日)";
					myMsg += myDate.getHours() + "時";
					myMsg += myDate.getMinutes() + "分";
					myMsg += myDate.getSeconds() + "秒";
					document.getElementById("myIDdate").innerHTML = myMsg;
				}
				/*勤務状態に応じて、ボタン選択不可*/
				function judgeState(state){
					$('#btn'+1).attr('disabled', true);$('#btn'+2).attr('disabled', true);$('#btn'+3).attr('disabled', true);$('#btn'+4).attr('disabled', true);
					/*ボタン選択可能*/
					$('#btn'+state).attr('disabled', false);
					if(state==2) $('#btn'+4).attr('disabled', false);
					if(state==4) $('#btn'+2).attr('disabled', false);
					/*画像変更*/
					if (state==1) $("#btn1 > img").attr('src', '/sushikaz_2.0/img/images/action-start_hover.png');
					if (state==2) $("#btn2 > img").attr('src', '/sushikaz_2.0/img/images/action-break-start_hover.png');
					if (state==2) $("#btn4 > img").attr('src', '/sushikaz_2.0/img/images/action-end_hover.png');
					if (state==3) $("#btn3 > img").attr('src', '/sushikaz_2.0/img/images/action-break-end_hover.png');
					if (state==4) $("#btn4 > img").attr('src', '/sushikaz_2.0/img/images/action-end_hover.png');
					if (state==4) $("#btn2 > img").attr('src', '/sushikaz_2.0/img/images/action-break-start_hover.png');

				}
			</SCRIPT>
			<DIV id="myIDdate"></DIV>
			<SCRIPT type="text/javascript">
				setInterval( "myFunc()", 1000 );
			</SCRIPT>
		</h3>
		<h3><?php echo $member['Member']['name']; ?>さん</h3>
		<div class="show_toggle"><a href="#"></a></div>
		<ul class="main-button">
			<?echo $this->Form->create('Attendance');?>
			<input type="hidden" class="btn btn-primary" name="member_id" value="<?echo $member['Member']['id'];?>">
				<li>
					<button id="btn1" type="submit" name="state" value="出勤" onclick='return confirm("よろしいですか？");' style="border:0px;background-color:transparent;cursor:pointer;">
						<?echo $this->Html->image('images/action-start.png', array('width' => '100%','height'=>'100px'));?><span class="text">出勤</span>
					</button>
				</li>
				<li>
					<button id="btn2" type="submit" name="state" value="休憩開始" onclick='return confirm("よろしいですか？");' style="border:0px;background-color:transparent;cursor:pointer;">
						<?echo $this->Html->image('images/action-break-start.png', array('width' => '100%','height'=>'100px'));?><span class="text">休憩</span>
					</button>
				</li>
				<li>
					<button id="btn3" type="submit" name="state" value="休憩終了" onclick='return confirm("よろしいですか？");' style="border:0px;background-color:transparent;cursor:pointer;">
						<?echo $this->Html->image('images/action-break-end.png', array('width' => '100%','height'=>'100px'));?><span class="text">復帰</span>
					</button>
				</li>
				<li>
					<button id="btn4" type="submit" name="state" value="退勤" onclick='return confirm("よろしいですか？");' style="border:0px;background-color:transparent;cursor:pointer;">
						<?echo $this->Html->image('images/action-end-1.png', array('width' => '100%','height'=>'100px'));?><span class="text">退勤</span>
					</button>
				</li>
				<script type="text/javascript">judgeState(<?echo $flag;?>)</script>
			<?echo $this->Form->end();?>
		</ul>
	</div>
</section>
