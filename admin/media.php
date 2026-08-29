<?php
session_start(); require '../config.php'; require_admin();
$notice='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf(); $action=$_POST['action']??'';
 if($action==='delete'){ $id=(int)$_POST['id']; $q=db()->prepare("SELECT file_path,thumbnail_path FROM media WHERE id=?");$q->execute([$id]);$m=$q->fetch();if($m){foreach([$m['file_path'],$m['thumbnail_path']] as $p){if($p && is_file('../'.$p))@unlink('../'.$p);}db()->prepare("DELETE FROM media WHERE id=?")->execute([$id]);}$notice='Media deleted.';}
 if($action==='toggle'){ $id=(int)$_POST['id'];db()->prepare("UPDATE media SET published=1-published WHERE id=?")->execute([$id]);$notice='Publish status updated.';}
 if($action==='upload'){
   $type=$_POST['type']??'';$title=trim($_POST['title']??'');$desc=trim($_POST['description']??'');$cat=trim($_POST['category']??'');
   if(!in_array($type,['gallery','video','audio'],true)||$title===''){$notice='Choose a media type and title.';}else{
     $field='media_file';$f=$_FILES[$field]??null;
     if(!$f||$f['error']!==UPLOAD_ERR_OK){$notice='Please choose a file.';}else{
       $max=$type==='video'?500*1024*1024:50*1024*1024;
       $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));
       $allowed=$type==='gallery'?['jpg','jpeg','png','webp']:($type==='audio'?['mp3','wav','m4a','ogg']:['mp4','webm','mov','m4v']);
       if($f['size']>$max||!in_array($ext,$allowed,true)){$notice='File type or size is not allowed.';}else{
         $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
         $safe=['jpg','jpeg','png','webp','mp3','wav','m4a','ogg','mp4','webm','mov','m4v'];
         if(!in_array($ext,$safe,true)){$notice='Invalid file.';}else{
           $dir='../uploads/'.$type.'/';$name=bin2hex(random_bytes(16)).'.'.$ext;$path=$dir.$name;
           if(move_uploaded_file($f['tmp_name'],$path)){ $webPath='uploads/'.$type.'/'.$name;db()->prepare("INSERT INTO media(type,title,description,category,file_path) VALUES(?,?,?,?,?)")->execute([$type,$title,$desc,$cat,$webPath]);$notice='Media uploaded and published successfully.';}else $notice='Upload failed.';
         }
       }
     }
   }
 }
}
$items=db()->query("SELECT * FROM media ORDER BY created_at DESC")->fetchAll();
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Media Manager</title><link rel="stylesheet" href="../assets/css/style.css"></head><body class="admin-body"><header class="admin-head"><div><img src="../assets/images/school-logo.png"><strong>ME’RAJ ADMIN PORTAL</strong></div><nav><a href="dashboard.php">Dashboard</a><a href="applications.php">Applications</a><a href="media.php">Media</a><a href="logout.php">Logout</a></nav></header><main class="admin-main"><div class="container"><h1>Media Manager</h1><p class="notice"><?=e($notice)?></p><form class="card upload-card" method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="upload"><div class="form-grid"><label>Media Type<select name="type" required><option value="gallery">Gallery Photo</option><option value="video">Video</option><option value="audio">Audio</option></select></label><label>Title<input name="title" required></label><label>Category<input name="category" placeholder="e.g. Speech & Prize Giving Day"></label><label>File<input type="file" name="media_file" required></label><label class="wide">Description<textarea name="description"></textarea></label></div><button class="btn">Upload & Publish</button></form><div class="card table-card"><div class="table-wrap"><table><thead><tr><th>Type</th><th>Title</th><th>Category</th><th>Published</th><th>Date</th><th>Actions</th></tr></thead><tbody><?php foreach($items as $m): ?><tr><td><?=e(ucfirst($m['type']))?></td><td><?=e($m['title'])?></td><td><?=e($m['category'])?></td><td><?=((int)$m['published'])?'Yes':'No'?></td><td><?=e($m['created_at'])?></td><td><form class="inline" method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="id" value="<?=$m['id']?>"><button name="action" value="toggle" class="btn btn-small">Publish/Hide</button><button name="action" value="delete" class="btn btn-small danger" onclick="return confirm('Delete this media?')">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div></main></body></html>