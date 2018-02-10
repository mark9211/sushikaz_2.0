#店舗
create table locations(
	id int not null primary key auto_increment, 
	name varchar(255), 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);


#従業員
create table members(
	id int not null primary key auto_increment, 
	location_id int,
	name varchar(255),  
	post_id int, 
	position_id int,  
	type_id int, 
	hourly_wage int,
	compensation_daily int,
	compensation_monthly int,
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#従業員子テーブル
	create table member_posts(
		id int not null primary key auto_increment, 
		location_id int,
		name varchar(255),  
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

	create table member_positions(
		id int not null primary key auto_increment, 
		location_id int,
		name varchar(255),  
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

	create table member_types(
		id int not null primary key auto_increment, 
		location_id int,
		name varchar(255),  
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#営業日判定関数。深夜判定（24:00以降で営業開始以前の時刻は、-1日で営業日。それ以外はそのまま）:引数＝＞現在時刻、：返り値＝＞営業日
#出退勤ボタン制御関数
#出退勤
create table attendances(
	id int not null primary key auto_increment, 
	location_id int,
	member_id int,  
	working_day date, 
	type_id int, 
	time datetime,
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#出退勤子テーブル
	create table attendance_types(
		id int not null primary key auto_increment,
		name varchar(255),
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#Sort & 差分計算 & 深夜判定関数
#２つの出退勤計算結果
create table attendance_results(
	id int not null primary key auto_increment,
	location_id int,
	member_id int,  
	working_day date, 
	attendance_start datetime,
	attendance_end datetime,
	hours float, 
	late_hours float, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);


#総売上計算関数
#売上表
create table sales(
	id int not null primary key auto_increment,
	location_id int,
	type_id int,
	working_day date,
	fee int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#売上表子テーブル
	create table sales_types(
		id int not null primary key auto_increment,
		location_id int,
		attribute_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#クレジットカード売上
create table credit_sales(
	id int not null primary key auto_increment,
	location_id int,
	type_id int,
	working_day date,
	fee int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#クレジットカード売上子テーブル
	create table credit_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null	
	);

#時間帯別客数
create table customer_counts(
	id int not null primary key auto_increment,
	location_id int,
	timezone_id int,
	working_day date,
	count int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#時間帯別客数子テーブル
	create table customer_timezones(
		id int not null primary key auto_increment,
		location_id int,
		attribute_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#クーポン割引
create table coupon_discounts(
	id int not null primary key auto_increment,
	location_id int,
	type_id int, 
	working_day date,
	customer_name varchar(255), 
	fee int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#クーポン割引子テーブル
	create table coupon_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#その他割引
create table other_discounts(
	id int not null primary key auto_increment,
	location_id int,
	type_id int, 
	working_day date,
	customer_name varchar(255), 
	fee int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);
	
	#その他割引子テーブル
	create table other_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);


#支出表
create table expenses(
	id int not null primary key auto_increment,
	location_id int,
	type_id int, 
	working_day date,
	store_name varchar(255), 
	product_name varchar(255), 
	fee int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#その他割引子テーブル
	create table expense_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#宴会情報
create table party_informations(
	id int not null primary key auto_increment,
	location_id int,
	type_id int, 
	working_day date,
	starting_time varchar(255),
	customer_count int, 
	customer_name varchar(255), 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#宴会情報子テーブル
	create table party_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#伝票番号
create table slip_numbers(
	id int not null primary key auto_increment,
	location_id int,
	type_id int, 
	working_day date,
	start_number int, 
	end_number int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#伝票番号子テーブル
	create table slip_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255), 
		status enum('active', 'deleted') default 'active', 
		created datetime default null, 
		modified datetime default null
	);

#その他
create table other_informations(
	id int not null primary key auto_increment,
	location_id int,
	working_day date,
	member_id int, 
	weather varchar(255), 
	absence_one_id int, 
	absence_two_id int,
	absence_three_id int,
	notes text,
	tax int,
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

#売上合計,　カード合計, 客数合計, 支出合計, 売掛合計, クーポン合計, ポイント合計, 端数割引合計
#総売上 - カード - 支出 - 売掛 - クーポン - ポイント - 端数 = 現金計 
#総売上表
create table total_sales(
	id int not null primary key auto_increment,
	location_id int,
	working_day date,
	sales int, 
	credit_sales int,
	customer_counts int,
	coupon_discounts int, 
	other_discounts int, 
	expenses int,
	tax int,
	cash int, 
	status enum('active', 'deleted') default 'active', 
	created datetime default null, 
	modified datetime default null
);

	#人件費テーブル
	create table payrolls(
		id int not null primary key auto_increment,
		location_id int,
		working_day date,
		total_sales_id int,
		hall int,
		kitchen int,
		ratio float,
		status enum('active', 'deleted') default 'active',
		created datetime default null,
		modified datetime default null
	);

#20150702
#在庫
create table inventories(
	id int not null primary key auto_increment,
	location_id int,
	working_day date,
	type_id int,
	income float,
	outcome float,
	rest float,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

	#在庫子テーブル
	create table inventory_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255),
		status enum('active', 'deleted') default 'active',
		created datetime default null,
		modified datetime default null
	);

#売上目標値設定
create table targets(
	id int not null primary key auto_increment,
	location_id int,
	target_one int,
	target_two int,
	target_three int,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#買い掛け
create table payable_accounts(
	id int not null primary key auto_increment,
	location_id int,
	working_day date,
	type_id int,
	fee int,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

	#買い掛け子テーブル
	create table account_types(
		id int not null primary key auto_increment,
		location_id int,
		name varchar(255),
		status enum('active', 'deleted') default 'active',
		created datetime default null,
		modified datetime default null
	);


#20150723
#休業日テーブル
create table holidays(
	id int not null primary key auto_increment,
	location_id int,
	day int,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#20151016
#Sales属性
create table sales_attributes(
	id int not null primary key auto_increment,
	name varchar(255),
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#20151020
#ランチテーブル
create table sales_lunches(
	id int not null primary key auto_increment,
	location_id int,
	working_day date,
	attribute_id int,
	fee int,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#20151027
#パスコードテーブル
create table passcodes(
	id int not null primary key auto_increment,
	location_id int,
	username varchar(255),
	password1 varchar(255),
	password2 varchar(255),
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#2018/02/07
CREATE table m_breakdowns(
	id int not null primary key auto_increment,
	parent_id int,
	name varchar(255),
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

CREATE TABLE t_breakdowns(
	id int not null primary key auto_increment,
	m_id int NOT NULL,
	location_id int NOT NULL,
	working_day date NOT NULL,
	sales int,
	visitors int,
	average int,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);

#2018/02/08
create table receipt_summaries(
	id int not null primary key auto_increment,
	location_id int NOT NULL,
	working_day date NOT NULL,
	receipt_id VARCHAR(255),
	total int,
	tax int,
	visitors int,
	brand_name VARCHAR(255),
	breakdown_name VARCHAR(255),
	food int,
	drink int,
	credit int,
	voucher int,
	discount int,
	other int,
	time datetime,
	status enum('active', 'deleted') default 'active',
	created datetime default null,
	modified datetime default null
);
