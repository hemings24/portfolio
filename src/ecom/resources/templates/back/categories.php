<?php $category_valid = add_category(); ?>

<h1 class="page-header">Product Categories</h1>
<?php if($category_valid == 0){display_message();} ?>
<div class="col-md-4 cat-form-fix">
   <form method="post" enctype="multipart/form-data">
      <div class="form-group">
         <label for="cat-title">Title</label>
         <input name="category_title" type="text" value="<?php echo $_SESSION['cat_category_title'] ?>" class="form-control">
      </div>
      <div class="form-group">
         <label for="cat-title">Description</label>
         <input name="category_description" type="text" value="<?php echo $_SESSION['cat_category_description'] ?>" class="form-control">
      </div>
      <div class="form-group">
         <label for="cat-title">Image</label>
         <input type="file" name="file" id="file">
         <?php
         $spacer = "margin-top:20px;margin-bottom:20px;";
         if(!isset($_SESSION['cat_category_image']) || empty($_SESSION['cat_category_image'])){
            $spacer = "margin-top:0px;margin-bottom:0px;";
         }
         ?>
         <img style="<?php echo $spacer ?>" width="200" src="../../resources/<?php echo $_SESSION['cat_category_image'] ?>" alt="">
      </div>
      <div class="form-group">
         <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
      </div>      
   </form>
</div>

<div class="col-md-8">
   <table class="table table-hover table-striped">
      <thead><tr>
         <th>Title</th>
         <th>Description</th>
      </tr></thead>
      <tbody>
         <?php show_categories_in_admin(); ?>
      </tbody>
   </table>
</div>