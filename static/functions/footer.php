<footer id="footer" class="footer">
    <div class="container-fluid">
        <hr>
        <div class="text-center">Grader.ga - Made with <b style="color: salmon; ">Meow🐾</b> by <a href="https://www.facebook.com/p0ndja/" class="font-weight-bold">PondJaᵀᴴ</a> & <a href="https://www.facebook.com/Neptune.dreemurr" class="font-weight-bold">Nepumi</a></div>
        <br>
    </div>
</footer>
<script>hljs.initHighlightingOnLoad();</script>
<script>
    $('input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], input[type=date], input[type=time], textarea').each(function (element, i) {
        if ((element.value !== undefined && element.value.length > 0) || $(this).attr('placeholder') !== undefined) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
        $(this).trigger("change");
    });
    $('input[type=email]').val('test').siblings('label').addClass('active');
    
    // Tooltips Initialization
    $(document).ready(function () {
        $('.mdb-select').materialSelect();
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn-floating').unbind('click');
        $('.fixed-action-btn').unbind('click');
        attachFooter();
        
    });

    $(window).on('resize', function() {
        attachFooter();
    });

    function attachFooter() {
        console.log($(document.body).height() + " | " + $(window).height());
        if ($(document.body).height() < $(window).height()) {
            $('#footer').attr('style', 'position: fixed!important; bottom: 0px;');
        } else {
            $('#footer').removeAttr('style');
        }
    }

    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
    });

    $('.carouselsmoothanimated').on('slide.bs.carousel', function(e) {
        $(this).find('.carousel-inner').animate({
            height: $(e.relatedTarget).height()
        }, 500);
    });
</script>
<?php $_SESSION['isDarkProfile'] = 0; ?>
<?php mysqli_close($conn); ?>