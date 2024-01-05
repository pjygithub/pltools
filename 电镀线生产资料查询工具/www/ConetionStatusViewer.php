<!DOCTYPE html>
<html lang="zh_CN">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="./js/jquery.js"></script>
	<script src="./js/jquery.cookie.min.js"></script>
	<title>机台连通状态查询</title>
</head>
<style>
	* {
		padding: 0px;
		margin: 0;
		font-size: 0.9rem;
	}

	.main {
		width: 99.5%;
		margin: 0 auto;
	}

	.top {
		font-size: 24px;
		text-align: center;
		margin-top: 5px;
		margin-bottom: 5px;
		font-weight: 800;
	}

	.F {
		width: 32%;
		/* background-color: bisque; */
		float: left;
		margin-left: 0.5%;
		margin-right: 0.5%;
	}

	table {
		border-collapse: collapse;
		/* Remove cell spacing */
		width: 100%;
	}

	tbody>tr>td {
		border: 1px solid #6d6d6d;
		padding: 1px;
		text-align: center;
		/* font-size: 0.9rem; */
		height: 1.2rem;
		padding-bottom: 0.2rem;
		padding-top: 0.2rem;
		/* width:12%; */
	}

	table>tbody>tr>th {
		width: 100%;
		font-size: 20px;
		font-weight: 600;
		text-align: center;
	}

	table>tbody>tr>td:nth-last-child(3) {
		text-align: center;
		/* padding-left: 0.8rem; */
	}

	table>tbody>tr>td:nth-last-child(2) {
		display: none;
	}

	._block {
		display: inline-block;
		width: 60px;
		height: 20px;
		margin-top: 5px;
		margin-left: 10px;
	}

	._block1 {
		display: inline-block;
		width: 30px;
		height: 15px;
		margin-top: 5px;
		margin-left: 10px;
	}

	.faster>td:nth-last-child(1) {
		background-color: #80ea80;
		font-weight: 600;
		color: green;
	}

	.faster>td:nth-last-child(2) {
		background-color: #80ea80;
		font-weight: 600;
		color: green;
	}

	.slow>td:nth-last-child(1) {
		background-color: #9090f7;
		font-weight: 600;
		color: white;
	}

	.slow>td:nth-last-child(2) {
		background-color: #9090f7;
		font-weight: 600;
		color: white;
	}

	.stop>td:nth-last-child(1) {
		background-color: #f78282;
		font-weight: 600;
		color: red;
	}

	.stop>td:nth-last-child(2) {
		background-color: #f78282;
		font-weight: 600;
		color: red;
	}

	.offline>td:nth-last-child(1) {
		background-color: #ffffab;
		font-weight: 600;
		color: black;
	}

	.offline>td:nth-last-child(2) {
		background-color: #ffffab;
		font-weight: 600;
		color: black;
	}

	.pl209 {
		background-color: #ececec;
	}

	.sr {
		background-color: #c0c0c0;
	}

	.me2 {
		background-color: #c5c9f3;
	}

	.ppf {
		background-color: #d4f3c5;
	}

	.bot {
		background-color: #f3c8f0;
	}

	.title {
		background-color: #999999;
		color: white;
	}

	.timeless {
		width: 70%;
		position: relative;
		left: 1%;
		top: 0%;
		font-size: 20px;
		font-weight: 700;
	}

	.timeless>span {
		font-size: 20px;
		font-weight: 700;
	}

	.fenge {
		border-bottom: 3px solid #6d6d6d;
	}

	a {
		text-decoration: none;
		color: black;
	}
</style>
<script>
	//设置cookie
	function setCookie(cookieName, cookieValue) {
		$.cookie(cookieName, cookieValue, {
			expires: 7,
			path: '/'
		}); //第一种
	}
	//读取cookie
	function getCookie(cookieName) {
		var cookieWord = $.cookie(cookieName);
		return cookieWord;
	}
	//检测cookie是否存在

	function checkCookie(cookieName) {
		var user = getCookie(cookieName);
		if (user != "") {
			return 1;
		} else {
			return 0;
		}
	}

	function getURL(url, id) {
		$.ajax({
			type: 'get',
			url: "http://" + url,
			dataType: 'jsonp',
			timeout: 1000,
			async: true,
			processDate: 'false',
			complete: function(res) {
				console.log("url State Code=" + re.status);
				if (res.status == 200) {
					console.log('有效链接')
					setCookie(url, 200);
					$
				} else {
					console.log('无效链接')
					setCookie(url, 404);
				}
			},
		});
		return getCookie(url);
	}
</script>

<body>
	<div class="main">
		<!-- <div class="top">机台状态查询</div> -->
		<div class="F">
			<table>
				<tbody>
					<tr>
						<th colspan="4">12/3F</th>
					</tr>
					<tr class="title">
						<td>机台</td>
						<td>host / IP</td>
						<td>ping</td>
						<td>http</td>
					</tr>
					<tr id="27A" class="me2">
						<td rowspan="2">27</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="27B" class="me2">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="28A" class="pl209">
						<td rowspan="2">28</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="28B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="29A" class="pl209">
						<td rowspan="2">29</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="29B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="30A" class="me2">
						<td rowspan="2">30</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="30B" class="me2">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="31A" class="sr">
						<td rowspan="2">31</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="31B" class="sr">
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr id="32A" class="me2">
						<td rowspan="2">32</td>
						<td></td>
						<td></td>
						<td></td>
						</td>
					</tr>
					<tr id="32B" class="me2">
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr id="35A" class="me2">
						<td rowspan="2">35</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="35B" class="me2">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th colspan="4">6/3F</th>
					</tr>
					<tr id="34A" class="sr">
						<td rowspan="2">34</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="34B" class="sr">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: left; border: 1px solid #fff">
							<br />
							<span class="_block1" style="background-color: #ececec">&nbsp;</span>
							快机<span class="_block1" style="background-color: #c0c0c0">&nbsp;</span>
							慢机<span class="_block1" style="background-color: #c5c9f3">&nbsp;</span>
							ME2<span class="_block1" style="background-color: #d4f3c5">&nbsp;</span>
							钯机<span class="_block1" style="background-color: #f3c8f0">&nbsp;</span>
							棕色氧化<br />
							<!-- <span class="_block" style="background-color: #80ea80">&nbsp;</span>
							可ping可连接<br />
							<span class="_block" style="background-color: #9090f7">&nbsp;</span>
							可ping不可连接<br />
							<span class="_block" style="background-color: #f78282">&nbsp;</span>
							不可ping不可连接<br /> -->
							<!-- <span class="_block" style="background-color: #80ea80">&nbsp;</span>
							连通
							<span class="_block" style="background-color: #ffffab">&nbsp;</span>
							断网/无服务 -->
							<br />
							<div class="timeless">
								<br />页面刷新倒计时：<span>0 s</span>
							</div>
							<!-- <p style="color:red;font-size:1.5rem;">（等待100s下次才准确）</p> -->
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="F">
			<table>
				<tbody>
					<tr>
						<th colspan="4">13/3F</th>
					</tr>
					<tr class="title">
						<td>机台</td>
						<td>host / IP</td>
						<td>ping</td>
						<td>http</td>
					</tr>
					<tr id="01A" class="pl209">
						<td rowspan="2">01</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="01B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="02A" class="pl209">
						<td rowspan="2">02</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="02B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="03A" class="pl209">
						<td rowspan="2">03</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="03B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="04A" class="pl209">
						<td rowspan="2">04</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="04B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="05A" class="pl209">
						<td rowspan="2">05</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="05B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="06A" class="pl209">
						<td rowspan="2">06</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="06B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="07A" class="pl209">
						<td rowspan="2">07</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="07B" class="pl209 fenge">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="08A" class="pl209">
						<td rowspan="2">08</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="08B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="09A" class="pl209">
						<td rowspan="2">09</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="09B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="10A" class="sr">
						<td rowspan="2">10</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="10B" class="sr">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="11A" class="pl209">
						<td rowspan="2">11</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="11B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="12A" class="sr">
						<td rowspan="2">12</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="12B" class="sr">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="13A" class="pl209">
						<td rowspan="2">13</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="13B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr id="14A" class="pl209">
						<td rowspan="2">14</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="14B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="4" style="border: 1px solid #fff"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="F">
			<table>
				<tbody>
					<tr>
						<th colspan="4">14/3F</th>
					</tr>
					<tr class="title">
						<td>机台</td>
						<td>host / IP</td>
						<td>ping</td>
						<td>http</td>
					</tr>

					<tr id="15A" class="ppf">
						<td rowspan="2">15</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="15B" class="ppf">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="18A" class="ppf">
						<td rowspan="2">18</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="18B" class="ppf fenge">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="19A" class="pl209">
						<td rowspan="2">19</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="19B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="20A" class="pl209">
						<td rowspan="2">20</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="20B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="21A" class="pl209">
						<td rowspan="2">21</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="21B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="22A" class="pl209">
						<td rowspan="2">22</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="22B" class="pl209 fenge">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="23A" class="bot">
						<td rowspan="2">23</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="23B" class="bot">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="24A" class="bot">
						<td rowspan="2">24</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="24B" class="bot">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="25A" class="bot">
						<td rowspan="2">25</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="25B" class="bot fenge">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="26A" class="ppf">
						<td rowspan="2">26</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="26B" class="ppf">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="36A" class="ppf">
						<td rowspan="2">36</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="36B" class="ppf">
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr id="37A" class="ppf">
						<td rowspan="2">37</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="37B" class="ppf">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<th colspan="4">6/1F</th>
					</tr>
					<tr id="38A" class="pl209">
						<td rowspan="2">38</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="38B" class="pl209">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="RSAA" class="">
						<td rowspan="2">RSA</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="RSAB" class="">
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr id="" class="">
						<td colspan="4" style="border: 1px solid #fff"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<br />
	</div>
	<?php
	// 引入机器配置文件
	$machines_json = file_get_contents(dirname(__DIR__) . '/www/config/machines.config.json');
	$machines_arr = json_decode($machines_json, true);
	?>
</body>
<script>
	var data = <?php echo $machines_json; ?>;

	function checkURL(obj, sTime) {
		const eTime = Date.now();
		// console.log(eTime);
		const timec = (eTime - sTime) / 1000;
		if (timec > 2) {
			$('#' + obj)
				.children()
				.eq(-1)[0].innerHTML = "<span style='color:#f31616;'>404 Not Found</span>";
		} else {
			$('#' + obj)
				.children()
				.eq(-1)[0].innerHTML = "<span style='color:#36cd36;'>200 OK（TTL: " + (timec * 100).toFixed(2) + "ms）</span>";;
		}
	}
	for (let i = 0; i < data.length; i++) {
		const ele = data[i];
		// console.log(ele);
		if (ele.id < 10) {
			ele.id = '0' + ele.id;
		}
		const sTime = Date.now();
		// console.log(sTime);
		if ((ele.host != '')) {
			$('#' + ele.id + 'A')
				.children()
				.eq(-3)
				.append('<a href="http://' + ele.host + '">' + ele.host + '</a>');
			const html1 = '<img src="http://' + ele.host + "/" + Math.random() + '"  onerror="checkURL(\'' + ele.id + 'A\',' + sTime + ')">';
			// console.log(htmll);
			$('#' + ele.id + 'A')
				.children()
				.eq(-2)
				.append(html1);
		}
		if ((ele.ip != '')) {
			$('#' + ele.id + 'B')
				.children()
				.eq(-3)
				.append('<a href="http://' + ele.ip + '">' + ele.ip + '</a>');
			const html2 = '<img src="http://' + ele.ip + "/" + Math.random() + '"  onerror="checkURL(\'' + ele.id + 'B\',' + sTime + ')">';
			// console.log(htmll);
			$('#' + ele.id + 'B')
				.children()
				.eq(-2)
				.append(html2);
		}
	}
	var timeless = 60;
	ttt = timeless;
	setInterval(function() {
		$('.timeless')
			.children()
			.html(ttt + ' s');
		ttt = ttt - 1;
		if (ttt == 0 || ttt < 0) {
			window.location.reload();
			$('.timeless').children().html('1 s');
		}
	}, 1000);
</script>

</html>