<!-- Announcement Modal -->
<div class="modal animated jackInTheBox fadeOut" id="announcementPopup" name="announcementPopup" tabindex="-1"
    role="dialog" aria-labelledby="announcementTitle" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="annoucementTitle">ข่าวประชาสัมพันธ์</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="https://repository-images.githubusercontent.com/216790969/da52a000-7792-11ea-997b-7503371435f0"
                    class="img-fluid w-100 d-flex justify-content-center mb-3 z-depth-2">
                <div class="modal-text">
                    <p class="text-center">ทางผู้พัฒนาขอความร่วมมือจากผู้เข้าชมเว็บไซต์ทุก ๆ ท่าน
                        ร่วมตอบแบบสอบถามความพึงพอใจในการใช้งานเว็บไซต์ <a
                            href="https://smd.pondja.com">smd.pondja.com</a> / <a
                            href="https://smd.p0nd.ga">smd.p0nd.ga</a></p>
                    <a href="https://forms.gle/HfxaWmjVGKjARUR18" target="_blank" class="text-center text-smd">
                        <h1 class="animated infinite pulse">ตอบแบบสอบถาม</h1>
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-md btn-warning" data-dismiss="modal">ปิดหน้าต่าง</a>
            </div>
        </div>
    </div>
</div>
<!-- Announcement Modal -->
<script>
    $('.launchModal').on('click', function () {
        $('#modalTitle').html('Loading...');
        $('#modalBody').html('<div class="d-flex justify-content-center"><img class="img-fluid" align="center" src="https://cdn.dribbble.com/users/1284666/screenshots/6321168/__3.gif"></div>');
        $('#modalBodyCode').html("<div></div>");
        var title = $(this).data('title');
        var subID = $(this).data('id');
        var userID = $(this).data('uid');
            $.ajax({
                type: 'GET',
                url: '../pages/submission_gen.php',
                data: {
                    'id': subID
                },
                success: function (data) {
                    $('#modalBody').html(data);
                }
            }).then(function() {
                $.ajax({
                    type: 'GET',
                    url: '../pages/submission_code.php?target=' + subID,
                    data: {
                        'id': subID
                    },
                    success: function (data) {
                        $('#modalBodyCode').html('<pre><code>' + data + '</code></pre>');
                        $('pre > code').each(function() {
                            hljs.highlightBlock(this);
                        });
                    }
                });
            }).then(function() {
                $('#modalTitle').html(title);
            });
        });
</script>
<!-- Popup Modal -->
<div class="modal animated fade" id="modalPopup" name="modalPopup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-notify modal-coekku modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyBody">
                <div id="modalBody"></div>
                <div id="<?php if (isLogin() && isAdmin($_SESSION['id'], $conn)) echo 'modalBodyCode'; else echo 'CapooCat'; ?>"></div>
            </div>
        </div>
    </div>
</div>
<!-- Popup Modal -->
<?php 
    if (isset($_SESSION['swal_error']) && isset($_SESSION['swal_error_msg'])) { 
        errorSwal($_SESSION['swal_error'],$_SESSION['swal_error_msg']);
        $_SESSION['swal_error'] = null;
        $_SESSION['swal_error_msg'] = null;
    }
?>
<?php 
    if (isset($_SESSION['swal_warning']) && isset($_SESSION['swal_warning_msg'])) { 
        warningSwal($_SESSION['swal_warning'],$_SESSION['swal_warning_msg']);
        $_SESSION['swal_warning'] = null;
        $_SESSION['swal_warning_msg'] = null;
    }
?>
<?php 
    if (isset($_SESSION['swal_success'])) { 
        successSwal($_SESSION['swal_success'],$_SESSION['swal_success_msg']);
        $_SESSION['swal_success'] = null;
        $_SESSION['swal_success_msg'] = null;
    }
?>
<script>
    $("#logoutBtn").click(function () {
        swal({
            title: "ออกจากระบบ ?",
            text: "คุณต้องการออกจากระบบหรือไม่?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                window.location = "../logout/";
            }
        });
    });
</script>