<form action="./item" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label>Item Name</label>
        <input type="text" class="form-control" id="item-name" name="item_name" placeholder="Item name">
    </div>
    <div class="form-group">
        <label>Item Description</label>
        <textarea placeholder="Item description" class="form-control" name="item_description"></textarea>
    </div>
    <div class="form-group">
        <label>Item Price</label>
        <input type="number" class="form-control" name="item_price">
    </div>
    <div class="form-group">
        <label>Item Image</label>
        <input type="file" class="form-control" name="item_image">
    </div>
    <input type="submit" value="Add" class="btn btn-primary">
</form>