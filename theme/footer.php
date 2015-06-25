        <footer></footer>

<!-------------------------------------------------------------------------- -->
<!-- LIGHTBOX -->
        <div id="lightbox_overlay">
            <div id="lightbox">
                <a href="#" id="close">X</a>
                <div id="content">
                </div>
            </div>
        </div>
<!-------------------------------------------------------------------------- -->

<!-------------------------------------------------------------------------- -->
<!-- NOTIFICATION -->
        <div id="notification_spot" class="notification">
            <div id="notification_content">
            </div>
            <a href="#" id="close_btn">X</a>
        </div>
<!-------------------------------------------------------------------------- -->
        <div style="bottom:0px; color:#000; display:inline-block; font-size:12px; padding:0 20px 10px 0; position:fixed; right:0px; width: auto;">
        Dúvidas ou problemas técnicos? <a href="mailto:<?=DEFAULT_HUMAN_EMAIL?>"><?=DEFAULT_HUMAN_EMAIL?></a>
        </div>
    </body>
    <script>
      bindMasks();
      <?php if (defined(GOOGLE_ANALYTICS)) : ?>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<?=GOOGLE_ANALYTICS?>', 'auto');
      ga('send', 'pageview');
      <?php endif; ?>
    </script>
</html>
