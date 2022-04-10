<?php $product_valid = edit_product(); ?>

<div class="col-md-12">
   <div class="row">
      <h1 class="page-header">Edit Product</h1>
      <?php if($product_valid == 0){display_message();} ?>
   </div>
   <form action="" method="post" enctype="multipart/form-data">
      <div class="col-md-8">
         <div class="form-group">
            <label for="product-title">Title</label>
            <input type="text" name="product_title" class="form-control" value="<?php echo $_SESSION['prod_product_title'] ?>" required>
         </div>

         <div class="form-group">
            <label for="product-title">Description</label>
            <textarea name="product_description" id="" cols="30" rows="10" class="form-control"><?php echo $_SESSION['prod_product_description'] ?></textarea>
         </div>

         <div class="form-group row">
            <div class="col-xs-3">
               <label for="product-price">Price</label>
               <input type="number" name="product_price" class="form-control" size="60" min="0" step=".01" value="<?php echo $_SESSION['prod_product_price'] ?>" required>
            </div>
         </div>

         <div class="form-group">
            <label for="product-title">Short Description</label>
            <textarea name="product_short_desc" id="" cols="30" rows="3" class="form-control"><?php echo $_SESSION['prod_product_short_desc'] ?></textarea>
         </div>
      </div>

      <!-- SIDEBAR-->
      <aside id="admin_sidebar" class="col-md-4">

         <!-- Product Categories-->
         <div class="form-group">
            <label for="product-title">Category</label>
            <select name="product_cat_id" id="" class="form-control">
               <option value="<?php echo $_SESSION['prod_product_cat_id'] ?>">
                  <?php echo show_product_category_title($_SESSION['prod_product_cat_id']); ?>
               </option>
               <?php show_categories_add_product_page(); ?>
            </select>
         </div>

         <!-- Product Brands-->
         <div class="form-group">
            <label for="product-title">Quantity</label>
            <input type="number" name="product_quantity" class="form-control" value="<?php echo $_SESSION['prod_product_quantity'] ?>" required>
         </div>

         <!-- Product Image -->
         <div class="form-group">
            <label for="product-title">Image</label>
            <input type="file" name="file">
            <br><img width="200" src="../../resources/<?php echo $_SESSION['prod_product_image'] ?>" alt="">
         </div>

         <div class="form-group">
            <input type="submit" name="submit" value="Update Product" class="btn btn-primary btn-lg">
         </div>

      </aside>
   </form>
</div>