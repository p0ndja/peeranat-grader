<?php needAdmin($conn); ?>
<div class="container" style="padding-top: 88px;">
    <div class="container mb-3" id="container">
        <form method="post" action="../pages/problem_save.php" enctype="multipart/form-data">
            <div class="font-weight-bold text-coe">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="md-form">
                            <input type="text" id="name" name="name" class="form-control" required />
                            <label class="form-label" for="name">Problem Name</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="md-form">
                            <input type="text" id="codename" name="codename" class="form-control" required />
                            <label class="form-label" for="codename">Codename</label>
                        </div>
                    </div>
                </div>
            </div>
            <p>By PondJaᵀᴴ</p>
            <hr>
            <div class="row">
                <div class="col-12 col-md-8">
                    <input type="file" accept=".pdf" class="mb-1" name="pdfPreview" id="pdfPreview">
                    <input type="hidden" name="probDoc" id="probDoc" value=""/></input>
                    <script>
                    $("#pdfPreview").on('change', function(){
                        var fd = new FormData();
                        var files = $('#pdfPreview')[0].files;
                        if(files.length > 0 ){
                            fd.append('file',files[0]);
                            $.ajax({
                                url: '../pages/upload.php',
                                type: 'post',
                                data: fd,
                                contentType: false,
                                processData: false,
                                success: function(response){
                                    if(response != 0){
                                        $("#pdfViewer").attr("src",response);
                                        $("#probDoc").val(response); 
                                    }else{
                                        alert('file not uploaded');
                                    }
                                },
                            });
                        }
                    });
                    </script>
                    <iframe
                        src="../static/interface/js/pdf.js/web/viewer.html?file=../../../../../static/elements/demo.pdf"
                        width="100%" height="600" class="z-depth-1" id="pdfViewer" name="pdfViewer"></iframe>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-coe">Config</h5>
                            <div class="md-form">
                            <label for="rating">Rating</label>
                                <select class="mdb-select md-form colorful-select dropdown-primary" id="rating" name="rating" required>
                                    <option value="0">Peaceful</option>
                                    <option value="1">Easy</option>
                                    <option value="2">Normal</option>
                                    <option value="3">Hard</option>
                                </select>
                            </div>
                            <div class="md-form">
                                <input type="text" id="score" name="score" class="form-control" required  />
                                <label class="form-label" for="score">Score</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="time" name="time" class="form-control" required  />
                                <label class="form-label" for="time">Time</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="memory" name="memory" class="form-control" required />
                                <label class="form-label" for="memory">Memory</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="script" name="script" class="form-control" />
                                <label class="form-label" for="script">Custom Judgement Script</label>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-coe">Testcase<small class="text-muted font-weight-light"> Accept only .zip</small></h5>
                            <input type="file" class="mb-2" accept=".zip" name="testcase" id="testcase"/>
                            <input type="hidden" name="testcaseFile" id="testcaseFile" value="" />
                        </div>
                    </div>
                    <button class="btn btn-coe btn-block" type="submit" name="problem" value="create">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>