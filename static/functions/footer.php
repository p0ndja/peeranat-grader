<footer id="footer" class="footer">
    <div class="container-fluid">
        <hr>
        <div class="text-center">Grader.ga - Made with <b style="color: salmon; ">Meow🐾</b> by <a href="https://www.facebook.com/p0ndja/" class="font-weight-bold">PondJaᵀᴴ</a> & <a href="https://www.facebook.com/Neptune.dreemurr" class="font-weight-bold">Nepumi</a></div>
        <br>
    </div>
</footer>
<script type="text/javascript">
    // Tooltips Initialization
    $(document).ready(function () {
        $('.mdb-select').materialSelect();
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn-floating').unbind('click');
        $('.fixed-action-btn').unbind('click');
    });

    if ($(document.body).height() <= $(window).height()) {
            $('#footer').attr('style', 'position: fixed!important; bottom: 0px;');
        }

        $(window).on('resize', function() {
            if ($(document.body).height() < $(window).height()) {
                $('#footer').attr('style', 'position: fixed!important; bottom: 0px;');
            }
        });

    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
    });

    $('.carouselCourse').on('slide.bs.carousel', function(e) {
        $('#pNormalCollapse').collapse('hide');
        $('#pJEMSCollapse').collapse('hide');
        $('#sNormalCollapse').collapse('hide');
        $('#sSEMSCollapse').collapse('hide');
        $('#sSCiUSCollapse').collapse('hide');
    });

    $('.carouselsmoothanimated').on('slide.bs.carousel', function(e) {
        $(this).find('.carousel-inner').animate({
            height: $(e.relatedTarget).height()
        }, 500);
    });
</script>

<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v7.0&appId=2529205720433288&autoLogAppEvents=1" nonce="2UGIjGvo"></script>

<?php $_SESSION['isDarkProfile'] = 0; ?>
<?php mysqli_close($conn); ?>