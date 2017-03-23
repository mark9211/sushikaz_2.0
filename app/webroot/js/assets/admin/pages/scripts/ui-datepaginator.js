var UIDatepaginator = function () {

    return {

        //main function to initiate the module
        init: function () {
            // lang:jaを登録。これ以降はlangを指定しなくても自動的にjaが使用される。
            moment.lang('ja', {
                weekdays: ["日曜日","月曜日","火曜日","水曜日","木曜日","金曜日","土曜日"],
                weekdaysShort: ["日","月","火","水","木","金","土"],
            });

            /*url取得*/
            var date  = $(this).attr("data-moment");
            var url   = location.href;
            var parameters    = url.split("?");
            if (parameters[1]) {
                var dateJob = parameters[1].split("=");
                var options = {
                    selectedDate: dateJob[1]
                }
            }

            //sample #1
            $('#datepaginator_sample_1').datepaginator(options);

            //sample #2
            $('#datepaginator_sample_2').datepaginator({
                size: "large"
            });

            //sample #3
            $('#datepaginator_sample_3').datepaginator({
                size: "small"
            });

            //sample #3
            $('#datepaginator_sample_4').datepaginator({
                onSelectedDateChanged: function(event, date) {
                  alert("Selected date: " + moment(date).format("Do, MMM YYYY"));
                }
            });
            
        } // end init

    };

}();

