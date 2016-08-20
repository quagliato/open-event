        <footer></footer>

<!-------------------------------------------------------------------------- -->
<!-- LIGHTBOX -->
        <div id="lightbox_overlay">
            <div id="lightbox">
                <a href="#" id="close"><i class="fa fa-times"></i></a>
                <div id="content">
                </div>
            </div>
        </div>
<!-------------------------------------------------------------------------- -->

<!-------------------------------------------------------------------------- -->
<!-- PROCESSING -->
        <div id="processing-layer">
            <div id="content">
                <i id="icon" class="fa fa-spinner fa-pulse"></i><br>
                <span id="text">Processando...</span>
            </div>
        </div>
<!-------------------------------------------------------------------------- -->

<!-------------------------------------------------------------------------- -->
<!-- NOTIFICATION -->
        <div id="notification_spot" class="notification">
            <div id="notification_content">
            </div>
            <a href="#" id="close_btn"><i class="fa fa-times"></i></a>
        </div>
<!-------------------------------------------------------------------------- -->
    </body>
    <script>
      bindMasks();
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', '<?=GOOGLE_ANALYTICS?>', 'auto');
      ga('send', 'pageview');
    </script>
</html>
