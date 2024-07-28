<?php 
include('db_connect.php');
if(!isset($_SESSION['login_id']))
header('location:login.php');
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM files where id=".$_GET['id']);
	if($qry->num_rows > 0){
		foreach($qry->fetch_array() as $k => $v){
			$meta[$k] = $v;
		}
	}
}
?>

<div class="container-fluid">
    <form action="" id="manage-files" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
        <input type="hidden" name="folder_id" value="<?php echo isset($_GET['fid']) ? htmlspecialchars($_GET['fid']) : ''; ?>">

        <?php if (!isset($_GET['id']) || empty($_GET['id'])): ?>
            <link rel="icon" href="applicant/assets/img/mcc1.png" type="image/x-icon" />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="upload" id="upload" onchange="displayname(this, $(this))">
                    <label class="custom-file-label" for="upload">Choose file</label>
                </div>
            </div>
            
        <?php else: ?>
            
            <div class="form-group">
                <label for="uploaded-file" class="control-label">Uploaded File</label>
                <div>
                    <a href="assets/uploads/<?php echo htmlspecialchars($meta['file_path']); ?>" download><?php echo htmlspecialchars($meta['name'] . '.' . $meta['file_type']); ?></a>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($meta['file_number'])): ?>
            <div class="form-group">
                <label for="file_number" class="control-label">File Number</label>
                <input type="text" name="file_number" id="file_number" class="form-control" value="<?php echo htmlspecialchars($meta['file_number']); ?>" readonly>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="fullname" class="control-label">Full Name</label>
            <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo isset($meta['fullname']) ? htmlspecialchars($meta['fullname']) : ''; ?>">
        </div>

        <!-- Description and Public Checkbox -->
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?php echo isset($meta['description']) ? htmlspecialchars($meta['description']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="is_public" class="control-label">
                <input type="checkbox" name="is_public" id="is_public" <?php echo isset($meta['is_public']) && $meta['is_public'] == 1 ? 'checked' : ''; ?>>
                <i> Share to All Users</i>
            </label>
        </div>

        <div class="form-group" id="msg"></div>
    
    </form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-files').submit(function(e){
			e.preventDefault()
			start_load();
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_files',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(typeof resp != undefined){
					resp = JSON.parse(resp);
					if(resp.status == 1){
						alert_toast("New File successfully added.",'success')
						setTimeout(function(){
							location.reload()
						},1500)
					}else{
						$('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
						end_load()
					}
				}
			}
		})
		})
	})
	function displayname(input,_this) {
			    if (input.files && input.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function (e) {
            			_this.siblings('label').html(input.files[0]['name'])
			            
			        }

			        reader.readAsDataURL(input.files[0]);
			    }
			}
</script>
