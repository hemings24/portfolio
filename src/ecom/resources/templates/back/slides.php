<?php $slide_valid = add_slide(); ?>

<h1 class="page-header">Slides</h1>
<?php if($slide_valid == 0){display_message();} ?>
<div class="row">
   <div class="col-xs-4 col-md-4 col-lg-3 slide-form-container-outer">
      <div class="slide-form-container-inner">
         <div class="slide-form-container-inner-width">
            <form method="post" enctype="multipart/form-data">
               <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="slide_title" class="form-control" value="<?php echo $_SESSION['slid_slide_title'] ?>">
               </div>
               <div class="form-group">
                  <label for="title">Image</label>
                  <input type="file" name="file" id="file">
               </div>         
               <div class="form-group">
                  <input type="submit" name="submit" value="Add Slide" class="btn btn-primary">
               </div>
            </form>
         </div>
         <div class="slide-admin slide-admin-fix">
            <img src="../../resources/<?php echo $_SESSION['slid_slide_image'] ?>" alt="" class="slide-img-admin">
         </div>
      </div>
   </div>
</div>
<?php get_slide_thumbnails_admin(); ?>