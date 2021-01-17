<?php needAdmin($conn); 
    $probName = "";$probCodename = "";$probScore = "";$probRate = "";$probTime = "";$probMemory = "";$probScript = ""; $id = -1;
    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];
        if ($stmt = $conn -> prepare("SELECT * FROM `problem` WHERE id = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                while ($row = $result->fetch_assoc()) {
                    $probName = $row['name']; $probCodename = $row['codename']; $probRate = $row['rating']; $probMemory = $row['memory']; $probTime = $row['time']; $probScore = $row['score']; $probScript = $row['script'];
                }
                $stmt->free_result();
                $stmt->close();  
            } else {
                header("Location: ../problem/");
            }
        } else {
            header("Location: ../problem/");
        }
    }
    $probDoc = "static/elements/demo.pdf";
    if (isset($probCodename) && !empty($probCodename)) {
        $probDoc = "file/task/$id/$probCodename.pdf";
    }

?>
<div class="container" style="padding-top: 88px;">
    <div class="container mb-3" id="container">
        <form method="post" action="../pages/problem_save.php<?php if (isset($_GET['id'])) echo '?id=' . $_GET['id']; ?>" enctype="multipart/form-data">
            <div class="font-weight-bold text-coe">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="md-form">
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $probName; ?>" required/>
                            <label class="form-label" for="name">Problem Name</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="md-form">
                            <input type="text" id="codename" name="codename" class="form-control" value="<?php echo $probCodename; ?>" required />
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
                    <input type="hidden" name="probDoc" id="probDoc" value="<?php echo $probDoc; ?>"/></input>
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
                        src="../static/interface/js/pdf.js/web/viewer.html?file=../../../../../<?php echo $probDoc?>"
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
                                <script>
                                    $('#rating option[value=<?php echo $probRate; ?>]').attr('selected', 'selected');
                                </script>
                            </div>
                            <div class="md-form">
                                <input type="text" id="score" name="score" class="form-control" value="<?php echo $probScore; ?>" required  />
                                <label class="form-label" for="score">Score</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="time" name="time" class="form-control" value="<?php echo $probTime; ?>" required  />
                                <label class="form-label" for="time">Time (Millisecond)</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="memory" name="memory" class="form-control" value="<?php echo $probMemory; ?>" required />
                                <label class="form-label" for="memory">Memory (Megabyte)</label>
                            </div>
                            <div class="md-form">
                                <input type="text" id="script" name="script" class="form-control" value="<?php echo $probScript; ?>" disabled/>
                                <label class="form-label" for="script">Custom Judgement Script [DISABLED]</label>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="font-weight-bold text-coe">Testcase<small class="text-muted font-weight-light"> Accept only .zip</small></h5>
                            <?php if (isset($_GET['id'])) {
                                $id = (int) $_GET['id'];
                                $path = "../file/testcase/$id/";                                
                                $count = 0;
                                $files = glob($path . "*.{in,sol}", GLOB_BRACE);
                                if ($files) {
                                    echo "<ul>";
                                    foreach($files as $f) {
                                        $filename = str_replace($path, "", $f);
                                        echo "<li><a href='$f'>".$filename."</a></li>";
                                    }
                                    echo "</ul>";
                                }
                            } ?>
                            <input type="file" class="mb-2" accept=".zip" name="testcase" id="testcase"/>
                            <input type="hidden" name="testcaseFile" id="testcaseFile" value="" />
                            <small class="text-danger">*การเปลี่ยนแปลงไฟล์จะเป็นการแทนที่ด้วยไฟล์ใหม่ทั้งหมด</small>
                        </div>
                    </div>
                    <button class="btn btn-coe btn-block" type="submit" name="problem" value="<?php if (isset($_GET['id'])) echo "edit"; else echo "create"; ?>">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>