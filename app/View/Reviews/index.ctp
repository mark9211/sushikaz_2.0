<style>
    body {
        background: url(<?=$this->Html->webroot.'img/screen1.png';?>) center center / cover no-repeat fixed;
    }
    body:before{
        content: '';
        background: inherit;/*.bgImageで設定した背景画像を継承する*/
        -webkit-filter: blur(1px);
        -moz-filter: blur(1px);
        -o-filter: blur(1px);
        -ms-filter: blur(1px);
        filter: blur(1px);
        position: absolute;
        /*ブラー効果で画像の端がボヤけた分だけ位置を調整*/
        top: -1px;
        left: -1px;
        right: -1px;
        bottom: -1px;
        z-index: -1;/*重なり順序を一番下にしておく*/
    }
    .box{
        color: #fff;
        text-align: center;
        min-height: 550px;
        border: 5px solid #fff;
        margin: 10%;
        padding: 5%;
        font-family: 'Alegreya Sans SC', sans-serif;
    }
    .box p{
        font-size: 32px;
    }
</style>
<div class="container">
    <div class="row box">
        <p>ENJOY!</p>
        <form id="reservation">
            <label for="minbeds">Minimum number of beds</label>
            <select name="minbeds" id="minbeds">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </form>
    </div>
</div>
<script>
    $( function() {
        var select = $( "#minbeds" );
        var slider = $( "<div id='slider'></div>" ).insertAfter( select ).slider({
            min: 1,
            max: 5,
            range: "min",
            value: select[ 0 ].selectedIndex + 1,
            slide: function( event, ui ) {
                select[ 0 ].selectedIndex = ui.value - 1;
            }
        });
        $( "#minbeds" ).on( "change", function() {
            slider.slider( "value", this.selectedIndex + 1 );
        });
    } );
</script>