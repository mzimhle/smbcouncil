<script type="text/javascript" src="/library/javascript/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="/library/javascript/jquery.validate.js"></script>
<script src="/library/javascript/countdown.min.js"></script>
{literal}
<script>
    $(window).load(function() {
        $('#edate').countdown('2014/12/01', function(event) {
	       $(this).html(event.strftime(''
            + '<div>%w<span>week(s)</span></div>'
            + '<div>%d<span>day(s)</span></div>'
            + '<div>%H<span>hour(s)</span></div> '
            + '<div>%M<span>minute(s)</span></div> '
            /*+ '<div>%S<span>seconds</span></div>'*/));
        });
    });
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-52926050-1', 'auto');
  ga('send', 'pageview');
</script>
{/literal}